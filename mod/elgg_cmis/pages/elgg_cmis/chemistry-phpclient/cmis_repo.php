<?php
$title = elgg_echo('elgg_cmis:title');
$content = '';

$own_guid = elgg_get_logged_in_user_guid();
$own = elgg_get_logged_in_user_entity();


$cmis_url = elgg_get_plugin_setting('cmis_url', 'elgg_cmis');
$atom_url = elgg_get_plugin_setting('cmis_atom_url', 'elgg_cmis');
$repo_url = $cmis_url . $atom_url;
$cmis_service_url = $cmis_url . 'service/cmis/index.html';
//$repo_url = elgg_get_plugin_setting('user_cmis_url', $own_guid, 'elgg_cmis'); // Custom repo
$repo_username = elgg_get_plugin_user_setting('cmis_login', $own_guid, 'elgg_cmis');
$repo_password = elgg_get_plugin_user_setting('cmis_password2', $own_guid, 'elgg_cmis');
$key = $own->guid . $own->salt;
if (!empty($repo_password)) {
	$repo_password = base64_decode($repo_password);
	$repo_password = esope_vernam_crypt($repo_password, $key);
}
$repo_debug = elgg_get_plugin_setting('debugmode', 'elgg_cmis', 'no');
if ($repo_debug == 'yes') { $repo_debug = true; } else { $repo_debug = false; }



// Variables utiles
$cmis_query = get_input('query', 'folders'); // list, search, view
$cmis_type = get_input('type', ''); // folder, documents, sites
$cmis_filter = get_input('filter', ''); // author, search, insearch, folder
$cmis_filter_value = get_input('filter_value', ''); // 
$embed_mode = get_input('embed', 'elgg');
$repo_debug = get_input('debug', false);

$recursive = get_input('recursive', 'false');

// Lightbox support
//elgg_load_js('lightbox');
//elgg_load_css('lightbox');


if ($repo_debug) $content .= "URL : $repo_url<br />Identifiant : $repo_username<br />Mot de passe : $repo_password<br />";

if (empty($repo_url) || empty($repo_username) || empty($repo_password)) {
	echo 'WARNING : required parameters are missing - please <a href="' . elgg_get_site_url() . 'settings/plugins/' . $own->username . '" target="_new">update your user CMIS plugin settings</a>';
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
$is_valid_repo = @fopen($cmis_service_url, 'r');
if ($is_valid_repo) {
} else {
	echo "URL CMIS erronnée, ou service indisponible";
	exit;
}

$client = new CMISService($repo_url, $repo_username, $repo_password);

if ($repo_debug) {
		$content .= "Repository Information:<br />===========================================<br />";
		$content .= print_r($client->workspace, true);
		$content .= "<br />===========================================<br /><br />";
}

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

if ($repo_debug > 2) {
	$content .= "<hr />Final State of Client :<br />" . print_r($client, true);
}


// Display content
if (!empty($content)) {
	if ($embed_mode == 'elgg') {
		$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
	}
	elgg_render_embed_content($content, $title, $embed_mode, $headers);
}

