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
$title = 'Transitions²';
$sidebar = '';

$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$slider = elgg_view('slider/slider');
$content .= elgg_view_layout('one_sidebar', array('title' => false, 'content' => 'SLIDER / BLOC FOCUS<br />'.$slider, 'sidebar' => 'CONTRIBUEZ'));
//$content .= '<div class="" style="width:60%; float:left;"> / SLIDER</div>';
//$content .= '<div class="" style="width:36%; float:right;">BLOC CONTRIBUEZ</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$search = elgg_view('search/header');
$content .= elgg_view_layout('one_column', array('title' => false, 'content' => 'BLOC RECHERCHE<br />'.$search));
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$catalogue = elgg_list_entities(array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item'));
$content .= elgg_view_layout('one_column', array('title' => false, 'content' => '<div id="transitions">BLOC CATALOGUE<br />'.$catalogue . '</div>'));
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';


/*
$content = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));
*/

echo elgg_view_page($title, $content);
