<?php
$user = elgg_extract('user', $vars);
$content = '';

// Infos détaillées sur l'entité
if (elgg_is_active_plugin('developers')) {
	// /admin/administer_utilities/logbrowser?user_guid=600
	// /admin/develop_tools/entity_explorer?guid=600
	$content .= elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($user) {
		// Entity Information
		$result = elgg_view('admin/develop_tools/entity_explorer/attributes', ['entity' => $user]);
		
		// Metadata Information
		$result .= elgg_view('admin/develop_tools/entity_explorer/metadata', ['entity' => $user]);
		
		// Relationship Information
		$result .= elgg_view('admin/develop_tools/entity_explorer/relationships', ['entity' => $user]);
		
		// Private Settings Information
		$result .= elgg_view('admin/develop_tools/entity_explorer/private_settings', ['entity' => $user]);
		
		// Owned ACLs
		$result .= elgg_view('admin/develop_tools/entity_explorer/owned_acls', ['entity' => $user]);
		
		// ACL membership
		$result .= elgg_view('admin/develop_tools/entity_explorer/acl_memberships', ['entity' => $user]);
		return $result;
	});
}
if (!empty($content)) {
	echo '<h3 onClick="$(\'#account-lifecycle-user-details\').slideToggle();">Informations détaillées <i class="fa fa-caret-down"></i></h3>';
	echo '<div id="account-lifecycle-user-details">';
	echo $content;
	echo '</div>';
}

