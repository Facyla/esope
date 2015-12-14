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

$is_html_viewtype = true;
if ((elgg_get_viewtype() == 'rss') || (elgg_get_viewtype() == 'ical')) { $is_html_viewtype = false; }

//elgg_push_breadcrumb(elgg_echo('search'));
elgg_register_title_button();

$query = get_input('q', '');
$query = addslashes($query);
$filter = get_input('filter', '');
$limit = get_input('limit', 12);
if (!in_array($filter, array('recent', 'featured', 'read', 'comments', 'contributions'))) { $filter = 'recent'; }
$category = get_input('category', '');
if ($category == 'all') $category = '';
$actor_type = get_input('actor_type', '');
if ($actor_type == 'all') $actor_type = '';
$lang = get_input('lang', '');
if ($lang == 'all') $lang = '';
$status = get_input('status', '');
if ($status == 'all') $status = '';

$categories = transitions_get_category_opt(null, false);
$category_opt = transitions_get_category_opt(null, true, true, true);
$actortype_opt = transitions_get_actortype_opt(null, true, true);
$lang_opt = transitions_get_lang_opt(null, true, false, true);
$status_opt = array(
		'' => '',
		'all' => elgg_echo('transitions:status:all'),
		'draft' => elgg_echo('status:draft'),
		'published' => elgg_echo('status:published')
	);


// Bookmarklet
//$content .= elgg_view('transitions/sidebar/bookmarklet');

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


/* ADMIN & DEV : use to update project transitions to new format
$ents = elgg_get_entities(array('type' => 'object', 'subtype' => 'transitions', 'limit' => 0));
foreach($ents as $ent) {
	if ($ent->category == 'project') {
		if (!empty($ent->start_date) && empty($ent->start)) {
			$ent->start = date('m/Y', $ent->start_date);
			$ent->start_date = null;
		}
		if (!empty($ent->end_date) && empty($ent->end)) {
			$ent->end = date('m/Y', $ent->end_date);
			$ent->end_date = null;
		}
	}
}
*/


// RECHERCHE ET RESULTATS
//$content .= elgg_view('transitions/search');
$content .= '<div class="transitions-index-search">';
	$content .= '<form method="GET" action="' . elgg_get_site_url() . 'catalogue/" id="transitions-search">';
		
		$content .= '<p>';
		// Fulltext search
		$content .= elgg_view('input/text', array('name' => "q", 'value' => $query, 'placeholder' => elgg_echo('transitions:search:placeholder')));
		//$content .= '<p>' . elgg_view('input/text', array('name' => "q", 'style' => 'width:20em;', 'value' => $query)) . '</p>';
		// Results filter
		$content .= '<label>' . elgg_echo('transitions:filter') . ' ' . elgg_view('forms/transitions/switch_filter', array('value' => $filter)) . '</label>';
		$content .= '</p>';
		
		// Category
		$content .= '<p>';
		$content .= '<label>' . elgg_echo('transitions:category') . ' ' . elgg_view('input/select', array('name' => 'category', 'options_values' => $category_opt, 'value' => $category, 'onChange' => "transitions_toggle_search_fields(this.value);")) . '</label>';
		// conditionnel, ssi catégorie = actor
		$content .= '<label class="transitions-actortype"> &nbsp; ' . elgg_echo('transitions:actortype') . ' ' . elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt, 'value' => $actor_type)) . '</label>';
		// Langue
		$content .= ' &nbsp; <label class="transitions-lang">' . elgg_echo('multilingual:form:lang') . ' ' . elgg_view('input/select', array('name' => 'lang', 'options_values' => $lang_opt, 'value' => $lang)) . '</label>';
		// Status : published / draft
		// @TODO
		if (elgg_is_admin_logged_in()) {
				$content .= ' &nbsp; <label class="transitions-lang">' . elgg_echo('transitions:status') . ' ' . elgg_view('input/select', array('name' => 'status', 'options_values' => $status_opt, 'value' => $status)) . '</label>';
		}
		$content .= '</p>';

		
		//$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('transitions:search:go'))) . '</p>';
		$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('transitions:search'))) . '</p>';
	$content .= '</form>';
	
	$content .= '<div class="transitions-search-menu">';
		$content .= '<a href="' . elgg_get_site_url() . 'catalogue/" class="elgg-button transitions-all">' . elgg_echo('transitions:category:nofilter') . '</a>';
		foreach($categories as $name => $trans_name) {
			$content .= '<a href="' . elgg_get_site_url() . 'catalogue/' . $name . '" class="elgg-button transitions-' . $name . '">' . $trans_name . '</a>';
		}
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	
	$content .= '<script>
		$(document).ready( function() {
			transitions_toggle_search_fields();
			$("option[value=\'\']").attr("disabled", "disabled");
		});
		function transitions_toggle_search_fields(val) {
			//var val = $("select[name=\'category\']").val();
			// Reinit special fields
			$(".transitions-actortype").addClass(\'hidden\');
			if (val == "actor") {
				$(".transitions-actortype").removeClass(\'hidden\');
			}
			return true;
		}
	</script>';

	$content .= '<div class="clearfloat"></div>';


	// Search options
	$search_options = array('types' => 'object', 'subtypes' => 'transitions', 'limit' => $limit, 'list_type' => 'gallery', 'item_class' => 'transitions-item', 'list_class' => "elgg-gallery-transitions", 'count' => true);

	if (!empty($category)) {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'category', 'value' => $category);
	}
	if (($category == 'actor') && !empty($actor_type)) {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'actor_type', 'value' => $actor_type);
	}
	if (!empty($lang)) {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'lang', 'value' => $lang);
	}
	if (!empty($status)) {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'status', 'value' => $status);
	}
	if (!empty($query)) {
		$db_prefix = elgg_get_config('dbprefix');
	
		// Add custom metadata search
		$search_metadata = array('title', 'excerpt', 'description', 'tags', 'tags_contributed');
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
	// Apply filters
	switch($filter) {
		case 'featured':
			$search_options['metadata_name_value_pairs'][] = array('name' => 'featured', 'value' => 'featured');
			break;
		case 'background':
			$search_options['metadata_name_value_pairs'][] = array('name' => 'featured', 'value' => 'background');
			break;
		case 'read';
			$search_options['metadata_name_value_pairs'][] = array('name' => 'views_count', 'value' => '0', 'operand' => '>');
			$search_options['order_by_metadata'] = array('name' => 'views_count', 'direction' => 'DESC', 'as' => 'integer');
			break;
		case 'recent':
		default:
			$search_options['order_by'] = "time_created desc";
	}
	
	/* @TODO : gérer les doublons liés aux traductions, si possible via une clause where spécifique
	 * 
	 * Si pas de traduction => affichage standard
	 * Si traductions :
	 *  - si dispo dans ma langue : en priorité
	 *  - si dispo dans autre langue : langue originale en priorité
	 */
	//$search_options['wheres'][] = "";
	//$search_options['relationship'] = ""; // has_translation / translation_of
	//$search_options['callback'] = "multilingual_entity_row_to_elggstar"; // @TODO : should be applied before getting the entities

	// Add language filter
	// Note : filters content in current language only
	/*
	$lang = get_language();
	$main_lang = multilingual_get_main_language();
	if ($main_lang == $lang) {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'lang', 'value' => array('', $lang), 'operand' => '=');
	} else {
		$search_options['metadata_name_value_pairs'][] = array('name' => 'lang', 'value' => $lang, 'operand' => '=');
	}
	// @TODO et ajouter entités n'ayant pas de traduction dans la langue courante
	//$search_options['wheres'][] = '(1=1) OR (1=1)';
	*/

	// @TODO handle multilingual duplicates and content available in single language (other than current)
	// 
	
	// Perform search
	if (isset($search_options['metadata_name_value_pairs'])) {
		/*
		$count = elgg_get_entities_from_metadata($search_options);
		$catalogue = elgg_list_entities_from_metadata($search_options);
		*/
		$count = elgg_get_entities_from_relationship($search_options);
		$catalogue = elgg_list_entities_from_relationship($search_options);
	} else {
		/*
		$count = elgg_get_entities($search_options);
		$catalogue = elgg_list_entities($search_options);
		*/
		$count = elgg_get_entities_from_relationship($search_options);
		$catalogue = elgg_list_entities_from_relationship($search_options);
	}
	// @TODO use relations to filter duplicates at DB level ?
	// Relationship function wraps also metadata and basic getters
	//$count = elgg_get_entities_from_relationship($search_options);
	//$catalogue = elgg_list_entities_from_relationship($search_options);

	// Search RSS feed
	$rss_url = current_page_url();
	if (substr_count($rss_url, '?')) { $rss_url .= "&view=rss"; } else { $rss_url .= "?view=rss"; }
	$rss_url = elgg_format_url($rss_url);
	$content .= '<span style="float:right; margin-left:0.5em;"> <a href="' . $rss_url . '"><i class="fa fa-rss"></i> ' . elgg_echo('transitions:search:rss') . '</a></span>';

	// Search ICAL feed
	if ($category == 'event') {
		$ical_url = current_page_url();
		if (substr_count($ical_url, '?')) { $ical_url .= "&view=ical"; } else { $ical_url .= "?view=ical"; }
		$ical_url = elgg_format_url($ical_url);
		$content .= '<span style="float:right; margin-left:0.5em;"> <a href="' . $ical_url . '"><i class="fa fa-calendar"></i> ' . elgg_echo('transitions:search:ical') . ' </span>';
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

$content .= '</div>';

// Return only valid content for some view types
if (!$is_html_viewtype) { $content = $catalogue; }



//$content = elgg_view_layout('one_sidebar', array('content' => $content, 'title' => $title, 'sidebar' => $sidebar));
$content = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));
$title = strip_tags($title);
echo elgg_view_page($title, $content);

