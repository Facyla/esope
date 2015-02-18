<?php
/**
 * Elgg LDAP settings template file
 * @filesource settings.php
 * @package Elgg.ldap_auth
 * @author Simon Bouland <simon.bouland@inria.fr>
 * @author Florian DANIEL <facyla@gmail.com>
 */

/* @TODO Instructions
 * Search for "ToBeCompleted" and replace with your installation values
 * You may change and/or add new fields in the .._fields() functions
 */

/** Parameters for LdapServer construct.
 *  Authentication server : should be able to return at least username + email
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


/** Parameters for LdapServer construct.
 * Info server : should return detailed user fields (optional)
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



/** Authenticate server: matching between LDAP fields and Elgg ones.
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth_fields() {
	return array(
		'cn' => 'name',
		'inriagroupmemberof' => 'ToBeCompleted',
		'ou' => 'location',
		// ToBeCompleted
	);
}

/** Info server: matching between LDAP fields and Elgg ones.
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
		// ToBeCompleted
	);
}

