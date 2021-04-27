<?php

/**
 * Populates the ->getUrl() method for feedback objects
 */
function feedback_url(\Elgg\Hook $hook) {
	$entity = $hook->getEntityParam();
	if ($entity instanceof ElggFeedback) {
		return elgg_get_site_url() . 'feedback/view/' . $entity->guid . '/' . elgg_get_friendly_title($entity->title);
	}
}

// Feedback menu
function feedback_owner_block_menu(\Elgg\Hook $hook) {
	$entity = $hook->getEntityParam();
	$return = $hook->getValue();
	if ($entity instanceof ElggGroup) {
		$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', 'feedback');
		// Only add feedback to a group if it is allowed
		if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
			if (($entity->guid == $feedbackgroup) || (($feedbackgroup == 'grouptool') && ($entity->feedback_enable == 'yes')) ) {
				//add_submenu_item(sprintf(elgg_echo("feedback:group"),$entity->name), $CONFIG->wwwroot . "feedback");
				$url = "feedback/group/{$entity->guid}";
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
			if ($entity instanceof ElggFeedback) {
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
	if (!($entity instanceof ElggComment)) { return $subscriptions; }
	
	// Process only feedback comments
	$feedback = $event->getObject()->getContainerEntity();
	if ($feedback instanceof ElggFeedback) {
		
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
	if (!($entity instanceof ElggComment)) { return $notification; }
	
	// Process only feedback comments
	$feedback = $event->getObject()->getContainerEntity();
	if ($feedback instanceof ElggFeedback) {
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
	if (!$mood_values || sizeof($mood_values) < 1) { $mood_values = array('happy', 'neutral', 'angry'); }
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
	if (!($feedback instanceof ElggFeedback)) { return false; }
	
	// Specific container if set (valid group, different from owner user itself)
	$container = $feedback->getContainerEntity();
	if ($container instanceof ElggGroup) {
		elgg_set_page_owner_guid($container->guid);
		return $container;
	}
	
	// Main group if it is valid
	$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
	if (!empty($feedbackgroup) && !in_array($feedbackgroup, ['no', 'grouptool'])) {
		$maingroup = get_entity($feedbackgroup);
		if ($maingroup instanceof ElggGroup) {
			elgg_set_page_owner_guid($maingroup->guid);
			return $maingroup;
		}
	}
	
	// Default container = site
	$site = elgg_get_site_entity();
	elgg_set_page_owner_guid($site->guid);
	return $site;
	
}


function feedback_upgrade() {
	echo "FEEDBACK UPGRADE : <br />";
	$feedbacks = elgg_get_entities(['type' => 'object', 'subtype' => 'feedback', 'metadata_names' => "txt", 'limit' => false]);
	foreach($feedbacks as $entity) {
		// Replace "txt" metadata by standard "description" metadata
		if (empty($entity->description)) {
			$entity->description = $entity->txt;
			$entity->txt = null;
		}
		// Ensure title is not empty
		if (empty($entity->title)) { $entity->title = elgg_get_excerpt($entity->txt, 32); }
		// Set default status (cannot be empty)
		if (empty($entity->status)) { $entity->status = 'open'; }
		// About: Remove undefined values (default = no value)
		if (in_array($entity->about, ['other', 'undefined', 'feedback'])) { $entity->about = null; }
		// Mood: Remove undefined values (default = no value)
		if (in_array($entity->mood, ['other'])) { $entity->mood = null; }
		echo "{$entity->guid} {$entity->title} : OK<br />";
	}
	echo "Terminé.";
	return true;
}



