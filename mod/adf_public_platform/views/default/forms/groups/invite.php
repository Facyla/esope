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
if ($invite_anyone == 'yes') {
	// Dans ce cas on invite non des contacts mais qui on veut
	$friends = elgg_get_entities(array('type' => 'user', 'limit' => false));
} else {
	$friends = elgg_get_logged_in_user_entity()->getFriends('', 0);
}

if ($friends) {
	echo elgg_view('input/friendspicker', array('entities' => $friends, 'name' => 'user_guid', 'highlight' => 'all'));
	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
	echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo('invite')));
	echo '</div>';
} else {
	echo elgg_echo('groups:nofriendsatall');
}
