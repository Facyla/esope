<?php
/* Adds a Wire to the group (access reserved to group members)
*/
$group = elgg_get_page_owner_entity();

$add_wire = elgg_get_plugin_setting('groups_add_wire', 'adf_public_platform');
switch ($add_wire) {
	case 'yes': break; 
	case 'groupoption':
		if ($group->thewire_enable != 'yes') return;
		break; 
	default: return;
}

echo '<div class="theme_inria-thewire-group-add">';
	echo '<h3><a href="' . elgg_get_site_url() . 'thewire/group/' . $group->guid . '">' . elgg_echo('theme_inria:thewire:group:title') . '</a></h3>';
	
	$action = elgg_get_site_url() . "action/thewire/add";
	echo elgg_view_form('thewire/group_add', array('class' => 'thewire-form', 'action' => $action));
	
	echo elgg_view('input/urlshortener');
echo '</div>';

