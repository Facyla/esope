<?php
/**
 * Transitions² public homepage
 *
 */

// no RSS feed with a "widget" front page
/*
global $autofeed;
$autofeed = FALSE;
*/


$content = '';
$title = elgg_echo('transitions:index');
$sidebar = '';

//elgg_push_breadcrumb(elgg_echo('search'));
elgg_register_title_button();

$category = get_input('category', '');
if ($category == 'all') $category = '';
$actor_type = get_input('actor_type', '');
if ($actor_type == 'all') $actor_type = '';
$query = get_input('q', '');

$categories = transitions_get_category_opt(null, false);
$category_opt = transitions_get_category_opt(null, true, true);
$actortype_opt = transitions_get_actortype_opt(null, true);
$lang_opt = transitions_get_lang_opt(null, true);


// Form de contribution rapide
/*
$quickform = '<div class="transitions-gallery-quickform">';
$quickform .= '<div class="transitions-gallery-item">';
$quickform .= '<p>Racontez-nous votre transition, partagez une ressource pour le catalogue !</p>';
if (elgg_is_logged_in()) {
	// Quick contribution form
	$quickform .= elgg_view_form('transitions/quickform');
} else {
	$quickform .= '<a href="' . elgg_get_site_url() . 'register" class="elgg-button elgg-button-action">Contribuez</a>';
}
$quickform .= '</div>';
$quickform .= '</div>';
*/


// RECHERCHE
//$content .= elgg_view('transitions/search');
$content .= '<div class="transitions-search-menu">';
	$content .= '<a href="' . elgg_get_site_url() . 'transitions/" class="elgg-button transitions-all">' . elgg_echo('transitions:category:nofilter') . '</a>';
	foreach($categories as $name => $trans_name) {
		$content .= '<a href="' . elgg_get_site_url() . 'transitions/' . $name . '" class="elgg-button transitions-' . $name . '">' . $trans_name . '</a>';
	}
	$content .= '<div class="clearfloat"></div><br />';
	$content .= '<form method="POST" action="' . elgg_get_site_url() . 'transitions/" id="transitions-search">';
		$content .= '<label>' . elgg_echo('transitions:category') . ' ' . elgg_view('input/select', array('name' => 'category', 'options_values' => $category_opt, 'value' => $category)) . '</label>';
		$content .= ' &nbsp; ';
		$content .= '<label>' . elgg_echo('transitions:actortype') . ' ' . elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt, 'value' => $actor_type)) . '</label>';
		$content .= '<br />';
		$content .= '<br />';
		$content .= elgg_view('input/text', array('name' => "q", 'style' => 'width:20em;', 'value' => $query));
		$content .= elgg_view('input/submit', array('value' => "Rechercher"));
	$content .= '</form>';
$content .= '</div>';

$content .= '<div class="clearfloat"></div><br /><br />';


// Search options
$search_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => 10, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'count' => true);

if (!empty($category)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'category', 'value' => $category);
}
if (!empty($actor_type)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'actor_type', 'value' => $actor_type);
}
if (!empty($query)) {
	$db_prefix = elgg_get_config('dbprefix');
	
	// Add custom metadata search
	$search_metadata = array('excerpt');
	$clauses = _elgg_entities_get_metastrings_options('metadata', array('metadata_names' => $search_metadata));
	$md_where = "(({$clauses['wheres'][0]}) AND msv.string LIKE '%$query%')";
	$search_options['joins'] = $clauses['joins'];
	
	// Add title and description search
	$search_options['joins'][] = "JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid";
	
	$search_options['joins'][] = "JOIN {$db_prefix}metadata md on e.guid = md.entity_guid";
	$search_options['joins'][] = "JOIN {$db_prefix}metastrings msv ON n_table.value_id = msv.id";
		
	$search_options['wheres'][] = "((oe.title LIKE '%$query%') OR (oe.description LIKE '%$query%') OR $md_where)";
	
}

//echo '<pre>' . print_r($search_options, true) . '</pre>'; // debug


// Perfom search
if (isset($search_options['metadata_name_value_pairs'])) {
	$count = elgg_get_entities_from_metadata($search_options);
	$catalogue = elgg_list_entities_from_metadata($search_options);
} else {
	$count = elgg_get_entities($search_options);
	$catalogue = elgg_list_entities($search_options);
}

// Search RSS feed
$rss_url = current_page_url();
if (substr_count($rss_url, '?')) { $rss_url .= "&view=rss"; } else { $rss_url .= "?view=rss"; }
$rss_url = elgg_format_url($rss_url);
$content .= '<span style="float:right;"> <a href="' . $rss_url . '"><i class="fa fa-rss"></i> ' . elgg_echo('transitions:search:rss') . '</a></span>';

// Search ICAL feed
if ($category == 'event') {
	$ical_url = current_page_url();
	if (substr_count($ical_url, '?')) { $ical_url .= "&view=ical"; } else { $ical_url .= "?view=ical"; }
	$ical_url = elgg_format_url($ical_url);
	$content .= '<span style="float:right;"> <a href="' . $ical_url . '"><i class="fa fa-ical"></i> ' . elgg_echo('transitions:search:ical') . ' </span>';
}

if ($count > 1) {
	$content .= '<h3>' . elgg_echo('transitions:search:results', array($count)) . '</h3>';
} else if ($count == 1) {
	$content .= '<h3>' . elgg_echo('transitions:search:result') . '</h3>';
} else {
	$content .= '<h3>' . elgg_echo('transitions:search:noresult') . '</h3>';
}


$content .= '<div class="clearfloat"></div><br />';
$content .= '<div id="transitions">';
$content .= $quickform;
$content .= $catalogue;
$content .= '</div>';

// Return only valid content for some view types
if (elgg_get_viewtype() == 'rss') { $content = $catalogue; }
else if (elgg_get_viewtype() == 'ical') { $content = $catalogue; }


$sidebar = '';
$sidebar .= elgg_view('transitions/sidebar/bookmarklet');
$quickform = elgg_view_form('transitions/quickform');
$sidebar .= elgg_view_module('featured', elgg_echo('transitions:quickform:title'), $quickform);


$content = elgg_view_layout('one_sidebar', array('content' => $content, 'title' => $title, 'sidebar' => $sidebar));

echo elgg_view_page($title, $content);

