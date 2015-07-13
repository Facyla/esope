<?php
/**
 * recaptcha plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'recaptcha_init');


/**
 * Init recaptcha plugin.
 */
function recaptcha_init() {
	
	elgg_extend_view('css', 'recaptcha/css');
	elgg_extend_view('input/captcha', 'input/recaptcha');
	
	// Register JS script (async defer) - use with : elgg_load_js('recaptcha');
	elgg_register_js('google:recaptcha', 'https://www.google.com/recaptcha/api.js', 'footer');
	
	if (!elgg_is_logged_in()) { elgg_load_js('google:recaptcha'); }
	
	$actions = array('register', 'user/requestnewpassword');
	foreach ($actions as $action) {
		elgg_register_plugin_hook_handler("action", $action, 'recaptcha_verify_hook');
	}
	
}


function recaptcha_verify_hook($hook, $entity_type, $returnvalue, $params) {
	$verify = recaptcha_verify();
	return $verify;
}

function recaptcha_verify($response = '', $secret = '') {
	if (empty($secret)) {
		$secret = elgg_get_plugin_setting('secretkey', 'recaptcha');
	}
	if (empty($response)) {
		$response = get_input('g-recaptcha-response');
	}
	
	$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response";
	
	$json_response = file_get_contents($api_url);
	$obj_response = json_decode($json_response);

	if ($obj_response->success == '1') {
		return true;
	}
	
	$error_codes = array(
		'missing-input-secret' => "The secret parameter is missing.",
		'invalid-input-secret' => "The secret parameter is invalid or malformed.",
		'missing-input-response' => "The response parameter is missing.",
		'invalid-input-response' => "The response parameter is invalid or malformed.",
	);
	foreach($obj_response->{'error-codes'} as $error) {
		register_error($error_codes[$error]);
	}

	return false;
}


