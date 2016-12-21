<?php
/* ESOPE : generate JSON templates data for TinyMCE
 * See https://www.tinymce.com/docs/plugins/template/
 * Example JSON :
 * [
 *   {"title": "Some title 1", "description": "Some desc 1", "content": "My content"},
 *   {"title": "Some title 2", "description": "Some desc 2", "url": "development.html"}
 * ]
 */

// Note : must include start.php to access Elgg functions... so better keep it in main config file

//$enable_templates = strip_tags(elgg_get_plugin_setting('enable_templates', 'tinymce'));
//if ($enable_templates == "yes") {
	$templates_cmspages = strip_tags(elgg_get_plugin_setting('templates_cmspages', 'extended_tinymce'));
	$templates_htmlfiles = strip_tags(elgg_get_plugin_setting('templates_htmlfiles', 'extended_tinymce'));
	$templates_guids = strip_tags(elgg_get_plugin_setting('templates_guids', 'extended_tinymce'));
	$templates = '';
	// Build and add the JS params for templates
	if (!empty($templates_cmspages)) $templates .= esope_tinymce_prepare_templates($templates_cmspages, 'cmspage');
	if (!empty($templates_htmlfiles)) $templates .= esope_tinymce_prepare_templates($templates_htmlfiles, 'url');
	if (!empty($templates_guids)) $templates .= esope_tinymce_prepare_templates($templates_guids, 'guid');
//}

echo $templates;

