<?php
/**
 * Elgg Market Plugin
 */

// Get file GUID
$guid = (int) get_input('guid', 0);

$post = get_entity($guid);
if (!$post) {
	exit;
}

// Get the size
$size = strtolower(get_input('size'));
if (!in_array($size,array('large','medium','small','tiny','master'))) {
	$size = "medium";
}

// Get image number (1,2,3 or 4)
$imagenum = (int) get_input('imagenum');
if ($imagenum == 1) {
	$imagenum = '';
}

// Try and get the icon
$filehandler = new ElggFile();
$filehandler->owner_guid = $post->owner_guid;
$filehandler->setFilename("market/" . $post->guid . $size . $imagenum . ".jpg");
		
$success = false;
if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->getSize())) {
		$success = true;
	} 
}

if (!$success) {
	$path = elgg_get_site_url() . "mod/market/graphics/noimage{$size}.png";
	header("Location: $path");
	exit;
}

header("Content-type: image/jpeg");
header('Expires: ' . date('r',time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

$splitString = str_split($contents, 1024);

foreach($splitString as $chunk) {
	echo $chunk;
}

