<?php
global $CONFIG;

$url = $vars['url'];

// Define dropdown options
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );


// Define defaults and allow resetting the config
if (empty($vars['entity']->plugins)) $vars['entity']->plugins = 'lists,spellchecker,autosave,fullscreen,paste,table,template,style,inlinepopups,contextmenu,searchreplace,emotions';
if (!isset($vars['entity']->advanced_buttons1) || ($vars['entity']->advanced_buttons1 == "RAZ")) $vars['entity']->advanced_buttons1 = 'removeformat,formatselect,bold,italic,underline,strikethrough,forecolor,link,unlink,blockquote,sub,sup,hr,fullscreen';
if (!isset($vars['entity']->advanced_buttons2) || ($vars['entity']->advanced_buttons2 == "RAZ")) $vars['entity']->advanced_buttons2 = 'visualaid,|,code,|,pastetext,pasteword,emotions,|,search,replace,|,bullist,numlist,indent,outdent,|,justifyleft,justifycenter,justifyright,justifyfull';
if (!isset($vars['entity']->advanced_buttons3) || ($vars['entity']->advanced_buttons3 == "RAZ")) $vars['entity']->advanced_buttons3 = 'image,|,tablecontrols,|,undo,redo,|,spellchecker';
if (!isset($vars['entity']->advanced_buttons3) || ($vars['entity']->advanced_buttons3 == "RAZ")) $vars['entity']->advanced_buttons3 = '';
if (empty($vars['entity']->extended_valid_elements)) $vars['entity']->extended_valid_elements = "a[name|href|target|title|onclick|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[src|type|wmode|width|height|allowfullscreen|allowscriptaccess],object[classid|clsid|codebase|width|height|data|type|id],style[lang|media|title|type],iframe[src|width|height|style],param[name|value],,video[src|preload|autoplay|mediagroup|loop|muted|controls|poster|width|height],audio[src|preload|autoplay|mediagroup|loop|muted|controls],source[src|type|media],track[kind|src|srclang|label|default]";


?>

<p><label><?php echo elgg_echo('esope:tinymce:templates:plugins'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[plugins]', 'value' => $vars['entity']->plugins )); ?></label>
	<br /><em><?php echo elgg_echo('esope:tinymce:templates:plugins:details'); ?></em>
</p>

<p><label><?php echo elgg_echo('esope:tinymce:templates:advanced_buttons1'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons1]', 'value' => $vars['entity']->advanced_buttons1 )); ?></label>
	<br /><em><?php echo elgg_echo('esope:tinymce:templates:advanced_buttons:details'); ?></em>
</p>
<p><label><?php echo elgg_echo('esope:tinymce:templates:advanced_buttons2'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons2]', 'value' => $vars['entity']->advanced_buttons2 )); ?></label>
</p>
<p><label><?php echo elgg_echo('esope:tinymce:templates:advanced_buttons3'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons3]', 'value' => $vars['entity']->advanced_buttons3 )); ?></label>
</p>
<p><label><?php echo elgg_echo('esope:tinymce:templates:advanced_buttons4'); ?> 
	<?php echo elgg_view('input/text', array( 'name' => 'params[advanced_buttons4]', 'value' => $vars['entity']->advanced_buttons4 )); ?></label>
</p>



<p><label><?php echo elgg_echo('esope:tinymce:templates'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[enable_templates]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->enable_templates )); ?></label>
</p>

<p><em><?php echo elgg_echo('esope:tinymce:templates:cmspages:details'); ?></p>
<?php if (elgg_is_active_plugin('cmspages')) { ?>
	<p><label><?php echo elgg_echo('esope:tinymce:templates:cmspages'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_cmspages]', 'value' => $vars['entity']->templates_cmspages )); ?></label>
	</p>
<?php } ?>

<p><label><?php echo elgg_echo('esope:tinymce:templates:htmlfiles'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_htmlfiles]', 'value' => $vars['entity']->templates_htmlfiles )); ?></label>
	<br /><em><?php echo elgg_echo('esope:tinymce:templates:htmlfiles:details'); ?></em>
</p>

<p>[DEV] - <label><?php echo elgg_echo('esope:tinymce:templates:guids'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[templates_guids]', 'value' => $vars['entity']->templates_guids )); ?></label>
	<br /><em><?php echo elgg_echo('esope:tinymce:templates:guids:details'); ?></em>
</p>


<p><label><?php echo elgg_echo('esope:tinymce:extended_valid_elements'); ?> 
		<?php echo elgg_view('input/plaintext', array( 'name' => 'params[extended_valid_elements]', 'value' => $vars['entity']->extended_valid_elements )); ?></label>
	<br /><em><?php echo elgg_echo('esope:tinymce:extended_valid_elements:details'); ?></em>
</p>


