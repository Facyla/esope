<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

gatekeeper();

register_error("Adresse invalide, veuillez la compléter pour accéder à la page souhiatée.");
forward();

$content = '';
$sidebar = '';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

