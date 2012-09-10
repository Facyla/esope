<?php
/**
 * adf_registration_filter
 *
*/

elgg_register_event_handler('init', 'system', 'adf_registration_filter_init'); // Init


/**
 * Init adf_registration_filter plugin.
 */
function adf_registration_filter_init() {
  
  global $CONFIG;
  
  elgg_register_library('adf_registration_filter', $CONFIG->pluginspath . 'adf_registration_filter/lib/registration_filter.php');
  
  elgg_extend_view('css/elgg', 'registration_filter/css');
  
  // replace default registration action
  $action_path = $CONFIG->pluginspath . 'adf_registration_filter/actions/registration_filter/';
	elgg_register_action('register', $action_path.'register.php', 'public');
	
	/* Alternative : hook into email validation - cf. http://reference.elgg.org/1.8/users_8php_source.html#l00875
    - But this requires a double-check if account is admin-created (bypass if admin loggedin in)
    00880     // Got here, so lets try a hook (defaulting to ok)
    00881     $result = true;
    00882     return elgg_trigger_plugin_hook('registeruser:validate:email', 'all',
    00883         array('email' => $address), $result);
	*/
	
}


