<?php
/**
 * shorturls plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.fr/
 */

// Init plugin
elgg_register_event_handler('init', 'system', 'shorturls_init');


/**
 * Init shorturls plugin.
 */
function shorturls_init() {
	
	// Register a page handler for shorturls
	elgg_register_page_handler('s', 'shorturls_page_handler');
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'shorturls_public_pages');
	
}


/* Page handler : redirects to canonical entity URL
 * s/GUID => short link to ElggEntities
 * @TODO : generate shorter codes using base convert ? eg. sHortUrLc0d3
 */
function shorturls_page_handler($page) {
	$url = '';
	
	// GUID mode
	if (!empty($page[0])) {
		$ent = get_entity($page[0]);
		if (elgg_instanceof($ent)) {
			$url = $ent->getURL();
		} else {
			if (elgg_is_logged_in()) register_error(elgg_echo('shorturls:invalid:loggedin'));
			else register_error(elgg_echo('shorturls:invalid'));
		}
	} else {
		register_error(elgg_echo('shorturls:noid'));
	}
	
	// @TODO Shortest mode ?  should be used to reference stored external links
	/*
	if (!empty($page[0])) {
		$guid = shorturls_code_to_guid( $page[0]);
		if ($ent = get_entity($guid)) {
			$url = $ent->getURL();
			if (!empty())
		}
		return true;
	}
	*/
	
	header("Status: 301 Moved Permanently", false, 301);
	header("Location: {$url}");
	//forward($url); // Not working in walled garden mode
	return false;
}


// Permet l'accès à la fonctionnalité quel que soit le statut "walled garden"
function shorturls_public_pages($hook, $type, $return_value, $params) {
	$return_value[] = 's/.*';
	return $return_value;
}


// Converts base 10 to base 62
function shorturls_guid_to_code($num) {
	$base = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$b = strlen($base);
	$r = $num  % $b ;
	$res = $base[$r];
	$q = floor($num/$b);
	while ($q) {
		$r = $q % $b;
		$q = floor($q/$b);
		$res = $base[$r].$res;
	}
	return $res;
}

// Converts base 62 to base 10
function shorturls_code_to_guid( $num) {
	$base = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$b = strlen($base);
	$limit = strlen($num);
	$res = strpos($base,$num[0]);
	for ($i=1;$i<$limit;$i++) {
		$res = $b * $res + strpos($base,$num[$i]);
	}
	return $res;
}


