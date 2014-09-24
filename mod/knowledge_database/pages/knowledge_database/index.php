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



// All KDB fields
$fields = knowledge_database_get_all_kdb_fields();

// KDB group
$container_guid = get_input('container_guid', false);
if ($container_guid) {
	if ($container = get_entity($container_guid)) {
		// We are asked to render in, or at least for a specific group
		$publish_guid = $container_guid;
		// default : act as if we want site KDB (if enabled), and keep guid for publishing only
		// Check if it corresponds to an existing KDB group
			$kdb_group_guids = elgg_get_plugin_setting('enable_groups', 'knowledge_database');
			if ($kdb_group_guids) {
				$kdb_group_guids = esope_get_input_array($kdb_group_guids);
				if (in_array($container_guid, $kdb_group_guids)) {
					// If we are in a real KDB group, adapt filters and content
					$container_guid = $publish_guid;
					// Do we want group fields *only* ?
					if (elgg_get_plugin_setting('enable_merge', 'knowledge_database') != 'yes') {
						$fields = knowledge_database_get_group_kdb_fields($container_guid);
					}
				} else $container_guid = false;
			} else $container_guid = false;
	} else {
		$container_guid = false;
	}
}

// No container : check that site KDB is enabled
if (!$container_guid) {
	// Is site KDB enabled ?
	if (elgg_get_plugin_setting('enable_site', 'knowledge_database') != 'yes') {
		register_error("Knowledge Database is not enabled for the whole site.");
		forward();
	}
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

