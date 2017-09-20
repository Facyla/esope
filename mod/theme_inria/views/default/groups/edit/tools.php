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

//Iris v2 : workspaces
$translation_prefix = '';
$parent_group = elgg_extract("au_subgroup_of", $vars);
//if ($parent_group) { $translation_prefix = 'workspace:'; }

$tools = elgg_get_config("group_tool_options");
if ($tools) {
	usort($tools, create_function('$a,$b', 'return strcmp($a->label,$b->label);'));
	// Enable alternate (custom) sort
	// Sort options using priority settings, rather that alpha
	

/*
$views = elgg_get_config('views');
$tools = $views->extensions['groups/tool_latest'];
echo '<br /><p>' . elgg_echo($translation_prefix.'esope:grouptools:priority') . '</p>';
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
	
	// Iris v2
	// Si groupe
	if (!$parent_group) {
		echo elgg_view('input/hidden', array('name' => 'subgroups_enable', 'value' => 'yes'));
	} else {
		echo elgg_view('input/hidden', array('name' => 'subgroups_enable', 'value' => 'no'));
	}
	
	//foreach ($tools as $group_option) {
	foreach ($group_options as $group_option) {
		$group_option_toggle_name = $group_option->name . "_enable";
		
		// Iris v2 : options forcées
		// Si groupe
		if (!$parent_group) {
			if (in_array($group_option_toggle_name, array('subgroups_enable'))) {
				echo elgg_view('input/hidden', array('name' => $group_option_toggle_name, 'value' => 'yes'));
				continue;
			}
		} else {
			// Si espace de travail
			if (in_array($group_option_toggle_name, array('subgroups_enable', 'subgroups_members_create_enable'))) {
				echo elgg_view('input/hidden', array('name' => $group_option_toggle_name, 'value' => 'no'));
				continue;
			}
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
		
		// Valeur actuelle
		if ($vars['entity']->$group_option_toggle_name) {
			$value = $vars['entity']->$group_option_toggle_name;
		} else {
			$value = $group_option_default_value;
		}
		
		// Iris v2 : Options toujours forcées
		//if (in_array($group_option_toggle_name, array('file_enable', 'forum_enable', 'thewire_enable'))) {
		if (in_array($group_option_toggle_name, array('file_enable', 'blog_enable'))) {
			$attrs = array('class' => 'groups-edit-checkbox');
			$title = elgg_echo($translation_prefix."groups:tools:$group_option->name:details");
			if ($title != "groups:tools:$group_option->name:details") { $attrs['title'] = $title; }
			echo elgg_view('input/hidden', array('name' => $group_option_toggle_name, 'value' => 'yes'));
			/*
			echo elgg_format_element('div', $attrs, elgg_view('input/checkbox', array(
				'name' => $group_option_toggle_name,
				'value' => 'yes',
				'default' => 'yes',
				'checked' => true,
				'label' => $group_option->label,
				'disabled' => true,
			)));
			*/
			continue;
		}
		// Forum : on désactive s'il n'y en a plus - mais on laisse le choix tant qu'il reste du contenu
		if ($group_option_toggle_name == 'forum_enable') {
			$existing_topic = elgg_get_entities(array('type' => 'object', 'subtype' => 'groupforumtopic', 'container_guid' => $group->guid, 'count' => true));
			if ($existing_topic === 0) {
				// Can be safely disabled
				echo elgg_format_element('div', $attrs, elgg_view('input/checkbox', array(
					'name' => $group_option_toggle_name,
					'value' => 'no',
					'default' => 'no',
					'checked' => false,
					'label' => $group_option->label,
					'disabled' => true,
				)));
				continue;
			}
		}
		
		// Esope : add help title if set
		$attrs = array('class' => 'groups-edit-checkbox');
		$title = theme_inria_get_translation($translation_prefix."groups:tools:$group_option->name:details");
		$hint = '';
		if (!empty($title)) {
			//$attrs['title'] = $title;
			$hint = '<span class="custom_fields_more_info" id="more_info_' . $group_option_toggle_name . '"></span>';
			$hint .= '<span class="hidden" id="text_more_info_' . $group_option_toggle_name . '">' . $title . '</span>';
		}
		echo elgg_format_element('div', $attrs, elgg_view('input/checkbox', array(
			'name' => $group_option_toggle_name,
			'value' => 'yes',
			'default' => 'no',
			'checked' => ($value === 'yes') ? true : false,
			'label' => $group_option->label . $hint,
		)));
	}
}

