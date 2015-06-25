<?php
/**
 * View for multilingual objects
 * 
 * Determines which entity should be viewed (main object or translation), depending on chosen language
 *
 */

// Lang shoud be firstly set by views, because we might need multiple languages at the same time...
$lang = elgg_extract('locale', $vars, false);
if (!$lang) { $lang = get_input('lang'); }
else unset($vars['locale']);
$main_lang = multilingual_get_main_language();

$entity = elgg_extract('entity', $vars);


// Get original entity
$main_entity = multilingual_get_main_entity($entity);
if (!$main_entity) {
	error_log("Original content does not exist, updating translation.");
	// @TODO : handle orphan entity (should not happen but has to be handled...)
	
	// Quickest method : remove display view + relationship
	/*
	$translation->view = null;
	remove_entity_relationships($translation->guid, 'translation_of');
	*/
	$main_entity = $entity;
}


// Select original entity if no language is set
// Or the chosen translation if it is not already the good one
/*
if (empty($lang)) {
	$entity = $main_entity;
} else if ($translation->locale != $lang) {
	$entity = multilingual_get_translation($main_entity, $lang);
	// Default to main entity
	if (!elgg_instanceof($entity)) { $entity = $main_entity; }
}
*/


/*
if ($main_entity) {
	echo "This content is a alternate version of <a href=\"{$main_entity->getURL()}\">{$main_entity->title}</a> in language code : <strong>{$translation->lang}</strong>";
	// Display original content
	echo elgg_view_entity($main_entity, $view, $vars, $bypass, $debug);
} else {
	echo "Original content does not exist, updating translation.<br />";
	// @TODO : allow direct viewing of entity
	// @TODO : handle orphan entity (should not happen but has to be handled...)
	
	// Quickest method : remove display view + relationship
	/*
	$translation->view = null;
	remove_entity_relationships($translation->guid, 'translation_of');
	echo elgg_view_entity($translation, $view, $vars, $bypass, $debug);
}
*/




// Pursue the regular view display, using the updated entity
$entity_type = $entity->getType();

$subtype = $entity->getSubtype();
if (empty($subtype)) { $subtype = 'default'; }

$contents = '';
if (elgg_view_exists("$entity_type/$subtype")) {
	$contents = elgg_view("$entity_type/$subtype", $vars, $bypass, $debug);
}
if (empty($contents)) {
	$contents = elgg_view("$entity_type/default", $vars, $bypass, $debug);
}

// Marcus Povey 20090616 : Speculative and low impact approach for fixing #964
if ($vars['full_view']) {
	$annotations = elgg_view_entity_annotations($entity, $vars['full_view']);
	if ($annotations) {
		$contents .= $annotations;
	}
}

echo $contents;


