<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->thewire_enable == 'yes') {
	$options = array('type' => 'object', 'subtype' => 'thewire', 'container_guid' => $group->guid, 'limit' => 2);
	$count = elgg_get_entities($options + array('count' => true));
	$objects = elgg_get_entities($options);

	$content = '';
	if ($objects) {
		foreach ($objects as $ent) {
			$title = elgg_get_excerpt($ent->description, 140);
			$content .= '<div class="thewire">';
				$content .= '<a href="' . $ent->getURL() . '" title="' . $title . '">';
					//$image = '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
					$image = esope_get_fa_icon($ent, 'tiny');
					$body = '<span class="elgg-river-timestamp">' . elgg_view_friendly_time($ent->time_created) . '</span><br />';
					$body .= '<p>' . elgg_get_excerpt($ent->description, 50) . '</p>';
					$content .= elgg_view_image_block($image, $body);
				$content .= '</a>';
			$content .= '</div>';
		}
	}

	$all_link = elgg_view('output/url', array(
		'href' => "groups/content/$group->guid/thewire/all",
		'text' => elgg_echo('theme_inria:sidebar:thewire', array($count)). ' &nbsp; <i class="fa fa-angle-right"></i>',
		'is_trusted' => true,
	));

	// @TODO : Toggle add form, or return to workspace home ?
	/*
	$new_link = elgg_view('output/url', array(
		//'href' => "thewire/add/$group->guid",
		'href' => "groups/workspace/$group->guid",
		'text' => elgg_echo('theme_inria:thewire:add'),
		'is_trusted' => true,
	));
	*/


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

