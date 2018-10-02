<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');


/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;
	
	$action_url = elgg_get_plugins_path() . 'theme_inria/actions/';
	
	// HTML export action
	//elgg_register_action("pages/html_export", $action_url . "pages/html_export.php", "public");
	// Inria members user add
	elgg_register_action("inria_useradd", $action_url . "inria_useradd.php", "logged_in");
	// Inria members admin tools
	elgg_register_action("inria_remove_user_email", $action_url . "inria_remove_user_email.php", "logged_in");
	elgg_register_action("inria_archive_user", $action_url . "inria_archive_user.php", "logged_in");
	elgg_register_action("inria_unarchive_user", $action_url . "inria_unarchive_user.php", "logged_in");
	
	elgg_register_action("theme_inria/favorite", $action_url . "theme_inria/favorite_toggle.php", "logged_in");
	
	// Modified to make pages top_level / sub-pages
	//elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	// Rewrite friends and friends request to remove river entries
	elgg_unregister_action('friends/add');
	elgg_unregister_action('friend_request/approve');
	elgg_register_action("friends/add", $action_url . "friends/add.php", "logged_in");
	elgg_register_action("friend_request/approve", $action_url . "friend_request/approve.php", "logged_in");
	
	// Rewrite file upload action to avoid river entries for file images + quick upload
	elgg_unregister_action('file/upload');
	elgg_register_action("file/upload", $action_url . "file/upload.php");
	elgg_register_action("file/upload_version", $action_url . "file/upload_version.php");
	// Rewrite discussion save action for quick save
	elgg_unregister_action('discussion/save');
	elgg_register_action("discussion/save", $action_url . "discussion/save.php");
	
	// Use custom searches
	//elgg_register_action("theme_inria/search", $action_url . "theme_inria/search.php");
	elgg_register_action("theme_inria/membersearch", $action_url . "theme_inria/membersearch.php");
	elgg_register_action("theme_inria/groupsearch", $action_url . "theme_inria/groupsearch.php");
	
	// Per-group notificaiton settings
	elgg_register_action("theme_inria/group_notification", $action_url . "theme_inria/group_notification.php");
	// Force site notifications
	elgg_unregister_action("notificationsettings/save");
	elgg_register_action("notificationsettings/save", $action_url . "notifications/save.php");
	elgg_unregister_action("notificationsettings/groupsave");
	elgg_register_action("notificationsettings/groupsave", $action_url . "notifications/groupsave.php");
	
	// Group invites
	elgg_register_action("group/membership/join", $action_url . "groups/membership/join.php");
	elgg_register_action("groups/parent_group_invite", $action_url . "groups/membership/parent_group_invite.php");
	
	// Blog drafts
	elgg_unregister_action('blog/save');
	elgg_register_action("blog/save", $action_url . "blog/save.php");
	
	// Site notifications : remove all
	elgg_register_action('site_notifications/remove_all', $action_url . "site_notifications/remove_all.php");
	
	
	// CSS - Inria custom styles
	$css_url = elgg_get_site_url() . 'mod/theme_inria/fonts/';
	elgg_register_css('inria-sans', $css_url.'InriaSans/Web/fonts.css');
	elgg_register_css('inria-serif', $css_url.'InriaSerif/Web/fonts.css');
	elgg_load_css('inria-sans');
	elgg_load_css('inria-serif');
	
	elgg_extend_view('css', 'theme_inria/css', 1000);
	elgg_extend_view('css', 'transalgo/css', 1000);
	elgg_extend_view('css/admin', 'theme_inria/admin_css', 1000);
	elgg_extend_view('css/digest/core', 'css/digest/site/theme_inria');
	
	
	$js = elgg_get_simplecache_url('js', 'esope/event_calendar_adjust_end_dates');
	elgg_register_js('esope.event_calendar_adjust_end_dates', $js);
	elgg_load_js('esope.event_calendar_adjust_end_dates');
	
	elgg_extend_view('newsletter/sidebar/steps', 'theme_inria/newsletter_sidebar_steps');
	
	// Extend user owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_user_owner_block', 501);
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_group_owner_block', 501);
	elgg_unextend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
	elgg_extend_view('groups/sidebar/search', 'au_subgroups/sidebar/subgroups', 300);
	//elgg_extend_view('groups/sidebar/search', 'theme_inria/extend_group_my_status', 600);
	
	// Rewritten in a more specific way for Iris theme
	elgg_unextend_view('forms/login', 'elgg_cas/login_extend');
	
	// Removed from header and integrated under online group members
	// see theme_inria/views/default/groups/sidebar/online_groupmembers.php
	//elgg_unextend_view('page/elements/header', 'group_chat/groupchat_extend');
	
	elgg_extend_view('forms/profile/edit', 'theme_inria/profile_linkedin_import', 200);
	
	// Add group profile banner : more control directly in views
	//elgg_extend_view('groups/edit/profile', 'theme_inria/groups/extend_edit_profile', 400);
	
	// Add RSS feed option
	//add_group_tool_option('rss_feed', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with RSS feed reader
	// Note : directly integrated in groups/profile/widgets
	//elgg_extend_view('groups/tool_latest', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('groups/profile/summary', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('page/elements/sidebar', 'simplepie/sidebar_simplepie_module', 501);
	
	// Supprimer le suivi de l'activité (car toujours activé sur home du groupe)
	remove_group_tool_option('activity');
	// Supression option de gestion des dossiers (totalement inutile car dossiers désactivés)
	remove_group_tool_option('file_tools_structure_management');
	
	// Add CMIS folder option
	//add_group_tool_option('cmis_folder', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with CMIS folder
	//elgg_extend_view('groups/tool_latest', 'elgg_cmis/group_cmisfolder_module', 501);
	// Displays only if ->cmisfolder is set
	//elgg_extend_view('page/elements/sidebar', 'elgg_cmis/group_cmisfolder_sidebar', 501);
	
	// Extend public profile settings
	elgg_extend_view('core/settings/account', 'theme_inria/usersettings_extend', 100);
	//elgg_extend_view('adf_platform/account/public_profile', 'theme_inria/usersettings_extend', 501);
	
	// Export HTML des pages wiki (dans le menu de la page - cf. object/page_top pour chaque entité)
	//elgg_extend_view('page/elements/owner_block', 'theme_inria/html_export_extend', 200);
	
	// Add elements to site digest
	elgg_extend_view('digest/elements/site', 'digest/elements/site/thewire', 503);
	//elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600); // already extended by esope
	
	// Add preview link to newsletter edit form (page menu is not displayed in new design Iris v2)
	elgg_extend_view('forms/newsletter/edit/content', 'forms/newsletter/extend_preview', 900);
	elgg_extend_view('forms/newsletter/edit/recipients', 'forms/newsletter/extend_preview', 900);
	elgg_extend_view('forms/newsletter/edit/schedule', 'forms/newsletter/extend_preview', 900);
	elgg_extend_view('forms/newsletter/edit/template', 'forms/newsletter/extend_preview', 900);
	
	// Add email invites to groups
	elgg_extend_view('forms/groups/invite', 'forms/groups/email_invite', 1001);
	// Add parent group invites to groups
	//elgg_extend_view('forms/groups/invite', 'forms/groups/parent_group_invite', 1001);
	
	// Avoid feedback being hidden with main menu
	if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") == "yes" || elgg_is_logged_in()) {
		elgg_unextend_view('page/elements/footer', 'feedback/footer');
		elgg_extend_view('page/elements/foot', 'feedback/footer');
	}
	
	// Add analytics (default extends page/elements/footer)
	elgg_extend_view('page/elements/footer_main', 'page/elements/analytics');
	
	elgg_extend_view('forms/site_notifications/process', 'theme_inria/site_notifications/remove_all');
	
	// WIDGETS
	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	if (elgg_is_active_plugin('thewire')) {
		$widget_thewire = elgg_get_plugin_setting('widget_thewire', 'esope');
		elgg_unregister_widget_type('thewire');
		if ($widget_thewire != 'no') {
			elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
		}
	}
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', elgg_echo('theme_inria:widgets:tools'), elgg_echo('theme_inria:widgets:tools:details'), array('dashboard'), false);
	//elgg_register_widget_type('inria_partage', "Partage", "Accès à Partage", 'dashboard');
	
	// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_page_handler('esope_index');
		elgg_register_page_handler('', 'theme_inria_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_page_handler('esope_public_index');
			elgg_register_page_handler('', 'theme_inria_public_index');
		}
	}
	
	// Menus
	elgg_register_event_handler('pagesetup', 'system', 'theme_inria_setup_menu');
	// User actions
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_inria_user_hover_menu');
	// Entity menu : remove "thread" (thewire), members count in group listing menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'theme_inria_entity_menu_setup', 900);
	// River menu
	elgg_register_plugin_hook_handler('register', 'menu:river', 'theme_inria_river_menu_setup', 900);
	// River menu
	elgg_register_plugin_hook_handler('register', 'menu:extras', 'theme_inria_extras_menu_setup', 900);
	
	// Add new image to group edit
	elgg_register_event_handler('create', 'group', 'theme_inria_groups_edit_event_listener');
	elgg_register_event_handler('update', 'group', 'theme_inria_groups_edit_event_listener');
	
	// Enable modifying members count algo
	elgg_register_plugin_hook_handler('members', 'count', 'theme_inria_members_count_hook');
	
	/* Override object icons with images (but we use FA icons)
	// Set object icons
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'theme_inria_object_icon_hook');
	*/
	
	// Ajout niveau d'accès sur TheWire : désormais intégré dans Esope (ainsi que possibilité de définir un container)
	/*
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	*/
	
	// Remplacement du modèle d'event_calendar correction
	elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_inria/lib/event_calendar/model.php');
	
	// Check access validity and update meta fields (inria/external, active/closed)
	elgg_register_event_handler('login:before','user', 'inria_check_and_update_user_status', 900);
	
	// Remove unwanted widgets
	//elgg_unregister_widget_type('river_widget');
	
	
	// PAGE HANDLERS
	elgg_register_page_handler("inria", "inria_page_handler");
	
	// TransAlgo
	elgg_register_page_handler("transalgo", "transalgo_page_handler");
	
	// Add a "ressources" page handler for groups
	elgg_register_page_handler("ressources", "inria_ressources_page_handler");
	
	// Override activity PH
	elgg_register_page_handler('activity', 'theme_inria_elgg_river_page_handler');
	// Override thewire PH
	elgg_register_page_handler('thewire', 'theme_inria_thewire_page_handler');
	// Override search PH
	elgg_register_page_handler('search', 'theme_inria_search_page_handler');
	elgg_register_page_handler('members', 'theme_inria_members_page_handler');
	elgg_register_page_handler('groups', 'theme_inria_groups_page_handler');
	elgg_register_page_handler('group_operators', 'theme_inria_group_operators_page_handler');
	elgg_register_page_handler('au_subgroups', 'theme_inria_au_subgroups_page_handler');
	// Override profile page
	elgg_register_page_handler('profile', 'theme_inria_profile_page_handler');
	
	
	// Gestion des redirections et URL modifiées par le plugin (contenu des groupes essentiellement)
	elgg_register_plugin_hook_handler('route', 'all', 'theme_inria_route');
	
	// Add tool entry to group menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_inria_thewire_group_menu');
	// Add link to longtext menu
	//elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	
	// Modification des menus standards des widgets
	// Note : plus utile car on utilise FA d'emblée
	//elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'esope_elgg_widget_menu_setup');
	//elgg_register_plugin_hook_handler('register', 'menu:widget', 'theme_inria_widget_menu_setup');
	
	// Add Etherpad (and iframes) embed
	elgg_register_plugin_hook_handler('register', 'menu:embed', 'theme_inria_select_tab', 801);
	
	// Add message to user listing view
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'theme_inria_user_menu_setup');
	
	// Filtrage des contenus saisis
	if (elgg_is_active_plugin('htmlawed')) {
		elgg_unregister_plugin_hook_handler('validate', 'input', 'esope_htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('validate', 'input', 'theme_inria_htmlawed_filter_tags', 1);
	}
	
	// Use a custom method to get and update profile data
	if (elgg_is_active_plugin('ldap_auth')) {
		// Note that Inria uses settings only for server config
		// Fields config is not a simple mapping and is hard-coded
		elgg_register_plugin_hook_handler('check_profile', 'ldap_auth', 'theme_inria_ldap_check_profile');
		//elgg_register_plugin_hook_handler('update_profile', 'ldap_auth', 'theme_inria_ldap_update_profile');
		//elgg_register_plugin_hook_handler('clean_group_name', 'ldap_auth', 'theme_inria_ldap_clean_group_name');
	}
	
	// Register cron hook
	// @TODO attendre le GO de la DSI avant activation !
	$ldap_cron = elgg_get_plugin_setting('ldap_cron', 'theme_inria');
	if ($ldap_cron == 'yes') {
		elgg_register_plugin_hook_handler('cron', 'hourly', 'theme_inria_daily_cron');
	}
	
	// Allow to intercept and block email sending under some conditions (disabled account mainly)
	// The hook is triggered when using default elgg email handler, 
	// and is added and triggered by ESOPE when using plugins that replace it
	// Priority is set so it intercepts notification right before html_email_handler, and after notification_messages
	elgg_register_plugin_hook_handler('email', 'system', 'theme_inria_block_email', 499);
	
	// Hook pour bloquer les notifications dans certains groups si on a demandé à les désactiver
	// 1) Blocage pour les nouveaux objets
	// Note : load at first, because we want to block the process early, if it needs to be blocked
	// if a plugin hook send mails before and returns "true" this would be too late
	elgg_register_plugin_hook_handler('send:before', 'notifications', 'theme_inria_send_before_notifications_block', 1);
	/* 2) Blocage pour les réponses (annotations)
	 * Process : 
	 		action discussion/replies/save exécute un ->annotate('group_topic_post',...)
	 		create_annotation lance un event (qui peut exécuter des choses mais ne change pas le comportement)
	 		puis ajoute l'annotation, et lance un event create,annotation
	 		qui exécute, notamment, l'envoi d'email par comment_tracker et advanced_notifications
	 		Moyens de blocage dans comment_tracker : les users sont récupérés via leurs préférences d'abonnement
 			ce qui permet de spécifier un désabonnement au préalable, de manière à ne pas abonner à chaque commentaire
	 */
	// See html_email_handler :
	// Block annotations : use hook on notify:annotation:message => return false
	// @TODO  : non opérationnel car pas de moyen de bloquer à temps les notifications, envoyées via divers plugins qui s'appuient des events...
	//elgg_register_plugin_hook_handler('notify:annotation:message', 'group_topic_post', 'theme_inria_annotation_notifications_block', 1000);
	elgg_register_event_handler('create','annotation','theme_inria_annotation_notifications_event_block', 1);
	// Unregister advanced notification event to avoid sending reply twice
	// @TODO : move to ESOPE ?
	if (elgg_is_active_plugin('comment_tracker') && elgg_is_active_plugin('advanced_notifications')) {
		elgg_unregister_event_handler("create", "annotation", "advanced_notifications_create_annotation_event_handler");
	}
	
	// Override default icons (with images only !) - late so previous plugins have already set their own icon if applicable
	//elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'theme_inria_object_icon_hook', 1000);
	
	// Custom changes (for profile-type-based background color)
	
	elgg_unregister_plugin_hook_handler('entity:icon:url', 'user', 'default_icons_user_hook');
	elgg_register_plugin_hook_handler('entity:icon:url', 'user', 'theme_inria_user_icon_hook', 1000);
	
	// HTML head
	elgg_register_plugin_hook_handler('head', 'page','theme_inria_page_head_hook');
	
	// Intercept membership requests so we can notify the operators
	elgg_register_event_handler('create','relationship','theme_inria_create_relationship_event');
	
	// Block adding content to main group if defined so in group settings
	elgg_register_plugin_hook_handler('container_permissions_check', 'all', 'theme_inria_groups_container_override', 502); // Must run after core hook
	
	// Public pages - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'theme_inria_public_pages');
	
	
	require_once('vendors/EmojiDetection/Emoji.php');
	elgg_register_plugin_hook_handler('validate', 'input', 'theme_inria_emoji_input');
	elgg_register_plugin_hook_handler('view', 'output/longtext', 'theme_inria_emoji_output');
	//elgg_register_event_handler("create", "object", "theme_inria_thewire_handler_event", 0);
	elgg_unregister_action('thewire/add');
	$thewire_action_path = elgg_get_plugins_path() . 'theme_inria/actions/thewire/';
	elgg_register_action("thewire/add", $thewire_action_path . 'add.php');
}

// Include Inria page handlers
require_once(dirname(__FILE__) . '/lib/theme_inria/page_handlers.php');
// Include Inria functions
require_once(dirname(__FILE__) . '/lib/theme_inria/functions.php');
// Include events handlers
require_once(dirname(__FILE__) . '/lib/theme_inria/events.php');
// Include core and plugins hooks
require_once(dirname(__FILE__) . '/lib/theme_inria/hooks.php');





// Returns Elgg fields coming from LDAP
function inria_get_profile_ldap_fields() {
	$ldap_fields = array(
			'inria_location_main', // Centre de rattachement
			'inria_location', // Localisation
			'epi_ou_service', // EPI ou service
			'inria_room', // Bureau
			'inria_phone', // Téléphone
		);
	return $ldap_fields;
}



function theme_inria_get_community_groups($community = false, $count = false) {
	if (empty($community)) { return false; }
	
	$options = array('type' => 'group', 'metadata_name_value_pairs' => array('name' => 'community', 'value' => $community));
	if ($count) { $options['count'] = true; }
	return elgg_get_entities_from_metadata($options);
}


// Get main (top parent) group from current page owner / workspace
function theme_inria_get_main_group($main_group) {
	if (!elgg_instanceof($main_group, 'group')) { return false; }
	// Find top level parent
	$parent = AU\SubGroups\get_parent_group($main_group);
	if ($parent) {
		$main_group = $parent;
		while ($parent = AU\SubGroups\get_parent_group($parent)) { $main_group = $parent; }
	}
	return $main_group;
}

// Get active group members (= not closed account)
function theme_inria_get_group_active_members($group, $options = array()) {
	// Filter out closed accounts
	$options['wheres'][] = theme_inria_active_members_where_clause();
	return $group->getMembers($options);
}
// Active group members SQL WHERE clause (= not closed account)
function theme_inria_active_members_where_clause() {
	return "NOT EXISTS (
			SELECT 1 FROM " . elgg_get_config('dbprefix') . "metadata md
			WHERE md.entity_guid = e.guid
			AND md.name_id = " . elgg_get_metastring_id('memberstatus') . "
			AND md.value_id = " . elgg_get_metastring_id('closed') . "
		)";
}


// Returns valid objects subtypes filter in a group (for elgg_get_entities_)
// note : always force files as they can be published through embeds
function theme_inria_group_object_subtypes($group) {
	$subtypes = array();
	// Files can always be added, even if disabled
	$subtypes[] = 'file';
	// A comment can always happen - but this will not work as comments have container_guid set to commented entity
	//$subtypes[] = 'comment';
	if ($group->blog_enable == 'yes') { $subtypes[] = 'blog'; }
	if ($group->bookmarks_enable == 'yes') { $subtypes[] = 'bookmarks'; }
	// Forums : handle topic and replies - no reply will not be displayed, as their container is the parent groupforumtopic
	if ($group->forum_enable == 'yes') { $subtypes[] = 'groupforumtopic'; $subtypes[] = 'discussion_reply'; }
	// Pages : all pages
	if ($group->pages_enable == 'yes') { $subtypes[] = 'page_top'; $subtypes[] = 'page'; }
	if ($group->thewire_enable == 'yes') { $subtypes[] = 'thewire'; }
	if ($group->event_calendar_enable == 'yes') { $subtypes[] = 'event_calendar'; }
	if ($group->newsletter_enable == 'yes') { $subtypes[] = 'newsletter'; }
	if ($group->survey_enable == 'yes') { $subtypes[] = 'survey'; }
	if ($group->poll_enable == 'yes') { $subtypes[] = 'poll'; }
	return $subtypes;
}

// Returns valid objects subtypes filter options in a group
// note : always force files as they can be published through embeds
function theme_inria_group_object_subtypes_opt($group) {
	$subtypes = array('' => '');
	// Files can always be added, even if disabled
	$subtypes['file'] = elgg_echo('item:object:file');
	// A comment can always happen - will not work as comments have container_guid set to commented entity
	//$subtypes['comment'] = elgg_echo('item:object:comment');
	if ($group->blog_enable == 'yes') { $subtypes['blog'] = elgg_echo('item:object:blog'); }
	if ($group->bookmarks_enable == 'yes') { $subtypes['bookmarks'] = elgg_echo('item:object:bookmarks'); }
	if ($group->forum_enable == 'yes') { $subtypes['discussion'] = elgg_echo('item:object:groupforumtopic'); }
	if ($group->pages_enable == 'yes') { $subtypes['pages'] = elgg_echo('item:object:pages'); }
	//if ($group->pages_enable == 'yes') { $subtypes['page_top'] = elgg_echo('item:object:page_top'); }
	//if ($group->pages_enable == 'yes') { $subtypes['page'] = elgg_echo('item:object:page'); }
	if ($group->thewire_enable == 'yes') { $subtypes['thewire'] = elgg_echo('item:object:thewire'); }
	if ($group->event_calendar_enable == 'yes') { $subtypes['event_calendar'] = elgg_echo('item:object:event_calendar'); }
	if ($group->newsletter_enable == 'yes') { $subtypes['newsletter'] = elgg_echo('item:object:newsletter'); }
	if ($group->survey_enable == 'yes') { $subtypes['survey'] = elgg_echo('item:object:survey'); }
	if ($group->poll_enable == 'yes') { $subtypes['poll'] = elgg_echo('item:object:poll'); }
	if (elgg_is_active_plugin('feedback')) {
		$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
		if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
			if (($feedbackgroup == 'grouptool' && ($group->feedback_enable == 'yes')) || ($feedbackgroup == $group->guid)) {
				$subtypes['feedback'] = elgg_echo('item:object:feedback');
			}
		}
	}
	
	return $subtypes;
}


// Returns the proper URL for a group (or workspace) in a given context
function theme_inria_get_group_tab_url($group, $link_type = 'home') {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	switch($link_type) {
		case 'edit':
			return elgg_get_site_url() . 'groups/edit/' . $group->guid;
			break;
		case 'invite':
			return elgg_get_site_url() . 'groups/invite/' . $group->guid;
			break;
		case 'members':
			return elgg_get_site_url() . 'groups/members/' . $group->guid;
			break;
		case 'workspace':
			return elgg_get_site_url() . 'groups/workspace/' . $group->guid;
			break;
		case 'home':
		default:
			return $group->getURL();
	}
}


// Get the custom access level based on profile type
function theme_inria_get_inria_access_id() {
	if (elgg_is_active_plugin('access_collections')) {
		$inria_collection = access_collections_get_collection_by_name('profiletype:inria');
		if ($inria_collection) { return $inria_collection->id; }
	}
	return false;
}


/* Get a title for interface links
 * If a translation exists, use it
 * Otherwise try to use cmspage
 */
function theme_inria_get_link_title($key, $use_cmspages = false) {
	return theme_inria_get_translation('linktitle:' . $key);
}

/* Check if a translation exists before retuning it
 */
function theme_inria_get_translation($key, $use_cmspages = false) {
	$translated = elgg_echo($key);
	if ($translated != $key) { return $translated; }
	
	if ($use_cmspages && elgg_is_active_plugin('cmspages')) {
		$cmspage = cmspages_get_entity($pagetype);
		if ($cmspage) {
			$translated = $cmspage->description;
			if (!empty($translated)) { return $translated; }
		}
	}
	
	return false;
}


// EMOJI SUPPORT
// 👶 👧 👦 👩👵👳 ♂ 👩⚕ 👩🌾 👨🍳 👩‍🎤
// Input text filter, used to validate text content, extract data, replace strings, etc.
// Note : Wire input uses a custom getter
function theme_inria_emoji_input($hook, $type, $input, $params) {
	$emojis = Emoji\detect_emoji($input);
	$map = Emoji\_load_map();
	if (count($emojis) > 0) {
		error_log("EMOJI detected");
		foreach($emojis as $emoji) {
			$replace_map['emojis'][] = $emoji['emoji'];
			$replace_map['shortcodes'][] = ':' . $emoji['short_name'] . ':';
			//$replace_map['html'][] = '&#x' . $emoji['hex_str'];
			$replace_map['html'][] = '&#x' . str_replace('-', '&#x', $emoji['hex_str']);
			error_log('&#x' . str_replace('-', '&#x', $emoji['hex_str']));
			//$replace_map['html'][] = '&#x' . implode('&#x', $emoji['points_hex']);
			//error_log('&#x' . implode('&#x', $emoji['points_hex']));
			//error_log(" => " . print_r($emoji, true));
		}
		// Replace by shortcodes // Caution in editors - will be displayed as the shortcode
		//$input = str_replace($replace_map['emojis'], $replace_map['shortcodes'], $input);
		// Replace by HTML codepoint text
		$input = str_replace($replace_map['emojis'], $replace_map['html'], $input);
	}
	return $input;
}
// Add colon padding for unicode emoji shortcodes
function theme_inria_emoji_pad(&$text) { $text = ":$text:"; }
// Add HTML representation of codepoint
function theme_inria_emoji_html_codepoint(&$codepoint) { $codepoint = "&#x$codepoint"; }
// Get replacement map for text emojis
function theme_inria_emoji_get_map() {
	static $replace_map = 1;
	if (!is_array($replace_map)) {
		$emojis_map = Emoji\_load_map();
		$emojis = array_keys($emojis_map);
		array_walk($emojis, 'theme_inria_emoji_html_codepoint');
		$text = array_values($emojis_map);
		array_walk($text, 'theme_inria_emoji_pad');
		$replace_map = [
			'emojis' => $emojis,
			'text' => $text,
		];
	}
	return $replace_map;
}
/* Prepare emjoi for display
 * replace emoji text value with emoji
 * or make HTML codepoint viewable
 */
function theme_inria_emoji_output($hook, $type, $text, $params) {
	$replace_map = theme_inria_emoji_get_map();
	// Make HTML emojis displayable
	$text = str_replace('&amp;#x', '&#x', $text);
	// Convert shortcodes to emojis
	$text = str_replace($replace_map['text'], $replace_map['emojis'], $text);
	return $text;
}

/**
 * Replace urls, hash tags, and @'s by links
 *
 * @param string $text The text of a post
 * @return string
 */
function theme_inria_thewire_filter($text) {
	global $CONFIG;
	$text = ' ' . $text;
	// email addresses
	$text = preg_replace(
				'/(^|[^\w])([\w\-\.]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})/i',
				'$1<a href="mailto:$2@$3">$2@$3</a>',
				$text);
	// links
	$text = parse_urls($text);
	// usernames
	$text = preg_replace(
				'/(^|[^\w])@([\p{L}\p{Nd}._]+)/u',
				'$1<a href="' . $CONFIG->wwwroot . 'thewire/owner/$2">@$2</a>',
				$text);
	// hashtags => avoid &#xXXXX being interpreted as hashtag (Unicode codepoint)
	$text = preg_replace(
				//'/(^|[^\w])#(\w*[^\s\d!-\/:-@]+\w*)/',
				'/(^|[^\w|\&])#(\w*[^\s\d!-\/:-@]+\w*)/',
				'$1<a href="' . $CONFIG->wwwroot . 'thewire/tag/$2">#$2</a>',
				$text);
	$text = trim($text);
	return $text;
}

/* Support Wire posts content
function theme_inria_thewire_handler_event($event, $type, $object) {
//	if (!empty($object) && elgg_instanceof($object, "object", "thewire")) {
		$text = get_input('body', '', false);
		error_log("TEXT : $text");
		$text = theme_inria_emoji_input('', '', $text, []);
		// no html tags allowed so we escape
		$text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
		error_log(" => $text");
		set_input('body', $text);
		//$object->description = $text;
		// Update entity
		//$object->save();
//	}
	// Return false halts the process, true or no return is equivalent
}
 */


