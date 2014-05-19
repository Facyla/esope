<?php
/**
 * Elgg LDAP settings template file
 * @filesource settings.php
 * @package Elgg.ldap_auth
 * @author Simon Bouland <simon.bouland@inria.fr>
 * @author Florian DANIEL <facyla@gmail.com>
 */

/**
 *  Parameters for LdapServer construct.
 *  Authenticate server : should be able to return at least username + email
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth() {
	return array(
		'host' => 'ldaps://ToBeCompleted',
		'port' => 636,
		'version' => 3,
		'basedn' => 'ToBeCompleted',
	);
}


/**
 *  Parameters for LdapServer construct.
 *	Info server : should return detailed user fields (optional)
 * 
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info() {
	return array(
		'host' => 'ToBeCompleted',
		'port' => 9009,
		'version' => 3,
		'basedn' => 'ToBeCompleted',
	);
}



/**
 *  matching between LDAP fields and Elgg ones.
 *  Authenticate server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth_fields() {
	return array(
		'cn' => 'name',
		'inriagroupmemberof' => 'ToBeCompleted',
		'ou' => 'location',
	);
}

/**
 *  matching between LDAP fields and Elgg ones.
 *  Info server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info_fields() {
	return array(
		'cn' => 'name',
		'ou' => 'ToBeCompleted',
		'l' => 'location',
		'roomNumber' => 'room',
		'telephoneNumber' => 'phone',
	);
}

