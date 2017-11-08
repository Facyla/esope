<?php
$guid = (int) get_input("guid");
$size = strtolower(get_input("size"));

// Use some custom sizes too
if (!in_array($size,array("large","medium","small","tiny","master","topbar", 'embed', 'listing', 'gallery', 'hres'))) {
	$size = "medium";
}

$success = false;

if($collection = get_entity($guid)) {
	
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $collection->getOwnerGUID();
	$filehandler->setFilename("collection/" . $collection->getGUID(). $size . ".jpg");
	
	if ($filehandler->exists()) {
		if ($contents = $filehandler->grabFile()) { $success = true; }
	}
}

if (!$success) {
	$contents = @file_get_contents(elgg_get_plugins_path(). "mod/collection/graphics/icons/{$size}/collection.jpg");
}

header("Content-type: image/jpeg");
header("Expires: " . date("r", time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

echo $contents;

