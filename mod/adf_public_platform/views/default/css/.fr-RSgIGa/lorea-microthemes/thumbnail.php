<?php
/**
 * Elgg microtheme thumbnail
 *
 * @package ElggMicrotheme
 */

// Get engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get file GUID
$file_guid = (int) get_input('guid', 0);

// Get file thumbnail size
$size = get_input('size', 'small');

$microtheme = get_entity($guid);
if (!$microtheme || $microtheme->getSubtype() != "microtheme") {
	exit;
}


// Get file thumbnail
switch ($size) {
	case "small":
		$thumbfile = $microtheme->thumbnail;
		break;
	case "medium":
		$thumbfile = $microtheme->smallthumb;
		break;
	case "large":
	default:
		$thumbfile = $microtheme->largethumb;
		break;
}

// Grab the file
if ($thumbfile && !empty($thumbfile)) {
	$readfile = new ElggFile();
	$readfile->owner_guid = $microtheme->owner_guid;
	$readfile->setFilename($thumbfile);
	$mime = $microtheme->getMimeType();
	$contents = $readfile->grabFile();

	// caching images for 10 days
	header("Content-type: $mime");
	header('Expires: ' . date('r',time() + 864000));
	header("Pragma: public", true);
	header("Cache-Control: public", true);
	header("Content-Length: " . strlen($contents));

	echo $contents;
	exit;
}
