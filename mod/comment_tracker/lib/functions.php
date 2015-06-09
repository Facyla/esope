<?php

/**
 * Check whether user has subscribed
 *
 * @param ElggUser   $user   The user
 * @param ElggEntity $entity The target entity
 * @return bool
 */
function comment_tracker_is_subscribed($user, $entity) {
	if (!$user instanceof ElggUser) {
		return false;
	}

	if (!$entity instanceof ElggEntity) {
		return false;
	}

	$result = check_entity_relationship($user->guid, COMMENT_TRACKER_RELATIONSHIP, $entity->guid);

	$params = array(
		'user' => $user,
		'entity' => $entity,
	);

	// allow other plugins to affect the behaviour
	return elgg_trigger_plugin_hook('subscription_check', 'comment_tracker', $params, $result);
}

/**
 * Check whether user has explicitly unsubscribed
 *
 * @param ElggUser   $user   The user
 * @param ElggEntity $entity The target entity
 * @return bool
 */
function comment_tracker_is_unsubscribed($user, $entity) {
	if (!$user instanceof ElggUser) {
		return false;
	}

	if (!$entity instanceof ElggEntity) {
		return false;
	}

	$result = check_entity_relationship($user->guid, COMMENT_TRACKER_UNSUBSCRIBE_RELATIONSHIP, $entity->guid);

	$params = array(
		'user' => $user,
		'entity' => $entity,
	);

	// allow other plugins to affect the behaviour
	return elgg_trigger_plugin_hook('unsubscription_check', 'comment_tracker', $params, $result);
}

/**
 * Notify subscribed users with their preferred notification methods
 */
function comment_tracker_notify($annotation, $ann_user, $params = array()) {
	global $NOTIFICATION_HANDLERS, $CONFIG;

	if (!($annotation instanceof ElggAnnotation)) {
		return false;
	}

	$entity = get_entity($annotation->entity_guid);

	if (elgg_instanceof($entity, 'object')) {

		$container = get_entity($entity->container_guid);
		if (elgg_instanceof($entity, 'object', 'groupforumtopic')) {
			$subject = elgg_echo('comment:notify:subject:groupforumtopic', array(
				$ann_user->name,
				$entity->title,
				$container->name
			));
		}
		else {
			$content_type = elgg_echo($entity->getSubtype());
			if ($content_type == $entity->getSubtype()) {
				// wasn't translated that way, try item:object:subtype
				$content_type = elgg_echo('item:object:'.$entity->getSubtype());

				if ($content_type == 'item:object:'.$entity->getSubtype()) {
					$content_type = elgg_echo('comment_tracker:item');
				}
			}

			// construct subject for an entity
			if (elgg_instanceof($container, 'group')) {
				// see if we have a specific language string first
				// if not fall back to a generic one
				$key = 'comment:notify:subject:' . $entity->getSubtype() . ':group';
				if (elgg_echo($key) != $key) {
					// we have a specific subject
					$subject = elgg_echo($key, array(
						$ann_user->name,
						$entity->title ? $entity->title : $entity->name,
						$container->name
					));
				}
				else {
					// we don't have a specific subject, use generic
					$subject = elgg_echo('comment:notify:subject:comment:group', array(
						$ann_user->name,
						$content_type,
						$entity->title ? $entity->title : $entity->name,
						$container->name
					));
				}
			}
			else {
				// see if we have a specific language string first
				// if not fall back to a generic one
				$key = 'comment:notify:subject:' . $entity->getSubtype();
				if (elgg_echo($key) != $key) {
					$subject = elgg_echo($key, array(
						$ann_user->name,
						$content_type,
						$entity->title ? $entity->title : $entity->name
					));
				}
				else {
					$subject = elgg_echo('comment:notify:subject:comment', array(
						$ann_user->name,
						$content_type,
						$entity->title ? $entity->title : $entity->name
					));
				}
			}
		}

		$entity_link = elgg_view('output/url', array(
			'href' => $entity->getUrl(),
			'text' => $entity->title,
		));

		$commenter_link = elgg_view('output/url', array(
			'href' => $ann_user->getUrl(),
			'text' => $ann_user->name,
		));

		$options = array(
			'relationship' => COMMENT_TRACKER_RELATIONSHIP,
			'relationship_guid' => $annotation->entity_guid,
			'inverse_relationship' => true,
			'types' => 'user',
			'limit' => 0
		);

		$users = elgg_get_entities_from_relationship($options);
		$notify_owner = elgg_get_plugin_setting('notify_owner', 'comment_tracker');

		$result = array();
		foreach ($users as $user) {
			// Make sure user is real
			// Do not notify the author of comment
			if ($user instanceof ElggUser && $user->guid != $ann_user->guid) {
				if (($user->guid == $entity->owner_guid) && $notify_owner != 'yes') {
					// user is the owner of the entity being commented on
					continue;
				}

				$notify_settings_link = elgg_get_site_url() . "notifications/personal/{$user->username}";

				// Results for a user are...
				$result[$user->guid] = array();

				foreach ($NOTIFICATION_HANDLERS as $method => $details)	{
					if (check_entity_relationship($user->guid, 'block_comment_notify'.$method, $CONFIG->site_guid))	{
						continue;
					}

					$from = $ann_user;
					switch ($method) {
						case 'sms':
						case 'site':
						case 'web':
							$message = elgg_echo("comment:notify:{$group_lang}body:web", array(
								$user->name,
								$entity_link,
								$commenter_link,
								$annotation->value,
								$entity->getUrl(),
								$notify_settings_link,
								$notify_unsubscribe_link
							));
							break;
						case 'email':
						default:
							$message = elgg_echo("comment:notify:{$group_lang}body:email:text", array(
								$user->name,
								$entity_link,
								$commenter_link,
								$annotation->value,
								$entity->getUrl(),
								$CONFIG->sitename,
								$notify_settings_link,
								$notify_unsubscribe_link
							));
							if (empty($group_lang)) {
								$from = $CONFIG->site;
							}
							break;
					}

					// Extract method details from list
					$handler = $details->handler;

					if ((!$NOTIFICATION_HANDLERS[$method]) || (!$handler)) {
						error_log(sprintf(elgg_echo('NotificationException:NoHandlerFound'), $method));
					}

					elgg_log("Sending message to {$user->guid} using $method");

					// Trigger handler and retrieve result.
					try {
						$result[$user->guid][$method] = $handler(
							$from , 	// From entity
							$user, 		// To entity
							$subject,	// The subject
							$message, 	// Message
							$params		// Params
						);
					} catch (Exception $e) {
						error_log($e->getMessage());
					}
				}
			}
		}
		return $result;
	}
	return false;
}

/**
 * Subscribe user to notifications
 *
 * @param int $user_guid   The user that it subscribing
 * @param int $entity_guid The entity being subscribed to
 * @return bool
 */
function comment_tracker_subscribe($user_guid, $entity_guid) {
	if (!elgg_is_logged_in()) {
		return false;
	}

	if (empty($entity_guid)) {
		return false;
	}

	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}

	if (!check_entity_relationship($user_guid, COMMENT_TRACKER_RELATIONSHIP, $entity_guid)) {
		// Possible subscription block is not needed anymore
		remove_entity_relationship($user_guid, COMMENT_TRACKER_UNSUBSCRIBE_RELATIONSHIP, $entity_guid);

		return add_entity_relationship($user_guid, COMMENT_TRACKER_RELATIONSHIP, $entity_guid);
	}

	return false;
}

/**
 * Unsubscribe user from notifications
 *
 * @param int $user_guid   The user that unsubscribes
 * @param int $entity_guid The entity being unsubscribed from
 * @return bool
 */
function comment_tracker_unsubscribe($user_guid, $entity_guid) {
	if (!elgg_is_logged_in()) {
		return false;
	}

	if (empty($entity_guid)) {
		return false;
	}

	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}

	if (check_entity_relationship($user_guid, COMMENT_TRACKER_RELATIONSHIP, $entity_guid)) {
		// Prevent automatic subscription
		add_entity_relationship($user_guid, COMMENT_TRACKER_UNSUBSCRIBE_RELATIONSHIP, $entity_guid);

		return remove_entity_relationship($user_guid, COMMENT_TRACKER_RELATIONSHIP, $entity_guid);
	}

	return false;
}

/**
 * Get object subtypes that can be subscribed to
 *
 * Pre-populates the list with some common plugin objects and allows
 * other plugins to add/remove subtypes vie plugin hook.
 *
 * @return array $subscription_subtypes
 */
function comment_tracker_get_entity_subtypes() {
	static $subscription_subtypes;

	if (!$subscription_subtypes) {
		$base_types = array(
			'blog',
			'bookmarks',
			'event_calendar',
			'file',
			'groupforumtopic',
			'image', // tidypics
			'page',
			'page_top',
			'poll',
		);

		// other plugins can add allowed object subtypes in this hook
		$subscription_subtypes = elgg_trigger_plugin_hook('subscription_types', 'comment_tracker', array(), $base_types);
	}

	return $subscription_subtypes;
}
