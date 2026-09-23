# VOXA Media — Agent Handoff

## Project scope

This is the separate VOXA Media project, not `voxa-website`. It is a Vietnamese-first WordPress Multisite: WordPress serves `blog.voxa.vn`, and bbPress serves `forum.voxa.vn` with shared accounts. Both sites use the VOXA child theme at `wp-content/themes/voxa-media`, based on Twenty Twenty-One.

Read the relevant project guide before operational work:

- Local setup and Podman preview: `docs/development.md`
- Production routing, updates, and backup/restore: `docs/deployment.md`
- Account roles and publishing policy: `docs/accounts.md`

## Product and content rules

- Keep the blog and forum public to read. Public signup is disabled; administrators create shared accounts.
- Forum Participants may post topics and replies. Blog Authors are assigned only after approval and can publish their own posts.
- Do not invent or publish sample articles, discussions, customer claims, or case studies. Use only approved VOXA material.
- Keep bbPress active on the forum site only. Preserve separate per-site roles.
- The shared child theme controls both front ends. Check both blog and forum when changing navigation, colors, typography, or layout. Current styling is intentionally dark-first; use the semantic tokens in `assets/css/site.css` rather than introducing a light/white surface ad hoc.

## Local development

The isolated Podman stack uses `.env.local`, a separate database volume, and a loopback-only proxy. Do not print or commit `.env`/`.env.local` values.

```sh
podman compose --env-file .env.local -f compose.yaml -f compose.local.yaml up -d
```

Open `http://blog.voxa.localhost:8080/` and `http://forum.voxa.localhost:8080/`. The project bind-mounts the child theme read-only, so theme edits appear on the next request. If the WordPress or router container is recreated, restart the router as documented in `docs/development.md`.

Use the bootstrap script only for intended local initialization, after checking the local database state. The smoke test creates and removes a temporary user; run it only against the isolated local stack unless production testing has been explicitly authorized.

## Production and infrastructure safeguards

- Do not deploy, change Cloudflare routes, or alter server data unless the user explicitly asks.
- Production host path documented by the project: `/home/mlemingcapoo/Projects/voxa-media-web`. Verify the actual checkout and its state before running commands there.
- Do not publish host ports. Only `voxa-media-router` joins the existing `voxa-website-internal` Docker network; MariaDB remains on its private network. The router origins are `blog.voxa.vn` → `http://voxa-media-router:4346` and `forum.voxa.vn` → `http://voxa-media-router:4345`.
- Leave the existing `voxa.vn` route and VOXA website container untouched.
- Preserve `.env`, database/upload volumes, and backups. Never run `docker compose down -v` or destructive database/restore commands without explicit approval and a verified backup.
- Never expose passwords, tunnel tokens, private environment files, or initial login credentials in output, commits, or this handoff file.
- Inspect `git status`, branch, and remotes before staging or deployment. This checkout may not have an initial commit or remote configured; do not assume it is safe to `git add -A` or push.

## Verification

- For theme changes, load both local hosts and confirm they use the shared stylesheet and remain readable on mobile.
- Before infrastructure changes, inspect the resolved Compose configuration and confirm no host ports are published.
- Keep operational notes in the existing `docs/` files when they materially change; do not duplicate secrets or environment values.
