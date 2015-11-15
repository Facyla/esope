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
$content .= '<div class="flexible-block transitions-home-slider">';
	
	// Baseline
	/*
	$content .= '<div style="background: url(' . elgg_get_site_url() . 'mod/theme_transitions2/graphics/flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; min-height:140px;"><p style="text-transform: uppercase; font-size:2em; line-height:1.5; color:white; font-weight:bold; text-shadow:1px 1px 1px #99F; padding:1em; text-align:center;">' . "Relier transition ecologique et transition numerique" . '</p></div>';
	$content .= '<div class="clearfloat"></div>';
	*/
	
	// 4 articles en Une
	// Sélecteur pour chacun des 4 blocs avec titre, image et texte riche
	$is_content_admin = theme_transitions2_user_is_platform_admin();
	$slides = array();
	$slides_admin = '<div class="clearfloat"></div>';
	$lang = get_language();
	for ($i=1; $i<=4; $i++) {
		// Try to use translated slider
		if ($lang == 'fr') {
			$article = elgg_get_plugin_setting("home-article$i", 'theme_transitions2');
		} else {
			$article = elgg_get_plugin_setting("home-article$i" . "_" . $lang, 'theme_transitions2');
		}
		$slide_content = elgg_view('theme_transitions2/slider_homeslide', array('guid' => $article));
		if (!empty($slide_content)) { $slides[] = $slide_content; }
		if ($is_content_admin) {
			$slides_admin .= '<div class="flexible-block" style="width:auto; margin-right:1em;">';
			if ($lang == 'fr') {
				$slides_admin .= elgg_view_form('theme_transitions2/select_article', array(), array('name' => "home-article$i", 'value' => $article));
			} else {
				$slides_admin .= elgg_view_form('theme_transitions2/select_article', array(), array('name' => "home-article$i" . "_" . $lang, 'value' => $article));
			}
			$slides_admin .= '</div>';
		}
	}
	if ($is_content_admin) { $slides_admin .= '<div class="clearfloat"></div>'; }
	
	$content .= '<div style="height:260px; width:100%; overflow:hidden;" id="slider-homepage-slider" class="slider-homepage-slider">';
	$content .= elgg_view('slider/slider', array(
			'slides' => $slides,
			'sliderparams' => "theme : 'cs-portfolio', autoPlay : true, mode : 'f', resizeContents:true, expand:true, buildNavigation:true, buildStartStop:false, toggleControls:false, toggleArrows:true, hashTags:false, delay:5000, pauseOnHover:true, autoPlayLocked:true, allowRapidChange:true, resumeDelay: 3000",
			'slidercss_main' => "",
			'slidercss_textslide' => "",
			'height' => '260px',
			'width' => '100%',
		));
	$content .= '</div>';
	
$content .= '</div>';

// CONTRIBUEZ (FORM)
$content .= '<div class="flexible-block transitions-home-contribute">';
$content .= '<div style="padding: 40px 40px 20px; font-size:12px; font-weight:bold; color:white;">';
	if (elgg_is_logged_in()) {
		// Quick contribution form
		$content .= '<p>' . elgg_echo('theme_transitions:contribute') . '</p>';
		$content .= '<a href="' . elgg_get_site_url() . 'transitions/add" class="elgg-button elgg-button-action" style="width:100%; text-align:center; text-transform:uppercase;">' . elgg_echo('theme_transitions2:contribute:button') . '</a>';
		//$content .= '<h3>' . elgg_echo('transitions:quickform:title') . '</h3>';
		//$content .= elgg_view_form('transitions/quickform');
	} else {
		$content .= '<p>' . elgg_echo('theme_transitions:contribute') . '</p>';
		$content .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action" style="width:100%; text-align:center; text-transform:uppercase;">' . elgg_echo('theme_transitions2:contribute:button') . '</a>';
	}
$content .= '</div>';
$content .= '</div>';

// Admin slider
$content .= $slides_admin;


$content .= '</div></div><div class="elgg-page-body elgg-page-body-search"><div class="elgg-inner">';

// RECHERCHE ET RACCOURCIS VERS CATALOGUE
$content .= elgg_view('transitions/search_home');
$content .= '<div class="clearfloat"></div>';


$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';

// SELECTION ALEATOIRE PARMI ARTICLE SELECTIONNES DU CATALOGUE
// @TODO Par défaut : celles sélectionnées par la rédaction
$dbprefix = elgg_get_config('dbprefix');
$list_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true, 'pagination' => true);
$count = elgg_get_entities_from_metadata($list_options);

// @TODO Exclude featured and background contributions ?
$meta_featured_id = elgg_get_metastring_id('featured');
$meta_background_id = elgg_get_metastring_id('background');
//$list_options['joins'][] = "JOIN {$dbprefix}metadata md on e.guid = md.entity_guid";
//$list_options['wheres'][] = "(md.name_id = $meta_featured_id AND md.value_id IS NULL)";
//$list_options['wheres'][] = "e.guid NOT IN (SELECT entity_guid FROM {$dbprefix}metadata md WHERE md.entity_guid = e.guid AND md.name_id = $meta_featured_id AND md.value_id = '')";
//$list_options['metadata_name_value_pairs'][] = array('name' => 'featured', 'value' => '');
//$list_options['metadata_name_value_pairs'][] = array('name' => 'featured', 'value' => "($meta_featured_id, $meta_background_id)", 'operand' => 'NOT IN');
//$list_options['metadata_name_value_pairs'][] = array('name' => 'featured', 'value' => 'background', 'operand' => '<>');
$catalogue = '';
$catalogue .= '<div class="transitions-gallery transitions-gallery-recent hidden">';
$catalogue .= elgg_list_entities_from_metadata($list_options);
$catalogue .= '</div>';

// Featured content only
$list_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'pagination' => true, 'metadata_name_value_pairs' => array('name' => 'featured', 'value' => 'featured'));
$catalogue .= '<div class="transitions-gallery transitions-gallery-featured">';
$catalogue .= elgg_list_entities_from_metadata($list_options);
$catalogue .= '</div>';

// Background content only
$list_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'metadata_name_value_pairs' => array('name' => 'featured', 'value' => 'background'));
$catalogue .= '<div class="transitions-gallery transitions-gallery-background hidden">';
$catalogue .= elgg_list_entities_from_metadata($list_options);
$catalogue .= '</div>';

// @TODO Most read
$catalogue .= '<div class="transitions-gallery transitions-gallery-read hidden">';
$catalogue .= '[ TODO : les plus lues ]';
$catalogue .= '</div>';

// @TODO Most commented
$catalogue .= '<div class="transitions-gallery transitions-gallery-commented hidden">';
$catalogue .= '[ TODO : les plus commentées ]';
$catalogue .= '</div>';

// @TODO Most contributed
$catalogue .= '<div class="transitions-gallery transitions-gallery-contributed hidden">';
$catalogue .= '[ TODO : les plus contribuées ]';
$catalogue .= '</div>';


// Switch filter (+ onChange)
$content .= elgg_view('forms/theme_transitions2/switch_filter', array('id' => 'transitions-form-switch-filter', 'value' => 'featured'));

$content .= '<h2>' . elgg_echo('theme_transitions2:transitions:title') . '</h2>';
//$content .= '<h2>' . elgg_echo('theme_transitions2:transitions:count', array($count)) . '</h2>';
$content .= $catalogue;



//$content .= '</div></div><div class="elgg-page-body"><div class="elgg-inner">';


echo elgg_view_page($title, $content);

