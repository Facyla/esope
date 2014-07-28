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
	if (function_exists ('captcha_verify_captcha')) {
		// captcha verification
		$token = get_input('captcha_token');
		$input = get_input('captcha_input');
		if ( !$token || !captcha_verify_captcha($input, $token) ) {
			echo '<div id="feedbackError">' . elgg_echo('captcha:captchafail') . '</div>';
			exit();
		}
	}
}


// Get feedbacks vars
$feedback_txt = get_input('txt');
$feedback_access_id = (int) get_input('access_id', 0); // Default access = private (admin only)
$feedback_page = get_input('page');
$feedback_mood = get_input('mood');
$feedback_about = get_input('about');
$feedback_sender = get_input('id');
$feedback_status = get_input('status', 'open'); // Default status = open

// Refuse empty feedbacks
if (empty($feedback_txt) || empty($feedback_sender)) {
	// Error message
	echo '<div id="feedbackError">' . elgg_echo("feedback:submit:error") . '</div>';
	exit;
}


// Required for public feedback
$ia = elgg_set_ignore_access(true);

// Initialise a new ElggObject
$feedback = new ElggObject();
// Tell the system it's a feedback
$feedback->subtype = "feedback";
$feedback->access_id = $feedback_access_id;
// If it's public : give ownership to the site and force access to private (could be spam)
if (!elgg_is_logged_in()) {
	//$feedback_user = 2; // We could also configure some existing user..
	$feedback_user = $CONFIG->site->guid;
	$feedback->owner_guid = $feedback_user;
	$feedback->container_guid = $feedback_user;
	$feedback->access_id = 0; // Default access = private (admin only)
}
// Set the feedback's content
// Title is used by river...
$feedback->title = elgg_get_excerpt($feedback_txt, 25);
$feedback->page = $feedback_page;
$feedback->mood = $feedback_mood;
$feedback->about = $feedback_about;
$feedback->id = $feedback_sender;
$feedback->txt = $feedback_txt;
$feedback->status = $feedback_status; // Default status = open

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
$details = $feedback->about;
if (!empty($details)) $details .= ', ';
$details .= $feedback->mood;
if (!empty($details)) $details = " ($details)";
$feedback_title = $feedback->title . $details;
$user_guids = array();
// Notify up to 5 configured users
for ( $idx=1; $idx<=5; $idx++ ) {
	$name = elgg_get_plugin_setting( 'user_'.$idx, 'feedback' );
	if (!empty($name)) {
		if ($user = get_user_by_username($name)) {
			$user_guids[] = $user->guid;
		}
	}
}
if (count($user_guids) > 0) {
	notify_user(
			$user_guids, 
			$CONFIG->site->guid, 
			elgg_echo('feedback:email:subject', array($feedback_title)), 
			elgg_echo('feedback:email:body', array($feedback_sender, $feedback_title, $feedback_txt, $feedback->getURL())), 
			null, 
			'email'
		);
}

exit();

