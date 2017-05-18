<?php

$group = elgg_get_page_owner_entity();

$url = elgg_get_site_url();


if (!elgg_instanceof($vars['entity'], 'group')) {
	echo '<h3>' . elgg_echo('groups:about') . '</h3>';
}
?>

<div class="groups-edit-field">
	<div class="groups-edit-label">
		<label><?php echo elgg_echo("groups:banner"); ?></label>
	</div>
	<div class="groups-edit-input"
		<?php echo elgg_view("input/file", array("name" => "banner")); ?>
	</div>
</div>


