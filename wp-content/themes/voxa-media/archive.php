<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width listing-page">
	<header class="listing-heading"><p class="eyebrow"><?php esc_html_e('VOXA · MEDIA', 'voxa-media'); ?></p><h1><?php the_archive_title(); ?></h1><?php the_archive_description('<div class="archive-description">', '</div>'); ?></header>
	<?php if (have_posts()) : ?><div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div><?php the_posts_pagination(['prev_text' => __('Bài trước', 'voxa-media'), 'next_text' => __('Bài sau', 'voxa-media')]); ?><?php else : ?><div class="empty-state"><h2><?php esc_html_e('Chưa có nội dung trong mục này', 'voxa-media'); ?></h2></div><?php endif; ?>
</main>
<?php get_footer(); ?>
