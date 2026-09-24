<?php
/** Shared forum masthead, native search, and live community counts. */

$title = $args['title'] ?? __('Diễn đàn VOXA', 'voxa-media');
$description = $args['description'] ?? __('Không gian trao đổi câu hỏi, kinh nghiệm và ý tưởng cùng cộng đồng VOXA.', 'voxa-media');
$statistics = $args['statistics'] ?? (function_exists('bbp_get_statistics')
	? bbp_get_statistics(['count_users' => false, 'count_forums' => false, 'count_tags' => false])
	: []);
$topic_count = (int) ($statistics['topic_count_int'] ?? 0);
$reply_count = (int) ($statistics['reply_count_int'] ?? 0);
?>
<header class="forum-masthead">
	<div class="forum-status" aria-label="<?php esc_attr_e('Thông tin diễn đàn', 'voxa-media'); ?>">
		<div class="forum-status__identity"><span class="forum-status__signal" aria-hidden="true"></span><span>VOXA · COMMUNITY</span></div>
		<span class="forum-status__separator" aria-hidden="true">/</span>
		<span class="forum-status__context"><?php esc_html_e('FORUM INDEX', 'voxa-media'); ?></span>
		<span class="forum-status__live"><?php esc_html_e('NỘI DUNG CÔNG KHAI', 'voxa-media'); ?></span>
	</div>

	<div class="forum-masthead__grid">
		<div class="forum-masthead__copy">
			<h1><?php echo esc_html($title); ?></h1>
			<p><?php echo esc_html($description); ?></p>
		</div>
		<?php if (function_exists('bbp_allow_search') && bbp_allow_search()) : ?>
			<form class="forum-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				<label for="bbp_search_top" class="forum-search__label"><?php esc_html_e('Tra cứu diễn đàn', 'voxa-media'); ?></label>
				<input type="hidden" name="action" value="bbp-search-request">
				<div class="forum-search__controls">
					<span class="forum-search__icon" aria-hidden="true">⌕</span>
					<input id="bbp_search_top" type="search" name="bbp_search" value="<?php echo function_exists('bbp_get_search_terms') ? esc_attr(bbp_get_search_terms()) : ''; ?>" placeholder="<?php esc_attr_e('Tìm kiếm trong diễn đàn…', 'voxa-media'); ?>">
					<button type="submit"><?php esc_html_e('Tìm', 'voxa-media'); ?></button>
				</div>
			</form>
		<?php endif; ?>
	</div>

	<div class="forum-system-notice" role="status">
		<span class="forum-system-notice__mark" aria-hidden="true">i</span>
		<p><strong><?php esc_html_e('Thông tin diễn đàn:', 'voxa-media'); ?></strong>
			<?php
			printf(
				/* translators: 1: topic count, 2: reply count */
				esc_html__('hiện có %1$s chủ đề và %2$s phản hồi. Nội dung được mở để đọc; đăng nhập để tham gia thảo luận.', 'voxa-media'),
				esc_html(number_format_i18n($topic_count)),
				esc_html(number_format_i18n($reply_count))
			);
			?>
		</p>
		<?php if (!is_user_logged_in()) : ?>
			<a class="forum-system-notice__action" href="<?php echo esc_url(wp_login_url(home_url('/'))); ?>"><?php esc_html_e('Đăng nhập', 'voxa-media'); ?><span aria-hidden="true">→</span></a>
		<?php endif; ?>
	</div>
</header>
