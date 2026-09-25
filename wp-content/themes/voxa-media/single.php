<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main blog-main article-page">
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class('article'); ?>>
			<?php get_template_part('template-parts/blog-breadcrumbs'); ?>
			<header class="article__header">
				<p class="eyebrow"><?php echo wp_kses_post(get_the_category_list(' / ') ?: esc_html__('VOXA · MEDIA', 'voxa-media')); ?></p>
				<h1><?php the_title(); ?></h1>
				<?php get_template_part('template-parts/article-meta', null, ['author' => get_the_author(), 'date' => get_the_date(), 'datetime' => get_the_date('c')]); ?>
			</header>
			<?php if (has_post_thumbnail()) : ?><figure class="article__featured"><?php the_post_thumbnail('full', ['fetchpriority' => 'high']); ?></figure><?php endif; ?>
			<div class="prose article__content"><?php the_content(); ?></div>
			<?php wp_link_pages(['before' => '<nav class="page-links">' . esc_html__('Trang:', 'voxa-media'), 'after' => '</nav>']); ?>
			<footer class="article__footer"><a class="editorial-action" href="<?php echo esc_url(home_url('/')); ?>">← <?php esc_html_e('Quay lại bài viết', 'voxa-media'); ?></a></footer>
		</article>
		<?php if (comments_open() || get_comments_number()) : comments_template(); endif; ?>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
