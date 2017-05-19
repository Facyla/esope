<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->file_enable == 'yes') {
	$options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $group->guid, 'limit' => 8);
	$count = elgg_get_entities($options + array('count' => true));
	$objects = elgg_get_entities($options);

	$content = '';
	if ($objects) {
		foreach ($objects as $ent) {
			$content .= '<div class="file">';
				$content .= '<a href="' . $ent->getURL() . '" title="' . $ent->title . '">';
				$content .= '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
				$content .= '</a>';
			$content .= '</div>';
		}
	}

	$all_link = elgg_view('output/url', array(
		'href' => "file/group/$group->guid/all",
		'text' => elgg_echo('theme_inria:sidebar:file', array($count)),
		'is_trusted' => true,
	));

	$new_link = elgg_view('output/url', array(
		'href' => "file/add/$group->guid",
		'text' => elgg_echo('file:add'),
		'is_trusted' => true,
	));


	// Break out from iris-sidebar-content and reopen it
	echo '</div><div class="iris-sidebar-content">';
	//echo '<div class="workspace-subtype-header">';
	//	echo $new_link;
		echo '<h3>' . $all_link . '</h3>';
	//echo '</div>';
	echo '<div class="workspace-subtype-content">';
		echo $content;
	echo '</div>';
}

