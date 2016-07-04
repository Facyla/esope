<?php
/**
 * Knowledge Database main index and search page
 * Custom group KDB
 * Main KDB
 * Main KDB in container group
 *
 */

$title = elgg_echo('esope:search:title');
$content = '';

// Get config vars
$container_guid = get_input('container_guid', false);


// Get plugin settings

// Are local (groups) KBD enabled ?
$kdb_group_guids = elgg_get_plugin_setting('enable_groups', 'knowledge_database');
$kdb_group_guids = esope_get_input_array($kdb_group_guids);

// Search fields : do we want group fields *only* ? or merge group + site setting
$merge_site_fields = elgg_get_plugin_setting('enable_merge', 'knowledge_database');
if ($merge_site_fields == 'yes') { $merge_site_fields = true; } else { $merge_site_fields = false; }

// Is site KDB enabled ?
$enable_site = elgg_get_plugin_setting('enable_site', 'knowledge_database');
// Check global search setting (merge ALL site and group fields)
$globalsearch = elgg_get_plugin_setting('globalsearch', 'knowledge_database');

// Is main KDB tied to a specific group ?
$kdb_main_group_guid = elgg_get_plugin_setting('kdb_group', 'knowledge_database');


// Check that we have a valid container
$container = get_entity($container_guid);
//if (!elgg_instanceof($container, 'group') && !elgg_instanceof($container, 'user') && !elgg_instanceof($container, 'site')) {
if (!elgg_instanceof($container, 'group')) {
		$container_guid = false;
	$container = false;
}

// Which KDB should be displayed ?
if ($container_guid && elgg_instanceof($container, 'group') && $kdb_group_guids && in_array($container_guid, $kdb_group_guids)) {
	// Custom KDB group container
	elgg_set_page_owner_guid($container_guid);
	elgg_push_breadcrumb($container->name, $container->getURL());
	// Update publish target to the KDB group
	$publish_guid = $container_guid;
	// Get group fields, merge group+site fields if asked to
	$fields = knowledge_database_get_group_kdb_fields($container_guid, $merge_site_fields);
	// Update page title
	$title = $container->name;
	// Add information block to group interface
	$content .= '<div class="kdb-group-intro">';
		$content .= '<p><em>' . $container->briefdescription . '</em</p>';
		$content .= '<p>' . $container->description . '</p>';
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div><br />';
	// Add search form
	$content .= elgg_view('knowledge_database/search_kdb', array('fields' => $fields, 'container_guid' => $container_guid, 'publish_guid' => $container_guid));
	
} else {
	// Main (site) KDB
	
	// Forward if site KDB is disabled
	if ($enable_site != 'yes') {
		register_error(elgg_echo('knowledge_database:error:sitedisabled'));
		forward();
}

	// Get search fields based on global search setting (site only, or site + all groups fields)
	if ($globalsearch == 'yes') {
		$fields = knowledge_database_get_all_kdb_fields();
	} else {
		$fields = knowledge_database_get_site_kdb_fields();
	}

	// Should KDB be displayed in main group ?
	if ($kdb_main_group_guid) {
		$kdb_main_group = get_entity($kdb_main_group_guid);
		if (elgg_instanceof($kdb_main_group, 'group')) {
			$publish_guid = $kdb_main_group_guid;
			// Main KDB group : global search from container group and interface
			elgg_set_page_owner_guid($kdb_main_group_guid);
			//$title = $container->name;
			// Add information block to group interface (local)
			if ($container_guid == $kdb_main_group_guid) {
				$content .= '<div class="kdb-maingroup-intro">';
					$content .= '<p><em>' . $kdb_main_group->briefdescription . '</em</p>';
					$content .= '<p>' . $kdb_main_group->description . '</p>';
				$content .= '<div class="clearfloat"></div>';
				$content .= '</div>';
				$content .= '<div class="clearfloat"></div><br />';
			}
		}
	}

	// Default publish target to user content if no main group nor valid container is set
	if (!$publish_guid) { $publish_guid = elgg_get_logged_in_user_guid(); }
	
	// Add main KDB search form
	$content .= elgg_view('knowledge_database/search_kdb', array('fields' => $fields, 'publish_guid' => $publish_guid));
}


// Compose page
if (elgg_instanceof($container, 'group') && elgg_is_logged_in()) {
	$body = elgg_view_layout('one_sidebar', array(
		//'filter_context' => 'all',
		'content' => $content,
		'title' => $title,
		//'sidebar' => false,
	));
} else {
	$body = elgg_view_layout('one_column', array(
	//	'filter_context' => 'all',
		'content' => $content,
		'title' => $title,
		'sidebar' => false,
	));
}

elgg_set_context('knowledge_database');

echo elgg_view_page($title, $body);

