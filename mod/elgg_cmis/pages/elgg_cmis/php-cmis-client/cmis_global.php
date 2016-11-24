<?php
/* @TODO
 * Versionning : DKD lib only
 * 
 * 
*/


$title = elgg_echo('elgg_cmis:title');
$content = '';

$own_guid = elgg_get_logged_in_user_guid();
$own = elgg_get_logged_in_user_entity();


// URLs
$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
$atom_url = elgg_get_plugin_setting('cmis_atom_url', 'elgg_cmis');
$repo_url = $cmis_url . $atom_url;
$cmis_service_url = $cmis_url . 'service/cmis/index.html';
$cmis_browser_url = $cmis_url . 'api/-default-/public/cmis/versions/1.1/browser';
// Credentials
$repo_username = elgg_get_plugin_setting('cmis_username', 'elgg_cmis');
$repo_password = elgg_get_plugin_setting('cmis_password', 'elgg_cmis');
// Debug mode
$repo_debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis', 'no');
if ($repo_debug == 'yes') { $repo_debug = true; } else { $repo_debug = false; }
$repo_debug = get_input('debug', $repo_debug);  // Enable manual override
$repo_folder = elgg_get_plugin_setting('filestore_path', 'elgg_cmis', "/Applications SI/iris/");

// dkd uses constants by default
date_default_timezone_set('Europe/Berlin');       // Set the default timezone
define('CMIS_BROWSER_URL', $cmis_url . 'api/-default-/public/cmis/versions/1.1/browser');
define('CMIS_BROWSER_USER', $repo_username);
define('CMIS_BROWSER_PASSWORD', $repo_password);
// if empty the first repository will be used
define('CMIS_REPOSITORY_ID', null);

//$new_repo_folder = get_input('new_folder', '');

// Variables utiles
$cmis_query = get_input('query', 'folders'); // list, search, view
$cmis_type = get_input('type', ''); // folder, documents, sites
$cmis_filter = get_input('filter', ''); // author, search, insearch, folder
$cmis_filter_value = get_input('filter_value', ''); // 
$embed_mode = get_input('embed', 'elgg');

$recursive = get_input('recursive', 'false');

// Lightbox support
//elgg_load_js('lightbox');
//elgg_load_css('lightbox');


if ($repo_debug) { $content .= "URL : $repo_url<br />Endpoint URL : $cmis_browser_url<br />Base Folder : $repo_folder<br />Identifiant : $repo_username<br />Mot de passe : $repo_password<br />"; }

if (empty($repo_url) || empty($repo_username) || empty($repo_password)) {
	echo 'WARNING : required parameters are missing - please <a href="' . elgg_get_site_url() . 'settings/plugins/' . $own->username . '" target="_new">update your CMIS plugin settings</a>';
	exit;
}




/* URL utiles pour affichage et accès Partage :
	$baseurl = 'https://partage.inria.fr/share/';
	Dossiers :
		$baseurl + page/repository#filter=path| + cmis:path
	Fichiers : $baseurl . $action_type . $fileID


* Requêtes utiles :
=> What it does
CMIS Query

=> Select the name of every whitepaper with “sample” somewhere in their text.
SELECT cmis:name FROM sc:whitepaper where contains(‘sample’)

=> Select the name of whitepapers with “sample” somewhere in their text, ordered by full-text relevance, descending.
SELECT cmis:name, Score() as relevance FROM sc:whitepaper where contains('sample') order by relevance DESC

=> Select whitepapers with the isActive flag set to true (which happens to be a property defined by an aspect).
SELECT cmis:name from sc:whitepaper where sc:isActive = true

=> Select whitepapers with the isActive flag not set to true. This will return whitepapers where the property is not true as well as whitepapers where the property is unset.
SELECT cmis:name from sc:whitepaper where not(sc:isActive = true)

=> Select instances of Marketing Documents and their children where the multi-value property, sc:campaign, contains the value “Social Shopping” (note that Whitepaper is a child type of Marketing Document).
SELECT cmis:name from sc:marketingDoc where any sc:campaign in ('Social Shopping')

=> Select whitepapers published (sc:published, a property of the sc:webable aspect) on or after November 10, 2009 and before 18, 2009.
SELECT cmis:name,sc:published from sc:whitepaper where sc:published >= '2009-11-10T00:00:00.000-06:00' and sc:published < '2009-11-18T00:00:00.000-06:00'

=> Select all content in the Sales folder containing the word “contract”.
SELECT cmis:name from cmis:document where in_folder('workspace://SpacesStore/3935ce21-9f6f-4d46-9e22-4f97e1d5d9d8') and contains('contract')

=> Select all content in the Sales folder or any of its descendant folders containing the word “contract” and a description like “%sign%”.
SELECT cmis:name from cmis:document where in_tree('workspace://SpacesStore/3935ce21-9f6f-4d46-9e22-4f97e1d5d9d8') and contains('contract') and cm:description like “%sign%”


=> use joins
select d.cmis:objectid from cmis:document as d join cm:author as a on 
d.cmis:objectid = a.cmis:objectid where 
in_tree(d, 'workspace://SpacesStore/f91de5f4-629b-4a07-9729-78f860c3deaa') AND
(a.cm:author LIKE '%MArttinen%')

*/

// Avant tout appel, on devrait tester si l'URL est valide/active, et indiquer un pb d'inaccessibilité ou interruption de service
$is_valid_repo = @fopen($cmis_url, 'r');
if ($is_valid_repo) {
} else {
	echo "URL CMIS erronnée, ou service indisponible";
	exit;
}

// Edit tests sets
$tests = array(
		'list_root' => true,
		'list_folder' => true,
		'create_folder' => true,
		'create_file' => true,
		'update_file' => true,
		'version_file' => false,
		'move_file' => true,
		'delete_file' => false,
		'delete_folder' => false,
	);

$tests_content = '';
$tests_content .= '<h3>Tests CMIS</h3>';



// Apache Chemistry CMIS library @TODO adapt to dkd library

// CMIS Service session factory
$httpInvoker = new \GuzzleHttp\Client(array(
			'defaults' => array('auth' => array($repo_username, $repo_password))
		));
$parameters = array(
	\Dkd\PhpCmis\SessionParameter::BINDING_TYPE => \Dkd\PhpCmis\Enum\BindingType::BROWSER,
	\Dkd\PhpCmis\SessionParameter::BROWSER_URL => $cmis_browser_url,
	\Dkd\PhpCmis\SessionParameter::BROWSER_SUCCINCT => false,
	\Dkd\PhpCmis\SessionParameter::HTTP_INVOKER_OBJECT => $httpInvoker
);
$sessionFactory = new \Dkd\PhpCmis\SessionFactory();


// List repositories
$content .= '<h3>Repositories</h3>';
$repositories = $sessionFactory->getRepositories($parameters);
foreach($repositories as $repository) {
	$content .= "<strong>" . $repository->getName() . "</strong> &nbsp; ID: " . $repository->getId() . ' &nbsp; Root folder ID ' . $repository->getRootFolderId() . '<br />';
	//$content .= '<pre>' . print_r($repository, true) . '</pre><hr />';
}


// Select repository - If no repository id is defined use the first repository
if (CMIS_REPOSITORY_ID === null) {
	$repositories = $sessionFactory->getRepositories($parameters);
	$parameters[\Dkd\PhpCmis\SessionParameter::REPOSITORY_ID] = $repositories[0]->getId();
} else {
	$parameters[\Dkd\PhpCmis\SessionParameter::REPOSITORY_ID] = CMIS_REPOSITORY_ID;
}

// Create client session
$session = $sessionFactory->createSession($parameters);

// Get the root folder of the repository
$rootFolder = $session->getRootFolder();

// Get (navigate to) folder
$folder = $session->getObjectByPath($repo_folder);


// List files and folders in a repository
if ($tests['list_root']) {
	$content .= '<h3>List files and folders in repository (root folder)</h3>';
	$content .= '+ [ROOT FOLDER]: ' . $rootFolder->getName() . "<br />";
	$temp = elgg_cmis_printFolderContent($rootFolder, '-', 1);
	if (empty($temp)) { $tests_content .= 'List root content : FAILED<br />'; } else { $tests_content .= 'List root content : OK<br />'; }
	$content .= $temp;
}


// List files in arbitrary folder
if ($tests['list_folder']) {
	$content .= '<h3>List files and folders in ' . $folder->getName() . '</h3>';
	$content .= '+ [ROOT FOLDER]: ' . $folder->getName() . "<br />";
	$temp = elgg_cmis_printFolderContent($folder, '-', 1);
	if (empty($temp)) { $tests_content .= 'List folder content : FAILED<br />'; } else { $tests_content .= 'List folder content : OK<br />'; }
	$content .= $temp;
}


// Create new folder in arbitrary folder
if ($tests['create_folder']) {
	$content .= '<h3>Create new folder</h3>';
	$repo_new_folder = "Nouveau dossier";
	$properties = array(
			\Dkd\PhpCmis\PropertyIds::OBJECT_TYPE_ID => 'cmis:folder',
			\Dkd\PhpCmis\PropertyIds::NAME => $repo_new_folder
		);
	try {
		//$new_folder = $session->createFolder($properties, $session->createObjectId($session->getRepositoryInfo()->getRootFolderId()));
		$new_folder = $session->createFolder($properties, $session->createObjectId($folder->getId()));
		$content .= "Folder has been created. Folder Id: " . $new_folder->getId() . "<br />";
		$tests_content .= 'Create folder : OK<br />';
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		$content .= "ERROR : " . $e->getMessage() . "<br />" . "Try to get folder by path!<br />";
		$tests_content .= 'Create folder : FAILED<br />';
		$new_folder = $session->getObjectByPath($repo_folder . $properties[\Dkd\PhpCmis\PropertyIds::NAME] . '/');
		$content .= 'Get existing folder : ' . $new_folder->getId() . '<br />';
	}
}


// Create file in arbitrary folder
if ($tests['create_file']) {
	$content .= '<h3>Create new file</h3>';
	$repo_new_file = "Nouveau_fichier.txt";
	//$repo_new_file_content = "THIS IS A NEW DOCUMENT"; // raw data won't pass'
	// Content should be a stream (unless we can pass something else)
	$repo_new_file_content = \GuzzleHttp\Stream\Stream::factory(fopen(elgg_get_plugins_path() . 'elgg_cmis/vendors/php-cmis-client/README.md', 'r'));
	$repo_new_file_mime = "text/plain";
	$properties = array(
			\Dkd\PhpCmis\PropertyIds::OBJECT_TYPE_ID => 'cmis:document',
			\Dkd\PhpCmis\PropertyIds::NAME => $repo_new_file
		);
	try {
		$new_file = $session->createDocument(
				$properties,
				$session->createObjectId($folder->getId()),
				$repo_new_file_content
			);
		$content .= "File created. Id: " . $new_file->getId() . "<br />";
		$tests_content .= 'Create file : OK<br />';
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		$content .= "ERROR : " . $e->getMessage() . "<br />";
		$tests_content .= 'Create file : FAILED<br />';
		$new_file = $session->getObjectByPath($repo_folder . $properties[\Dkd\PhpCmis\PropertyIds::NAME]);
		$content .= 'Get existing file : ' . $new_file->getId() . '<br />';
	}
}


// Edit file properties
if ($tests['update_file']) {
	$content .= '<h3>Update file</h3>';
	if ($new_file !== null) {
		$new_file = $session->getObject($new_file);
		$properties = array(\Dkd\PhpCmis\PropertyIds::DESCRIPTION => 'Updated on ' . time());
		$new_file->updateProperties($properties, true);
		$content .= "File updated, the property " . \Dkd\PhpCmis\PropertyIds::DESCRIPTION . " should now has the value '" . $properties[\Dkd\PhpCmis\PropertyIds::DESCRIPTION]. "<br />";
		$tests_content .= 'Update file : OK<br />';
	} else {
		$content .= "ERROR : No file, could not be updated !<br />";
		$tests_content .= 'Update file : FAILED<br />';
	}
}


if ($tests['version_file']) {
	$content .= '<h3>TODO Version file</h3>';
	$new_file = $session->getObject($new_file);
	// Checkout
	try {
		$checkedOutDocumentId = $new_file->getVersionSeriesCheckedOutId();
		if ($checkedOutDocumentId) {
			$content .= "[*] Document is already checked out - resuming working copy<br />";
			$checkedOutDocumentId = $session->createObjectId($checkedOutDocumentId);
		} else {
			$content .= "[*] Checking out document to private working copy (PWC)... ";
			$checkedOutDocumentId = $new_file->checkOut();
			$content .= "done!<br />";
		}
		$content .= "[*] Versioned ID before: " . $new_file->getId() . "<br />";
		$content .= "[*] Versioned ID during checkout: ". $checkedOutDocumentId . "<br />";
		// Checkin
		$content .= "[*] Checking in with updated properties (";
		if ($major) {
			$content .= 'major';
		} else {
			$content .= 'minor - to make a major revision pass a "1" - one - as argument to the example script';
		}
		$content .= ")<br />";
		$checkedInDocumentId = $session->getObject($checkedOutDocumentId)->checkIn(
				$major,
				array(
					\Dkd\PhpCmis\PropertyIds::DESCRIPTION => 'New description'
				),
				$stream,
				'Checked out/in by system'
			);
		$content .= "[*] Versioned ID after: " . $checkedInDocumentId->getId() . "<br /><br />";
		// Versions
		$content .= "The following versions of $repo_new_file are now stored in the repository:<br />";
		foreach ($new_file->getAllVersions() as $version) {
			$content .= "  * " . $version->getVersionLabel() . ' ';
			$content .= $version->isLatestVersion() ? 'LATEST' : '';
			$content .= $version->isLatestMajorVersion() ? 'LATEST MAJOR' : '';
			$content .= "<br />";
		}
		$content .= "<br />";
	} catch (\Dkd\PhpCmis\Exception\CmisVersioningException $e) {
		$content .= "ERROR : " . $e->getMessage() . "<br />";
	}
	
	
	
	
	
}


// Move file to fnew older
if ($tests['move_file']) {
	$content .= '<h3>Move file</h3>';
	$folderId = $folder->getId();
	$new_folderId = $new_folder->getId();
	try {
		$new_file->move($folder, $new_folder);
		$content .= "File has been moved. Id: " . $new_file->getId() . "<br />";
		$tests_content .= 'Move file : OK<br />';
	} catch (\Dkd\PhpCmis\Exception\CmisContentAlreadyExistsException $e) {
		$content .= "ERROR : " . $e->getMessage() . "<br />";
		$tests_content .= 'Move file : FAILED<br />';
	}
}


// Delete file
if ($tests['delete_file']) {
	$content .= '<h3>Delete file</h3>';
	if ($new_file !== null) {
		/** @var FolderInterface $folder */
		$new_file = $session->getObject($new_file);
		$new_file->delete(true);
		$content .= "File has been deleted.<br />";
		$tests_content .= 'Delete file : OK<br />';
	} else {
		$content .= "ERROR : no file, could not be deleted !<br />";
		$tests_content .= 'Delete file : FAILED<br />';
	}
}


// Delete folder
if ($tests['delete_folder']) {
	$content .= '<h3>Delete folder</h3>';
	if (!$new_folder) {
		$new_folder = $session->getObjectByPath($repo_folder. $repo_new_folder . '/');
		$content .= "WARNING : No valid new folder, getting existing one if any<br />";
		$tests_content .= 'Delete folder : WARNING => ';
	}
	if ($new_folder !== null) {
		/** @var FolderInterface $folder */
		$new_folder = $session->getObject($new_folder);
		$new_folder->delete(true);
		$content .= "Folder deleted<br />";
		$tests_content .= 'Delete folder : OK<br />';
	} else {
		$content .= "ERROR : No folder, could not be deleted !<br />";
		$tests_content .= 'Delete folder : FAILED<br />';
	}
}





// Checkin / checkout et versionning : pas avec ce client PHP (possible avec la lib de DKD)
/*
checkedout = $client->checkOut($obj->id);
$client->checkIn($checkedout->id);
*/

// Send file content - OK
/*
$file = get_entity(4759);
if (elgg_instanceof($file, 'object', 'file')) {
	//$content .= print_r($file, true);
	$serve_file = $client->getObject($file->cmis_id);
	//$serve_file = $client->getObjectByPath($repo_folder . '1475181161bacasable.jpg');
	//$content .= '<hr /><pre>' . print_r($serve_file, true) . '</pre>';
	$file_content = $client->getContentStream($serve_file->id);
	//$content .= '<hr />RAW CONTENT = ' . $file_content . '</pre>';
	
	$mime = $file->getMimeType();
	if (!$mime) {
		$mime = "application/octet-stream";
	}

	$filename = $file->originalfilename;

	// fix for IE https issue
	header("Pragma: public");

	header("Content-type: $mime");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Length: {$file->getSize()}");

	while (ob_get_level()) {
		  ob_end_clean();
	}
	flush();
	readfile($file->getFilenameOnFilestore());
	exit;
}
*/


// Arbitrary query
// $objs = $client->query("select * from cmis:folder");


// List folder content
/*
$objs = $client->getChildren($myfolder->id);
if ($repo_debug) {
	$content .= '<br />' . "Folder Children Objects<br />:<br />===========================================<br />";
	print_r($objs);
	$content .= '<br />' . "<br />===========================================<br /><br />";
}
foreach ($objs->objectList as $obj) {
	if ($obj->properties['cmis:baseTypeId'] == "cmis:document") {
		$content .= '<br />' . "Document: " . $obj->properties['cmis:name'] . "<br />";
	} elseif ($obj->properties['cmis:baseTypeId'] == "cmis:folder") {
		$content .= '<br />' . "Folder: " . $obj->properties['cmis:name'] . "<br />";
	} else {
		$content .= '<br />' . "Unknown Object Type: " . $obj->properties['cmis:name'] . "<br />";
	}
}

$content .= elgg_cmis_list_objects_backend($objs);

*/
$content .= '<div class="clearfloat"></div><br />';



// @TODO : charger un fichier depuis Elgg vers Partage (avec choix de la cible de stockage : Elgg ou CMIS)
// @TODO : 

switch($cmis_query) {
	case 'list':
		switch($cmis_type) {
			case 'folder':
			case 'document':
				if ($cmis_filter == 'mine') { $cmis_filter= 'author'; $cmis_filter_value = $repo_username; }
				if ($cmis_filter && $cmis_filter_value) {
					// filter : author, search, insearch, folder
						switch($cmis_filter) {
							case 'author':
								$filter_query = "where cmis:createdBy = '$cmis_filter_value'";
								break;
							case 'search':
								$filter_query = "where cmis:name LIKE '%$cmis_filter_value%'";
								break;
							case 'insearch':
								$filter_query = "WHERE CONTAINS('TEXT:*$cmis_filter_value*')";
								/*
								The full text search expression is a String literal containing the search expression. The simplest expression is a single term.
								SELECT * FROM cmis:document WHERE CONTAINS('test')
								SELECT * FROM cmis:document D WHERE CONTAINS(D, 'test')
								 
								Phrases may also be used but the quotes have to be escaped:
								SELECT * FROM cmis:document WHERE CONTAINS('\'test tube\'')
								SELECT * FROM cmis:document D WHERE CONTAINS(D, '\'test tube\'')
								Both terms and phrases can be preceded with '-' for negation.
								SELECT * FROM cmis:document WHERE CONTAINS('-test')
								SELECT * FROM cmis:document D WHERE CONTAINS(D, '-test')
								SELECT * FROM cmis:document WHERE CONTAINS('-\'test tube\'')
								SELECT * FROM cmis:document D WHERE CONTAINS(D, '-\'test tube\'')
								Terms and phrases separated by white space are AND'ed together, those separated by OR are OR'ed.
								SELECT * FROM cmis:document WHERE CONTAINS('-test tube')
								SELECT * FROM cmis:document WHERE CONTAINS('-test OR tube')
								*/
								break;
							case 'folder':
								/* folder predicate
Folder predicate is supported by two predicate functions IN_FOLDER and IN_TREE() which have the same arguments. An optional qualifier with the same meaning as the optional qualifier in the CONTAINS() predicate function and a folder id. The folder id must be the id of a folder in the repository. IN_FOLDER() matches the immediate children of a folder, IN_TREE matches any object beneath the folder.
SELECT cmis:name FROM cmis:document WHERE IN_FOLDER('folder id')
SELECT cmis:name FROM cmis:folder F WHERE IN_TREE(F, 'folder id')
								*/
								if ($recursive == 'true') {
									// Docs dans tous les sous-dossiers
									$filter_query = "where in_tree('workspace://SpacesStore/$cmis_filter_value')";
								} else {
									// Docs du dossier
									$filter_query = "where in_folder('workspace://SpacesStore/$cmis_filter_value')";
								}
								break;
							default:
								$content .= "Filtre invalide<br />";
						}
				}
				$objs = $client->query("select * from cmis:$cmis_type $filter_query");
				break;
				//$objs = $client->query("select * from cmis:document where cmis:name LIKE '%test%'"); // Recherche par titre
				// SELECT cmis:name from cmis:document where in_tree('workspace://SpacesStore/3935ce21-9f6f-4d46-9e22-4f97e1d5d9d8')
				break;
			case 'site':
				$content .= "Non implémenté pour le moment";
				break;
			default:
				$content .= "Aucun type d'objet, précisez : folder / document";
		}
		$content .= elgg_cmis_list_objects($objs, false);
		if ($repo_debug) { $content .= "<hr />Objects :<br />" . print_r($objs, true) . "<hr />"; }
		break;
		
	case 'view':
		$content .= "Non implémenté pour le moment";
		break;
		
	case 'test':
		/* SELECT D.*, SCORE() FROM cmis:document D 
			 WHERE CONTAINS('test') AND (IN_FOLDER('F-1') OR IN_FOLDER('F-2')) AND D.cmis:name LIKE 't%'
			 ORDER BY SEARCH_SCORE DESC, D.cmis:name ASC
		*/
		//$objs = $client->query("select * from cmis:document D, cmis:folder F where F.cmis:name like '%devnet%'");
		$objs = $client->query("select * from cmis:document WHERE CONTAINS('Devnet')");
		$content .= elgg_cmis_list_objects($objs);
		break;
	
	default:
		$content .= "Aucune requête, précisez : list / search / view";
}

if ($repo_debug) {
	$content .= "<hr />Final State of Client :<br />" . print_r($client, true);
}



// DEBUG
$content = $tests_content . '<hr />' . $content;

// Display content
if (!empty($content)) {
	if ($embed_mode == 'elgg') {
		$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
	}
	elgg_render_embed_content($content, $title, $embed_mode, $headers);
}

