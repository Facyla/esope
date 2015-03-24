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
	
	// Register a page handler for "shorturls/"
	elgg_register_page_handler('s', 'shorturls_page_handler');
	
	
}


/* Page handler
 * Loads pages located in shorturls/pages/shorturls/
 * s/sHortUrLc0d3 => shortened URL
 * s/g/GUID => short link to ElggEntities
 */
function shorturls_page_handler($page) {
	$base = elgg_get_plugins_path() . 'shorturls/pages/shorturls';
	switch ($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		default:
			include "$base/index.php";
	}
	return true;
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
		$q =floor($q/$b);
		$res = $base[$r].$res;
	}
	return $res;
}

// Converts base 62 to base 10
function shorturls_code_to_guid( $num) {
	$base = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$b = strlen($base);
	$limit = strlen($num);
	$res=strpos($base,$num[0]);
	for($i=1;$i<$limit;$i++) {
		$res = $b * $res + strpos($base,$num[$i]);
	}
	return $res;
}


