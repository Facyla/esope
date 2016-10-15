<?php
/**
 * Group activity widget settings
 */

$widget_id = $vars['entity']->guid;

// once autocomplete is working use that
$groups = elgg_get_logged_in_user_entity()->getGroups(array('limit' => 0));
$mygroups = array();
if (!$vars['entity']->group_guid) {
	$mygroups[0] = '';
}
foreach ($groups as $group) {
	$mygroups[$group->guid] = $group->name;
}
$params = array(
	'name' => 'params[group_guid]',
	'id' => 'group_guid_'.$widget_id,
	'value' => $vars['entity']->group_guid,
	'options_values' => $mygroups,
);
$group_select = elgg_view('input/select', $params);
?>
<div>
	<label for="group_guid_<?php echo $widget_id; ?>"><?php echo elgg_echo('dashboard:widget:group:select'); ?>:
	<?php echo $group_select; ?>
</div>
<?php

// set default value for number to display
if (!isset($vars['entity']->num_display)) {
	$vars['entity']->num_display = 8;
}

$params = array(
	'name' => 'params[num_display]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->num_display,
	'options' => array(5, 8, 10, 12, 15, 20),
);
$num_select = elgg_view('input/select', $params);

?>
<div>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('widget:numbertodisplay'); ?>:</label>
	<?php echo $num_select; ?>
</div>

