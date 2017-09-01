<?php
/**
 * Discussion topic add/edit form body
 *
 */

$group = elgg_get_page_owner_entity();

$desc = get_input('description');

?>
<div>
	<?php echo elgg_view('input/plaintext', array('name' => 'description', 'value' => $desc, 'placeholder' => elgg_echo('theme_inria:discussion:placeholder'))); ?>
</div>

<?php echo elgg_view('input/hidden', array('name' => 'status', 'value' => 'open')); ?>

<?php echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->group_acl)); ?>

<div class="elgg-foot">
	<?php
	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $group->guid));
	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	?>
</div>
