<?php
/**
 * Elgg select transitions filter switch
 */


$filter_opt = array(
		'featured' => elgg_echo('transitions:filter:featured'), 
		'read' => elgg_echo('transitions:filter:read'), 
		'recent' => elgg_echo('transitions:filter:recent'), 
		'commented' => elgg_echo('transitions:filter:commented'), 
		'enriched' => elgg_echo('transitions:filter:enriched'),
	);

echo elgg_view('input/select', array('name' => "filter", 'options_values' => $filter_opt));


