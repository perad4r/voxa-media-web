<?php
/** @package VOXA_Media */
if (!is_main_site()) {
	locate_template('page-forum.php', true);
	return;
}
get_header();
?>
<main id="main-content" class="site-main">
	<section class="editorial-intro content-width">
		<p class="eyebrow"><?php esc_html_e('VOXA · MEDIA', 'voxa-media'); ?></p>
		<h1><?php esc_html_e('Góc nhìn mới về AI giao tiếp.', 'voxa-media'); ?></h1>
		<p class="editorial-intro__summary"><?php esc_html_e('Kiến thức, ứng dụng và câu chuyện về cách công nghệ tạo nên những cuộc trò chuyện tự nhiên hơn.', 'voxa-media'); ?></p>
		<?php if (is_user_logged_in() && current_user_can('edit_posts')) : ?>
			<a class="text-link" href="<?php echo esc_url(admin_url('post-new.php')); ?>"><?php esc_html_e('Viết bài mới', 'voxa-media'); ?> <span aria-hidden="true">↗</span></a>
		<?php endif; ?>
	</section>
	<section class="article-section content-width" aria-labelledby="latest-heading">
		<div class="section-heading"><div><p class="eyebrow"><?php esc_html_e('TỪ VOXA MEDIA', 'voxa-media'); ?></p><h2 id="latest-heading"><?php esc_html_e('Bài viết mới nhất', 'voxa-media'); ?></h2></div></div>
		<?php if (have_posts()) : ?>
			<div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div>
			<?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?>
		<?php else : ?>
			<div class="empty-state"><span class="empty-state__mark" aria-hidden="true">V.</span><h3><?php esc_html_e('Bài viết đang được chuẩn bị', 'voxa-media'); ?></h3><p><?php esc_html_e('Những nội dung đầu tiên sẽ xuất hiện tại đây. Trong lúc chờ, bạn có thể ghé thăm diễn đàn VOXA.', 'voxa-media'); ?></p><a class="button button--quiet" href="<?php echo esc_url(voxa_media_site_url(2)); ?>"><?php esc_html_e('Khám phá diễn đàn', 'voxa-media'); ?> <span aria-hidden="true">→</span></a></div>
		<?php endif; ?>
	</section>
</main>
<?php get_footer(); ?>
