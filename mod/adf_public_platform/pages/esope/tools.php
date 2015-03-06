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

// Liste des outils Esope : 'page_handler' => "Description"
// @TODO : when adding new tools, synchronize with lib/page_handlers tools list
$tools = array('group_admins', 'users_email_search', 'group_newsletters_default', 'test_mail_notifications', 'threads_disable', 'group_updates', 'spam_users_list', 'user_updates', 'clear_cmis_credentials');

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

