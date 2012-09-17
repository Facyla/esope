<?php
/**
 * Elgg microtheme upload/save form
 *
 * @package ElggMicrothemes
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use 
$title = elgg_extract('title', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$guid = elgg_extract('guid', $vars, null);

if ($guid) {
	$label = elgg_echo("microtheme:background:replace");
} else {
	$label = elgg_echo("microtheme:background:upload");
}

?>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>
<div>
	<label><?php echo elgg_echo("microthemes:color:topbar"); ?></label><br />
	<?php echo elgg_view('input/color', array('name' => 'topbar_color')); ?>
</div>
<div>
	<label><?php echo elgg_echo("microthemes:color:background"); ?></label><br />
	<?php echo elgg_view('input/color', array('name' => 'background_color')); ?>
</div>
<div>
	<label><?php echo $label; ?></label><br />
	<?php echo elgg_view('input/file', array('name' => 'background_image')); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div class="elgg-foot">
<?php
if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>
