<?php
/** @package VOXA_Media */
get_header();
$forum_intro = [];
if (function_exists('bbp_is_single_forum') && bbp_is_single_forum()) {
	$forum_intro['title'] = bbp_get_forum_title();
	$forum_description = wp_strip_all_tags(bbp_get_forum_content());
	if ($forum_description !== '') {
		$forum_intro['description'] = $forum_description;
	}
} elseif (function_exists('bbp_is_single_topic') && bbp_is_single_topic()) {
	$forum_intro['title'] = bbp_get_topic_title();
	$forum_intro['description'] = __('Thảo luận trong cộng đồng VOXA.', 'voxa-media');
} elseif (function_exists('bbp_is_search') && bbp_is_search()) {
	$forum_intro['title'] = __('Kết quả tìm kiếm', 'voxa-media');
	$forum_intro['description'] = sprintf(__('Kết quả cho “%s” trong diễn đàn VOXA.', 'voxa-media'), bbp_get_search_terms());
}
?>
<main id="main-content" class="site-main content-width forum-page forum-page--bbpress">
	<?php get_template_part('template-parts/forum-intro', null, $forum_intro); ?>
	<div class="forum-content"><?php while (have_posts()) : the_post(); the_content(); endwhile; ?></div>
</main>
<?php get_footer(); ?>
