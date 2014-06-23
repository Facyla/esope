<?php
/**
 * Elgg single upload action for flash/ajax uploaders
 */

elgg_load_library('tidypics:upload');

$album_guid = (int) get_input('album_guid');
$file_var_name = get_input('file_var_name', 'Image');
$batch = get_input('batch');

$album = get_entity($album_guid);
if (!$album) {
	echo elgg_echo('tidypics:baduploadform');
	exit;
}

// probably POST limit exceeded
if (empty($_FILES)) {
	trigger_error('Tidypics warning: user exceeded post limit on image upload', E_USER_WARNING);
	register_error(elgg_echo('tidypics:exceedpostlimit'));
	exit;
}

$file = $_FILES[$file_var_name];

$image = new TidypicsImage();
$image->container_guid = $album->getGUID();
$image->setMimeType($file['type']);
$image->access_id = $album->access_id;
$image->batch = $batch;

try {
	$result = $image->save($file);

} catch (Exception $e) {
	// remove the bits that were saved
	delete_entity($image->getGUID());
	$result = false;
	echo $e->getMessage();
}

if ($result) {
	$album->prependImageList(array($image->guid));

	if (elgg_get_plugin_setting('img_river_view', 'tidypics') === "all") {
		add_to_river('river/object/image/create', 'create', $image->getOwnerGUID(), $image->getGUID());
	}
}

exit;