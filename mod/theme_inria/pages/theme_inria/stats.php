<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

gatekeeper();

// Liste manuelle.. ou metadata spécifique ?
if (elgg_is_admin_logged_in() || in_array($_SESSION['username'], explode(',', elgg_get_plugin_setting('animators', 'theme_inria'))) ) {
} else {
	forward();
}

$content = '';
$sidebar = '';

$dbprefix = elgg_get_config("dbprefix");
$current_site_guid = elgg_get_site_entity()->getGUID();
$day = 3600*24;
$month = $day*31;
$year = $day*365;

$start_ts = time() - $year;
$start_ts = get_input('start_ts', $start_ts);
$end_ts = time();
$end_ts = get_input('end_ts', $end_ts);
if ($start_ts >= $end_ts) {
	$content .= "Dates invalides : la date de début doit précéder celle de fin.";
}

// Composition de la page
$content .= '<div id="inria-animation" class="">';
$content .= "Cette page regroupe quelques statistiques du réseau. <a href=\"" . elgg_get_site_url() . "inria/animation\">Voyez également la page animation.</a>.";


// Accès autorisés pour tous
$sidebar .= '<p><a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'feedback">Afficher les feedbacks</a>' . "</p>";


$content .= '';

$content .= '<form>
	<p><label>Date de début ' . elgg_view('input/date', ['name' => 'start_ts', 'value' => $start_ts, 'timestamp' => true]) . '</label></p>
	<p><label>Date de fin ' . elgg_view('input/date', ['name' => 'end_ts', 'value' => $end_ts, 'timestamp' => true]) . '</label></p>
	<p>' . elgg_view('input/submit') . '</p>
</form>
<br />';

$content .= '<h3>Statistiques sur la période du ' . date("d/m/Y", $start_ts) . ' au ' . date("d/m/Y", $end_ts) . '</h3>';

$content .= '<div class="elgg-output">';

	// Publications
	$content .= "<h4>Nombre de publications</h4>";
	$objects_types = get_registered_entity_types('object');
	$subtypes = [];
	foreach($objects_types as $subtype) { $subtypes[] = $subtype; }
	$subtypes = array_unique($subtypes);
	$count = elgg_get_entities_from_relationship(['type' => 'object', 'count' => true, 'wheres' => "e.time_created > $start_ts AND e.time_created <= $end_ts"]);
	$content .= "<p><strong>$count nouvelles publications</strong>, dont : <ul>";
		foreach($subtypes as $subtype) {
			$count = elgg_get_entities_from_relationship(['type' => 'object', 'subtype' => $subtype, 'count' => true, 'wheres' => "e.time_created > $start_ts AND e.time_created <= $end_ts"]);
			$content .= "<li>$count " . elgg_echo('item:object:'.$subtype) . " ($subtype)</li>";
		}
	$content .= "</ul></p>";

	// Nouveaux comptes (inria et externes)
	$content .= "<h4>Nouveaux utilisateurs et utilisateurs actifs</h4>";
	$inria_profile_type_id = esope_get_profiletype_guid('inria');
	$external_profile_type_id = esope_get_profiletype_guid('external');
	// Tous
	$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'wheres' => "e.time_created > $start_ts AND e.time_created <= $end_ts"]);
	$content .= "<p><strong>$count nouveaux comptes</strong>, dont : <ul>";
		// Inria
		$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'metadata_name_value_pairs' => ['name' => 'custom_profile_type', 'value' => $inria_profile_type_id], 'wheres' => "e.time_created > $start_ts AND e.time_created <= $end_ts"]);
		$content .= "<li>$count Inria</li>";
		// Externes
		$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'metadata_name_value_pairs' => ['name' => 'custom_profile_type', 'value' => $external_profile_type_id], 'wheres' => "e.time_created > $start_ts AND e.time_created <= $end_ts"]);
		$content .= "<li>$count Externes</li>";
	$content .= '</ul></p>';

	// Comptes actifs (inria et externes)
	$inria_profile_type_id = esope_get_profiletype_guid('inria');
	$external_profile_type_id = esope_get_profiletype_guid('external');
	// Tous
	$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'joins' => array("join {$dbprefix}users_entity u on e.guid = u.guid"), 'wheres' => "u.last_login > $start_ts"]);
	$content .= "<p><strong>$count comptes actifs depuis le " . date('d/m/Y', $start_ts) . "</strong>, dont : <ul>";
		// Inria
		$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'metadata_name_value_pairs' => ['name' => 'custom_profile_type', 'value' => $inria_profile_type_id], 'joins' => array("join {$dbprefix}users_entity u on e.guid = u.guid"), 'wheres' => "u.last_login > $start_ts AND u.last_login <= $end_ts"]);
		$content .= "<li>$count Inria</li>";
		// Externes
		$count = elgg_get_entities_from_relationship(['type' => 'user', 'count' => true, 'metadata_name_value_pairs' => ['name' => 'custom_profile_type', 'value' => $external_profile_type_id], 'joins' => array("join {$dbprefix}users_entity u on e.guid = u.guid"), 'wheres' => "u.last_login > $start_ts AND u.last_login <= $end_ts"]);
		$content .= "<li>$count Externes</li>";
	$content .= '</ul></p>';


$content .= '</div>';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

