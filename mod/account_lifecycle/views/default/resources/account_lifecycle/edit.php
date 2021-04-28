<?php
/**
 * Main delivery modes page
 */

elgg_admin_gatekeeper();

$url = elgg_get_site_url();


// Main panel
$content = '';
$guid = get_input('guid');
$entity = get_entity($guid);
$content .= elgg_view_form('account_lifecycle/edit', [], ['entity' => $entity]);




// SIDEBAR
$sidebar = false;
//$sidebar .= '<div></div>';


// Sidebar droite
$sidebar_alt .= '';


$title = elgg_echo('account_lifecycle:edit');
if (!$entity instanceof ElggAccountLifeCycle) {
	$title = elgg_echo('account_lifecycle:add');
}

echo elgg_view_page($title, [
	'title' => $title,
	'content' =>  $content,
	'sidebar' => $sidebar,
	'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-chat-layout',
]);

