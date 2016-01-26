<?php
/**
 * Statistics for everyone
 *
 */

admin_gatekeeper();

$title = 'TEST';
$title = "Outils Page pour des tests (DEV)";
$content = '';
$sidebar = '';


$content .= '';




$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

