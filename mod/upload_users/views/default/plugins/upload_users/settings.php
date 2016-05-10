<?php
// Custom message in email notification

// Preview notification message
$preview_message = elgg_echo('upload_users:email:message', array("[NAME]", elgg_get_config('sitename'), "[USERNAME]", "[PASSWORD]", elgg_get_site_url(), $vars['entity']->custom_message));
?>

<div>
	<p>
		<label><?php echo elgg_echo('upload_users:notification:custom'); ?></label>
		<?php echo elgg_view('input/longtext', array('name' => 'params[custom_message]', 'value' => $vars['entity']->custom_message)); ?>
	</p>
</div>

<div>
	<h3><?php echo elgg_echo('upload_users:notification:preview'); ?></h3>
	<blockquote><?php echo nl2br($preview_message); ?></blockquote>
</div>
