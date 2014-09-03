<?php
/**
 * Group profile fields
 */

$group = $vars['entity'];

$profile_fields = elgg_get_config('group');

// Exclude some fields from being viewed
$hide_fields = array('customtab1', 'customtab2', 'customtab3', 'customtab4', 'customtab5', 'customtab6', 'customtab7', 'customtab8', 'cmisfolder', 'feed_url', 'customcss');
// Trigger hook to allow modifying/adding to the list (should return a modified returnvalue)
$hide_fields = elgg_trigger_plugin_hook('groups:profile:hide', 'fields', array(), $hide_fields);

if (is_array($profile_fields) && count($profile_fields) > 0) {

	$even_odd = 'odd';
	foreach ($profile_fields as $key => $valtype) {
		// do not show the name
		if ($key == 'name') {
			continue;
		}
		
		// Skip excluded fields
		if (in_array($key, $hide_fields)) { continue; }
		
		$value = $group->$key;
		if (!is_array($value)) $value = trim($value);
		if (empty($value)) { continue; }

		$options = array('value' => $group->$key);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

		echo "<div class=\"{$even_odd}\">";
		echo "<strong>";
		echo elgg_echo("groups:$key");
		echo ": </strong>";
		echo elgg_view("output/$valtype", $options);
		echo "</div>";

		$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
	}
}

