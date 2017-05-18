<?php
$guid = (int) get_input("guid");
$name = get_input("name");
if (empty($name)) { $name = 'banner'; }


$success = false;

if($entity = get_entity($guid)) {

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $entity->getGUID();
	$filehandler->setFilename("groups/" . $entity->guid . $entity->{$name});

	$filename = $entity->{$name.'_name'};

	if ($filehandler->exists()) {
		if ($contents = $filehandler->grabFile()) { $success = true; }
	}
}

if (!$success) {
	header("HTTP/1.0 404 Not Found");
	exit;
}


$disposition = get_input('inline', true);
$mime = $filehandler->detectMimeType();
if (empty($mime)) { $mime = 'application/octet-stream'; }


header("Content-type: application/octet-stream");
if ($disposition) {
	header("Content-Disposition: inline; filename=$filename");
} else {
	header("Content-Disposition: attachment; filename=$filename");
}
header("Expires: " . date("r", time() + 86400)); // 1 day ?
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

echo $contents;

