<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

elgg_set_context('members');

$title = elgg_echo('recommendations');
$content = '';

gatekeeper();

if (elgg_is_admin_logged_in()) {
	$username = get_input('username');
	if (!empty($username)) {
		$user = get_user_by_username($username);
	}
}

if (!$user) {
	$user = elgg_get_logged_in_user_entity();
}


$recommendations = recommendations_get_users($user, 30, 20);


$content .= "<h3>Recommandations de contacts pour {$user->name}</h3>";
if (count($recommendations > 0)) {
	foreach ($recommendations as $person) {
		$mutuals = count($person['mutuals']);
		$shared_groups = count($person['groups']);
		//$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('large') . '" /></a>';
		$info = '<p><strong>' . $person['entity']->name . '</strong>';
		if ($mutuals > 0) $info = ' &nbsp; ' . $mutuals . ' contacts comuns';
		if ($shared_groups > 0) $info .= ' &nbsp; ' . $shared_groups . ' groupes partagés';
		$info .= '</p>';
		$content .= elgg_view_listing(elgg_view('profile/icon', array('entity' => $person['entity'], 'size' => 'small')), $info);
	}
} else {
	$content .= '<p>' . "Pas de recommandation de contact pour le moment.</p><p>Commencez par rejoindre des groupes et entrer en contact avec quelques personnes pour avoir des recommandations personnalisées" . '</p>';
}
$content .= '<div class="clearfloat"></div><br /><br />';



// GROUPES

// User groups (to be excluded)
$user_groups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid, 'inverse_relationship' => false, 'limit' => 0));
$user_groups_guids = array();
foreach($user_groups as $ent) {
	$user_groups_guids[] = $ent->guid;
}
if (!empty($user_groups_guids)) $exclude_usergroups = "e.guid NOT IN (" . implode(',', $user_groups_guids) . ")";
echo $user_groups_guids;

// Featured groups
$featured_groups = elgg_get_entities_from_metadata(array('type' => 'group', 'limit' => 0, 'metadata_name_value_pairs' => array('name' => 'featured_group', 'value' => 'yes'), 'wheres' => array($exclude_usergroups)));

$name_metastring_id = elgg_get_metastring_id('featured_group');
$value_metastring_id = elgg_get_metastring_id('yes');
$dbprefix = elgg_get_config('dbprefix');
$exclude_featured = "NOT EXISTS (SELECT 1 FROM {$dbprefix}metadata md WHERE md.entity_guid = e.guid AND md.name_id = $name_metastring_id AND md.value_id = $value_metastring_id)";
$popular_groups = elgg_get_entities_from_relationship_count(array('type' => 'group', 'relationship' => 'member', 'inverse_relationship' => false, 'wheres' => array($exclude_featured, $exclude_usergroups), 'limit' => 6));


// Render recommended groups
$content .= "<h3>Recommandations de groupes pour {$user->name}</h3>";

$content .= '<h3>Groupes en Une</h3>';
foreach($featured_groups as $ent) {
	$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
	$info = '<p><strong>' . $ent->name . '</strong>';
	$info .= '<p>' . $ent->getMembers(null, null, true) . ' membres</p>';
	$content .= elgg_view_listing($icon, $info);
}
$content .= '<div class="clearfloat"></div><br /><br />';

$content .= '<h3>Groupes populaires</h3>';
foreach($popular_groups as $ent) {
	$icon = '<a href="' . $ent->getURL() . '"><img src="' . $ent->getIcon('small') . '" /></a>';
	$info = '<p><strong>' . $ent->name . '</strong>';
	$info .= '<p>' . $ent->getMembers(null, null, true) . ' membres</p>';
	$content .= elgg_view_listing($icon, $info);
}
$content .= '<div class="clearfloat"></div><br />';


// Render the page
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content));
echo elgg_view_page($title, $body);


