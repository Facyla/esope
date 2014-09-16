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

$body = "";

$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
$cookiedomain = elgg_get_plugin_setting('cookiedomain', 'elgg_etherpad');
$own = elgg_get_logged_in_user_entity();
$authorMapper = $own->guid;
$name = $own->name;

$client = elgg_etherpad_get_client();



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

// 4. Open a session an link to that pad
// Portal starts the session for the user on the group
$validUntil = time() + 60*60*12;
$response = $client->createSession($groupID, $authorID, $validUntil);
$sessionID = elgg_etherpad_get_response_data($response, 'sessionID');
// Set session cookie (only on same domain !)
if (!$cookiedomain) $cookiedomain = parse_url(elgg_get_site_url(), PHP_URL_HOST);
$cookie_set = setcookie('sessionID', $sessionID, $validUntil, '/', $cookiedomain);

// Open pad
// Open asked pad, or default to own pad
$padID = get_input('padID', false);
if (empty($padID)) $padID = $groupID . '$' . $padName;
$body .= '<iframe src="' . $server . '/p/' . $padID . '?userName=' . rawurlencode($own->name) . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';


if (strpos($padID, '$')) {
	$pad_name = explode('$', $padID);
	$pad_name = $pad_name[1];
	$group_id = $pad_name[0];
} else {
	$pad_name = $padID;
}

$title = "Afficher le pad \"$pad_name\"";
if ($group_id) $title .= " (groupe $group_id)";

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb($pad_name);


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


