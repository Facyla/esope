<?php

$user = elgg_get_page_owner_entity();

elgg_push_breadcrumb(elgg_echo('groups'), elgg_generate_url('collection:group:group:all'));

// build page elements
$title = elgg_echo('groups:invitations');

$content = elgg_call(ELGG_IGNORE_ACCESS, function() use ($user) {
	return elgg_list_relationships([
		'relationship' => 'invited',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => true,
		'no_results' => elgg_echo('groups:invitations:none'),
	]);
});

// build page
$body = elgg_view_layout('default', [
	'title' => $title,
	'content' => $content,
	'filter_id' => 'group:invitations',
	'filter_value' => 'invitations',
]);

// draw page
echo elgg_view_page($title, $body);
