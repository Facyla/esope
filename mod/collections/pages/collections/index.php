<?php
/**
* Elgg Collections
* 
* @package Elggcollection
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

gatekeeper();
global $CONFIG;

gatekeeper();


// Build the page content
$content = '';

// Page title
$title = elgg_echo('collections');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('collections'));

// Count Total pages
$collection_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'collection', 'order_by' => 'time_created desc', 'count' => true));
if ($collection_count > 0) $title .= " ($collection_count)";

// MENU : collection selector
$content .= '<div class="clearfloat"></div>';
//$content .= elgg_echo('collections:pagescreated', array($collection_count));
//$content .= elgg_view('collection/menu', array('pagetype' => $pagetype));
$content .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">
		<strong><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#collection_instructions\').toggle();">' . elgg_echo('collections:showinstructions') . '</a></strong>
		<div id="collection_instructions" class="elgg-output hidden">' . elgg_echo('collections:instructions') . '</div>
	</blockquote>';

$content .= '<p><a href="' . elgg_get_site_url() . 'collection/edit" class="elgg-button elgg-button-action">' . elgg_echo('collections:add') . '</a></p>';

if ($collection_count > 0) {
	$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'collection', 'order_by' => 'time_created desc', 'limit' => 50));
	//$content .= elgg_view('collection/listing');
}


//$page = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));

echo elgg_view_page($title, $page);

