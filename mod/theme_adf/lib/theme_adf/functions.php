<?php
/**
 * theme_adf
 *
*/

// Permet l'accès à diverses pages en mode "walled garden"
function theme_adf_public_pages($hook, $type, $return, $params) {
	// Digest
	$return[] = 'digest/.*';
	
	return $return;
}

// Affichage clair des dépendances dans la config du plugin
function theme_adf_plugin_dependencies() {
	$plugin_deps = [
		// not enabling causes missing/unusable features or break functionnality
		'requires' => ['groups', 'members', 'profile', 'notifications', 'search', 'activity', 'dashboard'],
		// enabling these should be an option - though recommended, may be disabled
		'suggests' => [
			// content
			'file', 'pages', 'blog', 'bookmarks', 'discussions', 'event_manager', 'thewire', 
			'digest', 'feedback', 'survey', 'leaflet', 
			// profile & social / registration / custom ACL
			'profile_manager', 'friends', 'friend_request', 'elggx_userpoints', 
			'registration_filter', 'uservalidationbyemail', 'invitefriends', 
			'access_collections', 
			// around content : metadata, rich content and links
			'ckeditor', 'embed', 'likes', 'site_notifications', 'html_email_handler', 
			// admin tools and site management
			'login_as', 'advanced_statistics', 'account_lifecycle', 'content_lifecycle', 'groups_archive', 
			'garbagecollector', 'system_log', 
		],
	];
	return $plugin_deps;
}

