<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;

$debug_ts = microtime(TRUE);

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$addparams = array('limit' => $limit, 'offset' => $offset);

// Get form values (only those allowed per profile type)
$search_criteria = uhb_annonces_get_fields('search');


// Accès à la recherche : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
if (!uhb_annonces_can_view()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	forward('annonces');
}


$search_results = '';
$title = elgg_echo('uhb_annonces:search');

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
elgg_push_breadcrumb($title);


// Get fields (for admin or user)
$columns = uhb_annonces_get_fields('results');


// Recherche multicritère : 
// admin ont accès à tout
// Autres = accès seulement dans l'état 'published'
// Filtres personnels à part sur "Mes offres retenues" et "Mes candidatures"
// Recherches sur champs notés RE et RA
// Résultats affichés en tableau triable par colonne
// Champs afffichés : LE et LA (idem liste)


/* UHB Annonces search function, loosely based on Esope search function */

// Nb max de résultats
if ($admin) {
	$max_count = elgg_get_plugin_setting('max_count', 'uhb_annonces');
} else {
	$max_count = elgg_get_plugin_setting('max_count_admin', 'uhb_annonces');
}
if (empty($max_count)) $max_count = 0;

$search_params = array(
		'limit' => get_input('limit', $max_count),
		'offset' => get_input('offset', 0),
		'sort' => get_input('sort', ''),
		'order' => get_input('order', ''),
	);
// Force results limit for non-admins
if (!$admin && $search_params['limit'] > $max_count) { $search_params['limit'] = $max_count; }

// Compute search criteria
foreach ($search_criteria as $criteria) {
	
	if (in_array($criteria, array('workstart', 'followcreation', 'followvalidation', 'followend', 'followinterested', 'followcandidates', 'followreport'))) {
		// Use ranges for dates and some numeric fields
		$min = get_input($criteria.'_min', '');
		$max = get_input($criteria.'_max', '');
		
		// Correct max date to the end of the day (dates only !)
		if (!empty($max) && in_array($criteria, array('workstart', 'followcreation', 'followvalidation', 'followend'))) { $max += 3600*24; }
		
		// Add filters
		if (!empty($min)) $search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $min, 'operand' => '>=', 'case_sensitive' => false);
		if (!empty($max)) $search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $max, 'operand' => '<=', 'case_sensitive' => false);
		
	} else {
		
		$value = get_input($criteria, '');
		// Non admin : annonces publiées seulement
		if (!$admin && ($criteria == 'followstate')) { $value = 'published'; }

		if (!empty($value)) {
			// Non-range fields
			// Non-range fields may be exact match, LIKE match, IN match, or comparison match
			
			// Skip work type filter if not applicable
			//if (($criteria == 'typework') && (get_input('typeoffer') != 'emploi')) { continue; }
			
			// Almost each field has its specific filters
			if ($criteria == 'profilelevel') {
				// profile level have to be numeric !! (years after Bac)
				// But we're also using clustering (1-3, 4-5, 6+)
				if ($value < 4) {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => 4, 'operand' => '<');
				} else if ($value > 5) {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => 5, 'operand' => '>');
				} else {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => 4, 'operand' => '>=');
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => 5, 'operand' => '<=');
				}
			} else if ($criteria == 'structurepostalcode') {
				// Note : use LIKE operand to search by starting CP (departement)
				$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $value.'%', 'operand' => 'LIKE');
			} else if (in_array($criteria, array('structurename', 'structurenaf2008', 'structuresiret'))) {
				// Note : use LIKE operand to search in field content
				$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => "%$value%", 'operand' => 'LIKE');
			} else {
				// Basic search on exact match
				$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $value, 'operand' => '=');
			}
		}
	}
}

// Metadata search : $metadata[name]=value

$result = array();
// show hidden objects - mandatory here to get and display the resul entities
// Note access control is handled by state and profile type
access_show_hidden_entities(true);
elgg_set_ignore_access(true);


// Debug : updating tool for old meta values, and cleaning code
/*
$offers = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'limit' => 0));
$profilelevel_config = elgg_echo('uhb_annonces:profilelevel:values');
elgg_set_plugin_setting('profilelevel', $profilelevel_config, 'uhb_annonces');
elgg_set_plugin_setting('search_profilelevel', $profilelevel_config, 'uhb_annonces');
foreach ($offers as $ent) {
	$t = $ent->typeoffer;
	//if (empty($ent->typeoffer)) { echo "DEL $ent->guid / "; $ent->delete(); }
	if ($ent->profilelevel == 'all') $ent->profilelevel = null;
	if ($ent->profilelevel == 'licence') $ent->profilelevel = 1;
	if ($ent->profilelevel == 'master1') $ent->profilelevel = 4;
	if ($ent->profilelevel == 'master2') $ent->profilelevel = 5;
	if ($ent->profilelevel == 'doctorat') $ent->profilelevel = 6;
}
*/



$debug_ts1 = microtime(TRUE);

// Logic : make the quickest to get either entity rows, or guids and then get entities
$dbprefix = elgg_get_config('dbprefix');
$subtype_id = get_subtype_id('object', 'uhb_offer');

// 1. Build an entity filter entities, and optionally states
$select = $join = $where = '';
$select = "SELECT DISTINCT guid FROM {$dbprefix}entities as e ";
$where = "WHERE e.type = 'object' AND e.subtype = '$subtype_id' ";
// Add optional state filter
$name_id = get_metastring_id('followstate');
$value_id = false;
if ($admin) {
	$value = get_input('followstate');
	if (!empty($value)) { $value_id = get_metastring_id($value); }
} else {
	$value_id = get_metastring_id('published');
}
if ($value_id) {
	$join .= "JOIN {$dbprefix}metadata as md ON e.guid=md.entity_guid ";
	$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
	$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
	$where .= "AND md.name_id = '$name_id' AND md.value_id = '$value_id' ";
}
$query = $select . $join . $where . ';';
$valid_guids = get_data($query);
$entity_filter = array();
foreach ($valid_guids as $row) { $entity_filter[] = $row->guid; }
$guid_filter = "IN (" . implode(',', $entity_filter) . ")";
//$search_results .= '<pre>' . $query . '</pre>'; // debug
//$search_results .= "<br />Ent filter : " . $guid_filter; // debug

$debug_ts2 = microtime(TRUE);


// 2. Now perform additional queries on metadata
// @TODO : perform cascading search to lower the "IN" clause scope at each iteration
// And break when empty
$md_filters = array();
$search_results .= '<pre>' . print_r($search_params['metadata_name_value_pairs'], true) . '</pre>';
foreach($search_params['metadata_name_value_pairs'] as $md_filter) {
	$i++;
	$select = $join = $where = '';
	$name_id = get_metastring_id($md_filter['name']);
	$select = "SELECT DISTINCT md.entity_guid FROM {$dbprefix}metadata as md ";
	$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
	$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
	$where = "WHERE md.entity_guid $guid_filter ";
	switch($md_filter['operand']) {
		case '=':
		case '':
			$where .= "AND msn.string = '{$md_filter['name']}' AND msv.string = '{$md_filter['value']}'";
			break;
		case 'LIKE':
			$where .= "AND msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} '{$md_filter['value']}'";
			break;
		default:
			$where .= "AND msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} {$md_filter['value']}";
	}
	// Add SQL filter
	$md_filters[] = "md.entity_guid IN ($select $join $where)";
}
$result_guids = array();
if ($md_filters) {
	$where = implode(" \nAND ", $md_filters);
	$query = "$select WHERE $where;";
	$valid_results = get_data($query);
	foreach ($valid_results as $row) { $result_guids[] = $row->entity_guid; }
} else {
	$result_guids = $entity_filter;
}
$search_results .= 'Filter MD query : <pre>' . $query . '</pre>';
$search_results .= "<br />Résultats : " . implode(', ', $result_guids);

$debug_ts3 = microtime(TRUE);

// 3. Apply filters on result entities ?
// Limit meta search to valid object types : "SELECT guid FROM {$dbprefix}entities WHERE `type` = 'object' AND `subtype` = {$subtype_id};"
// Get useful properties names and meta ids


// Limit displayed results
$offers_count = count($result_guids);
if (($max_count > 0) && ($offers_count > $max_count)) {
	$result_guids = array_slice($result_guids, $offset, $max_count);
	$search_results .= elgg_echo('uhb_annonces:search:morethanmax', array($offers_count, $max_count));
}

// Now get full entities
$offers = array();
foreach ($result_guids as $guid) { $offers[$guid] = get_entity($guid); }

$debug_ts4 = microtime(TRUE);

$search_results .= "<br />Durée avant recherche : " . round($debug_ts1-$debug_ts, 4);
$search_results .= "<br />Recherche de base : " . round($debug_ts2-$debug_ts1, 4);
$search_results .= "<br />Recherche metadata : " . round($debug_ts3-$debug_ts2, 4);
$search_results .= "<br />Récupération entités : " . round($debug_ts4-$debug_ts3, 4);


// Sortable headers
elgg_load_js('jquery-tablesorter');

$search_results .= '<script type="text/javascript">
$(document).ready(function() {
	var myHeaders = {}
	$("#uhb_annonces-search-results").find(\'.nosort\').each(function (i, e) {
		myHeaders[$(this).index()] = { sorter: false };
	});
	$("#uhb_annonces-search-results").tablesorter({
		theme: \'blue\',
		widgets: ["zebra", "filter"],
		headers: myHeaders,
		widgetOptions : {
			filter_columnFilters : true,
		}
	});
}); 
</script>';

$search_results .= '<table id="uhb_annonces-search-results" class="tablesorter">';
$search_results .= '<thead>';
foreach ($columns as $field) {
	$search_results .= '<th class="header uhb_annonces-header-' . $field . '">' . elgg_echo("uhb_annonces:search:$field") . '</th>';
}
$search_results .= '<th class="header nosort">' . elgg_echo('uhb_annonces:results:actions') . '</th>';
$search_results .= '</thead>';
$search_results .= '<tbody>';
foreach ($offers as $offer) {
	$search_results .= '<tr class="uhb_annonces-result uhb_annonces-result-' . $offer->typeoffer . ' uhb_annonces-result-state-' . $offer->followstate . '">';
	//$search_results .= elgg_view_entity($offer, array('full_view' => false));
	$offer_url = $CONFIG->url . 'annonces/view/' . $offer->guid;
	foreach ($columns as $field) {
		if (in_array($field, array('workstart', 'followcreation', 'followvalidation', 'followend'))) {
			$value = $offer->$field;
			if (!empty($value)) $field_content = date('Y/m/d', $value);
			else $field_content = elgg_echo('uhb_annonces:undefined');
		} else if ($field == 'followstate') {
			$field_content = elgg_echo('uhb_annonces:search:state:' . $offer->$field);
		} else if ($field == 'managervalidated') {
			$field_content = elgg_echo('uhb_annonces:option:' . $offer->$field);
		} else if ($field == 'worklength') {
			$field_content = elgg_echo('uhb_annonces:search:worklength:result', array($offer->$field));
		} else if ($field == 'typeoffer') {
			$field_content = elgg_echo('uhb_annonces:typeoffer:' . $offer->$field);
			if (($offer->typeoffer == 'emploi') && !empty($offer->typework)) {
				$field_content .= ' (' . elgg_echo('uhb_annonces:typework:' . $offer->typework) . ')';
			}
		} else if ($field == 'profilelevel') {
			$field_content = elgg_echo('uhb_annonces:profilelevel:' . $offer->$field);
		} else {
			$field_content = $offer->$field;
		}
		if ($field == 'offerposition') { $field_content = '<a href="' . $offer_url . '" target="_blank">' . $field_content . '</a>'; }
		$search_results .= '<td class="uhb_annonces-result-field-' . $field . '">' . $field_content . '</td>';
	}
	// Actions selon droits : accéder, modifier
	// @TODO autres actions ?
	$search_results .= '<td>';
	$search_results .= '<a href="' . $offer_url . '" target="_blank"><i class="fa fa-eye"></i> ' . elgg_echo('uhb_annonces:results:view') . '</a> ';
	if (uhb_annonces_can_edit_offer($offer)) $search_results .= '<a href="' . $CONFIG->url . 'annonces/edit/' . $offer->guid . '" target="_blank"><i class="fa fa-edit"></i> ' . elgg_echo('uhb_annonces:results:edit') . '</a> ';
	$search_results .= '</td>';
	$search_results .= '</td>';
	$search_results .= '</tr>';
}
$search_results .= '</tbody>';
$search_results .= '</table>';

$search_results .= '<br /><br />';




// Add first layout to have search forms + sidebar, then results in full width
$search_form = elgg_view('uhb_annonces/search');
$sidebar .= elgg_view('uhb_annonces/sidebar');
$search_form = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $search_form, 'sidebar' => $sidebar));
$body = $search_form . $search_results;
// Note : the one_column layout do not have any breadcrumb
//$breadcrumbs = '<div id="uhb-header">' . elgg_view('navigation/breadcrumbs') . '</div>';
//$body = elgg_view_layout('one_colum', array('title' => $title, 'content' => $search_form . $search_results));

// Render the page
echo elgg_view_page($title, $body);

