<?php
/**
 * Elgg file upload/save form
 *
 * @package ElggFile
 */

// Adds prevent_notification form field

$file = elgg_extract('entity', $vars, null);
if (!elgg_instanceof($file, 'object', 'file')) { return; }

$file_label = elgg_echo("file:replace");
$submit_label = elgg_echo('save');

// Get post_max_size and upload_max_filesize
$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');

// Determine the correct value
$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;

$upload_limit = elgg_echo('file:upload_limit', array(elgg_format_bytes($max_upload)));

$is_embed = false;
?>
<div class="mbm elgg-text-help">
	<?php echo $upload_limit; ?>
</div>

<div>
	<label><?php echo $file_label; ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
</div>

<?php /*
<div>
	<label><?php echo elgg_echo('file:upload:version:message'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'version_message', 'value' => '')); ?>
</div>
*/ ?>

<div class="elgg-foot">
	<?php
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $file->guid));

	//echo elgg_view('prevent_notifications/prevent_form_extend', array());

	echo elgg_view('input/submit', array('value' => $submit_label));
	?>
</div>

