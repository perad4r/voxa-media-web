# VOXA Forum: design content guide

Use this guide to keep forum mockups aligned with the public forum and the discussion features configured today. It describes `forum.voxa.vn`; it does not authorize invented sample discussions or imply that every standard bbPress feature is enabled.

## Current public content

Snapshot checked 24 September 2026 from the public forum homepage.

| Content | Public count or state | Design implication |
| --- | --- | --- |
| Public forums | 1 | The current forum is “Thảo luận chung.” |
| Topics | 0 | There are no discussion titles or topic cards to use as live examples. |
| Replies | 0 | There are no reply excerpts, participant activity, or last-reply details. |
| Topic tags | None in use | Do not show populated tag chips or tag filters as existing content. |
| Public registration | Disabled | Visitors can read; an administrator creates accounts. |

The public forum currently shows the description “Không gian trao đổi câu hỏi, kinh nghiệm và ý tưởng cùng cộng đồng VOXA.” Its topic and reply counts are both zero, and its latest-activity cell says “Không có chủ đề.” Recheck the live forum before treating these counts as current.

## Discussion information available to designs

The forum uses bbPress on the forum site only. Its standard discussion records can supply:

| Record | Information available to the forum UI |
| --- | --- |
| Forum | Name, description, open/closed state, topic count, reply count, latest activity, and optional child forums. |
| Topic | Subject, body, forum, author, created/updated time, status, replies, and optional tags. |
| Reply | Body, author, timestamp, and the topic it belongs to. |

The forum list currently labels its columns “Diễn đàn,” “Chủ đề,” “Bài viết,” and “Bài viết cuối.” Topic and reply pages can show author/date details, reply content, pagination, and posting forms when relevant content exists and the visitor has permission.

## Existing page behavior

- **Forum homepage:** Shared VOXA header, the fixed “VOXA · COMMUNITY” heading and Vietnamese introduction, a forum search field, then the bbPress forum index inside the dark forum panel.
- **Forum row:** Forum title and description, topic count, reply count, and latest-activity information. There is currently one row and no discussions beneath it.
- **No-topic state:** The latest-activity cell reads “Không có chủ đề.” Keep the zero-count state visible; do not fill the screen with fictional topics or replies.
- **Topic and reply views:** bbPress provides the discussion content and forms inside the shared theme wrapper. The theme stylesheet supports breadcrumbs, topic/reply tables, reply author/date areas, pagination, topic tags, login forms, and topic/reply forms. These are available layouts, not evidence that matching live content exists today.
- **Participation:** Forum pages are public to read. Public sign-up is disabled. Administrators create shared accounts, and users assigned the **Participant** role on the forum can create topics and replies. A signed-out visitor should not be mocked as able to publish anonymously.
- **Shared header and footer:** The header links to “Bài viết” and “Diễn đàn” and shows “Đăng nhập” or “Tài khoản” based on sign-in state. The footer has VOXA MEDIA branding, the existing Vietnamese tagline, and a link to `voxa.vn`.

## Keep mockups grounded

- Do not invent discussion subjects, replies, participant names, avatars, activity times, testimonials, moderation badges, or community statistics.
- For a populated-state concept, use labeled neutral placeholders and mark it as a future state. Keep the current public forum’s one empty forum as the default reference.
- Reactions, likes, voting, reputation scores, leaderboards, direct messages, notifications, member directories, and community analytics are not established features in the current forum design. Treat them as proposed product work.
- Topic tags are supported in the theme styling but are not currently populated. Do not make a tag directory or filter system look like an existing feature.
- Keep the existing Vietnamese copy and dark-first visual direction unless the product owner approves a change.

## Sources

- [Live public forum](https://forum.voxa.vn/)
- Theme wrapper and layout: `wp-content/themes/voxa-media/page-forum.php`, `bbpress.php`, `header.php`, and `footer.php`.
- Forum setup and permissions: `scripts/setup-forum-home.php`, `docs/accounts.md`, and the forum rules in `AGENTS.md`.
- Shared bbPress presentation rules: `wp-content/themes/voxa-media/assets/css/site.css`.
