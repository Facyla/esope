<?php
/* 
 * Old method used footer/analytics
 * New method extends page/elements/foot with analytics view (in ESOPE: this view)
 */

//echo elgg_view('footer/analytics');

$analytics = elgg_get_plugin_setting('analytics', 'esope');
if (!empty($analytics)) {
	echo '<script type="text/javascript">';
	echo $analytics;
	echo '</script>';
}


