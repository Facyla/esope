<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

$site = elgg_get_site_entity();
$title = $site->name;

$title = elgg_echo('theme_template:index:public:title');
$body = '';

// Titre de la page
$body .= 'SOME CONTENT ON PUBLIC HOMEPAGE';

$params = array(
		'content' => $body,
		'title' => $title, 
	);
$body = elgg_view_layout('one_column', $params);


// Affichage
echo elgg_view_page($title, $body);

