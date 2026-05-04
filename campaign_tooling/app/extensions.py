import os

from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import MetaData

# Pin tables to the campaign_tooling schema on Postgres so we don't pollute
# `public` (which the user shares with another app). SQLite has no schemas,
# so leave it None when running locally without Postgres.
_db_url = os.environ.get("DATABASE_URL", "")
_schema = "campaign_tooling" if _db_url.startswith("postgresql") else None

db = SQLAlchemy(metadata=MetaData(schema=_schema))
