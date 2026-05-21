from flask import Flask, render_template

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

    @app.errorhandler(404)
    def _not_found(_err):
        return render_template("not_found.html"), 404

    # Health check for the platform (Render). Lives outside the public
    # blueprint so it bypasses any route-level locking; returns a plain
    # 200 so the probe is cheap and doesn't touch the DB.
    @app.route("/healthz")
    def _healthz():
        return ("ok", 200, {"Content-Type": "text/plain"})

    with app.app_context():
        from . import models  # noqa: F401  ensure models are imported
        db.create_all()

    return app
