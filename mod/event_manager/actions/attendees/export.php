<?php
$guid = (int) get_input("guid");
$rel = get_input("rel", EVENT_MANAGER_RELATION_ATTENDING);

$event = false;

if ($entity = get_entity($guid)) {
	if ($entity->getSubtype() == Event::SUBTYPE) {
		$event = $entity;
	}
}

if ($event && $event->canEdit()) {
	header("Content-Type: text/csv");
	header("Content-Disposition: Attachment; filename=export.csv");
	header('Pragma: public');

	echo event_manager_export_attendees($event, $rel);
	exit;
} else {
	register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
	forward(REFERER);
}
