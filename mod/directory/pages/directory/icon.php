<?php
$guid = (int) get_input("guid");
$size = strtolower(get_input("size"));

// Use some custom sizes too
$icon_sizes = elgg_get_config("icon_sizes");
if (!isset($icon_sizes[$size])) { $size = "small"; }

$success = false;

if ($object = get_entity($guid)) {
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $object->getOwnerGUID();
	$filehandler->setFilename("directory/" . $object->guid. $size . ".jpg");
	if ($filehandler->exists()) {
		if ($contents = $filehandler->grabFile()) { $success = true; }
	}
}

if (!$success) {
	$subtype = 'directory';
	if ($object) { $subtype = $object->getSubtype(); }
	$contents = @file_get_contents(elgg_get_plugins_path(). "directory/graphics/{$subtype}.png");
	header("Content-type: image/png");
} else {
	header("Content-type: image/jpeg");
}
header("Expires: " . date("r", time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

echo $contents;
