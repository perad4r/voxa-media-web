<?php
/** @package VOXA_Media */
if (!is_main_site()) {
	locate_template('page-forum.php', true);
	return;
}

$preview_enabled = voxa_media_design_preview_enabled();
$current_page = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
$preview_content = $preview_enabled ? voxa_media_design_preview_content() : null;
$preview_articles = $preview_enabled ? $preview_content['articles'] : [];
$preview_featured = $preview_enabled ? $preview_content['featured'] : null;
$published = wp_count_posts('post');
$post_count = $preview_enabled ? (int) $preview_content['total'] : (int) ($published->publish ?? 0);

if (!$preview_enabled) {
	$feed = new WP_Query([
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => 7,
		'paged' => $current_page,
		'ignore_sticky_posts' => true,
	]);
}

get_header();
?>
<main id="main-content" class="site-main blog-main blog-home">
	<div class="editorial-shell"<?php echo $preview_enabled ? ' data-design-preview' : ''; ?>>
		<?php if ($preview_enabled) : ?>
			<p class="design-preview-notice" role="status"><strong><?php esc_html_e('Bản xem trước thiết kế', 'voxa-media'); ?></strong><span><?php esc_html_e('Dữ liệu và hình ảnh minh họa — chỉ hiển thị trên môi trường local.', 'voxa-media'); ?></span></p>
		<?php endif; ?>

		<header class="feed-header">
			<p class="eyebrow">VOXA · MEDIA / EDITORIAL</p>
			<div class="feed-header__title-row">
				<div>
					<h1><?php esc_html_e('Bài viết mới nhất', 'voxa-media'); ?></h1>
					<p class="feed-header__summary"><?php esc_html_e('Kiến thức, ứng dụng và câu chuyện về cách công nghệ tạo nên những cuộc trò chuyện tự nhiên hơn.', 'voxa-media'); ?></p>
					<?php if (!$preview_enabled && is_user_logged_in() && current_user_can('edit_posts')) : ?><a class="editorial-action" href="<?php echo esc_url(admin_url('post-new.php')); ?>"><?php esc_html_e('Viết bài mới', 'voxa-media'); ?> ↗</a><?php endif; ?>
				</div>
				<p class="feed-count"><span><?php esc_html_e('Tổng cộng', 'voxa-media'); ?></span><strong data-post-counter><?php echo esc_html(number_format_i18n($post_count)); ?></strong><span><?php esc_html_e('bài viết', 'voxa-media'); ?></span></p>
			</div>
		</header>

		<div class="feed-controls">
			<form class="editorial-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				<label class="screen-reader-text" for="editorial-search-input"><?php esc_html_e('Tìm kiếm bài viết', 'voxa-media'); ?></label>
				<input id="editorial-search-input" class="editorial-search__input" type="search" name="s" value="<?php echo $preview_enabled ? '' : esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Tìm kiếm bài viết, tiêu đề hoặc từ khóa kỹ thuật…', 'voxa-media'); ?>"<?php echo $preview_enabled ? ' data-preview-search' : ''; ?>>
				<button class="editorial-search__submit" type="submit"><?php esc_html_e('Tìm kiếm', 'voxa-media'); ?></button>
			</form>
			<?php get_template_part('template-parts/category-filters', null, ['preview' => $preview_enabled]); ?>
		</div>

		<?php if ($preview_enabled && $preview_featured) : ?>
			<section class="featured-section" aria-label="<?php esc_attr_e('Bài viết tiêu điểm', 'voxa-media'); ?>">
				<?php get_template_part('template-parts/featured-article', null, ['preview' => $preview_featured]); ?>
			</section>
		<?php elseif (!$preview_enabled && $current_page === 1 && $feed->have_posts()) : ?>
			<section class="featured-section" aria-label="<?php esc_attr_e('Bài viết tiêu điểm', 'voxa-media'); ?>">
				<?php $feed->the_post(); ?>
				<?php get_template_part('template-parts/featured-article', null, ['post_id' => get_the_ID()]); ?>
			</section>
		<?php endif; ?>

		<section class="feed-section" id="preview-articles" aria-labelledby="feed-section-heading">
			<?php get_template_part('template-parts/section-heading', null, [
				'eyebrow' => __('VOXA · MEDIA', 'voxa-media'),
				'title' => __('Danh mục bài đăng', 'voxa-media'),
				'id' => 'feed-section-heading',
				'note' => $preview_enabled ? __('TRANG 1 · ARCHIVE FEED', 'voxa-media') : sprintf(__('TRANG %s · ARCHIVE FEED', 'voxa-media'), number_format_i18n($current_page)),
			]); ?>

			<?php if ($preview_enabled) : ?>
				<div class="article-grid">
					<?php foreach ($preview_articles as $preview_article) : ?>
						<?php get_template_part('template-parts/article-card', null, ['preview' => $preview_article]); ?>
					<?php endforeach; ?>
				</div>
				<p class="preview-no-results" data-preview-no-results hidden><?php esc_html_e('Không tìm thấy bài viết phù hợp trong dữ liệu xem trước.', 'voxa-media'); ?></p>
			<?php elseif ($feed->have_posts()) : ?>
				<div class="article-grid">
					<?php while ($feed->have_posts()) : $feed->the_post(); ?>
						<?php get_template_part('template-parts/article-card'); ?>
					<?php endwhile; ?>
				</div>
			<?php else : ?>
				<?php get_template_part('template-parts/empty-state', null, [
					'title' => __('Bài viết đang được chuẩn bị', 'voxa-media'),
					'text' => __('Những nội dung đầu tiên sẽ xuất hiện tại đây. Trong lúc chờ, bạn có thể ghé thăm diễn đàn VOXA.', 'voxa-media'),
					'link_url' => voxa_media_site_url(2),
					'link_label' => __('Khám phá diễn đàn', 'voxa-media'),
				]); ?>
			<?php endif; ?>
		</section>

		<?php if ($preview_enabled) : ?>
			<nav class="preview-pagination" id="preview-pagination" aria-label="<?php esc_attr_e('Phân trang bài viết minh họa', 'voxa-media'); ?>">
				<p><?php esc_html_e('Hiển thị', 'voxa-media'); ?> <strong>1–7</strong> <?php esc_html_e('trong số', 'voxa-media'); ?> <strong><?php echo esc_html(number_format_i18n($post_count)); ?></strong> <?php esc_html_e('bài viết', 'voxa-media'); ?></p>
				<div class="preview-pagination__controls"><span class="preview-pagination__status"><?php esc_html_e('Trang 1 / 4', 'voxa-media'); ?></span><span class="page-number is-current" aria-current="page">1</span><span class="page-number" aria-disabled="true">2</span><span class="page-number" aria-disabled="true">3</span><span class="page-number" aria-disabled="true">4</span><span class="preview-pagination__next" aria-disabled="true"><?php esc_html_e('Tiếp theo', 'voxa-media'); ?> →</span></div>
			</nav>
		<?php elseif ($feed->max_num_pages > 1) : ?>
			<?php
			$pagination = paginate_links([
				'total' => (int) $feed->max_num_pages,
				'current' => $current_page,
				'type' => 'plain',
				'prev_text' => __('Trước', 'voxa-media'),
				'next_text' => __('Tiếp theo', 'voxa-media'),
			]);
			if ($pagination) {
				echo '<nav class="navigation pagination" aria-label="' . esc_attr__('Phân trang bài viết', 'voxa-media') . '"><div class="nav-links">' . wp_kses_post($pagination) . '</div></nav>';
			}
			?>
		<?php endif; ?>
	</div>
</main>
<?php
if (!$preview_enabled) {
	wp_reset_postdata();
}
get_footer();
