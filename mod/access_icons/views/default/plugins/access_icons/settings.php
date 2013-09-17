<?php
/**
 * Access_icons plugin settings
 *
*/

if ($vars['entity']->helptext == "RAZ") { $vars['entity']->helptext = elgg_echo('access_icons:settings:helptext:default'); }
?>

<p><label><?php echo elgg_echo('access_icons:settings:helpurl'); ?></label><br />
	<?php echo elgg_echo('access_icons:settings:helpurl:help'); ?><br />
	<?php echo $url . elgg_view('input/text', array( 'name' => 'params[helpurl]', 'value' => $vars['entity']->helpurl, 'js' => 'style="width:50%;"' )); ?>
</p><br />

<?php /* @TODO : doesn't work as expected yet
<p><label><?php echo elgg_echo('access_icons:settings:helptext'); ?></label><br />
	<?php echo elgg_echo('access_icons:settings:helptext:help'); ?><br />
	<?php echo $url . elgg_view('input/plaintext', array( 'name' => 'params[helptext]', 'value' => $vars['entity']->helptext)); ?>
</p><br />
*/ ?>


