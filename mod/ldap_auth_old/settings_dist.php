<?php
/**
 * Elgg LDAP settings
 * @filesource settings.php
 * @package Elgg.ldap_auth
 * @author Simon Bouland <simon.bouland@inria.fr>
 */

/**
 *  Parameters for LdapServer construct.
 *	Mail server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_mail(){
	return array(	'host' => 'ldaps://ToBeCompleted',
 					'port' => 636,
 					'version' => 3,
 					'basedn' => 'ToBeCompleted' );
}

/**
 *  Parameters for LdapServer construct.
 *	Annuaire server
 * 
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info(){
	return array(	'host' => 'ToBeCompleted',
 					'port' => 9009,
					'version' => 3,
 					'basedn' => 'ToBeCompleted' );
}

/**
 *  Parameters for LdapServer construct.
 *  Authenticate server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth(){
	return array(	'host' => 'ldaps://ToBeCompleted',
 					'port' => 636,
					'version' => 3,
 					'basedn' => 'ToBeCompleted' );
}

/**
 *  matching between LDAP fields and Elgg ones.
 *  Annuaire server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info_fields()
{
	return array('cn' => 'name',
				'ou' => 'ToBeCompleted',
				'l' => 'location',
				'roomNumber' => 'room',
				'telephoneNumber' => 'phone');
}

/**
 *  matching between LDAP fields and Elgg ones.
 *  Authenticate server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth_fields()
{
	return array(	'cn' => 'name',
			'inriagroupmemberof' => 'ToBeCompleted',
			'ou' => 'location');
}
