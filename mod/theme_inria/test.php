<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

$username = get_input('username', false);

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
	echo "LDAP infos : ";
	$auth = new LdapServer(ldap_auth_settings_auth());
	if ($auth->bind()) {
		$result = $auth->search('inriaLogin=' . $user->username, array('inriaentrystatus'));
		if ($result) {
			echo print_r($result, true);
		}
	}
	echo '<hr />';
}

