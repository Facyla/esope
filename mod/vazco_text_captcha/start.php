<?php
// As the original version is no longer licensed as GPL, this version is now maintained in ESOPE


function vazco_text_captcha_init() {
	global $CONFIG;
	
	require_once(dirname(__FILE__)."/models/model.php");
	
	// Register a function that provides some default override actions
	elgg_register_plugin_hook_handler('actionlist', 'captcha', 'vazco_text_captcha_actionlist_hook');
	
	elgg_extend_view('css', 'vazco_text_captcha/css');
	// Register actions to intercept
	$actions = array();
	$actions = elgg_trigger_plugin_hook('actionlist', 'captcha', null, $actions);

	if (($actions) && (is_array($actions))) {
		foreach ($actions as $action)
			elgg_register_plugin_hook_handler("action", $action, "vazco_text_captcha_verify_action_hook",999);
	}
	
	elgg_register_event_handler('create', 'user', 'vazco_text_captcha_mark_register');
}

function vazco_text_captcha_mark_register($event, $object_type, $object) {
	if($object && $object instanceof ElggUser) {
		if($_SESSION['vazco_text_captcha_verified']==1)
			$_SESSION['vazco_text_captcha_verified'] = "1";
		else
			$_SESSION['vazco_text_captcha_verified'] = "0";
		return $object->setMetaData('vazco_text_captcha_verified', $_SESSION['vazco_text_captcha_verified']);
	}
}

/**
 * Verify a vazco_text_captcha based on the input value entered by the user and the seed token passed.
 *
 * @param string $input_value
 * @param string $seed_token
 * @return bool
 */
function vazco_text_captcha_verify_captcha($input_value, $seed_token) {
	if (strcasecmp($input_value, vazco_text_captcha_generate_captcha($seed_token)) == 0)
		return true;
		
	//Creating forward url
	$username = get_input('username');
	$email = get_input('email');
	$name = get_input('name');
	$agreetoterms = get_input('agreetoterms');
	$qs = explode('?',$_SERVER['HTTP_REFERER']);
	$qs = $qs[0];
	$qs .= "?username=" . urlencode($username) . "&email=" . urlencode($email) . "&name=" . urlencode($name)."&agreetoterms=".$agreetoterms;
	
	register_error(elgg_echo('vazco_text_captcha:captchafail'));
	forward($qs);
	return false;
}

/**
 * Listen to the action plugin hook and check the vazco_text_captcha.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function vazco_text_captcha_verify_action_hook($hook, $entity_type, $returnvalue, $params) {
	global $_SESSION;
	$token = get_input('captcha_token');
	$input = trim(strtolower(get_input('captcha_input')));
	
	$challenge = vazco_text_captcha::getCaptchaChallengeById($token);
	list($challenge_id, $challenge_question, $challenge_answer) = $challenge;  
	$challenge_answer = trim(strtolower($challenge_answer));
	
	if ($challenge_answer==$input) {
		$_SESSION['vazco_text_captcha_verified'] = 1;
		return true;
	}
	$_SESSION['vazco_text_captcha_verified'] = 0;
	
	//Creating forward url
	$username = get_input('username');
	$email = get_input('email');
	$name = get_input('name');
	$agreetoterms = get_input('agreetoterms');
	$qs = explode('?',$_SERVER['HTTP_REFERER']);
	$qs = $qs[0];
	$qs .= "?username=" . urlencode($username) . "&email=" . urlencode($email) . "&name=" . urlencode($name)."&agreetoterms=".$agreetoterms;
	
	register_error(elgg_echo('vazco_text_captcha:captchafail'));
	forward($qs);
	return false;
}

/**
 * This function returns an array of actions the vazco_text_captcha will expect a vazco_text_captcha for, other plugins may
 * add their own to this list thereby extending the use.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function vazco_text_captcha_actionlist_hook($hook, $entity_type, $returnvalue, $params) {
	if (!is_array($returnvalue))
		$returnvalue = array();
		
	$returnvalue[] = 'register';
	$returnvalue[] = 'user/requestnewpassword';
		
	return $returnvalue;
}

elgg_register_event_handler('init','system','vazco_text_captcha_init');


