<?php
/**
 * List the latest feedback entries
 */

$num = $vars['entity']->num_display;
$status = $vars['entity']->status;

// @TODO filter doesn't work as expected yet
switch($vars['entity']->status) {
	
	case 'closed':
		$list = elgg_list_entities(['types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => ['name' => 'status', 'value' => 'closed'], 'limit' => $num, 'pagination' => false, 'full_view' => false]);
		if (!$list) {
			$list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>';
		}
		break;
	
	case 'all':
		$list = elgg_list_entities(['types' => 'object', 'subtypes' => 'feedback', 'limit' => $num, 'pagination' => false, 'full_view' => false]);
		if (!$list) {
			$list = '<p class="mtm">' . elgg_echo('feedback:list:nofeedback') . '</p>';
		}
		break;
	
	case 'open':
	default:
		$list = elgg_list_entities(['types' => 'object', 'subtypes' => 'feedback', 'metadata_name_value_pairs' => ['name' => 'status', 'value' => 'open'], 'limit' => $num, 'pagination' => false, 'full_view' => false]);
		if (!$list) {
			$list = '<p class="mtm">' . elgg_echo('feedback:list:noopenfeedback') . '</p>';
		}
		break;
}


echo $list;

