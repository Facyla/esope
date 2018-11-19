<?php
/**
* Elgg CMS pages menu
* 
* @package ElggCMSpages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.net/
* 
*/

$url = elgg_get_site_url() . 'cmspages';
$full_url = current_page_url();

$access_opt = array(
	'none' => elgg_echo('cmspages:access_id:none'), 
	ACCESS_PUBLIC => elgg_echo('PUBLIC'), 
	ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'), 
	ACCESS_PRIVATE => elgg_echo('PRIVATE'), 
	//ACCESS_DEFAULT => elgg_echo('default_access:label'), //("accès par défaut")
);

$status_opt = array('' => elgg_echo('cmspages:status:none'), 'published' => elgg_echo('cmspages:status:published'), 'draft' => elgg_echo('cmspages:status:notpublished'));

$content_type_opt = array('' => elgg_echo('cmspages:content_type:none'), 'editor' => elgg_echo('cmspages:type:editor'), 'module' => elgg_echo('cmspages:type:module'), 'template' => elgg_echo('cmspages:type:template'));

$sort_opt = array('' => elgg_echo('cmspages:sort:none'), 'latest' => elgg_echo('cmspages:sort:latest'), 'alpha' => elgg_echo('cmspages:sort:alpha'));

// Search filters
$title = get_input('title');
$status = get_input('status');
$access_id = get_input('access_id');
$content_type = get_input('content_type');
$sort = get_input('sort', 'latest');

$options = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created desc', 'limit' => 0);
if ($status == 'draft') {
	$access_id = "0";
} else if ($status == 'published') {
	$options['wheres'][] = "(e.access_id <> 0)";
}
if (!empty($access_id) && ($access_id != 'none')) { $options['wheres'][] = "(e.access_id = $access_id)"; }
if (!empty($content_type)) {
	if ($content_type == 'editor') {
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => 'module', 'operand' => '<>');
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => 'template', 'operand' => '<>');
	} else {
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => $content_type);
	}
}
if (!empty($title)) { $options['metadata_name_value_pairs'][] = array('name' => 'pagetitle', 'value' => "%$title%", 'operand' => 'LIKE'); }
//echo '<pre>' . print_r($options, true) . '</pre>';

// Get cmspages
if (!empty($options['metadata_name_value_pairs'])) $cmspages = elgg_get_entities_from_metadata($options);
else $cmspages = elgg_get_entities($options);

if ($cmspages) {
	$edit_url = elgg_get_site_url() . 'cmspages/edit/';
	// @TODO Filtrer par content_type, access_id, et regrouper par rubrique le cas échéant + organiser page parentes/enfant
	
	// Tri des pages : dernières, alpha
	switch($sort) {
		case 'alpha':
			// Tri alphabétique des pages (sur la base du pagetype)
			usort($cmspages, create_function('$a,$b', 'return strcmp($a->pagetype,$b->pagetype);'));
			break;
		case 'latest':
		default:
	}

	// Build select menu - Construit la liste, et détermine au passage si la page existe ou non
	$cmspages_content = '';
	foreach ($cmspages as $ent) {
		// Correct old URL pagetypes
		if (strpos($ent->pagetype, '_')) {
			$reload_marker = true;
			$ent->pagetype = str_replace('_', '-', $ent->pagetype);
		}
		if ($reload_marker) { register_error(elgg_echo('cmspages:error:updatedpagetypes')); }
		
		//$ent->delete(); // DEBUG/TEST : uncomment and run cmspages menu once to clean delete all cmspages (appears on page reload) - don't forget to comment again !
	
		// Useful infos
		$cmspages_content .= '<li class="cmspages-item cmspages-item-' . $ent->content_type . '" id="cmspages-' . $ent->guid . '">';
		
		// Statut et visibilité
		//$cmspages_content .= '<span style="float:right;">' . elgg_view('output/access', array('entity' => $ent)) . '</span>';
		$cmspages_content .= '<span style="float:right; min-width:20ex;">';
			$cmspages_content .= elgg_view('output/access', array('entity' => $ent, 'hide_text' => true)) . $access_opt[$ent->access_id];
		$cmspages_content .= '</span>';
		// Statut = Publié ou Brouillon
		$cmspages_content .= '<span style="float:right; margin-right:2ex;">';
			if ($cmspage->access_id === 0) {
				$cmspages_content .= '<span class="cmspages-unpublished">' . elgg_echo('cmspages:status:notpublished') . '</span>';
			} else {
				$cmspages_content .= '<span class="cmspages-published">' . elgg_echo('cmspages:status:published') . '</span>';
			}
		$cmspages_content .= '</span>';
		
		$cmspages_content .= '<span class="cmspages-content_type">' . elgg_echo('cmspages:type:' . $ent->content_type) . '</span>';
		
		$cmspages_content .= '<a href="' . $edit_url . $ent->pagetype . '">';
		if (!empty($ent->pagetitle)) $cmspages_content .= $ent->pagetitle . ' (' . $ent->pagetype . ')';
		else $cmspages_content .= '(' . $ent->pagetype . ')';
		$cmspages_content .= '</a>';
		
		if (!empty($ent->display)) $cmspages_content .= ', display = ' . $ent->display;
		
		$cmspages_content .= '<span class="elgg-subtext">';
		$cmspages_content .= ' &nbsp; ' . elgg_echo('cmspages:created', array(elgg_get_friendly_time($ent->time_created)));
		if ($ent->time_updated - $ent->time_created > 3600) $cmspages_content .= ', ' . elgg_echo('cmspages:updated', array(elgg_get_friendly_time($ent->time_updated)));
		$cmspages_content .= '</span>';
		
		$cmspages_content .= '</li>';
	}
	$cmspages_content = '<ul>' . $cmspages_content . '<ul>';
} else {
	$cmspages_content = '<p><em>' . elgg_echo('cmspages:none') . '</em></p>';
}

// New page add form
$addpage_content = '';
$addpage_content .= '<div style="float:left; 45%; min-width:200ox;">';
$addpage_content .= '<h3>' . elgg_echo('cmspages:page:new') . '</h3>';
$addpage_content .= '<form action="' . elgg_get_site_url() . 'cmspages/edit/" name="new_cmspage" id="cmspages-form-new">';
$addpage_content .= '<label>' . elgg_view('input/text', array('name' => 'title', 'placeholder' => elgg_echo('cmspages:page:new:name'), 'style' => "width:50ex; max-width:100%;")) . '</label>';
$addpage_content .= elgg_view('input/submit', array('class' => "elgg-button elgg-button-submit", 'value' => elgg_echo('create'), 'style' => "float:none;"));
$addpage_content .= '</form>';
$addpage_content .= '</div>';

// Search page form
$search_content = '';
$search_content .= '<div style="float:right; width:45%; min-width:200px;">';
$search_content .= '<h3>' . elgg_echo('cmspages:pageselect:filter') . '</h3>';
$search_content .= '<form name="cmspage-search" id="cmspages-form-search">';
// Page name or title
$search_content .= '<p><label>' . elgg_view('input/text', array('name' => 'title', 'value' => $title, 'placeholder' => elgg_echo('cmspages:search:nameortitle'))) . '</label></p>';
// Content type
$search_content .= '<p><label>' . elgg_echo('cmspages:filter:content_type') . elgg_view('input/dropdown', array('name' => 'content_type', 'value' => $content_type, 'options_values' => $content_type_opt)) . '</label></p>';
// Published/draft
$search_content .= '<p><label>' . elgg_echo('cmspages:filter:status') . elgg_view('input/dropdown', array('name' => 'status', 'value' => $status, 'options_values' => $status_opt)) . '</label></p>';
// Access
$search_content .= '<p><label>' . elgg_echo('cmspages:filter:access_id') . elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id, 'options_values' => $access_opt)) . '</label></p>';
// Sort
$search_content .= '<p><label>' . elgg_echo('cmspages:filter:sort') . elgg_view('input/dropdown', array('name' => 'sort', 'value' => $sort, 'options_values' => $sort_opt)) . '</label></p>';
$search_content .= '<input type="submit" class="elgg-button elgg-button-submit" value="' . elgg_echo('search') . '" />';
$search_content .= '</form>';
$search_content .= '</div>';
$search_content .= '<div class="clearfloat"></div><br />';



// Results listing
$results_content = '';
$results_content .= '<h3>' . elgg_echo('cmspages:pageselect') . '</h3>';
$results_content .= '<div class="cmspages-search-filter">';
if (($full_url == "$url") || ($full_url == "$url?")) {
	$results_content .= '<a href="?" class="elgg-selected">' . elgg_echo('cmspages:filter:all') . '</a>';
} else {
	$results_content .= '<a href="?">' . elgg_echo('cmspages:filter:all') . '</a>';
}
if ($full_url == "$url?status=published") {
	$results_content .= '<a href="?status=published" class="elgg-selected">' . elgg_echo('cmspages:status:published') . '</a>';
} else {
	$results_content .= '<a href="?status=published">' . elgg_echo('cmspages:status:published') . '</a>';
}
if ($full_url == "$url?sort=latest") {
	$results_content .= '<a href="?sort=latest" class="elgg-selected">' . elgg_echo('cmspages:sort:latest') . '</a>';
} else {
	$results_content .= '<a href="?sort=latest">' . elgg_echo('cmspages:sort:latest') . '</a>';
}
if ($full_url == "$url?content_type=page") {
	$results_content .= '<a href="?content_type=page" class="elgg-selected">' . elgg_echo('cmspages:type:editor') . '</a>';
} else {
	$results_content .= '<a href="?content_type=page">' . elgg_echo('cmspages:type:editor') . '</a>';
}
if ($full_url == "$url?content_type=module") {
	$results_content .= '<a href="?content_type=module" class="elgg-selected">' . elgg_echo('cmspages:type:module') . '</a>';
} else {
	$results_content .= '<a href="?content_type=module">' . elgg_echo('cmspages:type:module') . '</a>';
}
if ($full_url == "$url?content_type=template") {
	$results_content .= '<a href="?content_type=template" class="elgg-selected">' . elgg_echo('cmspages:type:template') . '</a>';
} else {
	$results_content .= '<a href="?content_type=template">' . elgg_echo('cmspages:type:template') . '</a>';
}
$results_content .= '</div>';
$results_content .= '<div class="clearfloat"></div><br />';
$results_content .= $cmspages_content;
$results_content .= '<br />';



// RENDU DE LA PAGE
echo '<div class="elgg-sidebar">' . $search_content . '</div>';
echo '<div class="elgg-main elgg-body">' . $addpage_content . '<div class="clearfloat"></div><br />' . $results_content . '</div>';
echo '<div class="clearfloat"></div><br />';

