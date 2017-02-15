<?php
/**
 * Extend file object view with CMIS information and file versions
 */

$full = elgg_extract('full_view', $vars, FALSE);
$file = elgg_extract('entity', $vars, FALSE);

if (!$file) { return; }
if (!$full) { return; }

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

$content = '';


// DEBUG and ADMIN INFO
$debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis');
if ($debug == 'yes') {
	$content .= '<p><strong>' . elgg_echo('elgg_cmis:file:details') . '</strong></p>';

	if ($use_cmis) {
		$content .= '<p>' . elgg_echo('elgg_cmis:server:available') . '</p>';
	} else {
		$content .= '<p>' . elgg_echo('elgg_cmis:server:notavailable') . '</p>';
	}

	$content .= '<p>';
	$content .= '<u>' . elgg_echo('elgg_cmis:file:metadata') . '&nbsp;:</u><br />';
	$content .= '<br />' . elgg_echo('elgg_cmis:file:mimetype', array($file->getMimeType()));
	$content .= '<br />' . elgg_echo('elgg_cmis:file:simpletype', array($file->simpletype));
	$content .= '<br />' . elgg_echo('elgg_cmis:file:size', array($file->getSize()));
	$content .= '<br />' . elgg_echo('elgg_cmis:file:cmisid', array($file->cmis_id));
	$content .= '<br />' . elgg_echo('elgg_cmis:file:cmispath', array($file->cmis_path));
	$content .= '<br />' . elgg_echo('elgg_cmis:file:filestorename', array($file->getFilenameOnFilestore()));
	$content .= '</p>';

	$content .= '<u>' . elgg_echo('elgg_cmis:filestore') . '</u><br />';
	//if ($use_cmis && ($file->simpletype != "image")) {
	if ($file->simpletype != "image") {
		$content .= elgg_echo('elgg_cmis:filestore:cmis') . '<br />';
		if ($use_cmis) {
			$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file);
		}
		if ($cmis_file) {
			$content .= elgg_echo('elgg_cmis:filestore:cmis:stored') . '<br />';
		} else {
			$content .= elgg_echo('elgg_cmis:filestore:cmis:notstored') . '<br />';
		}
	} else {
		$content .= elgg_echo('elgg_cmis:filestore:elgg') . '<br />';
	}

	if (!$cmis_file) {
		$filestore_name = $file->getFilenameOnFilestore();
		if ($filestore_name) {
			$content .= elgg_echo('elgg_cmis:filestore:elgg:stored') . '<br />';
		} else {
			$content .= elgg_echo('elgg_cmis:filestore:elgg:notstored') . '<br />';
		}
	}
	$content .= '</p>';
	
}


// @TODO FILE VERSIONS
if ($use_cmis) {
	$cmis_file = elgg_cmis_file_exists_in_cmis_filestore($file);
	if ($cmis_file) {
		$versions = $cmis_file->getAllVersions();
		if (sizeof($versions) > 0) {
			$content .= '<p><strong>' . elgg_echo('elgg_cmis:versions') . '</strong></p>';
			$content .= '<ul>';
			foreach($versions as $version) {
				$content .= '<li>' . $version->getVersionLabel() . ' ';
				if ($version->isLatestVersion()) { $content .= elgg_echo('elgg_cmis:version:latest'); }
				if ($version->isLatestMajorVersion()) { $content .= elgg_echo('elgg_cmis:version:latestmajor'); }
				$content .= '</li>';
			}
			$content .= '</ul>';
		}
	}
}


echo '<div class="elgg-cmis-file-info">' . $content . '</div>';

