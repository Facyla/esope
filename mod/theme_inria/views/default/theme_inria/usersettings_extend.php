<?php
global $CONFIG;
$owner = elgg_get_page_owner_entity();
?>
<p><a href="<?php echo $CONFIG->url . 'profile/' . $owner->username . '/edit'; ?>" class="elgg-button elgg-button-action"><?php echo elgg_echo('profile:edit'); ?></a></p>
<p><a href="<?php echo $CONFIG->url . 'avatar/edit/' . $owner->username; ?>" class="elgg-button elgg-button-action"><?php echo elgg_echo('avatar:edit'); ?></a></p>
<hr />

