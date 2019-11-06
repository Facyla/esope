<?php
/**
* Elgg CMS pages
* 
* @package Elggslider
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2015
* @link http://id.facyla.fr/
*/

elgg_gatekeeper();

// Allow access to members ? or admins only..
$slider_access = elgg_get_plugin_setting('slider_access', 'slider');
if ($slider_access != 'yes') { admin_gatekeeper(); }


// Build the page content
$content = '';

// Page title
$title = elgg_echo('slider');

// Breadcrumbs
elgg_push_breadcrumb(elgg_echo('slider'));

// Count Total pages
$slider_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'slider', 'order_by' => 'time_created desc', 'count' => true));
if ($slider_count > 0) {
	$title .= " ($slider_count)";
}

// MENU : slider selector
$content .= '<div class="clearfloat"></div>';
//$content .= elgg_echo('slider:pagescreated', array($slider_count));
//$content .= elgg_view('slider/menu', array('pagetype' => $pagetype));
$content .= '<blockquote style="padding:6px 12px; margin: 1ex 0;">
		<strong><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#slider_instructions\').toggle();">' . elgg_echo('slider:showinstructions') . '</a></strong>
		<div id="slider_instructions" class="elgg-output hidden">' . elgg_echo('slider:instructions') . '</div>
	</blockquote>';

$content .= '<p><a href="' . elgg_get_site_url() . 'slider/edit" class="elgg-button elgg-button-action">' . elgg_echo('slider:add') . '</a></p>';

if ($slider_count > 0) {
	$content .= elgg_list_entities(array('types' => 'object', 'subtypes' => 'slider', 'order_by' => 'time_created desc', 'limit' => 50));
	//$content .= elgg_view('slider/listing');
}


$page = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));

echo elgg_view_page($title, $page);

