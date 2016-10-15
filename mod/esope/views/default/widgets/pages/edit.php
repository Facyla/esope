<?php
/**
 * Elgg pages widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;


// set default value
if (!isset($vars['entity']->pages_num)) {
	$vars['entity']->pages_num = 4;
}

$params = array(
	'name' => 'params[pages_num]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->pages_num,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$select = elgg_view('input/select', $params);

?>
<div>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('pages:num'); ?>:</label>
	<?php echo $select; ?>
</div>
