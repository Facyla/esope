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
	elgg_extend_view('page/elements/head', 'recaptcha/head');
	
	// Register JS script (async defer) - use with : elgg_load_js('recaptcha');
	$valid_recaptcha_urls = recaptcha_get_valid_urls();
	$recaptcha_url = elgg_get_plugin_setting('recaptcha_url', 'recaptcha');
	if (in_array($recaptcha_url, $valid_recaptcha_urls)) { $recaptcha_url = $valid_recaptcha_urls[0]; }
	elgg_register_js('google:recaptcha', $recaptcha_url, 'footer');
	// Multiple reCaptcha on single page: must use explicit call for multiple reCAPTCHA rendering
	// Note : seems not to work because & is converted to &amp; somewhere when loading JS scripts...
	//elgg_register_js('google:recaptcha', 'https://www.google.com/recaptcha/api.js?onload=ReCaptchaCallback&render=explicit', 'footer');
	
	if (!elgg_is_logged_in()) {
		elgg_load_js('google:recaptcha');
	}
	
	// @TODO enable hook into actions array
	$actions = array('register', 'user/requestnewpassword');
	foreach ($actions as $action) {
		elgg_register_plugin_hook_handler("action", $action, 'recaptcha_verify_hook');
	}
	
}


// Check that required settings are set
function recaptcha_check_settings() {
	$secretkey = elgg_get_plugin_setting('secretkey', 'recaptcha');
	$publickey = elgg_get_plugin_setting('publickey', 'recaptcha');
	if (!empty($secretkey) && !empty($publickey)) { return true; }
	return false;
}

// Ensure that a valid reCAPTCHA response has been sent back
function recaptcha_verify_hook($hook, $entity_type, $returnvalue, $params) {
	$verify = recaptcha_verify();
	return $verify;
}

// Verify reCAPTCHA response
function recaptcha_verify($response = '', $secret = '') {
	if (empty($secret)) {
		$secret = elgg_get_plugin_setting('secretkey', 'recaptcha');
	}
	
	// Do not block authentication if no secret key is set, but send an alert
	if (empty($secret)) {
		register_error(elgg_echo('recaptcha:error:missingkeys'));
		return true;
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
		'missing-input-secret' => elgg_echo('recaptcha:error:missingsecret'),
		'invalid-input-secret' => elgg_echo('recaptcha:error:invalidsecret'),
		'missing-input-response' => elgg_echo('recaptcha:error:missingresponse'),
		'invalid-input-response' => elgg_echo('recaptcha:error:invalidresponse'),
	);
	foreach($obj_response->{'error-codes'} as $error) {
		register_error($error_codes[$error]);
	}

	return false;
}


/* Get valid JS script source URLs
 * Note: index 0 is default source
 */
function recaptcha_get_valid_urls() {
	return [
		'www.google.com' => 'https://www.google.com/recaptcha/api.js', 
		'www.recaptcha.net' => 'https://www.recaptcha.net/recaptcha/api.js',
	];
}


