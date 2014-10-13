<?php
/**
* Elgg Etherpad Lite integration
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

gatekeeper();

$title = "Pads";

$body = "";

$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
$api_key = elgg_get_plugin_setting('api_key', 'elgg_etherpad');
$cookiedomain = elgg_get_plugin_setting('cookiedomain', 'elgg_etherpad');

$own = elgg_get_logged_in_user_entity();
$authorMapper = $own->guid;
$name = $own->name;

//$client = new \EtherpadLite\Client($api_key, $server);
$client = new EtherpadLiteClient($api_key, $server.'/api');



// http://etherpad.org/doc/v1.4.1/#index_createauthor_name
$available_methods = $client->getMethods();
foreach ($available_methods as $method_name => $method_args) {
	$methods_opts[$method_name] = $method_name;
}


// MAIN CONTENT

// Etherpad Lite User process
// 1. Check we have an author, or create it
// Portal maps the internal userid to an etherpad author
$response = $client->createAuthorIfNotExistsFor($authorMapper, $name);
$authorID = elgg_etherpad_get_response_data($response, 'authorID');
$groupMapper = $authorMapper;

// 2. Then create the associated group
// Portal maps the internal userid to an etherpad group
$response = $client->createGroupIfNotExistsFor($groupMapper);
$groupID = elgg_etherpad_get_response_data($response, 'groupID');

// 3. Create a main pad for the user
// Try to create a new (main) pad in the userGroup
$padName = "home";
$text = "Ce pad a été automatiquement créé pour vous. Vous pouvez l'utiliser ou en créer d'autres.";
$response = $client->createGroupPad($groupID, $padName, $text);
$padID = $groupID . '$' . $padName;

// 4. Open a session an link to that pad
// Portal starts the session for the user on the group
$validUntil = time() + 60*60*12;
$response = $client->createSession($groupID, $authorID, $validUntil);
$sessionID = elgg_etherpad_get_response_data($response, 'sessionID');
// Set session cookie (only on same domain !)
$cookie_set = elgg_etherpad_update_session($sessionID);
if (!$cookie_set) $body .= '<p>' . elgg_echo('elgg_etherpad:setcookie:error'). '</p>';


// LIST PADS
$body .= '<p><a href="' . $CONFIG->url . 'pad/edit" style="float:right;" class="elgg-button elgg-button-action">Créer un nouveau Pad</a></p>';

// Explications
$body .= "<p>Les Pads sont des documents texte, qui peuvent être <strong>édités à plusieurs</strong>, <strong>simultanément</strong>.</p>
<p>Ils peuvent être en accès <strong>public</strong>, et éventuellement <strong>protégés par un mot de passe</strong>.</p>
	<p>Sur ce site, les Pads peuvent être associés à une personne ou à un groupe, ce qui permet de restreindre son accès à cette personne ou aux membres de ce groupe.</p>
	<p>Ils peuvent également être associés à une publication existante, ce qui permet par exemple d'utiliser un page pour modifier le contenu d'ue page page wiki ou d'un article de blog.</p>";

// Affichage du pad personnel
/*
if ($cookie_set) {
	$body .= '<h3>Votre pad personnel</h3>';
	//$body .= '<iframe src="' . $server . '/p/' . $padID . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';
	$body .= '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '">Ouvrir votre Pad personnel dans une autre fenêtre</a></p>';
}
*/


/*
// Now list all user's pads
$response = $client->listPadsOfAuthor($authorID);
$own_pads = elgg_etherpad_get_response_data($response, 'padIDs');
foreach ($own_pads as $padID) {
	$pad_name = explode('$', $padID);
	$own_group_id = $pad_name[0];
	$pad_name = $pad_name[1];
	//$personal_pads[$pad_name] = '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '">Afficher "' . $pad_name . '"</a></p>';
	$personal_pads[$pad_name] = elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
}
*/

// All pads : list and sort
$response = $client->listAllPads();
$all_pads = elgg_etherpad_get_response_data($response, 'padIDs');
foreach ($all_pads as $padID) {
	if (strpos($padID, '$')) {
		$pad_name = explode('$', $padID);
		$group_id = $pad_name[0];
		$pad_name = $pad_name[1];
	} else {
		$pad_name = $padID;
		$group_id = false;
	}
	
	// Sort by group
	//$pad_item = '<p>Afficher <a href="' . $CONFIG->url . 'pad/view/' . $padID . '">"' . $pad_name . '"</a></p>';
	$pad_item = elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
	if ($group_id) {
		// Can be either own or other private/group pad
		if ($group_id == $own_group_id) {
			$personal_pads[$pad_name] = $pad_item;
		} else {
			$private_pads[$group_id][$pad_name] = $pad_item;
		}
	} else {
		$public_pads[$pad_name] = $pad_item;
	}
}

$body .= '<br />';

$body .= '<div style="float:left; width:32%; margin-right:2%;">';
	$body .= '<h4>Pads personnels</h4>';
	$body .= implode('', $personal_pads);
$body .= '</div>';

$body .= '<div style="float:left; width:32%;">';
	$body .= '<h4>Pads en accès restreint</h4>';
	$body .= '<p><em>Note : les accès peuvent différer pour chacun de ces pads</em></p>';
	foreach ($private_pads as $groupID => $pads) {
		$test = elgg_etherpad_get_entity_from_group_id($groupID);
		$body .= "$groupID => " . print_r($test, true);
		$body .= '<h5>' . $groupID . '</h5>';
		$body .= implode('', $pads);
	}
$body .= '</div>';

$body .= '<div style="float:right; width:32%;">';
	$body .= '<h4>Pads publics</h4>';
	$body .= '<p><em>Ces pads sont ouverts à tous (y compris sans compte)</em></p>';
	$body .= implode('', $public_pads);
$body .= '</div>';


/*
$body .= '<div style="float:left; width:48%;">';
	// BUILD FORM
	$query = get_input('query', 'checkToken');
	$body .= '<form method="POST">';
	$body .= '<p>Requête : ' . elgg_view('input/dropdown', array('name' => 'query', 'value' => $query, 'options_values' => $methods_opts)) . '</p>';
	foreach ($parameters as $parameter) {
		$$parameter = get_input($parameter, false);
		$body .= '<p><label>' . $parameter . ' : ' . elgg_view('input/text', array('name' => $parameter, 'value' => $$parameter)) . '</label></p>';
	}
	$body .= '<p>' . elgg_view('input/submit', array('value' => "Effectuer la requête")) . '</p>';
	$body .= '</form>';
	
	// Adapt some parameters
	if ($authorMapper) {
		if (($author = get_entity($authorMapper)) && elgg_instanceof($author, 'user')) {
			$authorMapper = $author->guid;
			$name = $author->name;
		} else if (($author = get_user_by_username($authorMapper)) && elgg_instanceof($author, 'user')) {
			$authorMapper = $author->guid;
			$name = $author->name;
		} else {
			$authorMapper = false;
			$name = false;
		}
	}
	
	
	// Perform query
	switch($query) {
		// Listings
		case 'listAllPads': $response = $client->listAllPads(); break;
		case 'listAllGroups': $response = $client->listAllGroups(); break;
		
		// Manage authors and sessions
		case 'createAuthorIfNotExistsFor': 
			if ($authorMapper && $name) {
				// Portal maps the internal userid to an etherpad author
				$response = $client->createAuthorIfNotExistsFor($authorMapper, $name);
				$authorID = elgg_etherpad_get_response_data($response, 'authorID');
				$groupMapper = $authorMapper;
				$body .= elgg_etherpad_view_response($response);
				// Portal maps the internal userid to an etherpad group
				$response = $client->createGroupIfNotExistsFor($groupMapper);
				$groupID = elgg_etherpad_get_response_data($response, 'groupID');
				$body .= elgg_etherpad_view_response($response);
				// Portal starts the session for the user on the group
				$validUntil = time() + 300;
				$response = $client->createSession($groupID, $authorID, $validUntil);
				$sessionID = elgg_etherpad_get_response_data($response, 'sessionID');
				$body .= elgg_etherpad_view_response($response);
				// Set session cookie (only on same domain !)
				if (!$cookiedomain) $cookiedomain = parse_url(elgg_get_site_url(), PHP_URL_HOST);
				if(!setcookie('sessionID', $sessionID, $validUntil, '/', $cookiedomain)){
					throw new Exception(elgg_echo('etherpad:error:cookies_required'));
				}
				//$body .= " authorID = $authorID / groupMapper = $groupMapper / groupID = $groupID / sessionID = $sessionID ";
				$body .= '<p><a href="' . $server . '/p/' . $padID . '" target="_blank" class="elgg-button elgg-button-action">Open "' . $padID . '" pad</a></p>';
			}
			break;
		case 'listPadsOfAuthor': if ($authorID) { $response = $client->listPadsOfAuthor($authorID); } break;
		
		// Pads
		case 'getText': if ($padID) { $response = $client->getText($padID); } break;
		//case 'deletePad': if ($padID) { $response = $client->deletePad($padID); } break;
		
		// Default : does instance respond ?
		default: $response = $client->checkToken();
	}

$body .= elgg_etherpad_view_response($response);
*/

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'));
//elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
//elgg_push_breadcrumb($title);


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


