<?php
/**
 * Elgg directory add/edit action
 * 
 * @package ElggDirectory
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Cache to the session
elgg_make_sticky_form('directory');

// @TODO : édition directory, person, organisation : qqs champs communs (photo)
$subtype = get_input('subtype', 'person');


/* Get input data */
$title = get_input('title');
$name = get_input('name');
$description = get_input('description');
$access = get_input('access_id');
//if (!in_array((string) $access, array('0', '2'))) { $access = 2; } // Always public if not defined
$write_access = get_input('write_access_id');
//if (!in_array((string) $write_access, array('0', '2'))) { $write_access = 2; } // Allow contributions to anyone by default

// Set directory name if not defined + normalize it
// @TODO : ensure it remains unique ?
if (empty($name)) { $name = $title; }
$name = elgg_get_friendly_title($name);

// Get directory entity, if it exists
$guid = get_input('guid', false);
$object = get_entity($guid);

if (elgg_instanceof($object, 'object', 'directory')) {
	// Cannot change afterwards
	$subtype = $object->getSubtype();
}

switch($subtype) {
	case 'directory':
		// Check existing object, or create a new one
		if (!elgg_instanceof($object, 'object')) {
			$object = new ElggDirectory();
			$object->save();
		}
		// @TODO Check if directory already exists (for another this container, etc.)
		$fields_config = array();
		$required = array('title');
		break;
	case 'organisation':
		if (!elgg_instanceof($object, 'object')) {
			$object = new ElggOrganisation();
			$object->save();
		}
		$fields_config = directory_data_organisation();
		$required = array('name');
		break;
	case 'person':
	default:
		if (!elgg_instanceof($object, 'object')) {
			$object = new ElggPerson();
			$object->save();
		}
		$fields_config = directory_data_person();
		$required = array('name');
}


// Check required fields
foreach ($required as $field) {
	if (empty($$field)) {
		register_error(elgg_echo('directory:missingrequired'));
		forward(REFERER);
	}
}


// Edition de l'objet existant ou nouvellement créé
$object->title = $title;
$object->name = $name;
$object->description = $description;
$object->access_id = $access;
$object->write_access_id = $write_access;
//$object->entities = $entities;
//$object->entities_comment = $entities_comment;

// @TODO : Enable quick configuration of data model
foreach($fields_config as $field => $input_type) {
	$val = get_input($field, '');
	// @TODO : switch depending on input type
	switch ($input_type) {
		case 'tags':
			$val = string_to_tag_array($val);
			break;
		case 'text':
		default:
	}
	$object->$field = $val;
}

// Save new/updated content
if ($object->save()) {
	
	// Icon upload
	if(get_input("remove_icon") == "yes"){
		// remove existing icons
		//@TODO directory_remove_icon($object);
	} else {
		//$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
		// Autres dimensions, notamment recadrage pour les vignettes en format carré définies via le thème
		$icon_sizes = elgg_get_config("icon_sizes");
		if ($icon_file = get_resized_image_from_uploaded_file("icon", 100, 100)) {
			// create icon
			$prefix = "directory/" . $object->getGUID();
			$fh = new ElggFile();
			$fh->owner_guid = $object->getOwnerGUID();
			foreach($icon_sizes as $size => $icon_info){
				if($icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"])){
					$fh->setFilename($prefix . $size . ".jpg");
					if($fh->open("write")){
						$fh->write($icon_file);
						$fh->close();
					}
				}
			}
			$object->icontime = time();
		}
	}

	system_message(elgg_echo("directory:saved")); // Success message
	elgg_clear_sticky_form('directory'); // Remove the cache
} else {
	register_error(elgg_echo("directory:error"));
}

//elgg_set_ignore_access(false);


// Forward back to the page
//forward('directory/edit/' . $object->guid);
forward($object->getURL());


