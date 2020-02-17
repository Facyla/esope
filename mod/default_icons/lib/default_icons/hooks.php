<?php
/* Hook functions
 * Hooks usually return $result, or other meaningful result
 * $result is passed to the next registered hook
 * $result value may block upcoming registered hooks
 * $params is an array passed by hook triggering code
 
 * See hook triggering code for reference on $result handling and passed $params
 */

// Permet l'accès à diverses pages en mode "walled garden"
function default_icons_public_pages($hook, $type, $return, $params) {
	// Icones générées
	$return[] = 'default_icons/.*';
	
	// Icones des groupes
	//$return[] = 'groupicon/.*';
	
	// Pièces jointes et téléchargements directs
	//$return[] = 'file/download/.*';
	
	return $return;
}


