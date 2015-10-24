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

$title = elgg_echo('elgg_webdav:index');

$content = '';

$content .= '<h3>' . $title . '</h3>';

$url = elgg_get_site_url();
$main_url = $url . 'webdav/virtual';
$webdav_url = parse_url($url . 'webdav/virtual');
$webdav_root = $webdav_url['path'];

$content .= '<h3>Utilisation</h3>
	<p>Le serveur WebDAV peut être utilisé pour "monter" un dossier de fichiers, de manière à pouvoir y accéder directement depuis votre ordinateur. Ces fichiers peuvent être ceux gérés par Elgg, ou totalement indépendants.</p>
	<p>Pour ajouter un partage réseau qui vous permet d\'accéder et d\'éditer les fichiers auxquels vous avez accès sur le site, utilisez les informations suivantes :</p>
	<ul>
		<li>Adresse du serveur : <a href="' . $main_url . '" target="_blank">' . $main_url . '</a></li>
		<li>Ou pour configurer un partage réseau :
			<ul>
				<li>Type de partage : WebDAV (HTTP)</li>
				<li>Port : 80 (ou 443 si HTTPS)</li>
				<li>Serveur : ' . $main_url . '</li>
				<li>Dossier : /</li>
			</ul>
		<li>Identifiant : votre identifiant sur le site (ou votre email)</li>
		<li>Mot de passe : votre mot de passe sur le site</li>
	</ul>';

$content .= '<h3>Autres types de partages disponibles :</h3>';
$content .= '<p>Attention : ces types de partages ne sont pas liés aux publications du site et ne seront donc pas accessibles via le site web ! Ils ne pourront être utilisés <strong>que</strong> sous la forme de dossiers WebDAV</p>';
$content .= '<ul>';

	$content .= '<li>Dossier public du site : <a href="' . $url . 'webdav/server" target="_blank">' . $url . 'webdav/server</a></li>';

	if (elgg_is_logged_in()) {
		$own = elgg_get_logged_in_user_entity();
		$ownguid = elgg_get_logged_in_user_guid();
		$content .= '<li>Dossier personnel : <strong><a href="' . $url . 'webdav/user/GUID" target="_blank">' . $url . 'webdav/user/GUID</a></strong>';
		$content .= '<ul>';
		$content .= '<li>Votre dossier personnel : <a href="' . $url . 'webdav/user/' . $ownguid . '" target="_blank">' . $url . 'webdav/user/' . $ownguid . '</a></li>';
		$content .= '</ul>';
		$content .= '</li>';
	
		$content .= '<li>Dossier de groupe : <strong><a href="' . $url . 'webdav/group/GUID" target="_blank">' . $url . 'webdav/group/GUID</a></strong>';
		$groups = $own->getGroups('', 0);
		$content .= '<ul>';
		foreach ($groups as $group) {
			$content .= '<li><a href="' . $group->getURL() . '" target="_blank">"' . $group->name . '</a> : <a href="' . $url . 'webdav/group/' . $group->guid . '" target="_blank">' . $url . 'webdav/group/' . $group->guid . '</a></li>';
		}
		$content .= '</ul>';
		$content .= '</li>';
	
	} else {
		$content .= '<li>Dossier personnel : <strong><a href="' . $url . 'webdav/user/GUID" target="_blank">' . $url . 'webdav/user/GUID</a></strong></li>';
		$content .= '<li>Dossier de groupe : <strong><a href="' . $url . 'webdav/group/GUID" target="_blank">' . $url . 'webdav/group/GUID</a></strong></li>';
	}

	$content .= '<li>Dossier pour les membres du site : <strong><a href="' . $url . 'webdav/member" target="_blank">' . $url . 'webdav/member</a></strong> (lecture seule)</li>';

	$content .= '<li>Dossier public : <strong><a href="' . $url . 'webdav/public" target="_blank">' . $url . 'webdav/public</a></strong> (sans authentification, lecture seule)</li>';

$content .= '</ul>';

$content .= '<br />';
$content .= '<br />';


$content = '<div class="elgg-output">' . $content . '</div>';
$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

