<?php
/**
 * Elgg groups invite form
 *
 * @package ElggGroups
 */

$group = $vars['entity'];
$owner = $group->getOwnerEntity();
$forward_url = $group->getURL();
$invite_anyone = elgg_get_plugin_setting('invite_anyone', 'esope');
$allowregister = elgg_get_plugin_setting('allowregister', 'esope');

if ($invite_anyone != 'yes') {
	$friends = elgg_get_logged_in_user_entity()->getFriends('', 0);
} else {
	// Dans ce cas on invite non des contacts mais qui on veut
	$friends = elgg_get_entities(array('type' => 'user', 'limit' => false));
}

if ($friends) {
	echo elgg_view('input/friendspicker', array('entities' => $friends, 'name' => 'user_guid', 'highlight' => 'all'));
	if ($allowregister == 'yes') {
		echo ' <p><label>' . elgg_echo('esope:groups:allowregister') . '</label> ' . elgg_view('input/dropdown', array('name' => 'group_register', 'options_values' => array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') ))) . '</p>';
	}
	
	echo '<div class="elgg-foot">';
	echo elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
	echo elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo('invite')));
	echo '</div>';
} else {
	echo elgg_echo('groups:nofriendsatall');
}
