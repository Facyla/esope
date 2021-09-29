<?php
/**
 * theme_adf
 *
*/

use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;
use Elgg\Activity\GroupRiverFilter;

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
		'requires' => ['groups', 'members', 'profile', 'notifications', 'search', 'search_advanced', 'activity', 'dashboard'],
		// enabling these should be an option - though recommended, may be disabled
		'suggests' => [
			// content
			'file', 'pages', 'blog', 'bookmarks', 'discussions', 'event_manager', 'thewire', 'thewire_tools', 
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

// Liste des GUIDs des groupes d'un user
// @param $return_type : array | where_clause
function theme_adf_get_user_groups_guids($return_type = 'array') {
	if (!elgg_is_logged_in()) { return false; }
	$user = elgg_get_logged_in_user_entity();
	switch($return_type) {
		case "where_clause":
			$return = [];
			$user_groups = $user->getGroups(['limit' => false]);
			if ($user_groups) {
				foreach($user_groups as $group) {
					$return[] = new GroupRiverFilter($group);
					break;
				}
			}
			break;
		case "sql_in":
			$guids = $user->getGroups([
				'limit' => false,
				'callback' => function ($row) {
					return (int) $row->guid;
				},
			]);
			$return  = implode(',', $guids);
			break;
		case "array":
		default:
			$return = $user->getGroups([
				'limit' => false,
				'callback' => function ($row) {
					return (int) $row->guid;
				},
			]);
	}
	return $return;
}


