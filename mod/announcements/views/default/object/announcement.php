<?php
/**
 * View for announcement objects
 *
 * @package Announcement
 */

$full = elgg_extract('full_view', $vars, FALSE);
$announcement = elgg_extract('entity', $vars, FALSE);

if (!$announcement) {
	return TRUE;
}

$owner = $announcement->getOwnerEntity();
$container = $announcement->getContainerEntity();

if (elgg_get_page_owner_guid() == $announcement->container_guid) {
	$owner_icon = elgg_view_entity_icon($owner, 'small');
} else {
	$owner_icon = elgg_view_entity_icon($container, 'small');
}
$owner_link = elgg_view('output/url', array(
	'href' => "announcements/group/$container->guid/all",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($announcement->time_created);

$comments_count = $announcement->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $announcement->getURL() . '#announcement-comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'announcements',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "<p>$author_text $date $comments_link</p>";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {

	$body = elgg_view('output/longtext', array(
		'value' => $announcement->description,
		'class' => 'announcement-post',
	));

	$header = elgg_view_title($announcement->title);

	$params = array(
		'entity' => $announcement,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$list_body = elgg_view('page/components/summary', $params);

	$announcement_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$announcement_info
$body
HTML;

} else {
	// brief view

	$params = array(
		'entity' => $announcement,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$list_body = elgg_view('page/components/summary', $params);

	echo elgg_view_image_block($owner_icon, $list_body);
}
