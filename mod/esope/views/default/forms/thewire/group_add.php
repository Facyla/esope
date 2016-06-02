<?php
/**
 * Wire add to group form body (access limited to group members)
 *
 * @uses $vars['post']
 */

$group = elgg_extract('entity', $vars, elgg_get_page_owner_entity());

// Wire in groups is only available to group members (or admins)
if (!elgg_instanceof($group, 'group')) { return; }
if (!($group->isMember() || elgg_is_admin_logged_in())) { return; }

elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('thewire:reply');
}

if ($post) {
	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
}

// Integration into groups : add container
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $group->guid));
// Also force access to the group members
echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->group_acl));

echo elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => 'thewire-textarea',
	'placeholder' => elgg_echo('esope:thewire:group:placeholder'),
));
?>
<div id="thewire-characters-remaining">
	<span>140</span> <?php echo elgg_echo('thewire:charleft'); ?>
</div>
<div class="elgg-foot mts">
<?php

echo elgg_view('input/submit', array(
	'value' => $text,
	'id' => 'thewire-submit-button',
));
?>
</div>
