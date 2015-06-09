<?php
/**
 * Provide a way of setting your email
 *
 * @package Elgg
 * @subpackage Core
 */

$user = elgg_get_page_owner_entity();

if ($user) {
	// Inria member email is updated by LDAP - can't be changed
	// Admin users can change it anyway (data does not necessarly come from LDAP + admin need to restore broken email)
	if ((esope_get_user_profile_type($user) != 'inria') || elgg_is_admin_logged_in()) {
		$title = elgg_echo('email:settings');
		$content = elgg_echo('email:address:label') . ': ';
		$content .= elgg_view('input/email', array(
			'name' => 'email',
			'value' => $user->email,
		));
		echo elgg_view_module('info', $title, $content);
	} else {
		echo elgg_view('input/hidden', array('name' => 'email', 'value' => $user->email));
	}
}
