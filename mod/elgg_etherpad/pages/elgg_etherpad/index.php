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
$padName = "main-" . $own->username;
$text = "Ce pad a été automatiquement créé pour vous. Vous pouvez l'utiliser ou en créer d'autres.";
$response = $client->createGroupPad($groupID, $padName, $text);
$padID = $groupID . '$' . $padName;

// 4. Open a session an link to that pad
// Portal starts the session for the user on the group
$validUntil = time() + 60*60*12;
$response = $client->createSession($groupID, $authorID, $validUntil);
$sessionID = elgg_etherpad_get_response_data($response, 'sessionID');
// Set session cookie (only on same domain !)
if (!$cookiedomain) $cookiedomain = parse_url(elgg_get_site_url(), PHP_URL_HOST);
$cookie_set = setcookie('sessionID', $sessionID, $validUntil, '/', $cookiedomain);


// LIST PADS
// Affichage du pad personnel
$body .= '<h3>Votre pad personnel</h3>';
$body .= '<iframe src="' . $server . '/p/' . $padID . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';
$body .= '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '" class="elgg-button elgg-button-action">Votre Pad personnel</a></p>';


// Now list all user's pads
$body .= '<br />';
$body .= '<h3>Vos pads</h3>';
$response = $client->listPadsOfAuthor($authorID);
$own_pads = elgg_etherpad_get_response_data($response, 'padIDs');
foreach ($own_pads as $padID) {
	// @TODO : sort by group
	$body .= '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '" class="elgg-button elgg-button-action">Afficher "' . $padID . '"</a></p>';
}

$body .= '<br />';
$body .= '<h3>Tous les pads</h3>';
$response = $client->listAllPads();
$all_pads = elgg_etherpad_get_response_data($response, 'padIDs');
foreach ($all_pads as $padID) {
	// @TODO : sort by group
	$body .= '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '" class="elgg-button elgg-button-action">Afficher "' . $padID . '"</a></p>';
}



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

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb($title);


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


