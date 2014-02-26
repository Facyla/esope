<?php

$page_owner = elgg_get_page_owner_entity();
$title = elgg_echo('au_subgroups:subgroups');
echo elgg_pop_context();
elgg_set_context('au_subgroups');

// set up breadcrumb navigation
au_subgroups_parent_breadcrumbs($page_owner);
elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());
elgg_push_breadcrumb(elgg_echo('au_subgroups:subgroups'));

//$content = au_subgroups_list_subgroups($page_owner, 10, true);
// List subgroups : filtering by grouptype added
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
		$display_accordion = true;
		$content .= '<script type="text/javascript">';
		$content .= "$(function() {
			$('#subgroups-{$group->guid}-accordion').accordion({ header: 'h3', autoHeight: false });
		});";
		$content .= '</script>';
	}
	$content .= '<div id="subgroups-' . $group->guid . '-accordion">';
	foreach ($subgroups as $grouptype => $groups) {
		if (count($groups) > 0) {
			if ($display_accordion) {
				$content .= '<h3>' . elgg_echo('grouptype:' . $grouptype) . ' (' . count($groups) . ')</h3>';
			}
			elgg_push_context('widgets');
			$content .= '<div>' . elgg_view_entity_list($groups, array('full_view' => false)) . '</div>';
			elgg_pop_context();
		}
	}
	$content .= '</div>';
	
} else {
	$content = '<p>' . elgg_echo('au_subgroups:nogroups') . '</p>';
}
elgg_push_context('au_subgroups');

$body = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $content,
		'filter' => false
	));

echo elgg_view_page($title, $body);
