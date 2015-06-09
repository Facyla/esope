<?php
/**
 * Maghrenov Knowledge Database public index page
 *
 */
global $CONFIG;

$title = elgg_echo('esope:search:title');
$content = '';

//elgg_pop_breadcrumb();
//elgg_push_breadcrumb(elgg_echo('search'));



// Should we use a specific container ? (site host group or KDB group or publishing group)
$container_guid = get_input('container_guid', false);
// Check we have a valid container
$container = get_entity($container_guid);
if (!elgg_instanceof($container, 'group') && !elgg_instanceof($container, 'user') && !elgg_instanceof($container, 'site')) { $container_guid = false; }
// (valid) Container is at least used to publish in it, so keep it anyway
if ($container_guid) $publish_guid = $container_guid;

// Check merge setting
$enable_merge = elgg_get_plugin_setting('enable_merge', 'knowledge_database');
if ($enable_merge == 'yes') $enable_merge = true; else $enable_merge = false;

// Is site KDB enabled ?
$enable_site = elgg_get_plugin_setting('enable_site', 'knowledge_database');
if ($enable_site == 'yes') {
	// Check global search setting
	$globalsearch = elgg_get_plugin_setting('globalsearch', 'knowledge_database');
	if ($globalsearch == 'yes') {
		$fields = knowledge_database_get_all_kdb_fields();
	} else {
		$fields = knowledge_database_get_site_kdb_fields();
	}
}

// Are KBD groups enabled ?
$kdb_group_guids = elgg_get_plugin_setting('enable_groups', 'knowledge_database');
$kdb_group_guids = esope_get_input_array($kdb_group_guids);
if (empty($kdb_group_guids)) { $container_guid = false; }


// If we are in a KDB group : merge fields if both enabled (and if asked to), use only group fields otherwise
if ($container_guid && $kdb_group_guids) {
	// Check if it corresponds to an existing KDB group
	if (in_array($container_guid, $kdb_group_guids)) {
		// Do we want group fields *only* ?
		$fields = knowledge_database_get_group_kdb_fields($container_guid, $enable_merge);
	} else {
		// Use site KDB so don't filter results
		$container_guid = false;
	}
}

// No valid container : display site KDB if enabled
if (!$container_guid) {
	// Is site KDB enabled ?
	if ($enable_site != 'yes') {
		register_error(elgg_echo('knowledge_database:error:sitedisabled'));
		forward();
	}
	// Get publishing group
	$publish_guid = elgg_get_plugin_setting('kdb_group', 'knowledge_database');
}


// @TODO : differenciate site interface (global) and group interface (local)
if ($container_guid) {
	if (elgg_instanceof($container, 'group')) {
		$title = $container->name;
		$content .= '<div style="border:1px solid #2195B1; margin:10px; padding:10px;">';
		$content .= '<p><em>' . $container->briefdescription . '</em</p>';
		$content .= '<p>' . $container->description . '</p>';
		$content .= '<div class="clearfloat"></div>';
		$content .= '</div>';
		$content .= '<div class="clearfloat"></div><br />';
	}
}

// Add search form
$content .= elgg_view('knowledge_database/search_kdb', array('fields' => $fields, 'container_guid' => $container_guid, 'publish_guid' => $publish_guid));


// Compose page
$body = elgg_view_layout('one_column', array(
//	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

elgg_set_context('knowledge_database');

echo elgg_view_page($title, $body);

