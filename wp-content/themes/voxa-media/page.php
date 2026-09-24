<?php
/** @package VOXA_Media */
get_header();
?>
<main id="main-content" class="site-main blog-main article-page page-content">
	<?php while (have_posts()) : the_post(); ?>
		<article <?php post_class('article'); ?>>
			<header class="article__header">
				<p class="eyebrow">VOXA · MEDIA</p>
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="prose article__content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
