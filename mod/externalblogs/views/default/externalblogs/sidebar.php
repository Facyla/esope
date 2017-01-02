<?php

// Menu latéral
$sidebar = '';
if (elgg_is_logged_in()) {
	$ownguid =  elgg_get_logged_in_user_guid();
	//$sidebar .= '<h2>Blogs</h2>';
	
	$sidebar .= '<h3><a href="' . elgg_get_site_url() . 'externalblog">' . elgg_echo('externalblogs:all') . '</a></h3>';
	
	// Blogs dont le membre est le propriétaire (owner)
	$owner_externalblogs_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'owner_guid' => $ownguid, 'count' => true));
	$owner_externalblogs = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'owner_guid' => $ownguid, 'limit' => $owner_externalblogs_count));
	// Blogs dont le membre est administrateur
	$blogadmin_externalblogs_count = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'blogadmin_guids', 'value' => $ownguid), 'count' => true));
	$blogadmin_externalblogs = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'blogadmin_guids', 'value' => $ownguid), 'limit' => $blogadmin_externalblogs_count));
	$blogadmin_externalblogs = array_merge($owner_externalblogs, $blogadmin_externalblogs);
	if (sizeof($blogadmin_externalblogs) > 0) {
		$sidebar .= '<br /><h4>' . elgg_echo('externalblogs:mine') . '</h4><ul>';
		foreach ($blogadmin_externalblogs as $ent) {
			if (isset($listed_externablog) && in_array($ent->guid, $listed_externablog)) {
				continue;
			} else {
				$listed_externablog[] = $ent->guid;
			}
			$sidebar .= '<li><a href="' . elgg_get_site_url() . 'externalblog/edit/' . $ent->guid . '">' . elgg_echo('externalblogs:administer', array($ent->title)) . '</a></li>';
		}
		$sidebar .= '</ul>';
	}
	
	// Blogs dont le membre est auteur
	$author_externalblogs_count = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'author_guids', 'value' => $ownguid), 'count' => true));
	$author_externalblogs = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'author_guids', 'value' => $ownguid), 'limit' => $author_externalblogs_count));
	$author_externalblogs = array_merge($blogadmin_externalblogs, $author_externalblogs);
	if (sizeof($author_externalblogs) > 0) {
		$sidebar .= '<br /><h4>' . elgg_echo('externalblogs:mine:author') . '</h4><ul>';
		$listed_externablog = array(); // On réinitialise pour avoir aussi les sites dont on est admin
		foreach ($author_externalblogs as $author_externalblog) {
			if (isset($listed_externablog) && in_array($author_externalblog->guid, $listed_externablog)) { continue; } else { $listed_externablog[] = $author_externalblog->guid; }
			$sidebar .= '<li><a href="' . elgg_get_site_url() . $author_externalblog->blogname . '">&raquo;&nbsp;' . $author_externalblog->title . '</a></li>';
		}
		$sidebar .= '</ul>';
	}
	
	// Blogs auxquels le membre a simplement accès
	$all_externalblogs = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'limit' => 99));
	if (sizeof($all_externalblogs) > 0) {
		$sidebar .= '<br /><h4>' . elgg_echo('externalblogs:others') . '</h4><ul>';
		foreach ($all_externalblogs as $all_externalblog) {
			if (isset($listed_externablog) && in_array($all_externalblog->guid, $listed_externablog)) { continue; } else { $listed_externablog[] = $all_externalblog->guid; }
			$sidebar .= '<li><a href="' . elgg_get_site_url() . $all_externalblog->blogname . '">&raquo;&nbsp;' . $all_externalblog->title . '</a></li>';
		}
		$sidebar .= '</ul>';
	}
	
} else {
	if ($unset_session) $sidebar .= $unset_session;
	$sidebar .= '<h3><a href="' . elgg_get_site_url() . $externalblog->blogname . '">' . $externalblog->title . '</a></h3>';
	$sidebar .= '<blockquote>' . $externalblog->description . '</blockquote>';
	$sidebar .= '<a href="' . elgg_get_site_url() . 'externalblog">&raquo;&nbsp;' . elgg_echo('externalblogs:all') . '</a><br />';
}


echo $sidebar;

