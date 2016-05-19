<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');


/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;
	$action_url = dirname(__FILE__) . "/actions/";
	
	// HTML export action
	elgg_register_action("pages/html_export", $action_url . "pages/html_export.php", "public");
	// Inria members user add
	elgg_register_action("inria_useradd", $action_url . "inria_useradd.php", "logged_in");
	// Inria members admin tools
	elgg_register_action("inria_remove_user_email", $action_url . "inria_remove_user_email.php", "logged_in");
	elgg_register_action("inria_archive_user", $action_url . "inria_archive_user.php", "logged_in");
	elgg_register_action("inria_unarchive_user", $action_url . "inria_unarchive_user.php", "logged_in");
	
	// Modified to make pages top_level / sub-pages
	//elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	// Rewrite friends and friends request to remove river entries
	elgg_unregister_action('friends/add');
	elgg_unregister_action('friend_request/approve');
	elgg_register_action("friends/add", $action_url . "friends/add.php", "logged_in");
	elgg_register_action("friend_request/approve", $action_url . "friend_request/approve.php", "logged_in");
	
	// Rewrite file upload action to avoid river entries for file images
	elgg_unregister_action('file/upload');
	elgg_register_action("file/upload", $action_url . "file/upload.php");
	
	elgg_extend_view('css', 'theme_inria/css');
	elgg_extend_view('css/admin', 'theme_inria/admin_css');
	elgg_extend_view('css/digest/core', 'css/digest/site/theme_inria');
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
	elgg_unextend_view('page/elements/header', 'group_chat/groupchat_extend');
	
	elgg_extend_view('forms/profile/edit', 'theme_inria/profile_linkedin_import', 200);
	
	// Add RSS feed option
	//add_group_tool_option('rss_feed', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with RSS feed reader
	// Note : directly integrated in groups/profile/widgets
	//elgg_extend_view('groups/tool_latest', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('groups/profile/summary', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('page/elements/sidebar', 'simplepie/sidebar_simplepie_module', 501);
	
	// Supprimer le suivi de l'activité (car toujours activé sur home du groupe)
	remove_group_tool_option('activity');
	
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
	
	// Add all groups excerpt to digest
	elgg_extend_view('digest/elements/site', 'digest/elements/site/thewire', 503);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
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
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_inria_user_hover_menu');
	
	
	// Ajout niveau d'accès sur TheWire : désormais intégré dans Esope (ainsi que possibilité de définir un container)
	/*
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	*/
	
	// Remplacement du modèle d'event_calendar
	// @TODO : inutile avec version pour Elgg 1.12 ?
	//elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_inria/lib/event_calendar/model.php');
	
	// Check access validity and update meta fields (inria/external, active/closed)
	elgg_register_event_handler('login:before','user', 'inria_check_and_update_user_status', 900);
	
	// Remove unwanted widgets
	//elgg_unregister_widget_type('river_widget');
	
	
	// PAGE HANDLERS
	elgg_register_page_handler("inria", "inria_page_handler");
	
	// Add a "ressources" page handler for groups
	elgg_register_page_handler("ressources", "inria_ressources_page_handler");
	
	// Override activity PH
	elgg_register_page_handler('activity', 'theme_inria_elgg_river_page_handler');
	// Override thewire PH
	elgg_register_page_handler('thewire', 'theme_inria_thewire_page_handler');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'theme_inria_thewire_group_menu');
	// Add link to longtext menu
	//elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	
	// Modification des menus standards des widgets
	// Note : plus utile car on utilise FA d'emblée
	//elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'esope_elgg_widget_menu_setup');
	//elgg_register_plugin_hook_handler('register', 'menu:widget', 'theme_inria_widget_menu_setup');
	
	// Add Etherpad (and iframes) embed
	elgg_register_plugin_hook_handler('register', 'menu:embed', 'theme_inria_select_tab', 801);
	
	
	// Modify message and add attachments to event notifications
	if (elgg_is_active_plugin('html_email_handler')) {
		// Modify default events notification message
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'event_calendar_ics_notify_message');
		// Use hook to add attachments
		elgg_register_plugin_hook_handler('notify:entity:params', 'object', 'event_calendar_ics_notify_attachment');
	}
	// Interception création event pour ajouter l'auteur aux personnes notifiées
	elgg_register_event_handler('create','object', 'theme_inria_notify_event_owner', 900);
	
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
	
}

// Include Inria page handlers
require_once(dirname(__FILE__) . '/lib/theme_inria/page_handlers.php');
// Include Inria functions
require_once(dirname(__FILE__) . '/lib/theme_inria/functions.php');
// Include events handlers
require_once(dirname(__FILE__) . '/lib/theme_inria/events.php');
// Include core and plugins hooks
require_once(dirname(__FILE__) . '/lib/theme_inria/hooks.php');




// Add thewire menu in group tools
function theme_inria_thewire_group_menu($hook, $type, $return, $params) {
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_instanceof($page_owner, 'group')) {
		if ($page_owner->isMember() || elgg_is_admin_logged_in()) {
			$add_wire = elgg_get_plugin_setting('groups_add_wire', 'adf_public_platform');
			switch ($add_wire) {
				case 'yes': break; 
				case 'groupoption':
					if ($page_owner->thewire_enable != 'yes') { return $return; }
					break; 
				default: return $return;
			}
			$title = elgg_echo('theme_inria:thewire:group:title');
			$return[] = new ElggMenuItem('thewire_group', $title, 'thewire/group/' . $page_owner->getGUID());
		}
	}
	return $return;
}


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



