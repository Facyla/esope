<?php

/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 * 
 * Adaptations by Facyla ~ Florian DANIEL
 * facyla@gmail.com
 * Implement status, member view, access selector, property-based rendering, + french translation & various other adaptations
 * http://lereseausocial.fr/
 * 
 */

global $CONFIG;
action_gatekeeper();

// check if captcha functions are loaded (only necessary when logged out)
if (!elgg_is_logged_in()) {
	if ( function_exists ( "captcha_verify_captcha" ) ) {
		// captcha verification
		$token = get_input('captcha_token');
		$input = get_input('captcha_input');
		if ( !$token || !captcha_verify_captcha($input, $token) ) {
			echo "<div id=\"feedbackError\">".elgg_echo('captcha:captchafail')."</div>";
			exit();
		}
	}
}


// Required for public feedback
$ia = elgg_set_ignore_access(true);

// Initialise a new ElggObject
$feedback = new ElggObject();
// Tell the system it's a feedback
$feedback->subtype = "feedback";
$feedback->access_id = (int) get_input('access_id', 0); // Default access = private (admin only)
// If it's public : give ownership to the site and force access to private
if (!elgg_is_logged_in()) {
	//$feedback_user = 2; // We could configure some existing user..
	$feedback_user = $CONFIG->site->guid;
	$feedback->owner_guid = $feedback_user;
	$feedback->container_guid = $feedback_user;
}
// Set the feedback's content
$feedback->page = get_input('page');
$feedback->mood = get_input('mood');
$feedback->about = get_input('about');
$feedback->id = $feedback_sender = get_input('id');
$feedback->txt = $feedback_txt = get_input('txt');
$feedback->status = get_input('status', 'open'); // Default status = open

// save the feedback now
if ($feedback->save()) {
	// Success message
	echo '<div id="feedbackSuccess">' . elgg_echo("feedback:submit:success") . '</div>';
} else {
	// Error message
	echo '<div id="feedbackError">' . elgg_echo("feedback:submit:error") . '</div>';
}

elgg_set_ignore_access($ia);

// now email if required - note: we'll email anyway, on success or error
$user_guids = array();
for ( $idx=1; $idx<=5; $idx++ ) {
	$name = elgg_get_plugin_setting( 'user_'.$idx, 'feedback' );
	if ( !empty($name) ) {
		if ( $user = get_user_by_username($name) ) {
			$user_guids[] = $user->guid;
		}
	}
}
if (count($user_guids) > 0) {
	notify_user($user_guids, $CONFIG->site->guid, sprintf(elgg_echo('feedback:email:subject'), $feedback_sender), sprintf(elgg_echo('feedback:email:body'), $feedback_txt));
}

exit();

