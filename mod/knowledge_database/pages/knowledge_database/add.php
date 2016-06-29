<?php
/**
 * Knowledge Database add new content page
 *
 */
$url = elgg_get_site_url();

$title = elgg_echo('esope:search:title');
$content = '';

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('knowledge_database'));

// Everything happens in a KDB group - must be set and valid
$kdb_group_guid = elgg_get_plugin_setting('kdb_group', 'knowledge_database');
if ($kdb_group_guid) {
	$kdb_group = get_entity($kdb_group_guid);
	if (elgg_instanceof($kdb_group, 'group')) {
		$title = $kdb_group->name;
		$content .= '<div style="border:1px solid #2195B1; margin:10px; padding:10px;">
			<p><em>' . $kdb_group->briefdescription . '</em</p>
			<p>' . $kdb_group->description . '</p>
			</div>';
		
		$content .= '<h2>Add a new ressource</h2>';
		$content .= '<ul id="knowledge_database-kdb-add">';
		$content .= '<li><a href="' . $url . 'file/add/' . $kdb_group_guid . '"><i class="fa fa-file"></i><br />Upload a file document</a></li>';
		$content .= '<li><a href="' . $url . 'bookmarks/add/' . $kdb_group_guid . '"><i class="fa fa-link"></i><br />Publish a link to a web ressource</a></li>';
		$content .= '<li><a href="' . $url . 'event_calendar/add/' . $kdb_group_guid . '"><i class="fa fa-calendar"></i><br />Announce an event in the calendar</a></li>';
		$content .= '<li><a href="' . $url . 'blog/add/' . $kdb_group_guid . '"><i class="fa fa-book"></i> <i class="fa fa-code"></i> <i class="fa fa-video-camera"></i><br />Publish text or embed web content</a></li>';
		$content .= '</ul>';

	} else  {
		register_error("Something's wrong with the Knowledge Database group, please contact the site administrator !");
	}
}

$body = elgg_view_layout('one_column', array(
//	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

echo elgg_view_page($title, $body);

