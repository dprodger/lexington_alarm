import os
from datetime import timedelta

from dotenv import load_dotenv

load_dotenv()


class Config:
    SECRET_KEY = os.environ.get("SECRET_KEY", "dev-only-do-not-use-in-prod")
    SQLALCHEMY_DATABASE_URI = os.environ.get(
        "DATABASE_URL", "sqlite:///campaign_tooling.db"
    )
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    ADMIN_TOKEN = os.environ.get("ADMIN_TOKEN", "")

    # The session cookie now carries writer PII and parameter values, so keep it
    # off JavaScript, send it only same-site, and require HTTPS in production.
    # Set SESSION_COOKIE_SECURE=0 for local http development.
    SESSION_COOKIE_HTTPONLY = True
    SESSION_COOKIE_SAMESITE = "Lax"
    SESSION_COOKIE_SECURE = os.environ.get("SESSION_COOKIE_SECURE", "1") != "0"

    # A writer's session is marked permanent (see routes_public) so they can
    # come back later in a chain and still log against the same respondent.
    PERMANENT_SESSION_LIFETIME = timedelta(days=30)
