<?php
/**
 * User blog widget display view
 */
global $CONFIG;

$insearch = $vars['entity']->insearch;

if (!empty($insearch)) {
	echo '<div class="elgg-cmis-widget elgg-cmis-widget-insearch"><iframe src="' . $CONFIG->url . 'cmis/repo/list/document/insearch/' . $insearch . '?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
}

