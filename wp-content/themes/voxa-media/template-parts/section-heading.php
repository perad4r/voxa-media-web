<?php
/** Reusable editorial section heading. */
$heading = wp_parse_args($args ?? [], [
	'eyebrow' => '',
	'title' => '',
	'level' => 'h2',
	'id' => '',
	'note' => '',
]);
$heading_tag = in_array($heading['level'], ['h1', 'h2', 'h3'], true) ? $heading['level'] : 'h2';
?>
<div class="editorial-section-heading">
	<?php if ($heading['eyebrow'] !== '') : ?><p class="eyebrow"><?php echo esc_html($heading['eyebrow']); ?></p><?php endif; ?>
	<<?php echo esc_attr($heading_tag); ?><?php if ($heading['id'] !== '') : ?> id="<?php echo esc_attr($heading['id']); ?>"<?php endif; ?>><?php echo esc_html($heading['title']); ?></<?php echo esc_attr($heading_tag); ?>>
	<?php if ($heading['note'] !== '') : ?><p class="editorial-section-heading__note"><?php echo esc_html($heading['note']); ?></p><?php endif; ?>
</div>
