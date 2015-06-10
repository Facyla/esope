<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : This view is designed to provide a full interface to CMS Pages viewing
*/

/*
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
*/

$pagetype = elgg_extract('pagetype', $vars);
$cmspage = elgg_extract('entity', $vars);
$embed = elgg_extract('embed', $vars);
$noedit = elgg_extract('noedit', $vars);

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


// Check if full page display is allowed - Exit si pas d'affichage pleine page autorisé
if ($cmspage->display == 'no') { return; }
//if ($cmspage->display == 'no') { forward(REFERER); }

// Allow to remove admin links (useful for tinymce templates and content embedding)
$params = array('mode' => 'read', 'embed' => $embed, 'noedit' => $noedit);
echo cmspages_view($pagetype, $params, $vars);

// Restore original rights
if ($is_editor) { elgg_set_ignore_access($ia); }


