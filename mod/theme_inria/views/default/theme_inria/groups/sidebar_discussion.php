<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->forum_enable == 'yes') {
	$options = array('type' => 'object', 'subtype' => 'groupforumtopic', 'container_guid' => $group->guid, 'limit' => 2);
	$count = elgg_get_entities($options + array('count' => true));
	$objects = elgg_get_entities($options);

	$content = '';
	if ($objects) {
		foreach ($objects as $ent) {
			$content .= '<div class="discussion">';
				$content .= '<a href="' . $ent->getURL() . '" title="' . $ent->title . '">';
					//$image = '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
					$image = esope_get_fa_icon($ent, 'tiny');
					$body = '<p>' . elgg_get_excerpt($ent->title, 140) . '</p>';
					$content .= elgg_view_image_block($image, $body);
				$content .= '</a>';
			$content .= '</div>';
		}
	}

	$all_link = elgg_view('output/url', array(
		'href' => "groups/content/$group->guid/discussion/all",
		'text' => elgg_echo('theme_inria:sidebar:discussion', array($count)). ' &nbsp; <i class="fa fa-angle-right"></i>',
		'is_trusted' => true,
	));

	$new_link = elgg_view('output/url', array(
		'href' => "discussion/add/$group->guid",
		'text' => elgg_echo('discussion:add'),
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

