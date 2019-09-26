<?php
/**
 * Register classes for ElggObject subtypes on plugin activation
 */

$classes = array(
	'Event',
	'\ColdTrick\EventManager\Event\Day',
	'\ColdTrick\EventManager\Event\Slot',
	'EventRegistrationQuestion',
	'EventRegistration',
);

foreach ($classes as $class) {
	if (get_subtype_id('object', $class::SUBTYPE)) {
		update_subtype('object', $class::SUBTYPE, $class);
	} else {
		add_subtype('object', $class::SUBTYPE, $class);
	}
}
