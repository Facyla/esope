<?php

// Define survey URL
function survey_url(\Elgg\Hook $hook) {
	$entity = $hook->getEntityParam();
	if ($entity instanceof ElggSurvey) {
		// default to a standard view if no owner.
		if (!$entity->getOwnerEntity()) { return false; }
		$title = elgg_get_friendly_title($entity->title);
		return "survey/view/" . $entity->guid . "/" . $title;
	}
}


// Owner block menu
function survey_owner_block_menu(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$entity = $hook->getEntityParam();
	if ($entity instanceof ElggUser) {
		$url = "survey/owner/{$entity->username}";
		$item = new ElggMenuItem('survey', elgg_echo('survey'), $url);
		$return[] = $item;
	} else {
		if (survey_activated_for_group($entity)) {
			$url = "survey/group/{$entity->guid}";
			$item = new ElggMenuItem('survey', elgg_echo('survey:group_survey'), $url);
			$return[] = $item;
		}
	}
	return $return;
}


// Register title urls for widgets
function survey_widget_urls(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$widget = $hook->getEntityParam();

	if (empty($return) && ($widget instanceof ElggWidget)) {
		$owner = $widget->getOwnerEntity();
		switch($widget->handler) {
			case "survey":
				if ($owner instanceof ElggUser) {
					$return = "/survey/owner/{$owner->username}";
				} else {
					$return = "/survey";
				}
				break;
			case "latestsurvey":
			case "survey_individual":
			case "latestsurvey_index":
			case "survey_individual_index":
				$return = "/survey";
				break;
			case "latestgroupsurvey":
				if ($owner instanceof ElggGroup) {
					$return = "/survey/group/{$owner->guid}";
				} else {
					$return = "/survey/owner/{$owner->username}";
				}
				break;
		}
	}
	return $return;
}


/**
 * Prepare a notification message about a created survey
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg_Notifications_Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg_Notifications_Notification
 */
function survey_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$notification->subject = elgg_echo('survey:notify:subject', array($entity->title), $language);
	$notification->body = elgg_echo('survey:notify:body', array(
		$owner->name,
		$entity->title,
		$entity->getURL()
	), $language);
	$notification->summary = elgg_echo('survey:notify:summary', array($entity->title), $language);

	return $notification;
}


