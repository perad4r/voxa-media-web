<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width blog-listing listing-page">
	<header class="listing-heading">
		<?php get_template_part('template-parts/section-heading', null, [
			'eyebrow' => __('VOXA · MEDIA', 'voxa-media'),
			'title' => __('Bài viết', 'voxa-media'),
			'level' => 'h1',
		]); ?>
	</header>
	<?php get_template_part('template-parts/category-filters'); ?>
	<?php if (have_posts()) : ?>
		<div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div>
		<?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?>
	<?php else : ?>
		<?php get_template_part('template-parts/empty-state', null, ['title' => __('Chưa có bài viết', 'voxa-media'), 'text' => __('Nội dung mới sẽ được cập nhật tại đây.', 'voxa-media')]); ?>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
