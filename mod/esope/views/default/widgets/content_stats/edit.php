<?php
/**
 * Content statistics widget edit view
 */

$widget_id = $vars['entity']->guid;

$num_display = sanitize_int($vars['entity']->num_display, false);
// set default value for display number
if (!$num_display) {
	$num_display = 8;
}

$params = array(
	'name' => 'params[num_display]',
	'id' => 'num_display_'.$widget_id,
	'value' => $num_display,
	'options' => array(5, 8, 10, 12, 15, 20),
);
$dropdown = elgg_view('input/select', $params);

?>
<p>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('widget:numbertodisplay'); ?>:</label>
	<?php echo $dropdown; ?>
</p>
