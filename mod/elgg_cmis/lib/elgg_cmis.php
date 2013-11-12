<?php

/* Listing des objets retournés par une requête CMIS */
function elgg_cmis_list_objects($objs = false, $debug = false) {
	$file_baseurl = 'https://partage.inria.fr/share/';
	$open_basepath = $file_baseurl . 'page/repository#filter=path|';
	$action_type = array(
			'page' => 'page/document-details?nodeRef=workspace://',
			'view' => 'proxy/alfresco/api/node/content/workspace/',
			'download' => 'proxy/alfresco/api/node/content/workspace/',
			'edit' => 'page/inline-edit?nodeRef=workspace://',
		);
	$return = '';
	
	if ($objs) foreach ($objs->objectList as $obj) {
		
		switch($obj->properties['cmis:baseTypeId']) {
			// DOCUMENT
			case 'cmis:document':
				$return .= elgg_echo('elgg_cmis:document') . '&nbsp;: ' . $obj->properties['cmis:name'];
				$fileID = str_replace('workspace://', '', $obj->properties['alfcmis:nodeRef']);
				$title =  'TYPE= ' . $obj->properties['cmis:contentStreamMimeType'] . ', ID= ' . $obj->id . ', AUTEUR= ' . $obj->properties['cmis:createdBy'];
				foreach ($action_type as $action => $action_path) {
					$action_url = $file_baseurl . $action_path . $fileID;
					if ($action == 'download') $action_url .= '?a=true';
					$return .=  ' &nbsp; <a class="elgg-button elgg-button-action" href="' . $action_url . '" target="_new" title="' . $title . '">' . elgg_echo('elgg_cmis:action:'.$action) . '</a>';
				}
				if ($debug) $return .= print_r($obj);
				$return .=  '<br />';
				break;
			
			// DOSSIER
			case 'cmis:folder':
				$folder_type = $obj->properties['cmis:objectTypeId'];
				if (in_array($folder_type, array('cmis:folder', 'F:st:site'))) {
					$path = $obj->properties['cmis:path'];
					$name = $obj->properties['cmis:name'];
					$type = '';
					if ($folder_type == 'F:st:site') $type = '(' . elgg_echo('elgg_cmis:foldertype:' . $folder_type) . ') ';
					$title =  'PATH= ' . $path . ', ID= ' . $obj->id . ', PARENTID= ' . $obj->properties['cmis:parentId'];
					$folder_data[$path] = $type . $name . ' &nbsp; <a class="elgg-button elgg-button-action" href="' . $open_basepath . $path . '" target="_new" title="' . $title . '">Ouvrir</a>';
				} else continue;
				if ($debug) $return .= print_r($obj);
				break;
			
			// AUTRE / INCONNU
			default:
				$return .= elgg_echo('elgg_cmis:unknowtype') . '<br />';
			
		}
		
	}
	
	$return .= elgg_make_list_from_path($folder_data);
	return $return;
}



