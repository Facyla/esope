<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

$title = "Pad";

$body = "";


function elgg_etherpad_view_response($response) {
	$content = false;
	if ($response) {
		$content .= "Code : " . $response->getCode() . ' - ';
		$content .= "Message : " . $response->getMessage() . ' - ';
		$content .= "Réponse : <pre>" . print_r($response->getData(), true) . '</pre>';
	}
	return $content;
}

function elgg_etherpad_get_response_data($response, $key = false) {
	$return = false;
	if ($response) {
		$return = $response->getData();
		if ($key) { $return = $return[$key]; }
	}
	return $return;
}


$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
$cookiedomain = elgg_get_plugin_setting('cookiedomain', 'elgg_etherpad');
$api_key = elgg_get_plugin_setting('api_key', 'elgg_etherpad');

$client = new \EtherpadLite\Client($api_key, $server);

$documentation = '<h3>Documentation</h3>
	<p>Groupes : des groupes de pads (indépendant des auteurs)</p>
	<p>Auteur : compte avec un id, peut être mappé sur un identifiant</p>
	<ul>
		<li>createGroup() creates a new group</li>
		<li>createGroupIfNotExistsFor($groupMapper) this functions helps you to map your application group ids to etherpad lite group ids</li>
		<li>deleteGroup($groupID) deletes a group</li>
		<li>listPads($groupID) returns all pads of this group</li>
		<li>createGroupPad($groupID, $padName, $text = null) creates a new pad in this group</li>
		<li>listAllGroups() lists all existing groups</li>
		<li></li>
		<li>createAuthor($name = null) creates a new author</li>
		<li>createAuthorIfNotExistsFor($authorMapper, $name = null) this functions helps you to map your application author ids to etherpad lite author ids</li>
		<li>listPadsOfAuthor($authorID) returns an array of all pads this author contributed to</li>
		<li>getAuthorName($authorID) Returns the Author Name of the author</li>
		<li></li>
		<li>createSession($groupID, $authorID, $validUntil) creates a new session. validUntil is an unix timestamp in seconds</li>
		<li>deleteSession($sessionID) creates a new session. validUntil is an unix timestamp in seconds</li>
		<li>getSessionInfo($sessionID) returns informations about a session</li>
		<li>listSessionsOfGroup($groupID) returns all sessions of a group</li>
		<li>listSessionsOfAuthor($authorID) returns all sessions of an author</li>
		<li></li>
		<li>getText($padID, $rev = null) returns the text of a pad</li>
		<li>setText($padID, $text) sets the text of a pad</li>
		<li>getHTML($padID, $rev = null) returns the text of a pad formatted as HTML</li>
		<li>setHTML($padID, $html) sets the html of a pad</li>
		<li></li>
		<li>getChatHistory($padID, $start = null, $end = null) a part of the chat history, when start and end are given, the whole chat histroy, when no extra parameters are given</li>
		<li>getChatHead($padID) returns the chatHead (last number of the last chat-message) of the pad</li>
		<li></li>
		<li>createPad($padID, $text = null) creates a new (non-group) pad. Note that if you need to create a group Pad, you should call createGroupPad.</li>
		<li>getRevisionsCount($padID) returns the number of revisions of this pad</li>
		<li>padUsersCount($padID) returns the number of user that are currently editing this pad</li>
		<li>padUsers($padID) returns the list of users that are currently editing this pad</li>
		<li>deletePad($padID) deletes a pad</li>
		<li>getReadOnlyID($padID) returns the read only link of a pad</li>
		<li>setPublicStatus($padID, $publicStatus) sets a boolean for the public status of a pad</li>
		<li>getPublicStatus($padID) return true of false</li>
		<li>setPassword($padID, $password) returns ok or a error message</li>
		<li>isPasswordProtected($padID) returns true or false</li>
		<li>listAuthorsOfPad($padID) returns an array of authors who contributed to this pad</li>
		<li>getLastEdited($padID) returns the timestamp of the last revision of the pad</li>
		<li>sendClientsMessage($padID, $msg) sends a custom message of type $msg to the pad</li>
		<li>checkToken() returns ok when the current api token is valid</li>
		<li></li>
		<li>listAllPads() lists all pads on this epl instance</li>
	</ul>';


$parameters = array('authorID', 'authorMapper', 'name', 'sessionID', 'validUntil', 'padID', 'padName', 'text', 'rev', 'html', 'msg', 'groupMapper', 'groupID', 'start', 'end');

// Potential vars
//$name = elgg_get_logged_in_user_entity()->name;
//$authorMapper = elgg_get_logged_in_user_entity()->guid;


$body .= '<div style="float:left; width:48%;">';
	// BUILD FORM
	$query = get_input('query', 'checkToken()');
	$body .= '<form method="POST">';
	$body .= '<p>Requête : ' . elgg_view('input/text', array('name' => 'query', 'value' => $query)) . '</p>';
	foreach ($parameters as $parameter) {
		$$parameter = get_input($parameter, false);
		$body .= '<p><label>' . $parameter . ' : ' . elgg_view('input/text', array('name' => $parameter, 'value' => $$parameter)) . '</label></p>';
	}
	$body .= '<p>' . elgg_view('input/submit', array('value' => "Effectuer la requête")) . '</p>';
	$body .= '</form>';
	
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
				//$validUntil = time() + 3600;
				$validUntil = mktime(date("H"), date("i")+5, 0, date("m"), date("d"), date("y"));
				$response = $client->createSession($groupID, $authorID, $validUntil);
				$sessionID = elgg_etherpad_get_response_data($response, 'sessionID');
				$body .= elgg_etherpad_view_response($response);
				$body .= " authorID = $authorID / groupID = $groupID / sessionID = $sessionID ";
				// Set session cookie (only on same domain !)
				if (!$cookiedomain) $cookiedomain = "." . parse_url(elgg_get_site_url(), PHP_URL_HOST);
				if(!setcookie('sessionID', $sessionID, $validUntil, '/', $cookiedomain)){
					throw new Exception(elgg_echo('etherpad:error:cookies_required'));
				}
				$body .= '<p><a href="' . $server . '/p/' . $padID . '" target="_blank">Open Pad</a></p>';
			}
			break;
		case 'listPadsOfAuthor': if ($authorID) { $response = $client->listPadsOfAuthor($authorID); } break;
		
		// Pads
		case 'getText': if ($padID) { $response = $client->getText($padID); } break;
		//case 'deletePad': if ($padID) { $response = $client->deletePad($padID); } break;
		
		// Default : does instance respond ?
		default: $response = $client->checkToken();
	}

$body .= '</div>';

$body .= '<div style="float:right; width:48%;">' . elgg_view('output/longtext', array('value' => $documentation)) . '</div>';

/** @var $response \EtherpadLite\Response */
/*
$response = $client->checkToken();
$body .= "Code : " . $response->getCode() . '<br />';
$body .= "Message : " . $response->getMessage() . '<br />';
$body .= "Data : " . $response->getData() . '<br />';

$response = $client->listAllPads();
$body .= "Code : " . $response->getCode() . '<br />';
$body .= "Message : " . $response->getMessage() . '<br />';
$body .= "Data : " . print_r($response->getData(), true) . '<br />';
*/


// Render the page
echo elgg_view_page($title, $body);


