<?php
/**
 * Group announcement module
 */

$group = elgg_get_page_owner_entity();

if ($group->announcements_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "/announcements/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'title' => elgg_echo('announcements:group') . ', ' . elgg_echo('link:view:all'),
));

$header = "<span class=\"groups-widget-viewall\">$all_link</span>";
$header .= '<h3>' . elgg_echo('announcements:group') . '</h3>';


elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'announcement',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('announcements:none') . '</p>';
}

//if ($group->canWriteToContainer(0, 'object', 'announcement')) {
if ($group->canEdit()) {
	$new_link = elgg_view('output/url', array(
		'href' => "/announcements/add/$group->guid",
		'text' => elgg_echo('announcement:write'),
		'title' => elgg_echo('announcements:group') . ', ' . elgg_echo('announcement:write'),
	));
	//$content .= "<span class='elgg-widget-more'>$new_link</span>";
} else $new_link = '';


echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('announcements:group'),
	'class' => 'elgg-module-group-announcements',
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
//echo elgg_view_module('info', elgg_echo('announcements:group'), $content, array('header' => $header));

