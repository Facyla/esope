<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->bookmarks_enable == 'yes') {
	$options = array('type' => 'object', 'subtype' => 'bookmarks', 'container_guid' => $group->guid, 'limit' => 2);
	$count = elgg_get_entities($options + array('count' => true));
	$objects = elgg_get_entities($options);

	$content = '';
	if ($objects) {
		foreach ($objects as $ent) {
			$content .= '<div class="bookmarks">';
				$content .= '<a href="' . $ent->getURL() . '" title="' . $ent->title . '">';
					$image = '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
					$body = '<p>' . elgg_get_excerpt($ent->title, 64) . '</p>';
					$content .= elgg_view_image_block($image, $body);
				$content .= '</a>';
			$content .= '</div>';
		}
	}

	$all_link = elgg_view('output/url', array(
		'href' => "groups/content/$group->guid/bookmarks/all",
		'text' => elgg_echo('theme_inria:sidebar:bookmarks', array($count)). ' &nbsp; <i class="fa fa-angle-right"></i>',
		'is_trusted' => true,
	));

	$new_link = elgg_view('output/url', array(
		'href' => "bookmarks/add/$group->guid",
		'text' => elgg_echo('bookmarks:add'),
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

