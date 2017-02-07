<?php
/**
 * Extend file object view with CMIS information
 */

$full = elgg_extract('full_view', $vars, FALSE);
$file = elgg_extract('entity', $vars, FALSE);

if (!$file) { return; }
if (!$full) { return; }

$debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis');
if ($debug != 'yes') { return; }

// Check that all conditions are met to use CMIS ?   But leads to a failure if CAS server is down or not accessible for some reason
$use_cmis = true;
// Load libraries (and get base page handler include path)
$vendor = elgg_cmis_vendor();
$base = elgg_cmis_libraries();
if (!elgg_cmis_is_valid_repo()) {
	$use_cmis = false;
} else if (!elgg_cmis_get_session()) {
	$use_cmis = false;
}


echo '<div class="elgg-cmis-file-info">';
echo "<p><strong>CMIS and filestore information&nbsp;:</strong></p>";

if ($use_cmis) {
	echo "<p>CMIS server is available and ready for use</p>";
} else {
	echo "<p>CMIS server is not available or cannot be used</p>";
}

echo '<p>';
echo "<u>Metadata&nbsp;:</u><br />";
echo 'MIME type : ' . $file->getMimeType() . '<br />';
echo 'File simpletype : ' . $file->simpletype . '<br />';
echo 'File size : ' . $file->getSize() . '<br />';
echo "CMIS ID : " . $file->cmis_id . '<br />';
echo "CMIS path : " . $file->cmis_path . '<br />';
echo "Elgg filestore name&nbsp;: " . $file->getFilenameOnFilestore() . '<br />';
echo '</p>';

echo "<u>Filestore&nbsp;:</u><br />";
//if ($use_cmis && ($file->simpletype != "image")) {
if ($file->simpletype != "image") {
	echo "File should be stored in CMIS repository<br />";
	if ($use_cmis) {
		$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file);
	}
	if ($cmis_file) {
		echo "File is stored in CMIS repository<br />";
	} else {
		echo "File is NOT stored in CMIS repository<br />";
	}
} else {
	echo "File should be stored in Elgg filestore<br />";
}

if (!$cmis_file) {
	$filestore_name = $file->getFilenameOnFilestore();
	if ($filestorename) {
		echo "File is stored in Elgg repository<br />";
	} else {
		echo "File is NOT stored in Elgg repository<br />";
	}
}
echo '</p>';


echo '</div>';


