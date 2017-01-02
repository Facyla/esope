<?php
/**
 * Elgg edit externablog action
 *
 */

$guid = (int) get_input('guid', false);
$access_id = (int) get_input('access_id', 2);
$owner_guid = (int) get_input('owner_id', false);
$title = get_input('title');
$description = get_input('description');
$blogname = get_input('blogname');
$password = get_input('password');
// Templates
$template = get_input('template');
// Custom template
$layout_header = get_input('layout_header', false, false);
$layout_footer = get_input('layout_footer', false, false);
$layout_css = get_input('layout_css', false, false);
// Zones template
$zones_home = get_input('zones_home', false, false);
$zones_home_layout = get_input('zones_home_layout', false, false);
$zones_fullview = get_input('zones_fullview', false, false);
$zones_fullview_layout = get_input('zones_fullview_layout', false, false);
$zones_cmspages = get_input('zones_cmspages', false, false);
$zones_cmspages_layout = get_input('zones_cmspages_layout', false, false);
$zones_category = get_input('zones_category', false, false);
$zones_category_layout = get_input('zones_category_layout', false, false);
$zones_listing = get_input('zones_listing', false, false);
$zones_listing_layout = get_input('zones_listing_layout', false, false);
$zones_css = get_input('zones_css', false, false);

// les auteurs (externalblog_blogadmin)
$blogadmin_guids = get_input('blogadmin_guids');
$blogadmin_guids = string_to_tag_array($blogadmin_guids);
// les auteurs (externalblog_authors)
$author_guids = get_input('author_guids');
$author_guids = string_to_tag_array($author_guids);

// Vérifications préliminaires
// @todo : seulement alphanumérique !!
// Pas d'URL vide pour le blog...
if (strlen($blogname) < 3) { register_error('externablog:emptyblogname'); forward(REFERER); }

// Nouvelle entité ou édition ?
$externalblog = get_entity($guid);
if (!$externalblog) {
	$externalblog = new ElggObject;
	$externalblog->subtype = 'externalblog';
	if ($owner_guid) $externalblog->owner_guid = $owner_guid;
	else $externalblog->owner_guid = elgg_get_logged_in_user_guid();
}

if (!elgg_instanceof($externalblog, 'object', 'externablog')) {
	register_error('externablog:invalidentity');
	forward(REFERER);
}


// editable metadata
$externalblog->access_id = $access_id;
if ($owner_guid) $externalblog->owner_guid = $owner_guid;
$externalblog->container_guid = elgg_get_site_entity()->guid;
$externalblog->blogadmin_guids = $blogadmin_guids;
$externalblog->author_guids = $author_guids;
$externalblog->title = $title;
$externalblog->description = $description;
$externalblog->blogname = $blogname;
$externalblog->password = $password;
$externalblog->template = $template;
if ($layout_header) $externalblog->layout_header = $layout_header;
if ($layout_footer) $externalblog->layout_footer = $layout_footer;
if ($layout_css) $externalblog->layout_css = $layout_css;
if ($zones_home) $externalblog->zones_home = $zones_home;
if ($zones_home_layout) $externalblog->zones_home_layout = $zones_home_layout;
if ($zones_fullview) $externalblog->zones_fullview = $zones_fullview;
if ($zones_fullview_layout) $externalblog->zones_fullview_layout = $zones_fullview_layout;
if ($zones_cmspages) $externalblog->zones_cmspages = $zones_cmspages;
if ($zones_cmspages_layout) $externalblog->zones_cmspages_layout = $zones_cmspages_layout;
if ($zones_category) $externalblog->zones_category = $zones_category;
if ($zones_category_layout) $externalblog->zones_category_layout = $zones_category_layout;
if ($zones_listing) $externalblog->zones_listing = $zones_listing;
if ($zones_listing_layout) $externalblog->zones_listing_layout = $zones_listing_layout;
if ($zones_css) $externalblog->zones_css = $zones_css;

$externalblog->save();


system_message(elgg_echo("externalblog:edited"));

// Forward
//forward(elgg_get_site_url() . 'externalblog');
forward(elgg_get_site_url() . 'externalblog/edit/' . $externalblog->guid);

