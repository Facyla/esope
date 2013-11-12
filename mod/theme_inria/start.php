<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');

/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;
	
	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	elgg_unregister_widget_type('thewire');
	elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', "Outil", "Une série d'outils pratiques");
	elgg_register_widget_type('inria_partage', "Partage", "Accès à Partage", 'dashboard', true);
	
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
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	
	// Update meta fields (inria/external, active/closed)
	if (elgg_is_active_plugin('ldap_auth')) {
		elgg_register_event_handler('login','user', 'inria_update_user_status');
	}
	
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



/* Met à jour les infos des membres
 * Existe dans le LDAP : compte Inria
 * Pas dans le LDAP : compte externe
 * Inactif ou période expirée : marque comme archivé
 */
function inria_update_user_status($event, $object_type, $user) {
	if ( ($event == 'login') && ($object_type == 'user') && elgg_instanceof($user, 'user')) {
		system_message("Informations du compte mises à jour");
		elgg_load_library("elgg:ldap_auth");
		if (ldap_user_exists($user->username)) {
			if ($user->membertype != 'inria') $user->membertype = 'inria';
			if (ldap_auth_is_closed($user->username)) {
				//$user->banned = 'yes'; // Don't ban automatically, refusing access on various criteria is enough
				if ($user->memberstatus != 'closed') $user->memberstatus = 'closed';
			} else {
				if ($user->memberstatus != 'active') $user->memberstatus = 'active';
			}
		} else {
			if ($user->membertype != 'external') $user->membertype = 'external';
			// External access has some restrictions : if account was not used for more than 1 year => disable
			if ( (time() - $user->last_action) > 31622400) {
				if ($user->memberstatus != 'closed') $user->memberstatus = 'closed';
			} else {
				if ($user->memberstatus != 'active') $user->memberstatus = 'active';
			}
		}
		//return $user->save();
	}
	return true;
}


