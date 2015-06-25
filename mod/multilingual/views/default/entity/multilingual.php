<?php
/**
 * View for multilingual objects
 * 
 * Redirects to the main object
 *
 */

$translation = elgg_extract('entity', $vars);
unset($vars['entity']);

// Get translated entity
$entity = multilingual_get_translated_entity($translation);

if ($entity) {
	// echo elgg_echo('multilingual:translation:view', array($entity->name, $translation->lang));
	echo "This content is a alternate version of <a href=\"{$entity->getURL()}\">{$entity->title}</a> in language code : <strong>{$translation->lang}</strong>";
	
	// Display original content
	echo elgg_view_entity($entity, $view, $vars, $bypass, $debug);
} else {
	echo "Original content does not exist, updating translation.<br />";
	// @TODO : allow direct viewing of entity
	// @TODO : handle orphan entity (should not happen but has to be handled...)
	
	// Quickest method : remove display view + relationship
	/*
	$translation->view = null;
	remove_entity_relationships($translation->guid, 'translation_of');
	echo elgg_view_entity($translation, $view, $vars, $bypass, $debug);
	*/


	// Display translation as a real view
	$entity_type = $translation->getType();
	$subtype = $translation->getSubtype();
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
		$annotations = elgg_view_entity_annotations($translation, $vars['full_view']);
		if ($annotations) {
			$contents .= $annotations;
		}
	}
	echo $contents;
}


