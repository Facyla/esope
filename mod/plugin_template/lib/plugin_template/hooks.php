<?php
/* Hook functions
 * Hooks usually return $result, or other meaningful result
 * $result is passed to the next registered hook
 * $result value may block upcoming registered hooks
 * $params is an array passed by hook triggering code
 
 * See hook triggering code for reference on $result handling and passed $params
 */

function plugin_template_somehook($hook, $type, $result, $params) {
	// Extract some data from $params
	//$entity = elgg_extract("entity", $params);
	
	// @TODO : Perform some tests and actions
	//if (elgg_instanceof($entity, "object")) {}
	
	return $result;
}



