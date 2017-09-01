<?php
/**
 * Elgg file upload/save form
 *
 * @package ElggFile
 */

$group = elgg_get_page_owner_entity();

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = $group->guid;

// Get post_max_size and upload_max_filesize
$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');

// Determine the correct value
$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;

$upload_limit = elgg_echo('file:upload_limit', array(elgg_format_bytes($max_upload)));

?>

<div>
	<div class="form-label">
		<label><?php echo elgg_echo("file:file"); ?></label>
	</div>
	<div class="form-input">
		<?php echo elgg_view('input/file', array('name' => 'upload')); ?>
		<div class="mbm elgg-text-help">
			<?php echo $upload_limit; ?>
		</div>
	</div>
</div>

<div>
	<div class="form-label">
		<label><?php echo elgg_echo('title'); ?></label>
	</div>
	<div class="form-input">
		<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
	</div>
</div>

<div>
	<div class="form-label">
		<label><?php echo elgg_echo('description'); ?></label>
	</div>
	<div class="form-input">
		<?php echo elgg_view('input/plaintext', array('name' => 'description', 'value' => $desc)); ?>
	</div>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) { echo $categories; }

?>
<div>
	<div class="form-label">
		<label><?php echo elgg_echo('access'); ?></label>
	</div>
	<div class="form-input">
		<?php echo elgg_view('input/access', array(
			'name' => 'access_id',
			'value' => $access_id,
			'entity' => get_entity($guid),
			'entity_type' => 'object',
			'entity_subtype' => 'file',
		)); ?>
	</div>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'file_guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => $submit_label));

?>
</div>
