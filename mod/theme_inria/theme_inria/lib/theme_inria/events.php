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
		if (elgg_instanceof($page_owner, 'group')) {
			if (elgg_is_logged_in() && $page_owner->canEdit()) {
				$url = elgg_get_site_url() . "group_operators/manage/{$page_owner->getGUID()}";
				elgg_unregister_menu_item('page', 'edit');
			}
		}
	}
	
	// Add missing collections and invites menus in members page
	if (elgg_in_context('members')) {
		
		if (elgg_is_logged_in()) {
			elgg_register_menu_item('page', array(
				'name' => 'friends:view:collections',
				'text' => elgg_echo('friends:collections'),
				'href' => "collections/owner/" .  elgg_get_logged_in_user_entity()->username,
				'contexts' => array("friends", "friendsof", "collections", "members"),
			));
		}
		
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
	/*
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
	*/
	
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
/* Iris v2 : avec membres externes
 * Les comptes Inria qui sortent du LDAP ne sont plus désactivés, mais ils quittent leurs groupes (on garde la liste ds une meta, au cas où)
 * Pas d'archivage auto
 */
function inria_check_and_update_user_status($event, $object_type, $user) {
	// Note : return true to avoid blocking access if we are not in the right context
	if (!(($event == 'login:before') && ($object_type == 'user') && elgg_instanceof($user, 'user'))) { return true; }
	
	$ia = elgg_set_ignore_access(true);
	$debug = false;
	if ($debug) error_log("Inria : profile update : $event, $object_type, " . $user->guid);
	if ($debug) error_log("Account update : before = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
	
	// Default values
	$is_inria = false;
	$force_archive = false;
	if (empty($user->memberstatus)) { $memberstatus = 'active'; }
	if (empty($user->memberreason)) { $memberreason = 'undefined'; }
	
	// Use LDAP to check status
	if (elgg_is_active_plugin('ldap_auth')) {
		elgg_load_library("elgg:ldap_auth");
		
		// Vérification du type de compte : si existe + valide dans le LDAP => Inria et actif
		// Sinon devient compte externe, et désactivé (sauf si une raison de le garder actif)
		if (ldap_user_exists($user->username)) {
			if ($debug) error_log("Existing LDAP account");
			// Update LDAP data
			ldap_auth_check_profile($user);
			
			// Force archive for non-inria if member reason was not set
			if (empty($user->memberreason) || ($user->memberreason == 'undefined')) { $force_archive = true; }
			if (ldap_auth_is_active($user->username)) {
				$is_inria = true;
				$memberstatus = 'active';
				// Ce motif de validité d'un compte Inria indique que le compte LDAP existe et est actif
				$memberreason = 'validldap';
				if ($debug) error_log("Active LDAP account");
			} else {
				// Clean up Inria fields for accounts that are not active anymore
				foreach(inria_get_profile_ldap_fields() as $field) {
					$user->{$field} = null;
				}
			}
		} else {
			// Clean up Inria fields for accounts that do not have a LDAP entry
			foreach(inria_get_profile_ldap_fields() as $field) {
				$user->{$field} = null;
			}
		}
		
		// Bypass admin : tout admin est Inria de fait (eg.: Iris)
		if (elgg_is_admin_user($user->guid)) {
			$is_inria = true;
			$memberstatus = 'active';
			$memberreason = 'admin';
			if ($debug) error_log("Admin user => always Inria and active");
		}
		
		// Non-Inria : Statut du compte = externe, et éventuellement archivé
		if (!$is_inria) {
			if ($debug) error_log("NO valid LDAP account");
			
			// Update external account : disable if not used for more than 1 year
			// Skip unused accounts (only created ones...)
			if (!empty($user->last_action) && ((time() - $user->last_action) > 31622400)) {
				/* Iris v2 : pas d'archivage auto ?
				$memberstatus = 'closed';
				$memberreason = 'inactive';
				if ($debug) error_log("Not logged in since more than a year : closing account");
				*/
			}
			// @TODO : add reminders through cron a few days before closing account ?
			
			// Fermeture d'un ex-compte Inria (devenu invalide)
			// Iris v2 : le compte n'est plus désactivé car on a maintenant des comptes externes
			// Si le compte LDAP est fermé, et qu'on n'a pas de nouveau motif de le garder actif, il est archivé
			// Càd que si l'ancien statut était un compte Inria ou était justifié par un LDAP valide
			// (car un statut externe est toujours justifié par une autre valeur que 'validldap')
			// Effet rétroactif pour les comptes qui n'avaient pas été mis à jour correctement
			// => désactivation du compte
			if (($user->membertype == 'inria') || ($user->memberreason == 'validldap') || $force_archive) {
				//$memberstatus = 'closed';
				//$memberreason = 'invalidldap';
				$memberstatus = 'active';
				$memberreason = 'alumni';
				// Note : email removal is replaced by the email blocking hook, much cleaner and extensible
				if ($debug) error_log("Previously valid Inria has become alumni : quitting groups");
				// @TODO leave groups : probably leave only some groups (not if owner, not if open group...)
				$user_groups = elgg_get_entities_from_relationship(array('relationship' => 'member', 'relationship_guid' => $user->guid, 'type' => 'group', 'limit' => false));
				$left_groups_guids = (array) $user->inria_left_groups;
				if ($user_groups) {
					foreach($user_groups as $group) {
						// Don't remove if group owner
						// Operator ? To avoid removing operators, use a proper operator function - not: !$entity->canEdit($user->guid)
						// Don't remove if group access is public or limited to members
						if (($group->owner_guid != $user->guid)  && !in_array($group->access_id, [2, 1])) {
							if (!in_array($group->guid, $left_groups_guids)) { $left_groups_guids[] = $group->guid; }
							$group->leave($user);
						}
					}
					$user->inria_left_groups = $left_groups_guids;
				}
			}
		}
		
		// Update user metadata : only if there is a change !
		// Type de profil (profile_manager)
		$profiletype_guid = $user->custom_profile_type;
		$inria_profiletype_guid = esope_get_profiletype_guid('inria');
		$external_profiletype_guid = esope_get_profiletype_guid('external');
		
		// MAJ du type de compte et de profil
		// @TODO : use create_metadata to ensure profile type is readable by anyone
		/* See http://reference.elgg.org/1.8/engine_2lib_2metadata_8php.html#ad896cf3bd1e5347f5ced1876e8311af2
		create_metadata 	(
		  	$entity_guid,
		  	$name,
		  	$value,
		  	$value_type = '',
		  	$owner_guid = 0,
		  	$access_id = ACCESS_PRIVATE,
		  	$allow_multiple = false 
			)
		*/
		if ($is_inria) {
			if ($user->membertype != 'inria') { $user->membertype = 'inria'; }
			if ($profiletype_guid != $inria_profiletype_guid) { $user->custom_profile_type = $inria_profiletype_guid; }
		} else {
			if ($user->membertype != 'external') { $user->membertype = 'external'; }
			if ($profiletype_guid != $external_profiletype_guid) { $user->custom_profile_type = $external_profiletype_guid; }
		}
		// MAJ du statut du compte
		if (!empty($memberstatus) && ($user->memberstatus != $memberstatus)) { $user->memberstatus = $memberstatus; }
		// MAJ du motif de validité
		if (!empty($memberreason) && ($user->memberreason != $memberreason)) { $user->memberreason = $memberreason; }
		
	}
	if ($debug) error_log("Account update : after = {$user->membertype} / {$user->memberstatus} / {$user->memberreason}");
	
	// Set user default profile
	// Vérification rétroactive pour les comptes qui n'ont pas encore de type de profil défini
	// Compte externe par défaut (si on n'a pas eu d'info du LDAP)
	if (empty($user->custom_profile_type)) {
		if ($is_inria) {
			esope_set_user_profile_type($user, 'inria');
		} else {
			esope_set_user_profile_type($user, 'external');
		}
	}
	
	elgg_set_ignore_access($ia);
	
	// Block access for closed accounts
	// Verrouillage à l'entrée si le compte est inactif (= archivé mais pas désactivé !!)
	// Mais seulement si c'est l'user lui-même (la vérification/MAJ a pu être appellée par un autre user)
	if (($user->guid == elgg_get_logged_in_user_guid()) && ($user->memberstatus == 'closed')) {
		register_error(elgg_echo('theme_inria:invalidaccess'));
		return false;
	}
	
	return true;
}


// NOTIFICATIONS

// Block sending notification in some groups' discussions (replies only)
// Intercepts create,annotation event early and block sending messages by modifying plugins signals
// As they are not notified by default, block plugins which notify comments, eg. comment_tracker
// See also hook function theme_inria_object_notifications_block
function theme_inria_annotation_notifications_event_block($event, $type, $annotation) {
	if (($type == 'annotation') && ($annotation->name == "group_topic_post")) {
		$block = elgg_get_plugin_setting('block_notif_forum_groups_replies', 'theme_inria');
		if ($block == 'yes') {
			// Get blocked groups setting
			$entity = $annotation->getEntity();
			$blocked_guids = elgg_get_plugin_setting('block_notif_forum_groups', 'theme_inria');
			$blocked_guids = esope_get_input_array($blocked_guids);
			$group_guid = $entity->container_guid;
			if ($group_guid && is_array($blocked_guids) && in_array($group_guid, $blocked_guids)) { 
				error_log("  => A BLOQUER #22");
				//$user_guid = elgg_get_logged_in_user_guid();
				// Use rather a CRON an WS safe
				$user_guid = $annotation->owner_guid;
				if (elgg_is_active_plugin('comment_tracker')) {
					$result = comment_tracker_unsubscribe($user_guid, $entity->guid);
					error_log("  => ABO auto desactive");
				}
			}
		}
	}
}

// Also notify group operators
function theme_inria_create_relationship_event($event, $type, $relationship) {
	if (($type == 'relationship') && ($relationship->relationship == "membership_request")) {
		$user_guid = $relationship->guid_one;
		$group_guid = $relationship->guid_two;
		$operators = elgg_get_entities_from_relationship(array('types'=>'user', 'relationship_guid'=>$group_guid, 'relationship'=>'operator', 'inverse_relationship'=>true));
		
		// Notify all group operators + group owner if not passed through join action
		$user = get_entity($user_guid);
		$group = get_entity($group_guid);
		$url = elgg_get_site_url() . "groups/requests/$group_guid";
		$subject = elgg_echo('groups:request:subject', array(
				$user->name,
				$group->name,
			), $ent->language);
		
		$body = elgg_echo('groups:request:body', array(
				$owner->name,
				$user->name,
				$group->name,
				$user->getURL(),
				$url,
			), $ent->language);
			
		$params = [
			'action' => 'membership_request',
			'object' => $group,
		];
		
		// Notify owner first
		$owner = $group->getOwnerEntity();
		notify_user($owner->guid, $user_guid, $subject, $body, $params);
		
		foreach ($operators as $ent) {
			$body = elgg_echo('groups:request:body', array(
					$ent->name,
					$user->name,
					$group->name,
					$user->getURL(),
					$url,
				), $ent->language);
			
			// Avoid duplicate if owner is also in operators
			if ($ent->guid == $owner->guid) { continue; }
			notify_user($ent->guid, $user_guid, $subject, $body, $params);
		}
	}
}



