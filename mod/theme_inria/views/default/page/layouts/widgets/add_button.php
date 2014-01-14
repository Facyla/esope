<?php
/**
 * Button area for showing the add widgets panel
 */
?>
<div class="elgg-widget-add-control">
<?php
	echo elgg_view('output/url', array(
		'href' => '#widgets-add-panel',
		'text' => '<i class="fa fa-plus"></i> ' . elgg_echo('widgets:add'),
		'class' => 'iris-add-button',
		'rel' => 'toggle',
	));
?>
</div>

