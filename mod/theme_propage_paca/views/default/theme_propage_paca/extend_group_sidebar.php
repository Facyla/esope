<?php


// Groupes du Pôle : s'affiche si Pôle
// Affiche le ou les Pôles de référence si on est dans un groupe de Pôle
/*
$poles = $group->poles_rh;
if (theme_afparh_is_pole($group)) && !empty($poles) && !is_array($poles)) {
	// Groupes du Pôle
	$title = elgg_echo('theme_afparh:pole:groups');
	$content = '';
	// Get and list groups
	$params = array('type' => 'group', 'limit' => 0, 'metadata_name_value_pairs' => array('name' => 'poles_rh', 'value' => $poles, 'case_sensitive' => false, 'full_view' => false));
	$groups = elgg_get_entities_from_metadata($params);
	$group_guids = array();
	foreach ($groups as $ent) {
		if (theme_afparh_is_pole($group)) { continue; }
		$group_guids[] = $ent->guid;
		$img = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL('small') . '" /></a>';
		$text = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '">' . $ent->name . '</a><br /><q>' . $ent->briefdescription . '</q>';
		$content .= elgg_view_image_block($img, $text);
	}
	
} else if (!empty($poles)) {
	// Pôle(s) de référence du groupe
	if (!is_array($poles)) { $poles = array($poles); }
	$content = '';
	$title = elgg_echo('theme_afparh:group:pole');
	foreach ($poles as $pole) {
		$group_guid = elgg_get_plugin_setting("{$pole}group_guid", 'theme_afparh');
		if ($ent = get_entity($group_guid)) {
			$img = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL('small') . '" /></a>';
			$text = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '">' . $ent->name . '</a><br /><q>' . $ent->briefdescription . '</q>';
			$content .= elgg_view_image_block($img, $text);
		}
	}
	
}
echo elgg_view_module('aside', $title, $content);
*/

$title = elgg_echo('theme_afparh:ateliers:future');
$content = elgg_view('theme_afparh/ateliers');
echo elgg_view_module('aside', $title, $content);


