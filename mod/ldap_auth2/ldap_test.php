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

header('Content-type: text/html; charset=utf-8');
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
if (elgg_is_active_plugin('ldap_auth')) {
	
	echo "<h3>LDAP functions tests</h3>";
	
	if (ldap_user_exists($username)) $ldap_user_exists = "TRUE"; else $ldap_user_exists = "FALSE";
	echo "<p><strong>Testing 'ldap_user_exists(username)' : $ldap_user_exists</h3>";
	
	if (ldap_auth_is_closed($username) {) $ldap_auth_is_closed = "TRUE"; else $ldap_auth_is_closed = "FALSE";
	echo "<p><strong>Testing 'ldap_auth_is_closed(username)' : $ldap_auth_is_closed</h3>";
	
	if (ldap_auth_is_valid($username, $password)) $ldap_auth_is_valid = "TRUE"; else $ldap_auth_is_valid = "FALSE";
	echo "<p><strong>Testing 'ldap_auth_is_valid(username, password)' : $ldap_auth_is_valid</h3>";
	
	// ldap_auth_create_profile($username, $password)
	// ldap_auth_check_profile(ElggUser $user)
	// ldap_auth_update_profile(ElggUser $user, Array $ldap_infos, Array $ldap_mail, Array $fields)
	// ldap_auth_clean_group_name(array $infos)
	
	echo "<h3>LDAP settings tests</h3>";
	
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
	
	// Update inria user
	//inria_check_and_update_user_status($event, $object_type, $user);
	
	elgg_load_library("elgg:ldap_auth");
	//ldap_auth_check_profile($user);


	$auth = new LdapServer($auth_settings);
	$mail = new LdapServer($mail_settings);
	$info = new LdapServer($info_settings);
	
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


	echo '<pre>';
	if ( $info->bind() && $auth->bind() && $mail->bind()) {
		echo "<br />BIND OK";

                echo "<br />BASE infos (from people branch) :<br />";
                $ldap_mail = $auth->search('inriaLogin=' . $username, array('mail', 'uid'));
                $user_mail = $ldap_mail[0]['mail'][0];
                $user_uid = $ldap_mail[0]['uid'][0];
                echo "<br />Email : $user_mail<br />";
                echo "UID : $user_uid<br /><br />";

		echo "<br />AUTH infos : (people branch, based on username)<br />";
//		$result = $auth->search('inriaLogin=' . $username, array_keys($ldap_people_fields));
		$result = $auth->search('inriaLogin=' . $username);
		if ($result) { echo print_r($result, true); }
		
		echo "<br /><br />MAIL infos : (contacts branch, based on user UID)<br />";
		//$result = $mail->search('mail=' . $user_mail, array_keys(ldap_contacts_fields));
//		$result = $mail->search('uid=' . $user_uid, array_keys($ldap_contacts_fields));
		$result = $mail->search('uid=' . $user_uid);
		if ($result) { echo print_r($result, true); }
	
		echo "<br /><br />INFO infos : (contacts branch, based on user UID)<br />";
		//$result = $info->search('mail=' . $user_mail, array_keys($ldap_contacts_fields));
//		$result = $info->search('uid=' . $user_uid, array_keys($ldap_contacts_fields));
		$result = $info->search('uid=' . $user_uid);
		if ($result) { echo print_r($result, true); }

		echo "<br /><br />Locality infos : (contacts branch on objectClass=locality)<br />";
		$result = $info->search('objectClass=locality', array('l', 'description'));
		if ($result) {
			foreach($result as $num => $locality) {echo "{$locality['l'][0]} => {$locality['description'][0]}\n"; }
			//echo print_r($result, true);
		}
	}
	echo '</pre>';
	
	echo '<hr />';
}

