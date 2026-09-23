# Local development

The local stack runs in Podman and is isolated from the production database and Docker network. The router binds only to `127.0.0.1:8080`; WordPress and MariaDB have no host-published ports.

## First run

1. Copy `.env.local.example` to `.env.local` and change the local-only passwords.
2. Start Podman (on macOS, `podman machine start` if the VM is stopped).
3. Start the stack and initialize the multisite:

```sh
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml up -d
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml run --rm wp-cli sh /scripts/bootstrap.sh
```

Open [http://blog.voxa.localhost:8080](http://blog.voxa.localhost:8080) and [http://forum.voxa.localhost:8080](http://forum.voxa.localhost:8080). The admin URLs are `/wp-admin/` on either hostname. Local bootstrap credentials are the values in `.env.local`.

The local tunnel-facing router ports 4345 and 4346 are not mapped to the Mac. Only the loopback proxy on port 8080 is reachable from the host. If port 8080 is already in use, change the local override to another available high loopback port and open each `.localhost:<port>` URL instead. The one-time bootstrap uses the pinned official Twenty Twenty-One 2.9 and bbPress 2.6.18 packages in `.packages/` when present; otherwise WP-CLI downloads them from WordPress.org.

## Useful commands

```sh
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml ps
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml logs -f wordpress router
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml down
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml run --rm wp-cli wp --url=http://blog.voxa.localhost:8080 core version
COMPOSE_MODE=local ./scripts/backup.sh
```

`down` preserves named volumes. Do not use `down -v` unless you intentionally want to erase the local database and uploaded files. To update theme code, edit `wp-content/themes/voxa-media`; the bind-mounted files are served on the next request. Plugins and uploads live in the WordPress volume.

If you recreate the WordPress container, restart `router` afterward so Nginx resolves the new container address (`podman compose ... restart router`).

The default local admin password is only for this isolated development environment; never copy `.env.local` to production.
