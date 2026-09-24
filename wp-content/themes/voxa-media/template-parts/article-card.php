<?php
/** Reusable WordPress article card; accepts preview data for local design review. */
$preview = isset($args['preview']) && is_array($args['preview']) ? $args['preview'] : null;

if ($preview) {
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
	$title = get_the_title();
	$excerpt = get_the_excerpt();
	$categories = get_the_category();
	$category = $categories ? $categories[0]->name : '';
	$category_slug = $categories ? $categories[0]->slug : '';
	$image = get_post_thumbnail_id() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : '';
	$image_alt = get_post_thumbnail_id() ? get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) : '';
	$author = get_the_author();
	$date = get_the_date();
	$datetime = get_the_date('c');
	$permalink = get_permalink();
}
?>
<article class="article-card<?php echo $image === '' ? ' article-card--text-only' : ''; ?>"<?php if ($preview) : ?> data-preview-item data-category="<?php echo esc_attr($category_slug); ?>"<?php endif; ?>>
	<a class="article-card__link" href="<?php echo esc_url($permalink); ?>">
		<?php if ($image !== '') : ?><div class="article-card__image"><img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy" decoding="async"></div><?php endif; ?>
		<div class="article-card__body">
			<?php if ($category !== '') : ?><p class="article-card__category"><?php echo esc_html($category); ?></p><?php endif; ?>
			<h3><?php echo esc_html($title); ?></h3>
			<p class="article-card__excerpt"><?php echo esc_html(wp_trim_words($excerpt, 30)); ?></p>
			<?php get_template_part('template-parts/article-meta', null, ['author' => $author, 'date' => $date, 'datetime' => $datetime]); ?>
			<span class="article-card__read"><?php esc_html_e('Đọc bài viết', 'voxa-media'); ?> <span aria-hidden="true">↗</span></span>
		</div>
	</a>
</article>
