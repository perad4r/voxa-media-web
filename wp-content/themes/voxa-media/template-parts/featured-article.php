<?php
/** Reusable featured story spotlight. */
$preview = isset($args['preview']) && is_array($args['preview']) ? $args['preview'] : null;

if ($preview) {
	$post_id = 0;
	$title = $preview['title'] ?? '';
	$excerpt = $preview['excerpt'] ?? '';
	$category = $preview['category'] ?? '';
	$category_slug = $preview['category_slug'] ?? '';
	$image = $preview['image'] ?? '';
	$image_alt = $preview['image_alt'] ?? '';
	$author = $preview['author'] ?? '';
	$date = $preview['date'] ?? '';
	$datetime = $preview['datetime'] ?? '';
	$permalink = '#preview-articles';
} else {
	$post_id = isset($args['post_id']) ? (int) $args['post_id'] : get_the_ID();
	$title = get_the_title($post_id);
	$excerpt = get_the_excerpt($post_id);
	$categories = get_the_category($post_id);
	$category = $categories ? $categories[0]->name : '';
	$category_slug = $categories ? $categories[0]->slug : '';
	$image = get_post_thumbnail_id($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';
	$image_alt = get_post_thumbnail_id($post_id) ? get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) : '';
	$author = get_the_author_meta('display_name', (int) get_post_field('post_author', $post_id));
	$date = get_the_date('', $post_id);
	$datetime = get_the_date('c', $post_id);
	$permalink = get_permalink($post_id);
}
?>
<article class="featured-story<?php echo $image === '' ? ' featured-story--text-only' : ''; ?>"<?php if ($preview) : ?> data-preview-item data-category="<?php echo esc_attr($category_slug); ?>"<?php endif; ?>>
	<?php if ($image !== '') : ?>
		<div class="featured-story__media">
			<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" fetchpriority="high" decoding="async">
			<?php if ($category !== '') : ?><span class="featured-story__category"><?php echo esc_html($category); ?></span><?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="featured-story__content">
		<p class="featured-story__label"><?php esc_html_e('Bài viết tiêu điểm', 'voxa-media'); ?></p>
		<?php if ($category !== '' && $image === '') : ?><p class="featured-story__category featured-story__category--inline"><?php echo esc_html($category); ?></p><?php endif; ?>
		<h2><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a></h2>
		<p class="featured-story__excerpt"><?php echo esc_html(wp_trim_words($excerpt, 42)); ?></p>
		<?php get_template_part('template-parts/article-meta', null, ['author' => $author, 'date' => $date, 'datetime' => $datetime]); ?>
	</div>
</article>
