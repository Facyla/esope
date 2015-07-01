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
$title = 'Titre public';
$sidebar = 'Sidebar publique';

$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$content .= 'BLOC HEADER ET NAVIGATION';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$content .= '<div class="" style="width:60%; float:left;">BLOC FOCUS / SLIDER</div>';
$content .= '<div class="" style="width:36%; float:right;">BLOC CONTRIBUEZ</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$content .= '<div>BLOC RECHERCHE</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$content .= '<div>BLOC CATALOGUE</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$content .= '<div>BLOC FOOTER</div>';


/*
$content = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));
*/

echo elgg_view_page($title, $content);
