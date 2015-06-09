<?php
/* Social share sharing links
 */
global $CONFIG;

// Add only if set up
if (elgg_get_plugin_setting('extend_owner_block', 'socialshare') != 'yes') { return; }

// We'll add this only for groups/users (sharing links are added to entity menu)
$page_owner = elgg_get_page_owner_entity();
if (elgg_instanceof($page_owner, 'group') && ($page_owner->access_id == 2)) {
	$share_url = $page_owner->getURL();
	echo '<div class="socialshare-links">';
		echo elgg_view('socialshare/extend', array('shareurl' => $share_url));
		echo '<div class="clearfloat"></div>';
	echo '</div>';
}

