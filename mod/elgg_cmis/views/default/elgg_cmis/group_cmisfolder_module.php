<?php
/**
 * Group CMIS folder module
 */

/**
 * Group CMIS folder module
 */

$group = elgg_get_page_owner_entity();

//if ($group->cmis_folder_enable != "yes") { return true; }

if (!elgg_in_context('group_profile')) { return; }

// Display only if a folder is set
$folder = $group->cmisfolder;
if (empty($folder)) { return true; }

global $CONFIG;

$folder = $group->cmisfolder;
//$contenttype = $group->contenttype;
//$recursive = $group->recursive;
if (empty($contenttype)) $contenttype = 'document';
if (empty($recursive)) $recursive = 'true';

$title = elgg_echo('elgg_cmis:widget:cmis_folder');

// Forme d'une URL de partage : share/page/folder-details?nodeRef=workspace://SpacesStore/ + identifiant Alfresco
$needle = 'SpacesStore/';
// Keep only useful info if full URL was provided
if (strrpos($folder, $needle) !== false) {
	$folder_parts = explode($needle, $folder);
	$folder = end($folder_parts);
	
	if (!empty($folder)) {
		$embed_url = $CONFIG->url . 'cmis/repo/list/'.$contenttype.'/folder/' . $folder . '?embed=iframe&recursive='.$recursive;
		$content = '<div class="elgg-cmis-module elgg-cmis-groupmodule-folder"><iframe src="' . $embed_url .'">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
		
	// Nouveau contenu : apparemment pas de lien direct pour uploader...
	// /share/page/create-content?destination=workspace://SpacesStore/$folder&itemId=cm:content&mimeType=text/plain
	
	// Folder link
	//$content .= '<p><a class="elgg-button elgg-button-action" href="' . $group->cmisfolder . '">' . elgg_echo('elgg_cmis:action:openfolder') . '</a></p>';
	
	} else {
		$content = elgg_echo('elgg_cmis:noconf');
	}
} else {
	$content = elgg_echo('elgg_cmis:invalidurl');
}

// Group module
echo elgg_view('groups/profile/module', array(
	'title' => $title,
	'content' => $content,
	'all_link' => $group->cmisfolder,
	'add_link' => false,
));

