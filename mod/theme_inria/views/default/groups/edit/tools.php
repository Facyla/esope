<?php

/**
 * Group edit form
 *
 * This view contains the group tool options provided by the different plugins
 *
 * @package ElggGroups
 */

// ESOPE : enable admin-controlled tools sorting + default settings

// may not be set yet
$group = $vars['entity'];

$tools = elgg_get_config("group_tool_options");
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	// Enable alternate (custom) sort
	// Sort options using priority settings, rather that alpha
	

/*
$views = elgg_get_config('views');
$tools = $views->extensions['groups/tool_latest'];
echo '<br /><p>' . elgg_echo('esope:grouptools:priority') . '</p>';
foreach ($tools as $priority => $view) {
	if ($view != 'groups/tool_latest') {
		echo '<label>' . $view . '</label>';
		echo elgg_view('input/text', array(
			'name' => "params[tools:$view]",
			'value' => $priority
		));
	}
}
*/
	
	
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
	
	//foreach ($tools as $group_option) {
	foreach ($group_options as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		
		// Iris v2 : force sous-groupe si pas de parent
		if (elgg_instanceof($group, 'group') && ($group_option_toggle_name == 'subgroups_enable') && elgg_is_active_plugin('au_subgroups') && (AU\SubGroups\get_parent_group($group))) {
			$group->$group_option_toggle_name = 'yes';
			continue;
		}
		//$value = elgg_extract($group_option_toggle_name, $vars);
		// Set tools to global default, or custom value
		$group_default_tools = elgg_get_plugin_setting('group_tools_default', 'esope');
		if (empty($group_default_tools) || ($group_default_tools == 'no')) {
			$group_option_default_value = 'no';
		} else if ($group_default_tools == 'yes') {
			$group_option_default_value = 'yes';
		} else {
			// Let the plugin decide by itself
			if ($group_option->default_on) {
				$group_option_default_value = 'yes';
			} else {
				$group_option_default_value = 'no';
			}
		}
		if ($vars['entity']->$group_option_toggle_name) {
			$value = $vars['entity']->$group_option_toggle_name;
		} else {
			$value = $group_option_default_value;
		}
		
		// Esope : add help title if set
		$attrs = array('class' => 'groups-edit-checkbox');
		$title = elgg_echo("groups:tools:$group_option->name:details");
		if ($title != "groups:tools:$group_option->name:details") { $attrs['title'] = $title; }
		echo elgg_format_element('div', $attrs, elgg_view('input/checkbox', array(
			'name' => $group_option_toggle_name,
			'value' => 'yes',
			'default' => 'no',
			'checked' => ($value === 'yes') ? true : false,
			'label' => $group_option->label,
		)));
	}
}

