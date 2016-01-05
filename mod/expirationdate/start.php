<?php
/**
 * Expiration Date
 *
 * @package ExpirationDate
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt
 * @copyright Brett Profitt 2008-2015
 * @link http://eschoolconsultants.com
 *
 * (c) iionly 2012-2015 for Elgg 1.8 onwards
 */

// Initialise plugin
elgg_register_event_handler('init', 'system', 'expirationdate_init');

/**
 * Initialise the plugin.
 *
 */
function expirationdate_init() {

	// Register cron hook
	if (!elgg_get_plugin_setting('period', 'expirationdate')) {
		elgg_set_plugin_setting('period', 'fiveminute', 'expirationdate');
	}

	elgg_register_plugin_hook_handler('cron', elgg_get_plugin_setting('period', 'expirationdate'), 'expirationdate_cron');
}

/**
 * Hook for cron event.
 *
 * @param $event
 * @param $object_type
 * @param $object
 * @return unknown_type
 */
function expirationdate_cron($event, $object_type, $object) {
	$value = expirationdate_expire_entities(false) ? 'Ok' : 'Fail';
	return 'expirationdate: ' . $value;
}

/**
 * Deletes expired entities.
 * @return boolean
 */
function expirationdate_expire_entities($verbose=true) {
	$now = time();

	$access = elgg_set_ignore_access(true);
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);

	if (!$entities = elgg_get_entities_from_metadata(array('metadata_names' => 'expirationdate', 'limit' => false))) {
		// no entities that need to expire.
		return true;
	}

	foreach ($entities as $entity) {
		if ($entity->expirationdate < $now) {
			$guid = $entity->guid;
			if (!elgg_trigger_plugin_hook('expirationdate:expire_entity', $entity->type, array('entity'=>$entity), true)) {
				continue;
			}

			// call the standard delete to allow for triggers, etc.
			if ($entity->expirationdate_disable_only == 1) {
				if ($entity->disable()) {
					$return = expirationdate_unset($entity->getGUID());
					$msg = "Disabled $guid<br>\n";
				} else {
					$msg = "Couldn't disable $guid<br>\n";
				}
			} else {
				if ($entity->delete()) {
					$msg = "Deleted $guid<br>\n";
				} else {
					$msg = "Couldn't delete $guid<br>\n";
				}
			}
		} else {
			if (!elgg_trigger_plugin_hook('expirationdate:will_expire_entity', $entity->type, array('expirationdate'=>$entity->expirationdate, 'entity'=>$entity), true)) {
				continue;
			}
		}

		if ($verbose) {
			print $msg;
		}
	}
	access_show_hidden_entities($access_status);
	elgg_set_ignore_access($access);

	return true;
}

/**
 * Sets an expiration for a GUID/Id.
 *
 * @param int $id
 * @param strToTime style date $expiration
 * @return bool
 */
function expirationdate_set($id, $expiration, $disable_only=false, $type='entities') {

	$access = elgg_set_ignore_access(true);

	if (!$date=strtotime($expiration)) {
		return false;
	}

	// clear out any existing expiration
	expirationdate_unset($id, $type);
	$return = false;

	if ($type == 'entities') {
		// @todo what about disabled entities?
		// Allow them to expire?
		if (!$entity=get_entity($id)) {
			return false;
		}
		$return = create_metadata($id, 'expirationdate', $date, 'integer', -1, 2);
		$return = create_metadata($id, 'expirationdate_disable_only', $disable_only, 'integer', -1, 2);
	} else {
		// bugger all.
	}

	elgg_set_ignore_access($access);

	return $return;
}

/**
 * Removes an expiration date for an entry.
 *
 * @param $guid
 * @param $type
 * @return unknown_type
 */
function expirationdate_unset($id, $type='entities') {

	$access = elgg_set_ignore_access(true);

	if ($type == 'entities') {
		elgg_delete_metadata(array('guid' => $id, 'metadata_name' => 'expirationdate'));
		elgg_delete_metadata(array('guid' => $id, 'metadata_name' => 'expirationdate_disable_only'));
	}

	elgg_set_ignore_access($access);

	return true;
}
