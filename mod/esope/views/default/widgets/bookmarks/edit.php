<?php
/**
 * Elgg bookmark widget edit view
 *
 * @package Bookmarks
 */

$widget_id = $vars['entity']->guid;


// Number to display
if (!isset($vars['entity']->num_display)) { $vars['entity']->num_display = 4; }
$params = array(
	'name' => 'params[num_display]',
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$select = elgg_view('input/select', $params);

// Filter
$filter_params = array(
	'name' => 'params[filter]',
	'value' => $vars['entity']->filter,
	'options_values' => array(
		'mine' => elgg_echo('bookmarks:mine'), 
		'friends' => elgg_echo('bookmarks:friends'), 
		'mygroups' => elgg_echo('bookmarks:mygroups'), 
		'all' => elgg_echo('bookmarks:everyone'), 
	),
);
$filter_select = elgg_view('input/select', $filter_params);

?>
<p>
	<label><?php echo elgg_echo('bookmarks:numbertodisplay'); ?> <?php echo $select; ?></label>
</p>

<p>
	<label><?php echo elgg_echo('bookmarks:filter'); ?> <?php echo $filter_select; ?></label>
</p>

