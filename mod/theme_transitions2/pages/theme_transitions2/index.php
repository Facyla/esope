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


$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// FOCUS ET PRESENTATION
$content .= '<div class="flexible-block" style="width:66%;">';
// @TODO use cmspage + custom slider or theme-specifc slider (with dynamic content) ?
//$content .= elgg_view('theme_transitions2/slider');
$content .= elgg_view('cmspages/view', array('pagetype' => "homepage-slider"));
$content .= '</div>';
$content .= '<div class="flexible-block" style="width:30%; float:right;">';
$content .= '<p>Racontez-nous votre transition, partagez une ressource pour le catalogue !</p>';
if (elgg_is_logged_in()) {
	//$content .= '<a href="' . elgg_get_site_url() . 'transitions/add/' . elgg_get_logged_in_user_guid() . '" class="elgg-button elgg-button-action">Contribuez</a>';
	// Quick contribution form
	$content .= elgg_view_form('transitions/quickform');
} else {
	$content .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action">Contribuez</a>';
}
$content .= '</div>';
$content .= '<div class="clearfloat"></div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// RECHERCHE
$search = elgg_view('theme_transitions2/search');
$content .= elgg_view_module('aside', 'Recherchez une ressource', $search);
$content .= '<div class="clearfloat"></div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';


$category = get_input('category', '');
if ($category == 'all') $category = '';
$search_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true);
if (!empty($category)) {
	$search_options['metadata_name_value_pairs'] = array('name' => 'category', 'value' => $category);
	$count = elgg_get_entities_from_metadata($search_options);
	$catalogue = elgg_list_entities_from_metadata($search_options);
} else {
	$count = elgg_get_entities_from_metadata($search_options);
	$catalogue = elgg_list_entities($search_options);
}
$content .= '<div id="transitions">'.$catalogue . '</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';


/*
$content .= elgg_view_module('info', "Ils s'appuient sur Transitions²", "<br /><br /><br /><br />");
$content .= elgg_view_module('info', "Nos choix", "<br /><br /><br /><br />");
$content .= elgg_view_module('featured', "Les +...", "<br /><br /><br /><br />");
*/


echo elgg_view_page($title, $content);
