<?php
/**
 * ESOPE template endpoint
 * 
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL 2016
 * @link http://facyla.fr/
 */

$mode = get_input('mode', 'html');
$editor = get_input('editor');




//$mime = $file->getMimeType();
if (!$mime) { $mime = "application/octet-stream"; }

// fix for IE https issue
header("Pragma: public");
header("Content-type: $mime");
if ($inline || (strpos($mime, "image/") !== false) || ($mime == "application/pdf")) {
	header("Content-Disposition: inline; filename=\"$filename\"");
} else {
	header("Content-Disposition: attachment; filename=\"$filename\"");
}


