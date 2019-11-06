<?php
/**
 * Slider plugin settings
 * Params :
 * - contenu du slider par défaut
 * - styles du slider par défaut
 *
*/

$url = elgg_get_site_url();
$vendor_url = $url . 'mod/slider/vendors/anythingslider/';

// Define options
$yn_opts = array('yes' => elgg_echo('slider:option:yes'), 'no' => elgg_echo('slider:option:no'));


// Enable/disable editing by members, or admins only ?
echo '<p><label>' . elgg_echo('slider:settings:slider_access') . ' ';
echo elgg_view('input/select', array('name' => 'params[slider_access]', 'value' => $vars['entity']->slider_access, 'options_values' => $yn_opts));
echo '</label><br />' . elgg_echo('slider:settings:slider_access:details');
echo '</p>';

// Enable cloning
echo '<p><label>' . elgg_echo('slider:settings:enable_cloning') . ' ';
echo elgg_view('input/select', array('name' => 'params[enable_cloning]', 'value' => $vars['entity']->enable_cloning, 'options_values' => $yn_opts));
echo '</label><br />' . elgg_echo('slider:settings:enable_cloning:details');
echo '</p>';
?>

<p>
	<em>
		<h3><?php echo elgg_echo('slider:settings:defaultslider'); ?></h3>
		<?php echo elgg_echo('slider:settings:defaultslider:help'); ?>
	</em>
</p>
<br />

<p><label><?php echo elgg_echo('slider:settings:content'); ?></label><br />
	<?php echo elgg_echo('slider:settings:content:help'); ?><br />
	<?php echo elgg_view('input/longtext', array( 'name' => 'params[content]', 'value' => $vars['entity']->content, 'class' => 'elgg-input-rawtext' )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:jsparams'); ?></label><br />
	<?php echo elgg_echo('slider:settings:jsparams:help'); ?><br />
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[jsparams]', 'value' => $vars['entity']->jsparams )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_main'); ?></label><br />
	<?php echo elgg_echo('slider:settings:css_main:help'); ?><br />
	<?php echo elgg_view('input/text', array( 'name' => 'params[css_main]', 'value' => $vars['entity']->css_main )); ?>
</p><br />

<p><label><?php echo elgg_echo('slider:settings:css_textslide'); ?></label><br />
	<?php echo elgg_echo('slider:settings:css_textslide:help'); ?><br />
	<?php echo elgg_view('input/text', array( 'name' => 'params[css_textslide]', 'value' => $vars['entity']->css_textslide )); ?>
</p><br />

<!--
<p><label><?php echo elgg_echo('slider:settings:css'); ?></label><br />
	<?php echo elgg_echo('slider:css:help'); ?>
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css )); ?>
</p>
//-->

<br />


