<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


admin_gatekeeper();

$title = "Statistiques sur les membres";
$content = '';
$sidebar = '';


$users_count = elgg_get_entities(array('types' => 'user', 'count' => true));
$content .= "Le site comporte actuellement  " . $users_count . " membres.<br /><br />";
$content .= "Attention : les résultats sont affichés *sous* cete page (utilisation d'un batch pour éviter tout dépassement de mémoire).<br /><br />";


$params = array('content' => $content, 'title' => $title, 'sidebar' => $sidebar);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


// Use a batch, as it is an intensive task on big sites
echo "<br /><br />";
echo '<table style="width:100%;">';
echo '<thead><tr><th>Membre</th><th>Nombre de groupes</th></tr></thead>';
echo '<tbody>';
$batch = new ElggBatch('elgg_get_entities', array('types' => 'user', 'limit' => false), 'esope_tools_users_stats', 50);
echo '</tbody>';
echo '</table>';
echo '<br />';


// Batch function
function esope_tools_users_stats($ent, $getter, $options) {
	$content .= '<tr style="border:1px solid;">';
	$content .= '<td style="border:1px solid; padding:2px 4px;"><a href="' . $ent->getURL() . '">' . $ent->name . '</a> (' . $ent->guid . ')</td>';
	$content .= '<td style="border:1px solid; padding:2px 4px;">';
	$content .= elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $ent->guid, 'count' => true));
	$content .= '</td>';
	$content .= '<tr>';
	echo $content;
}

