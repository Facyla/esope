<?php
/**
 * prevent_notificationss
 *
 */

elgg_register_event_handler('init', 'system', 'prevent_notifications_init'); // Init

// @TODO : add a more flexible way to add prevent field to forms, 
// using e.g. forms extension + objects registered for notifications


/**
 * Init prevent_notifications plugin.
 */
function prevent_notifications_init() {
	global $CONFIG;
	
	elgg_extend_view('css', 'prevent_notifications/css');
	
	// Hook pour bloquer les notifications si on a demandé à les désactiver
	// Note : load at first, because we want to block the process early, if it needs to be blocked
	// See html_email_handler :
	// Facyla : warning, if a plugin hook returned "true" (e.g. for blocking notification process), this won't be handled, so we should check it before going through the whole process !!
	elgg_register_plugin_hook_handler('object:notifications', 'all', 'prevent_notifications_object_notifications_disable', 1);
	
	
	// Add new field to eligible forms
	// This is not solid enough yet to rely on these, so keep the basic method until we find a better way
	// Main limits : can't tell between new objects and edits + forms name changes between objects types
	/*
	//$registered_objects = $CONFIG->register_objects['object'];
	$registered_objects = array('event_calendar');
	foreach ($registered_objects as $subtype) {
		elgg_extend_view("forms/$subtype/edit", 'prevent_notifications/prevent_notifications_extend');
		elgg_extend_view("forms/$subtype/save", 'prevent_notifications/prevent_notifications_extend');
		// This approach allows to insert the prevent box more easily before the submit button 
		// but is less reliable (as it relies only on context)
		//elgg_extend_view("input/submit", 'prevent_notifications/prevent_notifications_extend', 300);
	}
	*/
}

function prevent_notifications_object_notifications_disable($hook, $entity_type, $returnvalue, $params) {
	$send_notification = get_input('send_notification', 'yes');
	if ($send_notification == 'no') {
		// Don't notify if explicitely asked to
		$msg = elgg_echo('prevent_notifications:notsent');
		system_message($msg);
		return true;
	}
	// Don't change default behaviour
	return $returnvalue;
}



