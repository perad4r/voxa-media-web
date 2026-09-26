# VOXA Media blog: design content guide

Use this guide to keep blog mockups aligned with the content and page behavior that exist today. It describes the public blog at `blog.voxa.vn`; it is a design reference, not a promise that every WordPress field has content.

## Current public content

Snapshot checked 24 September 2026 using the public WordPress REST API. These counts cover publicly available records; drafts and private records are not included.

| Content | Public count | Design implication |
| --- | ---: | --- |
| Published posts | 0 | The homepage and article listings show their empty states. There are no live article cards to use as visual references. |
| Published pages | 0 | The blog has no public standalone pages beyond its routed homepage and WordPress system views. |
| Media uploads | 0 | No article cover images or image gallery are available from the blog media library. |
| Categories | 1 | The only category is `Uncategorized`, with 0 posts. Do not present it as an established editorial category system. |
| Tags | 0 | There are no tags to display or use as filter chips. |

The counts can change when approved content is published. Check the live blog before treating this snapshot as current.

## Content fields available to article designs

The theme uses standard WordPress posts. A post can provide:

| Field | How the current theme uses it |
| --- | --- |
| Title | Article heading and card title. |
| Body | Main article content, entered through the WordPress editor. |
| Excerpt | Short card summary; WordPress can derive one from the body when no manual excerpt is set. Cards trim it to about 26 words. |
| Publish date | Shown in card metadata and on the article page. |
| Author display name | Shown on the article page. |
| Category | The card shows the first assigned category when present. The article page can show its assigned categories. |
| Featured image | Optional. The card and article page omit the image area when no featured image is set. |

The VOXA theme does not define extra article fields such as reading time, subtitle, reviewer, author biography, ratings, or article series. Those would need new content rules, fields, or development before a design depends on them.

## Existing page behavior

- **Homepage:** A fixed Vietnamese introduction and a “Bài viết mới nhất” section. With no posts, it shows “Bài viết đang được chuẩn bị,” a short explanation, and a link to the forum. Do not replace this with invented article cards.
- **Article listing:** A “Bài viết” heading, article-card grid when posts exist, pagination, and an empty message when none exist.
- **Category and other archives:** The archive title and optional description, the same article-card grid, pagination, and an empty message.
- **Search:** A query-specific heading and search form, matching article cards and pagination when results exist, or a no-results message.
- **Article detail:** Category label (or the static “VOXA · MEDIA” fallback), title, publish date, author name, optional featured image, body, and a back-to-articles link. Comments appear only when WordPress has comments open or existing comments.
- **Shared header and footer:** The header has the VOXA logo, links to “Bài viết” and “Diễn đàn,” and “Đăng nhập” or “Tài khoản” depending on sign-in state; it has no category or tag navigation. The footer has VOXA MEDIA branding, the existing Vietnamese tagline, and a link to `voxa.vn`.

## Keep mockups grounded

- Do not invent article titles, excerpts, authors, dates, images, testimonials, customer claims, ratings, view counts, or performance statistics.
- For populated-state layouts, use clearly labeled neutral placeholders such as “Article title from WordPress” and mark them as examples, not approved copy. Keep the empty state as the default until approved posts and assets exist.
- Treat category filters, tag chips, related or featured articles, author profile pages, reading-time labels, sharing controls, and comment counts as proposed features. The current theme does not render these as article-design elements.
- Keep the existing Vietnamese copy and dark-first visual direction unless the product owner approves a content or visual change.

## Sources

- Live public counts: [posts](https://blog.voxa.vn/wp-json/wp/v2/posts?per_page=1), [pages](https://blog.voxa.vn/wp-json/wp/v2/pages?per_page=1), [media](https://blog.voxa.vn/wp-json/wp/v2/media?per_page=1), [categories](https://blog.voxa.vn/wp-json/wp/v2/categories?per_page=1), and [tags](https://blog.voxa.vn/wp-json/wp/v2/tags?per_page=1).
- Theme behavior: `wp-content/themes/voxa-media/front-page.php`, `index.php`, `archive.php`, `search.php`, `single.php`, and `template-parts/article-card.php`.
