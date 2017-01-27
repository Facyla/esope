<?php
/**
 * Elgg file download.
 *
 * @package ElggFile
 */

// Enable CMIS support : provide Elgg version or CMIS version

// Get the guid
$file_guid = get_input("guid");

// Get the file
$file = get_entity($file_guid);
if (!elgg_instanceof($file, 'object', 'file')) {
	register_error(elgg_echo("file:downloadfailed"));
	forward();
}

$mime = $file->getMimeType();
if (!$mime) {
	$mime = "application/octet-stream";
}

$filename = $file->originalfilename;

// Check that all conditions are met to use CMIS
$use_cmis = true;
// Load libraries (and get base page handler include path)
$vendor = elgg_cmis_vendor();
$base = elgg_cmis_libraries();
if (!elgg_cmis_is_valid_repo()) { $use_cmis = false; }
if (!elgg_cmis_get_session()) { $use_cmis = false; }

/* Note : this direct URL works.. but requires to log in using site credentials, so should be only used for personal CMIS filestore and access
$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
$cmis_dl_url = $cmis_url . 'api/-default-/public/cmis/versions/1.1/atom/content?id=' . $file->cmis_id;
echo '<p><a href="' . $cmis_dl_url . '">' . $cmis_dl_url . '</a></p>';
*/

// Check if present in CMIS filestore, and serve content if available
//if ($use_cmis) {
if ($use_cmis && ($file->simpletype != "image")) {
	$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file);
	// Provide content from CMIS repository
	if ($cmis_file) {
		header("Pragma: public");
		header("Content-type: $mime");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Length: {$file->getSize()}");
		$session = elgg_cmis_get_session();
		$cmis_file = $session->getObject($cmis_file);
		$content_stream = $session->getContentStream($cmis_file);
		//echo "Size : " . strlen($content_stream) . '<br />';
		//echo "Elgg size : " . $file->getSize() . '<br />';
		echo $content_stream;
		exit;
	}
}


// Otherwise provide content from Elgg repository
// Optional check in Elgg filestore (but almost useless as we use it as a default / failsafe method)
//$elgg_filestore = elgg_cmis_file_exists_in_elgg_filestore($file);

// fix for IE https issue
header("Pragma: public");
header("Content-type: $mime");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: {$file->getSize()}");

while (ob_get_level()) { ob_end_clean(); }
flush();
readfile($file->getFilenameOnFilestore());
exit;

