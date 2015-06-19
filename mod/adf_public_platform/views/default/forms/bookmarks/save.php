<?php
/**
 * Edit / add a bookmark
 *
 * @package Bookmarks
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$address = elgg_extract('address', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$shares = elgg_extract('shares', $vars, array());
$place = get_input('place');

// Allow to change container (bookmarklet use)
if (!$guid && ($place == 'yes')) {
	?>
	<div>
		<label><?php echo elgg_echo('esope:bookmarks:container'); ?></label><br />
		<?php echo elgg_view('input/groups_select', array('name' => 'container_guid', 'value' => $container_guid, 'scope' => 'member', 'add_owner' => true, 'empty_value' => false, 'filter' => array('name' => 'bookmarks_enable', 'value' => 'yes'))); ?>
	</div>
	<?php
} else {
	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
}
?>
<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo('bookmarks:address'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'address', 'value' => $address)); ?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php
	if (!$guid && ($place == 'yes')) {
		$options_values = get_write_access_array();
		// Note : we cannot define no value because it would mean "do not change", 
		// but we also need to put something that is valid and numeric, in case the bookmarks/save action is overridden
		// and also default marker cannot be used because it is transformed to a real value
		// So : we will use a value that always remain valid, but can be differenciated at save time <=> "00"
		$options_values["00"] = elgg_echo('esope:access_id:restricttocontainer');
		if ($container_guid && ($container = get_entity($container_guid)) && elgg_instanceof($container, 'group')) {
			unset($options_values[$container->group_acl]);
			// Force when using default access, because it applies to groups, which we override in this case
			// And of course also force if group access level has been set (i wonder how), because the option has been removed and replaced
			if (($access_id == ACCESS_DEFAULT) || ($access_id == $container->group_acl)) { $access_id = "00"; }
		}
		$params = array('name' => 'access_id', 'value' => $access_id, 'options_values' => $options_values);
		echo elgg_view('input/access', $params);
	} else {
		echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id));
	}
	?>
</div>

<div class="elgg-foot">
  <?php
  if (!$vars['entity']) echo elgg_view('prevent_notifications/prevent_form_extend', array());

	if ($guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	}

	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	?>
</div>
