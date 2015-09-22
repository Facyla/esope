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
$title = elgg_echo('theme_transitions2:news');
$sidebar = '';


$content .= '<h2>' . elgg_echo('theme_transitions2:news:title') . '</h2>';

// SELECTION ALEATOIRE PARMI ARTICLE SELECTIONNES DU CATALOGUE
// Event et Editorial sélectionnées par la rédaction
$list_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 12, 'full_view' => true, 'item_class' => 'transitions-item', 'metadata_name_value_pairs' => array(array('name' => 'featured', 'value' => 'featured'), array('name' => 'category', 'value' => array('event', 'editorial'))), 'embed' => true);
$content .= '<div class="transitions-news">';
$content .= elgg_list_entities_from_metadata($list_options);
$content .= '</div>';


echo elgg_view_page($title, $content);

