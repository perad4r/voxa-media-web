<?php
/** @package VOXA_Media */

function voxa_media_setup() {
	load_child_theme_textdomain('voxa-media', get_stylesheet_directory() . '/languages');
	register_nav_menus(['primary' => __('Primary navigation', 'voxa-media')]);
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('site-icon');
	add_theme_support('bbpress');
	add_theme_support('yoast-seo-breadcrumbs');
}
add_action('after_setup_theme', 'voxa_media_setup');

function voxa_media_favicon() {
	if (function_exists('has_site_icon') && has_site_icon()) {
		return;
	}

	$icon_path = get_stylesheet_directory() . '/assets/favicon.png';
	if (!file_exists($icon_path)) {
		return;
	}

	$icon_url = add_query_arg('ver', (string) filemtime($icon_path), get_stylesheet_directory_uri() . '/assets/favicon.png');
	printf('<link rel="icon" href="%1$s" type="image/png">', esc_url($icon_url));
	printf('<link rel="apple-touch-icon" href="%1$s">', esc_url($icon_url));
}
add_action('wp_head', 'voxa_media_favicon', 98);

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
