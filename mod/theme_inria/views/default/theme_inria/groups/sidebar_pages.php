<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->pages_enable == 'yes') {
	$options = array('type' => 'object', 'subtype' => array('page', 'page_top'), 'container_guid' => $group->guid, 'limit' => 2);
	$count = elgg_get_entities($options + array('count' => true));
	$objects = elgg_get_entities($options);

	$content = '';
	if ($objects) {
		foreach ($objects as $ent) {
			$content .= '<div class="pages">';
				$content .= '<a href="' . $ent->getURL() . '" title="' . $ent->title . '">';
					$image = '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
					$body = '<p>' . elgg_get_excerpt($ent->title, 64) . '</p>';
					$content .= elgg_view_image_block($image, $body);
				$content .= '</a>';
			$content .= '</div>';
		}
	}

	$all_link = elgg_view('output/url', array(
		'href' => "pages/group/$group->guid/all",
		'text' => elgg_echo('theme_inria:sidebar:pages', array($count)),
		'is_trusted' => true,
	));

	$new_link = elgg_view('output/url', array(
		'href' => "pages/add/$group->guid",
		'text' => elgg_echo('pages:add'),
		'is_trusted' => true,
	));


	//echo '<div class="workspace-subtype-header">';
	//	echo $new_link;
		echo '<h3>' . $all_link . '</h3>';
	//echo '</div>';
	echo '<div class="workspace-subtype-content">';
		echo $content;
	echo '</div>';
}

