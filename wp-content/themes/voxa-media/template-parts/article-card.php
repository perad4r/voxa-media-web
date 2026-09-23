<article <?php post_class('article-card'); ?>>
	<a class="article-card__link" href="<?php the_permalink(); ?>">
		<?php if (has_post_thumbnail()) : ?><div class="article-card__image"><?php the_post_thumbnail('medium_large', ['loading' => 'lazy']); ?></div><?php endif; ?>
		<div class="article-card__body"><p class="article-card__meta"><?php echo esc_html(get_the_date()); ?><?php $categories = get_the_category(); if ($categories) : ?><span aria-hidden="true"> · </span><?php echo esc_html($categories[0]->name); endif; ?></p><h3><?php the_title(); ?></h3><p class="article-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p><span class="article-card__read"><?php esc_html_e('Đọc bài viết', 'voxa-media'); ?> <span aria-hidden="true">↗</span></span></div>
	</a>
</article>
