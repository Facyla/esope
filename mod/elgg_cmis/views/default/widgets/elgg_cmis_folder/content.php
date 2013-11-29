<?php
/**
 * User blog widget display view
 */
global $CONFIG;

$folder = $vars['entity']->folder;
$contenttype = $vars['entity']->contenttype;
$recursive = $vars['entity']->recursive;
if (empty($contenttype)) $contenttype = 'document';
if (empty($recursive)) $recursive = 'true';

// Forme d'une URL de partage : share/page/folder-details?nodeRef=workspace://SpacesStore/ + identifiant Alfresco
$needle = 'SpacesStore/';
// Keep only useful info if full URL was provided
if (strrpos($folder, $needle) !== false) {
	$folder_parts = explode($needle, $folder);
	$folder = end($folder_parts);
}


if (!empty($folder)) {
	$embed_url = $CONFIG->url . 'cmis/repo/list/'.$contenttype.'/folder/' . $folder . '?embed=iframe&recursive='.$recursive;
	echo '<div class="elgg-cmis-widget elgg-cmis-widget-folder"><iframe src="' . $embed_url .'">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';

	// Nouveau contenu : apparemment pas de lien direct pour uploader...
	// /share/page/create-content?destination=workspace://SpacesStore/$folder&itemId=cm:content&mimeType=text/plain

}

