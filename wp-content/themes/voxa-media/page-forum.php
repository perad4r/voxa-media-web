<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width forum-page">
	<header class="forum-page__heading"><p class="eyebrow">VOXA · COMMUNITY</p><h1><?php esc_html_e('Diễn đàn', 'voxa-media'); ?></h1><p><?php esc_html_e('Cùng đặt câu hỏi, chia sẻ kinh nghiệm và trao đổi về những ứng dụng AI giao tiếp.', 'voxa-media'); ?></p></header>
	<div class="forum-content"><?php while (have_posts()) : the_post(); the_content(); endwhile; ?></div>
</main>
<?php get_footer(); ?>
