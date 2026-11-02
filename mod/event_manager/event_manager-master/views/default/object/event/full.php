<?php

$event = elgg_extract('entity', $vars);
if (!$event instanceof \Event) {
	return;
}

if ($event->owner_guid === elgg_get_logged_in_user_guid()) {
	$vars['class'] = elgg_extract_class($vars, 'event-manager-event-owner');
} elseif ($event->getRelationshipByUser()) {
	$vars['class'] = elgg_extract_class($vars, 'event-manager-event-attending');
}

$body = elgg_view('event_manager/event/view/header', $vars);
$body .= elgg_view('event_manager/event/view/description', $vars);
$body .= elgg_view('event_manager/program/view', $vars);
$body .= elgg_view('event_manager/event/view/contact_details', $vars);
$body .= elgg_view('event_manager/event/view/location', $vars);
$body .= elgg_view('event_manager/event/view/attendees', $vars);
$body .= elgg_view('event_manager/event/view/files', $vars);

$params = [
	'body' => $body,
	'show_summary' => true,
	'show_navigation' => false,
	'icon' => false,
];
$params = $params + $vars;

echo elgg_view('object/elements/full', $params);
