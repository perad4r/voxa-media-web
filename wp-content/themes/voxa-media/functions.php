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
}
add_action('after_setup_theme', 'voxa_media_setup');

function voxa_media_enqueue_styles() {
	$css_path = get_stylesheet_directory() . '/assets/css/site.css';
	wp_enqueue_style('voxa-media-style', get_stylesheet_directory_uri() . '/assets/css/site.css', [], file_exists($css_path) ? (string) filemtime($css_path) : '1.0.0');
}
add_action('wp_enqueue_scripts', 'voxa_media_enqueue_styles');

function voxa_media_logo_url($filename) {
	return get_stylesheet_directory_uri() . '/assets/' . rawurlencode($filename);
}

function voxa_media_site_url($blog_id) {
	$url = get_home_url((int) $blog_id, '/');
	return $url ?: home_url('/');
}

function voxa_media_archive_canonical() {
	if (is_singular() || is_search() || is_404()) {
		return;
	}

	$canonical = (is_front_page() || is_home())
		? home_url('/')
		: get_pagenum_link(max(1, (int) get_query_var('paged')));

	echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
}
add_action('wp_head', 'voxa_media_archive_canonical', 1);

function voxa_media_noindex_internal_results($robots) {
	if (is_search() || is_404()) {
		$robots['noindex'] = true;
	}
	return $robots;
}
add_filter('wp_robots', 'voxa_media_noindex_internal_results');
