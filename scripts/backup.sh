#!/bin/sh
set -eu

CONTAINER_CLI="${CONTAINER_CLI:-podman}"
COMPOSE_MODE="${COMPOSE_MODE:-production}"
BACKUP_DIR="${BACKUP_DIR:-./backups}"
STAMP="$(date -u +%Y%m%dT%H%M%SZ)"

compose() {
    if [ "$COMPOSE_MODE" = "local" ]; then
        "$CONTAINER_CLI" compose --env-file .env.local -f compose.yaml -f compose.local.yaml "$@"
    else
        "$CONTAINER_CLI" compose "$@"
    fi
}

umask 077
mkdir -p "$BACKUP_DIR"

compose exec -T database sh -c \
    'mariadb-dump --single-transaction --routines --triggers -u"$MARIADB_USER" -p"$MARIADB_PASSWORD" "$MARIADB_DATABASE"' \
    | gzip > "$BACKUP_DIR/voxa-media-db-$STAMP.sql.gz"

compose run --rm --no-deps --entrypoint sh wp-cli \
    -c 'mkdir -p /var/www/html/wp-content/uploads /var/www/html/wp-content/plugins && tar -C /var/www/html/wp-content -czf - uploads plugins' \
    > "$BACKUP_DIR/voxa-media-content-$STAMP.tar.gz"

printf 'Created protected backups:\n%s\n%s\n' \
    "$BACKUP_DIR/voxa-media-db-$STAMP.sql.gz" \
    "$BACKUP_DIR/voxa-media-content-$STAMP.tar.gz"
