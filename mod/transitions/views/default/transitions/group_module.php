<?php
/**
 * Group transitions module
 */

$group = elgg_get_page_owner_entity();

if ($group->transitions_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "transitions/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'transitions',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('transitions:none'),
	'distinct' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

$new_link = elgg_view('output/url', array(
	'href' => "transitions/add/$group->guid",
	'text' => elgg_echo('transitions:write'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('transitions:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
