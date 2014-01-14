<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');
// HTML export action
elgg_register_action("pages/html_export", dirname(__FILE__) . "/actions/pages/html_export.php", "public");


/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;
	
	elgg_extend_view('css', 'theme_inria/css');
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_group_owner_block', 501);
	elgg_unextend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
	elgg_extend_view('groups/sidebar/search', 'au_subgroups/sidebar/subgroups', 300);
	elgg_extend_view('groups/sidebar/search', 'theme_inria/extend_group_my_status', 600);

	
	elgg_extend_view('core/settings/account', 'theme_inria/usersettings_extend', 100);
	elgg_extend_view('page/elements/owner_block', 'theme_inria/html_export_extend', 200);
	
	// Add all groups excerpt to digest
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
	
	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	elgg_unregister_widget_type('thewire');
	elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', "Outils", "Une série d'outils pratiques", 'dashboard', true);
	elgg_register_widget_type('inria_partage', "Partage", "Accès à Partage", 'dashboard');
	
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
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	
	// Update meta fields (inria/external, active/closed)
	if (elgg_is_active_plugin('ldap_auth')) {
		elgg_register_event_handler('login','user', 'inria_check_and_update_user_status', 900);
	}
	
	// Remove unwanted widgets
	//elgg_unregister_widget_type('river_widget');
	
	elgg_register_page_handler("inria", "inria_page_handler");
	
	// Add a "ressources" page handler for groups
	elgg_register_page_handler("ressources", "inria_ressources_page_handler");
	
	// Add link to longtext menu
	//elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	
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
}



/* Met à jour les infos des membres
 * Existe dans le LDAP ET actif : compte Inria
 * Sinon : compte externe
 * Qualification du compte externe faite par aileurs, sauf si ex-Inria (dans ce cas : raison = ldap)
 * Inactif ou période expirée : marque comme archivé
 * Metadata : 
   - membertype : type de membre => inria/external
   - memberstatus : compte actif ou non (= permet de s'identifier ou non) => active/closed
   - memberreason : qualification du type de compte, raison de l'accès => validldap/invalidldap/partner/researchteam/...
 */
function inria_check_and_update_user_status($event, $object_type, $user) {
	if ( ($event == 'login') && ($object_type == 'user') && elgg_instanceof($user, 'user')) {
		// Attention, ne fonctionne que si ldap_auth est activé !
		if (elgg_is_active_plugin('ldap_auth')) {
			elgg_load_library("elgg:ldap_auth");
			// Default values
			$is_inria = false;
			$is_active = true;
		
			// Existe dans le LDAP : Inria ssi actif, sinon désactivé (sauf si une raison de le garder actif)
			if (ldap_user_exists($user->username)) {
				if (!ldap_auth_is_closed($user->username)) {
					$is_inria = true;
					$is_active = true;
					$memberreason = 'validldap';
				} else {
					$is_inria = false;
				}
			}
			// Si compte non-Inria = externe
			if (!$is_inria) {
				// External access has some restrictions : if account was not used for more than 1 year => disable
				if ( (time() - $user->last_action) > 31622400) {
					$is_active = false;
					$memberreason = 'inactive';
				}
			
				if (in_array($user->memberreason, array('validldap', 'invalidldap'))) {
					// Si le compte a été fermé, et qu'on n'a donné aucun nouveau motif d'activation, il devient inactif
					$is_active = false;
					$memberreason = 'invalidldap';
				} else {
					// Si on a changé entretemps pour un compte externe, pas de changement à ce niveau
				}
			}
			// Update user metadata : we update only if there is a change !
			if ($is_inria && ($user->membertype != 'inria')) { $user->membertype = 'inria'; }
			if (!$is_inria && ($user->membertype != 'external')) { $user->membertype = 'external'; }
			if ($is_active) { $user->memberstatus = 'active'; } else { $user->memberstatus = 'closed'; }
			if ($user->memberreason != $memberreason) { $user->memberreason = $memberreason; }
		
			// Verrouillage à l'entrée si le compte est devenu inactif (= archivé mais pas désactivé !!)
			if ($user->memberstatus == 'closed') {
				register_error("Cet accès n'est plus valide. ");
				return false;
			}
		}
	}
	return true;
}


