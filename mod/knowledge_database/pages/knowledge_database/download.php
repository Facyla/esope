<?php
/**
 * Elgg project_workflow browser
 * 
 * @package Elggproject_manager
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
	register_error("Invalid entity. Cannot attach file.");
	forward(REFERRER);
}


// @TODO Gérer les autorisations d'accès à ce fichier : quels critères ?
// Par défaut, identique à l'accès au contenant (pas d'accès à l'entité <=> pas d'accès au fichier joint)
// Mais devrait être déduit à partir du champ concerné
//$role = knowledge_database_role();

if (!has_access_to_entity($entity)) {
	register_error("No access");
	forward(REFERRER);
}

$inline = get_input("inline", false);


/*
elgg_set_page_owner_guid($CONFIG->site->guid);

// Get workflow details
$workflow_steps = project_workflow_get_workflow_steps();
$fields_description = project_workflow_get_fields_description();

// Build form fields
$form_fields = array();
foreach($fields_description as $name => $field) {
	if (!project_workflow_read_field($field, $role, $entity)) { continue; }
	
	// Build field params
	$fieldset = $field['category'];
	if (empty($fieldset)) $fieldset = 'default';
	$input_params = $field['params'];
	if ($input_params['required']) $input_params['required'] = 'required';
	$input_params['name'] = $name;
	// Set default if not set
	if (isset($entity->{$name})) {
		$input_params['value'] = $entity->{$name};
	} else {
		$input_params['value'] = $field['default'];
	}
	// Render input field
	$form_fields[$fieldset] .= '<p>';
	$form_fields[$fieldset] .= '<label>' . elgg_echo("project_workflow:field:$name");
	if ($input_params['required']) $form_fields[$fieldset] .= '<span class="required">*</span>';
	$form_fields[$fieldset] .= ' ' . elgg_view("input/{$field['type']}", $input_params) . '</label>';
	$field_help = elgg_echo("project_workflow:field:$name:details");
	if (!empty($field_help) && ($field_help != "project_workflow:field:$name:details")) $form_fields[$fieldset] .= '<br /><em>' . $field_help . '</em>';
	$form_fields[$fieldset] .= '</p>';
	
	switch($field['type']) {
		case 'file':
			$form_fields[$fieldset] .= "<p>Fichier joint : " . $entity->{$name} . "</p>";
			break;
		default:
	}
}
*/


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

