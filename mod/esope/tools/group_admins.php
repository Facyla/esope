<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Liste des propriétaires et responsables de groupes";
$content = '';
$sidebar = '';

$options = array('types' => 'group', 'limit' => false);
$all_groups = elgg_get_entities($options);
$content .= "Le site comporte actuellement  " . count($all_groups) . " groupes.<br /><br />";

$content .= '<style>
#group-admins-table, #group-admins-table tr, #group-admins-table td { border:1px solid black; }
#group-admins-table td { padding:1px 4px; }
</style>';

if (elgg_is_active_plugin('group_operators')) { elgg_load_library('elgg:group_operators'); }

$content .= '<h3>Tableau des responsables par groupe</h3>';
$content .= '<table id="group-admins-table" style="width:100%;">';
$content .= '<tr><th>Groupe</th><th>Propriétaire</th><th>Co-responsables</th></tr>';
$all_group_owners = array();
$all_group_admins = array();
foreach ($all_groups as $ent) {
	$content .= '<tr>';
	$content .= '<td><a href="' . $ent->getURL() . '">' . $ent->name . '</a> (' . $ent->guid . ')</td>';
	$group_owner = get_entity($ent->owner_guid);
	if (!isset($all_group_owners[$ent->owner_guid])) { $all_group_owners[$ent->owner_guid] = $group_owner; }
	$content .= '<td><a href="' . $group_owner->getURL() . '">' . $group_owner->name . '</a> (' . $ent->owner_guid . ')</td>';
	$content .= '<td>';
	if (elgg_is_active_plugin('group_operators')) {
		$group_admins = get_group_operators($ent);
		foreach ($group_admins as $group_admin) {
			if (!isset($all_group_admins[$group_admin->guid])) { $all_group_admins[$group_admin->guid] = $group_admin; }
			$content .= '<a href="' . $group_admin->getURL() . '">' . $group_admin->name . '</a> (' . $group_admin->guid . ')<br />';
		}
	} else { $content .= "sans objet (fonctionnalité non activée)"; }
	$content .= '</td>';
	$content .= '<tr>';
}
$content .= '</table>';
$content .= '<br />';

$content .= '<h3>Liste des propriétaires de groupes</h3>';
$content .= '<table id="group-admins-table" style="width:100%;">';
$content .= '<tr><th>GUID</th><th>Nom</th><th>email</th></tr>';
foreach ($all_group_owners as $ent) {
	$content .= '<tr><td>' . $ent->guid . '</td><td><a href="' . $ent->getURL() . '">' . $ent->name . '</a></td><td>' . $ent->email . '</td></tr>';
}
$content .= '</table>';
$content .= '<br />';

$content .= '<h3>Liste des responsables de groupes</h3>';
$content .= '<table id="group-admins-table" style="width:100%;">';
$content .= '<tr><th>GUID</th><th>Nom</th><th>email</th></tr>';
foreach ($all_group_admins as $ent) {
	$content .= '<tr><td>' . $ent->guid . '</td><td><a href="' . $ent->getURL() . '">' . $ent->name . '</a></td><td>' . $ent->email . '</td></tr>';
}
$content .= '</table>';


$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


