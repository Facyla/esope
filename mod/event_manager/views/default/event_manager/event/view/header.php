<?php

$event = elgg_extract('entity', $vars);
if (!$event instanceof \Event) {
	return;
}

$header = elgg_view('event_manager/event/view/datetime', $vars);
$header .= elgg_format_element('div', ['class' => 'event-manager-view-rsvp'], elgg_view('event_manager/event/rsvp', $vars));

$header = elgg_format_element('div', ['class' => 'event-manager-view-registration'], $header);
$header .= elgg_view('event_manager/event/view/registration', $vars);

$body = elgg_format_element('div', ['class' => 'event-manager-header'], $header);

echo elgg_view_module('event', '', $body, ['class' => 'event-header']);
