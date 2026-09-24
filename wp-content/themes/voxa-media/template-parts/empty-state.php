<?php
/** Reusable no-content and no-results message. */
$empty = wp_parse_args($args ?? [], [
	'title' => '',
	'text' => '',
	'link_url' => '',
	'link_label' => '',
]);
?>
<section class="empty-state" aria-live="polite">
	<span class="empty-state__mark" aria-hidden="true">V.</span>
	<h2><?php echo esc_html($empty['title']); ?></h2>
	<?php if ($empty['text'] !== '') : ?><p><?php echo esc_html($empty['text']); ?></p><?php endif; ?>
	<?php if ($empty['link_url'] !== '' && $empty['link_label'] !== '') : ?><a class="editorial-action" href="<?php echo esc_url($empty['link_url']); ?>"><?php echo esc_html($empty['link_label']); ?><span aria-hidden="true"> →</span></a><?php endif; ?>
</section>
