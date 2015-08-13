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


//$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// BASELINE + UNE + CONTRIBUEZ
$content .= '<div class="flexible-block" style="width:66%;">';
	
	// Baseline
	$content .= '<div style="background: url(' . elgg_get_site_url() . 'mod/theme_transitions2/graphics/flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; min-height:140px;"><p style="text-transform: uppercase; font-size:2em; line-height:1.5; color:white; font-weight:bold; text-shadow:1px 1px 1px #99F; padding:1em; text-align:center;">' . "Relier transition ecologique et transition numerique" . '</p></div>';
	$content .= '<div class="clearfloat"></div>';
	
	// 4 articles en Une
	// @TODO : sélecteur pour chacun des 4 blocs avec titre, image, texte et possibilité de faire un lien
	$content .= '<div class="flexible-block" style="width:48%;">';
		$content .= '[ TODO : Sélecteur page à afficher ]';
		$cmspage = cmspages_get_entity('accueil-article1');
		if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
			$content .= $cmspage->getFeaturedImage('original');
			$content .= '<h3>' . $cmspage->pagetitle . '</h3>';
			$content .= $cmspage->description;
		}
	$content .= '</div>';
	$content .= '<div class="flexible-block" style="width:48%; float:right;">';
		$content .= '[ TODO : Sélecteur page à afficher ]';
		$cmspage = cmspages_get_entity('accueil-article2');
		if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
			$content .= $cmspage->getFeaturedImage('original');
			$content .= '<h3>' . $cmspage->pagetitle . '</h3>';
			$content .= $cmspage->description;
		}
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';
	$content .= '<div class="flexible-block" style="width:48%;">';
		$content .= '[ TODO : Sélecteur page à afficher ]';
		$cmspage = cmspages_get_entity('accueil-article3');
		if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
			$content .= $cmspage->getFeaturedImage('original');
			$content .= '<h3>' . $cmspage->pagetitle . '</h3>';
			$content .= $cmspage->description;
		}
	$content .= '</div>';
	$content .= '<div class="flexible-block" style="width:48%; float:right;">';
		$content .= '[ TODO : Sélecteur page à afficher ]';
		$cmspage = cmspages_get_entity('accueil-article4');
		if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
			$content .= $cmspage->getFeaturedImage('original');
			$content .= '<h3>' . $cmspage->pagetitle . '</h3>';
			$content .= $cmspage->description;
		}
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';
	
$content .= '</div>';

// CONTRIBUEZ (FORM)
$content .= '<div class="flexible-block" style="width:30%; float:right;">';
	if (elgg_is_logged_in()) {
		// Quick contribution form
		$content .= elgg_view_form('transitions/quickform');
	} else {
		$content .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action">Contribuez</a>';
	}
$content .= '</div>';


$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// RECHERCHE ET RACCOURCIS VERS CATALOGUE
$content .= '<br />';
$content .= elgg_view('transitions/search_home');
$content .= '<div class="clearfloat"></div>';


$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// SELECTION ALEATOIRE PARMI ARTICLE SELECTIONNES DU CATALOGUE
// @TODO Par défaut : celles sélectionnées par la rédaction
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

