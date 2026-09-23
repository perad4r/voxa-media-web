<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main content-width article-page">
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class('article'); ?>>
			<header class="article__header"><p class="eyebrow"><?php echo wp_kses_post(get_the_category_list(' · ') ?: esc_html__('VOXA · MEDIA', 'voxa-media')); ?></p><h1><?php the_title(); ?></h1><div class="article__meta"><span><?php echo esc_html(get_the_date()); ?></span><span aria-hidden="true">·</span><span><?php echo esc_html(get_the_author()); ?></span></div></header>
			<?php if (has_post_thumbnail()) : ?><figure class="article__featured"><?php the_post_thumbnail('large'); ?></figure><?php endif; ?>
			<div class="prose article__content"><?php the_content(); ?></div>
			<?php wp_link_pages(['before' => '<nav class="page-links">' . esc_html__('Trang:', 'voxa-media'), 'after' => '</nav>']); ?>
			<footer class="article__footer"><a class="text-link" href="<?php echo esc_url(home_url('/')); ?>">← <?php esc_html_e('Quay lại bài viết', 'voxa-media'); ?></a></footer>
		</article>
		<?php if (comments_open() || get_comments_number()) : comments_template(); endif; ?>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
