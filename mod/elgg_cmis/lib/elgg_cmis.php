<?php
/* @TODO
 * - récupérer les fichiers via un token (est-ce possible ?)
 * - hooker sur la recherche Elgg pour inclure les résultats ou du moins un lien vers la recherche Alfresco
 */


/* Listing des objets retournés par une requête CMIS */
function elgg_cmis_list_objects($objs = false, $debug = false) {
	$file_baseurl = 'https://partage.inria.fr/share/';
	$open_basepath = $file_baseurl . 'page/repository#filter=path|';
	$action_type = array(
			'download' => 'proxy/alfresco/api/node/content/workspace/',
			'view' => 'proxy/alfresco/api/node/content/workspace/',
			'page' => 'page/document-details?nodeRef=workspace://',
			'edit' => 'page/inline-edit?nodeRef=workspace://',
		);
	$editable_mimetypes = array(
			'text/plain',
			'text/html',
		);
	$return = '';
	$return .= "<style>.fa { margin: 0.1em 0.3em; }</style>";
	
	if ($objs) foreach ($objs->objectList as $obj) {
		
		switch($obj->properties['cmis:baseTypeId']) {
			// DOCUMENT
			case 'cmis:document':
				$return .=  '<p>';
				$mimetype = $obj->properties['cmis:contentStreamMimeType'];
				$return .= elgg_echo('elgg_cmis:icon:document') . $obj->properties['cmis:name'] . ' &nbsp; ';
				$fileID = str_replace('workspace://', '', $obj->properties['alfcmis:nodeRef']);
				// echo elgg_view('output/url', array('text' => 'Open lighbox', 'href' => $url, 'class' => 'elgg-lightbox'));
				foreach ($action_type as $action => $action_path) {
					$action_url = $file_baseurl . $action_path . $fileID;
					if ($action == 'download') $action_url .= '?a=true';
					if (($action == 'edit') && !in_array($mimetype, $editable_mimetypes)) continue;
					$return .=  '<a href="' . $action_url . '" target="_new" title="' . elgg_echo('elgg_cmis:action:'.$action) . '">' . elgg_echo('elgg_cmis:icon:'.$action) . '</a>';
				}
				if ($debug) $return .= print_r($obj);
				$return .=  '</p>';
				break;
			
			// DOSSIER
			case 'cmis:folder':
				$folder_type = $obj->properties['cmis:objectTypeId'];
				if (in_array($folder_type, array('cmis:folder', 'F:st:site'))) {
					$path = $obj->properties['cmis:path'];
					$name = $obj->properties['cmis:name'];
					$folder_data[$path] = elgg_echo('elgg_cmis:icon:foldertype:' . $folder_type) . $name . ' &nbsp; <a href="' . $open_basepath . $path . '" target="_new" title="' . elgg_echo('elgg_cmis:action:openfolder') . '">' . elgg_echo('elgg_cmis:icon:openfolder') . '</a>';
				} else continue;
				if ($debug) $return .= print_r($obj);
				break;
			
			// AUTRE / INCONNU
			default:
				$return .= elgg_echo('elgg_cmis:icon:unknowtype') . elgg_echo('elgg_cmis:unknowtype') . '<br />';
			
		}
		
	}
	
	$return .= elgg_make_list_from_path($folder_data);
	return $return;
}



