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
$title = elgg_echo('theme_transitions2:home');
$sidebar = '';


$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// FOCUS ET PRESENTATION
$content .= '<div class="flexible-block" style="width:66%;">';
// @TODO use cmspage + custom slider or theme-specifc slider (with dynamic content) ?
//$content .= elgg_view('theme_transitions2/slider');
$content .= elgg_view('cmspages/view', array('pagetype' => "homepage-slider"));
$content .= '</div>';
$content .= '<div class="flexible-block" style="width:30%; float:right;">';
$content .= '<p>' . elgg_echo('theme_transitions2:newcontribution') . '</p>';
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
$search = elgg_view('transitions/search_home');
$content .= elgg_view_module('aside', elgg_echo('theme_transitions2:search'), $search);
$content .= '<div class="clearfloat"></div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

$search_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true);

$count = elgg_get_entities_from_metadata($search_options);
$catalogue = elgg_list_entities($search_options);
$content .= '<div id="transitions">';
$content .= elgg_echo('theme_transitions2:transitions:count', array($count));
$content .= $catalogue;
$content .= '</div>';
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';



echo elgg_view_page($title, $content);
