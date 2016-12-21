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


// Ordre des outils dans le groupe (modules)
echo '<fieldset><legend>' . elgg_echo('esope:grouptools:priority') . '</legend>';
$views = elgg_get_config('views');
$tools = $views->extensions['groups/tool_latest'];
foreach ($tools as $priority => $view) {
	if ($view != 'groups/tool_latest') {
		echo '<p><label>';
		echo elgg_view('input/text', array(
			'name' => "params[tools:$view]",
			'value' => $priority,
			'style' => 'width:4em;',
		));
		echo ' ' . $view;
		echo '</label></p>';
	}
}
echo '</fieldset>';


// Ordre des outils dans le menu d'édition (@TODO et dans le menu latéral ?)
echo '<fieldset><legend>' . elgg_echo('esope:grouptools:priority:menu') . '</legend>';
$tools = elgg_get_config("group_tool_options");
// Sort and init priority list
$group_options = array();
foreach ($tools as $k => $obj) {
	$option_name = $obj->name;
	$priority = elgg_get_plugin_setting("options:$option_name", 'groups');
	if (!$priority) { $priority = ($k + 1) * 10; }
	// Ensure no entry will be skipped because of equal priority!
	while (isset($group_options[$priority])) { $priority++; }
	$group_options[$priority] = $obj;
}
ksort($group_options);
foreach ($group_options as $priority => $group_option) {
	echo '<p><label>';
	echo elgg_view('input/text', array(
		'name' => "params[options:{$group_option->name}]",
		'value' => $priority,
		'style' => 'width:4em;',
	));
	echo ' ' . $group_option->label;
	echo '</label></p>';
}
echo '</fieldset>';

echo '<div class="clearfloat"></div>';

