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
	elgg_extend_view('css/admin', 'feedback/admin_css');
	
	// create feedback page in admin section
	elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');
	// Admin widget
	elgg_register_widget_type('feedback', elgg_echo('feedback:admin:title'), elgg_echo('feedback:widget:description'), 'admin');
	
	// Give access to feedbacks in groups
	$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
	//if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && elgg_is_logged_in()) {
	if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
		//gatekeeper();
		//group_gatekeeper();
		// Add group menu option if no feedback group specified (default = disabled)
		if ($feedbackgroup == 'grouptool') { add_group_tool_option('feedback', elgg_echo('feedback:enablefeedback'), false); }
		elgg_extend_view('groups/profile/summary','feedback/grouplisting', 900);
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
	
		// Register a URL handler for bookmarks
	elgg_register_entity_url_handler('object', 'feedback', 'feedback_url');
	
	// menu des groupes
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'feedback_owner_block_menu');
	
	// Interception des commentaires
	elgg_register_event_handler('create', 'annotation', 'feedback_create_annotation_event_handler');
	
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
		case 'about': set_input('about', $page[1]); break;
		case 'mood': set_input('mood', $page[1]); break;
	}
	include(dirname(__FILE__) . "/pages/feedback/feedback.php");
	return true;
}

/**
 * Populates the ->getUrl() method for feedback objects
 *
 * @param ElggEntity $entity The feedback
 * @return string feedback item URL
 */
function feedback_url($entity) {
	global $CONFIG;
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "feedback/view/" . $entity->getGUID() . "/" . $title;
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


function feedback_create_annotation_event_handler($event, $type, $annotation){
	if($annotation instanceof ElggAnnotation){
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


