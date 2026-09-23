<?php
/** @package VOXA_Media */
$blog_url = voxa_media_site_url(1);
$forum_url = voxa_media_site_url(2);
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Bỏ qua đến nội dung', 'voxa-media'); ?></a>
<header class="site-header">
	<div class="site-header__inner">
		<a class="brand" href="<?php echo esc_url($blog_url); ?>" aria-label="VOXA Media — <?php esc_attr_e('Trang chủ', 'voxa-media'); ?>">
			<img class="brand__logo brand__logo--light" src="<?php echo esc_url(voxa_media_logo_url('voxa-logo-full.png')); ?>" alt="VOXA" width="866" height="289">
			<img class="brand__logo brand__logo--dark" src="<?php echo esc_url(voxa_media_logo_url('voxa-logo.png')); ?>" alt="VOXA" width="1248" height="350">
		</a>
		<nav class="primary-nav" aria-label="<?php esc_attr_e('Điều hướng chính', 'voxa-media'); ?>">
			<a class="primary-nav__link<?php echo is_main_site() ? ' is-current' : ''; ?>" href="<?php echo esc_url($blog_url); ?>"><?php esc_html_e('Bài viết', 'voxa-media'); ?></a>
			<a class="primary-nav__link<?php echo !is_main_site() ? ' is-current' : ''; ?>" href="<?php echo esc_url($forum_url); ?>"><?php esc_html_e('Diễn đàn', 'voxa-media'); ?></a>
			<?php if (is_user_logged_in()) : ?>
				<a class="primary-nav__account" href="<?php echo esc_url(admin_url()); ?>"><?php esc_html_e('Tài khoản', 'voxa-media'); ?></a>
			<?php else : ?>
				<a class="primary-nav__account" href="<?php echo esc_url(wp_login_url(home_url('/'))); ?>"><?php esc_html_e('Đăng nhập', 'voxa-media'); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</header>
