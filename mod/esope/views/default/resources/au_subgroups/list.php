<?php

namespace AU\SubGroups;

$page_owner = elgg_get_page_owner_entity();
$title = elgg_echo('au_subgroups:subgroups');
elgg_set_context('au_subgroups');

// set up breadcrumb navigation
parent_breadcrumbs($page_owner);
elgg_push_breadcrumb($page_owner->name, $page_owner->getURL());
elgg_push_breadcrumb(elgg_echo('au_subgroups:subgroups'));

//$content = list_subgroups($page_owner, 10);
// ESOPE : List subgroups, sorted by grouptype (if any)
$content = '';
$subgroups = get_subgroups($page_owner, 0);
if ($subgroups) {
	$subgroups = esope_sort_groups_by_grouptype($subgroups);
	$display_grouptypes = false;
	if (count($subgroups) > 1) {
		$display_grouptypes = true;
		/* No need for accordion in full page listing !
		$content .= '<script type="text/javascript">';
		$content .= "$(function() {
			$('#subgroups-{$page_owner->guid}-accordion').accordion({ header: 'h3', autoHeight: false });
		});";
		$content .= '</script>';
		*/
	}
	//$content .= '<div id="subgroups-' . $page_owner->guid . '-accordion">';
	$content .= '<div id="subgroups-' . $page_owner->guid . '">';
	foreach ($subgroups as $grouptype => $groups) {
		if (count($groups) > 0) {
			if ($display_grouptypes) {
				$content .= '<h3>' . elgg_echo('grouptype:' . $grouptype) . ' (' . count($groups) . ')</h3>';
			}
			elgg_push_context('widgets');
			$content .= '<div>' . elgg_view_entity_list($groups, array('full_view' => false)) . '</div>';
			//$content .= '<div>' . elgg_list_entities(array('entities' => $groups, 'full_view' => false)) . '</div>';
			elgg_pop_context();
		}
	}
	$content .= '</div>';
}


if (!$content) {
  $content = elgg_echo('au_subgroups:nogroups');
}

$body = elgg_view_layout('content', array(
    'title' => $title,
    'content' => $content,
    'filter' => false
));

echo elgg_view_page($title, $body);
