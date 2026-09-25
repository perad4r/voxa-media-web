<?php
/** @package VOXA_Media */

function voxa_media_blog_breadcrumbs_enabled() {
	return is_main_site() && !is_front_page() && !is_search() && !is_404();
}

function voxa_media_render_blog_breadcrumbs() {
	if (!voxa_media_blog_breadcrumbs_enabled() || !function_exists('yoast_breadcrumb')) {
		return;
	}

	$breadcrumbs = yoast_breadcrumb('', '', false);
	if (!$breadcrumbs) {
		return;
	}

	echo '<nav class="blog-breadcrumbs" aria-label="' . esc_attr__('Đường dẫn trang', 'voxa-media') . '">';
	echo wp_kses_post($breadcrumbs);
	echo '</nav>';
}

function voxa_media_seo_description($description) {
	if ($description !== '' || is_search() || is_404() || voxa_media_design_preview_enabled()) {
		return $description;
	}

	if (is_front_page() || is_home()) {
		return wp_strip_all_tags(get_bloginfo('description'));
	}

	if (is_category() || is_tag() || is_tax()) {
		$term_description = term_description();
		return wp_trim_words(wp_strip_all_tags($term_description), 32, '…') ?: wp_strip_all_tags(get_bloginfo('description'));
	}

	if (function_exists('bbp_is_single_topic') && bbp_is_single_topic()) {
		return wp_trim_words(wp_strip_all_tags(strip_shortcodes(bbp_get_topic_content())), 32, '…');
	}

	if (is_singular()) {
		$post = get_queried_object();
		$content = has_excerpt($post) ? get_the_excerpt($post) : get_post_field('post_content', $post);
		return wp_trim_words(wp_strip_all_tags(strip_shortcodes($content)), 32, '…');
	}

	return wp_strip_all_tags(get_bloginfo('description'));
}
add_filter('wpseo_metadesc', 'voxa_media_seo_description', 10);

function voxa_media_seo_social_description($description) {
	if ($description !== '') {
		return $description;
	}

	return voxa_media_seo_description('');
}
add_filter('wpseo_opengraph_desc', 'voxa_media_seo_social_description', 10);
add_filter('wpseo_twitter_description', 'voxa_media_seo_social_description', 10);
