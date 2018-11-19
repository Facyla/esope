<?php
/**
 * User blog widget display view
 */

$query = $vars['query'];
$type = $vars['type'];
$filter = $vars['filter'];
$filter_value = $vars['filter_value'];

if (!empty($query)) {
	$cmis_url = elgg_get_site_url() . 'cmis/repo/' . $query;
	if (!empty($type)) $cmis_url .= "/$type";
	if (!empty($filter)) $cmis_url .= "/$filter";
	if (!empty($filter_value)) $cmis_url .= "/$filter_value";

	echo '<div class="elgg-cmis elgg-cmis-main"><iframe src="' . $cmis_url . '?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
}

