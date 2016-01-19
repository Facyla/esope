<?php

/*
 * People usort callback
 */
function recommendations_sorter($a, $b){
	if ($a['priority'] == $b['priority']) {
		return 0;
	}
	return ($a['priority'] < $b['priority']) ? 1 : -1;
}


/** Recommends people - based on mutual friends and common groups
 *
 * Returns array of people containing entity, users (friends), groups (shared) and priority
 * @param ElggUser $user
 * @param Int $recommendations_limit - number of friends/groups checked, per user's friend (accuracy)
 * @param Int $limit - number of elements returned
 * @return Array
 */
function recommendations_get_users($user = false, $recommendations_limit = 30, $limit = 20) {
	// 20110922 - Facyla : friends and groups limits should be understood as an accuracy setting, while $limit is a display limiter. They have a direct effect on performances, but also on results accuracy.
	// For best results, use a friends number close to the real number of friends (about 30 should be fine enough)
	// and a groups number close to the real number of uisers in groups (about 50 but this might have a more direct effect on server load than	friends, so we default to much lower)
	// retrieve all users friends,
	
	if (!$user && elgg_is_logged_in()) { $user = elgg_get_logged_in_user_entity(); }
	if (!elgg_instanceof($user, 'user')) { return false; }
	
	$guid = $user->guid;
	$dbprefix = elgg_get_config('dbprefix');
	
	$options = array(
		'type' => 'user',
		'relationship' => 'friend',
		'relationship_guid' => $guid,
		'wheres' => "u.banned = 'no'",
		'joins' => "INNER JOIN {$dbprefix}users_entity u USING (guid)",
		'order_by' => 'u.last_action DESC',
		'limit' => 0,
	);
	$friends = elgg_get_entities_from_relationship($options);
	
	// generate a guids array of user's friends
	$in_a = array($guid);
	if ($friends) foreach ($friends as $friend) {
		$in_a[] = $friend->guid;
	}
	$in = implode(',', $in_a);
	
	$people = array();

	/* search by mutual friends */
	if ($friends) foreach ($friends as $friend) {
		// retrieve 3 friends of each friend (discarding the users friends)
		$fof = elgg_get_entities_from_relationship(array(
			'type' => 'user',
			'relationship' => 'friend',
			'relationship_guid' => $friend->guid,
			'wheres' => array(
				"e.guid NOT IN ($in)",
				"u.banned = 'no'"
			),
			'joins' => "INNER JOIN {$dbprefix}users_entity u USING (guid)",
			'order_by' => 'u.last_action DESC',
			'limit' => $recommendations_limit
		));
		
		if (is_array($fof) && count($fof) > 0) {
			// populate $people
			foreach ($fof as $f) {
				if (isset($people[$f->guid])) {
					// if the current person is present in $people, increase the priority and attach the common friend entity
					$people[$f->guid]['mutuals'][] = $friend;
					++$people[$f->guid]['priority'];
				} else {
					$people[$f->guid] = array(
						'entity' => $f,
						'mutuals' => array($friend),
						'groups' => array(),
						'priority' => 0
					);
				}
			}
		}
	}
	unset($friends);

	/* search by groups */
	// retrieve ($groups_limit) user's groups
	$options = array(
		'type' => 'group',
		'relationship' => 'member',
		'relationship_guid' => $guid,
		'order_by' => 'time_created DESC',
		'limit' => 0,
	);
	$groups = elgg_get_entities_from_relationship($options);
	if (is_array($groups) && count($groups) > 0) {
		foreach ($groups as $group) {
			// retrieve some members of each group (discarding the users friends)
			$members = elgg_get_entities_from_relationship(array(
				'type' => 'user',
				'relationship' => 'member',
				'relationship_guid' => $group->guid,
				'inverse_relationship' => TRUE,
				'wheres' => array(
					"e.guid NOT IN ($in)",
					"u.banned = 'no'"
				),
				'joins' => "INNER JOIN {$dbprefix}users_entity u USING (guid)",
				'order_by' => 'u.last_action DESC',
				'limit' => $recommendations_limit
			));
			if (is_array($members) && count($members) > 0) {
				// populate $people
				foreach ($members as $member) {
					if (isset($people[$member->guid])) {
						// if the current person is present in $people, increase the priority and attach the common group entity
						$people[$member->guid]['groups'][] = $group;
						++$people[$member->guid]['priority'];
					} else {
						$people[$member->guid] = array(
							'entity' => $member,
							'mutuals' => array(),
							'groups' => array($group),
							'priority' => 0
						);
					}
				}
			}
		}
	}
	unset($groups);
	
	// sort by priority
	usort($people, 'recommendations_sorter');
	
	return array_slice($people, 0, $limit);
}



