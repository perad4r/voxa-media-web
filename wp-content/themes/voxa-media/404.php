<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width blog-main not-found">
	<p class="eyebrow">404 · VOXA MEDIA</p>
	<h1><?php esc_html_e('Trang này chưa được tìm thấy.', 'voxa-media'); ?></h1>
	<p><?php esc_html_e('Đường dẫn có thể đã thay đổi. Bạn có thể quay lại trang chủ hoặc ghé thăm diễn đàn.', 'voxa-media'); ?></p>
	<div class="not-found__actions"><a class="editorial-action" href="<?php echo esc_url(voxa_media_site_url(1)); ?>"><?php esc_html_e('Về trang bài viết', 'voxa-media'); ?> →</a><a class="editorial-action" href="<?php echo esc_url(voxa_media_site_url(2)); ?>"><?php esc_html_e('Mở diễn đàn', 'voxa-media'); ?> →</a></div>
</main>
<?php get_footer(); ?>
