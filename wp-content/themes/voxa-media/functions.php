<?php
/** @package VOXA_Media */

function voxa_media_setup() {
	load_child_theme_textdomain('voxa-media', get_stylesheet_directory() . '/languages');
	register_nav_menus(['primary' => __('Primary navigation', 'voxa-media')]);
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('bbpress');
	add_theme_support('yoast-seo-breadcrumbs');
}
add_action('after_setup_theme', 'voxa_media_setup');

function voxa_media_disable_core_site_icon() {
	remove_action('wp_head', 'wp_site_icon', 99);
}
add_action('after_setup_theme', 'voxa_media_disable_core_site_icon', 20);

function voxa_media_asset_url($filename) {
	$asset_path = get_stylesheet_directory() . '/assets/' . $filename;
	$asset_url = get_stylesheet_directory_uri() . '/assets/' . rawurlencode($filename);

	if (file_exists($asset_path)) {
		$asset_url = add_query_arg('ver', (string) filemtime($asset_path), $asset_url);
	}

	return $asset_url;
}

function voxa_media_favicon() {
	$icon_sizes = [
		'favicon-16x16.png' => '16x16',
		'favicon-32x32.png' => '32x32',
		'favicon-48x48.png' => '48x48',
		'favicon.png' => '512x512',
	];

	foreach ($icon_sizes as $filename => $size) {
		$icon_path = get_stylesheet_directory() . '/assets/' . $filename;
		if (!file_exists($icon_path)) {
			continue;
		}

		printf(
			'<link rel="icon" type="image/png" sizes="%1$s" href="%2$s">',
			esc_attr($size),
			esc_url(voxa_media_asset_url($filename))
		);
	}

	$apple_icon_path = get_stylesheet_directory() . '/assets/apple-touch-icon.png';
	if (file_exists($apple_icon_path)) {
		printf(
			'<link rel="apple-touch-icon" sizes="180x180" href="%s">',
			esc_url(voxa_media_asset_url('apple-touch-icon.png'))
		);
	}

	$manifest_path = get_stylesheet_directory() . '/assets/site.webmanifest';
	if (file_exists($manifest_path)) {
		$manifest_url = add_query_arg('ver', (string) filemtime($manifest_path), home_url('/site.webmanifest'));
		printf('<link rel="manifest" href="%s">', esc_url($manifest_url));
	}
}
add_action('wp_head', 'voxa_media_favicon', 98);

function voxa_media_redirect_brand_assets() {
	$request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
	$request_path = wp_parse_url($request_uri, PHP_URL_PATH);
	$brand_assets = [
		'/favicon.ico' => 'favicon.png',
		'/favicon.png' => 'favicon.png',
		'/favicon-16x16.png' => 'favicon-16x16.png',
		'/favicon-32x32.png' => 'favicon-32x32.png',
		'/favicon-48x48.png' => 'favicon-48x48.png',
		'/apple-touch-icon.png' => 'apple-touch-icon.png',
		'/android-chrome-192x192.png' => 'android-chrome-192x192.png',
		'/android-chrome-512x512.png' => 'android-chrome-512x512.png',
		'/site.webmanifest' => 'site.webmanifest',
	];

	if (!isset($brand_assets[$request_path])) {
		return;
	}

	$asset_filename = $brand_assets[$request_path];
	$asset_path = get_stylesheet_directory() . '/assets/' . $asset_filename;
	if (!file_exists($asset_path)) {
		return;
	}

	nocache_headers();
	wp_safe_redirect(voxa_media_asset_url($asset_filename), 302, 'VOXA Media');
	exit;
}
add_action('template_redirect', 'voxa_media_redirect_brand_assets', 0);

function voxa_media_enqueue_styles() {
	$css_path = get_stylesheet_directory() . '/assets/css/site.css';
	$theme_script_path = get_stylesheet_directory() . '/assets/js/theme-toggle.js';
	wp_enqueue_style('voxa-media-style', get_stylesheet_directory_uri() . '/assets/css/site.css', [], file_exists($css_path) ? (string) filemtime($css_path) : '1.0.0');
	wp_enqueue_style(
		'voxa-editorial-fonts',
		'https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap',
		[],
		null
	);
	wp_enqueue_script(
		'voxa-media-theme',
		get_stylesheet_directory_uri() . '/assets/js/theme-toggle.js',
		[],
		file_exists($theme_script_path) ? (string) filemtime($theme_script_path) : '1.0.0',
		false
	);
	if (voxa_media_design_preview_enabled()) {
		$script_path = get_stylesheet_directory() . '/assets/js/blog-design-preview.js';
		wp_enqueue_script(
			'voxa-blog-design-preview',
			get_stylesheet_directory_uri() . '/assets/js/blog-design-preview.js',
			[],
			file_exists($script_path) ? (string) filemtime($script_path) : '1.0.0',
			true
		);
	}
}
add_action('wp_enqueue_scripts', 'voxa_media_enqueue_styles');

function voxa_media_body_classes($classes) {
	if (is_main_site()) {
		$classes[] = 'voxa-blog';
	} else {
		$classes[] = 'voxa-forum';
	}
	return $classes;
}
add_filter('body_class', 'voxa_media_body_classes');

function voxa_media_design_preview_enabled() {
	return is_main_site()
		&& is_front_page()
		&& getenv('VOXA_DESIGN_PREVIEW') === '1'
		&& isset($_GET['voxa_design_preview'])
		&& is_string($_GET['voxa_design_preview'])
		&& sanitize_text_field(wp_unslash($_GET['voxa_design_preview'])) === '1';
}

function voxa_media_logo_url($filename) {
	return get_stylesheet_directory_uri() . '/assets/' . rawurlencode($filename);
}

function voxa_media_site_url($blog_id) {
	$url = get_home_url((int) $blog_id, '/');
	return $url ?: home_url('/');
}

function voxa_media_noindex_internal_results($robots) {
	$empty_archive = is_archive()
		&& isset($GLOBALS['wp_query'])
		&& 0 === (int) $GLOBALS['wp_query']->found_posts;
	$private_forum_page = function_exists('bbp_is_single_reply') && bbp_is_single_reply()
		|| function_exists('bbp_is_single_user') && bbp_is_single_user();

	if (is_search() || is_404() || $empty_archive || $private_forum_page || voxa_media_design_preview_enabled()) {
		$robots['noindex'] = true;
	}
	return $robots;
}
add_filter('wp_robots', 'voxa_media_noindex_internal_results');

require_once get_stylesheet_directory() . '/inc/design-preview.php';
require_once get_stylesheet_directory() . '/inc/seo.php';
