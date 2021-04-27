<?php

/**
 * Admin listing
 */

$no_results = '<p class="mtm">' . elgg_echo('feedback:list:noopenfeedback') . '</p>';

// @dev Force upgrade
echo '<p>' . elgg_view('output/url', ['href' => "?upgrade=yes", 'text' => elgg_echo('feedback:upgrade')]) . '</p>';
if (elgg_is_admin_logged_in() && get_input('upgrade') == 'yes') {
	feedback_upgrade();
}


echo elgg_list_entities([
	'types' => 'object', 'subtypes' => 'feedback', 
	//'metadata_name_value_pairs' => ['name' => 'status', 'value' => 'closed', 'operand' => '<>']
	'no_results' => $no_results,
]);

