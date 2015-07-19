<?php
/**
 * Elgg collections add entity to existing collection
 * 
 * @package ElggCollections
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

/* Get input data */
$guid = get_input('collection', false);
$action = get_input('query', 'add');
$entity_guid = get_input('entity_guid');

// Get collection entity, if it exists
$collection = get_entity($guid);
// collections_get_entity_by_name($name);

// Check if collection name already exists (for another collection)


// Check existing object, or create a new one
if (!elgg_instanceof($collection, 'object', 'collection')) {
	forward(REFERER);
	//return json_encode(array('success' => false));
}

// @TODO : handle case where entities input var is an array

$entities = $collection->entities;
$entities_comment = $collection->entities_comment;
if ($action == 'add') {
	if (!in_array($entity_guid, $entities)) {
		$entities[] = $entity_guid;
		$entities_comment[] = '';
	}
} else if ($action == 'remove') {
	foreach($entities as $k => $g) {
		if ($g == $guid) {
			unset($entities[$k]);
			unset($entities_comment[$k]);
		}
	}
}
$collection->entities = $entities;
$collection->entities_comment = $entities_comment;


//return json_encode(array('success' => true));
$edit_url = elgg_get_site_url() . 'collection/edit/' . $collection->guid . '#' . $entity_guid;
forward($edit_url);

