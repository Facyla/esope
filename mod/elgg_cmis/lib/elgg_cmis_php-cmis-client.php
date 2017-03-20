<?php
/* @TODO
 * - récupérer les fichiers via un token (est-ce possible ?)
 * - hooker sur la recherche Elgg pour inclure les résultats ou du moins un lien vers la recherche Alfresco
 */



/** Get sessionFactory parameters from site configuration
 * @return false|array
 */
function elgg_cmis_get_session_parameters() {
	static $parameters = false;
	if ($parameters) { return $parameters; }
	
	// URLs
	$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
	$cmis_browser_binding = elgg_get_plugin_setting('cmis_1_1_browser_binding', 'elgg_cmis');
	$url = $cmis_url . $cmis_browser_binding;
	// Credentials
	$username = elgg_get_plugin_setting('cmis_username', 'elgg_cmis');
	$password = elgg_get_plugin_setting('cmis_password', 'elgg_cmis');
	
	// Avant tout appel, on devrait tester si l'URL est valide/active, et indiquer un pb d'inaccessibilité ou interruption de service
	if (empty($cmis_url) || empty($username) || empty($password)) {
		register_error('WARNING : required parameters are missing, or CMIS service is unavailable at ' . $cmis_url . '- please <a href="' . elgg_get_site_url() . 'admin/plugin_settings/elgg_cmis" target="_new">update CMIS settings</a>');
		return false;
	}
	// Check that we have a valid repository
	if (!elgg_cmis_is_valid_repo($cmis_url)) {
		register_error('WARNING : CMIS service is unavailable - please <a href="' . $url . '">check URL ' . $url . '</a> manually or <a href="' . elgg_get_site_url() . 'admin/plugin_settings/elgg_cmis" target="_new">update CMIS settings</a>');
		return false;
	}
	
	// Build parameters
	$httpInvoker = new \GuzzleHttp\Client(array('defaults' => array('auth' => array($username, $password))));
	$parameters = array(
			\Dkd\PhpCmis\SessionParameter::BINDING_TYPE => \Dkd\PhpCmis\Enum\BindingType::BROWSER,
			\Dkd\PhpCmis\SessionParameter::BROWSER_URL => $url,
			\Dkd\PhpCmis\SessionParameter::BROWSER_SUCCINCT => false,
			\Dkd\PhpCmis\SessionParameter::HTTP_INVOKER_OBJECT => $httpInvoker
		);
	
	// Add selected repository, or auto-select the first repository
	$repository_id = elgg_get_plugin_setting('repository_id', 'elgg_cmis');
	if (empty($repository_id)) {
		try {
			$sessionFactory = new \Dkd\PhpCmis\SessionFactory();
			$repositories = $sessionFactory->getRepositories($parameters);
			$repository_id = $repositories[0]->getId();
		} catch(Exception $e) {
			error_log("CMIS get_session_parameters failed : " . strip_tags($e->getMessage())); // debug
			return false;
		}
	}
	$parameters[\Dkd\PhpCmis\SessionParameter::REPOSITORY_ID] = $repository_id;
	
	return $parameters;
}

/** Get client session (and create it if needed)
 * @return $session
 */
function elgg_cmis_get_session() {
	static $session = false;
	if ($session) { return $session; }
	
	// Get sessionFactory parameters (and respository if not set)
	$parameters = elgg_cmis_get_session_parameters();
	if (!$parameters) { return false; }
	
	// CMIS Service session factory
	$sessionFactory = new \Dkd\PhpCmis\SessionFactory();
	
	// Create client session
	$session = $sessionFactory->createSession($parameters);
	return $session;
}



/** List repositories
 * @param $sessionFactory
 */
function elgg_cmis_list_repositories() {
	$content = '';
	$parameters = elgg_cmis_get_session_parameters();
	$sessionFactory = new \Dkd\PhpCmis\SessionFactory();
	$repositories = $sessionFactory->getRepositories($parameters);
	foreach($repositories as $repository) {
		$content .= '<p>ID: <strong>' . $repository->getId() . '</strong> / Name: <strong>' . $repository->getName() . '</strong> / Root folder ID <strong>' . $repository->getRootFolderId() . '</strong></p>';
		//$content .= '<pre>' . print_r($repository, true) . '</pre><hr />';
	}
	return $content;
}

/** Get a folder object
 * @param $path : the wanted folder path, from root, eg. /some/path/to/folder/
 * @param $create_path : create full path if not exists
 * @return : $folder object or false
 */
function elgg_cmis_get_folder($path, $create_path = false) {
	$session = elgg_cmis_get_session();
	//echo "elgg_cmis_get_folder : $path";
	try {
		if ($path == '/') {
			$folder = $session->getRootFolder();
		} else {
			$folder = $session->getObjectByPath($path);
		}
		if ($folder) { return $folder; }
	} catch (Exception $e) {
		error_log("CMIS get folder $path failed : " . strip_tags($e->getMessage())); // debug
		//echo print_r($e, true);
	}
	
	// Not exists ? create full path from root to new folder
	if ($create_path) {
		$paths = explode('/', $path);
		$paths = array_filter($paths); // remove empty values and keep folder names
		$parent_path = '/';
		$current_folder = $session->getRootFolder();
		foreach($paths as $name) {
			// Try to get existing folder, and create it otherwise
			$folder = elgg_cmis_get_folder($parent_path . $name . '/', false);
			if (!$folder) { $folder = elgg_cmis_create_folder($parent_path, $name); }
			// Update parent path for next loop
			$parent_path .= $name . '/';
		}
		if ($folder) { return $folder; }
	}
	return false;
}

/** Get a document object
 * Optionally creates the file and the full tree
 * @param $path : the wanted document path, from root, eg. /some/path/to/document
 * @param $create_document : create document if not exists
 * @return : $folder object or false
 */
function elgg_cmis_get_document($path, $create_document = false, $params = null) {
	$session = elgg_cmis_get_session();
	try {
		$document = $session->getObjectByPath($path);
		if ($document) { return $document; }
	} catch (Exception $e) {
		error_log("CMIS exception elgg_cmis_get_document : " . strip_tags($e->getMessage()));
	}
	
	// Not exists ? create full path from root to new folder
	if ($create_document) {
		$paths = explode('/', $path);
		$paths = array_filter($paths); // remove empty values and keep folder names
		$title = array_pop($paths);
		$parent_path = '/' . implode('/', $paths) . '/';
		$folder = elgg_cmis_get_folder($parent_path, true);
		if ($parent_folder) {
			$document = elgg_cmis_create_document($folder, $title, null);
			if ($document) { return $document; }
		}
	}
	return false;
}

/** Lists a folder content
 * @param $folder : a folder grabbed by $session->getRootFolder(); or $session->getObjectByPath($path);
 * @param $levels : max subfolder level (1 = current folder only)
 * @param $max : limit item listing in folder
 */
function elgg_cmis_list_folder_content($folder, $levels = 1, $max = false) {
	$content = elgg_cmis_printFolderContent($folder, '-', $levels, $max);
	if (!empty($content)) {
		return '<p><em>Listing ' . $folder->getName() . ' on ' . $levels . ' tree levels (max ' . $max . ' items per folder)</em></p>' . $content;
	}
	return false;
}

// Get a document by its CMIS id
function elgg_cmis_get_document_by_id($id = '') {
	if (!empty($id)) {
		$session = elgg_cmis_get_session();
		$id = $session->createObjectId($id);
		try {
			$document = $session->getObject($id);
			//getContentStream
			//getLatestDocumentVersion($document)
			//getObject
			if ($document) { return $document; }
		} catch (Exception $e) {
			error_log("CMIS exception in elgg_cmis_get_document_by_id : " . strip_tags($e->getMessage()));
		}
	}
	return false;
}

// Get a document by its CMIS path
function elgg_cmis_get_document_by_path($path = '') {
	if (!empty($path)) {
		$session = elgg_cmis_get_session();
		try {
			$document = $session->getObjectByPath($path);
			if ($document) { return $document; }
		} catch (Exception $e) {
			error_log("CMIS exception in elgg_cmis_get_document_by_path : " . strip_tags($e->getMessage()));
		}
	}
	return false;
}


/** Create new folder (if not exists)
 * @param $path : full new folder path
 * @param $name : new folder name
 * @return : new folder object, or existing folder object
 */
function elgg_cmis_create_folder($path, $name = '') {
	$session = elgg_cmis_get_session();
	//$parent_folder = $session->createObjectId($session->getRepositoryInfo()->getRootFolderId());
	$folder = elgg_cmis_get_folder($path, false);
	$folder = $session->createObjectId($folder->getId());
	$properties = array(
			\Dkd\PhpCmis\PropertyIds::OBJECT_TYPE_ID => 'cmis:folder',
			\Dkd\PhpCmis\PropertyIds::NAME => $name
		);
	try {
		$new_folder = $session->createFolder($properties, $folder);
		return $new_folder;
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		error_log("CMIS create folder failed : " . strip_tags($e->getMessage()));
	}
	return false;
}

/** Create new file / document (if not exists)
 * @param $path : parent folder path
 * @param $content : content stream
 * @param $version : create a new version if exists ?
 * @param $params : document or new version params
 * @return : new document object, or new document version object
 */
function elgg_cmis_create_document($path = '', $name = '', $content = null, $version = false, $params = array()) {
	$session = elgg_cmis_get_session();
	// Create parent path if needed
	$folder = elgg_cmis_get_folder($path, true);
	$major = false;
	/*
	$paths = explode('/', $path);
	$paths = array_filter($paths); // remove empty values and keep folder names
	$title = array_pop($paths);
	$parent_path = '/' . implode('/', $paths) . '/';
	$folder = elgg_cmis_get_folder($parent_path, true);
	*/

	$mime_type = elgg_extract('mime_type', $params, "text/plain");
	$properties = array(
			\Dkd\PhpCmis\PropertyIds::OBJECT_TYPE_ID => 'cmis:document',
			\Dkd\PhpCmis\PropertyIds::NAME => $name
		);
	try {
		//error_log(" - creating new document");
		$document = $session->createDocument(
				$properties,
				$session->createObjectId($folder->getId()),
				$content
			);
		//$document->setMimeType($mime_type);
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		// If unable to create document and versionning is allowed, create a new version
		//error_log(" - failed creating new document - creating new version");
		if ($version) {
			$document = elgg_cmis_version_document($folder->getPath() . '/' . $name, $major, $content, $params);
		}
	}
	if ($document) { return $document; }
	return false;
}

/** Update a file / document properties
 * @param $document
 * @param $properties
 */
function elgg_cmis_update_document($document, $properties = array()) {
	$session = elgg_cmis_get_session();
	if ($document !== null) {
		$document = $session->getObject($document);
		$properties = array(\Dkd\PhpCmis\PropertyIds::DESCRIPTION => 'Updated on ' . time());
		if ($document->updateProperties($properties, true)) { return $document; }
	}
	return false;
}


/** Add new version of a file / document
 * @param $path : full path to document /path/to/document
 * @param $major : is it a major version ?
 * @param $stream : new content
 * @param $params : new document version parameters
 */
function elgg_cmis_version_document($path, $major = true, $stream = false, $params = array()) {
	$session = elgg_cmis_get_session();
	$document = elgg_cmis_get_document($path);
	$document = $session->getObject($document);
	try {
		// Checkout
		$checkedOutDocumentId = $document->getVersionSeriesCheckedOutId();
		if ($checkedOutDocumentId) {
			// Document is already checked out - resuming working copy
			$checkedOutDocumentId = $session->createObjectId($checkedOutDocumentId);
		} else {
			// Checking out document to private working copy (PWC)...
			$checkedOutDocumentId = $document->checkOut();
		}
		//echo "[*] Versioned ID before: " . $document->getId() . "<br />";
		//echo "[*] Versioned ID during checkout: ". $checkedOutDocumentId . "<br />";
		
		// Checkin new version
		$checkedInDocumentId = $session->getObject($checkedOutDocumentId)->checkIn(
				$major,
				array(
					\Dkd\PhpCmis\PropertyIds::DESCRIPTION => 'New description'
				),
				$stream,
				'Checked out/in by system'
			);
		//echo "[*] Versioned ID after: " . $checkedInDocumentId->getId() . "<br /><br />";
		
	} catch (\Dkd\PhpCmis\Exception\CmisVersioningException $e) {
		error_log("CMIS version document failed : " . strip_tags($e->getMessage()));
		//$content .= "ERROR : " . strip_tags($e->getMessage()) . "<br />";
		return false;
	}
	
	//return $document; // old ID
	return $checkedInDocumentId; // New document (updated ID)
}

/** Move file / document to new folder
 * @param $document : a document grabbed by $session->getObjectByPath($path);
 * @param $folder : a folder path (/some/path/to/folder/)
 * @param $new_folder : a folder path (idem)
 * @return : false|new document object
 */
function elgg_cmis_move_document($document, $path, $new_path) {
	$folder = elgg_cmis_get_folder($path);
	$new_folder = elgg_cmis_get_folder($new_path, true); // we may need to create the folder if owner changed
	try {
		$folderId = $folder->getId();
		$new_folderId = $new_folder->getId();
		$document->move($folder, $new_folder);
		return $document;
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		error_log("CMIS move document failed : " . strip_tags($e->getMessage()));
	}
	return false;
}

/** Delete a file / document
 * @param $document : a document
 */
function elgg_cmis_delete_document($document, $all_versions = true) {
	$session = elgg_cmis_get_session();
	$document = $session->getObject($document);
	if ($document !== null) {
		$document = $session->getObject($document);
		try {
			//$document->delete($all_versions);
			$session->delete($document, $all_versions);
			return true;
		} catch (Exception $e) {
			error_log("CMIS delete document failed : " . strip_tags($e->getMessage()));
		}
	}
	return false;
}

/** Delete a folder
 * @param $folder : a folder grabbed by $session->getRootFolder(); or $session->getObjectByPath($path);
 * @param bool $recursive : also delete subfolders
 */
function elgg_cmis_delete_folder($folder, $recursive = false) {
	$session = elgg_cmis_get_session();
	if ($folder !== null) {
		/** @var FolderInterface $folder */
		$folder = $session->getObject($folder);
		if ($recursive) {
			if ($folder->deleteTree(true)) { return true; }
		} else {
			if ($folder->delete(true)) { return true; }
		}
	}
	return false;
}








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
	$document_baseurl = 'https://partage.inria.fr/share/';
	$open_basepath = $document_baseurl . 'page/repository#filter=path|';
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
				$documentID = str_replace('workspace://', '', $obj->properties['alfcmis:nodeRef']);
				// echo elgg_view('output/url', array('text' => 'Open lighbox', 'href' => $url, 'class' => 'elgg-lightbox'));
				foreach ($action_type as $action => $action_path) {
					$action_url = $document_baseurl . $action_path . $documentID;
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



