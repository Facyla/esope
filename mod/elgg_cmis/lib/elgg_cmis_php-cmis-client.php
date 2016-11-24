<?php
/* @TODO
 * - récupérer les fichiers via un token (est-ce possible ?)
 * - hooker sur la recherche Elgg pour inclure les résultats ou du moins un lien vers la recherche Alfresco
 */


/* Affichage du contenu d'un répertoire
 * @param $folder
 * @param $levelIndention : string - marquage textuel d'un niveau
 * @param $max_levels : false|int - nombre de niveaux à afficher
 * @param $max_items : false|int - nb max d'éléments listés dans un dossier
 */
function elgg_cmis_printFolderContent(\Dkd\PhpCmis\Data\FolderInterface $folder, $levelIndention = '--', $max_levels = 1, $max_items = 0) {
	$content = '';
	if (!$max_levels || ($max_levels > 0)) {
		$i = 0;
		foreach ($folder->getChildren() as $children) {
			$content .= $levelIndention;
			$i++;
			// Limit content list
			if ($max_items && ($i > $max_items)) {
				$content .= "| ..." . '<br />';
				break;
			}
			if ($children instanceof \Dkd\PhpCmis\Data\FolderInterface) {
				$content .= '+ [FOLDER]: ' . $children->getName() . '<br />';
				// Limit recursivity
				if (!$max_levels || ($max_levels > 1)) {
					$content .= elgg_cmis_printFolderContent($children, $levelIndention . '--', $max_levels - 1, $max_items);
				}
			} elseif ($children instanceof \Dkd\PhpCmis\Data\DocumentInterface) {
				$content .= '- [DOCUMENT]: ' . $children->getName() . '<br />';
			} else {
				$content .= '- [ITEM]: ' . $children->getName() . '<br />';
			}
		}
	}
	return $content;
}

// Avoid loading other functions (@TODO make them generic ?)
return true;


/* Listing des objets retournés par une requête CMIS
 */
function elgg_cmis_list_objects_backend($objs = false, $debug = false) {
	if ($objs) {
		foreach ($objs->objectList as $obj) {
		
			switch($obj->properties['cmis:baseTypeId']) {
				// DOCUMENT
				case 'cmis:document':
					$return .=  '<p>';
					$mimetype = $obj->properties['cmis:contentStreamMimeType'];
					$return .= elgg_echo('elgg_cmis:icon:document') . $obj->properties['cmis:name'] . ' &nbsp; ';
					if ($debug) $return .= print_r($obj, true);
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
					if ($debug) $return .= print_r($obj, true);
					break;
			
				// AUTRE / INCONNU
				default:
					$return .= elgg_echo('elgg_cmis:icon:unknowtype') . elgg_echo('elgg_cmis:unknowtype') . '<br />';
			
			}
		
		}
	}
	
	$return .= elgg_make_list_from_path($folder_data);
	return $return;
}


/* Listing des objets retournés par une requête CMIS, avec liens de DL, affichage et page
 * Cette fonction n'est à utiliser que pour une authentification *personnelle* car elle nécessite de s'authentifier !
 */
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
				if ($debug) $return .= print_r($obj, true);
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
				if ($debug) $return .= print_r($obj, true);
				break;
			
			// AUTRE / INCONNU
			default:
				$return .= elgg_echo('elgg_cmis:icon:unknowtype') . elgg_echo('elgg_cmis:unknowtype') . '<br />';
			
		}
		
	}
	
	$return .= elgg_make_list_from_path($folder_data);
	return $return;
}



/* Envoi d'un fichier sur le repository
 * $file : file content
 * $name : file name
 * $path : relative path where file should be stored
 * $mime : MIME type
 */
function elgg_cmis_upload_file($file, $name, $path, $mime) {
	elgg_load_library('elgg:elgg_cmis:chemistry');
	
	$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
	$atom_url = elgg_get_plugin_setting('cmis_atom_url', 'elgg_cmis');
	$repo_url = $cmis_url . $atom_url;
	$cmis_service_url = $cmis_url . 'service/cmis/index.html';
	$repo_username = elgg_get_plugin_setting('cmis_username', 'elgg_cmis');
	$repo_password = elgg_get_plugin_setting('cmis_password', 'elgg_cmis');
	$repo_folder = elgg_get_plugin_setting('filestore_path', 'elgg_cmis', "/Applications SI/iris/");
	
	// Avant tout appel, on devrait tester si l'URL est valide/active, et indiquer un pb d'inaccessibilité ou interruption de service
	$is_valid_repo = @fopen($cmis_service_url, 'r');
	if (!$is_valid_repo) {
		register_error("URL CMIS erronnée, ou service indisponible");
		return false;
	}
	
	// Start CMIS Service client
	$client = new CMISService($repo_url, $repo_username, $repo_password);
	
	// Get (navigate to) folder
	$myfolder = $client->getObjectByPath($repo_folder);
	
	// @TODO create subfolders if needed
	
	// Create new file
	$obs = $client->createDocument($myfolder->id, $name, array(), $file, $mime);
	
	return $obs;
}




