<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width listing-page">
	<header class="listing-heading"><p class="eyebrow"><?php esc_html_e('TÌM KIẾM', 'voxa-media'); ?></p><h1><?php printf(esc_html__('Kết quả cho: %s', 'voxa-media'), '<span>' . esc_html(get_search_query()) . '</span>'); ?></h1><?php get_search_form(); ?></header>
	<?php if (have_posts()) : ?><div class="article-grid"><?php while (have_posts()) : the_post(); get_template_part('template-parts/article-card'); endwhile; ?></div><?php the_posts_pagination(); ?><?php else : ?><div class="empty-state"><h2><?php esc_html_e('Chưa tìm thấy bài phù hợp', 'voxa-media'); ?></h2><p><?php esc_html_e('Thử một từ khóa khác nhé.', 'voxa-media'); ?></p></div><?php endif; ?>
</main>
<?php get_footer(); ?>
