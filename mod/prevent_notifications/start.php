<?php
/**
 * prevent_notifications
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
	
	/* Hook pour bloquer les notifications si on a demandé à les désactiver
	 * - load at first, because we want to block the process early, if it needs to be blocked
	 * - method: prevent enqueuing into notification queue, so we don't have to imagine complex tricks to block notification afterwards
	 */
	elgg_register_plugin_hook_handler('enqueue', 'notification', 'prevent_notifications_enqueue_notification', 1);
	
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


/* Prevents sending a notification
* @return bool $notify : enqueue event (to send a notification through next cron)
 */
function prevent_notifications_enqueue_notification($hook, $type, $notify, $params) {
	$send_notification = get_input('send_notification', 'yes');
	$entity = $params['object'];
	//error_log("ADD TO QUEUE => $send_notification => {$entity->guid} / {$entity->title}");
	if ($send_notification == 'no') {
		// Do not notify only if explicitely asked to block
		if (!elgg_in_context('cron')) {
			$msg = elgg_echo('prevent_notifications:notsent');
			system_message($msg);
		}
		return false;
	}
	// Don't change default behaviour
	return $notify;
}


