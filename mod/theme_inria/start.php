<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');

$action_url = dirname(__FILE__) . "/actions/";


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
	elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	// Rewrite friends and friends request to remove river entries
	elgg_unregister_action('friends/add');
	elgg_unregister_action('friend_request/approve');
	elgg_register_action("friends/add", $action_url . "friends/add.php", "logged_in");
	elgg_register_action("friend_request/approve", $action_url . "friend_request/approve.php", "logged_in");
	
	
	elgg_extend_view('css', 'theme_inria/css');
	elgg_extend_view('css/admin', 'theme_inria/admin_css');
	elgg_extend_view('css/digest/core', 'css/digest/site/theme_inria');
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_user_owner_block', 501);
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_group_owner_block', 501);
	elgg_unextend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
	elgg_extend_view('groups/sidebar/search', 'au_subgroups/sidebar/subgroups', 300);
	elgg_extend_view('groups/sidebar/search', 'theme_inria/extend_group_my_status', 600);
	
	// Rewritten in a more specific way for Iris theme
	elgg_unextend_view('forms/login', 'elgg_cas/login_extend');
	
	elgg_extend_view('forms/profile/edit', 'theme_inria/profile_linkedin_import', 200);
	
	// Add RSS feed option
	//add_group_tool_option('rss_feed', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with RSS feed reader
	// Note : directly integrated in groups/profile/widgets
	//elgg_extend_view('groups/tool_latest', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('groups/profile/summary', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('page/elements/sidebar', 'simplepie/sidebar_simplepie_module', 501);
	
	// Supprimer le suivi de l'activité (toujours activé)
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
		$widget_thewire = elgg_get_plugin_setting('widget_thewire', 'adf_public_platform');
		elgg_unregister_widget_type('thewire');
		if ($widget_thewire != 'no') {
			elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
		}
	}
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', elgg_echo('theme_inria:widgets:tools'), elgg_echo('theme_inria:widgets:tools:details'), 'dashboard', false);
	//elgg_register_widget_type('inria_partage', "Partage", "Accès à Partage", 'dashboard');
	
	
	// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_inria_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_inria_public_index');
		}
	}
	
	// Menus
	elgg_register_event_handler('pagesetup', 'system', 'theme_inria_setup_menu');
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_inria_user_hover_menu');
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	
	// Remplacement du modèle d'event_calendar
	elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_inria/lib/event_calendar/model.php');
	
	// Check access validity and update meta fields (inria/external, active/closed)
	elgg_register_event_handler('login','user', 'inria_check_and_update_user_status', 900);
	
	// Remove unwanted widgets
	//elgg_unregister_widget_type('river_widget');
	
	elgg_register_page_handler("inria", "inria_page_handler");
	
	// Add a "ressources" page handler for groups
	elgg_register_page_handler("ressources", "inria_ressources_page_handler");
	
	// Add link to longtext menu
	//elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	
	// Modification des menus standards des widgets
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'theme_inria_widget_menu_setup');
	
	// Add Etherpad (and iframes) embed
	elgg_register_plugin_hook_handler('register', 'menu:embed', 'theme_inria_select_tab', 801);
	
	
	// @TODO - DEV & TESTING !!
	if (elgg_is_active_plugin('html_email_handler')) {
		// Modify default events notification message
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'event_calendar_ics_notify_message');
		// Use hook to add attachments
		elgg_register_plugin_hook_handler('notify:entity:params', 'object', 'event_calendar_ics_notify_attachment');
	}
	// @TODO : ajouter interception création event pour ajouter l'auteur aux personnes notifiées
	elgg_register_event_handler('create','object', 'theme_inria_notify_event_owner', 900);
	
	
}


// Theme inria index
function theme_inria_index(){
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_inria/loggedin_homepage.php');
	return true;
}

function theme_inria_public_index() {
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_inria/public_homepage.php');
	return true;
}


function inria_page_handler($page){
	switch($page[0]){
		case "linkedin":
			include(dirname(__FILE__) . '/pages/theme_inria/linkedin_profile_update.php');
			break;
		case "invite":
			include(dirname(__FILE__) . '/pages/theme_inria/invite_external.php');
			break;
		case "animation":
		default:
			include(dirname(__FILE__) . '/pages/theme_inria/admin_tools.php');
			break;
	}
	return true;
}

function inria_ressources_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base_dir = elgg_get_plugins_path() . 'theme_inria/pages/ressources';
	$page_type = $page[0];
	// Only valid URL model : ressources/group/GUID/all (or without 'all')
	if (isset($page[1])) set_input('guid', $page[2]);
	switch ($page_type) {
		case 'group':
			include "$base_dir/group_ressources.php";
			break;
		default:
			return false;
	}
	return true;
}


// Réécriture de certains menus
function theme_inria_setup_menu() {
	// Get the page owner entity
	$page_owner = elgg_get_page_owner_entity();
	
	if (elgg_in_context('groups')) {
		if ($page_owner instanceof ElggGroup) {
			if (elgg_is_logged_in() && $page_owner->canEdit()) {
				$url = elgg_get_site_url() . "group_operators/manage/{$page_owner->getGUID()}";
				elgg_unregister_menu_item('page', 'edit');
			}
		}
	}
	
	// Add missing collections and invites menus in members page
	if (elgg_in_context('members')) {
		
		collections_submenu_items();
		
		$menu_item = array(
			"name" => "friend_request",
			"text" => elgg_echo("friend_request:menu"),
			"href" => "friend_request/" . elgg_get_logged_in_user_entity()->username,
			"contexts" => array("friends", "friendsof", "collections", "messages", "members"),
			"section" => "friend_request"
		);
		elgg_register_menu_item("page", $menu_item);
		
	}
	
	// Ajout menu Invitations à rejoindre Iris
	if (elgg_is_logged_in()) {
		$own = elgg_get_logged_in_user_entity();
		//if (($own->membertype == 'inria') || elgg_is_admin_logged_in()) {
		if (elgg_is_admin_logged_in()) {
			$menu_item = array(
				"name" => "inria_invite",
				"text" => elgg_echo("inria_invite"),
				"href" => "inria/invite",
				"contexts" => array("friends", "friendsof", "collections", "messages", "members"),
				"section" => "inria_invite"
			);
			elgg_register_menu_item("page", $menu_item);
		}
	}
	
}



/* Met à jour les infos des membres
 *
 * 1. Type de compte
 *  - Si existe dans le LDAP ET actif : compte Inria actif
 *  - Sinon : compte externe
 *
 * 2. Statut du compte :
 * Inactif ou période expirée : marqué comme archivé
 *  - un compte Inria valide est toujours actif
 *  - un compte externe peut être archivé (plus possible de se connecter avec) :
 *    * si inactif plus de X temps
 *    * ou manuellement par un admin
 *  - un compte archivé peut être réactivé : 
 *    * par un admin
 *    * s'il a de nouveau un ldap actif
 *
 * Metadata : 
 *  - membertype : type de membre => inria/external
 *  - memberstatus : statut du compte = actif ou non (= permet de s'identifier ou non) => active/closed
 *  - memberreason : qualification du type de compte, raison de la validité de l'accès => validldap/invalidldap/partner/researchteam/...
 *
 */
function inria_check_and_update_user_status($event, $object_type, $user) {
	if ( ($event == 'login') && ($object_type == 'user') && elgg_instanceof($user, 'user')) {
		//error_log("Inria : profile update : $event, $object_type, " . $user->guid);
		
		// Default values
		$is_inria = false;
		$account_status = 'active';
		
		// Attention, la vérification LDAP ne fonctionne que si ldap_auth est activé !
		if (elgg_is_active_plugin('ldap_auth')) {
			//error_log("LDAP plugin active");
			elgg_load_library("elgg:ldap_auth");
			
			// Update LDAP data
			ldap_auth_check_profile($user);
			
			// Vérification du type de compte : si existe dans le LDAP => Inria et actif
			// Sinon devient compte externe, et désactivé (sauf si une raison de le garder actif)
			if (ldap_user_exists($user->username)) {
				if (!ldap_auth_is_closed($user->username)) {
					$is_inria = true;
					$account_status = 'active';
					// Le motif de validité d'un compte Inria actif est toujours que le compte LDAP est actif !
					$memberreason = 'validldap';
					//error_log("Valid LDAP account");
				}
			}
			
			// Bypass admin : tout admin est Inria de fait (eg.: Iris)
			if (elgg_is_admin_user($user->guid)) {
				$is_inria = true;
				$account_status = 'active';
				$memberreason = 'admin';
			}
			
			// Statut du compte
			// Si compte non-Inria = externe
			if (!$is_inria) {
				//error_log("NO valid LDAP account");
				// External access has some restrictions : if account was not used for more than 1 year => disable
				// Skip unused accounts (just created ones...)
				if (!empty($user->last_action) && ((time() - $user->last_action) > 31622400)) {
					$account_status = 'closed';
					$memberreason = 'inactive';
				}
				
				// Si le compte LDAP vient d'être fermé, et qu'on n'a pas de nouveau motif, il est archivé
				// Càd que si l'ancien statut était un LDAP valide => désactivation du compte
				if (($user->membertype == 'inria') && ($user->memberreason == 'validldap')) {
					$account_status = 'closed';
					$memberreason = 'invalidldap';
				}
			}
			
			// Update user metadata : only if there is a change !
			//error_log("Account update : before = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
			// Type de profil (profile_manager)
			$profiletype_guid = $user->custom_profile_type;
			$inria_profiletype_guid = esope_get_profiletype_guid('inria');
			$external_profiletype_guid = esope_get_profiletype_guid('external');
			
			// MAJ des données : Type de compte et type de profil, puis statut et motif de validité
			if ($is_inria) {
				if ($user->membertype != 'inria') { $user->membertype = 'inria'; }
				if ($profiletype_guid != $inria_profiletype_guid) { $user->custom_profile_type = $inria_profiletype_guid; }
			} else {
				if ($user->membertype != 'external') { $user->membertype = 'external'; }
				if ($profiletype_guid != $external_profiletype_guid) { $user->custom_profile_type = $external_profiletype_guid; }
			}
			// Statut du compte
			if ($user->memberstatus != $account_status) { $user->memberstatus = $account_status; }
			// Motif de validité
			if ($user->memberreason != $memberreason) { $user->memberreason = $memberreason; }
			
		}
		//error_log("Account update : after = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
		
		// Vérification rétro-active pour les comptes qui n'ont pas encore de type de profil défini
		// Compte externe par défaut (si on n'a pas eu d'info du LDAP)
		if (empty($user->custom_profile_type)) {
			if ($is_inria) {
				esope_set_user_profile_type($user, 'inria');
			} else {
				esope_set_user_profile_type($user, 'external');
			}
		}
		
		// Verrouillage à l'entrée si le compte est inactif (= archivé mais pas désactivé !!)
		// Mais seulement si c'est l'user lui-même (la vérification/MAJ a pu être appellée par un autre user)
		if (($user->guid == $_SESSION['guid']) && ($user->memberstatus == 'closed')) {
			register_error(elgg_echo('theme_inria:invalidaccess'));
			return false;
		}
	
	}
	return true;
}


/* Boutons des widgets */
function theme_inria_widget_menu_setup($hook, $type, $return, $params) {
	global $CONFIG;
	$urlicon = $CONFIG->url . 'mod/theme_inria/graphics/';
	
	$widget = $params['entity'];
	$show_edit = elgg_extract('show_edit', $params, true);
	
	$widget_title = $widget->getTitle();
	$collapse = array(
			'name' => 'collapse',
			'text' => '<img src="' . $urlicon . 'widget_hide.png" alt="' . elgg_echo('widget:toggle', array($widget_title)) . '" />',
			'href' => "#elgg-widget-content-$widget->guid",
			'class' => 'masquer',
			'rel' => 'toggle',
			'priority' => 900
		);
	$return[] = ElggMenuItem::factory($collapse);
	
	if ($widget->canEdit()) {
		$delete = array(
				'name' => 'delete',
				'text' => '<img src="' . $urlicon . 'widget_delete.png" alt="' . elgg_echo('widget:delete', array($widget_title)) . '" />',
				'href' => "action/widgets/delete?widget_guid=" . $widget->guid,
				'is_action' => true,
				'class' => 'elgg-widget-delete-button suppr',
				'id' => "elgg-widget-delete-button-$widget->guid",
				'priority' => 900
			);
		$return[] = ElggMenuItem::factory($delete);

		if ($show_edit) {
			$edit = array(
					'name' => 'settings',
					'text' => '<img src="' . $urlicon . 'widget_config.png" alt="' . elgg_echo('widget:editmodule', array($widget_title)) . '" />',
					'href' => "#widget-edit-$widget->guid",
					'class' => "elgg-widget-edit-button config",
					'rel' => 'toggle',
					'priority' => 800,
				);
			$return[] = ElggMenuItem::factory($edit);
		}
	}
	
	return $return;
}


// Etherpad (and iframes) soft integration
function theme_inria_select_tab($hook, $type, $items, $vars) {
	$items[] = ElggMenuItem::factory(array(
		'name' => 'etherpad',
		'text' => elgg_echo('theme_inria:embed:etherpad'),
		'priority' => 500,
		'data' => array(
			'view' => 'embed/etherpad_embed',
		),
	));
	return $items;
}


/**
* Returns a more meaningful message for events
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function event_calendar_ics_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];

	if (elgg_instanceof($entity, 'object', 'event_calendar')) {
		$descr = $entity->description;
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$ics_file_details = ''; // @TODO : add a message for attached files ?
		
		return elgg_echo('event_calendar:ics:notification', array(
			$owner->name,
			$title,
			$descr,
			$entity->getURL(),
			$ics_file_details,
		));
	}
	return null;
}


/**
* Add attachment to events
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
function event_calendar_ics_notify_attachment($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	$options = array();

	if (elgg_instanceof($entity, 'object', 'event_calendar')) {
		// Build attachment
		$mimetype = 'text/calendar';
		$filename = 'calendar.ics';
		// @TODO : we need to get entity to filter and send correct content !!
		$file_content = elgg_view('theme_inria/attached_event_calendar', array('entity' => $entity));
		$file_content = elgg_view('theme_inria/attached_event_calendar_wrapper', array('body' => $file_content));
		$file_content = chunk_split(base64_encode($file_content));
		$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
		
		// Build $options array
		$options['attachments'] = $attachments;
		
		return $options;
	}
	return $returnvalue;
}

/* Sends also a message to the event owner */
function theme_inria_notify_event_owner($event, $type, $object) {
	if(!empty($object) && elgg_instanceof($object, "object", "event_calendar")) {
		global $CONFIG;
		$owner = $object->getOwnerEntity();
		$default_subject = $CONFIG->register_objects['object']['event_calendar'] . ": " . $object->getURL();
		$subject = elgg_trigger_plugin_hook("notify:entity:subject", 'object', array("entity" => $object, "to_entity" => $owner, "method" => 'email'), $default_subject);
		if (empty($subject)) $subject = $default_subject;
		$message = event_calendar_ics_notify_message('notify:entity:message', 'event', '', array('entity' => $object, 'to_entity' => $owner, 'method' => 'email'));
		$params = elgg_trigger_plugin_hook('notify:entity:params', 'object', array("entity" => $object, "to_entity" => $owner, "method" => 'email'), null);
		notify_user($owner->guid, $object->container_guid, $subject, $message, $params, 'email');
	}
}


/*
function esope_html_email_handler_notification_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL){
	
	if (!$from) {
		$msg = elgg_echo("NotificationException:MissingParameter", array("from"));
		throw new NotificationException($msg);
	}

	if (!$to) {
		$msg = elgg_echo("NotificationException:MissingParameter", array("to"));
		throw new NotificationException($msg);
	}

	if ($to->email == "") {
		$msg = elgg_echo("NotificationException:NoEmailAddress", array($to->guid));
		throw new NotificationException($msg);
	}

	// To
	$to = html_email_handler_make_rfc822_address($to);

	// From
	$site = elgg_get_site_entity();
	// If there's an email address, use it - but only if its not from a user.
	if (!($from instanceof ElggUser) && !empty($from->email)) {
	    $from = html_email_handler_make_rfc822_address($from);
	} elseif (!empty($site->email)) {
	    // Use email address of current site if we cannot use sender's email
	    $from = html_email_handler_make_rfc822_address($site);
	} else {
		// If all else fails, use the domain of the site.
		if(!empty($site->name)){
			$name = $site->name;
			if (strstr($name, ',')) {
				$name = '"' . $name . '"'; // Protect the name with quotations if it contains a comma
			}
			
			$name = '=?UTF-8?B?' . base64_encode($name) . '?='; // Encode the name. If may content nos ASCII chars.
			$from = $name . " <noreply@" . get_site_domain($site->getGUID()) . ">";
		} else {
			$from = "noreply@" . get_site_domain($site->getGUID());
		}
	}
	
	// generate HTML mail body
	$html_message = html_email_handler_make_html_body($subject, $message);

	// Facyla : Build attachment
	$mimetype = 'text/calendar';
	$filename = 'calendar.ics';
	// @TODO : we need to get entity to filter and send correct content !!
	$file_content = elgg_view('theme_inria/attached_event_calendar', array('entity' => $params['entity']));
	$file_content = elgg_view('theme_inria/attached_event_calendar_wrapper', array('body' => $file_content));
	$file_content = chunk_split(base64_encode($file_content));
	$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
	$attachments[] = array('mimetype' => $mimetype, 'filename' => 'v1_'.$filename, 'content' => $file_content);

	// set options for sending
	$options = array(
		"to" => $to,
		"from" => $from,
		"subject" => $subject,
		"html_message" => $html_message,
		"plaintext_message" => $message,
		"attachments" => $attachments,
	);
	
	if(!empty($params) && is_array($params)){
		$options = array_merge($options, $params);
	}
	
	return html_email_handler_send_email($options);
}
*/


/*
function esope_html_email_handler_email_hook($hook, $type, $return, $params){
	// generate HTML mail body
	$html_message = html_email_handler_make_html_body($params["subject"], $params["body"]);
	
	// Build attachment
	$mimetype = 'text/calendar';
	$filename = 'calendar.ics';
	// @TODO : we need to get entity to filter and send correct content !!
	$file_content = elgg_view('theme_inria/attached_event_calendar', array('entity' => $params['entity']));
	$file_content = elgg_view('theme_inria/attached_event_calendar_wrapper', array('body' => $file_content));
	$file_content = chunk_split(base64_encode($file_content));
	$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
	$attachments[] = array('mimetype' => $mimetype, 'filename' => 'v2_'.$filename, 'content' => $file_content);
	
	// set options for sending
	$options = array(
		"to" => $params["to"],
		"from" => $params["from"],
		"subject" => $params["subject"],
		"html_message" => $html_message,
		"plaintext_message" => $params["body"],
		"attachments" => $attachments,
	);
	return html_email_handler_send_email($options);
}
*/


/*
// This is modified version of html_email_handler function that supports attachments
function esope_html_email_handler_send_email(array $options = null){
error_log('TEST esope send email');
	$result = false;
	
	$site = elgg_get_site_entity();
	
	// make site email
	if(!empty($site->email)){
		$sendmail_from = $site->email;
		$site_from = html_email_handler_make_rfc822_address($site);
	} else {
		// no site email, so make one up
		$sendmail_from = "noreply@" . get_site_domain($site->getGUID());
		$site_from = $sendmail_from;
		
		if(!empty($site->name)){
			$site_name = $site->name;
			if (strstr($site_name, ',')) {
				$site_name = '"' . $site_name . '"'; // Protect the name with quotations if it contains a comma
			}
			
			$site_name = '=?UTF-8?B?' . base64_encode($site_name) . '?='; // Encode the name. If may content nos ASCII chars.
			$site_from = $site_name . " <" . $sendmail_from . ">";
		}
	}
	
	$sendmail_options = html_email_handler_get_sendmail_options();
	
	// set default options
	$default_options = array(
		"to" => array(),
		"from" => $site_from,
		"subject" => "",
		"html_message" => "",
		"plaintext_message" => "",
		"cc" => array(),
		"bcc" => array(),
		"date" => null,
	);
	
	// merge options
	$options = array_merge($default_options, $options);
	
	// check options
	if(!empty($options["to"]) && !is_array($options["to"])){
		$options["to"] = array($options["to"]);
	}
	if(!empty($options["cc"]) && !is_array($options["cc"])){
		$options["cc"] = array($options["cc"]);
	}
	if(!empty($options["bcc"]) && !is_array($options["bcc"])){
		$options["bcc"] = array($options["bcc"]);
	}
	
	// can we send a message
	if(!empty($options["to"]) && (!empty($options["html_message"]) || !empty($options["plaintext_message"]))){
		// start preparing
		// Facyla : better without spaces and special chars
		//$boundary = uniqid($site->name);
		$boundary = uniqid(friendly_title($site->name));
		
		// start building headers
		$headers = "";
		if(!empty($options["from"])){
			$headers .= "From: " . $options["from"] . PHP_EOL;
		} else {
			$headers .= "From: " . $site_from . PHP_EOL;
		}

		// check CC mail
		if(!empty($options["cc"])){
			$headers .= "Cc: " . implode(", ", $options["cc"]) . PHP_EOL;
		}

		// check BCC mail
		if(!empty($options["bcc"])){
			$headers .= "Bcc: " . implode(", ", $options["bcc"]) . PHP_EOL;
		}

		// add a date header
		if(!empty($options["date"])) {
			$headers .= "Date: " . date("r", $options["date"]) . PHP_EOL;
		}

		$headers .= "X-Mailer: PHP/" . phpversion() . PHP_EOL;
		$headers .= "MIME-Version: 1.0" . PHP_EOL;
		
		// Facyla : add attachments support
		if(!empty($options["attachments"])) {
			$headers .= "Content-Type: multipart/mixed; boundary=\"mixed--" . $boundary . "\"" . PHP_EOL . PHP_EOL;
			// @TODO : Add multiple attachments ?
			$attachments = '';
error_log("Attached file");
			foreach($options["attachments"] as $attachment) {
error_log($attachment['mimetype'] . ' - ' . $attachment['filename'] . ' - ' . $attachment['content']);
				//$attachments = chunk_split(base64_encode(file_get_contents('attachment.zip')));
				$attachments .= "--mixed--" . $boundary . PHP_EOL;
				$attachments .= "Content-Type: " . $attachment['mimetype'] . "; name=\"" . $attachment['filename'] . "\"" . PHP_EOL;
				$attachments .= "Content-Transfer-Encoding: base64" . PHP_EOL;
				$attachments .= "Content-Disposition: attachment  " . PHP_EOL;
				$attachments .= $attachment['content'];
			}
		} else {
			$headers .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"" . PHP_EOL . PHP_EOL;
		}

		// start building the message
		$message = "";

		// TEXT part of message
		if(!empty($options["plaintext_message"])){
			$message .= "--" . $boundary . PHP_EOL;
			$message .= "Content-Type: text/plain; charset=\"utf-8\"" . PHP_EOL;
			$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;

			$message .= chunk_split(base64_encode($options["plaintext_message"])) . PHP_EOL . PHP_EOL;
		}

		// HTML part of message
		if(!empty($options["html_message"])){
			$message .= "--" . $boundary . PHP_EOL;
			$message .= "Content-Type: text/html; charset=\"utf-8\"" . PHP_EOL;
			$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;

			$message .= chunk_split(base64_encode($options["html_message"])) . PHP_EOL;
		}

		// Final boundry
		$message .= "--" . $boundary . "--" . PHP_EOL;
		
		// Facyla : add attachment support
		if(!empty($options["attachments"])) {
error_log('Adding attached file');
			// Build strings that will be added before TEXT/HTML message
			$before_message = "--mixed--" . $boundary . PHP_EOL;
			$before_message .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"" . PHP_EOL . PHP_EOL;
			// Build strings that will be added after TEXT/HTML message
*/
			/*
			$after_message = "--mixed--" . $boundary . PHP_EOL;
			$after_message .= "Content-Type: text/calendar; name=\"calendar.ics\"" . PHP_EOL;
			$after_message .= "Content-Transfer-Encoding: base64" . PHP_EOL;
			$after_message .= "Content-Disposition: attachment  " . PHP_EOL;
			*/
/*
			$after_message .= PHP_EOL;
			$after_message .= $attachments;
			$after_message .= "--mixed--" . $boundary . PHP_EOL;
			// Wrap TEXT/HTML message into mixed message content
			$message = $before_message . PHP_EOL . $message . PHP_EOL . $after_message;
		}
		
		// convert to to correct format
		$to = implode(", ", $options["to"]);
		
		// encode subject to handle special chars
		$subject = "=?UTF-8?B?" . base64_encode($options["subject"]) . "?=";
			
		$result = mail($to, $subject, $message, $headers, $sendmail_options);
	}

	return $result;
}
*/


// These functions are used for temporary changing the current user 
// This lets view one's page as someone else
function theme_inria_temp_login($user) {
	$_SESSION['user'] = $user;
	$_SESSION['guid'] = $user->guid;
	$_SESSION['id'] = $user->guid;
	$_SESSION['username'] = $user->username;
	$_SESSION['name'] = $user->name;
	$_SESSION['code'] = $user->code;
	$_SESSION['user']->save();
	session_regenerate_id();
	return true;
}
function theme_inria_temp_logout() {
	$_SESSION['user']->code = "";
	$_SESSION['user']->save();
	unset($_SESSION['user']);
	unset($_SESSION['guid']);
	unset($_SESSION['id']);
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	unset($_SESSION['code']);
	session_destroy();
	_elgg_session_boot(NULL, NULL, NULL);
	return true;
}


function theme_inria_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	
	// Allow admins to perform these actions, except only to other admins
	if (elgg_is_admin_logged_in() && !($user->isAdmin())){
		
		if ($user->membertype == 'inria') { $is_inria = true; }
		if ($user->memberstatus == 'closed') { $is_archived = true; }
		
		if (!$is_inria) {
			// Email removal is limited to non-valid LDAP users, only if they have a non-empty email
			if (!empty($user->email)){
				$url = "action/inria_remove_user_email?guid=" . $user->getGUID();
				$title = elgg_echo("theme_inria:action:remove_user_email");
				$item = new ElggMenuItem('remove_user_email', $title, $url);
				$item->setSection('admin');
				$item->setConfirmText(elgg_echo("question:areyousure"));
				$return[] = $item;
			}
			// Archive can only apply to non-valid LDAP users + not archived yet
			if (!$is_archived) {
				$url = "action/inria_archive_user?guid=" . $user->getGUID();
				$title = elgg_echo("theme_inria:action:archive_user");
				$item = new ElggMenuItem('archive_user', $title, $url);
				$item->setSection('admin');
				$item->setConfirmText(elgg_echo("question:areyousure"));
				$return[] = $item;
			}
		}
		// Un-archive can be useful in any situation
		if ($is_archived) {
			$url = "action/inria_unarchive_user?guid=" . $user->getGUID();
			$title = elgg_echo("theme_inria:action:unarchive_user");
			$item = new ElggMenuItem('unarchive_user', $title, $url);
			$item->setSection('admin');
			$item->setConfirmText(elgg_echo("question:areyousure"));
			$return[] = $item;
		}
		return $return;
	}
}


