#!/usr/bin/env bash
#
# Redeploy campaign_tooling after a code change: pull, reinstall deps, restart.
# Run as root (or via sudo). Pair with `git push` from your laptop.
#
#   sudo bash /opt/campaign-tooling/lexington_alarm/campaign_tooling/deploy/update.sh

set -euo pipefail

APP_USER="${APP_USER:-campaign}"
BASE_DIR="${BASE_DIR:-/opt/campaign-tooling}"
REPO_DIR="$BASE_DIR/lexington_alarm"
APP_DIR="$REPO_DIR/campaign_tooling"
VENV="$APP_DIR/.venv"

if [[ $EUID -ne 0 ]]; then
  echo "Run as root (sudo)." >&2
  exit 1
fi

echo "==> Pulling latest code"
sudo -u "$APP_USER" git -C "$REPO_DIR" pull --ff-only

echo "==> Syncing dependencies"
sudo -u "$APP_USER" "$VENV/bin/pip" install -r "$APP_DIR/requirements.txt"

echo "==> Restarting service"
systemctl restart campaign-tooling
sleep 2
systemctl status campaign-tooling --no-pager | head -n 5
curl -fs http://127.0.0.1:8000/healthz && echo " <- healthz OK"
