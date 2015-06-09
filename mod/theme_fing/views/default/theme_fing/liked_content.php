<?php
/**
 * List liked content, using various sort criteria and filtering options
 *
 */

$content = '';

$ts_lower = (int) elgg_extract("ts_lower", $vars, false);
$ts_upper = (int) elgg_extract("ts_upper", $vars, false);
$sortby = elgg_extract('sortby', $vars, 'latest');
$order = elgg_extract('order', $vars, 'DESC');
$full = elgg_extract('full_view', $vars, false);
$container_guid = elgg_extract('container_guid', $vars, false);


// Set selection criteria
$options['annotation_names'] = array('likes');
$options['limit'] = elgg_extract('limit', $vars, 5);

// Use container only if set
if ($container_guid) { $options['annotation_owner_guids'] = $container_guid; }

// @TODO : Add timesframe filtering, but let's check first if we have this information !! (we should check when it has been liked, not the publication date...)
// Note : les likes conservent la date et l'auteur du like
// $sql .= " AND r.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval
// 'wheres' => "l.time_created BETWEEN " . $ts_lower . " AND " . $ts_upper; // filter interval

$dbprefix = elgg_get_config('dbprefix');
if ($sortby == 'popular') {
	$likes_metastring = get_metastring_id('likes');
	$options['selects'] = array("(SELECT count(distinct l.id) FROM {$dbprefix}annotations l WHERE l.name_id = $likes_metastring AND l.entity_guid = e.guid) AS likes");
	$options['order_by'] = 'likes DESC';
	if ($order == 'DESC') $options['order_by'] = 'likes ASC';
} else if ($sortby == 'latest') {
	$options['joins'] = "JOIN {$dbprefix}annotations as l on l.entity_guid = e.guid";
	$options['order_by'] = 'l.time_created DESC';
	if ($order == 'ASC') $options['order_by'] = 'l.time_created ASC';
}


$likes = elgg_get_entities_from_annotations($options);
if ($likes) {
	$content .= '<ul class="elgg-list elgg-list-river elgg-river">';
	
	foreach ($likes as $ent) {
		$ent_url = $ent->getURL();
		$body = '';
		
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
		$image = "<a href='" . $ent_url . "'><img src='" . $image_url . "' /></a>";
		
		$ent_title = $ent->title;
		if (empty($ent_title)) $ent_title = $ent->name;
		if (empty($ent_title)) $ent_title = $ent->description;
		$body .= "<strong><a href='" . $ent_url . "'>" . $ent_title . "</a></strong>";
		$body .= '<div class="elgg-subtext"><em>' . $likes_string . '</em></div>';
		//$body .= elgg_get_excerpt($ent->description);
		
		$content .= '<li class="elgg-item">' . elgg_view_image_block($image, $body) . '</li>';
	}
	
	$content .= '</ul>';
}

echo $content;

