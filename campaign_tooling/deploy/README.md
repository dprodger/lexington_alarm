# Deploying campaign_tooling to your own Linux server

This is the self-hosted equivalent of the Render Blueprint (`../render.yaml`):
a Flask app served by **gunicorn**, managed by **systemd**, behind an **nginx**
reverse proxy with **Let's Encrypt** TLS, talking to **Supabase Postgres**.

```
Internet ──HTTPS──▶ nginx (:443, TLS via certbot)
                      └─proxy─▶ gunicorn (127.0.0.1:8000, systemd unit)
                                  └─▶ Supabase Postgres (campaign_tooling schema)
```

Files in this directory:

| File | Purpose |
|------|---------|
| `install.sh` | One-shot, re-runnable first install (packages, user, clone, venv, systemd, nginx). |
| `update.sh` | Redeploy after a code change: pull, reinstall deps, restart. |
| `campaign-tooling.service` | systemd unit for the gunicorn process. |
| `nginx-campaign-tooling.conf` | nginx reverse-proxy server block. |
| `.env.production.example` | Template for the production secrets file. |

## Prerequisites

- SSH access to the server with `sudo`.
- A domain name with a DNS **A record pointing at the server's IP** (needed before
  certbot can issue a certificate). Set this up early — DNS can take a while.
- Your Supabase `DATABASE_URL` (Session pooler string, port 5432) and a strong
  `ADMIN_TOKEN`. If you're reusing the same Supabase DB as Render, the data and
  the `campaign_tooling` schema already exist.

## Fast path (scripted)

```bash
# On the server:
ssh you@your-server

# Detect the distro (the script handles apt and dnf; this is just a sanity check):
cat /etc/os-release | grep ^PRETTY_NAME

# Pull just the installer (or clone the whole repo first — your call):
curl -fsSL https://raw.githubusercontent.com/<you>/lexington_alarm/main/campaign_tooling/deploy/install.sh -o install.sh

sudo DOMAIN=campaign.example.com \
     REPO_URL=https://github.com/<you>/lexington_alarm.git \
     bash install.sh
```

The script stops short of writing secrets and issuing TLS, then prints the exact
remaining commands (create `.env`, start the service, run certbot). It does **not**
seed — this deploy reuses your existing production database.

## Manual path (understand each step)

```bash
# 1. Packages  (Debian/Ubuntu shown; RHEL: swap apt-get for dnf, drop python3-venv)
sudo apt-get update
sudo apt-get install -y python3 python3-venv python3-pip git nginx

# 2. Dedicated unprivileged user
sudo useradd --system --create-home --shell /usr/sbin/nologin campaign

# 3. Clone the repo (the app is the campaign_tooling/ subdirectory)
sudo mkdir -p /opt/campaign-tooling && sudo chown campaign:campaign /opt/campaign-tooling
sudo -u campaign git clone https://github.com/<you>/lexington_alarm.git \
     /opt/campaign-tooling/lexington_alarm
cd /opt/campaign-tooling/lexington_alarm/campaign_tooling

# 4. Virtualenv + deps
sudo -u campaign python3 -m venv .venv
sudo -u campaign .venv/bin/pip install --upgrade pip
sudo -u campaign .venv/bin/pip install -r requirements.txt

# 5. Production secrets
sudo -u campaign cp deploy/.env.production.example .env
sudo -u campaign nano .env          # SECRET_KEY, DATABASE_URL, ADMIN_TOKEN
sudo chmod 600 .env
#   SECRET_KEY:  python3 -c "import secrets; print(secrets.token_hex(32))"
#   ADMIN_TOKEN: python3 -c "import secrets; print(secrets.token_urlsafe(24))"

# 6. systemd service
sudo install -m 644 deploy/campaign-tooling.service \
     /etc/systemd/system/campaign-tooling.service
sudo systemctl daemon-reload
sudo systemctl enable --now campaign-tooling
curl -s http://127.0.0.1:8000/healthz && echo     # expect: ok

# 7. nginx reverse proxy
sudo sed 's/REPLACE_WITH_YOUR_DOMAIN/campaign.example.com/g' \
     deploy/nginx-campaign-tooling.conf \
     | sudo tee /etc/nginx/sites-available/campaign-tooling >/dev/null
sudo ln -sf /etc/nginx/sites-available/campaign-tooling /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t && sudo systemctl reload nginx

# 8. TLS (DNS A record must already point here)
sudo apt-get install -y certbot python3-certbot-nginx
sudo certbot --nginx -d campaign.example.com --redirect
```

## Seeding data — FRESH DATABASE ONLY

> ⚠️ **Do not run this against a production database that already has data.**
> This deployment reuses an existing Supabase DB, so **you skip this entire
> section.** Booting the app runs `db.create_all()`, which only creates missing
> tables (`checkfirst=True`) and never inserts or deletes rows — it cannot seed
> and cannot wipe. The commands below are destructive/additive writes meant for a
> brand-new, empty database only. Never run `import-seed` or `reset-db` against
> your production DB.

`db.create_all()` does not create the *schema* itself. On a genuinely new Supabase
project, run this once in the Supabase SQL editor first:

```sql
CREATE SCHEMA IF NOT EXISTS campaign_tooling;
```

Then load the starter campaign (the command is `import-seed`, not the `seed`
command the top-level README mentions — that one no longer exists):

```bash
cd /opt/campaign-tooling/lexington_alarm/campaign_tooling
sudo -u campaign .venv/bin/flask --app wsgi import-seed seed/ct-pension.json
# --replace overwrites an existing campaign with the same slug — destructive.
```

## Redeploying a change

```bash
# laptop:
git push origin main
# server:
sudo bash /opt/campaign-tooling/lexington_alarm/campaign_tooling/deploy/update.sh
```

## Operating it

```bash
sudo systemctl status campaign-tooling     # is it up?
sudo journalctl -u campaign-tooling -f     # live app logs (gunicorn stdout/stderr)
sudo systemctl restart campaign-tooling    # after an .env change
sudo tail -f /var/log/nginx/error.log      # proxy-level problems
```

## Notes & gotchas

- **One worker on purpose.** The unit pins `--workers 1` because `db.create_all()`
  in the app factory isn't race-safe on a fresh schema. Don't raise it until table
  creation moves to a migration release-step (same caveat as `render.yaml`).
- **`.env` is read from the app directory** by python-dotenv (in `config.py`), the
  same as local dev — that's why `WorkingDirectory` in the unit points there. After
  editing `.env`, restart the service for changes to take effect.
- **Firewall:** if the server runs ufw/firewalld, allow 80 and 443
  (`sudo ufw allow 'Nginx Full'`). Don't expose 8000 — it's localhost-only.
- **certbot auto-renews** via its own systemd timer; no action needed. Verify with
  `sudo certbot renew --dry-run`.
- **Secrets never enter git.** `.env` lives only on the server and is chmod 600.
