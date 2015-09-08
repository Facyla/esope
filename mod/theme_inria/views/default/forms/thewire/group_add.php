<?php
/**
 * Wire add to group form body (access limited to group members)
 *
 * @uses $vars['post']
 */

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
$group = elgg_extract('entity', $vars, elgg_get_page_owner_entity());
if (elgg_instanceof($group, 'group')) {
	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $group->guid));
	echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->group_acl));
}

echo '<h3>' . elgg_echo('theme_inria:thewire:group:title') . '</h3>';

echo elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => 'thewire-textarea',
	'placeholder' => elgg_echo('theme_inria:thewire:group:placeholder'),
));
?>

<div class="elgg-foot mts">
	<span style="float:right;">
		<span id="thewire-characters-remaining"><span>140</span></span>
		<?php
		echo elgg_view('input/submit', array(
			'value' => $text,
			'id' => 'thewire-submit-button',
		));
		?>
	</span>
</div>

