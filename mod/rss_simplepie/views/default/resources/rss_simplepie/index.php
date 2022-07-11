<?php
/**
 * Main delivery modes page
 */

elgg_admin_gatekeeper();

$url = elgg_get_site_url();

elgg_push_breadcrumb(elgg_echo('rss_simplepie:index'), 'rss_simplepie');

// @TODO bouton visible ssi les fonctionnalités avancées sont développées
//elgg_register_title_button('rss_simplepie', 'add', 'object', 'rss_simplepie');

$content = '';



// SIDEBAR
$sidebar .= elgg_view('rss_simplepie/sidebar', []);



echo elgg_view_page($title, [
	'title' => elgg_echo('rss_simplepie:index'),
	'content' =>  $content,
	'sidebar' => $sidebar,
	'class' => 'elgg-chat-layout',
]);

