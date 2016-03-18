<?php
/**
 * Access_icons plugin settings
 *
*/

if ($vars['entity']->helptext == "RAZ") { $vars['entity']->helptext = elgg_echo('access_icons:settings:helptext:default'); }

// Update old settings
if (strpos($vars['entity']->helpurl, 'pg/cmspages/read') !== false) { $vars['entity']->helpurl = str_replace('pg/cmspages/read', 'p', $vars['entity']->helpurl); }

?>

<p><label><?php echo elgg_echo('access_icons:settings:helpurl'); ?></label><br />
	<?php echo elgg_echo('access_icons:settings:helpurl:help'); ?><br />
	<?php echo $url . elgg_view('input/text', array( 'name' => 'params[helpurl]', 'value' => $vars['entity']->helpurl, 'style' => "width:50%;" )); ?>
</p><br />

<p><?php echo elgg_echo('access_icons:settings:helptext:details'); ?></p>
<blockquote><?php echo elgg_echo('access_icons:settings:helptext:default'); ?></blockquote>

<?php /* @TODO : doesn't work as expected yet
<p><label><?php echo elgg_echo('access_icons:settings:helptext'); ?></label><br />
	<?php echo elgg_echo('access_icons:settings:helptext:help'); ?><br />
	<?php echo $url . elgg_view('input/plaintext', array( 'name' => 'params[helptext]', 'value' => $vars['entity']->helptext)); ?>
</p><br />
*/ ?>


