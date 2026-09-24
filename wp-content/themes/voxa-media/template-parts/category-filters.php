<?php
/** Category navigation; local mock mode uses client-side-only filter controls. */
$args = $args ?? [];
if (!empty($args['preview'])) :
	$preview_categories = [
		['slug' => 'all', 'name' => __('Tất cả', 'voxa-media')],
		['slug' => 'voice', 'name' => __('Công nghệ Giọng nói', 'voxa-media')],
		['slug' => 'dsp', 'name' => __('Xử lý Tín hiệu Âm thanh', 'voxa-media')],
		['slug' => 'architecture', 'name' => __('Kiến trúc Hệ thống', 'voxa-media')],
		['slug' => 'news', 'name' => __('Tin tức Sản phẩm', 'voxa-media')],
	];
?>
	<nav class="category-filters" aria-label="<?php esc_attr_e('Lọc bài viết theo danh mục', 'voxa-media'); ?>">
		<?php foreach ($preview_categories as $index => $category) : ?>
			<button class="category-filter<?php echo $index === 0 ? ' is-active' : ''; ?>" type="button" data-preview-category="<?php echo esc_attr($category['slug']); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"><?php echo esc_html($category['name']); ?></button>
		<?php endforeach; ?>
	</nav>
<?php else :
	$categories = get_categories(['taxonomy' => 'category', 'hide_empty' => true]);
	$all_active = is_front_page() && !is_category();
?>
	<nav class="category-filters" aria-label="<?php esc_attr_e('Danh mục bài viết', 'voxa-media'); ?>">
		<a class="category-filter<?php echo $all_active ? ' is-active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>"<?php echo $all_active ? ' aria-current="page"' : ''; ?>><?php esc_html_e('Tất cả', 'voxa-media'); ?></a>
		<?php foreach ($categories as $category) : $active = is_category($category->term_id); ?>
			<a class="category-filter<?php echo $active ? ' is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($category->term_id)); ?>"<?php echo $active ? ' aria-current="page"' : ''; ?>><?php echo esc_html($category->name); ?></a>
		<?php endforeach; ?>
	</nav>
<?php endif; ?>
