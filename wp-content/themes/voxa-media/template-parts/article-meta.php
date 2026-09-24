<?php
/** Shared editorial author and publication-date row. */
$meta = wp_parse_args($args ?? [], [
	'author' => '',
	'date' => '',
	'datetime' => '',
]);
?>
<div class="article-meta">
	<?php if ($meta['author'] !== '') : ?><span class="article-meta__author"><?php echo esc_html($meta['author']); ?></span><?php endif; ?>
	<?php if ($meta['date'] !== '') : ?><time class="article-meta__date" datetime="<?php echo esc_attr($meta['datetime']); ?>"><?php echo esc_html($meta['date']); ?></time><?php endif; ?>
</div>
