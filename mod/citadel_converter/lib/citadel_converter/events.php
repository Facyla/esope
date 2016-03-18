<?php
/* Events functions
 * Events usually return nothing (or null)
 * $event is triggering event
 * $type is the type of data passed in $entity
 * $entity may actually be any data type, usually an ElggEntity but not always
 * 
 * See event triggering code for details
 */

function citadel_converter_someevent($event, $type, $entity) {
	
	// @TODO : Perform some tests and actions
	//if (elgg_instanceof($entity, "object")) {}
	
	return null;
}



