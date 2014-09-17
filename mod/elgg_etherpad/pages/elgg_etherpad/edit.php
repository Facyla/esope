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

// 3. Open a session and link to that pad
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
$action = get_input('action', false);


// MODE 0 : Actions toujours disponibles

$body .= '<h3>' . elgg_echo('elgg_etherpad:forms:createpad') . '</h3>';
$body .= elgg_view('forms/elgg_etherpad/createpad', array());
$body .= '<h3>' . elgg_echo('elgg_etherpad:forms:creategrouppad') . '</h3>';
$body .= elgg_view('forms/elgg_etherpad/creategrouppad', array());


$body .= '<p><a href="' . $CONFIG->url . 'pad/edit?action=createpad&padName=" class="elgg-button elgg-button-action">Créer un Pad public</a></p>';
$body .= '<p><a href="' . $CONFIG->url . 'pad/edit?action=creategrouppad&padName=&groupName=" class="elgg-button elgg-button-action">Créer un Pad privé</a></p>';


// MODE 1 : Edition d'un pad précis
if ($padID) {
	$isPasswordProtected = elgg_etherpad_is_password_protected($padID);
	$isPublic = elgg_etherpad_is_public($padID);
	
	$body .= '<p><strong>Adresse du Pad :</strong> ' . $CONFIG->url . '/pad/view/' . $padID . '</p>';
	
	$body .= '<p><strong>Visibilité :</strong> ';
	if ($isPublic == 'yes') {
		$body .= '<i class="fa fa-unlock"></i> PUBLIC ';
		$body .= '<a href="' . $CONFIG->url . 'pad/edit/' . $padID . '?action=makeprivate"><i class="fa fa-lock"></i> Rendre privé</a> ';
	} else if ($isPublic == 'no') {
		$body .= '<i class="fa fa-lock"></i> NON PUBLIC ';
		$body .= '<a href="' . $CONFIG->url . 'pad/edit/' . $padID . '?action=makepublic"><i class="fa fa-unlock"></i> Rendre public</a> ';
	}
	$body .= '</p>';
	
	$body .= '<p><strong>Mot de passe :</strong> ';
	if ($isPasswordProtected == 'yes') {
		$body .= '<i class="fa fa-key"></i> PROTEGE PAR MOT DE PASSE ';
		$body .= '<a href="' . $CONFIG->url . 'pad/edit/' . $padID . '?action=changepassword"><i class="fa fa-key"></i> Modifier le mot de passe</a> ';
		$body .= '<a href="' . $CONFIG->url . 'pad/edit/' . $padID . '?action=removepassword"><i class="fa fa-remove"></i> Supprimer le mot de passe</a> ';
	} else if ($isPasswordProtected == 'no') {
		$body .= '(SANS MOT DE PASSE) ';
		$body .= '<a href="' . $CONFIG->url . 'pad/edit/' . $padID . '?action=changepassword"><i class="fa fa-key"></i> Ajouter un mot de passe</a> ';
	}
	$body .= '</p>';
	
	$body .= '<p><a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher le pad</a></p>';
	
	
	$public = null;
	$password = null;
	if ($action) {
		switch ($action) {
			case 'makeprivate':
				$public = false;
				break;
			case 'makepublic':
				$public = true;
				break;
			case 'changepassword':
				$password = get_input('password', '');
				break;
			case 'removepassword':
				$password = false;
				break;
			default:
		}
		$body .= elgg_etherpad_set_pad_access($padID, $public, $password);
		forward('pad/edit/' . $padID);
	}
	
} else {
	
	// MODE 2 : Liste des tous les pads modifiables
	if (elgg_is_admin_logged_in()) {
		$body .= '<h3>Tous les pads</h3>';
		$response = $client->listAllPads();
	} else {
		$body .= '<h3>Tous vos pads</h3>';
		$response = $client->listPadsOfAuthor($authorID);
	}
	$pads = elgg_etherpad_get_response_data($response, 'padIDs');
	if ($pads) {
		foreach ($pads as $padID) {
			// @TODO : sort by group
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
		}
	} else {
		$body .= '<p>Aucun Pad<p>';
	}
	
	// CREATION DE NOUVEAUX PADS
	$public = null;
	$password = null;
	$padName = get_input('padName');
	$groupName = get_input('groupName');
	if ($action) {
		switch ($action) {
			case 'creategrouppad':
				if (!empty($groupName) && !empty($padName)) {
					$padID = elgg_etherpad_create_pad($padName, $groupName, $public, $password);
					$body .= '<p><strong>Pad "' . $padID . '" créé</strong>';
					$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher</a> ';
					$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '"><i class="fa fa-gear"></i> Modifier</a> ';
					$body .= '</p>';
					forward('pad/view/' . $padID);
				} else {
					$body .= '<p>Nom du pad et/ou du groupe manquant : &padName=XXXX&groupName=YYYY</p>';
				}
				break;
			case 'createpad':
				if (!empty($padName)) {
					$padID = elgg_etherpad_create_pad($padName, $groupName, $public, $password);
					$body .= '<p><strong>Pad "' . $padID . '" créé</strong>';
					$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/view/' . $padID . '"><i class="fa fa-eye"></i> Afficher</a> ';
					$body .= ' &nbsp; <a href="' . $CONFIG->url . 'pad/edit/' . $padID . '"><i class="fa fa-gear"></i> Modifier</a> ';
					$body .= '</p>';
					forward('pad/view/' . $padID);
				} else {
					$body .= '<p>Nom du pad manquant : &padName=XXXX</p>';
				}
				break;
			default:
		}
	}
}





$title = "Créer / modifier un Pad";
if ($group_id) $title .= " (groupe $group_id)";

elgg_push_breadcrumb(elgg_echo('elgg_etherpad'), 'pad');
elgg_push_breadcrumb(elgg_echo('elgg_etherpad:edit'), 'pad/edit');
elgg_push_breadcrumb($pad_name);


$body = elgg_view_layout('one_column', array(
		'title' => $title,
		'content' => $body,
	));

// Render the page
echo elgg_view_page($title, $body);


