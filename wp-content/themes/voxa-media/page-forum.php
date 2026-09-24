<?php
/** @package VOXA_Media */
get_header();
$statistics = function_exists('bbp_get_statistics')
	? bbp_get_statistics(['count_users' => false, 'count_forums' => false, 'count_tags' => false])
	: [];
$topic_count = (int) ($statistics['topic_count_int'] ?? 0);
$forum_posts = function_exists('bbp_get_forum_post_type') ? get_posts([
	'post_type' => bbp_get_forum_post_type(),
	'post_status' => function_exists('bbp_get_public_status_id') ? bbp_get_public_status_id() : 'publish',
	'post_parent' => 0,
	'numberposts' => 1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
]) : [];
$forum_id = $forum_posts ? (int) $forum_posts[0]->ID : 0;
$discussion_url = $forum_id && function_exists('bbp_get_forum_permalink') ? bbp_get_forum_permalink($forum_id) : '';
$can_create_topic = $forum_id && current_user_can('publish_topics') && (!function_exists('bbp_is_forum_open') || bbp_is_forum_open($forum_id));
$topic_action_url = $discussion_url ? ($can_create_topic ? $discussion_url . '#new-post' : (!is_user_logged_in() ? wp_login_url($discussion_url . '#new-post') : '')) : '';
?>
<main id="main-content" class="site-main content-width forum-page">
	<?php get_template_part('template-parts/forum-intro', null, ['statistics' => $statistics]); ?>
	<section class="forum-section forum-directory" aria-labelledby="forum-directory-title">
		<header class="forum-section__heading">
			<div><p class="eyebrow"><?php esc_html_e('VOXA · COMMUNITY', 'voxa-media'); ?></p><h2 id="forum-directory-title"><?php esc_html_e('Danh mục diễn đàn', 'voxa-media'); ?></h2></div>
			<span class="forum-section__note"><?php esc_html_e('ROOT INDEX', 'voxa-media'); ?></span>
		</header>
		<div class="forum-content"><?php while (have_posts()) : the_post(); the_content(); endwhile; ?></div>
	</section>

	<section class="forum-section forum-latest" aria-labelledby="forum-latest-title">
		<header class="forum-section__heading forum-section__heading--latest">
			<div><p class="eyebrow"><?php esc_html_e('THẢO LUẬN', 'voxa-media'); ?></p><h2 id="forum-latest-title"><?php esc_html_e('Chủ đề mới nhất', 'voxa-media'); ?></h2></div>
			<div class="forum-section__tools">
				<span class="forum-count"><strong><?php echo esc_html(number_format_i18n($topic_count)); ?></strong> <?php esc_html_e('CHỦ ĐỀ', 'voxa-media'); ?></span>
				<?php if ($topic_action_url) : ?>
					<a class="forum-new-topic" href="<?php echo esc_url($topic_action_url); ?>"><span aria-hidden="true">＋</span><?php echo esc_html($can_create_topic ? __('Tạo chủ đề mới', 'voxa-media') : __('Đăng nhập để tham gia', 'voxa-media')); ?></a>
				<?php endif; ?>
			</div>
		</header>
		<?php if ($topic_count > 0) : ?>
			<div class="forum-content forum-content--topics"><?php echo do_shortcode('[bbp-topic-index]'); ?></div>
		<?php else : ?>
			<div class="forum-empty-state">
				<span class="forum-empty-state__mark" aria-hidden="true">＋</span>
				<div><h3><?php esc_html_e('Chưa có chủ đề thảo luận', 'voxa-media'); ?></h3><p><?php esc_html_e('Các chủ đề mới sẽ xuất hiện tại đây khi cộng đồng bắt đầu trao đổi.', 'voxa-media'); ?></p></div>
			</div>
		<?php endif; ?>
	</section>
</main>
<?php get_footer(); ?>
