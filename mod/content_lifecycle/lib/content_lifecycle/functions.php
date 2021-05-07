<?php


// Event avant la suppression d'un compte
function content_lifecycle_delete_user_event(\Elgg\Event $event) {
	
	return true;
}

// Hook avant action de suppression d'un compte
function content_lifecycle_delete_user_action(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$params = $hook->getParams();
	$entity = $hook->getEntityParam();
	$guid = get_input('guid');
	$user = get_user($guid);
	// Check account_lifecycle delete flag (intercept only if not set to 'delete')
	if ($user->account_lifecycle == "delete_now") {
		return true;
	} else {
		forward('content_lifecycle/?guid=' . $guid);
	}
}

// Hook avant action de suppression de plusieurs comptes
function content_lifecycle_delete_user_bulk_action(\Elgg\Hook $hook) {
	
	return true;
}

/*
// Select and options lists
function content_lifecycle_direct_rule_options() {
	return [
		'email_validation' => elgg_echo('content_lifecycle:rule:email_validation'),
		//'confirm_button' => elgg_echo('content_lifecycle:rule:confirm_button'),
		//'archive' => elgg_echo('content_lifecycle:rule:archive'),
		//'ban' => elgg_echo('content_lifecycle:rule:ban'),
	];
} 

function content_lifecycle_direct_criteria_options() {
	return [
		'all' => elgg_echo('content_lifecycle:criteria:all'),
		'inactive' => elgg_echo('content_lifecycle:criteria:inactive'),
	];
}


// Cron batch action
function content_lifecycle_execute_rules($force_run = false, $simulation = false, $verbose = true) {
	$return = '';
	$interval = elgg_get_plugin_setting('direct_interval', 'content_lifecycle');
	if (!isset($interval) || empty($interval) || $interval < 1) { return false; }
	
	$action = elgg_get_plugin_setting('direct_rule', 'content_lifecycle');
	$valid_actions = ['email_validation', 'archive', 'ban', 'confirm_button'];
	if (!isset($action) || empty($action) || !in_array($action, $valid_actions)) { return false; }
	
	$include_admin = elgg_get_plugin_setting('direct_include_admin', 'content_lifecycle');
	if (!isset($include_admin) || empty($include_admin)) { return false; }
	
	// @TODO Send reminders ?   not for direct mode (no action required yet)
	
	// Perform action if user_last_run + interval >= now ie. user_last_run >= now - interval)
	//$next_date = content_lifecycle_get_next_date();
	$interval_ts = $interval * 24 * 3600;
	$now = time();
	
	// Select entities (select + tempo)
	$users = elgg_get_entities([
		'type' => 'user',
		//'subtype' => 'page',
//		'metadata_name_value_pairs' => [
//			'name' => 'some_meta',
//			'value' => some_meta_value,
//			//'operator' => '>=',
//		],
		'limit' => false,
		'batch' => true,
		'batch_inc_offset' => true,
	]);
	
	foreach ($users as $user) {
		$return .= "<li>{$user->guid} => $action : ";
		if (!empty($user->content_lifecycle_direct_last_ts)) {
			$return .= elgg_echo('content_lifecycle:cron:latest_run') . ' <span title="' . date("Y-m-d H:i:s", $user->content_lifecycle_direct_last_ts) . '">' . date("Y-m-d", $user->content_lifecycle_direct_last_ts) . '</span>';
		} else {
			$return .= elgg_echo('content_lifecycle:cron:never_ran');
		}
		
		// Skip admin if needed
		if ($include_admin != 'yes' && $user->isAdmin()) { $return .= elgg_echo('content_lifecycle:cron:skip_admin'); continue; }
		// Skip if already done (we have a latest run date + don't force the run + next run is passed)
		if (isset($user->content_lifecycle_direct_last_ts) && !$force_run) {
			if ( ($user->content_lifecycle_direct_last_ts + $interval_ts) >= $now) {
				$next_run = $user->content_lifecycle_direct_last_ts + $interval_ts;
				$return .= elgg_echo('content_lifecycle:cron:skip_notyet', [date("Y-m-d", $next_run), floor(($next_run - time())/(3600*24))]);
				continue;
			}
		}
		
		
		// Send reminders
		//
		
		// Execute rule action
		if ($simulation) { $return .= elgg_echo('content_lifecycle:cron:simulation'); }
		switch($action) {
			case 'email_validation':   // OK
				if (elgg_is_active_plugin('uservalidationbyemail')) {
					if (!$simulation) {
						// set user as unvalidated
						$user->setValidationStatus(false);
						// set flag for tracking validation status
						elgg_set_plugin_user_setting('email_validated', false, $user->guid, 'uservalidationbyemail');
						// send out validation email
						uservalidationbyemail_request_validation($user->guid);
					}
					$return .= elgg_echo('content_lifecycle:cron:require_validation');
				} else {
					register_error(elgg_echo('content_lifecycle:cron:error:missing_uservalidationbyemail'));
				}
				break;
			
			case 'confirm_button':   // OK
				if (!$simulation) {
					$user->content_lifecycle_require_confirmation = 'yes';
				}
				$return .= elgg_echo('content_lifecycle:cron:confirm_button');
				break;
			
			case 'archive':   // @TODO
				if (!$simulation) {
					//$user->archive = 'yes';
				}
				$return .= elgg_echo('content_lifecycle:cron:archive');
				break;
			
			case 'ban':   // @TODO
				if (!$simulation) {
					//$user->ban("User account expired.");
				}
				$return .= elgg_echo('content_lifecycle:cron:ban');
				break;
		}
		$user->content_lifecycle_direct_last_ts = $now;
		$return .= elgg_echo('content_lifecycle:cron:saved_lastrun', [date("Y-m-d H:i:s", $now)]);;
		$return .= '</li>';
	}
	if ($verbose) { return '<ul class="account-lifecycle-log-item">' . $return . '</ul>'; }
	return true;
}
*/

