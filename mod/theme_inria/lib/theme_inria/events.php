<?php
/* Events handlers
 * 
 */


// MENUS

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


// USERS - ACCOUNTS

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
		$debug = false;
		if ($debug) error_log("Inria : profile update : $event, $object_type, " . $user->guid);
		if ($debug) error_log("Account update : before = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
		
		// Default values
		$is_inria = false;
		$account_status = 'active';
		$memberreason = 'undefined';
		$force_archive = false;
		
		// Attention, la vérification LDAP ne fonctionne que si ldap_auth est activé !
		if (elgg_is_active_plugin('ldap_auth')) {
			//if (function_exists('ldap_auth_check_profile')) {
			elgg_load_library("elgg:ldap_auth");
			
			// Update LDAP data
			ldap_auth_check_profile($user);
			
			// Vérification du type de compte : si existe + valide dans le LDAP => Inria et actif
			// Sinon devient compte externe, et désactivé (sauf si une raison de le garder actif)
			if (ldap_user_exists($user->username)) {
				// Force archive update if member reason was not set
				if (empty($user->memberreason) || ($user->memberreason == 'undefined')) { $force_archive = true; }
				if ($debug) error_log("Existing LDAP account");
				if (ldap_auth_is_active($user->username)) {
					$is_inria = true;
					$account_status = 'active';
				// Ce motif de validité d'un compte Inria indique que le compte LDAP existe et est actif
					$memberreason = 'validldap';
					if ($debug) error_log("Active LDAP account");
				}
			}
			
			// Bypass admin : tout admin est Inria de fait (eg.: Iris)
			if (elgg_is_admin_user($user->guid)) {
				$is_inria = true;
				$account_status = 'active';
				$memberreason = 'admin';
				if ($debug) error_log("Admin user => always Inria and active");
			}
			
			// Statut du compte
			// Si compte non-Inria = externe
			if (!$is_inria) {
				if ($debug) error_log("NO valid LDAP account");
				// External access has some restrictions : if account was not used for more than 1 year => disable
				// Skip unused accounts (just created ones...)
				if (!empty($user->last_action) && ((time() - $user->last_action) > 31622400)) {
					$account_status = 'closed';
					$memberreason = 'inactive';
					if ($debug) error_log("Not logged in since more than a year : closing account");
				}
				
				// Si le compte LDAP est fermé, et qu'on n'a pas de nouveau motif de le garder actif, il est archivé
				// Càd que si l'ancien statut était un compte Inria ou était justifié par un LDAP valide
				// (car un statut externe est toujours justifié par une autre valeur que 'validldap')
				// Effet rétroactif pour les comptes qui n'avaient pas été mis à jour correctement
				// => désactivation du compte
				if (($user->membertype == 'inria') || ($user->memberreason == 'validldap') || $force_archive) {
					$account_status = 'closed';
					$memberreason = 'invalidldap';
					if ($debug) error_log("Previously valid Inria has become invalid : closing account");
				}
			}
			
			// Update user metadata : only if there is a change !
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
		if ($debug) error_log("Account update : after = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
		
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


// NOTIFICATIONS

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


