<?php
/**
 * Elgg collections add/edit action
 * 
 * @package ElggCollections
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Cache to the session
elgg_make_sticky_form('collections');

/* Get input data */
$title = get_input('title');
$name = get_input('name');
$description = get_input('description');
$entities = get_input('entities', '', false); // We do *not want to filter HTML
$entities_comment = get_input('entities_comment', '', false); // We do *not want to filter HTML
$access = get_input('access_id');
if (!in_array((string) $access, array('0', '2'))) { $access = 2; } // Always public if not defined
$write_access = get_input('write_access_id');
if (!in_array((string) $write_access, array('0', '2'))) { $write_access = 2; } // Allow contributions to anyone by default

// Set collection name if not defined + normalize it
// @TODO : ensure it remains unique ?
if (empty($name)) { $name = $title; }
$name = elgg_get_friendly_title($name);

// Get collection entity, if it exists
$guid = get_input('guid', false);
$collection = get_entity($guid);

// Check if collection name already exists (for another collection)
$existing_collection = collections_get_entity_by_name($name);
if ($existing_collection && elgg_instanceof($collection, 'object', 'collection') && ($existing_collection->guid != $collection->guid)) {
	register_error(elgg_echo('collections:error:alreadyexists'));
	forward(REFERER);
}


// Check existing object, or create a new one
if (elgg_instanceof($collection, 'object', 'collection')) {
} else {
	$collection = new ElggCollection();
	$collection->save();
}

$required = array('title');
foreach ($required as $field) {
	if (empty($$field)) {
		register_error(elgg_echo('collections:missingrequired'));
		forward(REFERER);
	}
}


// Edition de l'objet existant ou nouvellement créé
$collection->title = $title;
$collection->name = $name;
$collection->description = $description;
$collection->access_id = $access;
$collection->entities = $entities;
$collection->entities_comment = $entities_comment;
$collection->write_access_id = $write_access;


// Save new/updated content
if ($collection->save()) {
	
	// Icon upload
	if(get_input("remove_icon") == "yes"){
		// remove existing icons
		collection_remove_icon($collection);
	} else {
		//$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
		// Autres dimensions, notamment recadrage pour les vignettes en format carré définies via le thème
		$icon_sizes = elgg_get_config("icon_sizes");
		if ($icon_file = get_resized_image_from_uploaded_file("icon", 100, 100)) {
			// create icon
			$prefix = "collection/" . $collection->getGUID();
			$fh = new ElggFile();
			$fh->owner_guid = $collection->getOwnerGUID();
			foreach($icon_sizes as $icon_name => $icon_info){
				if($icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"])){
					$fh->setFilename($prefix . $icon_name . ".jpg");
					if($fh->open("write")){
						$fh->write($icon_file);
						$fh->close();
					}
				}
			}
			$collection->icontime = time();
		}
	}
	
	system_message(elgg_echo("collections:saved")); // Success message
	elgg_clear_sticky_form('collections'); // Remove the cache
} else {
	register_error(elgg_echo("collections:error"));
}

//elgg_set_ignore_access(false);


// Forward back to the page
//forward('collection/edit/' . $collection->guid);
forward($collection->getURL());


