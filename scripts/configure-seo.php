<?php
/** Configure the shared VOXA SEO defaults for the current WordPress site. */

if (!defined('ABSPATH')) {
	exit(1);
}

if (!class_exists('WPSEO_Options')) {
	fwrite(STDERR, "Yoast SEO is not loaded.\n");
	exit(1);
}

$site_name = wp_strip_all_tags(get_bloginfo('name'));
$site_description = wp_strip_all_tags(get_bloginfo('description'));

$title_settings = [
	'company_or_person' => 'company',
	'company_name' => 'VOXA',
	'website_name' => $site_name,
	'breadcrumbs-enable' => true,
	'breadcrumbs-home' => __('Trang chủ', 'voxa-media'),
	'breadcrumbs-prefix' => '',
	'breadcrumbs-sep' => '→',
	'breadcrumbs-archiveprefix' => __('Lưu trữ', 'voxa-media'),
	'breadcrumbs-searchprefix' => __('Tìm kiếm', 'voxa-media'),
	'breadcrumbs-display-blog-page' => true,
	'metadesc-home-wpseo' => $site_description,
	'open_graph_frontpage_title' => $site_name,
	'open_graph_frontpage_desc' => $site_description,
];

if (is_main_site()) {
	$title_settings['schema-article-type-post'] = 'BlogPosting';
} elseif (post_type_exists('topic')) {
	$title_settings['schema-article-type-topic'] = 'SocialMediaPosting';
}

foreach ($title_settings as $key => $value) {
	WPSEO_Options::set($key, $value, 'wpseo_titles');
}

$social_settings = [
	'opengraph' => true,
	'twitter' => true,
	'twitter_card_type' => 'summary_large_image',
	'og_frontpage_title' => $site_name,
	'og_frontpage_desc' => $site_description,
];
foreach ($social_settings as $key => $value) {
	WPSEO_Options::set($key, $value, 'wpseo_social');
}

WPSEO_Options::set('enable_xml_sitemap', true, 'wpseo');

echo "Configured Yoast SEO for " . ($site_name ?: 'current site') . ".\n";
