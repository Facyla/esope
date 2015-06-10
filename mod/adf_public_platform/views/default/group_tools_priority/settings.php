<?php
/* Nice piece of code from Ismayil Khayredinov 
 * from http://community.elgg.org/plugins/1520344/1.0/group-tools-priority
 * @name Group Tools Priority
 * @description Change the order of group tool modules
 * @author Ismayil Khayredinov (ismayil@arckinteractive.com)
 * @website http://www.arckinteractive.com/
 * @copyright ArckInteractive LLC
 * @license GNU General Public License version 2
*/
$views = elgg_get_config('views');
$tools = $views->extensions['groups/tool_latest'];
echo '<br /><h3>' . elgg_echo('adf_platform:grouptools:priority') . '</h3>';
foreach ($tools as $priority => $view) {
	if ($view != 'groups/tool_latest') {
		echo '<label>';
		echo elgg_view('input/text', array('name' => "params[tools:$view]", 'value' => $priority, 'style' => "width:4ex;"));
		echo ' ';
		echo $view;
		echo '</label></br />';
	}
}

// Facyla : Also allow to reorder group options in group edit form
echo '<br /><h3>' . elgg_echo('adf_platform:groupoptions:priority') . '</h3>';
//echo print_r($vars['entity'], true);
$tools_options = elgg_get_config('group_tool_options');
//echo '<pre>' . print_r($tools_options, true) . '</pre>';
//echo '<pre>' . print_r($tools_options, true) . '</pre>';
// 1. Sort array using priority settings
$group_options = array();
foreach ($tools_options as $k => $obj) {
	$name = $obj->name;
	$priority = $vars["entity"]->{"options:$name"};
	if (!$priority) $priority = ($k + 1) * 10;
	$group_options[$priority] = $obj;
}
ksort($group_options);
// 2. Display options in proper order
foreach ($group_options as $priority => $obj) {
	$name = $obj->name;
	// Set default values
	echo '<label>';
	echo elgg_view('input/text', array('name' => "params[options:$name]", 'value' => $priority, 'style' => "width:4ex;"));
	echo ' ';
	echo $name . '&nbsp;: "' . $obj->label . '"';
	echo '</label></br />';
}


