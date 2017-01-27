<?php
/**
 * Extend file object view with CMIS information
 */

$full = elgg_extract('full_view', $vars, FALSE);
$file = elgg_extract('entity', $vars, FALSE);

if (!$file) {
	return TRUE;
}

$debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis');
if ($debug != 'yes') { return; }


/*
// Check that all conditions are met to use CMIS ?   But leads to a failure if CAS server is down or not accessible for some reason
$use_cmis = true;
// Load libraries (and get base page handler include path)
$vendor = elgg_cmis_vendor();
$base = elgg_cmis_libraries();
if (!elgg_cmis_is_valid_repo()) { $use_cmis = false; }
if (!elgg_cmis_get_session()) { $use_cmis = false; }
*/


echo '<div class="elgg-cmis-file-info">';
echo "<p>CMIS and filestore information&nbsp;:";

echo 'MIME type : ' . $file->getMimeType() . '<br />';
echo 'File simpletype : ' . $file->simpletype . '<br />';
echo 'File size : ' . $file->getSize() . '<br />';
	echo "CMIS ID : " . $file->cmis_id . '<br />';
	echo "CMIS path : " . $file->cmis_path . '<br />';

//if ($use_cmis && ($file->simpletype != "image")) {
if ($file->simpletype != "image") {
	echo "<p>File should be stored in CMIS repository</p>";
	//$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file);
	if ($cmis_file) {
		echo "<p>File is stored in CMIS repository</p>";
	} else {
		echo "<p>File is NOT stored in CMIS repository</p>";
	}
} else {
	echo "<p>File should be stored in Elgg filestore</p>";
}

if (!$cmis_file) {
	$filestore_name = $file->getFilenameOnFilestore();
	if ($filestorename) {
		echo "<p>File is stored in Elgg repository</p>";
	}
}
echo '</p>';


echo '</div>';


