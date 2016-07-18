<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('phpoffice:title');

elgg_push_breadcrumb(elgg_echo('phpoffice'), 'phpoffice');
elgg_push_breadcrumb($title);


$sidebar = "";
$content = '';

$content .= '';
$content .= '<p><a href="' . elgg_get_site_url() . 'phpoffice/word">' . elgg_echo('phpoffice:word') . '</a>';
$content .= '<p><a href="' . elgg_get_site_url() . 'phpoffice/presentation">' . elgg_echo('phpoffice:presentation') . '</a>';
$content .= '<p><a href="' . elgg_get_site_url() . 'phpoffice/excel">' . elgg_echo('phpoffice:excel') . '</a>';
$content .= '<p><a href="' . elgg_get_site_url() . 'phpoffice/project">' . elgg_echo('phpoffice:project') . '</a>';



// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

