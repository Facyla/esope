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

// Ensure admins and comment owner are notified
function feedback_comment_get_subscriptions_hook(\Elgg\Hook $hook) {
	$entity = $hook->getEntityParam();
	$subscriptions = $hook->getValue();
	
	// Process only comments
	if (!($entity instanceof ElggComment)) { return $subscriptions; }
	
	// Process only feedback comments
	$feedback = $entity->getContainerEntity();
	if ($feedback instanceof ElggFeedback) {
		
		// @TODO : vérifier la bonne valeur à indiquer dans $mtthods
		//$handlers = _elgg_services()->notifications->getMethods();
		//error_log(print_r($handlers, true));
		
		// Add feedback owner
		$owner = $feedback->getOwnerEntity();
		$subscriptions[$owner->guid] = ['email'];
		
		// Add configured admins
		for ($i=1; $i<=5; $i++) {
			$name = elgg_get_plugin_setting('user_'.$i, 'feedback');
			if (!empty($name)) {
				if ($user = get_user_by_username($name)) {
					$subscriptions[$user->guid] = ['email'];
				}
			}
		}
		
	}
	return $subscriptions;
}


// Feedback notification message replies (comments)
function feedback_prepare_comment_notification(\Elgg\Hook $hook) {
	$entity = $hook->getEntityParam();
	$notification = $hook->getValue();
	$event = $hook->getParam['event'];
	
	// Process only comments
	if (!($entity instanceof ElggComment)) { return $notification; }
	
	// Process only feedback comments
	$feedback = $entity->getContainerEntity();
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
		
		$notification->subject = elgg_echo('feedback:email:reply:subject', [$feedback_title], $language);
		$notification->summary = elgg_echo('feedback:email:reply:subject', [$comment_sender, $feedback_title], $language);
		$notification->body = elgg_echo('feedback:email:reply:body', [$comment_sender, $feedback_title, $feedback->value, $feedback->getURL()], $language);
	}
	
	return $notification;
}



