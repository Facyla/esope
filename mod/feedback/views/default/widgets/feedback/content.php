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

elgg_push_context('widget');

switch($vars['entity']->status) {
	case 'open':
		$list = elgg_list_entities_from_metadata(array('types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'open'), 'limit' => $num, 'pagination' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:noopenfeedback') . '</p>'; }
		break;
	
	case 'closed':
		$list = elgg_list_entities_from_metadata(array('types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => array('name' => 'status', 'value' => 'closed'), 'limit' => $num, 'pagination' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>'; }
		break;
	
	default:
		$list = elgg_list_entities(array('types' => 'object', 'subtypes' => 'feedback', 'limit' => $num, 'pagination' => false));
		if (!$list) { $list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>'; }
}

elgg_pop_context();

echo $list;
