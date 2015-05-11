<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

// Limited to admin !
admin_gatekeeper();

$inria_location = get_input('inria_location', false);
$inria_location_main = get_input('inria_location_main', false);
$epi_ou_service = get_input('epi_ou_service', false);

$title = "Liste des membres selon divers critères issus du LDAP";


// esope_get_meta_values($meta_name)
$inria_location_opt = array_merge(array(''), esope_get_meta_values('inria_location'));
$inria_location_opt = array_combine($inria_location_opt, $inria_location_opt);
$inria_location_main_opt = array_merge(array(''), esope_get_meta_values('inria_location_main'));
$inria_location_main_opt = array_combine($inria_location_main_opt, $inria_location_main_opt);
$epi_ou_service_opt = array_merge(array(''), esope_get_meta_values('epi_ou_service'));
$epi_ou_service_opt = array_combine($epi_ou_service_opt, $epi_ou_service_opt);

$content .= '<form method="POST">';
$content .= '<p><label>Localisation géographique ' . elgg_view('input/dropdown', array('name' => "inria_location", 'value' => $inria_location, 'options_values' => $inria_location_opt)) . '</label></p>';
$content .= '<p><label>Entité de rattachement ' . elgg_view('input/dropdown', array('name' => "inria_location_main", 'value' => $inria_location_main, 'options_values' => $inria_location_main_opt)) . '</label></p>';
$content .= '<p><label>EPI ou service ' . elgg_view('input/dropdown', array('name' => "epi_ou_service", 'value' => $epi_ou_service, 'options_values' =>$epi_ou_service_opt)) . '</label></p>';
/*
$content .= '<input type="text" name="inria_location" placeholder="Localisation géographique" value="' . $inria_location . '">';
$content .= '<input type="text" name="inria_location_main" placeholder="" value="' . $inria_location_main . '">';
$content .= '<input type="text" name="epi_ou_service" placeholder="" value="' . $epi_ou_service . '">';
*/
$content .= '<input type="submit" value="Lister les comptes">';
$content .= '</form>';

$max_results = 0;
$search_params = array('types' => "user", 'limit' => $max_results, 'count' => true, 'metadata_name_value_pairs' => array(array('name' => "membertype", 'value' => "inria")));
if ($inria_location) $search_params['metadata_name_value_pairs'][] = array('name' => 'inria_location', 'value' => $inria_location);
if ($inria_location_main) $search_params['metadata_name_value_pairs'][] = array('name' => 'inria_location_main', 'value' => $inria_location_main);
if ($epi_ou_service) $search_params['metadata_name_value_pairs'][] = array('name' => 'epi_ou_service', 'value' => $epi_ou_service);

if ($inria_location || $inria_location_main || $epi_ou_service) {
	$count_users = elgg_get_entities_from_metadata($search_params);
	$search_params['count'] = false;
	$users = elgg_get_entities_from_metadata($search_params);
	
	$title_filters = array();
	if ($inria_location) $title_filters[] = $inria_location;
	if ($inria_location_main) $title_filters[] = $inria_location_main;
	if ($epi_ou_service) $title_filters[] = $epi_ou_service;
	$title_filters = implode($title_filters, ' + ');
	
	$content .= "<h2>{$count_users} comptes Iris trouvés pour : $title_filters</h2>";
	if ($max_results > 0) $content .= "<p><em>$max_results comptes affichés au maximum</em></p>";

	if ($users) {
		foreach($users as $ent) {
			//$content .= "{$ent->guid} {$ent->username} : {$ent->name} &nbsp; {$ent->email}" . '<br />';
			$content .= "{$ent->guid} {$ent->username} : {$ent->name} ({$ent->inria_location} / {$ent->inria_location_main} / {$ent->epi_ou_service})<br />";
		}
	}
} else {
	$content .= "<p><em>Aucun critère de recherche défini : veuillez choisir ou moins 1 critère.</em></p>";
}


$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

// Affichage
echo elgg_view_page($title, $body);

