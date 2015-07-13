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
		// use cmspage + custom slider or theme-specifc slider (with dynamic content) ?
		//$content .= elgg_view('theme_transitions2/slider');
		//$content .= elgg_view('cmspages/view', array('pagetype' => "homepage-slider"));
		$content .= elgg_view('slider/view', array('guid' => "homepage-slider"));
		if (elgg_is_admin_logged_in()) $content .= '<a href="' . elgg_get_site_url() . 'slider/edit/homepage-slider?edit_mode=basic">Modifier le diaporama</a>';
		// @TODO 4 blocs avec titre, image, texte et possibilité de faire un lien
		$content .= '<div class="clearfloat"></div>';
		$content .= '<br /><br />';
		
		// SEARCH
		$content .= elgg_view('transitions/search_home');
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	
	// SIDEBAR - CONTRIBUEZ !
	$content .= '<div class="flexible-block" style="width:30%; float:right;">';
		$content .= '<p>' . elgg_echo('theme_transitions2:newcontribution') . '</p>';
		if (elgg_is_logged_in()) {
			// Quick contribution form
			$content .= elgg_view_form('transitions/quickform');
		} else {
			$content .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action">Contribuez</a>';
		}
	$content .= '</div>';
	
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';


// @TODO Par défaut : celles sélectionnées par la rédaction
// Filtres sur : les +commentées, les +tagguées, les +récentes, les +liées
	$list_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true);
	$count = elgg_get_entities_from_metadata($list_options);
	$catalogue = elgg_list_entities($list_options);

	$content .= '<br /><br />';
	$content .= '<div id="transitions">';
	$content .= '<h2>' . elgg_echo('theme_transitions2:transitions:count', array($count)) . '</h2>';
	$content .= $catalogue;
	$content .= '</div>';
	
$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';



echo elgg_view_page($title, $content);
