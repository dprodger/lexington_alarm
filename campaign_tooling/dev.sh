#!/usr/bin/env bash
# Start the local Flask dev server for campaign_tooling.
#
# Activates ./.venv, then runs `flask --app wsgi run` on port 5050. Reads
# .env (DATABASE_URL, ADMIN_TOKEN, SECRET_KEY) automatically via
# python-dotenv. Override the port with PORT=5060 ./dev.sh; any extra
# args are forwarded to flask, e.g. `./dev.sh --debug` or `./dev.sh --no-reload`.
#
# First-time setup:
#   python3 -m venv .venv
#   source .venv/bin/activate
#   pip install -r requirements.txt
#   cp .env.example .env  # and fill it in

set -euo pipefail

cd "$(dirname "$0")"

if [[ -z "${VIRTUAL_ENV:-}" ]]; then
  if [[ -f .venv/bin/activate ]]; then
    # shellcheck disable=SC1091
    source .venv/bin/activate
  else
    echo "No .venv at $(pwd)/.venv — run the first-time setup steps in dev.sh." >&2
    exit 1
  fi
fi

PORT="${PORT:-5050}"
exec flask --app wsgi run --port "$PORT" "$@"
