<?php
/**
 * Online users widget edit view
 */

$widget_id = $vars['entity']->guid;


// set default value
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 8;
}

$params = array(
	'name' => 'params[num_display]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->num_display,
	'options' => array(5, 8, 10, 12, 15, 20),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<p>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('onlineusers:numbertodisplay'); ?>:</label>
	<?php echo $dropdown; ?>
</p>
