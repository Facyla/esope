<?php
/* @TODO This is for TinyMCE - but CKEditor JS config does not use PHP views anymore... or use AMD init view ?
 * @TODO Templates are defined in vendors/ckeditor/plugins/templates/templates/default.js
 */

if (!elgg_is_active_plugin('ckeditor')) {
	register_error('Please enable plugin first.');
	forward('admin/plugins#ckeditor');
}

$url = elgg_get_site_url();

// Define select options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

// @TODO : port for ckeditor

// Get previous config from TinyMCE
$tinymce_settings = array('enable_templates', 'templates_cmspages', 'templates_htmlfiles', 'templates_guids', 'extended_valid_elements');
foreach ($tinymce_settings as $setting) {
	if (!isset($vars['entity']->$setting)) { $vars['entity']->$setting = elgg_get_plugin_setting($setting, 'tinymce'); }
}

/* These were TinyMCE settings
// Define defaults and allow resetting the config
if (empty($vars['entity']->plugins)) $vars['entity']->plugins = 'lists,spellchecker,autosave,fullscreen,paste,table,template,style,inlinepopups,contextmenu,searchreplace,emotions';
if (!isset($vars['entity']->advanced_buttons1) || ($vars['entity']->advanced_buttons1 == "RAZ")) $vars['entity']->advanced_buttons1 = 'removeformat,formatselect,bold,italic,underline,strikethrough,forecolor,link,unlink,blockquote,sub,sup,hr,fullscreen';
if (!isset($vars['entity']->advanced_buttons2) || ($vars['entity']->advanced_buttons2 == "RAZ")) $vars['entity']->advanced_buttons2 = 'visualaid,|,code,|,pastetext,pasteword,emotions,|,search,replace,|,bullist,numlist,indent,outdent,|,justifyleft,justifycenter,justifyright,justifyfull';
if (!isset($vars['entity']->advanced_buttons3) || ($vars['entity']->advanced_buttons3 == "RAZ")) $vars['entity']->advanced_buttons3 = 'image,|,tablecontrols,|,undo,redo,|,spellchecker';
if (!isset($vars['entity']->advanced_buttons4) || ($vars['entity']->advanced_buttons4 == "RAZ")) $vars['entity']->advanced_buttons4 = '';
if (empty($vars['entity']->extended_valid_elements)) $vars['entity']->extended_valid_elements = "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height|allowfullscreen|allowscriptaccess],object[classid|clsid|codebase|width|height|data|type|id],style[lang|media|title|type],iframe[src|width|height|style],param[name|value],video[src|preload|autoplay|mediagroup|loop|muted|controls|poster|width|height],audio[src|preload|autoplay|mediagroup|loop|muted|controls],source[src|type|media],track[kind|src|srclang|label|default]";
*/

?>

<?php /* ?>
<p><label><?php echo elgg_echo('esope:ckeditor:plugins'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[plugins]', 'value' => $vars['entity']->plugins )); ?></label>
	<br /><em><?php echo elgg_echo('esope:ckeditor:plugins:details'); ?></em>
</p>

<p><label><?php echo elgg_echo('esope:ckeditor:advanced_buttons1'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons1]', 'value' => $vars['entity']->advanced_buttons1 )); ?></label>
	<br /><em><?php echo elgg_echo('esope:ckeditor:advanced_buttons:details'); ?></em>
</p>
<p><label><?php echo elgg_echo('esope:ckeditor:advanced_buttons2'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons2]', 'value' => $vars['entity']->advanced_buttons2 )); ?></label>
</p>
<p><label><?php echo elgg_echo('esope:ckeditor:advanced_buttons3'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons3]', 'value' => $vars['entity']->advanced_buttons3 )); ?></label>
</p>
<p><label><?php echo elgg_echo('esope:ckeditor:advanced_buttons4'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons4]', 'value' => $vars['entity']->advanced_buttons4 )); ?></label>
</p>
<?php */ ?>


<p><label><?php echo elgg_echo('esope:ckeditor:templates'); ?> 
	<?php echo elgg_view('input/select', array( 'name' => 'params[enable_templates]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->enable_templates )); ?></label>
</p>

<p><em><?php echo elgg_echo('esope:ckeditor:templates:cmspages:details'); ?></p>
<?php if (elgg_is_active_plugin('cmspages')) { ?>
	<p><label><?php echo elgg_echo('esope:ckeditor:templates:cmspages'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_cmspages]', 'value' => $vars['entity']->templates_cmspages )); ?></label>
	</p>
<?php } ?>

<p><label><?php echo elgg_echo('esope:ckeditor:templates:htmlfiles'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_htmlfiles]', 'value' => $vars['entity']->templates_htmlfiles )); ?></label>
	<br /><em><?php echo elgg_echo('esope:ckeditor:templates:htmlfiles:details'); ?></em>
</p>

<p>[DEV] - <label><?php echo elgg_echo('esope:ckeditor:templates:guids'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_guids]', 'value' => $vars['entity']->templates_guids )); ?></label>
	<br /><em><?php echo elgg_echo('esope:ckeditor:templates:guids:details'); ?></em>
</p>

<?php /* ?>
<p><label><?php echo elgg_echo('esope:ckeditor:extended_valid_elements'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[extended_valid_elements]', 'value' => $vars['entity']->extended_valid_elements )); ?></label>
	<br /><em><?php echo elgg_echo('esope:ckeditor:extended_valid_elements:details'); ?></em>
</p>
<?php */ ?>


