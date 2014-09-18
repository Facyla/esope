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
$own = elgg_get_logged_in_user_entity();
$authorMapper = $own->guid;
$name = $own->name;

$client = elgg_etherpad_get_client();



// MAIN CONTENT

// Create an user and its session if no exist
// Etherpad Lite User process
// 1. Get or create the authorID
$authorID = elgg_etherpad_get_author_id($own);

// 2. Get or create the associated groupID
$groupID = elgg_etherpad_get_entity_group_id($own);

// @TODO : access to pads should be determined based on Elgg criteria, and session set accordingly.

// 4. Open a session an link to that pad
// Portal starts the session for the user on the group
//$validUntil = time() + 60*60*12;
$sessionID = elgg_etherpad_create_session($groupID, $authorID);
// Set session cookie (only on same domain !)
// @TODO : we can store multiple sessions at once :
// Sessions can be created between a group and an author. This allows an author to access more than one group. The sessionID will be set as a cookie to the client and is valid until a certain date. The session cookie can also contain multiple comma-seperated sessionIDs, allowing a user to edit pads in different groups at the same time. Only users with a valid session for this group, can access group pads. You can create a session after you authenticated the user at your web application, to give them access to the pads. You should save the sessionID of this session and delete it after the user logged out.
$cookie_set = elgg_etherpad_update_session($sessionID);
if (!$cookie_set) $body .= '<p>Cookie could not be set : you will probably not be able to access any protected pad.</p>';


// Associate pad to entities :
/*
 1. Create group for entity
 2. Create pad for entity
 3. Give read access to all people who can read entity
 Optional for Admins : Give write access to all people who can edit entity
 4. Add sync buttons :
   - allow checking content (both on 1 page)
   - and pushing pad to entity
   - optional remove pad and pushing pad to entity
*/

// The source/target Elgg entity
$guid = get_input('guid', 1169);
// @TODO We need public pads for anyone to edit - should be changed to a setting in production
$public = get_input('public', true);
$password = get_input('password', false);
if ($entity = get_entity($guid)) {
	$text = $entity->description;
	$authorID = elgg_etherpad_get_author_id($own);
	$body .= '<p>AuthorID found/created : ' . $authorID . '</p>';
	$groupID = elgg_etherpad_get_entity_group_id($entity);
	$body .= '<p>GroupID found/created : ' . $groupID . '</p>';
	$padName = 'edit-'.$guid;
	$padID = elgg_etherpad_create_pad($padName, $guid, $public, $password, $text);
	
	if (empty($padID)) {
		$padID = $groupID . '$' .$padName;
		$body .= '<p>Error ! Pad may already exists...</p>';
	}
	
	// Update access controls
	if (elgg_etherpad_set_pad_access($padID, $public, $password)) {
		$body .= '<p>Pad exists. Access controls updated</p>';
	} else { $body .= '<p>Cannot update access controls</p>'; }
	
	// Update content
	if (elgg_etherpad_set_pad_content($padID, $text)) {
		$body .= '<p>Pad content updated</p>';
	} else {
		$body .= '<p>Pad content could not be updated</p>';
	}
	
	/*
	if (empty($padID)) {
		$padID = $groupID . '$' . $guid;
		$body .= '<p>Pad already exists !</p>';
	}
	*/
	
	// Get some info about pad
	$isPasswordProtected = elgg_etherpad_is_password_protected($padID);
	$isPublic = elgg_etherpad_is_public($padID);
	$body .= '<p>';
	$body .= '<strong>"' . $padID . '" :</strong>';
	if ($isPublic == 'yes') $body .= ' &nbsp; <i class="fa fa-unlock"></i> Public';
	else if ($isPublic == 'no') $body .= ' &nbsp; <i class="fa fa-lock"></i> Privé';
	if ($isPasswordProtected == 'yes') $body .= ' &nbsp; <i class="fa fa-key"></i> Avec mot de passe';
	else if ($isPasswordProtected == 'no') $body .= ' &nbsp; <i class="fa fa-key"></i> (sans mot de passe)';
	$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher</a> ';
	$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '"><i class="fa fa-gear"></i> Modifier</a> ';
	$body .= '</p>';
	
	$body .= '<p>PadID found/created : ' . $padID . '</p>';
	$sessionID = elgg_etherpad_create_session($groupID, $authorID, $validUntil);
	$body .= '<p>SessionID created : ' . $authorID . '</p>';
	$cookie_set = elgg_etherpad_update_session($sessionID, $validUntil = 43200);
	if (!$cookie_set) $body .= '<p>Cookie could not be set : you will probably not be able to access any protected pad.</p>';
	$pad_url = $server . '/p/' . $padID;
	$body .= '<p>Now displaying pad... ' . $pad_url . '</p>';
	$body .= '<iframe src="' . $pad_url . '?userName=' . rawurlencode($own->name) . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';
	
	$body .= '<p><a href="">Compare pad to entity content</a></p>';
	$body .= '<p><a href="">Push pad content to entity content</a></p>';
	$body .= '<p><a href="">Push entity content to pad content</a></p>';
	//elgg_etherpad_save_pad_content_to_entity($padID = false, $entity = false, $metadata = false);
}

// elgg_etherpad_get_entity_group_id($entity, $update = false);
// elgg_etherpad_create_pad($padName, $groupName = false, $public = null, $password = null, $text = false);
// elgg_etherpad_update_session($sessionID, $validUntil = 43200) {
//elgg_etherpad_save_pad_content_to_entity($padID = false, $entity = false, $metadata = false);

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb("TESTS");


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


