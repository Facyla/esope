<?php
$default = elgg_get_plugin_setting('notification_default', 'prevent_notifications');
$value = elgg_extract('value', $vars, $default);
?>
<div id="prevent_notification">
	<img src="<?php echo $vars['url']; ?>mod/prevent_notifications/graphics/notify.png" />
	<label><?php echo elgg_echo('prevent_notifications:label'); ?></label><br />
	<?php echo elgg_view("input/radio", array("name" => 'send_notification', "value" => $value, 'options' => array(elgg_echo('prevent_notifications:yes') => 'yes', elgg_echo('prevent_notifications:no') => 'no'), 'required' => "required")); ?>
</div>

