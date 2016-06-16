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
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire', 140);

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

$count_down = "<span>$char_limit</span>";
$num_lines = 3;
if ($char_limit == 0) {
	$num_lines = 4;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 4;
}
echo elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => 'thewire-textarea',
	'rows' => $num_lines,
	'data-max-length' => $char_limit,
	'style' => "height:initial;",
	'placeholder' => elgg_echo('theme_inria:thewire:group:placeholder'),
));
?>

<div class="elgg-foot mts">
	<span style="float:right;">
		<span id="thewire-characters-remaining"><?php echo $count_down; ?></span>
		<?php
		echo elgg_view('input/submit', array(
			'value' => $text,
			'id' => 'thewire-submit-button',
		));
		?>
	</span>
</div>

