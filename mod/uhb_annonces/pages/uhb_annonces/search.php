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


$debug_mode = elgg_get_plugin_setting('debug_mode', 'uhb_annonces');
$debug = false;
if ($debug_mode == 'yes') { $debug = true; }
if ($debug) $debug_ts = microtime(TRUE);


$memory_limit = elgg_get_plugin_setting('memory_limit', 'uhb_annonces');
if (strlen($memory_limit) > 2) {
	if ($debug) echo "Current memory_limit = " . ini_get("memory_limit");
	ini_set("memory_limit", $memory_limit);
	$real_memory_limit = ini_get("memory_limit");
	if ($debug) echo " => Set to $memory_limit => New value = $real_memory_limit <br />";
	if ($memory_limit != $real_memory_limit) { register_error("Memory_limit could ne be set, please contact the sysadmin to allow setting it through a script, or update the global value."); }
}

// Accès à la recherche : public ssi IP université, ou tout membre dont le profil est dans la liste blanche
$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }
if (!uhb_annonces_can_view()) {
	register_error(elgg_echo('uhb_annonces:error:unauthorised'));
	forward('annonces');
}

// Increase time limit
// Note : memory limit should also be raised to at least 256 Mo
// The query may retrieve and process up to a few thousands results
set_time_limit(180);

// Set offset
$offset = get_input('offset', 0);

// Set limit - Nb max de résultats
if ($admin) {
	$max_count = elgg_get_plugin_setting('max_count_admin', 'uhb_annonces');
} else {
	$max_count = elgg_get_plugin_setting('max_count', 'uhb_annonces');
}
if (empty($max_count)) $max_count = 100;
$limit = get_input('limit', $max_count); // Default to max allowed
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


// Allows to trigger the search only after setting search parameters (no results at first)
// Use this to alter some params at first page display, eg. limit results, or set some defaults
// Or restore previously saved values
if (elgg_is_logged_in()) {
	$action = get_input('action', '');
	// If no action set, we're accessing to a new search, so session params restore applies
	if (empty($action)) {
		// Restore the previously saved settings
		$saved_search = elgg_get_sticky_values('uhb_offer_search');
		// Force search only if we got some data from there
		if ($saved_search) {
			//extract($saved_search); // This is nice for 
			//elgg_clear_sticky_form('uhb_offer_search');
			foreach ($saved_search as $field => $value) { set_input($field, $value); }
			set_input('action', 'search');
		}
	} else {
		// If any search criteria is set, then we should save this for later re-use
		elgg_make_sticky_form('uhb_offer_search');
	}
}



// Allows to trigger the search only after setting search parameters (no results at first)
// Use this to alter some params at first page display, eg. limit results, or set some defaults
$action = get_input('action', '');
if ($action != 'search') {
	/*
	$max_count = 10;
	$action = 'search';
	*/
}


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
function uhb_annonces_debug_update($offer, $getter, $options) {
	if (empty($offer->followinterested)) $offer->followinterested = 0;
	if (empty($offer->followreport)) $offer->followreport = 0;
	if (empty($offer->followcandidates)) $offer->followcandidates = 0;
}
$batch = new ElggBatch('elgg_get_entities', array('types' => 'object', 'subtypes' => 'uhb_offer'), 'uhb_annonces_debug_update', 25);
echo $content;
exit;
*/


/* Create test entities by duplicating exiting ones (the quick and dirty way) */
// Noter que cela a toutes les chances de faire planter le script, si on crée plus de qqs dizaines d'annonces à la fois
// (mais cela ne pose pas de problème si ça plante en cours d'exécution)
$test_duplicator = get_input('test_clone', false);
if ($admin && ($test_duplicator == 'clone')) {
	$clone_limit = get_input('clone_limit', 40);
	$offers = elgg_get_entities(array('types' => 'object', 'subtypes' => 'uhb_offer', 'limit' => $clone_limit));
	$all_fields = uhb_annonces_get_fields();
	echo "Duplication de " . count($offers) . " offres<br />";
	error_log("Duplication de " . count($offers) . " offres");
	foreach ($offers as $ent) {
		$new_ent = clone $ent;
		$new_ent->save();
		echo "Existing $ent->guid => NEW $new_ent->guid<br />";
		error_log("Existing $ent->guid => NEW $new_ent->guid");
	}
	exit;
}

// Perform search only if asked to
if ($action == 'search') {
	
	$meta_filter = array(); // Array that will be used as $search_params['metadata_name_value_pairs']
	
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
			
			if (!empty($min) && ($min == $max)) {
				// Special case : use a shorter test if no interval
				$meta_filter[] = array('name' => $criteria, 'value' => $min, 'case_sensitive' => false);
			} else {
				// Add filters : only if we are using something narrower than existing values
				if (!empty($min) && ($min > 0)) {
					$meta_filter[] = array('name' => $criteria, 'value' => $min, 'operand' => '>=', 'case_sensitive' => false);
				}
			
				// Note : $max may be 0, and this is a valid filter so we need to keep it !
				//if (in_array($criteria, array('followinterested', 'followcandidates', 'followreport')) && ($max === 0)) { $max = "0"; }
				if (($max != '') && ($max >= 0)) {
					// If using a date, correct max date to get the whole day (end of the day)
					if (!empty($max) && in_array($criteria, array('workstart', 'followvalidation', 'followend'))) { $max += 3600*24; }
				
					// Check max available value : no need to add filter if it is greater
					$max_val = esope_get_meta_max($criteria, 'uhb_offer');
					if ($max < $max_val) {
						$meta_filter[] = array('name' => $criteria, 'value' => $max, 'operand' => '<=', 'case_sensitive' => false);
					}
				}
			}
		
		} else {
			$value = get_input($criteria, '');
		
			// Note : use filter only if we have something set
			if (!empty($value)) {
				// Non-range fields may be exact match, LIKE match, IN match, or comparison match
				// Note : almost each field has its specific filters
			
				// Skip work type filter if not applicable
				if (($criteria == 'typework') && (get_input('typeoffer') != 'emploi')) { continue; }
			
				if ($criteria == 'profilelevel') {
					// Profile level is numeric (years after Bac), + clustering (<4, 4-5, >5)
					if ($value < 4) {
						$meta_filter[] = array('name' => $criteria, 'operand' => '<', 'value' => 4);
					} else if ($value > 5) {
						$meta_filter[] = array('name' => $criteria, 'operand' => '>', 'value' => 5);
					} else if (($value >= 4) && ($value <= 5)) {
						$meta_filter[] = array('name' => $criteria, 'operand' => '>=', 'value' => 4);
						$meta_filter[] = array('name' => $criteria, 'operand' => '<=', 'value' => 5);
					}
				} else if ($criteria == 'worklength') {
					// Worklength is numeric, + clustering (<3, 3-6, >6)
					if (in_array($value, array('0to3', '3to6', '6more'))) {
						$meta_filter[] = array('name' => 'typework', 'operand' => '!=', 'value' => "'cdi'");
					}
					switch ($value) {
						case '0to3':
							$meta_filter[] = array('name' => $criteria, 'operand' => '<', 'value' => 3);
							break;
						case '3to6':
							$meta_filter[] = array('name' => $criteria, 'operand' => '>=', 'value' => 3);
							$meta_filter[] = array('name' => $criteria, 'operand' => '<=', 'value' => 6);
							break;
						case'6more':
							$meta_filter[] = array('name' => $criteria, 'operand' => '>', 'value' => 6);
							break;
					}
				} else if ($criteria == 'structurepostalcode') {
					// Note : use LIKE operand to search by starting CP (departement)
					$meta_filter[] = array('name' => $criteria, 'value' => $value.'%', 'operand' => 'LIKE');
				} else if (in_array($criteria, array('structurename', 'structurenaf2008', 'structuresiret'))) {
					// Note : use LIKE operand to search into field content
					$meta_filter[] = array('name' => $criteria, 'value' => "%$value%", 'operand' => 'LIKE');
				} else {
					// Basic search on exact match
					$meta_filter[] = array('name' => $criteria, 'value' => $value);
				}
			}
		}
	}
	if (!empty($meta_filter)) { $search_params['metadata_name_value_pairs'] = $meta_filter; }

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
		if ($is_anonymous[0] == 'yes') { $where .= "AND e.owner_guid = '{$CONFIG->site->guid}'"; }
	}
	// Add optional state filter
	$name_id = get_metastring_id('followstate');
	$value_id = '';
	if ($admin) {
		$value = get_input('followstate');
		if (!empty($value)) { $value_id = get_metastring_id($value); }
	} else {
		$value_id = get_metastring_id('published');
	}
	if (!empty($value_id)) {
		$join .= "JOIN {$dbprefix}metadata as md ON e.guid=md.entity_guid ";
		$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
		$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
		$where .= "AND md.name_id = '$name_id' AND md.value_id = '$value_id' ";
	}
	$sql_order = "ORDER BY e.guid DESC ";
	$query = "$select $join $where $sql_order;";
	$results = get_data($query);
	$result_guids = array();
	if ($results) {
		foreach ($results as $row) { $result_guids[] = $row->guid; }
	}
	if ($debug) {
		$search_results .= '<pre>' . $query . '</pre>'; // debug
		$debug_ts2 = microtime(TRUE);
	}


	// 2. Now build additional queries using metadata
	// Lastest optimized version : we break the query into small pieces, allowing better caching, 
	// and lower the result scope by iterating metadata filters until we're done
	$md_filters = array();


	// 3. Get filtered results (apply filters on result entities)
	// Don't even bother to build filters if no entity matches at this step
	if (!empty($result_guids) && $search_params['metadata_name_value_pairs']) {
		foreach($search_params['metadata_name_value_pairs'] as $md_filter) {
			// Stop adding filters if we don't have any result
			if (empty($result_guids)) { break; }
			// Apply metadata filter
			$result_guids = uhb_annonces_filter_entity_guid_by_metadata($result_guids, $md_filter);
		}
	}

	if ($debug) {
		$search_results .= '<pre>' . print_r($search_params['metadata_name_value_pairs'], true) . '</pre>';
		$search_results .= "<br />Résultats : " . implode(', ', $result_guids);
		$debug_ts3 = microtime(TRUE);
	}


	// Results number...
	$offers_count = 0;
	if ($result_guids) { $offers_count = sizeof($result_guids); }
	$search_results .= '<div><h3>' . elgg_echo('uhb_annonces:search:count', array($offers_count)) . '</h3>';
	// Limit displayed results, except if we want to export
	if (!$export && ($max_count > 0) && ($offers_count > $max_count)) {
		$result_guids = array_slice($result_guids, $offset, $max_count);
		$search_results .= '<br />';
		$search_results .= '<span class="uhb_annonces-morethanmax">' . elgg_echo('uhb_annonces:search:morethanmax', array($max_count)) . '</p>';
	} 
	if ($offers_count == 0) { $search_results .= '<br /><br />'; }
	$search_results .= '</div>';

	// 4. Now get full entities
	$offers = array();
	if ($result_guids) {
		//foreach ($result_guids as $guid) { $offers[$guid] = get_entity($guid); }
		// This is about 30 times quicker than getting them one by one
		// Note that when exporting to CSV one by one method is faster and uses much less memory
		if (!$export) $offers = elgg_get_entities(array('guids' => $result_guids, 'limit' => 0));
	}

	if ($debug) $debug_ts4 = microtime(TRUE);


	if ($debug) {
		$search_results .= "<br />Construction des filtres : " . round($debug_ts1-$debug_ts, 4);
		$search_results .= "<br />Recherche de base : " . round($debug_ts2-$debug_ts1, 4);
		$search_results .= "<br />Recherche filtre metadata : " . round($debug_ts3-$debug_ts2, 4);
		$search_results .= "<br />Récupération entités : " . round($debug_ts4-$debug_ts3, 4);
	}

}


// RENDER RESULTS

// CSV EXPORT
if ($export) {
	if ($debug) $debug_ts5 = microtime(TRUE);
	set_time_limit(0);
	$all_fields = uhb_annonces_get_fields();
	$filename = 'offres_' . date('Y-m-d-H-i-s') . '.csv';
	$delimiter = ";";
	
	// Send file using headers for download
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename);

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	// output up to 5MB is kept in memory, if it becomes bigger it will automatically be written to a temporary file
	//$output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
	
	// Add Headings
	foreach ($all_fields as $field) {
		$headings[] = elgg_echo("uhb_annonces:object:$field");
	}
	fputcsv($output, $headings, $delimiter);
	
	/*
	// Optimisation : récupérer les entités une à une est meilleur pour la mémoire et les caches mysql, 
	//   la récupération globale des entités est plus rapide en soi, mais n'évite pas de récupérer les metadata via des requêtes séparées : 
	//   au final, les batches ne semblent pas apporter d'amélioration notable car on ne récupère pas les metadata en même temps
	// L'export "direct" en CSV, sans fonction spécifique, peut faire gagner un peu de temps, mais nécessite d'échapper toutes les saisies, ce qui risque de faire perdre le temps gagné...
	// Conclusion : le bottleneck est au niveau du "rendu" : affichage ou export des entités l'une après l'autre, à cause des requêtes et jointures nécessaires pour chacune des entités
	// @TODO : Pistes d'amélioration :
			1) un cache des fichiers d'export générés, sur la base des paramètres de requête, mais qui devrait être régénéré après chaque action d'écriture effectuée sur les annonces...
			2) Une requête SQL directe qui effectue toutes les jointures nécessaires pour récupérer chaque annonce en une seule fois
	// Split results in batches
	$batches = array_chunk($result_guids, 200);
	foreach ($batches as $result_guids) {
		$offers = elgg_get_entities(array('guids' => $result_guids, 'limit' => 0));
		// Process batch entities...
	}
	*/
		
	// Output the objects
	//foreach ($offers as $offer) {
	foreach ($result_guids as $guid) {
		$offer = get_entity($guid);
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
				//foreach($raw_value as $val) { $value[] = date('Y/m/d', $val); }
				foreach($raw_value as $val) { $value[] = date('d/m/Y', $val); }
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
	
	if ($debug) {
		$debug_ts6 = microtime(TRUE);
		error_log("UHB Annonces : Export CSV time = " . round($debug_ts6-$debug_ts5, 4));
		
		$peak = memory_get_peak_usage();
		$peak = round($peak/1000000);
		$realpeak = memory_get_peak_usage();
		$realpeak = round($realpeak/1000000);
		error_log("UHB Annonces : MEM test = $peak MB / $realpeak MB");
	}
	
	exit;
}


// TABLE OUTPUT
if ($offers) {
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
			$field_content = '';
			if (in_array($field, array('workstart', 'followcreation', 'followvalidation', 'followend'))) {
				if ($field == 'followcreation') {
					$value = $offer->time_created;
				} else {
					$value = $offer->$field;
				}
				//if (!empty($value)) $field_content = date('Y/m/d', $value);
				if (!empty($value)) $field_content = date('d/m/Y', $value);
				else $field_content = elgg_echo('uhb_annonces:undefined');
			} else if ($field == 'followstate') {
				$field_content = elgg_echo('uhb_annonces:search:state:' . $offer->$field);
			} else if ($field == 'managervalidated') {
				$field_content = elgg_echo('uhb_annonces:option:' . $offer->$field);
			} else if ($field == 'worklength') {
				if (($offer->typeoffer == 'emploi') && ($offer->typework == 'cdi')) {
					$field_content = '(' . elgg_echo('uhb_annonces:typework:' . $offer->typework) . ')';
				} else {
					$field_content = elgg_echo('uhb_annonces:search:worklength:result', array($offer->$field));
				}
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
		$search_results .= '<br /><br /><p><em>' . elgg_echo('uhb_annonces:form:action:exportcsv:details') . '</em></p>';
	}
	$search_results .= '<br /><br />';
	
	
	// Sortable headers
	elgg_load_js('jquery-tablesorter');
	$sort_headers = array();
	$num_col = 0; // Column counter - used because we need to target actions column (which is not in $columns)
	// Block some columns sorters
	// Note : if sorter is blocked, also add a nosort class to the tr so that the sorting icon doesn't appear
	$nosort_cols = array();
	foreach ($columns as $field) {
		if ($nosort_cols && in_array($field, $nosort_cols)) {
			$sort_headers[] = "$num_col: {sorter: false}";
		}
		$num_col++;
	}
	// Don't use sort on last column (actions)
	$sort_headers[] = "$num_col: {sorter: false}";
	
	$tablesorter = '<script type="text/javascript">
	$(document).ready(function() {
		$("#uhb_annonces-search-results").tablesorter({
			//sortList: [[0,1]], // Default sort columns
			theme: \'blue\',
			headers: {' . implode(", \n", $sort_headers) . '},
			dateFormat: \'pt\', // pt = d/m/Y ; available formats : us|pt|uk
			widgets: ["zebra", "filter"],
			widgetOptions : {
				filter_columnFilters : true,
			}
		});
	}); 
	</script>';
	
} else {
	// No results, or no search performed yet
}


if ($debug) {
	$debug_ts5 = microtime(TRUE);
	$search_results .= "<br />Affichage des entités : " . round($debug_ts5-$debug_ts4, 4);
	
	// Memory information
	$peak = memory_get_peak_usage();
	$peak = round($peak/1000000);
	$realpeak = memory_get_peak_usage();
	$realpeak = round($realpeak/1000000);
	error_log("UHB Annonces : MEM test = $peak MB / $realpeak MB");
	$content .= "UHB Annonces : MEM test = $peak MB / $realpeak MB";
}



// Add first layout to have search forms + sidebar, then results in full width
// Important : form has to be called prior to the action, because we may restore saved search parameters
$search_form = elgg_view('uhb_annonces/search');
$search_form .= '<br /><br />';
$sidebar .= elgg_view('uhb_annonces/sidebar');
$search_form = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $search_form, 'sidebar' => $sidebar));
$body = $search_form . $tablesorter . $search_results;
// Note : the one_column layout do not have any breadcrumb
//$breadcrumbs = '<div id="uhb-header">' . elgg_view('navigation/breadcrumbs') . '</div>';
//$body = elgg_view_layout('one_colum', array('title' => $title, 'content' => $search_form . $search_results));

// Render the page
echo elgg_view_page($title, $body);

