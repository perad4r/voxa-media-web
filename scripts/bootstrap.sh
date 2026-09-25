#!/bin/sh
set -eu

WP_URL_PORT="${WP_URL_PORT:-}"
URL_PORT="${WP_URL_PORT:+:$WP_URL_PORT}"
BASE_URL="${WP_SCHEME}://${WP_NETWORK_DOMAIN}${URL_PORT}"
FORUM_URL="${WP_SCHEME}://${WP_FORUM_DOMAIN}${URL_PORT}"

if wp --url="$BASE_URL" core is-installed >/dev/null 2>&1; then
    if ! wp --url="$BASE_URL" site list --field=blog_id >/dev/null 2>&1; then
        echo "WordPress is installed, but Multisite is not configured. Refusing to alter the existing database." >&2
        exit 1
    fi
else
    wp core multisite-install \
        --url="$BASE_URL" \
        --base=/ \
        --subdomains \
        --title="VOXA Media" \
        --admin_user="$WP_ADMIN_USER" \
        --admin_password="$WP_ADMIN_PASSWORD" \
        --admin_email="$WP_ADMIN_EMAIL" \
        --skip-email \
        --skip-config
fi

if ! wp --url="$BASE_URL" site list --field=domain | grep -Fxq "${WP_FORUM_DOMAIN}${URL_PORT}"; then
    if ! wp --url="$BASE_URL" site list --field=domain | grep -Fxq "forum.${WP_NETWORK_DOMAIN}${URL_PORT}"; then
        wp --url="$BASE_URL" site create \
            --slug=forum \
            --title="VOXA Forum" \
            --email="$WP_ADMIN_EMAIL"
    fi
fi

wp --url="$BASE_URL" eval-file /scripts/map-forum.php

if ! wp --url="$BASE_URL" theme is-installed twentytwentyone; then
    if [ -f /packages/twentytwentyone.2.9.zip ]; then
        wp --url="$BASE_URL" theme install /packages/twentytwentyone.2.9.zip
    else
        wp --url="$BASE_URL" theme install twentytwentyone
    fi
fi
wp --url="$BASE_URL" theme enable voxa-media --network
wp --url="$BASE_URL" theme activate voxa-media
wp --url="$FORUM_URL" theme activate voxa-media

if ! wp --url="$FORUM_URL" plugin is-installed bbpress; then
    if [ -f /packages/bbpress.2.6.18.zip ]; then
        wp --url="$FORUM_URL" plugin install /packages/bbpress.2.6.18.zip
    else
        wp --url="$FORUM_URL" plugin install bbpress
    fi
fi
wp --url="$FORUM_URL" plugin activate bbpress
wp --url="$BASE_URL" language core install vi --activate
wp --url="$FORUM_URL" language core install vi --activate
wp --url="$FORUM_URL" language plugin install bbpress vi
wp --url="$BASE_URL" option update blogname "VOXA Media"
wp --url="$BASE_URL" option update blogdescription "Góc nhìn và giải pháp về AI giao tiếp tự nhiên."
wp --url="$BASE_URL" option update home "$BASE_URL"
wp --url="$BASE_URL" option update siteurl "$BASE_URL"
wp --url="$FORUM_URL" option update blogname "Diễn đàn VOXA"
wp --url="$FORUM_URL" option update blogdescription "Cùng trao đổi và chia sẻ kinh nghiệm với cộng đồng VOXA."

wp --url="$FORUM_URL" eval-file /scripts/setup-forum-home.php

sh /scripts/configure-seo.sh

# Remove only the default sample post and page from a fresh WordPress install.
wp --url="$BASE_URL" post delete 1 2 --force >/dev/null 2>&1 || true
wp --url="$BASE_URL" rewrite flush --hard
wp --url="$FORUM_URL" rewrite flush --hard

echo "Multisite is ready: $BASE_URL and $FORUM_URL"
echo "Public signup remains disabled. Create users in wp-admin and assign site-specific roles."
