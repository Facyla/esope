<?php
/**
 * Collection plugin settings
 * Params :
 * - contenu de la collection par défaut
 * - styles de la collection par défaut
 *
*/

$url = elgg_get_site_url();

// Define options
$yn_opts = array('yes' => elgg_echo('collection:option:yes'), 'no' => elgg_echo('collection:option:no'));

?>

<!--
<p><label><?php echo elgg_echo('collection:settings:css'); ?></label><br />
	<?php echo elgg_echo('collection:css:help'); ?>
	<?php echo elgg_view('input/plaintext', array( 'name' => 'params[css]', 'value' => $vars['entity']->css )); ?>
</p>
//-->

<p><label><?php echo elgg_echo('collections:settings:subtypes'); ?>
	<?php echo elgg_view('input/text', array( 'name' => 'params[subtypes]', 'value' => $vars['entity']->subtypes )); ?></label><br />
	</em><?php echo elgg_echo('collections:settings:subtypes:details'); ?></em>
</p>

<br />


