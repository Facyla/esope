<?php
// Ensure that only logged-in users can see this page
gatekeeper();

$url = elgg_get_site_url();

$user = elgg_get_logged_in_user_entity();
$user_guid = elgg_get_logged_in_user_guid();

$title = elgg_echo('theme_template:index:title');
$body = '';

// Titre de la page
$body .= 'SOME CONTENT';

$params = array(
		'content' => $body,
		'title' => $title, 
	);
$body = elgg_view_layout('one_column', $params);


// Affichage
echo elgg_view_page($title, $body);

