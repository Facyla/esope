<?php
/**
 * Group CMIS folder module
 */

$group = elgg_get_page_owner_entity();

//if ($group->cmis_folder_enable != "yes") { return true; }

if (!elgg_in_context('group_profile')) { return; }

// Display only if a folder is set
$folder = $group->cmisfolder;
if (empty($folder)) { return; }


// Forme d'une URL de partage : share/page/folder-details?nodeRef=workspace://SpacesStore/ + identifiant Alfresco
$needle = 'SpacesStore/';
// Keep only useful info if full URL was provided
if (strrpos($folder, $needle) !== false) {
	$folder_parts = explode($needle, $folder);
	$folder = end($folder_parts);

	if (!empty($folder)) { echo $group->cmisfolder; }
}

