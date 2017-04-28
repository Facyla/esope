<?php
/**
 * Profile layout
 * 
 * @uses $vars['entity']  The user
 */

// main profile page
/*
$params = array(
	'content' => elgg_view('profile/wrapper'),
	'num_columns' => 3,
);
echo elgg_view_layout('widgets', $params);
*/

echo elgg_view('profile/wrapper');
//echo elgg_view_layout('one_column', array('content' => elgg_view('profile/wrapper')));

