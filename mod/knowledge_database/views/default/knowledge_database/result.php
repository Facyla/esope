<?php
$ent = $vars ['entity'];
global $selectors;

$fields = knowledge_database_get_all_kdb_fields();
if ($fields) foreach ($fields as $name) {
	$config = knowledge_database_get_field_config($name);
	$selectors[$name] = $config['params']['options_values'];
}

/*
global $kdb_types, $kdb_themes, $kdb_topics, $kdb_regions, $kdb_countries;
if (!isset($kdb_types)) $kdb_types = knowledge_database_build_options('kdb_type', false);
if (!isset($kdb_topics)) $kdb_topics = knowledge_database_build_options('kdb_topic', false);
if (!isset($kdb_themes)) $kdb_themes = knowledge_database_build_options('kdb_theme', false);
if (!isset($kdb_regions)) $kdb_regions = knowledge_database_build_options('kdb_region', false);
if (!isset($kdb_countries)) $kdb_countries = knowledge_database_build_options('kdb_country', false);
*/


// Image : default icon if no specific icon set
$image = knowledge_database_get_icon($ent, 'medium');

$body .= '<div class="entity_title"><a href="' . $ent->getURL() . '"><h4>' . $ent->title . '</h4></a></div>';

$body .= '<div class="knowledge_database-result-meta">';

switch($ent->getSubtype()) {
	case 'file':
		$body .= '<i class="fa fa-file"></i>';
		break;
	case 'bookmarks':
		$body .= '<i class="fa fa-link"></i>';
		break;
	case 'blog':
		$body .= '<i class="fa fa-file-text-o"></i>';
		break;
	default:
		$body .= elgg_echo($ent->getSubtype());
}
if ($ent->kdb_type) {
	$body .= '<br />';
	if (!is_array($ent->kdb_type)) { $body .= $ent->kdb_type; }
	else foreach ($ent->kdb_type as $type) { $body .= $kdb_types[$type] . ' '; }
	// else foreach ($ent->kdb_type as $type) { $body .= ', ' . $ent->kdb_type; }
}
$body .= '</div>';

$body .= '<div class="elgg-subtext">';
$body .= elgg_view_friendly_time($ent->time_created);
$body .= ' &nbsp; ';



if ($ent->tags) { $body .= elgg_view('output/tags', array('tags' => $ent->tags)); }
$body .= '</div>';

$body .= '<div class="elgg-content">';
if ($ent->briefdescription) {
	$body .= '<p><em>' . elgg_get_excerpt($ent->briefdescription) . '</em></p>';
} else {
	$body .= '<p><em>' . elgg_get_excerpt($ent->description) . '</em></p>';
}
$body .= '</div>';

// Render list element
echo '<li id="elgg-object-' . $ent->guid . '" class="elgg-item">';
echo elgg_view_image_block($image, $body, array());
echo '</li>';

