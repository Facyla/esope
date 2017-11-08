<?php
/**
 * registration_filter
 *
*/

elgg_register_event_handler('init', 'system', 'registration_filter_init'); // Init


/**
 * Init registration_filter plugin.
 */
function registration_filter_init() {
	elgg_register_library('registration_filter', elgg_get_plugins_path() . 'registration_filter/lib/registration_filter.php');
	
	elgg_extend_view('css/elgg', 'registration_filter/css');
	elgg_extend_view('forms/register', 'forms/registration_filter_register_extend', 0);
	
	elgg_register_plugin_hook_handler('registeruser:validate:email', 'all', 'registration_filter_validate_email_hook', 1);
	
}


// Validate email before registration
// Hook is triggered by validate_email_address() in register_user()
function registration_filter_validate_email_hook($hook_name, $entity_type, $return, $params) {
	elgg_load_library('registration_filter');
	
	// Admin bypass
	if (elgg_is_admin_logged_in()) { return $return; }
	
	// Block registration
	if (!registration_filter($params['email'])) {
		register_error(elgg_echo('RegistrationException:NotAllowedEmail'));
		return false;
	}
	// Or keep going
	return $return;
}


