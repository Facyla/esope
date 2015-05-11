<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

// Limited to admin !
admin_gatekeeper();

$inria_location = get_input('inria_location', false);
$inria_location_main = get_input('inria_location_main', false);
$epi_ou_service = get_input('epi_ou_service', false);

$valid_ldap = '';


// esope_get_meta_values($meta_name)

$content .= '<form method="POST">';
$content .= '<p><label>Localisation géographique ' . elgg_view('input/dropdown', array('name' => "inria_location", 'value' => $inria_location, 'options_values' => esope_get_meta_values('inria_location'))) . '</label></p>';
$content .= '<p><label>Entité de rattachement ' . elgg_view('input/dropdown', array('name' => "inria_location_main", 'value' => $inria_location_main, 'options_values' => esope_get_meta_values('inria_locatio_main'))) . '</label></p>';
$content .= '<p><label>EPI ou service ' . elgg_view('input/dropdown', array('name' => "epi_ou_service", 'value' => $epi_ou_service, 'options_values' => esope_get_meta_values('epi_ou_service'))) . '</label></p>';
/*
$content .= '<input type="text" name="inria_location" placeholder="Localisation géographique" value="' . $inria_location . '">';
$content .= '<input type="text" name="inria_location_main" placeholder="" value="' . $inria_location_main . '">';
$content .= '<input type="text" name="epi_ou_service" placeholder="" value="' . $epi_ou_service . '">';
*/
$content .= '<input type="submit" value="Lister les comptes">';
$content .= '</form>';


$search_params = array('types' => "user", 'limit' => 100, 'count' => true, 'metadata_name_value_pairs' => array(array('name' => "membertype", 'value' => "inria")));
if ($inria_location) $search_params['metadata_name_value_pairs'][] = array('name' => 'inria_location', 'value' => $inria_location);
if ($inria_location_main) $search_params['metadata_name_value_pairs'][] = array('name' => 'inria_location_main', 'value' => $inria_location_main);
if ($epi_ou_service) $search_params['metadata_name_value_pairs'][] = array('name' => 'epi_ou_service', 'value' => $epi_ou_service);

if ($inria_location || $inria_location_main || $epi_ou_service) {
	$count_users = elgg_get_entities_from_metadata($search_params);
	$search_params['count'] = false;
	$users = elgg_get_entities_from_metadata($search_params);

	$content .= "<h2>{$count_users} comptes Iris trouvés</h2>";
	$content .= "<p><em>100 comptes affichés au maximum</em></p>";

	if ($users) {
		foreach($users as $ent) {
			//$content .= "{$ent->guid} {$ent->username} : {$ent->name} &nbsp; {$ent->email}" . '<br />';
			$content .= "{$ent->guid} {$ent->username} : {$ent->name}<br />";
		}
	}
} else {
	$content .= "<p><em>Aucun critère de recherche défini : veuillez choisir ou moins 1 critère.</em></p>";
}


$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

// Affichage
echo elgg_view_page($title, $body);

