<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width listing-page">
	<header class="listing-heading"><p class="eyebrow"><?php esc_html_e('VOXA · MEDIA', 'voxa-media'); ?></p><h1><?php esc_html_e('Bài viết', 'voxa-media'); ?></h1></header>
	<?php if (have_posts()) : ?>
		<div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div>
		<?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?>
	<?php else : ?><div class="empty-state"><h2><?php esc_html_e('Chưa có bài viết', 'voxa-media'); ?></h2><p><?php esc_html_e('Nội dung mới sẽ được cập nhật tại đây.', 'voxa-media'); ?></p></div><?php endif; ?>
</main>
<?php get_footer(); ?>
