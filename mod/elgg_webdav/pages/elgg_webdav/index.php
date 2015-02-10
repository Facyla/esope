<?php
/**
 * Elgg WebDAV home page
 *
 * @package ElggWebDAV
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('webdav'));
*/
global $CONFIG;
//$view_url = $CONFIG->url . 'webdav/';

$title = elgg_echo('elgg_webdav:index');

$content = '';

$content .= '<h3>' . $title . '</h3>';

//$content .= '<p><a href="' . $view_url . 'd3" class="elgg-button elgg-button-action">D3</a> generic visualisation library</p>';
$webdav_url = parse_url($CONFIG->url . 'webdav/server');
$webdav_root = $webdav_url['path'];

$content .= "<h3>Utilisation</h3><p>Ajoutez un partage réseau avec les informations suivantes :</p>
	<ul>
		<li>Adresse du serveur : " . $CONFIG->url . 'webdav/server' . "</li>
		<li>Ou :
			<ul>
				<li>Type de partage : WebDAV (HTTP)</li>
				<li>Port : 80</li>
				<li>Serveur : " . $webdav_url['host'] . "</li>
		<li>Dossier : " . $webdav_url['path'] . "</li>
			</ul>
		<li>Nom d'utilisateur : votre nom d'utilisateur sur le site (ou votre email d'inscription)</li>
		<li>Mot de passe : votre mot de passe sur le site</li>
	</ul>";

$content .= "<h3>Types de partages disponibles :</h3><ul>";

if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = elgg_get_logged_in_user_guid();
	$content .= "<li>Dossier personnel : <strong>" . $CONFIG->url . 'webdav/user/GUID</strong>';
	$content .= "<ul>";
	$content .= "<li>Votre dossier personnel : " . $CONFIG->url . 'webdav/user/' . $ownguid . "</li>";
	$content .= "</ul>";
	$content .= "</li>";
	
	$content .= "<li>Dossier de groupe : <strong>" . $CONFIG->url . 'webdav/group/GUID</strong>';
	$groups = $own->getGroups('', 0);
	$content .= "<ul>";
	foreach ($groups as $group) {
		$content .= '<li><a href="' . $group->getURL() . '" target="_blank">"' . $group->name . '</a> : ' . $CONFIG->url . 'webdav/group/' . $group->guid . '</li>';
	}
	$content .= "</ul>";
	$content .= "</li>";
	
} else {
	$content .= "<li>Dossier personnel : <strong>" . $CONFIG->url . "webdav/user/GUID</strong></li>";
	$content .= "<li>Dossier de groupe : <strong>" . $CONFIG->url . "webdav/group/GUID</strong></li>";
}
$content .= "<li>Dossier pour les membres du site : <strong>" . $CONFIG->url . "webdav/member</strong> (lecture seule)</li>";
$content .= "<li>Dossier public : <strong>" . $CONFIG->url . "webdav/public</strong> (sans authentification, lecture seule)</li>";
$content .= "</ul>";

$content .= '<br />';
$content .= '<br />';


$content = '<div class="elgg-output">' . $content . '</div>';
$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

