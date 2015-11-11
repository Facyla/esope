<?php
/**
 * Elgg directory add/edit action
 * 
 * @package ElggDirectory
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2010-2015
 * @link http://id.facyla.net/
 */

gatekeeper();

// Cache to the session
elgg_make_sticky_form('directory');

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

// Set directory name if not defined + normalize it
// @TODO : ensure it remains unique ?
if (empty($name)) { $name = $title; }
$name = elgg_get_friendly_title($name);

// Get directory entity, if it exists
$guid = get_input('guid', false);
$directory = get_entity($guid);

// Check if directory name already exists (for another directory)
if ($existing_directory && elgg_instanceof($directory, 'object', 'directory') && ($existing_directory->guid != $directory->guid)) {
	register_error(elgg_echo('directory:error:alreadyexists'));
	forward(REFERER);
}


// Check existing object, or create a new one
if (elgg_instanceof($directory, 'object', 'directory')) {
} else {
	$directory = new ElggDirectory();
	$directory->save();
}

$required = array('title');
foreach ($required as $field) {
	if (empty($$field)) {
		register_error(elgg_echo('directory:missingrequired'));
		forward(REFERER);
	}
}


// Edition de l'objet existant ou nouvellement créé
$directory->title = $title;
$directory->name = $name;
$directory->description = $description;
$directory->access_id = $access;
$directory->entities = $entities;
$directory->entities_comment = $entities_comment;
$directory->write_access_id = $write_access;


// Save new/updated content
if ($directory->save()) {
	
	// Icon upload
	if(get_input("remove_icon") == "yes"){
		// remove existing icons
		directory_remove_icon($directory);
	} else {
		//$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
		// Autres dimensions, notamment recadrage pour les vignettes en format carré définies via le thème
		$icon_sizes = elgg_get_config("icon_sizes");
		if ($icon_file = get_resized_image_from_uploaded_file("icon", 100, 100)) {
			// create icon
			$prefix = "directory/" . $directory->getGUID();
			$fh = new ElggFile();
			$fh->owner_guid = $directory->getOwnerGUID();
			foreach($icon_sizes as $icon_name => $icon_info){
				if($icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"])){
					$fh->setFilename($prefix . $icon_name . ".jpg");
					if($fh->open("write")){
						$fh->write($icon_file);
						$fh->close();
					}
				}
			}
			$directory->icontime = time();
		}
	}
	
	system_message(elgg_echo("directory:saved")); // Success message
	elgg_clear_sticky_form('directory'); // Remove the cache
} else {
	register_error(elgg_echo("directory:error"));
}

//elgg_set_ignore_access(false);


// Forward back to the page
//forward('directory/edit/' . $directory->guid);
forward($directory->getURL());


