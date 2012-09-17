<?php
/**
 * Elgg microtheme uploader/edit action
 *
 * @package ElggMicrothemes
 */

// Get variables
$title = get_input("title");
$access_id = (int) get_input("access_id");
$guid = (int) get_input('guid');
$tags = get_input("tags");

elgg_make_sticky_form('microtheme');

// check if upload failed
if (!empty($_FILES['background_image']['name']) && $_FILES['background_image']['error'] != 0) {
	register_error(elgg_echo('microthemes:background:cannotload'));
	forward(REFERER);
}

// check whether this is a new file or an edit
$new = true;
if ($guid > 0) {
	$new = false;
}

if ($new) {
	$theme = new ElggObject();
	$theme->subtype = "microtheme";

	// if no title on new upload, grab filename
	if (empty($title)) {
		register_error('microthemes:notitle');
		forward(REFERER);
	}

} else {
	// load original microtheme object
	$theme = new ElggObject($guid);
	if (!$theme->guid) {
		register_error(elgg_echo('microthemes:cannotload'));
		forward(REFERER);
	}

	// user must be able to edit file
	if (!$theme->canEdit()) {
		register_error(elgg_echo('microthmees:noaccess'));
		forward(REFERER);
	}

	if (!$title) {
		// user blanked title, but we need one
		$title = $theme->title;
	}
}

$theme->title = $title;
$theme->access_id = $access_id;

$tags = explode(",", $tags);
$theme->tags = $tags;

// if we have a background upload, process it
if (isset($_FILES['background_image']['name']) && !empty($_FILES['background_image']['name'])) {

	$prefix = "microthemes/banner_{$theme->guid}";
	$file = new ElggFile();
	$file->owner_guid = $theme->owner_guid;
	$file->container_guid = $theme->owner_guid;
	$file->setFilename($prefix.'_master.jpg');
	$file->open("write");
	$file->write(get_uploaded_file('background_image'));
	$file->close();

	$guid = $theme->save();

	$theme->icontime = time();
		
	$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
	if ($thumbnail) {
		$thumb = new ElggFile();
		$thumb->setMimeType($_FILES['upload']['type']);

		$thumb->setFilename($prefix."thumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumbnail);
		$thumb->close();

		$theme->thumbnail = $prefix."thumb".$filestorename;
		unset($thumbnail);
	}

	$thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
	if ($thumbsmall) {
		$thumb->setFilename($prefix."smallthumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumbsmall);
		$thumb->close();
		$theme->smallthumb = $prefix."smallthumb".$filestorename;
		unset($thumbsmall);
	}

	$thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
	if ($thumblarge) {
		$thumb->setFilename($prefix."largethumb".$filestorename);
		$thumb->open("write");
		$thumb->write($thumblarge);
		$thumb->close();
		$theme->largethumb = $prefix."largethumb".$filestorename;
		unset($thumblarge);
	}
} else {
	// not saving a file but still need to save the entity to push attributes to database
	$theme->save();
}

// file saved so clear sticky form
elgg_clear_sticky_form('microtheme');


if ($guid) {
	system_message(elgg_echo("microthemes:saved"));
	if ($new) {
		add_to_river('river/object/microtheme/create', 'create', elgg_get_logged_in_user_guid(), $theme->guid);
	}
} else {
	register_error(elgg_echo("microthemes:nosave"));
}
forward($theme->getURL());
