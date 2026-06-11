#!/usr/bin/env bash
#
# Repeatable first-time install of campaign_tooling on a fresh Linux server.
# Run as root (or via sudo). Idempotent: safe to re-run — it pulls the latest
# code, reinstalls deps, and refreshes the systemd/nginx config.
#
# It does NOT write the .env (secrets) or run certbot — those are deliberate
# manual steps. The script prints them at the end.
#
# Usage:
#   sudo DOMAIN=campaign.example.com \
#        REPO_URL=https://github.com/<you>/lexington_alarm.git \
#        bash install.sh
#
# Optional vars: BRANCH (default main), APP_USER (default campaign),
#                BASE_DIR (default /opt/campaign-tooling).

set -euo pipefail

DOMAIN="${DOMAIN:?Set DOMAIN, e.g. DOMAIN=campaign.example.com}"
REPO_URL="${REPO_URL:?Set REPO_URL to the git clone URL of the lexington_alarm repo}"
BRANCH="${BRANCH:-main}"
APP_USER="${APP_USER:-campaign}"
BASE_DIR="${BASE_DIR:-/opt/campaign-tooling}"

REPO_DIR="$BASE_DIR/lexington_alarm"
APP_DIR="$REPO_DIR/campaign_tooling"
VENV="$APP_DIR/.venv"

if [[ $EUID -ne 0 ]]; then
  echo "Run as root (sudo)." >&2
  exit 1
fi

echo "==> Installing system packages"
if command -v apt-get >/dev/null 2>&1; then
  export DEBIAN_FRONTEND=noninteractive
  apt-get update -y
  apt-get install -y python3 python3-venv python3-pip git nginx
elif command -v dnf >/dev/null 2>&1; then
  dnf install -y python3 python3-pip git nginx
else
  echo "Unsupported package manager (need apt-get or dnf)." >&2
  exit 1
fi

echo "==> Creating system user '$APP_USER' (if missing)"
if ! id "$APP_USER" >/dev/null 2>&1; then
  useradd --system --create-home --shell /usr/sbin/nologin "$APP_USER" 2>/dev/null \
    || useradd --system --create-home --shell /sbin/nologin "$APP_USER"
fi

echo "==> Fetching code into $REPO_DIR"
mkdir -p "$BASE_DIR"
chown "$APP_USER:$APP_USER" "$BASE_DIR"
if [[ -d "$REPO_DIR/.git" ]]; then
  sudo -u "$APP_USER" git -C "$REPO_DIR" fetch --all --prune
  sudo -u "$APP_USER" git -C "$REPO_DIR" checkout "$BRANCH"
  sudo -u "$APP_USER" git -C "$REPO_DIR" pull --ff-only origin "$BRANCH"
else
  sudo -u "$APP_USER" git clone --branch "$BRANCH" "$REPO_URL" "$REPO_DIR"
fi

echo "==> Creating virtualenv and installing dependencies"
if [[ ! -d "$VENV" ]]; then
  sudo -u "$APP_USER" python3 -m venv "$VENV"
fi
sudo -u "$APP_USER" "$VENV/bin/pip" install --upgrade pip
sudo -u "$APP_USER" "$VENV/bin/pip" install -r "$APP_DIR/requirements.txt"

echo "==> Installing systemd unit"
install -m 644 "$APP_DIR/deploy/campaign-tooling.service" \
  /etc/systemd/system/campaign-tooling.service
systemctl daemon-reload
systemctl enable campaign-tooling

echo "==> Installing nginx site for $DOMAIN"
NGINX_TMP="$(mktemp)"
sed "s/REPLACE_WITH_YOUR_DOMAIN/$DOMAIN/g" \
  "$APP_DIR/deploy/nginx-campaign-tooling.conf" > "$NGINX_TMP"
if [[ -d /etc/nginx/sites-available ]]; then
  install -m 644 "$NGINX_TMP" /etc/nginx/sites-available/campaign-tooling
  ln -sf /etc/nginx/sites-available/campaign-tooling \
    /etc/nginx/sites-enabled/campaign-tooling
  rm -f /etc/nginx/sites-enabled/default
else
  install -m 644 "$NGINX_TMP" /etc/nginx/conf.d/campaign-tooling.conf
fi
rm -f "$NGINX_TMP"
nginx -t
systemctl enable nginx
systemctl reload nginx || systemctl start nginx

cat <<EOF

==> System install complete. Remaining MANUAL steps:

  1. Create the production .env (holds your two secrets):
       sudo -u $APP_USER cp $APP_DIR/deploy/.env.production.example $APP_DIR/.env
       sudo -u $APP_USER nano $APP_DIR/.env       # fill SECRET_KEY, DATABASE_URL, ADMIN_TOKEN
       sudo chmod 600 $APP_DIR/.env

  2. Start the app:
       sudo systemctl start campaign-tooling
       systemctl status campaign-tooling --no-pager
       curl -s http://127.0.0.1:8000/healthz && echo

     (No seeding step. This deploy reuses an existing Supabase database that
     already holds production data. Booting the app only runs db.create_all(),
     which creates missing tables and never inserts or deletes rows. Do NOT run
     import-seed or reset-db against this DB — see "Seeding" in deploy/README.md
     for the fresh-database-only procedure.)

  3. Get HTTPS (point $DOMAIN's DNS A record at this server FIRST):
       # Debian/Ubuntu:  sudo apt-get install -y certbot python3-certbot-nginx
       # RHEL family:    sudo dnf install -y certbot python3-certbot-nginx
       sudo certbot --nginx -d $DOMAIN --redirect

  4. Visit https://$DOMAIN — confirm the campaign list and /admin/login work.

EOF
