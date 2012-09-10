<?php
/**
 * Elgg group widget edit view
 *
 * @package ElggGroups
 */

$widget_id = $vars['entity']->guid;


// set default value
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 4;
}

$params = array(
	'name' => 'params[num_display]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 20),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<div>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('group:widget:num_display'); ?>:</label>
	<?php echo $dropdown; ?>
</div>
