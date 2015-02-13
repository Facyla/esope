<?php
/**
 * event_calendar_reminder plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'event_calendar_reminder_init');


/**
 * Init event_calendar_reminder plugin.
 */
function event_calendar_reminder_init() {
	
	// Register cron hook
	elgg_register_plugin_hook_handler('cron', 'daily', 'event_calendar_reminder_cron');
	
}


/* Cron tasks
 * Check upcoming events and send emails to registreed users
 */
function event_calendar_reminder_cron($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	elgg_set_context('cron');
	
	// Avoid any time limit while processing offers
	set_time_limit(0);
	access_show_hidden_entities(true);
	elgg_set_ignore_access(true);
	
	// Encode the name. If may content nos ASCII chars.
	$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
	$from = $from_name . ' <' . $CONFIG->site->email . '>';
	define('event_calendar_reminder_EMAIL_FROM', $from);
	
	$reminders = elgg_get_plugin_setting('reminder_days', 'event_calendar_reminder');
	$reminders = explode(',', $reminders);
	foreach ($reminders as $days) {
		// Get events that start N day from now (1 day means at least 1 day, and at most 1+1 days)
		// $days must be an int, and cannot be < 1
		$days = (int) trim($days);
		if ($days < 1) $days = 1;
		$start_ts = ($days -1 ) * 24*3600;
		$end_ts = $days * 24*3600;
		$events_options = array(
				'types' => 'object', 'subtypes' => 'event_calendar', 'limit' => 0,
				'metadata_name_value_pairs' => array(
					array('name' => 'start_date', 'value' => time() + $start_ts, 'operand' => '>'), 
					array('name' => 'start_date', 'value' => time() + $end_ts, 'operand' => '<='), 
				), 
			);
		$batch = new ElggBatch('elgg_get_entities_from_metadata', $events_options, 'event_calendar_reminder_cron_notify_subscribers', 1);
	}
	
	echo "Event calendar email reminder cron : done.";
}

// CRON : Send reminder email for obsoletes offers
function event_calendar_reminder_cron_notify_subscribers($event, $getter, $options) {
	global $CONFIG;
	elgg_load_library('elgg:event_calendar');
	
	// Get subscribers list
	$users = event_calendar_get_users_for_event($event->guid,0,0,false);
	
	// Debug
	echo '<p>' . $event->guid . ' : ' . $event->title . ' ' . date('d m Y', $event->start_date) . ' => ' . count($users) . '</p>';
	
	// Remove those who do not want notifications
	foreach ($users as $user) {
		// @TODO : add blocking usersetting (if admin setting enabled)
		if (false) continue;
		
		// @TODO : update subject and message
		$subject = 'Event reminder : ' . $event->title;
		$message = 'Your event ' . $event->title . ' will start on ' . elgg_get_friendly_time($event->start_time) . '.
		
		' . $event->brief_description . '
		
		Please check full information and venue on ' . $event->getURL() . '.';
		notify_user($user->guid, $CONFIG->site->guid, $subject, $message, NULL, 'email');
		
		/*
		// Encode the name. If may content nos ASCII chars.
		$to_name = "=?UTF-8?B?" . base64_encode($event->managername) . "?=";
		$to = $to_name . ' <' . $event->manageremail . '>';
		$html_message = html_email_handler_make_html_body($subject, $message);
		html_email_handler_send_email(array('from' => event_calendar_reminder_EMAIL_FROM, 'to' => $to, 'subject' => $subject, 'plaintext_message' => $message, 'html_message' => $html_message));
		*/
	}
	
}

// CRON : Archive old offers
function event_calendar_reminder_cron_archive($event, $getter, $options) {
	$event->followstate = 'archive';
	event_calendar_reminder_state_change($event, 'published');
}



