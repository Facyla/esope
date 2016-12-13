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

$debug = true;
if ($debug) $debug_ts = microtime(TRUE);

// Accès à la recherche : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
if (!uhb_annonces_can_view()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	forward('annonces');
}

$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
// Nb max de résultats
if ($admin) {
	$max_count = elgg_get_plugin_setting('max_count', 'uhb_annonces');
} else {
	$max_count = elgg_get_plugin_setting('max_count_admin', 'uhb_annonces');
}
if (empty($max_count)) $max_count = 0;
// Force results limit for non-admins
if (!$admin && ($limit > $max_count)) { $limit = $max_count; }

// Export CSV : admin seulement
$export = false;
if ($admin && (get_input('export') == 'csv')) {
	$export = true;
	// Override default limit + force offset so we get all results
	$limit = 0;
	$offset = 0;
}


$search_results = '';
$title = elgg_echo('uhb_annonces:search');

// Breacrumbs
elgg_push_breadcrumb(elgg_echo('uhb_annonces'), 'annonces');
elgg_push_breadcrumb($title);

// Get form values (only those allowed per profile type)
$search_criteria = uhb_annonces_get_fields('search');

// Get rendered fields (for admin or user)
$columns = uhb_annonces_get_fields('results');


// Recherche multicritère : 
// admin ont accès à tout
// Autres = accès seulement dans l'état 'published'
// Filtres personnels à part sur "Mes offres retenues" et "Mes candidatures"
// Recherches sur champs notés RE et RA
// Résultats affichés en tableau triable par colonne
// Champs afffichés : LE et LA (idem liste)


/* UHB Annonces search function, loosely based on Esope search function */



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
*/
/*
foreach ($offers as $ent) {
	if (!isset($ent->followinterested)) $ent->followinterested = 0;
	if (!isset($ent->followreport)) $ent->followreport = 0;
	if (!isset($ent->followcandidates)) $ent->followcandidates = 0;
	$t = $ent->typeoffer;
	//if (empty($ent->typeoffer)) { echo "DEL $ent->guid / "; $ent->delete(); }
	if ($ent->profilelevel == 'all') $ent->profilelevel = null;
	if ($ent->profilelevel == 'licence') $ent->profilelevel = 1;
	if ($ent->profilelevel == 'master1') $ent->profilelevel = 4;
	if ($ent->profilelevel == 'master2') $ent->profilelevel = 5;
	if ($ent->profilelevel == 'doctorat') $ent->profilelevel = 6;
}
*/

// Compute search criteria
foreach ($search_criteria as $criteria) {
	
	// Creation date can be computed without metadata, so use it
	if ($criteria == 'followcreation') {
		$time_created_min = get_input($criteria.'_min', 0);
		$time_created_max = get_input($criteria.'_max', 0);
		if (!empty($time_created_max)) { $time_created_max += 3600*24; }
		continue;
	}
	
	if (in_array($criteria, array('workstart', 'followvalidation', 'followend', 'followinterested', 'followcandidates', 'followreport'))) {
		// Use ranges for dates and some numeric fields
		$min = get_input($criteria.'_min', '');
		$max = get_input($criteria.'_max', '');
		
		// Correct max date to the end of the day (dates only !)
		if (!empty($max) && in_array($criteria, array('workstart', 'followvalidation', 'followend'))) { $max += 3600*24; }
		
		// Add filters
		if (!empty($min)) $search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $min, 'operand' => '>=', 'case_sensitive' => false);
		if (!empty($max)) $search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'value' => $max, 'operand' => '<=', 'case_sensitive' => false);
		
	} else {
		
		$value = get_input($criteria, '');
		if (!empty($value)) {
			// Non-range fields
			// Non-range fields may be exact match, LIKE match, IN match, or comparison match
			
			// Skip work type filter if not applicable
			//if (($criteria == 'typework') && (get_input('typeoffer') != 'emploi')) { continue; }
			
			// Almost each field has its specific filters
			if ($criteria == 'profilelevel') {
				// Profile level is numeric (years after Bac), + clustering (<4, 4-5, >5)
				if ($value < 4) {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '<', 'value' => 4);
				} else if ($value > 5) {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '>', 'value' => 5);
				} else {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '>=', 'value' => 4);
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '<=', 'value' => 5);
				}
			} else if ($criteria == 'worklength') {
				// Worklength is numeric, + clustering (<3, 3-6, >6)
				if ($value == '0to3') {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '<', 'value' => 3);
				} else if ($value == '3to6') {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '>=', 'value' => 3);
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '>', 'value' => 6);
				} else {
					$search_params['metadata_name_value_pairs'][] = array('name' => $criteria, 'operand' => '>=', 'value' => 6);
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


if ($debug) $debug_ts1 = microtime(TRUE);

// Logic : make the quickest to get either entity rows, or guids and then get entities
$dbprefix = elgg_get_config('dbprefix');
$subtype_id = get_subtype_id('object', 'uhb_offer');

// 1. Build an entity filter entities, and optionally states
$select = $join = $where = '';
$select = "SELECT DISTINCT guid FROM {$dbprefix}entities as e ";
$where = "WHERE e.type = 'object' AND e.subtype = '$subtype_id' ";
// Add creation date filtering if asked to
if (!empty($time_created_min)) { $where .= "AND e.time_created >= $time_created_min "; }
if (!empty($time_created_max)) { $where .= "AND e.time_created <= $time_created_max "; }
// Optional filter for offers created by anonymous
if ($admin) {
	$is_anonymous = get_input('is_anonymous');
	if ($is_anonymous[0] == 'yes') {
		$where .= "AND e.owner_guid = '{$CONFIG->site->guid}'";
	}
}
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
$sql_order = "ORDER BY e.guid DESC ";
$query = "$select $join $where $sql_order;";
$valid_guids = get_data($query);
$entity_filter = array();
$guid_filter = false;
if ($valid_guids) {
	foreach ($valid_guids as $row) { $entity_filter[] = $row->guid; }
	$guid_filter = "IN (" . implode(',', $entity_filter) . ")";
}
if ($debug) {
	$search_results .= '<pre>' . $query . '</pre>'; // debug
	$search_results .= "<br />Ent filter : " . $guid_filter; // debug
	$debug_ts2 = microtime(TRUE);
}


// 2. Now build additional queries using metadata
// @TODO : if there are still memory issues, we may also perform a cascading search to lower the "IN" clause scope at each iteration
$md_filters = array();
// Don't even bother to build filters if no entity matches at this step
if ($guid_filter && $search_params['metadata_name_value_pairs']) {
	foreach($search_params['metadata_name_value_pairs'] as $md_filter) {
		$i++;
		$select = $join = $where = '';
		$name_id = get_metastring_id($md_filter['name']);
		$select = "SELECT DISTINCT md.entity_guid FROM {$dbprefix}metadata as md ";
		$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
		$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
		$where = '';
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
		// Add SQL filter clause
		$md_filters[] = "md.entity_guid IN ($select $join $where)";
	}
} else { $md_filters = false; }

// 3. Get filtered results (apply filters on result entities)
$result_guids = array();
if ($md_filters) {
	$where = "WHERE " . implode(" \nAND ", $md_filters);
	$sql_limit = '';
	// Note : do NOT use limit clause because we want to get all entities (count)
	//if ($limit > 0) { $sql_limit = "LIMIT " . $offset . "," . ($offset + $limit) . " "; }
	// Note : no need to order, as we did it is first query
	//$sql_order = "ORDER BY md.entity_guid DESC ";
	//$query = "$select $where $sql_order $sql_limit;";
	$query = "$select $where;";
	$valid_results = get_data($query);
	foreach ($valid_results as $row) { $result_guids[] = $row->entity_guid; }
} else {
	$result_guids = $entity_filter;
}
if ($debug) {
	$search_results .= '<pre>' . print_r($search_params['metadata_name_value_pairs'], true) . '</pre>';

	$search_results .= 'Filter MD query : <pre>' . $query . '</pre>';
	$search_results .= "<br />Résultats : " . implode(', ', $result_guids);
	$debug_ts3 = microtime(TRUE);
}

// Limit displayed results, except if we want to export
$offers_count = 0;
if ($result_guids) { $offers_count = sizeof($result_guids); }
if (!$export && ($max_count > 0) && ($offers_count > $max_count)) {
	$result_guids = array_slice($result_guids, $offset, $max_count);
	$search_results .= elgg_echo('uhb_annonces:search:morethanmax', array($offers_count, $max_count));
}

// 4. Now get full entities
$offers = array();
foreach ($result_guids as $guid) { $offers[$guid] = get_entity($guid); }

if ($debug) $debug_ts4 = microtime(TRUE);


if ($debug) {
	$search_results .= "<br />Construction des filtres : " . round($debug_ts1-$debug_ts, 4);
	$search_results .= "<br />Recherche de base : " . round($debug_ts2-$debug_ts1, 4);
	$search_results .= "<br />Recherche filtre metadata : " . round($debug_ts3-$debug_ts2, 4);
	$search_results .= "<br />Récupération entités : " . round($debug_ts4-$debug_ts3, 4);
}




// RENDER RESULTS

// CSV EXPORT
if ($export) {
	$debug_ts5 = microtime(TRUE);
	set_time_limit(0);
	$all_fields = uhb_annonces_get_fields();
	$filename = 'offres_' . date('Y-m-d-H-i-s') . '.csv';
	$delimiter = ";";
	
	// Send file using headers for download
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename);

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	
	// Headings
	foreach ($all_fields as $field) {
		$headings[] = elgg_echo("uhb_annonces:object:$field");
	}
	fputcsv($output, $headings, $delimiter);

	// Output the objects
	foreach ($offers as $offer) {
		$row_array = array();
		foreach ($all_fields as $field) {
			$value = array();
			$raw_value = $offer->$field;
			if ($field == 'followcreation') { $raw_value = $offer->time_created; }
			if (!is_array($raw_value)) { $raw_value = array($raw_value); }
			if (in_array($field, array('typeoffer', 'typework', 'structurelegalstatus', 'structureworkforce', 'worktime', 'worktrip', 'managergender', 'managervalidated', 'profileformation', 'profilelevel', 'followstate'))) {
				// Some fields need translation
				foreach($raw_value as $val) {
					$value[] = elgg_echo("uhb_annonces:$field:$val");
				}
			} else if (in_array($field, array('workstart', 'followcreation', 'followvalidation', 'followend'))) {
				// Some need date conversion
				foreach($raw_value as $val) { $value[] = date('Y/m/d', $val); }
			} else if (in_array($field, array('workcomment', 'structuredetails', 'profilecomment', 'followcomments'))) {
				// And some HTML cleaning
				foreach($raw_value as $val) { $value[] = strip_tags($val); }
			} else {
				$value = $raw_value;
			}
			$value = implode("\n", $value);
			$row_array[] = $value;
		}
		// Output the CSV row
		fputcsv($output, (array) $row_array, $delimiter);
	}
	
	$debug_ts6 = microtime(TRUE);
	error_log("Export CSV : " . round($debug_ts6-$debug_ts5, 4));
	
	exit;
}


// TABLE OUTPUT

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

$search_results .= '<p class="uhb_annonces-results-count">' . elgg_echo('uhb_annonces:search:count', array($offers_count)) . '</p>';
$search_results .= '<table id="uhb_annonces-search-results" class="tablesorter">';
// Table headers
$search_results .= '<thead>';
foreach ($columns as $field) {
	$search_results .= '<th class="header uhb_annonces-header-' . $field . '">' . elgg_echo("uhb_annonces:search:$field") . '</th>';
}
$search_results .= '<th class="header nosort">' . elgg_echo('uhb_annonces:results:actions') . '</th>';
$search_results .= '</thead>';
// Table rows
$search_results .= '<tbody>';
foreach ($offers as $offer) {
	$search_results .= '<tr class="uhb_annonces-result uhb_annonces-result-' . $offer->typeoffer . ' uhb_annonces-result-state-' . $offer->followstate . '">';
	//$search_results .= elgg_view_entity($offer, array('full_view' => false));
	$offer_url = $CONFIG->url . 'annonces/view/' . $offer->guid;
	foreach ($columns as $field) {
		if (in_array($field, array('workstart', 'followcreation', 'followvalidation', 'followend'))) {
			if ($field == 'followcreation') {
				$value = $offer->time_created;
			} else {
				$value = $offer->$field;
			}
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


if ($admin) {
	$export_url = full_url();
	if (strpos($export_url, '?')) { $export_url .= '&'; } else { $export_url .= '?'; }
	$export_url .= 'export=csv';
	$search_results .= '<a href="' . $export_url . '&export=csv" class="elgg-button elgg-button-action">' . elgg_echo('uhb_annonces:form:action:exportcsv') . '</a>';
	$search_results .= '<p><em>' . elgg_echo('uhb_annonces:form:action:exportcsv:details') . '</em></p>';
}
$search_results .= '<br /><br />';




// Add first layout to have search forms + sidebar, then results in full width
$search_form = elgg_view('uhb_annonces/search');
$search_form .= '<br /><br />';
$sidebar .= elgg_view('uhb_annonces/sidebar');
$search_form = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $search_form, 'sidebar' => $sidebar));
$body = $search_form . $search_results;
// Note : the one_column layout do not have any breadcrumb
//$breadcrumbs = '<div id="uhb-header">' . elgg_view('navigation/breadcrumbs') . '</div>';
//$body = elgg_view_layout('one_colum', array('title' => $title, 'content' => $search_form . $search_results));

// Render the page
echo elgg_view_page($title, $body);

