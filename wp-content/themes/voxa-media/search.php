<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width blog-listing listing-page search-page">
	<header class="listing-heading">
		<p class="eyebrow"><?php esc_html_e('TÌM KIẾM', 'voxa-media'); ?></p>
		<h1><?php esc_html_e('Kết quả cho:', 'voxa-media'); ?> <span><?php echo esc_html(get_search_query()); ?></span></h1>
		<?php get_search_form(); ?>
	</header>
	<?php if (have_posts()) : ?>
		<p class="listing-result-count"><?php echo esc_html(sprintf(_n('%s bài viết phù hợp', '%s bài viết phù hợp', (int) $wp_query->found_posts, 'voxa-media'), number_format_i18n((int) $wp_query->found_posts))); ?></p>
		<div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div>
		<?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?>
	<?php else : ?>
		<?php get_template_part('template-parts/empty-state', null, ['title' => __('Chưa tìm thấy bài phù hợp', 'voxa-media'), 'text' => __('Thử một từ khóa khác nhé.', 'voxa-media')]); ?>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
