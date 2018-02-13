<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

admin_gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
$own = elgg_get_logged_in_user_entity();
/*
if (elgg_is_admin_logged_in() || in_array($own->username, explode(',', elgg_get_plugin_setting('animators', 'theme_inria'))) ) {
} else {
	forward();
	register_error(elgg_echo('error:noaccess'));
}
*/

$group_guid = get_input('group_guid', '');
$limit = get_input('limit', 100);
$offset = get_input('offset', 0);

$content = '';
$sidebar = '';

// Composition de la page
$content .= '<div id="members-icons" class="">';
$content .= "<p>Cette page vous permet de lister les images de profils des membrs du site ou d'un groupe particulier.</p>";
$content .= '<div class="clearfloat"></div><br />';


// Compose form
$content .= '<h3>Images du profil</h3>';
$content .= '<form method="POST">';
$content .= '<p><label>Groupe ' . elgg_view('input/groups_select', array('name' => 'group_guid', 'value' => $group_guid)) . '</label></p>';
$content .= '<p>' . elgg_view('input/submit', array('value' => "Afficher les images")) . '</p>';
$content .= '</form>';
$content .= '<div class="clearfloat"></div><br />';


$content .= '<h3>Images des profils</h3>';
if (empty($group_guid)) {
	$members = elgg_get_entities_from_metadata(['type' => 'user', 'metadata_names' => 'icontime', 'limit' => $limit, 'offset' => $offset]);
} else {
	$members = elgg_get_entities_from_relationship(['type' => 'user', 'metadata_names' => 'icontime', 'relationship' => 'member', 'relationship_guid' => $group_guid, 'inverse_relationship' => true, 'limit' => $limit, 'offset' => $offset]);
}
foreach ($members as $ent) {
	$content .= '<img src="' . $ent->getIcon('master') . '" style="max-width: 100px; max-height: 100px;"/>';
}
$content .= '<div class="clearfloat"></div><br />';




$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));

// Affichage
echo elgg_view_page($title, $body);

