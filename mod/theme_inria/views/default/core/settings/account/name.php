<?php
/**
 * Provide a way of setting your full name.
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();
if ($user) {
	// Inria member name is updated through LDAP - can't be changed
	// Admin users can change it anyway (data does not necessarly come from LDAP)
	if ((esope_get_user_profile_type($user) != 'inria') || elgg_is_admin_logged_in()) {
		$title = elgg_echo('user:name:label');
		$content = elgg_echo('name') . ': ';
		$content .= elgg_view('input/text', array(
			'name' => 'name',
			'value' => $user->name,
		));
		echo elgg_view_module('info', $title, $content);
	} else {
		echo elgg_view('input/hidden', array('name' => 'name', 'value' => $user->name));
	}
	
	// need the user's guid to make sure the correct user gets updated
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $user->guid));
}
