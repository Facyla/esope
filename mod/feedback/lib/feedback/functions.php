<?php


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
				$user_guids = [];
				for ( $idx=1; $idx<=5; $idx++ ) {
					$name = elgg_get_plugin_setting( 'user_'.$idx, 'feedback' );
					if ( !empty($name) ) {
						if ( $user = get_user_by_username($name) ) {
							$user_guids[$user->guid] = $user;
						}
					}
				}
				if (count($user_guids) > 0) {
					$subject = elgg_echo('feedback:email:reply:subject', [$feedback_title]);
					foreach ($user_guids as $user_guid => $user) {
						$message = elgg_echo('feedback:email:reply:body', [$comment_sender, $feedback_title, $comment_content, $entity->getURL()]);
						// Trigger a hook to enable integration with other plugins
						$hook_message = elgg_trigger_plugin_hook('notify:annotation:message', 'comment', ['entity' => $feedback, 'to_entity' => $user], $message);
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
	if (!$mood_values || sizeof($mood_values) < 1) { $mood_values = ['happy', 'neutral', 'angry']; }
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
	if (!$about_values || sizeof($about_values) < 1) {
		$about_values = ['bug_report', 'content', 'question', 'suggestions', 'compliment', 'other'];
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


// Upgrade feedback entities
function feedback_upgrade() {
	echo "FEEDBACK UPGRADE : <br />";
	if (feedback_upgrade_to_elgg3_check()) {
		$result = feedback_upgrade_to_elgg3();
	}
	return true;
}
// Check data structure for potential required upgrade
function feedback_upgrade_to_elgg3_check() {
	$feedbacks_count = elgg_get_entities(['type' => 'object', 'subtype' => 'feedback', 'metadata_names' => "txt", 'count' => true]);
	if ($feedbacks_count > 0) { return true; }
	return false;
}
// Update data structure for better Elgg entities compatibility
function feedback_upgrade_to_elgg3() {
	echo "<h3>Upgrade data structure for Elgg 3.x</<h3>";
	$feedbacks = elgg_get_entities(['type' => 'object', 'subtype' => 'feedback', 'metadata_names' => "txt", 'limit' => false]);
	$feedbacks_count = elgg_get_entities(['type' => 'object', 'subtype' => 'feedback', 'metadata_names' => "txt", 'count' => true]);
	$processed_count = 0;
	foreach($feedbacks as $entity) {
		$processed = false;
		if (!empty($entity->description)) { continue; }
		// Replace "txt" metadata by standard "description" metadata
		if (empty($entity->description)) {
			$entity->description = $entity->txt;
			$entity->txt = null;
			$processed = true;
		}
		// Ensure title is not empty
		if (empty($entity->title)) {
			$entity->title = elgg_get_excerpt($entity->txt, 32);
			$processed = true;
		}
		// Set default status (cannot be empty)
		if (empty($entity->status)) {
			$entity->status = 'open';
			$processed = true;
		}
		// About: Remove undefined values (default = no value)
		if (in_array($entity->about, ['other', 'undefined', 'feedback'])) {
			$entity->about = null;
			$processed = true;
		}
		// Mood: Remove undefined values (default = no value)
		if (in_array($entity->mood, ['other'])) {
			$entity->mood = null;
			$processed = true;
		}
		echo "{$entity->guid} {$entity->title} : OK<br />";
		// Only changes should be count as processed
		if ($processed) { $processed++; }
	}
	echo "<p>$feedbacks_count objets feedback traités ($feedbacks_count total).</p>";
	echo "Terminé.";
	return true;
}




