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
 */

elgg_register_event_handler('init', 'system', 'feedback_init');


/**
 * Initialize Plugin
 */
function feedback_init() {
	// extend the view
	if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") == "yes" || elgg_is_logged_in()) {
		elgg_extend_view('page/elements/footer', 'feedback/footer');
	}
	
	// extend the site CSS
	elgg_extend_view('css/elgg', 'feedback/css');
	elgg_extend_view('css/admin', 'feedback/css');
	
	// create feedback page in admin section
	elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');
	// Admin widget
	elgg_register_widget_type('feedback', elgg_echo('feedback:admin:title'), elgg_echo('feedback:widget:description'), array('admin'));
	
	// Give access to feedbacks in groups
	$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
	//if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && elgg_is_logged_in()) {
	if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
		//gatekeeper();
		//group_gatekeeper();
		// Add group menu option if no feedback group specified (default = disabled)
		if ($feedbackgroup == 'grouptool') { add_group_tool_option('feedback', elgg_echo('feedback:enablefeedback'), false); }
		elgg_extend_view('groups/tool_latest','feedback/grouplisting', 100);
	}
	
	/* Note : these settings are used in views
	// Allow members to read feedbacks
	$memberview = elgg_get_plugin_setting("memberview", "feedback");
	
	// Allow comments on feedbacks
	$comment = elgg_get_plugin_setting("comment", "feedback");
	*/
	
	// Register entity type (makes feedbacks eligible for search)
	elgg_register_entity_type('object','feedback');

	// page handler
	elgg_register_page_handler('feedback','feedback_page_handler');
	
		// Register a URL handler for feedbacks
	elgg_register_plugin_hook_handler('entity:url', 'object', 'feedback_url');
	
	// menu des groupes
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'feedback_owner_block_menu');
	
	// Interception des commentaires
	// Set core notifications system to track the creation of new comments (might also have been enabled by other plugins)
	elgg_register_notification_event('object', 'comment', array('create'));
	//elgg_register_event_handler('create', 'annotation', 'feedback_create_annotation_event_handler');
	elgg_register_plugin_hook_handler("get", "subscriptions", "feedback_comment_get_subscriptions_hook");
	
	// @TODO : override feedback message to use our own content
	// Note : load late to avoid content being modifed by some other plugin
	elgg_register_plugin_hook_handler('prepare', 'notification:create:object:comment', 'feedback_prepare_comment_notification', 800);
	
	// Register actions
	elgg_register_action('feedback/delete', elgg_get_plugins_path() . 'feedback/actions/delete.php', 'admin');
	elgg_register_action("feedback/close", elgg_get_plugins_path() . 'feedback/actions/close.php', 'admin');
	elgg_register_action("feedback/reopen", elgg_get_plugins_path() . 'feedback/actions/reopen.php', 'admin');
	elgg_register_action('feedback/submit_feedback', elgg_get_plugins_path() . 'feedback/actions/submit_feedback.php', 'public');
	
}


/**
 * Feedback Page handler
 *
 * @param unknown_type $page
 */
function feedback_page_handler($page) {
	switch($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include(dirname(__FILE__) . "/pages/feedback/view.php");
			return true;
			break;
		
		// Following all use default page
		case 'group': set_input('group', $page[1]); break;
		case 'status': set_input('status', $page[1]); break;
		case 'about': set_input('about', $page[1]); set_input('status', $page[2], 'open'); break;
		case 'mood': set_input('mood', $page[1]); break;
	}
	include(dirname(__FILE__) . "/pages/feedback/feedback.php");
	return true;
}

/**
 * Populates the ->getUrl() method for feedback objects
 */
function feedback_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'feedback')) {
		return elgg_get_site_url() . 'feedback/view/' . $entity->guid . '/' . elgg_get_friendly_title($entity->title);
	}
}

// Feedback menu
function feedback_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'group')) {
		$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', 'feedback');
		// Only add feedback to a group if it is allowed
		if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
			if (($params['entity']->guid == $feedbackgroup) || (($feedbackgroup == 'grouptool') && ($params['entity']->feedback_enable == 'yes')) ) {
				//add_submenu_item(sprintf(elgg_echo("feedback:group"),$params['entity']->name), $CONFIG->wwwroot . "feedback");
				$url = "feedback/group/{$params['entity']->guid}";
				$item = new ElggMenuItem('feedback', elgg_echo('feedback:group'), $url);
				$return[] = $item;
			}
		}
	}
	return $return;
}


/* Old comment notification system
function feedback_create_annotation_event_handler($event, $type, $annotation){
	if(!empty($annotation) && ($annotation instanceof ElggAnnotation)){
		// check if the entity isn't PRIVATE
		if($entity = $annotation->getEntity()){
			if (elgg_instanceof($entity, 'object', 'feedback')) {
				$feedback_title = $entity->title;
				$details = $entity->about;
				if (!empty($details)) $details .= ', ';
				$details .= $entity->mood;
				if (!empty($details)) $details = " ($details)";
				$feedback_title .= $details;
				$comment_owner = $annotation->getOwnerEntity();
				$comment_sender = '<a href="' . $comment_owner->getURL() . '">' . $comment_owner->name . '</a>';
				$comment_content = $annotation->value;
				// Notify admins
				$user_guids = array();
				for ( $idx=1; $idx<=5; $idx++ ) {
					$name = elgg_get_plugin_setting( 'user_'.$idx, 'feedback' );
					if ( !empty($name) ) {
						if ( $user = get_user_by_username($name) ) {
							$user_guids[$user->guid] = $user;
						}
					}
				}
				if (count($user_guids) > 0) {
					$subject = elgg_echo('feedback:email:reply:subject', array($feedback_title));
					foreach ($user_guids as $user_guid => $user) {
						$message = elgg_echo('feedback:email:reply:body', array($comment_sender, $feedback_title, $comment_content, $entity->getURL()));
						// Trigger a hook to enable integration with other plugins
						$hook_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', array('entity' => $feedback, 'to_entity' => $user), $message);
						// Failsafe backup if hook as returned empty content but not false (= stop)
						if (!empty($hook_message) && ($hook_message !== false)) { $message = $hook_message; }
						notify_user($user_guids, elgg_get_site_entity()->guid, $subject, $message, null, 'email');
					}
				}
				
			}
		}
	}
	return true;
}
*/


// Ensure admins and comment owner are notified
function feedback_comment_get_subscriptions_hook($hook, $type, $subscriptions, $params) {
	$event = $params['event'];
	$entity = $event->getObject();
	
	// Process only comments
	if (!elgg_instanceof($entity, 'object', 'comment')) { return $subscriptions; }
	
	// Process only feedback comments
	$feedback = $event->getObject()->getContainerEntity();
	if (elgg_instanceof($feedback, 'object', 'feedback')) {
		
		// @TODO : vérifier la bonne valeur à indiquer dans $mtthods
		//$handlers = _elgg_services()->notifications->getMethods();
		//error_log(print_r($handlers, true));
		
		// Add feedback owner
		$owner = $feedback->getOwnerEntity();
		$subscriptions[$owner->guid] = array('email');
		
		// Add configured admins
		for ($i=1; $i<=5; $i++) {
			$name = elgg_get_plugin_setting('user_'.$i, 'feedback');
			if (!empty($name)) {
				if ($user = get_user_by_username($name)) {
					$subscriptions[$user->guid] = array('email');
				}
			}
		}
		
	}
	return $subscriptions;
}


// Feedback notification message replies (comments)
function feedback_prepare_comment_notification($hook, $type, $notification, $params) {
	$event = $params['event'];
	$entity = $event->getObject();
	
	// Process only comments
	if (!elgg_instanceof($entity, 'object', 'comment')) { return $notification; }
	
	// Process only feedback comments
	$feedback = $event->getObject()->getContainerEntity();
	if (elgg_instanceof($feedback, 'object', 'feedback')) {
		$actor = $event->getActor();
		/*
		$recipient = $params['recipient'];
		$language = $params['language'];
		$method = $params['method'];
		*/
		$feedback_title = $feedback->title;
		$details = '';
		if (feedback_is_about_enabled()) {
			$details = $feedback->about;
		}
		if (feedback_is_mood_enabled()) {
			if (!empty($details)) { $details .= ', '; }
			$details .= $feedback->mood;
		}
		if (!empty($details)) { $feedback_title .= " ($details)"; }
		$comment_sender = '<a href="' . $actor->getURL() . '">' . $actor->name . '</a>';
		
		$notification->subject = elgg_echo('feedback:email:reply:subject', array($feedback_title), $language);
		$notification->summary = elgg_echo('feedback:email:reply:subject', array($comment_sender, $feedback_title), $language);
		$notification->body = elgg_echo('feedback:email:reply:body', array($comment_sender, $feedback_title, $feedback->value, $feedback->getURL()), $language);
	}
	
	return $notification;
}



// Tells if mood options are enabled
function feedback_is_mood_enabled() {
	$enable_mood = elgg_get_plugin_setting('enable_mood', 'feedback');
	if ($enable_mood != 'no') { return true; }
	return false;
}
// Return mood available values
function feedback_mood_values() {
	$mood_values = elgg_get_plugin_setting('mood_values', 'feedback');
	if (!empty($mood_values)) {
		$mood_values = explode(',', $mood_values);
		$mood_values = array_map('trim', $mood_values);
		$mood_values = array_unique($mood_values);
		$mood_values = array_filter($mood_values, 'strlen');
	}
	// Set default
	if (sizeof($mood_values) < 1) { $mood_values = array('happy', 'neutral', 'angry'); }
	return $mood_values;
}

// Tells if about categories are enabled
function feedback_is_about_enabled() {
	$enable_about = elgg_get_plugin_setting('enable_about', 'feedback');
	if ($enable_about != 'no') { return true; }
	return false;
}

/* Values for feedback categories
 * Note : if no value wanted, better to disable than set to empty,
 * so we set a default array if empty config
 */
function feedback_about_values() {
	$about_values = elgg_get_plugin_setting('about_values', 'feedback');
	if (!empty($about_values)) {
		$about_values = explode(',', $about_values);
		$about_values = array_map('trim', $about_values);
		$about_values = array_unique($about_values);
		$about_values = array_filter($about_values, 'strlen');
	}
	// Set default
	if (sizeof($about_values) < 1) {
		$about_values = array('bug_report', 'content', 'question', 'suggestions', 'compliment', 'other');
	}
	return $about_values;
}


/* Determines feedback page owner (specific container, main group, user...)
 * Specific container : specific group (ie. published in a specific group)
 * Container not set (= owner) : main group if set, site or user otherwise
 * @return $container
 */
function feedback_set_page_owner($feedback) {
	if (!elgg_instanceof($feedback, 'object', 'feedback')) { return false; }
	
	// Specific container if set (valid group, different from owner user itself)
	$container = $feedback->getContainerEntity();
	if (elgg_instanceof($container, 'group')) {
		elgg_set_page_owner_guid($container->guid);
		return $container;
	}
	
	// Main group if it is valid
	$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
	if (!empty($feedbackgroup) && !in_array($feedbackgroup, ['no', 'grouptool'])) {
		$maingroup = get_entity($feedbackgroup);
		if (elgg_instanceof($maingroup, 'group')) {
			elgg_set_page_owner_guid($maingroup->guid);
			return $maingroup;
		}
	}
	
	// Default container = site
	$site = elgg_get_site_entity();
	elgg_set_page_owner_guid($site->guid);
	return $site;
	
}

