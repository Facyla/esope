<?php
$owner = elgg_get_page_owner_entity();
?>
<p>
	<?php echo elgg_echo('theme_inria:publicprofile:othersettings'); ?>&nbsp;: 
	<a href="<?php echo elgg_get_site_url() . 'profile/' . $owner->username . '/edit'; ?>" class="elgg-button elgg-button-action"><?php echo elgg_echo('profile:edit'); ?></a> &nbsp; 
	<a href="<?php echo elgg_get_site_url() . 'avatar/edit/' . $owner->username; ?>" class="elgg-button elgg-button-action"><?php echo elgg_echo('avatar:edit'); ?></a>
</p>

