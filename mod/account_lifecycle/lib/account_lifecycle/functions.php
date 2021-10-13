<?php

// Select and options lists
function account_lifecycle_direct_rule_options() {
	return [
		'email_validation' => elgg_echo('account_lifecycle:rule:email_validation'),
		//'confirm_button' => elgg_echo('account_lifecycle:rule:confirm_button'),
		//'archive' => elgg_echo('account_lifecycle:rule:archive'),
		//'ban' => elgg_echo('account_lifecycle:rule:ban'),
	];
} 

function account_lifecycle_direct_criteria_options() {
	return [
		'all' => elgg_echo('account_lifecycle:criteria:all'),
		'inactive' => elgg_echo('account_lifecycle:criteria:inactive'),
	];
}



// Cron hook (daily)
function account_lifecycle_cron(\Elgg\Hook $hook) {
	$plugin = elgg_get_plugin_from_id('account_lifecycle');
	$value = account_lifecycle_execute_rules(false, false, true);
	// Save log
	$annotation_guid = $plugin->annotate('direct_mode_log', $value);
	return "account_lifecycle: CRON done";   // "$value ($annotation_guid)";
}

/* Cron batch action
 * $force_run bool Force run without consideration for last run date
 * $simulation bool Simulates without any action
 * $verbose bool Displays details on planned actions
 * $users_guids array Overrides the default automatic users selection with a custom list 
 *              Note : this will not override admin setting
 */
function account_lifecycle_execute_rules($force_run = false, $simulation = false, $verbose = true, $users_guids = false) {
	$return = '';
	$interval = elgg_get_plugin_setting('direct_interval', 'account_lifecycle');
	if (!isset($interval) || empty($interval) || $interval < 1) { return false; }
	
	$action = elgg_get_plugin_setting('direct_rule', 'account_lifecycle');
	$valid_actions = ['email_validation', 'archive', 'ban', 'confirm_button'];
	if (!isset($action) || empty($action) || !in_array($action, $valid_actions)) { return false; }
	
	$include_admin = elgg_get_plugin_setting('direct_include_admin', 'account_lifecycle');
	if (!isset($include_admin) || empty($include_admin)) { return false; }
	
	// @TODO Send reminders ?   not for direct mode (no action required yet)
	
	// Perform action if user_last_run + interval >= now ie. user_last_run >= now - interval)
	//$next_date = account_lifecycle_get_next_date();
	$interval_ts = $interval * 24 * 3600;
	$now = time();
	
	// Select entities (select + tempo) or use provided users GUIDs
	if (!$users_guids) {
		$users = elgg_get_entities([
			'type' => 'user',
			//'subtype' => 'page',
			/*
			'metadata_name_value_pairs' => [
				'name' => 'some_meta',
				'value' => some_meta_value,
				//'operator' => '>=',
			],
			*/
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => true,
		]);
	} else {
		$users = elgg_get_entities(['guids' => $users_guids]);
	}
	
	foreach ($users as $user) {
		$return .= '<li>';
		$return .= '<a href="' . $user->getURL() . '" target="_blank">';
		$return .= '<img src="' . $user->getIconURL('tiny') . '" /> ';
		$return .= "{$user->name} ({$user->guid}, {$user->username}) ";
		$return .= '</a>';
		$return .= " => $action : ";
		if (!empty($user->account_lifecycle_direct_last_ts)) {
			$return .= elgg_echo('account_lifecycle:cron:latest_run') . ' <span title="' . date("Y-m-d H:i:s", $user->account_lifecycle_direct_last_ts) . '">' . date("Y-m-d", $user->account_lifecycle_direct_last_ts) . '</span>';
		} else {
			$return .= elgg_echo('account_lifecycle:cron:never_ran');
		}
		
		// Skip admin if needed
		if ($include_admin != 'yes' && $user->isAdmin()) { $return .= elgg_echo('account_lifecycle:cron:skip_admin'); continue; }
		// Skip if already done (we have a latest run date + don't force the run + next run is passed)
		if (isset($user->account_lifecycle_direct_last_ts) && !$force_run) {
			if ( ($user->account_lifecycle_direct_last_ts + $interval_ts) >= $now) {
				$next_run = $user->account_lifecycle_direct_last_ts + $interval_ts;
				$return .= elgg_echo('account_lifecycle:cron:skip_notyet', [date("Y-m-d", $next_run), floor(($next_run - time())/(3600*24))]);
				continue;
			}
		}
		
		
		// Send reminders
		//
		
		// Execute rule action
		$site = elgg_get_site_entity();
		if ($simulation) { $return .= elgg_echo('account_lifecycle:cron:simulation'); }
		switch($action) {
			case 'email_validation':   // OK
				if (elgg_is_active_plugin('uservalidationbyemail')) {
					if (!$simulation) {
						// set user as unvalidated
						$user->validated = false;
						$user->setValidationStatus(false, 'account_lifecycle');
						// set flag for tracking validation status
						elgg_set_plugin_user_setting('email_validated', false, $user->guid, 'uservalidationbyemail');
						
						// send out validation email
						//uservalidationbyemail_request_validation($user->guid);
						// @note : dans ce cas, il est préférable d'avoir un message plus personnalisé
						// Envoi manuel du mail de validation
						// Work out validate link
						$link = elgg_generate_url('account:validation:email:confirm', ['u' => $user->guid]);
						$link = elgg_http_get_signed_url($link);
						$subject = elgg_echo('account_lifecycle:email_validation:email:validate:subject', [
								$user->getDisplayName(),
								$site->getDisplayName()
							], $user->language
						);
						$body = elgg_echo('account_lifecycle:email_validation:email:validate:body', [
								$user->getDisplayName(),
								$interval,
								$site->getDisplayName(),
								$link,
								$site->getDisplayName(),
								$site->getURL(),
							], $user->language
						);
						$params = [
							'action' => 'uservalidationbyemail',
							'object' => $user,
							'link' => $link,
						];
						// Send validation email
						$result = notify_user($user->guid, $site->guid, $subject, $body, $params, 'email');
						if ($result) {
							$return .= elgg_echo('account_lifecycle:email_validation:email:sent');
						} else {
							$return .= elgg_echo('account_lifecycle:email_validation:email:error');
						}
					}
					$return .= elgg_echo('account_lifecycle:cron:require_validation');
				} else {
					register_error(elgg_echo('account_lifecycle:cron:error:missing_uservalidationbyemail'));
				}
				break;
			
			case 'confirm_button':   // OK
				if (!$simulation) {
					$user->account_lifecycle_require_confirmation = 'yes';
				}
				$return .= elgg_echo('account_lifecycle:cron:confirm_button');
				break;
			
			case 'archive':   // @TODO
				if (!$simulation) {
					//$user->archive = 'yes';
				}
				$return .= elgg_echo('account_lifecycle:cron:archive');
				break;
			
			case 'ban':   // @TODO
				if (!$simulation) {
					//$user->ban("User account expired.");
				}
				$return .= elgg_echo('account_lifecycle:cron:ban');
				break;
		}
		$user->account_lifecycle_direct_last_ts = $now;
		$return .= elgg_echo('account_lifecycle:cron:saved_lastrun', [date("Y-m-d H:i:s", $now)]);;
		$return .= '</li>';
	}
	if ($verbose) { return '<ul class="account-lifecycle-log-item">' . $return . '</ul>'; }
	return true;
}



// Indique la/les prochaines dates d'exécution (ts)
function account_lifecycle_get_next_date(/*$entity = false, $offset = 0*/) {
	$debug = false;
	$direct_start_date = elgg_get_plugin_setting('direct_start_date', 'account_lifecycle');
	$direct_interval = account_lifecycle_get_interval();
	if (empty($direct_start_date)) {
		register_error("Date de prochain échéance manquante.");
		return false;
	}
	if (!$direct_interval) { return false; }
	
	$direct_start_date_ts = strtotime($direct_start_date);
	$now = time();
	$interval_seconds = $direct_interval * 24 * 3600;
	if ($debug) echo "<p>Date : $direct_start_date => $direct_start_date_ts / now $now / Intervale : $direct_interval => $interval_seconds</p>";
	
	if ($direct_start_date_ts <= $now) {
		if ($debug) echo "<p>Date d'échance < date actuelle</p>";
	}
	
	$num_iter = floor($now - $direct_start_date_ts) / $interval_seconds + 1;
	$new_date_ts = $direct_start_date_ts + $num_iter * $interval_seconds;
	if ($debug) echo "<p>Next date : $new_date_ts / " . date("Y-m-d H:i:s", $new_date_ts) . "</p>";
	
	return $new_date_ts;
}

// Renvoie un tableau avec les jours de rappels
// @return (array) 
function account_lifecycle_get_interval() {
	$direct_interval = elgg_get_plugin_setting('direct_interval', 'account_lifecycle');
	if (empty($direct_interval)) {
		register_error("Intervalle manquant.");
		return false;
	}
	if ($direct_interval < 1) {
		register_error("Intervalle invalide (doit être un entier supérieur à 0).");
		return false;
	}
	return $direct_interval;
}

// Renvoie un tableau avec les jours de rappels
// @return (array) 
function account_lifecycle_get_reminders() {
	$reminders = elgg_get_plugin_setting('direct_reminders', 'account_lifecycle');
	if (empty($reminders)) { return false; }
	$reminders = explode(',', $reminders);
	$reminders = array_filter($reminders);
	sort($reminders);
	return $reminders;
}

// Return next reminder TS (or custom format) for next run. Passed dates are removed.
function account_lifecycle_get_reminders_dates($date_format = 'U') {
	$now = time();
	$due_date = account_lifecycle_get_next_date();
	if (!$due_date || $due_date <= $now) { return false; }
	
	$reminders = account_lifecycle_get_reminders();
	if (!$reminders) { return false; }
	
	$reminders_dates = [];
	foreach($reminders as $num_days_before) {
		$reminder_ts = $due_date - ($num_days_before * 24 * 3600);
		if ($reminder_ts > $now) {
			$reminders_dates["$num_days_before"] = date($date_format, $reminder_ts);
		}
	}
	return $reminders_dates;
}

// Tells if a given user is validated or not.
// Note : basically $user->isValidated( works fine, beware of testing === false to ensure valid behaviour)
/*
function account_lifecycle_is_validated($user = false) {
	if (!$user) { $user = elgg_get_logged_in_user_entity(); }
	if (!$user instanceof ElggUser) { return false; }
	
	// This returns null or bool
	$is_validated = $user->isValidated();
	//$status .= "{$user->name} {$user->username} {$user->guid} ";
	if ($is_validated === true) {
		$status .= " isValidated - ";
	} else if ($is_validated === false) {
		$status .= " NOT isValidated - ";
	} else {
		// Not concerned
		$status .= " NOTSET isValidated - ";
	}
	
	// get flag for tracking validation status
	$validation_status = elgg_get_plugin_user_setting('email_validated', $user->guid, 'uservalidationbyemail');
	$status .= " validation status $validation_status";
	
	error_log("Account lifecyle validation status : $status");
	return $status;
}
*/


/*
// Validate email before registration
// Hook is triggered by validate_email_address() in register_user()
function account_lifecycle_validate_email_hook(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	//$params = $hook->getParams();
	$email = $hook->getParam('email');
	
	// Admin bypass
	if (elgg_is_admin_logged_in()) { return $return; }
	
	// Block registration
	if (!account_lifecycle($email)) {
		register_error(elgg_echo('RegistrationException:NotAllowedEmail'));
		return false;
	}
	// Or keep going
	return $return;
}
*/



//// Validates the email against the admin-defined list of allowed email domains
//function account_lifecycle($email = null) {
//	
//	// Quick test : email must at least be set, and can't be less than 6 cars long (ie. c@c.cc)
//	if (!isset($email) || (strlen($email) < 6)) { return false; }
//	
//	// Domain must be at least 4 cars long (c.cc)
//	$email_a = explode('@', $email);
//	if (strlen($email_a[1]) < 4) { return false; }
//	
//	// Check active filter
//	$whitelist_enable = elgg_get_plugin_setting('whitelist_enable', 'account_lifecycle');
//	$blacklist_enable = elgg_get_plugin_setting('blacklist_enable', 'account_lifecycle');
//	
//	/* Whitelist mode */
//	if ($whitelist_enable == 'yes') {
//		// Get and prepare valid domain config array from plugin settings
//		$whitelist = elgg_get_plugin_setting('whitelist', 'account_lifecycle');
//		$whitelist = preg_replace('/\r\n|\r/', "\n", $whitelist);
//		// Add csv support - cut also on ";" and ","
//		$whitelist = str_replace(array(' ', '<p>', '</p>'), '', $whitelist); // Delete all white spaces
//		$whitelist = str_replace(array(';', ','), "\n", $whitelist);
//		$whitelist = explode("\n",$whitelist);
//		
//		//error_log($email_a[1] . " = " . implode(", ", $whitelist)); // debug
//		// Exact match mode : email domain has to be in the list
//		if (!in_array($email_a[1], $whitelist)) { return false; }
//		// @TODO : enable wildcards ?
//		/*
//		if ($whitelist) foreach ($whitelist as $pattern) {
//			$pattern = str_replace('.', '\.', $pattern);
//			$pattern = str_replace('*', '.*', $pattern);
//			if (preg_match($pattern, $url)) { return true; }
//		}
//		*/
//	}
//	
//	/* Blacklist mode */
//	if ($blacklist_enable == 'yes') {
//		// Get and prepare valid domain config array from plugin settings
//		$blacklist = elgg_get_plugin_setting('blacklist', 'account_lifecycle');
//		$blacklist = preg_replace('/\r\n|\r/', "\n", $blacklist);
//		// Add csv support - cut also on ";" and ","
//		$blacklist = str_replace(array(' ', '<p>', '</p>'), '', $blacklist); // Delete all white spaces
//		$blacklist = str_replace(array(';', ','), "\n", $blacklist);
//		$blacklist = explode("\n",$blacklist);
//		
//		//error_log($email_a[1] . " = " . implode(", ", $blacklist)); // debug
//		// Exact match mode : email domain has to be in the list
//		if (in_array($email_a[1], $blacklist)) { return false; }
//		// @TODO : enable wildcards mode (email domain terminal match)
//		/*
//		// @TODO : Allow wildcards : use ".*" as a wildcard (not "*"), and "\." for dots (not ".")
//		// @TODO : auto-replace * and . so we can use simply *.domain.tld
//		// @TODO : and also duplicate filter so we can have raw domain too => domain.tld)
//		if ($blacklist) foreach ($blacklist as $pattern) {
//			//@TODO tester en direct sur longueur dispo si * au début, sinon exact match - plus simple/rapide ?
//			//if (substr())
//			$pattern = str_replace('.', '\.', $pattern);
//			$pattern = str_replace('*', '.*', $pattern);
//			$pattern = "`^$pattern/*$`i";
//			if (preg_match($pattern, $url)) { return false; }
//		}
//		*/
//	}
//	
//	// If we've gotten so far.. it's OK !
//	return true;
//}

