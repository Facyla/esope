<?php
/**
 * Inria base page
 */

gatekeeper();

register_error("Adresse invalide, veuillez la compléter pour accéder à la page souhaitée.");
forward();

$content = '';
$sidebar = '';


$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

