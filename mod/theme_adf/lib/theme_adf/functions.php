<?php
/**
 * theme_adf
 *
*/

// Permet l'accès à diverses pages en mode "walled garden"
function theme_adf_public_pages($hook, $type, $return, $params) {
	// Digest
	$return[] = 'digest/.*';
	
	return $return;
}


