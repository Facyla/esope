<?php
$guid = (int) get_input("guid");
$name = get_input("name");
if (empty($name)) $name = 'attachment';

$success = false;

if($transitions = get_entity($guid)) {
	
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $transitions->getOwnerGUID();
	$filehandler->setFilename("transitions/" . $transitions->getGUID() . $transitions->{$name});
	
	$filename = $transitions->getAttachmentName($name);
	
	if ($filehandler->exists()) {
		if ($contents = $filehandler->grabFile()) { $success = true; }
	}
}

if (!$success) {
	register_error(elgg_echo('file:notfound'));
	forward(REFERER);
}


header("Content-type: application/octet-stream");
if (!empty(get_input('inline'))) {
	header("Content-Disposition: inline; filename=$filename");
} else {
	header("Content-Disposition: attachment; filename=$filename");
}
header("Expires: " . date("r", time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

echo $contents;

