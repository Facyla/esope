<?php
// Articles les plus likés
// This view is meant to render liked content, using various criteria, such as popularity, normal or reverse order, and by using a timeframe

$ts_lower = (int) elgg_extract("ts_lower", $vars);
$ts_upper = (int) elgg_extract("ts_upper", $vars);
$order = elgg_extract('order', $vars, 'ASC');

// Set selection criteria
$options['annotation_names'] = array('likes');
$options['limit'] = 5;

$dbprefix = elgg_get_config('dbprefix');
$likes_metastring = get_metastring_id('likes');
$options['selects'] = array("(SELECT count(distinct l.id) FROM {$dbprefix}annotations l WHERE l.name_id = $likes_metastring AND l.entity_guid = e.guid) AS likes");

// Add timesframe filtering : we check when it has been liked, not the publication date...
// Note : les likes conservent la date et l'auteur du like
$sql .= " AND l.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval

$options['order_by'] = 'likes DESC';

$likes = elgg_get_entities_from_annotations($options);
if ($likes) {
	
	$title = elgg_echo("theme_fing:digest:likes");
	$latest_likes = '<div id="digest-likes">';
	
	foreach ($likes as $ent) {
		$ent_url = $ent->getURL();
		
		$latest_likes .= '<div class="digest-blog">';
		
		$num_of_likes = likes_count($ent);
		// display the number of likes
		if ($num_of_likes == 1) {
			$likes_string = elgg_echo('theme_fing:userlikedthis', array($num_of_likes));
		} else {
			$likes_string = elgg_echo('theme_fing:userslikedthis', array($num_of_likes));
		}
		
		$image_url = '';
		if ($ent->icontime) { $image_url = $ent->getIconURL("small"); }
		if (empty($image_url) || strpos($image_url, 'graphics/icons/default')) {
			if ($container = $ent->getOwnerEntity()) $image_url = $container->getIconURL('small');
		}
		
		$latest_likes .=  '<span style="">' . $likes_string . '</span>';
		
		$latest_likes .= "<a href='" . $ent_url . "'><img src='" . $image_url . "' /></a>";
		$latest_likes .= "<span>";
		
		$ent_title = $ent->title;
		if (empty($ent_title)) $ent_title = $ent->name;
		if (empty($ent_title)) $ent_title = $ent->description;
		$latest_likes .= "<h4><a href='" . $ent_url . "'>" . $ent_title . "</a></h4>";
		$latest_likes .= elgg_get_excerpt($ent->description);
		$latest_likes .= '</span>';
		
		$latest_likes .= '</div>';
	}
	$latest_likes .= '</div>';
	
	echo elgg_view_module("digest", $title, $latest_likes);
}

