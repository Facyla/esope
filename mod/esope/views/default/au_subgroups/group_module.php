<?php

namespace AU\SubGroups;

/**
 * Group blog module
 */

$group = elgg_get_page_owner_entity();

// ESOPE : require explicit enabling
//if ($group->subgroups_enable == "no") {
if ($group->subgroups_enable != "yes") {
	return true;
}

$all_link = '';

// ESOPE : Anyone should be able to view existing subgroups, if allowed - not only group admins
//if ($group->canEdit()) {
	$all_link = elgg_view('output/url', array(
		'href' => "groups/subgroups/{$group->guid}/all",
		'text' => elgg_echo('link:view:all'),
		'is_trusted' => true,
	));
//}

elgg_push_context('widgets');
//$content = list_subgroups($group, 10);
// ESOPE : List subgroups : filtering by grouptype added
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
	$subgroups = esope_sort_groups_by_grouptype($subgroups);
	if (count($subgroups) < 2) { $display_accordion = false; } else {
		$display_accordion = true;
		$content .= '<script type="text/javascript">';
		$content .= "$(function() {
			$('#subgroups-{$group->guid}-accordion').accordion({ header: 'h4', autoHeight: false });
		});";
		$content .= '</script>';
	}
	$content .= '<div id="subgroups-' . $group->guid . '-accordion">';
	foreach ($subgroups as $grouptype => $groups) {
		if (count($groups) > 0) {
			$content .= '<h4>' . elgg_echo('grouptype:' . $grouptype) . ' (' . count($groups) . ')</h4>';
			$content .= '<div>' . elgg_view_entity_list($groups, array('full_view' => false)) . '</div>';
		}
	}
	$content .= '</div>';
}
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('au_subgroups:nogroups') . '</p>';
}

//$any_member = ($group->subgroups_members_create_enable != 'no');
// ESOPE : require explicit authorisation
$any_member = ($group->subgroups_members_create_enable == 'yes');
 if (($any_member && $group->isMember()) || $group->canEdit()) {
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
