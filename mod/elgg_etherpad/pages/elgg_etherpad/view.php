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

//gatekeeper();

$body = "";

$server = elgg_get_plugin_setting('server', 'elgg_etherpad');
$own = elgg_get_logged_in_user_entity();
$authorMapper = $own->guid;
$name = $own->name;

$client = elgg_etherpad_get_client();

// MAIN CONTENT

// Create an user and its session if no exist
if (elgg_is_logged_in()) {
	// Etherpad Lite User process
	// 1. Get or create the authorID
	$authorID = elgg_etherpad_get_author_id($own);

	// 2. Get or create the associated groupID
	$groupID = elgg_etherpad_get_entity_group_id($own);

	// 3. Create a new pad ("home") in the userGroup
	$own_padID = elgg_etherpad_create_pad("home", $own->guid, false, false, $text);
	
	// @TODO : access to pads should be determined based on Elgg criteria, and session set accordingly.
	
	// 4. Open a session an link to that pad
	// Portal starts the session for the user on the group
	$sessionID = elgg_etherpad_create_session($groupID, $authorID);
	// Set session cookie (only on same domain !)
	// @TODO : we can store multiple sessions at once :
	// Sessions can be created between a group and an author. This allows an author to access more than one group. The sessionID will be set as a cookie to the client and is valid until a certain date. The session cookie can also contain multiple comma-seperated sessionIDs, allowing a user to edit pads in different groups at the same time. Only users with a valid session for this group, can access group pads. You can create a session after you authenticated the user at your web application, to give them access to the pads. You should save the sessionID of this session and delete it after the user logged out.
	$cookie_set = elgg_etherpad_update_session($sessionID);
	if (!$cookie_set) $body .= '<p>' . elgg_echo('elgg_etherpad:setcookie:error'). '</p>';
}

// Open pad
// Open asked pad, or default to own pad
$padID = get_input('padID', $own_padID);
if (empty($padID)) $padID = $groupID . '$' . $padName;
$body .= '<iframe src="' . $server . '/p/' . $padID . '?userName=' . rawurlencode($own->name) . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';

if (!elgg_etherpad_can_read_pad($padID)) {
	register_error("Vous n'avez pas accès à ce pad.");
	forward('pad');
}

if (strpos($padID, '$')) {
	$pad_name = explode('$', $padID);
	$group_id = $pad_name[0];
	$pad_name = $pad_name[1];
} else {
	$pad_name = $padID;
}

// If we want to display a private pad, we need to add a specific session cookie for that pad !
if ($group_id && elgg_is_logged_in()) $sessionID = elgg_etherpad_create_session($group_id, $authorID);

// Display some details on pad visibility
$title = "Pad \"$pad_name\"";
$inner_title = elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
//if ($group_id) $title .= " (groupe $group_id)";

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb($pad_name);


$body = elgg_view_layout('one_column', array(
		'title' => $inner_title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


