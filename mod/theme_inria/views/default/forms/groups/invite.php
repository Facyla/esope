<?php
/**
 * Elgg groups invite form
 *
 * @package ElggGroups
 */

$group = $vars['entity'];
$owner = $group->getOwnerEntity();
$forward_url = $group->getURL();
$invite_anyone = elgg_get_plugin_setting('invite_anyone', 'adf_public_platform');
$allowregister = elgg_get_plugin_setting('allowregister', 'adf_public_platform');
$invite_picker = elgg_get_plugin_setting('invite_picker', 'adf_public_platform');

$own = elgg_get_logged_in_user_entity();
$ownguid = elgg_get_logged_in_user_guid();

// Count first, so we can get actual users only if count is reasonnable
if ($invite_anyone != 'yes') {
	$users_count = elgg_get_entities_from_relationship(array(
			'relationship' => 'friend', 'relationship_guid' => $ownguid,
			'type' => 'user', 'subtype' => '', 'count' => true
		));
} else {
	// Dans ce cas on invite non des contacts mais qui on veut
	$users_count = elgg_get_entities(array('type' => 'user', 'limit' => 0, 'count' => true));
}

// Selon le nombre de personnes, on peut forcer un sélecteur plus léger en mémoire
if ($users_count > 500) { $invite_picker = 'userpicker'; }

if ($users_count > 0) {
	// Use prefered or memory-friendly picker depending on custom setting and users number
	switch($invite_picker) {
		case 'userpicker':
			// Note : userpicker uses always 'members[]' name, so the actions must be updated too
			// Action is properly overriden in esope, but care to themes !
			echo '<p>' . elgg_echo('theme_inria:invitegroups:help') . '</p>';
			// Force friends only selector (will apply anyway in the action)
			if ($invite_anyone != 'yes') {
				echo elgg_view('input/userpicker', array());
			} else {
				echo elgg_view('input/userpicker', array('friends_only' => 'yes_force'));
			}
			break;
		
		default:
			if ($invite_anyone != 'yes') {
				$users = elgg_get_logged_in_user_entity()->getFriends('', 0);
			} else {
				// Dans ce cas on invite non des contacts mais qui on veut
				$users = elgg_get_entities(array('type' => 'user', 'limit' => 0));
			}
			echo elgg_view('input/friendspicker', array('entities' => $users, 'name' => 'user_guid', 'highlight' => 'all'));
	}
	
	// Allow direct registration
	if ($allowregister == 'yes') {
		echo ' <p><label>' . elgg_echo('adf_platform:groups:allowregister') . '</label> ' . elgg_view('input/dropdown', array('name' => 'group_register', 'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ))) . '</p>';
	}
	
	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
	echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo('invite')));
	echo '</div>';
} else {
	echo elgg_echo('groups:nofriendsatall');
}
