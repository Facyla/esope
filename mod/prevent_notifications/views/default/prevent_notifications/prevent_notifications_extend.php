<?php
/* Uncomment if using input/submit extend instead of object form
// Add only to notifiable objects (registered by register_notification_object())
global $CONFIG;
$registered_objects = $CONFIG->register_objects['object'];
if (!array_key_exists(elgg_get_context(), $registered_objects)) return;
*/

$value = elgg_extract('value', $vars, 'yes');
?>
<div id="prevent_notification">
	<img src="<?php echo elgg_get_site_url(); ?>mod/prevent_notifications/graphics/notify.png" />
	<label><?php echo elgg_echo('prevent_notifications:label'); ?></label><br />
	<?php echo elgg_view("input/radio", array("name" => 'send_notification', "value" => $value, 'options' => array(elgg_echo('prevent_notifications:yes') => 'yes', elgg_echo('prevent_notifications:no') => 'no') )); ?>
</div>

<?php
/* JS way to reorder elements afterwards : 
 * this is less reliable for UI than extending input/submit button, 
 * but more reliable on extending the good elements
*/
?>
<script type="text/javascript">
// Reorder to insert before form submit button
$('#prevent_notification').insertBefore('input[type="submit"]');
</script>

