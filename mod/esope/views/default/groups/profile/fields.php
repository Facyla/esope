<?php
/**
 * Group profile fields
 * Esope : allow to hide fields, and also labels
 */

$group = $vars['entity'];

$profile_fields = elgg_get_config('group');

// Esope : Exclude some fields from being viewed
$hide_fields = elgg_get_plugin_setting('group_hide_profile_field', 'esope');
if ($hide_fields) {
	$hide_fields = esope_get_input_array($hide_fields);
} else {
	$hide_fields = array('customtab1', 'customtab2', 'customtab3', 'customtab4', 'customtab5', 'customtab6', 'customtab7', 'customtab8', 'cmisfolder', 'feed_url', 'customcss');
}
// Also trigger hook to allow modifying/adding to the list in a more "computed" way
// Should return a modified returnvalue = array of fields names
$hide_fields = elgg_trigger_plugin_hook('groups:profile:hide', 'fields', array('entity' => $group), $hide_fields);

// Esope : allow to hide some labels
//$hide_labels = array('description', 'interests');
$hide_labels = array();

if (is_array($profile_fields) && count($profile_fields) > 0) {

	$even_odd = 'odd';
	foreach ($profile_fields as $key => $valtype) {
		// do not show the name
		if ($key == 'name') {
			continue;
		}
		
		// Skip other excluded fields
		if (in_array($key, $hide_fields)) { continue; }
		
		$value = $group->$key;
		if (is_null($value)) {
			continue;
		}
		if (!is_array($value)) { $value = trim($value); }

		$options = array('value' => $group->$key);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

		echo "<div class=\"{$even_odd}\">";
		if (!in_array($key, $hide_labels)) {
			echo "<strong>";
			echo elgg_echo("groups:$key");
			echo ": </strong>";
		}
		echo elgg_view("output/$valtype", $options);
		echo "</div>";

		$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
	}
}

