#!/bin/sh
set -eu

WP_URL_PORT="${WP_URL_PORT:-}"
URL_PORT="${WP_URL_PORT:+:$WP_URL_PORT}"
BASE_URL="${WP_SCHEME}://${WP_NETWORK_DOMAIN}${URL_PORT}"
FORUM_URL="${WP_SCHEME}://${WP_FORUM_DOMAIN}${URL_PORT}"
USER_LOGIN="voxasmoke$(date +%s)"
USER_EMAIL="${USER_LOGIN}@example.test"
USER_ID=""

cleanup() {
    if [ -n "$USER_ID" ]; then
        wp --url="$BASE_URL" user delete "$USER_ID" --yes >/dev/null 2>&1 || true
    fi
}
trap cleanup EXIT HUP INT TERM

wp --url="$BASE_URL" core is-installed
wp --url="$BASE_URL" site list --field=domain | grep -Fxq "${WP_NETWORK_DOMAIN}${URL_PORT}"
wp --url="$BASE_URL" site list --field=domain | grep -Fxq "${WP_FORUM_DOMAIN}${URL_PORT}"
wp --url="$BASE_URL" theme is-active voxa-media
wp --url="$FORUM_URL" theme is-active voxa-media
for site_url in "$BASE_URL" "$FORUM_URL"; do
    SITE_LOCALE="$(wp --url="$site_url" eval 'echo get_locale();')"
    [ "$SITE_LOCALE" = "vi" ] || { echo "Expected Vietnamese locale on $site_url; got $SITE_LOCALE." >&2; exit 1; }
done
wp --url="$BASE_URL" plugin is-active bbpress >/dev/null 2>&1 && {
    echo "bbPress must not be activated on the blog site." >&2
    exit 1
} || true
wp --url="$FORUM_URL" plugin is-active bbpress

SIGNUP_STATE="$(wp --url="$BASE_URL" eval 'echo WP_ALLOW_SIGNUP ? "enabled" : "disabled";')"
[ "$SIGNUP_STATE" = "disabled" ] || { echo "Public registration is enabled unexpectedly." >&2; exit 1; }

USER_ID="$(wp --url="$FORUM_URL" user create "$USER_LOGIN" "$USER_EMAIL" --role=bbp_participant --porcelain)"
FORUM_PUBLISH="$(wp --url="$FORUM_URL" eval "wp_set_current_user(get_user_by('login', '$USER_LOGIN')->ID); echo current_user_can('publish_topics') ? 'yes' : 'no';")"
[ "$FORUM_PUBLISH" = "yes" ] || { echo "Forum Participant cannot publish topics." >&2; exit 1; }

wp --url="$BASE_URL" user set-role "$USER_ID" subscriber
BLOG_SUBSCRIBER_PUBLISH="$(wp --url="$BASE_URL" eval "wp_set_current_user(get_user_by('login', '$USER_LOGIN')->ID); echo current_user_can('publish_posts') ? 'yes' : 'no';")"
[ "$BLOG_SUBSCRIBER_PUBLISH" = "no" ] || { echo "Unapproved blog user can publish." >&2; exit 1; }

wp --url="$BASE_URL" user set-role "$USER_ID" author
BLOG_AUTHOR_PUBLISH="$(wp --url="$BASE_URL" eval "wp_set_current_user(get_user_by('login', '$USER_LOGIN')->ID); echo current_user_can('publish_posts') ? 'yes' : 'no';")"
[ "$BLOG_AUTHOR_PUBLISH" = "yes" ] || { echo "Approved blog Author cannot publish." >&2; exit 1; }

echo "PASS: mapped sites, theme, forum-only bbPress, signup disabled, immediate forum posting, and blog role gate."
