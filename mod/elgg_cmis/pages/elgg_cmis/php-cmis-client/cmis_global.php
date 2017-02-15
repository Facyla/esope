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

$base_path = elgg_get_plugin_setting('filestore_path', 'elgg_cmis', "/Applications SI/iris/");

// Debug mode
$repo_debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis', 'no');
if ($repo_debug == 'yes') { $repo_debug = true; } else { $repo_debug = false; }
$repo_debug = get_input('debug', $repo_debug);  // Enable manual override


// dkd uses constants by default
/*
date_default_timezone_set('Europe/Berlin');       // Set the default timezone
define('CMIS_BROWSER_URL', $cmis_url . 'api/-default-/public/cmis/versions/1.1/browser');
define('CMIS_BROWSER_USER', $repo_username);
define('CMIS_BROWSER_PASSWORD', $repo_password);
// if empty the first repository will be used
define('CMIS_REPOSITORY_ID', null);
*/

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


if ($repo_debug) {
	//$content .= "<p>URL : $repo_url<br />Endpoint URL : $cmis_browser_url<br />Base Folder : $base_path<br />Identifiant : $repo_username<br />Mot de passe : $repo_password</p>";
	$content .= "<p>Base Folder : $base_path</p>";
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


// Edit tests sets
$tests_content = '';

$tests = array(
		'list_repo' => (get_input('list_repo') == 'yes') ? true : false,
		'list_root' => (get_input('list_root') == 'yes') ? true : false,
		'list_folder' => (get_input('list_folder') == 'yes') ? true : false,
		'create_folder' => (get_input('create_folder') == 'yes') ? true : false,
		'create_file' => (get_input('create_file') == 'yes') ? true : false,
		'update_file' => (get_input('update_file') == 'yes') ? true : false,
		'version_file' => (get_input('version_file') == 'yes') ? true : false,
		'move_file' => (get_input('move_file') == 'yes') ? true : false,
		'delete_file' => (get_input('delete_file') == 'yes') ? true : false,
		'delete_folder' => (get_input('delete_folder') == 'yes') ? true : false,
	);
//$tests_content .= '<pre>' . print_r($tests, true) . '</pre>'; 

$tests_content .= '<h3>Tests CMIS</h3>';
$tests_content .= '<div class="home-static-container float", style="width:45%;">';
	$tests_content .= '<form action="' . elgg_get_site_url() . 'cmis/test" method="POST">
			<label>' . elgg_view('input/checkbox', array('name' => 'list_repo', 'value' => 'yes', 'checked' => $tests['list_repo'])) . 'List repo</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'list_root', 'value' => 'yes', 'checked' => $tests['list_root'])) . 'List root</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'list_folder', 'value' => 'yes', 'checked' => $tests['list_folder'])) . 'List folder</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'create_folder', 'value' => 'yes', 'checked' => $tests['create_folder'])) . 'Create folder</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'create_file', 'value' => 'yes', 'checked' => $tests['create_file'])) . 'Create file</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'update_file', 'value' => 'yes', 'checked' => $tests['update_file'])) . 'Update file</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'version_file', 'value' => 'yes', 'checked' => $tests['version_file'])) . 'Version file</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'move_file', 'value' => 'yes', 'checked' => $tests['move_file'])) . 'Move file</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'delete_file', 'value' => 'yes', 'checked' => $tests['delete_file'])) . 'Delete file</label></br />
			<label>' . elgg_view('input/checkbox', array('name' => 'delete_folder', 'value' => 'yes', 'checked' => $tests['delete_folder'])) . 'Delete folder</label></br />
			<p>' . elgg_view('input/submit', array('value' => "Run tests")) . '</p>
		</form>';
$tests_content .= '</div>';
$tests_content .= '<div class="home-static-container float-alt", style="width:45%;">';




// Get CMIS client session
$session = elgg_cmis_get_session();

if (!$session) {
	$content .= 'WARNING : required parameters are missing, or service is unavailable - please <a href="' . elgg_get_site_url() . 'admin/plugin_settings/elgg_cmis" target="_new">update CMIS settings</a>';
	$content = $tests_content . '<div class="clearfloat"></div><hr />' . $content;
	// Display content
	if (!empty($content)) {
		if ($embed_mode == 'elgg') {
			$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
		}
		elgg_render_embed_content($content, $title, $embed_mode, $headers);
	}
	exit;
}

// Get the root folder of the repository
//$rootFolder = $session->getRootFolder();
$rootFolder = elgg_cmis_get_folder('/', false);

// Get (navigate to) folder
//$folder = $session->getObjectByPath($base_path);
$folder = elgg_cmis_get_folder($base_path, false);

// Reusable test vars
$new_file_name = 'Nouveau_fichier.txt';
$new_folder_name = 'Nouveau dossier';
//$new_file_content = "THIS IS A NEW DOCUMENT"; // raw data won't pass
// Content should be a stream (unless we can pass something else)
$new_file_content = \GuzzleHttp\Stream\Stream::factory(fopen(elgg_get_plugins_path() . 'elgg_cmis/vendors/php-cmis-client/README.md', 'r'));
$new_file_content2 = \GuzzleHttp\Stream\Stream::factory("Some text or other string data");


// OK - List repositories
if ($tests['list_repo']) {
	esope_dev_profiling("list_repo");
	$content .= '<h3>List repositories</h3>';
	$temp = elgg_cmis_list_repositories();
	if (empty($temp)) { $tests_content .= 'List repositories : <strong style="color:darkred;">FAILED</strong><br />'; } else { $tests_content .= 'List repositories : <strong style="color:darkgreen;">OK</strong><br />'; }
	$content .= $temp;
	esope_dev_profiling("list_repo");
} else { $tests_content .= 'List repositories : <em>not tested</em><br />'; }

// OK - List files and folders in a repository
if ($tests['list_root']) {
	esope_dev_profiling("list_root");
	$content .= '<h3>List root repository content (files and folders)</h3>';
	$temp = elgg_cmis_list_folder_content($rootFolder, 1, false);
	if (empty($temp)) { $tests_content .= 'List root content : <strong style="color:darkred;">FAILED</strong><br />'; } else { $tests_content .= 'List root content : <strong style="color:darkgreen;">OK</strong><br />'; }
	$content .= $temp;
	esope_dev_profiling("list_root");
} else { $tests_content .= 'List root content : <em>not tested</em><br />'; }

// OK - List files in arbitrary folder
if ($tests['list_folder']) {
	esope_dev_profiling("list_folder");
	$content .= '<h3>List folder content (files and folders)</h3>';
	$temp = elgg_cmis_list_folder_content($folder, 1, false);
	if (empty($temp)) { $tests_content .= 'List folder content : <strong style="color:darkred;">FAILED</strong><br />'; } else { $tests_content .= 'List folder content : <strong style="color:darkgreen;">OK</strong><br />'; }
	$content .= $temp;
	esope_dev_profiling("list_folder");
} else { $tests_content .= 'List folder content : <em>not tested</em><br />'; }


// Create or get new folder in arbitrary folder
if ($tests['create_folder']) {
	esope_dev_profiling("create_folder");
	$content .= '<h3>Create new folder</h3>';
	//$new_folder = elgg_cmis_create_folder($folder, $new_folder_name);
	$new_folder = elgg_cmis_get_folder($base_path . $new_folder_name, true);
	if ($new_folder) {
		$content .= "Folder exists or has  been created. Id: " . $new_folder->getId() . "<br />";
		$tests_content .= 'Create folder : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$content .= "ERROR : folder could not be created and does not exist<br />";
		$tests_content .= 'Create folder : <strong style="color:darkred;">FAILED</strong><br />';
	}
	esope_dev_profiling("create_folder");
} else { $tests_content .= 'Create folder : <em>not tested</em><br />'; }

// Create file in arbitrary folder
if ($tests['create_file']) {
	esope_dev_profiling("create_file");
	$content .= '<h3>Create new file</h3>';
	//$new_file_content = "THIS IS A NEW DOCUMENT"; // raw data won't pass
	// Content should be a stream (unless we can pass something else)
	// @TODO Load file from Elgg datastore
	// @TODO Load file from string content
	// @TODO Load file from upload
	// Note : do not try to create new version for testing purposes
	$new_file = elgg_cmis_create_document($folder->getPath(), $new_file_name, $new_file_content, false);
	if ($new_file) {
		$content .= "File created. Id: " . $new_file->getId() . "<br />";
		$tests_content .= 'Create file : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$new_file = elgg_cmis_get_document($base_path . $new_file_name);
		if ($new_file) {
			$content .= "File already exists. Id: " . $new_file->getId() . "<br />";
			$tests_content .= 'Create file : <strong style="color:darkgreen;">OK</strong> (from previous test)<br />';
		} else {
			$tests_content .= 'Create file : <strong style="color:darkred;">FAILED</strong><br />';
			$content .= "ERROR : file could not be created and does not exist<br />";
		}
	}
	esope_dev_profiling("create_file");
} else { $tests_content .= 'Create file : <em>not tested</em><br />'; }


// Edit file properties
if ($tests['update_file']) {
	esope_dev_profiling("update_file");
	$content .= '<h3>Update file</h3>';
	$properties = array(\Dkd\PhpCmis\PropertyIds::DESCRIPTION => 'Updated on ' . time());
	try {
		$new_file = elgg_cmis_update_document($new_file, $properties);
		if ($new_file) {
			$content .= "File updated, the property " . \Dkd\PhpCmis\PropertyIds::DESCRIPTION . " should now has the value '" . $properties[\Dkd\PhpCmis\PropertyIds::DESCRIPTION]. "<br />";
			$tests_content .= 'Update file : <strong style="color:darkgreen;">OK</strong><br />';
		} else {
			$content .= "ERROR : No file, could not be updated !<br />";
			$tests_content .= 'Update file : <strong style="color:darkred;">FAILED</strong><br />';
		}
	} catch(Exception $e) {
		$content .= "ERROR : " . $e->message . '<br />';
	}
	esope_dev_profiling("update_file");
} else { $tests_content .= 'Update file : <em>not tested</em><br />'; }

// Create new version of file / document
if ($tests['version_file']) {
	esope_dev_profiling("version_file");
	$content .= '<h3>Version file</h3>';
	$new_file = elgg_cmis_version_document($folder->getPath() . "/$new_file_name", rand(0,1), $new_file_content2, array());
	//$new_file = elgg_cmis_create_document($folder->getPath(), "$new_file_name", $new_file_content2, true);
	if ($new_file) {
		// Versions
		$content .= "The following versions of " . $new_file->getName() . " are now stored in the repository:<br />";
		foreach ($new_file->getAllVersions() as $version) {
			$content .= "  * " . $version->getVersionLabel() . ' ';
			$content .= $version->isLatestVersion() ? ' LATEST' : '';
			$content .= $version->isLatestMajorVersion() ? ' MAJOR VERSION' : '';
			$content .= "<br />";
		}
		$content .= "<br />";
		$tests_content .= 'Version file : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$tests_content .= 'Version file : <strong style="color:darkred;">FAILED</strong><br />';
	}
	esope_dev_profiling("version_file");
} else { $tests_content .= "Version file : <em>not tested</em><br />"; }

// Move file to new folder
if ($tests['move_file']) {
	esope_dev_profiling("move_file");
	$content .= '<h3>Move file</h3>';
	if (!$new_file) { $new_file = elgg_cmis_get_document($base_path . $new_file_name, true); }
	$new_file = elgg_cmis_move_document($new_file, $base_path, $base_path . $new_folder_name);
	if ($new_file) {
		$content .= "File has been moved. Id: " . $new_file->getId() . "<br />";
		$tests_content .= 'Move file : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$content .= "ERROR : " . $e->getMessage() . "<br />";
		$tests_content .= 'Move file : <strong style="color:darkred;">FAILED</strong><br />';
	}
	esope_dev_profiling("move_file");
} else { $tests_content .= 'Move file : <em>not tested</em><br />'; }



// Download file content
/*
if ($tests['send_file']) {
		$content .= '<h3>Create new file</h3>';
	$file = get_entity(4759);
	if (elgg_instanceof($file, 'object', 'file')) {
		//$content .= print_r($file, true);
		$serve_file = $client->getObject($file->cmis_id);
		//$serve_file = $client->getObjectByPath($base_path . '1475181161bacasable.jpg');
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
}
*/




// Delete file
if ($tests['delete_file']) {
	esope_dev_profiling("delete_file");
	$content .= '<h3>Delete file</h3>';
	// Remove all created test files
	$new_file = elgg_cmis_get_document($base_path . $new_file_name);
	if ($new_file && elgg_cmis_delete_document($new_file)) {
		$content .= "$base_path$new_file_name has been deleted.<br />";
		$tests_content .= 'Delete file : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$content .= "ERROR : no file or could not be deleted !<br />";
		$tests_content .= 'Delete new file : <strong style="color:darkred;">FAILED</strong><br />';
	}
	// Removed moved file
	$new_file = elgg_cmis_get_document($base_path . $new_folder_name . '/' . $new_file_name);
	if ($new_file && elgg_cmis_delete_document($new_file)) {
		$content .= "$base_path$new_folder_name$new_file_name has been deleted.<br />";
		$tests_content .= 'Delete file : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$content .= "ERROR : no file or could not be deleted !<br />";
		$tests_content .= 'Delete moved file : <strong style="color:darkred;">FAILED</strong><br />';
	}
	esope_dev_profiling("delete_file");
} else { $tests_content .= 'Delete moved file : <em>not tested</em><br />'; }


// Delete folder
if ($tests['delete_folder']) {
	esope_dev_profiling("delete_folder");
	$content .= '<h3>Delete folder</h3>';
	if (!$new_folder) {
		$new_folder = $session->getObjectByPath($base_path. $repo_new_folder . '/');
		$content .= "WARNING : No valid new folder, getting existing one if any<br />";
		$tests_content .= 'Delete folder : WARNING => ';
	}
	// @TODO test if content inside folder
	
	if (elgg_cmis_delete_folder($new_folder, true)) {
		$content .= "Folder deleted<br />";
		$tests_content .= 'Delete folder : <strong style="color:darkgreen;">OK</strong><br />';
	} else {
		$content .= "ERROR : No folder, could not be deleted !<br />";
		$tests_content .= 'Delete folder : <strong style="color:darkred;">FAILED</strong><br />';
	}
	esope_dev_profiling("delete_folder");
} else { $tests_content .= 'Delete folder : <em>not tested</em><br />'; }






// Arbitrary query
// $objs = $client->query("select * from cmis:folder");

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
$tests_content .= '</div>';
$tests_content .= '<div class="clearfloat"></div>';
$content = $tests_content . '<div class="clearfloat"></div><hr />' . $content;

// Display content
if (!empty($content)) {
	if ($embed_mode == 'elgg') {
		$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
	}
	elgg_render_embed_content($content, $title, $embed_mode, $headers);
}

