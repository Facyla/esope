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

$content .= '<div>BLOC HEADER ET NAVIGATION</div>';
$content .= '<div>';
$content .= '<div class="" style="width:60%; float:left;">BLOC FOCUS / SLIDER</div>';
$content .= '<div class="" style="width:36%; float:right;">BLOC CONTRIBUEZ</div>';
$content .= '</div>';
$content .= '<div>BLOC RECHERCHE</div>';
$content .= '<div>BLOC CATALOGUE</div>';
$content .= '<div>BLOC FOOTER</div>';


$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
