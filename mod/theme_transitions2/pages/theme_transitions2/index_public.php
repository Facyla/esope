<?php
/**
 * Transitions² public homepage
 *
 */

// no RSS feed with a "widget" front page
/*
global $autofeed;
$autofeed = FALSE;
*/


$content = 'Contenu public';
$title = 'Titre public';
$sidebar = 'Sidebar publique';


$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
