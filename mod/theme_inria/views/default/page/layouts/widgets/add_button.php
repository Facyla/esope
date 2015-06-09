<?php
/**
 * Button area for showing the add widgets panel
 */
?>
<div class="elgg-widget-add-control">
<?php
	if (elgg_in_context('dashboard')) $text =  elgg_echo('theme_inria:widgets:add:home');
	else $text =  elgg_echo('theme_inria:widgets:add:profile');
	echo elgg_view('output/url', array(
		'href' => '#widgets-add-panel',
		'text' => '<i class="fa fa-cog"></i> ' . $text,
		'class' => 'iris-add-button',
		'rel' => 'toggle',
	));
?>
</div>

