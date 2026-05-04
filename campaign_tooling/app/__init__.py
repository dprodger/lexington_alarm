from flask import Flask

from config import Config
from .extensions import db


def create_app(config_class: type = Config) -> Flask:
    app = Flask(__name__, instance_relative_config=False)
    app.config.from_object(config_class)

    db.init_app(app)

    from .routes_public import bp as public_bp
    from .routes_admin import bp as admin_bp
    from . import cli

    app.register_blueprint(public_bp)
    app.register_blueprint(admin_bp, url_prefix="/admin")
    cli.register(app)

    with app.app_context():
        from . import models  # noqa: F401  ensure models are imported
        db.create_all()

    return app
