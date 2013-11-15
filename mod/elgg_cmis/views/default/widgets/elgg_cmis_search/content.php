<?php
/**
 * User blog widget display view
 */
global $CONFIG;

$search = $vars['entity']->search;

if (!empty($search)) {
	echo '<div class="elgg-cmis-widget elgg-cmis-widget-search"><iframe src="' . $CONFIG->url . 'cmis/repo/list/document/search/' . $search . '?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
}

