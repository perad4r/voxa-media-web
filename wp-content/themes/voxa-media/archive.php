<?php
/** @package VOXA_Media */
$archive_title = wp_strip_all_tags(get_the_archive_title());
get_header();
?>
<main id="main-content" class="site-main content-width blog-listing listing-page">
	<header class="listing-heading">
		<?php get_template_part('template-parts/section-heading', null, [
			'eyebrow' => __('VOXA · MEDIA / LƯU TRỮ', 'voxa-media'),
			'title' => $archive_title,
			'level' => 'h1',
		]); ?>
		<?php the_archive_description('<div class="archive-description">', '</div>'); ?>
		<?php get_template_part('template-parts/category-filters'); ?>
	</header>
	<?php if (have_posts()) : ?>
		<div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div>
		<?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?>
	<?php else : ?>
		<?php get_template_part('template-parts/empty-state', null, ['title' => __('Chưa có nội dung trong mục này', 'voxa-media'), 'text' => __('Các bài viết phù hợp sẽ xuất hiện tại đây khi được đăng.', 'voxa-media')]); ?>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
