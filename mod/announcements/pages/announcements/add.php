<?php
/**
 * Add announcement page
 *
 * @package Announcements
 */

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('announcements:add');
elgg_push_breadcrumb($title);

$announcement = new ElggAnnouncement();
$announcement->container_guid = elgg_get_page_owner_guid();

$vars = array(
	'entity' => $announcement,
);
$content = elgg_view_form('announcements/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '', 
	'buttons' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);