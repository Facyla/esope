<?php

namespace AU\RSSImport;

//get our defaults
$container_guid = $vars['container_guid'];
$container = get_entity($container_guid);
if (!$container) {
	return;
}

$rssimport = get_entity($vars['guid']);
$import_into = $vars['import_into'];


// make sure we're the owner if selecting a feed
if ($rssimport instanceof RSSImport && !$rssimport->canEdit()) {
	register_error(elgg_echo('rssimport:not:owner'));
	forward(REFERRER);
}

// set up breadcrumbs
$urlsuffix = 'owner/' . $container->username;
$name = $container->username;
if ($container instanceof \ElggGroup) {
	RSSImport::groupGatekeeper($container, $import_into);
	$urlsuffix = 'group/' . $container->guid . '/all';
	$name = $container->name;
}

$url = elgg_get_site_url() . "{$import_into}/{$urlsuffix}";

// push original context
elgg_push_breadcrumb(elgg_echo($import_into), $url);
elgg_push_breadcrumb(elgg_echo('rssimport:import'), "rssimport/{$container->guid}/{$import_into}");

if ($rssimport) {
	elgg_push_breadcrumb($rssimport->title);
}

// set the title
$title = elgg_echo('rssimport:title');
$subtitle = elgg_echo("rssimport:import:title", array($container->name, elgg_echo($import_into)));

$body = elgg_view_form('rssimport/edit', array(), array(
	'entity' => $rssimport,
	'import_into' => $import_into,
	'container_guid' => $container_guid
));


$body .= "<hr><br>";

if ($rssimport) {
	// Begin showing our feed
	$feed = $rssimport->getFeed();

	$body .= elgg_view('rssimport/feedcontrol', array('entity' => $rssimport, 'feed' => $feed));

	//Display each item
	$importablecount = 0;
	foreach ($feed->get_items() as $item) {
		if (!$rssimport->isAlreadyImported($item)) {
			$importablecount++;

			$blacklisted = false;
			if ($rssimport->isBlacklisted($item)) {
				$importablecount--;
				$blacklisted = true;
			}

			$body .= elgg_view('rssimport/feeditem', array(
				'entity' => $rssimport,
				'blacklisted' => $blacklisted,
				'item' => $item
			));
		}
	}
}


$content = elgg_view_module('main', $subtitle, $body);

// get the sidebar
$sidebar = elgg_view('rssimport/sidebar', array(
	'container_guid' => $container_guid,
	'import_into' => $import_into
));

$layout = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $content,
	'sidebar' => $sidebar
));

// display the page
echo elgg_view_page($title, $layout);
