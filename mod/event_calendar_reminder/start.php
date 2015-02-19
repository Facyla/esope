<?php
/**
 * event_calendar_reminder plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2015
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
 * Check upcoming events and send emails to registered users
 */
function event_calendar_reminder_cron($hook, $entity_type, $returnvalue, $params) {
	global $CONFIG;
	elgg_set_context('cron');
	
	// Avoid any time limit while processing
	set_time_limit(0);
	access_show_hidden_entities(true);
	elgg_set_ignore_access(true);
	
	// Encode the name. If may content nos ASCII chars.
	$from_name = "=?UTF-8?B?" . base64_encode($CONFIG->site->name) . "?=";
	$from = $from_name . ' <' . $CONFIG->site->email . '>';
	define('event_calendar_reminder_EMAIL_FROM', $from);
	
	// Admin reminder setting
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
	
	echo elgg_echo('event_calendar_reminder:cron:done');
}

// CRON : Send reminder email
function event_calendar_reminder_cron_notify_subscribers($event, $getter, $options) {
	global $CONFIG;
	$enable_usersettings = elgg_get_plugin_setting('enable_usersettings', 'event_calendar_reminder');
	
	elgg_load_library('elgg:event_calendar');
	
	// Get subscribers list
	$users = event_calendar_get_users_for_event($event->guid,0,0,false);
	
	// Debug
	//echo '<p>' . $event->guid . ' : ' . $event->title . ' ' . date('d m Y', $event->start_date) . ' => ' . count($users) . '</p>';
	
	// Remove those who do not want notifications
	foreach ($users as $user) {
		// Block sending if user wants (if admin setting enabled)
		if ($enable_usersettings == 'yes') {
			$user_block = elgg_get_plugin_user_setting('block_reminder', $user->guid, 'event_calendar_reminder');
			if ($user_block == 'yes') { continue; }
		}
		
		// Define event subject and message, and send it
		$subject = elgg_echo('event_calendar_reminder:subject', array($event->title));
		$time_bit = date('d', $event->start_date) . ' ' . elgg_echo('date:month:' . date('m', $event->start_date), array(date('Y', $event->start_date)));
		$message = elgg_echo('event_calendar_reminder:message', array($event->title, $time_bit, $event->brief_description, $event->getURL()));
		notify_user($user->guid, $CONFIG->site->guid, $subject, $message, NULL, 'email');
	}
	
}


