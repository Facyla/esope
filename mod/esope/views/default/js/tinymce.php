<?php
// Get plugin settings, and set defaults if they are missing
$plugins = strip_tags(elgg_get_plugin_setting('plugins', 'tinymce'));
if (empty($plugins)) $plugins = "lists,spellchecker,autosave,fullscreen,paste,table,template,style,inlinepopups,contextmenu,searchreplace,emotions,media,advimage,advlink,xhtmlxtras";

// Toobars
$advanced_buttons1 = strip_tags(elgg_get_plugin_setting('advanced_buttons1', 'tinymce'));
if (empty($advanced_buttons1)) $advanced_buttons1 = "removeformat,formatselect,bold,italic,underline,strikethrough,forecolor,link,unlink,blockquote,sub,sup,hr,fullscreen";
$advanced_buttons2 = strip_tags(elgg_get_plugin_setting('advanced_buttons2', 'tinymce'));
if (empty($advanced_buttons2)) $advanced_buttons2 = "visualaid,|,code,|,pastetext,pasteword,emotions,|,search,replace,|,bullist,numlist,indent,outdent,|,justifyleft,justifycenter,justifyright,justifyfull";
$advanced_buttons3 = strip_tags(elgg_get_plugin_setting('advanced_buttons3', 'tinymce'));
if (empty($advanced_buttons3)) $advanced_buttons3 = "image,|,tablecontrols,|,undo,redo,|,spellchecker";
$advanced_buttons4 = strip_tags(elgg_get_plugin_setting('advanced_buttons4', 'tinymce'));

// Templates
$enable_templates = strip_tags(elgg_get_plugin_setting('enable_templates', 'tinymce'));
if ($enable_templates == "yes") {
	$templates_cmspages = strip_tags(elgg_get_plugin_setting('templates_cmspages', 'tinymce'));
	$templates_htmlfiles = strip_tags(elgg_get_plugin_setting('templates_htmlfiles', 'tinymce'));
	$templates_guids = strip_tags(elgg_get_plugin_setting('templates_guids', 'tinymce'));
	$templates = '';
	// Build and add the JS params for templates
	if (!empty($templates_cmspages)) $templates .= esope_tinymce_prepare_templates($templates_cmspages, 'cmspage');
	if (!empty($templates_htmlfiles)) $templates .= esope_tinymce_prepare_templates($templates_htmlfiles, 'url');
	if (!empty($templates_guids)) $templates .= esope_tinymce_prepare_templates($templates_guids, 'guid');
}

// Editor-based filtering
$extended_valid_elements = strip_tags(elgg_get_plugin_setting('extended_valid_elements', 'tinymce'));
if (empty($extended_valid_elements)) $extended_valid_elements = "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height|allowfullscreen|allowscriptaccess],object[classid|clsid|codebase|width|height|data|type|id],style[lang|media|title|type],iframe[src|width|height|style],param[name|value],video[src|preload|autoplay|mediagroup|loop|muted|controls|poster|width|height],audio[src|preload|autoplay|mediagroup|loop|muted|controls],source[src|type|media],track[kind|src|srclang|label|default]";

$expert_settings = strip_tags(elgg_get_plugin_setting('extended_valid_elements', 'tinymce'));

?>

elgg.provide('elgg.tinymce');

/**
 * Toggles the tinymce editor
 *
 * @param {Object} event
 * @return void
 */
elgg.tinymce.toggleEditor = function(event) {
	event.preventDefault();
	
	var target = $(this).attr('href');
	var id = $(target).attr('id');
	if (!tinyMCE.get(id)) {
		tinyMCE.execCommand('mceAddControl', false, id);
		$(this).html(elgg.echo('tinymce:remove'));
	} else {
		tinyMCE.execCommand('mceRemoveControl', false, id);
		$(this).html(elgg.echo('tinymce:add'));
	}
}

/**
 * TinyMCE initialization script
 *
 * You can find configuration information here:
 * http://tinymce.moxiecode.com/wiki.php/Configuration
 */
elgg.tinymce.init = function() {

	$('.tinymce-toggle-editor').live('click', elgg.tinymce.toggleEditor);

	$('.elgg-input-longtext').parents('form').submit(function() {
		tinyMCE.triggerSave();
	});
	
	// Regular, advanced configuration editor
	tinyMCE.init({
		theme : "advanced",
		mode : "specific_textareas",
		editor_selector : "elgg-input-longtext",
		editor_deselector : "elgg-input-rawtext",
		
		language : "<?php echo tinymce_get_site_language(); ?>",
		gecko_spellcheck : true,
		browser_spellcheck : true,
		spellchecker_languages : "+French=fr,English=en",
		
		table_inline_editing : true,
		//document_base_url : elgg.config.wwwroot,
		//relative_urls : false,
		convert_urls : false,
		
		// Doesn't check the HTML at all..
		//verify_html : false,
		// Allow custom elements
		//custom_elements : "",
		// Note extended actually extends the default list http://www.tinymce.com/wiki.php/Configuration3x:extended_valid_elements
		extended_valid_elements : "<?php echo $extended_valid_elements; ?>",
		
		
		<?php /* SOME INLINE DOC
		All available plugins :
		  pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template
		All available buttons :<p>&nbsp;</p>
<p>Your browser does not support the video tag or the file format of this video. <a href="http://www.supportduweb.com/">http://www.supportduweb.com/</a></p>
		  theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
      theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,spellchecker",
		*/ ?>
		// Pour intégrer des modèles configurés, ajouter le plugin et le bouton "template"
		plugins : "<?php echo $plugins; ?>",
		
		theme_advanced_buttons1 : "<?php echo $advanced_buttons1; ?>",
		theme_advanced_buttons2 : "<?php echo $advanced_buttons2; ?>",
		theme_advanced_buttons3 : "<?php echo $advanced_buttons3; ?>",
		theme_advanced_buttons4 : "<?php echo $advanced_buttons4; ?>",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_path : true,
		width : "100%",
		//height: "200px",
		
		setup : function(ed) {
			// show the number of words at startup
			ed.onLoadContent.add(function(ed, o) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});
			// Update word count
			ed.onKeyUp.add(function(ed, e) {
				var strip = (tinyMCE.activeEditor.getContent()).replace(/(&lt;([^&gt;]+)&gt;)/ig,"");
				var text = elgg.echo('tinymce:word_count') + strip.split(' ').length + ' ';
				tinymce.DOM.setHTML(tinymce.DOM.get(tinyMCE.activeEditor.id + '_path_row'), text);
			});
			
			// prevent Firefox from dragging/dropping files into editor
			ed.onInit.add(function(ed) {
				if (tinymce.isGecko) {
					tinymce.dom.Event.add(ed.getBody().parentNode, "drop", function(e) {
						if (e.dataTransfer.files.length > 0) {
							e.preventDefault();
						}
					});
				}
			});
		},
		
		content_css: elgg.config.wwwroot + 'mod/tinymce/css/elgg_tinymce.css',
		
		// Templates
		<?php if ($templates) { ?>
			template_templates : [ <?php echo $templates; ?> ],
		<?php } ?>
	});
	
	/* This seems to cause problems with translation strings
	// Doc : http://www.tinymce.com/tryit/3_x/multiple_configs.php
	// Setup a new, basic config
	tinyMCE.init({
		mode : "specific_textareas",
		editor_selector : "elgg-input-simpletext",
		theme : "advanced",
		extended_valid_elements : "<?php echo $extended_valid_elements; ?>",
		
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,anchor,|,undo,redo,|,cleanup,|,bullist,numlist",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		convert_urls : false,
	});
	*/
	
	
	// work around for IE/TinyMCE bug where TinyMCE loses insert carot
	if ($.browser.msie) {
		$(".embed-control").live('hover', function() {
			var classes = $(this).attr('class');
			var embedClass = classes.split(/[, ]+/).pop();
			var textAreaId = embedClass.substr(embedClass.indexOf('embed-control-') + "embed-control-".length);

			if (window.tinyMCE) {
				var editor = window.tinyMCE.get(textAreaId);
				if (elgg.tinymce.bookmark == null) {
					elgg.tinymce.bookmark = editor.selection.getBookmark(2);
				}
			}
		});
	}
}

elgg.register_hook_handler('init', 'system', elgg.tinymce.init);
