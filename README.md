# VOXA Media

A Vietnamese-first WordPress Multisite for `blog.voxa.vn` and `forum.voxa.vn`. WordPress manages editorial content and shared accounts; bbPress provides the discussion workflows. The VOXA child theme is based on Twenty Twenty-One.

- Local Podman preview: [`docs/development.md`](docs/development.md)
- User roles and publishing: [`docs/accounts.md`](docs/accounts.md)
- Production deployment, tunnel routing, backup and restore: [`docs/deployment.md`](docs/deployment.md)

Production exposes no host ports. Only the Nginx router joins the existing tunnel network; MariaDB is isolated on a separate internal network, while WordPress has outbound access for core/plugin updates.
