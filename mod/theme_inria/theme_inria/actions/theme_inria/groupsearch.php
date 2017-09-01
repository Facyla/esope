<?php
// DOC : see in esope/start.php
// esope_esearch($params = array(), $defaults = array(), $max_results = 200)

// Inria : use custom additional filters (to exclude closed account from search)
$merge_params = array();

// Tip : Following commented filter will *not* find entities that do not have that metadata set
//$merge_params['metadata_name_value_pairs'][] = array('name' => 'memberstatus', 'value' => 'closed', 'operand' => '!=');

// Note : to find entities that do not have a specific metadata value, use a custom where clause
/*
$merge_params['wheres'][] = "NOT EXISTS (
    SELECT 1 FROM " . elgg_get_config('dbprefix') . "metadata md
    WHERE md.entity_guid = e.guid
        AND md.name_id = " . elgg_get_metastring_id('memberstatus') . "
        AND md.value_id = " . elgg_get_metastring_id('closed') . ")";
*/

// @TODO handle specific group searches - maybe use direct search ?
$group_search_type = get_input('group_search_type', '');
switch($group_search_type) {
	case 'member':
		$merge_params['relationship'] = 'member';
		$merge_params['relationship_guid'] = elgg_get_logged_in_user_guid();
		break;
	case 'operator':
		/*
		$merge_params['relationship'] = 'operator';
		$merge_params['relationship_guid'] = elgg_get_logged_in_user_guid();
		$merge_params['wheres'] = array("e.owner_guid = '" . elgg_get_logged_in_user_guid());
		*/
		// Note : JOIN is automatic if using popular groups order, so avoid duplicate
		if (get_input('order_by') != 'popular') {
			$merge_params['joins'][] = "INNER JOIN " . elgg_get_config('dbprefix') . "entity_relationships as r ON r.guid_two=e.guid";
		}
		//$merge_params['wheres'][] = "(e.owner_guid = '" . elgg_get_logged_in_user_guid() . ")"; // owner only
		//$merge_params['wheres'][] = "((r.relationship = 'operator') AND (r.guid_one = '" . elgg_get_logged_in_user_guid() . "'))"; // operator only
		$merge_params['wheres'][] = "((e.owner_guid = '" . elgg_get_logged_in_user_guid() . "') OR ((r.relationship = 'operator') AND (r.guid_one = '" . elgg_get_logged_in_user_guid() . "')))";
		$merge_params['distinct'] = true;
		break;
	case 'owner':
		$merge_params['owner_guid'] = elgg_get_logged_in_user_guid();
		break;
	case 'featured':
		//$merge_params['metadata_names'] = 'featured_group';
		//$merge_params['metadata_values'] = 'yes';
		$merge_params['metadata_name_value_pairs'][] = array('name' => 'featured_group', 'value' => 'yes');
		break;
	case 'all':
	default:
}

// Add skills and interests search from full text ?
$group_profile_fields = array('briefdescription', 'interests');

// Use case-insensitive search
$merge_params['metadata_case_sensitive'] = false;

//echo esope_esearch(array('merge_params' => $merge_params, 'debug' => true), array('add_count' => 'yes'));
echo esope_esearch(array('merge_params' => $merge_params, 'user_profile_fields' => $group_profile_fields, 'add_url_params' => "&group_search_type=$group_search_type"), array('add_count' => 'yes'));
//echo esope_esearch(array(), array('add_count' => 'yes'));

//$results = esope_esearch(array('merge_params' => $merge_params, 'returntype' => 'entities'), array('add_count' => 'yes'));

exit;

