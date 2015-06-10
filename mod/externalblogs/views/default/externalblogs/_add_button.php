<?php
/**
 * Button area for showing the add widgets panel
 */
$context = $vars['context'];
?>
<div class="elgg-widget-add-control">
<?php
	echo elgg_view('output/url', array(
		'href' => '#widgets-add-panel_'.$context,
		'text' => elgg_echo("Personnaliser cette page"),
		'class' => 'elgg-button elgg-button-action',
		'rel' => 'toggle',
		'is_trusted' => true,
	));
?>
</div>
