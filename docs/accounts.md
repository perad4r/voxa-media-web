# Accounts and publishing

Public registration is disabled. Accounts are created by an administrator until outbound email and self-registration are deliberately configured in a later phase. A WordPress Multisite account is shared between the blog and forum, while permissions are assigned separately on each site.

## Create and approve contributors

1. Sign in with a network administrator account at either `/wp-admin/` URL.
2. Open **My Sites → Network Admin → Users → Add New** and create the account. Share its initial password privately; the system does not yet send email.
3. Add the account to `forum.voxa.vn` with the **Participant** role to allow it to create topics and replies. bbPress handles posting, editing windows, spam controls, and moderation.
4. Add the account to `blog.voxa.vn` with the **Author** role only after approval. Authors can write and publish their own articles immediately. A user without a blog role—or with only Subscriber/Contributor access—cannot publish.

This first phase approves the writer account, not each article. Do not assign Editor or Administrator for routine publishing. Review forum moderation and blog roles regularly.

## Login and recovery

Use the same username and password on both domains. Production WordPress cookies are scoped to `.voxa.vn` so a sign-in can be shared by the sibling subdomains. If an account cannot sign in, use the administrator’s password reset process; email-based password recovery will become available after SMTP is configured.
