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
$authorID = elgg_etherpad_get_author_id($own);
$groupMapper = $authorMapper;

// 2. Then create the associated group
// Portal maps the internal userid to an etherpad group
$groupID = elgg_etherpad_get_entity_group_id($entity);

// 3. Open a session and link to that pad
// Portal starts the session for the user on the group
$sessionID = elgg_etherpad_create_session($groupID, $authorID);

// Set session cookie (only on same domain !)
$cookie_set = elgg_etherpad_update_session($sessionID);
if (!$cookie_set) $body .= '<p>' . elgg_echo('elgg_etherpad:setcookie:error'). '</p>';

// Open pad
// Open asked pad, or default to own pad
$padID = get_input('padID', false);
$action = get_input('action', false);



// Avec un pad défini : édition d'un pad précis
if ($padID) {
	
	//$body .= elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
	$body .= elgg_view('forms/elgg_etherpad/editpad', array('padID' => $padID));
	
} else {
	
	// Création de nouveaux pads
	$body .= '<div style="float:left; width:48%;">';
		$body .= '<h3>' . elgg_echo('elgg_etherpad:forms:creategrouppad') . '</h3>';
		$body .= elgg_view('forms/elgg_etherpad/creategrouppad', array());
	$body .= '</div>';
	$body .= '<div style="float:right; width:48%;">';
		$body .= '<h3>' . elgg_echo('elgg_etherpad:forms:createpad') . '</h3>';
		$body .= elgg_view('forms/elgg_etherpad/createpad', array());
	$body .= '</div>';
	$body .= '<div class="clearfloat"></div><br />';
	
	// Liste des tous les pads modifiables
	if (elgg_is_admin_logged_in()) {
		$body .= '<h3>Tous les pads</h3>';
		$response = $client->listAllPads();
	} else {
		$body .= '<h3>Tous vos pads</h3>';
		$response = $client->listPadsOfAuthor($authorID);
	}
	$pads = elgg_etherpad_get_response_data($response, 'padIDs');
	
	if ($pads) {
		foreach ($pads as $pad_id) {
			if (strpos($pad_id, '$')) {
				$pad_name = explode('$', $pad_id);
				$group_id = $pad_name[0];
				$pad_name = $pad_name[1];
			} else {
				$pad_name = $pad_id;
				$group_id = false;
			}
	
			// Sort by group, personal and public pads
			$pad_item = elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $pad_id));
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
		
		// Render pads listings
		$body .= '<div style="float:left; width:32%; margin-right:2%;">';
			$body .= '<h4>Pads personnels</h4>';
			$body .= implode('', $personal_pads);
		$body .= '</div>';
		
		$body .= '<div style="float:left; width:32%;">';
			$body .= '<h4>Pads en accès restreint</h4>';
			$body .= '<p><em>Note : les accès peuvent différer pour chacun de ces pads</em></p>';
			foreach ($private_pads as $groupID => $pads) {
				$body .= '<h5>' . $groupID . '</h5>';
				$body .= implode('', $pads);
			}
		$body .= '</div>';
		
		$body .= '<div style="float:right; width:32%;">';
			$body .= '<h4>Pads publics</h4>';
			$body .= '<p><em>Ces pads sont ouverts à tous (y compris sans compte)</em></p>';
			$body .= implode('', $public_pads);
		$body .= '</div>';
		
	} else {
		$body .= '<p>Aucun Pad<p>';
	}
	
}



if ($padID) {
	$title = "Modifier le Pad $padID";
	$inner_title = elgg_view('elgg_etherpad/elgg_etherpad', array('padID' => $padID));
	if ($group_id) $title .= " (groupe $group_id)";
} else {
	$title = "Créer / modifier un Pad";
	$inner_title = $title;
}

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb(elgg_echo('elgg_etherpad:edit'), 'pad/edit');
if ($pad_name) elgg_push_breadcrumb($pad_name);


$body = elgg_view_layout('one_column', array(
		'title' => $inner_title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


