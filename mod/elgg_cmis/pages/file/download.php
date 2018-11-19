<?php
/**
 * Elgg file download.
 *
 * @package ElggFile
 */

// Enable CMIS support : provide Elgg version or CMIS version

// Get the guid
$file_guid = get_input("guid");
$version = get_input("version");

// Get the file
$file = get_entity($file_guid);
if (!elgg_instanceof($file, 'object', 'file')) {
	register_error(elgg_echo("file:downloadfailed"));
	forward();
}

$mime = $file->getMimeType();
if (!$mime) { $mime = "application/octet-stream"; }

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
	$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file); // Note : version is append to id, eg. SOME-CMIS-ID;1.1
	// Provide content from CMIS repository
	if ($cmis_file) {
		//$cmis_file = elgg_cmis_get_document_by_path($file->cmis_path); // This ensures we get the latest version
		$cmis_id = explode(';', $file->cmis_id);
		$cmis_id = $cmis_id[0];
		$latest_version = $cmis_file->getVersionLabel();
		//echo $latest_version .' / '. $cmis_id .' / '. $version;
		// Should we return a specific version instead of latest ?
		if (!empty($version) && !in_array($version, array($latest_version, 'latest'))) {
			$cmis_file = elgg_cmis_get_document_by_id($cmis_id.';'.$version); // Get a specific version
			if (!$cmis_file) {
				register_error('elgg_cmis:version:notexists', array($version, $latest_version));
				forward(REFERER);
			}
		}
		
		
		
		$content_stream = $cmis_file->getContentStream();
		
		//$filesize = strlen($content_stream); // oldies but goodies
		$filesize = $cmis_file->getContentStreamLength();
		
		/* Note on versions : 
		 * MIME type and file and (and extension) might change through versions. 
		 * As we need a fixed, unchanged file name in CMIS filestore (for consistency with Elgg filestore), we do not store real file names
		 * However when serving previous versions of file, we need a accurate file name and MIME type : 
		 *  - MIME is stored and can be retrieved
		 *  - File name is actually lost so we should rely on the file title instead
		 *  - version is key, so we should add it if serving a version that is not the latest
		 */
		
		// If not latest version, we cannot assume that MIME type is valid
		// We cannot use originalfilename either because of potentially wrong extension
		// So we need to define an abritrary file name
		if (!$cmis_file->isLatestVersion()) {
			$mime = $cmis_file->getContentStreamMimeType();
			// Use a dot-less versionning scheme (to avoid any extension error)
			$version = str_replace('.', '-', $cmis_file->getVersionLabel());
			$filename = elgg_get_friendly_title($file->title) . '_version-' . $version;
		}
		
		header("Pragma: public");
		header("Content-type: $mime");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Length: $filesize");
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

