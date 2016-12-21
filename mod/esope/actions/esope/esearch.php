<?php
// DOC : see in esope/start.php
// esope_esearch($params = array(), $defaults = array(), $max_results = 200)

// Inria : use custom additional filters (to exclude closed account from search)
$merge_params = array();

/* Doc : override this action to add some custom filters or additional parameters eg. for member search
 * esope_esearch($params, $defaults, $results_per_page);
 * 
 * Tip : Following filter will *not* find entities that do not have that metadata set
 * $merge_params['metadata_name_value_pairs'][] = array('name' => 'memberstatus', 'value' => 'closed', 'operand' => '!=');
 * 
 * Note : to find entities that do not have a specific metadata value, use a custom where clause
 * $merge_params['wheres'][] = "NOT EXISTS (
 *     SELECT 1 FROM " . elgg_get_config('dbprefix') . "metadata md
 *     WHERE md.entity_guid = e.guid
 *         AND md.name_id = " . elgg_get_metastring_id('memberstatus') . "
 *         AND md.value_id = " . elgg_get_metastring_id('closed') . ")";
 * 
 * echo esope_esearch(array('debug' => true, 'merge_params' => $merge_params), array('add_count' => 'yes'));
 * 
 */


echo esope_esearch(array(), array('add_count' => 'yes'));
exit;

