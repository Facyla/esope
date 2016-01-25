<?php
/**
 * Statistics for everyone
 *
 */

global $CONFIG;

admin_gatekeeper();

$title = 'TOOLS';
$title = "Outils d'administration spécifiques";
$content = '';
$sidebar = '';

// Liste des outils Esope : nom du page_handler, clef de traduction et nom du fichier dans pages/esope/tools
$tools = esope_admin_tools_list();

// Composition de la page
$content .=  '<p>' . elgg_echo("esope:tools:intro") . '</p>';
$content .=  '<p>' . elgg_echo("esope:tools:warning") . '</p>';
foreach ($tools as $tool) {
	$content .= '<p><a href="' . elgg_get_site_url() . 'esope/tools/' . $tool . '" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo("esope:tools:tool:$tool") . '</a> ' . elgg_echo("esope:tools:tool:$tool:details") . '</p>';
}


// SIDEBAR
//$sidebar .= '<p><a class="elgg-button elgg-button-action" href="' . $CONFIG->url . 'feedback">Afficher les feedbacks</a>' . "</p>";



$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

