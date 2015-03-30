<?php
// Display regular or specific footer

// Get direct setting
$cms_footer = elgg_extract('footer', $vars, '');
// Fallback to global setting
if (empty($cms_footer)) { $cms_footer = elgg_get_plugin_setting('cms_footer', 'cmspages'); }

// Set up chosen footer
if (empty($cms_footer)) {
	// Default footer
	echo elgg_view('page/elements/footer', $vars);
} else {
	// Specific footer
	echo elgg_view('cmspages/view', array('pagetype' => 'cms-footer'));
}


