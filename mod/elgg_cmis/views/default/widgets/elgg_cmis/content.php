<?php
global $CONFIG;

//$num = $vars['entity']->num_display;
$doctype = $vars['entity']->doctype; // folder or document
$search = $vars['entity']->search; // title search
$insearch = $vars['entity']->insearch; // inner content search
$author = $vars['entity']->author; // author filter
$folder = $vars['entity']->folder; // in_tree filter
/*
$query = $vars['entity']->query;
$type = $vars['entity']->type;
$filter = $vars['entity']->filter;
$filter_value = $vars['entity']->filter_value;
*/
$query = 'test';

if (!empty($query)) {
	$cmis_url = $CONFIG->url . 'cmis/repo/' . $query;
	if (!empty($type)) $cmis_url .= "/$type";
	if (!empty($filter)) $cmis_url .= "/$filter";
	if (!empty($filter_value)) $cmis_url .= "/$filter_value";

	echo '<div class="elgg-cmis-widget elgg-cmis-widget-main"><iframe src="' . $cmis_url . '?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
}

