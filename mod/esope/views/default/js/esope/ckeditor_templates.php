<?php
/* ESOPE : provides custom templates to CKEditor
 */

// Templates
$enable_templates = strip_tags(elgg_get_plugin_setting('enable_templates', 'extended_tinymce'));
if ($enable_templates == "yes") {
	$templates_cmspages = strip_tags(elgg_get_plugin_setting('templates_cmspages', 'extended_tinymce'));
	$templates_htmlfiles = strip_tags(elgg_get_plugin_setting('templates_htmlfiles', 'extended_tinymce'));
	$templates_guids = strip_tags(elgg_get_plugin_setting('templates_guids', 'extended_tinymce'));
	$templates = '';
	// Build and add the JS params for templates
	if (!empty($templates_cmspages)) { $templates .= esope_ckeditor_prepare_templates($templates_cmspages, 'cmspage'); }
	if (!empty($templates_htmlfiles)) { $templates .= esope_ckeditor_prepare_templates($templates_htmlfiles, 'url'); }
	if (!empty($templates_guids)) { $templates .= esope_ckeditor_prepare_templates($templates_guids, 'guid'); }
}


?>
//</script>
CKEDITOR.addTemplates("esope_custom_templates",{
	imagesPath: "<?php echo elgg_get_site_url(); ?>mod/esope/img/templates/",
	templates: [ <?php echo $templates; ?> ],
});

