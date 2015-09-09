<?php
/**
 * Group thewire module
 */

$group = elgg_get_page_owner_entity();
if (!($group->isMember() || elgg_is_admin_logged_in())) { return; }

$add_wire = elgg_get_plugin_setting('groups_add_wire', 'adf_public_platform');
switch ($add_wire) {
	case 'yes': break; 
	case 'groupoption':
		if ($group->thewire_enable != 'yes') return;
		break; 
	default: return;
}

/*
$all_link = elgg_view('output/url', array(
	'href' => "thewire/group/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'title' => elgg_echo('esope:thewire:group:title') . ', ' . elgg_echo('link:view:all'),
	'is_trusted' => true,
));
*/

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'thewire',
	'container_guid' => $group->guid,
	'limit' => 6,
	'full_view' => false,
	'pagination' => true,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('esope:thewire:none') . '</p>';
}


echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('esope:thewire:group:title'),
	'content' => $content,
	//'class' => 'elgg-module-group-thewire',
	//'all_link' => $all_link,
));

