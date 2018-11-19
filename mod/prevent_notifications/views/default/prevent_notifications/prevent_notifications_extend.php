<?php
/* Uncomment if using input/submit extend instead of object form
// Add only to notifiable objects (registered by register_notification_object())
global $CONFIG;
$registered_objects = $CONFIG->register_objects['object'];
if (!array_key_exists(elgg_get_context(), $registered_objects)) return;
*/

$default = elgg_get_plugin_setting('notification_default', 'prevent_notifications');
$value = elgg_extract('value', $vars, $default);

// Prevent notifications by default when using 'embed' (which usually means we are adding attachments to another content)
if (elgg_get_context() == 'embed') { $value = 'no'; }
?>

<div id="prevent-notification">
	<div id="prevent-notification-icon"><i class="fa fa-envelope fa-fw"></i></div>
	<label><?php echo elgg_echo('prevent_notifications:label'); ?></label><br />
	<?php echo elgg_view("input/radio", array("name" => 'send_notification', "value" => $value, 'options' => array(elgg_echo('prevent_notifications:yes') => 'yes', elgg_echo('prevent_notifications:no') => 'no'), 'required' => "required", 'align' => 'horizontal')); ?>
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

