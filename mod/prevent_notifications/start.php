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
	
	elgg_extend_view('css', 'prevent_notifications/css');
	
	// Hook pour bloquer les notifications si on a demandé à les désactiver
	// Note : load at first, because we want to block the process early, if it needs to be blocked
	elgg_register_plugin_hook_handler('enqueue', 'notification', 'prevent_notifications_enqueue_notification');
	
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


function prevent_notifications_enqueue_notification($hook, $type, $result, $params) {
	$send_notification = get_input('send_notification', 'yes');
	$entity = $params['object'];
	//error_log("PREVENT QUEUE => $send_notification");
	if ($send_notification == 'no') {
		// Do not notify if explicitely asked to
		$msg = elgg_echo('prevent_notifications:notsent');
		system_message($msg);
		return false;
	}
	// Don't change default behaviour
	return $result;
}


