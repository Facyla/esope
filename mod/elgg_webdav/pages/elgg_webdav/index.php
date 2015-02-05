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

$content .= "<p>Utilisation : ajoutez un partage réseau avec les informations suivantes : 
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
	</ul>
	</p>";

$content .= '<br />';
$content .= '<br />';


$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

