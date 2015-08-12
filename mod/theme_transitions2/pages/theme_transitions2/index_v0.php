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


$content = '';
$title = 'A la Une';
$sidebar = '';
$sidebar .= elgg_view_module('aside', 'Contribuer', "Par catégorie<br /><br /><br />Par tag<br /><br /><br />");
$sidebar .= elgg_view_module('aside', 'Naviguer', "Par catégorie<br /><br /><br />Par tag<br /><br /><br />");


$content .= elgg_view_module('info', "Ils s'appuient sur Transitions²", "<br /><br /><br /><br />");
$content .= elgg_view_module('info', "Nos choix", "<br /><br /><br /><br />");
$content .= elgg_view_module('featured', "Les +...", "<br /><br /><br /><br />");

$body = elgg_view_layout('one_sidebar', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
