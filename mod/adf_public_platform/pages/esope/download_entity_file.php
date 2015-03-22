<?php
/**
 * Elgg esope entity_file download
 * 
 * @author Facyla - Florian DANIEL
 * @copyright ITEMS International 2014
 * @link http://items.fr/
 */

global $CONFIG;

$entity_guid = get_input("guid");
if ($entity_guid) {
	$entity = get_entity($entity_guid);
}

// Attaching files is allowed for objects, users, groups, sites
//if (!($entity instanceof ElggEntity)) {
if (!elgg_instanceof($entity, 'object') && !elgg_instanceof($entity, 'user') && !elgg_instanceof($entity, 'group') && !elgg_instanceof($entity, 'site')) {
	register_error("Invalid entity.");
	//forward(REFERRER);
}


// Autorisations d'accès à ce fichier
// Par défaut, identique à l'accès au contenant (pas d'accès à l'entité <=> pas d'accès au fichier joint)
// Mais pourrait dépendre du champ concerné

if (!has_access_to_entity($entity)) {
	register_error("No access");
	//forward(REFERRER);
}

$inline = get_input("inline", false);


// Get file and send it
$field_name = get_input("field_name");
$file_path = $entity->{$field_name};
$filename = explode('/', $file_path);
$filename = end($filename);

$filehandler = new ElggFile();
$filehandler->owner_guid = $entity->guid;
$filehandler->setFilename($file_path);
/* Renvoie false alors que fichier existe ??
if (!$filehandler->exists()) {
	register_error("No filehandler");
	forward(REFERRER);
}
*/

//$mime = $file->getMimeType();
if (!$mime) { $mime = "application/octet-stream"; }

// fix for IE https issue
header("Pragma: public");
header("Content-type: $mime");
if ($inline || (strpos($mime, "image/") !== false) || ($mime == "application/pdf")) {
	header("Content-Disposition: inline; filename=\"$filename\"");
} else {
	header("Content-Disposition: attachment; filename=\"$filename\"");
}

ob_clean();
flush();
readfile($file_path);
exit;

