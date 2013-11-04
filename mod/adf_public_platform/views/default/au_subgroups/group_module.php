<?php
/**
 * Group blog module
 */

$group = elgg_get_page_owner_entity();

if ($group->subgroups_enable == "no") {
	return true;
}

$all_link = '';

// Anyone should view all subgroups, if allowed - not only group admins
//if ($group->canEdit()) {
	$all_link = elgg_view('output/url', array(
		'href' => "groups/subgroups/list/{$group->guid}",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
//}

// List subgroups : filtering by grouptype added
elgg_push_context('widgets');
//$content = au_subgroups_list_subgroups($group, 10);
$content = '';
$options = array(
		'types' => array('group'), 'limit' => $limit, 'full_view' => false, 'limit' => false, 
		'relationship' => AU_SUBGROUPS_RELATIONSHIP, 'relationship_guid' => $group->guid, 'inverse_relationship' => true,
	);
// Sort by title
$options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
$options['order_by'] = "g.name ASC";
$subgroups = elgg_get_entities_from_relationship($options);
if ($subgroups) {
	$subgroups = adf_platform_sort_groups_by_grouptype($subgroups);
	if (count($subgroups) < 2) { $display_accordion = false; } else {
		$display_accordion = false;
		$content .= '<script type="text/javascript">';
		$content .= "$(function() {
			$('#subgroups-{$group->guid}-accordion').accordion({ header: 'h4', autoHeight: false });
		});";
		$content .= '</script>';
	}
	$content .= '<div id="subgroups-' . $group->guid . '-accordion">';
	foreach ($subgroups as $grouptype => $groups) {
		if ($display_accordion) $content .= '<h4>' . elgg_echo('grouptype:' . $grouptype) . '</h4>';
		$content .= elgg_view_entity_list($groups, array('full_view' => false));
	}
	$content .= '</div>';
	elgg_pop_context();
	
} else {
	$content = '<p>' . elgg_echo('au_subgroups:nogroups') . '</p>';
}

if ($group->canEdit()) {
	$new_link = elgg_view('output/url', array(
		'href' => "groups/subgroups/add/$group->guid",
		'text' => elgg_echo('au_subgroups:add:subgroup'),
		'is_trusted' => true,
	));
}
else {
	$new_link = '';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('au_subgroups'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
