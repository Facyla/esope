<?php
// DOC : see in esope/start.php
// esope_esearch($params = array(), $defaults = array(), $max_results = 200)

// Inria : use custom additional filters (to exclude closed account from search)
$merge_params = array();

// Tip : Following commented filter will *not* find entities that do not have that metadata set
//$merge_params['metadata_name_value_pairs'][] = array('name' => 'memberstatus', 'value' => 'closed', 'operand' => '!=');

// Note : to find entities that do not have a specific metadata value, use a custom where clause
$dbprefix = elgg_get_config('dbprefix');
$name_metastring_id = elgg_get_metastring_id('memberstatus');
$value_metastring_id = elgg_get_metastring_id('closed');
$merge_params['wheres'][] = "NOT EXISTS (
    SELECT 1 FROM {$dbprefix}metadata md
    WHERE md.entity_guid = e.guid
        AND md.name_id = $name_metastring_id
        AND md.value_id = $value_metastring_id)";

echo esope_esearch(array('merge_params' => $merge_params), array('add_count' => 'yes'));
exit;

