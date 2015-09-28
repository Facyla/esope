<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : this view is designed for inclusion into other views
*/

/*
$pagetype => the cmspage id
$vars['rawcontent'] => no wrapper (no cmspage div around)
$vars['read_more'] => false|nb_chars : if text length > nb_chars, cuts at nb_chars and adds a "Read more" button"

$content .= $cmspage->guid; // who cares ?
$content .= $cmspage->access_id;
// These are for future developments
$content .= $cmspage->container_guid; // should be set as page_owner
$content .= $cmspage->parent_guid; // can be used for vertical links
$content .= $cmspage->sibling_guid; // can be used for horizontal links
// This if for a closer integration with externalblog, as a generic edition tool
$content .= $cmspage->content_type; // Type of content (default = HTML)
$content .= $cmspage->contexts; // Allowed contexts (empty or all => all)
$content .= $cmspage->module; // Load a specific module (use content as intro ? param ?)
$content .= $cmspage->display; // Allow to use own page (not concerned in a view)

$vars['body'] // Templates only : Loads additional content that will be rendered in {{%CONTENT%}}
*/

$pagetype = elgg_extract('pagetype', $vars);
$cmspage = elgg_extract('entity', $vars);

// We need at least entity or pagetype
if (!$pagetype && !$cmspage) { return; }

// Is viewer a page editor ?
$is_editor = false;
if (cmspage_is_editor()) {
	$is_editor = true;
	// Editors can also edit any cmspage - including private ones
	$ia = elgg_set_ignore_access(true);
}

// Get pagetype from entity
if (!$pagetype) { $pagetype = $cmspage->pagetype; }
// Or optional entity from pagetype
if (!$cmspage) { $cmspage = cmspages_get_entity($pagetype); }


echo cmspages_view($pagetype, array('mode' => 'view'), $vars);

// Restore original rights
if ($is_editor) { elgg_set_ignore_access($ia); }


