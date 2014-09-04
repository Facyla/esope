<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 

$group = $vars['entity'];

// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';

// ESOPE : disable widget tools if asked too
$disable_widgets = false;
$disable_group_widgets = elgg_get_plugin_setting('groups_disable_widgets', 'adf_public_platform');
if (elgg_is_logged_in()) {
	if (in_array($disable_group_widgets, array('yes', 'both', 'loggedin'))) { $disable_widgets = true; }
} else {
	if (in_array($disable_group_widgets, array('yes', 'both', 'public'))) { $disable_widgets = true; }
}
if (!$disable_widgets) {
	// enable tools to extend this area
	echo elgg_view("groups/tool_latest", $vars);
}

// backward compatibility
$right = elgg_view('groups/right_column', $vars);
$left = elgg_view('groups/left_column', $vars);
if ($right || $left) {
	elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
	echo $left;
	echo $right;
}

echo "</ul>";


// Add group activity or group content
// ESOPE : add activity if asked
echo elgg_view('groups/profile/activity', $vars);


