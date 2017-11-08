<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 *
 * List the latest feedback entries
 */

$num = $vars['entity']->num_display;
$status = $vars['entity']->status;

// @TODO filter doesn't work as expected yet
switch($vars['entity']->status) {
	
	case 'closed':
		$list = elgg_list_entities_from_metadata(array('types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'closed'), 'limit' => $num, 'pagination' => false, 'full_view' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>'; }
		break;
	
	case 'all':
		$list = elgg_list_entities(array('types' => 'object', 'subtypes' => 'feedback', 'limit' => $num, 'pagination' => false, 'full_view' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>'; }
		break;
	
	case 'open':
	default:
		$list = elgg_list_entities_from_metadata(array('types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'open'), 'limit' => $num, 'pagination' => false, 'full_view' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:noopenfeedback') . '</p>'; }
		break;
}


echo $list;
