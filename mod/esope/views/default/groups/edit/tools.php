<?php

/**
 * Group edit form
 *
 * This view contains the group tool options provided by the different plugins
 *
 * @package ElggGroups
 */

// ESOPE : enable admin-controlled tools sorting + default settings

$tools = elgg_get_config("group_tool_options");
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	// Enable alternate (custom) sort
	// Sort options using priority settings, rather that alpha
	$group_options = array();
	foreach ($tools as $k => $obj) {
		$option_name = $obj->name;
		$priority = elgg_get_plugin_setting("options:$option_name", 'groups');
		if (!$priority) $priority = ($k + 1) * 10;
		$group_options[$priority] = $obj;
	}
	ksort($group_options);
	
	//foreach ($tools as $group_option) {
	foreach ($group_options as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		//$value = elgg_extract($group_option_toggle_name, $vars);
		// Set tools to global default, or custom value
		$group_default_tools = elgg_get_plugin_setting('group_tools_default', 'esope');
		if (empty($group_default_tools) || ($group_default_tools == 'no')) {
			$group_option_default_value = 'no';
		} else if ($group_default_tools == 'yes') {
			$group_option_default_value = 'yes';
		} else {
			// Let the plugin decide by itself
			if ($group_option->default_on) { $group_option_default_value = 'yes'; } 
			else { $group_option_default_value = 'no'; }
		}
		$value = ($vars['entity']->$group_option_toggle_name) ? $vars['entity']->$group_option_toggle_name : $group_option_default_value;
		
		echo elgg_format_element('div', array(), elgg_view('input/checkbox', array(
			'name' => $group_option_toggle_name,
			'value' => 'yes',
			'default' => 'no',
			'checked' => ($value === 'yes') ? true : false,
			'label' => $group_option->label
		)));
	}
}
