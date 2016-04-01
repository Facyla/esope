<?php
/* ESOPE : needed to empty original file js/elgg/extended_tinymce.js to use PHP in this JS view
 */
// ESOPE @TODO finish importing changes from previous version (available plugins, some settings, etc.)


// Get plugin settings, and set defaults if they are missing
$plugins = strip_tags(elgg_get_plugin_setting('plugins', 'extended_tinymce'));
if (empty($plugins)) $plugins = "lists spellchecker autosave fullscreen paste table template style inlinepopups contextmenu searchreplace emotions media advimage advlink xhtmlxtras";

// Toobars
$advanced_buttons1 = strip_tags(elgg_get_plugin_setting('advanced_buttons1', 'extended_tinymce'));
if (empty($advanced_buttons1)) $advanced_buttons1 = "removeformat formatselect bold italic underline strikethrough forecolor link unlink blockquote sub sup hr fullscreen";
$advanced_buttons2 = strip_tags(elgg_get_plugin_setting('advanced_buttons2', 'extended_tinymce'));
if (empty($advanced_buttons2)) $advanced_buttons2 = "visualaid | code | pastetext pasteword emotions | search replace | bullist numlist indent outdent | justifyleft justifycenter justifyright justifyfull";
$advanced_buttons3 = strip_tags(elgg_get_plugin_setting('advanced_buttons3', 'extended_tinymce'));
if (empty($advanced_buttons3)) $advanced_buttons3 = "image | tablecontrols | undo redo | spellchecker";
$advanced_buttons4 = strip_tags(elgg_get_plugin_setting('advanced_buttons4', 'extended_tinymce'));

// Templates
$enable_templates = strip_tags(elgg_get_plugin_setting('enable_templates', 'extended_tinymce'));
if ($enable_templates == "yes") {
	$templates_cmspages = strip_tags(elgg_get_plugin_setting('templates_cmspages', 'extended_tinymce'));
	$templates_htmlfiles = strip_tags(elgg_get_plugin_setting('templates_htmlfiles', 'extended_tinymce'));
	$templates_guids = strip_tags(elgg_get_plugin_setting('templates_guids', 'extended_tinymce'));
	$templates = '';
	// Build and add the JS params for templates
	if (!empty($templates_cmspages)) $templates .= esope_tinymce_prepare_templates($templates_cmspages, 'cmspage');
	if (!empty($templates_htmlfiles)) $templates .= esope_tinymce_prepare_templates($templates_htmlfiles, 'url');
	if (!empty($templates_guids)) $templates .= esope_tinymce_prepare_templates($templates_guids, 'guid');
}

// Editor-based filtering
$extended_valid_elements = strip_tags(elgg_get_plugin_setting('extended_valid_elements', 'extended_tinymce'));
if (empty($extended_valid_elements)) { $extended_valid_elements = "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height|allowfullscreen|allowscriptaccess],object[classid|clsid|codebase|width|height|data|type|id],style[lang|media|title|type],iframe[src|width|height|style],param[name|value],video[src|preload|autoplay|mediagroup|loop|muted|controls|poster|width|height],audio[src|preload|autoplay|mediagroup|loop|muted|controls],source[src|type|media],track[kind|src|srclang|label|default]"; }

$expert_settings = strip_tags(elgg_get_plugin_setting('expert_settings', 'extended_tinymce'));

/* SOME INLINE DOC
All available plugins :
pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template
All available buttons :<p>&nbsp;</p>
<p>Your browser does not support the video tag or the file format of this video. <a href="http://www.supportduweb.com/">http://www.supportduweb.com/</a></p>
theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,spellchecker",
*/

?>
//<script>

define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var EXTENDED_TINYMCE = require('extended_tinymce');

	var tinymceLanguage = $('input:hidden[name=extendedtinymcelang]').val();

	$(".elgg-input-longtext").tinymce({
		script_url : elgg.config.wwwroot + '/mod/extended_tinymce/vendor/tinymce/js/tinymce/tinymce.min.js',
		selector: ".elgg-input-longtext",
		theme: "modern",
		skin : "lightgray",
		language : tinymceLanguage,
		relative_urls : false,
		remove_script_host : false,
		document_base_url : elgg.config.wwwroot,
		// Pour intégrer des modèles configurés, ajouter le plugin et le bouton "template"
		//plugins : "<?php echo $plugins; ?>",
		plugins: "advlist autolink autoresize charmap code colorpicker emoticons fullscreen hr image insertdatetime link lists paste preview print searchreplace table textcolor textpattern wordcount template",
		menubar: false,
		toolbar_items_size: "small",
		toolbar: [
			"newdocument preview fullscreen print | searchreplace | styleselect | fontselect | fontsizeselect",
			"undo redo | bullist numlist | outdent indent | bold italic underline | alignleft aligncenter alignright alignjustify | removeformat",
			"pastetext | insertdatetime | charmap | hr | table | forecolor backcolor | link unlink | image | emoticons | blockquote | code | template",
			
			// ESOPE @TODO : re-implement with new structure
			//"<?php echo $advanced_buttons1; ?>",
			//"<?php echo $advanced_buttons2; ?>",
			//"<?php echo $advanced_buttons3; ?>",
			//"<?php echo $advanced_buttons4; ?>",
			
		],
		width : "99%",
		browser_spellcheck : true,
		image_advtab: true,
		paste_data_images: false,
		autoresize_min_height: 200,
		autoresize_max_height: 450,
		insertdate_formats: ["%I:%M:%S %p", "%H:%M:%S", "%Y-%m-%d", "%d.%m.%Y"],
		content_css: elgg.config.wwwroot + 'mod/extended_tinymce/css/elgg_extended_tinymce.css',
		setup : function(e) {
			e.on('change', function(e) { tinyMCE.triggerSave(); });
		},
		
		// Doesn't check the HTML at all..
		//verify_html: false,
		// Allow custom elements
		//custom_elements: "",
		// Note extended actually extends the default list http://www.tinymce.com/wiki.php/Configuration3x:extended_valid_elements
		// ESOPE @TODO : re-implement
		//extended_valid_elements: "<?php echo $extended_valid_elements; ?>",
		
		// Templates - See https://www.tinymce.com/docs/plugins/template/
		<?php if ($templates) { ?>
			// ESOPE Note : we do NOT use URL method because it requires to load the engine to generate the file + non-cacheable
			//templates: "<?php echo elgg_get_site_url(); ?>mod/esope/views/default/js/elgg/extended_tinymce_templates.js.php",
			templates: [ <?php echo $templates; ?> ],
		<?php } ?>
		
	});
});
