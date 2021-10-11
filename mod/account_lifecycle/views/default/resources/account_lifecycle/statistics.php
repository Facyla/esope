<?php
/**
 * Main delivery modes page
 */

elgg_admin_gatekeeper();

$url = elgg_get_site_url();

elgg_push_breadcrumb(elgg_echo('account_lifecycle:statistics'), 'account_lifecycle');

// @TODO bouton visible ssi les fonctionnalités avancées sont développées
//elgg_register_title_button('account_lifecycle', 'add', 'object', 'account_lifecycle');

$content = '';

$validated = elgg_get_entities([
	'type' => 'user',
	'count' => true,
]);
$content .= "<p>$validated comptes utilisateurs</p>";

$validated = elgg_get_entities([
	'type' => 'user',
	'metadata_name_value_pairs' => ['name' => 'validated', 'value' => '1'], 
	'count' => true,
]);
$content .= "<p>$validated comptes validés</p>";

$validated = elgg_get_entities([
	'type' => 'user',
	'metadata_name_value_pairs' => ['name' => 'validated', 'value' => '0'], 
	'count' => true,
]);
$content .= "<p>$validated comptes non validés</p>";

$validated = elgg_get_admins(['count' => true]);
$content .= "<p>$validated comptes admin</p>";


// SIDEBAR
//$sidebar .= '<div></div>';


// Sidebar droite
$sidebar_alt .= '';



echo elgg_view_page($title, [
	'title' => elgg_echo('account_lifecycle:statistics'),
	'content' =>  $content,
	//'sidebar' => $sidebar,
	//'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-chat-layout',
]);

