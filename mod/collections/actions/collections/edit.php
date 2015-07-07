<?php
/**
 * Elgg external pages: add/edit action
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Cache to the session
elgg_make_sticky_form('collection');

/* Get input data */
$collection_title = get_input('title');
$collection_name = get_input('name');
$collection_description = get_input('description');
$collection_entities = get_input('entities', '', false); // We do *not want to filter HTML
$collection_entities_comment = get_input('entities_comment', '', false); // We do *not want to filter HTML
$collection_access = get_input('access_id');
// Set collection name if not defined + normalize it
// @TODO : ensure it remains unique ?
if (empty($collection_name)) { $collection_name = $collection_title; }
$collection_name = elgg_get_friendly_title($collection_name);

// Get collection entity, if it exists
$guid = get_input('guid', false);
$collection = get_entity($guid);

// Check if collection name already exists (for another collection)
$existing_collection = collection_get_entity_by_name($collection_name);
if ($existing_collection && elgg_instanceof($collection, 'object', 'collection') && ($existing_collection->guid != $collection->guid)) {
	register_error(elgg_echo('collection:error:alreadyexists'));
	forward(REFERER);
}


// Check existing object, or create a new one
if (elgg_instanceof($collection, 'object', 'collection')) {
} else {
	$collection = new ElggCollection();
	$collection->save();
}


// Edition de l'objet existant ou nouvellement créé
$collection->access_id = $collection_access;

$collection->title = $collection_title;
$collection->name = $collection_name;
$collection->description = $collection_description;
$collection->entities = $collection_entities;
$collection->entities_comment = $collection_entities_comment;


// Save new/updated content
if ($collection->save()) {
	system_message(elgg_echo("collection:saved")); // Success message
	elgg_clear_sticky_form('collection'); // Remove the cache
} else {
	register_error(elgg_echo("collection:error"));
}

//elgg_set_ignore_access(false);

// Forward back to the page
forward('collection/edit/' . $collection->guid);

