<?php
// Add content block

$content = '<div class="knowledge_database-add-ressources">';

$content .= '<h3>' . elgg_echo('knowledge_database:addressource') . '</h3>';

if (elgg_is_logged_in()) {
	
	$publish_guid = elgg_extract('publish_guid', $vars);
	if (!$publish_guid) { $publish_guid = elgg_get_logged_in_user_guid(); }
	if ($publish_entity = get_entity($publish_guid)) {
		$content .= '<ul id="maghrenov-kdb-add">';
		
		if (in_array('file', $vars['subtypes'])) {
			$content .= '<li><a href="' . $CONFIG->url . 'file/add/' . $publish_guid . '"><i class="fa fa-file"></i><br />' . elgg_echo('knowledge_database:addfile') . '</a></li>';
		}
		if (in_array('bookmarks', $vars['subtypes'])) {
			$content .= '<li><a href="' . $CONFIG->url . 'bookmarks/add/' . $publish_guid . '"><i class="fa fa-link"></i><br />' . elgg_echo('knowledge_database:addbookmark') . '</a></li>';
		}
		if (in_array('blog', $vars['subtypes'])) {
			$content .= '<li><a href="' . $CONFIG->url . 'blog/add/' . $publish_guid . '"><i class="fa fa-file-text-o"></i><br />' . elgg_echo('knowledge_database:addblog') . '</a></li>';
		}
		// @TODO : check link and icon
		if (in_array('event_calendar', $vars['subtypes'])) {
			$content .= '<li><a href="' . $CONFIG->url . 'event_calendar/add/' . $publish_guid . '"><i class="fa fa-calendar"></i><br />' . elgg_echo('knowledge_database:addevent') . '</a></li>';
		}
		if (in_array('pages', $vars['subtypes'])) {
			$content .= '<li><a href="' . $CONFIG->url . 'pages/add/' . $publish_guid . '"><i class="fa fa-file-text-o"></i><br />' . elgg_echo('knowledge_database:addpage') . '</a></li>';
		}
		
		$content .= '</ul>';
	}
	
} else {
	$content = '<h3>' . elgg_echo('knowledge_database:contribute') . '</h3>';
}

$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

echo $content;


