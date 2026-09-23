# Production deployment

Production uses the existing Docker host and Cloudflare Tunnel. The router is the only service attached to `voxa-website-internal`; MariaDB is isolated on an internal Compose network, and WordPress has outbound access for updates. No host ports are published. The tunnel's two public-hostname origins must point to the router's container DNS name:

| Public hostname | Origin service |
| --- | --- |
| `blog.voxa.vn` | `http://voxa-media-router:4346` |
| `forum.voxa.vn` | `http://voxa-media-router:4345` |

Leave the existing `voxa.vn` tunnel route unchanged.

## One-time setup

1. Ensure the existing Docker network is present: `docker network inspect voxa-website-internal`.
2. Create `/home/mlemingcapoo/Projects/voxa-media-web/.env` from `.env.example`. Set long, unique database and WordPress admin passwords. Protect the file (`chmod 600 .env`) and do not commit or copy it into public logs.
3. Confirm the existing tunnel connector joins `voxa-website-internal` and can resolve container names there.
4. Check that Compose intends to publish no server ports: `docker compose config`; `docker compose ps` must show no host bindings.
5. Start and initialize:

```sh
docker compose pull
docker compose up -d database wordpress router
docker compose restart router
docker compose run --rm wp-cli sh /scripts/bootstrap.sh
docker compose ps
```

The bootstrap command is safe to re-run: once the network is installed it exits without changing content. It creates the initial network administrator from `.env`, maps the forum subsite, installs Twenty Twenty-One, activates the VOXA child theme, and installs bbPress only on the forum. It does not create sample posts or discussions.

## Update

Back up first. Transfer the reviewed project files to the existing project directory, preserving `.env` and volumes. Then run:

```sh
docker compose pull
docker compose up -d database wordpress router
docker compose restart router
docker compose ps
```

Restarting the router after an app recreation refreshes Nginx's resolved WordPress container address. For theme-only edits, the source files are bind-mounted read-only into the app, so a WordPress restart plus router restart is enough. Do not run `docker compose down -v` during deployment.

## Automated deployment

The `main` branch triggers `.github/workflows/deploy.yml` on the project-specific self-hosted runner. The workflow:

1. Verifies that the live directory is the expected Git checkout and that its private `.env` exists.
2. Creates the database and uploads/plugins backups with `scripts/backup.sh`.
3. Fast-forwards `/home/mlemingcapoo/Projects/voxa-media-web` to `origin/main` without cleaning ignored runtime files.
4. Pulls images, updates the database/WordPress/router services, and restarts the router.

The runner is installed under `/home/mlemingcapoo/voxa-media-actions-runner` and managed as the `mlemingcapoo` user service `voxa-media-actions-runner.service`. Keep `.env`, Docker volumes, backups, and uploads outside Git.

## Back up and restore

Run `CONTAINER_CLI=docker ./scripts/backup.sh` from the project directory. It creates a MariaDB transaction-consistent dump and a separate archive of WordPress plugins and uploads under `./backups/`, with restrictive permissions. Store copies away from the server and test restores periodically. The theme and configuration are in the project files; the private `.env` must be backed up separately in a secure secret store.

To restore a selected pair of archives, first stop writes (`docker compose stop router wordpress`) and take one more backup of the current state. Then:

```sh
# Replace the database contents. Use only a verified backup and the intended project.
docker compose exec -T database sh -c 'mariadb -uroot -p"$MARIADB_ROOT_PASSWORD" -e "DROP DATABASE IF EXISTS ${MARIADB_DATABASE}; CREATE DATABASE ${MARIADB_DATABASE};"'
gzip -dc ./backups/voxa-media-db-TIMESTAMP.sql.gz | docker compose exec -T database sh -c 'mariadb -u"$MARIADB_USER" -p"$MARIADB_PASSWORD" "$MARIADB_DATABASE"'
docker compose run --rm --no-deps --entrypoint sh wp-cli -c 'tar -C /var/www/html/wp-content -xzf -' < ./backups/voxa-media-content-TIMESTAMP.tar.gz
docker compose start wordpress router
```

Replace both `TIMESTAMP` values with matching backup names. The database reset is destructive to current Media content. Verify the domain URLs, an uploaded file, and both admin pages before considering recovery complete.

## Launch checks

- Confirm `/`, `/wp-admin/`, and `/wp-login.php` on each public domain use HTTPS and show the expected domain in canonical URLs.
- Test the blog and forum from a signed-out browser; confirm anonymous signup is unavailable.
- Create a test user: forum Participant can post immediately; an account without blog Author cannot publish; assigning Author allows publishing. Remove the test content afterward.
- Confirm each host route reaches the correct site and that `voxa.vn` still uses its pre-existing origin.
- Run `docker compose ps` and inspect the Docker host to confirm no Media port is bound publicly. The Nginx ports 4345/4346 are internal to the shared tunnel network.
- Restart services and verify database content and uploaded media persist.
