#!/bin/sh
set -eu

YOAST_VERSION="28.5"
BASE_URL="${WP_SCHEME}://${WP_NETWORK_DOMAIN}${WP_URL_PORT:+:${WP_URL_PORT}}"
FORUM_URL="${WP_SCHEME}://${WP_FORUM_DOMAIN}${WP_URL_PORT:+:${WP_URL_PORT}}"

seo_plugins="wordpress-seo|rank-math|all-in-one-seo-pack|seo-by-10web|seopress|autodescription|the-seo-framework|squirrly-seo|slim-seo"

check_conflicts() {
	url="$1"
	active_plugins="$(
		wp --url="$url" plugin list --status=active --field=name
		wp --url="$url" plugin list --network --status=active --field=name 2>/dev/null || true
	)"
	conflicts="$(printf '%s\n' "$active_plugins" | grep -E "$seo_plugins" | grep -v '^wordpress-seo$' || true)"
	if [ -n "$conflicts" ]; then
		echo "Refusing to configure Yoast SEO because another SEO plugin is active on $url:" >&2
		echo "$conflicts" >&2
		exit 1
	fi
}

install_or_verify_yoast() {
	url="$1"
	if ! wp --url="$url" plugin is-installed wordpress-seo >/dev/null 2>&1; then
		wp --url="$url" plugin install wordpress-seo --version="$YOAST_VERSION"
	else
		installed_version="$(wp --url="$url" plugin get wordpress-seo --field=version)"
		if [ "$installed_version" != "$YOAST_VERSION" ]; then
			wp --url="$url" plugin install wordpress-seo --version="$YOAST_VERSION" --force
		fi
	fi
	wp --url="$url" plugin activate wordpress-seo
	wp --url="$url" eval-file /scripts/configure-seo.php
}

check_conflicts "$BASE_URL"
check_conflicts "$FORUM_URL"
install_or_verify_yoast "$BASE_URL"
install_or_verify_yoast "$FORUM_URL"
