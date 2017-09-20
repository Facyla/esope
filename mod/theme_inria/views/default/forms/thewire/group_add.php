<?php
/**
 * Wire add to group form body (access limited to group members)
 *
 * @uses $vars['post']
 */

$group = elgg_extract('entity', $vars, elgg_get_page_owner_entity());
$own = elgg_get_logged_in_user_entity();

// Wire in groups is only available to group members (or admins)
if (!elgg_instanceof($group, 'group')) { return; }
if (!$group->isMember() && !elgg_is_admin_logged_in()) { return; }
elgg_load_js('elgg.thewire');

$post = elgg_extract('post', $vars);
$char_limit = (int)elgg_get_plugin_setting('limit', 'thewire', 140);

$text = elgg_echo('post');
if ($post) {
	$text = elgg_echo('thewire:reply');
}

$id = 'thewire-textarea';

if ($post) {
	echo elgg_view('input/hidden', array(
		'name' => 'parent_guid',
		'value' => $post->guid,
	));
	$id = 'thewire-textarea-' . $post->guid;
}

// Integration into groups : add container
echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $group->guid));
// Also force access to the group members
//echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->group_acl));

$count_down = "<span>$char_limit</span>";
$num_lines = 3;
if ($char_limit == 0) {
	$num_lines = 4;
	$count_down = '';
} else if ($char_limit > 140) {
	$num_lines = 4;
}

if (!elgg_in_context('workspace')) {
	echo '<img src="' . $own->getIconUrl(array('size' => 'small')) . '" alt="' . $own->name . '" />';
}

echo elgg_view('input/plaintext', array(
	'name' => 'body',
	'class' => 'mtm',
	'id' => $id,
	'rows' => $num_lines,
	'data-max-length' => $char_limit,
	'style' => "height:initial;",
	'placeholder' => elgg_echo('theme_inria:thewire:group:placeholder', array($char_limit)),
));
?>

<div class="elgg-foot mts">
	<span style="float:right; margin-left:2em;">
		<span id="thewire-characters-remaining"><?php echo $count_down; ?></span>
		<?php
		echo elgg_view('input/submit', array(
			'value' => $text,
			'id' => 'thewire-submit-button',
		));
		?>
	</span>
	<?php
	
	// Force to group access if content access mode enabled
	if ($group->getContentAccessMode() === ElggGroup::CONTENT_ACCESS_MODE_MEMBERS_ONLY) {
		// Group members only
		echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->group_acl));
		echo elgg_view('output/access', array('value' => $group->group_acl));
		/*
		// Same as group visibility
		echo elgg_view('input/hidden', array('name' => 'access_id', 'value' => $group->access_id));
		echo elgg_view('output/access', array('value' => $group->access_id));
		*/
	} else {
		$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
		$inria_access_id = theme_inria_get_inria_access_id();
		// Only Inria only can select access (defaults to Inria only))
		$access_id = elgg_extract('access_id', $vars, $inria_access_id);
		$access_opt = array();
		
		//$access_opt[$group->group_acl] = get_readable_access_level($group->group_acl);
		// Note : we can access the real collection name by getting the collection, 
		// but a plain translation is fine in that case (we don't need the group name)
		//$group_acl = get_access_collection($group->group_acl);
		$main_group = theme_inria_get_main_group($group);
		if ($group->guid == $main_group->guid) {
			$access_opt[$group->group_acl] = elgg_echo('access:GROUP_MEMBERS');
		} else {
			$access_opt[$group->group_acl] = elgg_echo('workspaceaccess:GROUP_MEMBERS');
		}
		
		if ($inria_access_id && (esope_get_user_profile_type() == 'inria')) { $access_opt[$inria_access_id] = elgg_echo('profiletype:inria'); }
		$access_opt['1'] = elgg_echo('LOGGED_IN');
		echo elgg_view('input/select', array('name' => 'access_id', 'value' => $access_id, 'options_values' => $access_opt));
	}
	?>
	
</div>

