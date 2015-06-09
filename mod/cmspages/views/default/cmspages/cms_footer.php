<?php
// Display regular or specific footer

// Get direct setting
$cms_footer = elgg_extract('footer', $vars, '');
// Fallback to global setting if cmspage doesn't define any cutom setting
if (empty($cms_footer)) { $cms_footer = elgg_get_plugin_setting('cms_footer', 'cmspages'); }
// If nothing defined (no custom nor global config), use site default footer
if (empty($cms_footer)) { $cms_footer = 'initial'; }

// Render footer
if (!empty($cms_footer)) {
	switch ($cms_footer) {
		case 'no': break;
		
		case 'initial':
			echo elgg_view('page/elements/footer', $vars);
			break;
		
		default:
			echo elgg_view('cmspages/view', array('pagetype' => $cms_footer));
	}
}

