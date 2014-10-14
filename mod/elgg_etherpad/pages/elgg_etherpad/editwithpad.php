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

//$client = elgg_etherpad_get_client();



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
$guid = get_input('guid', false);
// Note : access controls can be set through a link when we display some info on the ‫editing pad
// We set only defaults for new pads here, which means not public, and no password
$public = get_input('public', false);
$password = get_input('password', false);

$debug = get_input('debug', false);

// Only work with valid entities
$entity = get_entity($guid);
if (elgg_instanceof($entity, 'object')) {
	
	
	// Only work with some subtypes : page, page_top and blog (which have history)
	$subtype = $entity->getSubtype();
	if (in_array($subtype, array('page', 'page_top', 'blog'))) {
		
		// We actually need to be able to edit the associated entity to edit it with a pad !
		if ($entity->canEdit()) {
			
			// Display entity
			$entity_content = $entity->description;
			$body .= '<h3>' . elgg_echo('elgg_etherpad:vieweditentity') . '</h3>';
			$body .= '<blockquote><p><em>' . elgg_echo('elgg_etherpad:vieweditentity:details', array($share_url, $public_share_url)) . '</em></p></blockquote>';
			$body .= elgg_view_entity($entity, array('full_view' => true)) . '</p>';
			$body .= '<hr /><br />';
			$body .= '<blockquote><p>' . elgg_echo('elgg_etherpad:entityedit:warning') . '</p></blockquote>';
			$body .= '<p><a href="?request=pushtopad" class="elgg-button elgg-button-action">' . elgg_echo('elgg_etherpad:pushtopad') . '</a></p>';
			$body .= '<div class="clearfloat"></div><br /><br />';
	
	
			// Display edition pad
			$body .= '<h3>' . elgg_echo('elgg_etherpad:vieweditpad') . '</h3>';
	
			// Note : we need at least the padID before we perform any action on it
			$authorID = elgg_etherpad_get_author_id($own);
			if ($debug) $body .= '<p>' . elgg_echo('elgg_etherpad:editwithpad:authorid', array($authorID)) . '</p>';
			$groupID = elgg_etherpad_get_entity_group_id($entity);
			if ($debug) $body .= '<p>' . elgg_echo('elgg_etherpad:editwithpad:groupid', array($groupID)) . '</p>';
			$padName = 'edit-'.$guid;
			// Try to create pad first
			$padID = elgg_etherpad_create_pad($padName, $guid, $public, $password, $entity_content);
			// If failed, get the existing pad
			if (empty($padID)) { $padID = $groupID . '$' .$padName; }
		
		
			// Handle sync actions
			$request = get_input('request', false);
			switch ($request) {
				// Update entity content
				case 'pushtoentity':
					if (elgg_etherpad_save_pad_content_to_entity($padID, $entity, 'description')) {
						system_message(elgg_echo('elgg_etherpad:pushtoentity:success'));
					} else { register_error(elgg_echo('elgg_etherpad:pushtoentity:error')); }
					forward("pad/editwithpad/$guid");
					break;
				// Update pad content
				case 'pushtopad':
					if (elgg_etherpad_set_pad_content($padID, $entity_content)) {
						system_message(elgg_echo('elgg_etherpad:pushtopad:success'));
					} else { register_error(elgg_echo('elgg_etherpad:pushtopad:error')); }
					forward("pad/editwithpad/$guid");
					break;
				default:
			}
		
		
			// Display edit pad
			$pad_url = $server . '/p/' . $padID;
			$share_url = '<a href="' . $CONFIG->url . 'pad/view/' . $padID . '">' . $CONFIG->url . 'pad/view/' . $padID . '</a>';
			$public_share_url = '<a href="' . $pad_url . '">' . $pad_url . '</a>';
			$body .= '<blockquote><p><em>' . elgg_echo('elgg_etherpad:vieweditpad:details', array($share_url, $public_share_url)) . '</em></p></blockquote>';
		
			// Display some info about pad
			$body .= elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
		
			// Create session for user
			if ($debug) $body .= '<p>' . elgg_echo('elgg_etherpad:editwithpad:padid', array($padID)) . '</p>';
			$sessionID = elgg_etherpad_create_session($groupID, $authorID);
			if ($debug) $body .= '<p>' . elgg_echo('elgg_etherpad:editwithpad:sessionid', array($sessionID)) . '</p>';
			$cookie_set = elgg_etherpad_update_session($sessionID);
			if (!$cookie_set) $body .= '<p>' . elgg_echo('elgg_etherpad:setcookie:error'). '</p>';
		
			// Display actual editing pad
			$body .= '<iframe src="' . $pad_url . '?userName=' . rawurlencode($own->name) . '" style="height:400px; width:100%; border:1px inset black;"></iframe>';
		
		
			// Sync actions
			$body .= '<br />';
			$body .= '<blockquote><p>' . elgg_echo('elgg_etherpad:entityedit:warning') . '</p></blockquote>';
			$body .= '<p><a href="?request=pushtoentity" class="elgg-button elgg-button-action">' . elgg_echo('elgg_etherpad:pushtoentity') . '</a></p>';
		
		
			$title =  elgg_echo('elgg_etherpad:editwithpad', array($entity->title));
		
		} else {
			register_error(elgg_echo('elgg_etherpad:error:cannoteditentity'));
		}
	} else {
		register_error(elgg_echo('elgg_etherpad:editwithpad:invalidsubtype', array($subtype)));
	}
} else {
	register_error(elgg_echo('elgg_etherpad:editwithpad:invalidentity', array($guid)));
}

// elgg_etherpad_get_entity_group_id($entity, $update = false);
// elgg_etherpad_create_pad($padName, $groupName = false, $public = null, $password = null, $text = false);
// elgg_etherpad_update_session($sessionID, $validUntil = 43200) {
//elgg_etherpad_save_pad_content_to_entity($padID = false, $entity = false, $metadata = false);

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb($title);


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


