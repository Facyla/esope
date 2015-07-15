<?php
/**
 * View for multilingual objects
 * 
 * Determines which entity should be viewed (main object or translation), depending on chosen language
 *
 */

$entity = elgg_extract('entity', $vars);

if (elgg_instanceof($entity, 'object')) {

	// Lang shoud be firstly set by views, because we might need multiple languages at the same time...
	$lang = elgg_extract('locale', $vars, false);
	if (!$lang) { $lang = get_input('lang'); } else { unset($vars['locale']); }
	// Use prefered user language by default
	if (empty($lang)) { $lang = get_current_language(); }
	$main_lang = multilingual_get_main_language(); // Main site language



	// Get original entity - always useful
	$main_entity = multilingual_get_main_entity($entity);
	if (!$main_entity) {
		error_log("Original content does not exist, updating translation.");
		// @TODO : handle orphan entity ? (should not happen but has to be handled...)
	
		// Quickest method : remove display view + relationship
		/*
		$translation->view = null;
		remove_entity_relationships($translation->guid, 'translation_of');
		*/
		$main_entity = $entity;
	}


	// If it is a translation and we're not using the right URL, correct it
	if (($main_entity->guid != $entity->guid) && (full_url() == $entity->getURL())) {
		$forward = $main_entity->getURL();
		// Explicitely specify the wanted language if it not the default, or is user-specific
		if (($lang != get_current_language()) || ($lang != $main_lang)) $forward .= '?locale=' . $entity->locale;
		forward($forward);
	}

	// Select entity to be displayed
	// Main entity if no language is set
	// Or the chosen translation if it is not already the good one
	if (empty($lang) || ($main_entity->locale == $lang)) {
		$entity = $main_entity;
	} else if ($entity->locale == $lang) {
		// Keep passed entity
	} else if ($entity->locale != $lang) {
		$entity = multilingual_get_translation($main_entity, $lang);
	}
	// Default to main entity if the chosen lang does not return any valid entity
	if (!elgg_instanceof($entity)) {
		register_error("No content available, using original content.");
		$entity = $main_entity;
	}

	// Update vars meta
	$vars['entity'] = $entity;

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
}




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

// @TODO : comments are attached to the page by the pages handler in each plugin - we need to force it if we want language-specific comments (or add some filtering ?)

echo $contents;

