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
	return array(	'host' => 'ldaps://ildap.inria.fr',
 					'port' => 636,
 					'version' => 3,
 					'basedn' => 'ou=service-mail,dc=inria,dc=fr' );
}

/**
 *  Parameters for LdapServer construct.
 *	Annuaire server
 * 
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info(){
	return array(	'host' => 'annuaire.inria.fr',
 					'port' => 9009,
					'version' => 3,
 					'basedn' => 'dc=rocq-annu,dc=inria,dc=fr' );
}

/**
 *  Parameters for LdapServer construct.
 *  Authenticate server
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth(){
	return array(	'host' => 'ldaps://ildap.inria.fr',
 					'port' => 636,
					'version' => 3,
 					'basedn' => 'ou=people,dc=inria,dc=fr' );
}

/**
 *  matching between LDAP fields and Elgg ones.
 *  Annuaire server
 * Note : Some fields marked as specific, as they cannot be edited by the user 
 * (need to preserve location for geolocation tools)
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_info_fields()
{
	return array('cn' => 'name',
				'ou' => 'epi_ou_service',
				'l' => 'inria_location',
				'roomNumber' => 'inria_room',
				'telephoneNumber' => 'inria_phone');
}

/**
 *  matching between LDAP fields and Elgg ones.
 *  Authenticate server
 * Note : Some fields marked as specific, as they cannot be edited by the user 
 * (need to preserve location for geolocation tools)
 *
 * @return array Options ('host', 'port', 'version', 'basedn')
 */
function ldap_auth_settings_auth_fields()
{
	return array(	'cn' => 'name',
			'inriagroupmemberof' => 'epi_ou_service',
			'ou' => 'inria_location');
}
