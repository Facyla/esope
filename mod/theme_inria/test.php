<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

gatekeeper();

$username = get_input('username', false);
if (!$username) $username = elgg_get_logged_in_user_entity()->username;

$user = get_user_by_username($username);

//echo inria_update_user_status('login', 'user', $user);

echo "Créé : " . elgg_view_friendly_time($user->time_created) . '<hr />';
echo "Mis à jour : " . elgg_view_friendly_time($user->time_updated) . '<hr />';
echo "Dernière action : " . elgg_view_friendly_time($user->last_action) . '<hr />';
echo "Avant-dernière action : " . elgg_view_friendly_time($user->prev_last_action) . '<hr />';
echo "Dernier login : " . elgg_view_friendly_time($user->last_login) . '<hr />';
echo "Avant-dernier login : " . elgg_view_friendly_time($user->prev_last_login) . '<hr />';

echo "Type de compte : " . $user->membertype . '<hr />';
echo "Statut du compte : " . $user->memberstatus . '<hr />';

if (elgg_is_active_plugin('ldap_auth')) {
	echo "LDAP infos :<br />";

	$auth = new LdapServer(ldap_auth_settings_auth());
	$mail = new LdapServer(ldap_auth_settings_mail());
	$info = new LdapServer(ldap_auth_settings_info());
	
	echo "AUTH infos :<br />";
	if ($auth->bind()) {
		$result = $auth->search('inriaLogin=' . $user->username, array_keys(ldap_auth_settings_auth_fields()));
		if ($result) { echo print_r($result, true); }
	}
	
	echo "MAIL infos :<br />";
	if ($mail->bind()) {
		$ldap_mail = $mail->search('inriaLogin=' .  $user->username, array('inriaMail'));
		echo "LDAP mail : $ldap_mail<br />";
		$result = $info->search('mail=' . $ldap_mail[0]['inriaMail'][0], array_keys(ldap_auth_settings_info_fields()));
		if ($result) { echo print_r($result, true); }
	}
	
	echo "INFO infos :<br />";
	if ($info->bind()) {
		$result = $auth->search('inriaLogin=' . $user->username, array_keys(ldap_auth_settings_auth_fields()));
		if ($result) { echo print_r($result, true); }
	}
	
	echo '<hr />';
}

