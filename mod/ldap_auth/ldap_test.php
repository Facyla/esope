<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

// Limited to admin !
admin_gatekeeper();

$username = get_input('username', false);
if (!$username) {
	$user = elgg_get_logged_in_user_entity();
	$username = $user->username;
} else {
	$user = get_user_by_username($username);
}
$password = get_input('password', false);

header('Content-type: text/html; charset=utf-8');
echo '<form method="POST">
	<input type="text" name="username" placeholder="username" value="' . $username . '">
	<input type="text" name="password" placeholder="password" value="' . $password . '">
	<input type="submit" value="Tester vec ces valeurs">
	</form>';

echo "<h2>User info for $username</h2>";

echo "<h3>Elgg user info</h3>";
if (elgg_instanceof($user, "user")) {
	echo "Créé : " . elgg_view_friendly_time($user->time_created) . '<hr />';
	echo "Mis à jour : " . elgg_view_friendly_time($user->time_updated) . '<hr />';
	echo "Dernière action : " . elgg_view_friendly_time($user->last_action) . '<hr />';
	echo "Avant-dernière action : " . elgg_view_friendly_time($user->prev_last_action) . '<hr />';
	echo "Dernier login : " . elgg_view_friendly_time($user->last_login) . '<hr />';
	echo "Avant-dernier login : " . elgg_view_friendly_time($user->prev_last_login) . '<hr />';

	echo "Type de compte : " . $user->membertype . '<hr />';
	echo "Statut du compte : " . $user->memberstatus . '<hr />';
} else echo "Pas de compte à ce nom<hr />";

// Tests LDAP
if (elgg_is_active_plugin('ldap_auth') || function_exists('ldap_auth_login')) {
	elgg_load_library("elgg:ldap_auth");
	
	echo "<h3>LDAP settings</h3>";
	
	//Test new config
	$auth_settings = array('host' => 'ldaps://ildap.inria.fr', 'port' => 636, 'version' => 3, 'basedn' => 'ou=people,dc=inria,dc=fr');
	$mail_settings = array('host' => 'ldaps://ildap.inria.fr', 'port' => 636, 'version' => 3, 'basedn' => 'ou=contacts,dc=inria,dc=fr');
	$info_settings = array('host' => 'ldaps://ildap.inria.fr', 'port' => 636, 'version' => 3, 'basedn' => 'ou=contacts,dc=inria,dc=fr');
	
	//Current config
/*
	$auth_settings = ldap_auth_settings_auth();
	$mail_settings = ldap_auth_settings_mail();
	$info_settings = ldap_auth_settings_info();
*/
	echo '<pre>Settings AUTH : ' . print_r($auth_settings, true) . '</pre>';
	echo '<pre>Settings MAIL : ' . print_r($mail_settings, true) . '</pre>';
	echo '<pre>Settings INFO : ' . print_r($info_settings, true) . '</pre>';
	

	$ldap_people_fields = array(
		'givenName' => 'firstname',
		'sn' => 'lastname',
		'cn' => 'inria_name',
		//'telephoneNumber' => 'inria_phone', // multiple
		//'roomNumber' => 'inria_room', // multiple
		'inriagroupmemberof' => 'epi_ou_service',
		'ou' => 'inria_location', // organisation (lieu)
		//'l' => 'inria_location', // deprecated ?

		//'displayName' => 'inria_name2', // same as cn
		//'mobile' => 'mobile',
		'mail' => 'email',
		//'secretary' => 'secretary',
		'uid' => 'ldap_uid',
	);
	
	$ldap_contacts_fields = array(
		'givenName' => 'firstname',
		'sn' => 'lastname',
		'cn' => 'inria_name',
		'telephoneNumber' => 'inria_phone', // multiple
		'telephoneNumber;x-location-ad0015r' => 'inria_phone', // multiple
		'telephoneNumber;x-location-ad0010a' => 'inria_phone', // multiple
		'telephoneNumber;x-location-ad00110' => 'inria_phone', // multiple
		'roomNumber' => 'inria_room', // multiple
		//'inriagroupmemberof' => 'epi_ou_service',
		'ou' => 'inria_location', // organisation (lieu)
		//'l' => 'inria_location', // deprecated ?

		'displayName' => 'inria_name2', // same as cn
		//'mobile' => 'mobile',
		'mail' => 'email',
		'secretary' => 'secretary',
		'uid' => 'ldap_uid',
	);

	
	echo "<h3>LDAP functions tests</h3>";
	
	if (ldap_user_exists($username)) $ldap_user_exists = "TRUE"; else $ldap_user_exists = "FALSE";
	echo "<p><strong>Testing 'ldap_user_exists(username)' :</strong> $ldap_user_exists</p>";
	
	if (ldap_auth_is_active($username)) $ldap_auth_is_active = "TRUE"; else $ldap_auth_is_active = "FALSE";
	echo "<p><strong>Testing 'ldap_auth_is_active(username)' :</strong> $ldap_auth_is_active</p>";
	
	if (ldap_auth_is_valid($username, $password)) $ldap_auth_is_valid = "TRUE"; else $ldap_auth_is_valid = "FALSE";
	echo "<p><strong>Testing 'ldap_auth_is_valid(username, password)' :</strong> $ldap_auth_is_valid</p>";
	
	$ldap_get_email = ldap_get_email($username);
	echo "<p><strong>Testing 'ldap_get_email(username)' :</strong> $ldap_get_email</p>";
	
	$user_infos = ldap_get_search_infos("inriaLogin=$username", $auth_settings, array('*'));
	echo "<p><strong>Testing 'ldap_get_search_infos(criteria, auth_settings, attributes)' :</strong> <pre>" . print_r($user_infos, true) . "</pre></p>";
	
	$user_infos = ldap_get_search_infos("mail=$ldap_get_email", $mail_settings, array_keys('*'));
	echo "<p><strong>Testing 'ldap_get_search_infos(criteria, mail_settings, attributes)' :</strong> <pre>" . print_r($user_infos, true) . "</pre></p>";
	
	$user_infos = ldap_get_search_infos("mail=$ldap_get_email", $info_settings, array('*'));
	echo "<p><strong>Testing 'ldap_get_search_infos(criteria, info_settings, attributes)' :</strong> <pre>" . print_r($user_infos, true) . "</pre></p>";
	
	if (ldap_auth_is_active($username)) {
		//echo inria_check_and_update_user_status('login', 'user', $user);
		echo ldap_auth_check_profile($user);
	}
	
	// ldap_auth_create_profile($username, $password)
	// ldap_auth_check_profile(ElggUser $user)
	// ldap_auth_update_profile(ElggUser $user, Array $ldap_infos, Array $ldap_mail, Array $fields)
	// ldap_auth_clean_group_name(array $infos)
	
	// Update inria user
	//inria_check_and_update_user_status($event, $object_type, $user);
	
	//ldap_auth_check_profile($user);

} else {
	echo "Plugin LDAP inactif.";
}

