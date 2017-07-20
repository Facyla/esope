<?php
/* Core and plugins hooks rewritten or used by Inria
 * 
 */

// MENUS

// Menu that appears on hovering over a user profile icon
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
			
			// Some actions are removed for archived users, too
			foreach ($return as $key => $item) {
				if ($item->getName() == 'send') unset($return[$key]);
				if ($item->getName() == 'group_chat_user') unset($return[$key]);
				if ($item->getName() == 'add_friend') unset($return[$key]);
				if ($item->getName() == 'remove_friend') unset($return[$key]);
			}
		}
		
		return $return;
	}
}

/* Modification des Boutons des widgets */
function theme_inria_widget_menu_setup($hook, $type, $return, $params) {
	$urlicon = elgg_get_site_url() . 'mod/theme_inria/graphics/';
	
	$widget = $params['entity'];
	$show_edit = elgg_extract('show_edit', $params, true);
	
	$widget_title = $widget->getTitle();
	$collapse = array(
			'name' => 'collapse',
			'text' => '<img src="' . $urlicon . 'widget_hide.png" alt="' . strip_tags(elgg_echo('widget:toggle', array($widget_title))) . '" />',
			'href' => "#elgg-widget-content-$widget->guid",
			'link_class' => 'masquer',
			'rel' => 'toggle',
			'priority' => 900
		);
	$return[] = ElggMenuItem::factory($collapse);
	
	if ($widget->canEdit()) {
		$delete = array(
				'name' => 'delete',
				'text' => '<img src="' . $urlicon . 'widget_delete.png" alt="' . strip_tags(elgg_echo('widget:delete', array($widget_title))) . '" />',
				'href' => "action/widgets/delete?widget_guid=" . $widget->guid,
				'is_action' => true,
				'link_class' => 'elgg-widget-delete-button suppr',
				'id' => "elgg-widget-delete-button-$widget->guid",
				'priority' => 900
			);
		$return[] = ElggMenuItem::factory($delete);

		if ($show_edit) {
			$edit = array(
					'name' => 'settings',
					'text' => '<img src="' . $urlicon . 'widget_config.png" alt="' . strip_tags(elgg_echo('widget:editmodule', array($widget_title))) . '" />',
					'href' => "#widget-edit-$widget->guid",
					'link_class' => "elgg-widget-edit-button config",
					'rel' => 'toggle',
					'priority' => 800,
				);
			$return[] = ElggMenuItem::factory($edit);
		}
	}
	
	return $return;
}


// Add Etherpad (and iframes) soft integration (embed)
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

// Add direct message to user listing view, and remove anything but friend requests
function theme_inria_user_menu_setup($hook, $type, $items, $vars) {
	if (!elgg_instanceof($vars['entity'], 'user')) { return $items; }
	
	$allowed = ['friend_request', 'add_friend', 'remove_friend', 'message'];
	// Update some existing menu items
	foreach ($items as $k => $item) {
		$name = $item->getName();
		if (!in_array($name, $allowed)) { unset($items[$k]); continue; }
		if ($name == 'friend_request') {
			$item->setTooltip($item->getText());
			$item->setText('<i class="fa fa-user-plus"></i>');
			$item->setPriority(601);
		}
		if ($name == 'add_friend') {
			$item->setTooltip($item->getText());
			$item->setText('<i class="fa fa-user-plus"></i>');
			$item->setPriority(601);
		}
		if ($name == 'remove_friend') {
			unset($items[$k]);
			/*
			$item->setTooltip($item->getText());
			$item->setText('<i class="fa fa-user-times"></i>');
			$item->setPriority(601);
			*/
		}
	}
	// Add send message
	$items[] = ElggMenuItem::factory(array(
			'name' => 'message',
			'text' => '<i class="fa fa-envelope-o"></i>',
			'title' => elgg_echo('messages:sendmessage'),
			'href' => elgg_get_site_url() . 'messages/compose?send_to=' . $vars['entity']->guid,
			'link_class' => 'iris-user-message',
			'priority' => 603,
		));
	// Add send message
	if (elgg_is_logged_in() && $vars['entity']->isFriend()) {
		$items[] = ElggMenuItem::factory(array(
				'name' => 'is-friend',
				'text' => '<i class="fa fa-user"></i>',
				'title' => elgg_echo('friend'),
				'href' => "javascript:void(0);",
				'link_class' => 'iris-user-is-friend',
				'priority' => 602,
			));
	}
	return $items;
}

// River menu : add container, remove ... ?
function theme_inria_river_menu_setup($hook, $type, $items, $vars) {
	$object = $vars['item']->getObjectEntity();
	
	// Add container
	if (elgg_instanceof($object, 'object')) {
		// Get real container for forum & comments
		$top_object = esope_get_top_object_entity($object);
		$container = esope_get_container_entity($object);
		//error_log("Object : $object->guid $object->name $object->title / Top = $top_object->guid $top_object->name $top_object->title / container = $container->guid $container->name $container->title");
		if (elgg_instanceof($container, 'group')) {
			$group_icon = '<svg class="iris-groupes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.54,3.17H9.66a1,1,0,0,0-1,1v5h-5a1,1,0,0,0-1,1V26a1,1,0,0,0,1.51.86L8.95,24H19.58a1,1,0,0,0,1-1V18.23L25,20.9A1,1,0,0,0,26.54,20V4.17A1,1,0,0,0,25.54,3.17ZM18.58,22H8.67a1,1,0,0,0-.51.14L4.71,24.23V11.12h4v5.94a1,1,0,0,0,1,1h8.92Zm6-3.74-3.45-2.07a1,1,0,0,0-.51-.14H10.66V5.17H24.54Z"></path><circle cx="21.07" cy="10.61" r="0.99"></circle><circle cx="17.6" cy="10.61" r="0.99"></circle><circle cx="14.13" cy="10.61" r="0.99"></circle></svg>';
			$items[] = ElggMenuItem::factory(array(
					'name' => 'container',
					'text' => $group_icon . '&nbsp;' . $container->name,
					'href' => $container->getURL(),
					'class' => 'iris-container',
					'priority' => 100,
				));
		}
		
		// Inline comment form (toggle link registred via river menu hook)
		//if (elgg_instanceof($top_object, 'object') && ($top_object->guid != $object->guid) && $top_object->canComment()) {
		if ($top_object->canComment()) {
			$items[] = \ElggMenuItem::factory(array(
					'name' => 'comment',
					'href' => "#comments-add-{$object->getGUID()}-{$top_object->guid}",
					'text' => elgg_view_icon('speech-bubble'),
					'title' => elgg_echo('comment:this'),
					'rel' => 'toggle',
					'priority' => 50,
				));
		}
		
	}
	return $items;
}

// Extras menu : remove RSS... ?
function theme_inria_extras_menu_setup($hook, $type, $items, $vars) {
	// Update some existing menu items
	foreach ($items as $k => $item) {
		if (in_array($item->getName(), array('rss', 'qrcode'))) {
			unset($items[$k]);
		}
	}
	return $items;
}



// HTMLAWED AND INPUT FILTERING

/**
 * htmLawed filtering of data
 *
 * Called on the 'validate', 'input' plugin hook
 *
 * Triggers the 'config', 'htmlawed' plugin hook so that plugins can change
 * htmlawed's configuration. For information on configuraton options, see
 * http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s2.2
 *
 * @param string $hook	 Hook name
 * @param string $type	 The type of hook
 * @param mixed	$result Data to filter
 * @param array	$params Not used
 * @return mixed
 */
function theme_inria_htmlawed_filter_tags($hook, $type, $result, $params) {
	$var = $result;
	elgg_load_library('htmlawed');
	$htmlawed_config = array(
			// seems to handle about everything we need.
			// /!\ Liste blanche des balises autorisées
			//'elements' => 'iframe,embed,object,param,video,script,style',
			'elements' => "* -script", // Blocks <script> elements (only)
			'safe' => false, // true est trop radical, à moins de lister toutes les balises autorisées ci-dessus
			// Attributs interdits
			'deny_attribute' => 'on*',
			// Filtrage supplémentaires des attributs autorisés (cf. start de htmLawed) : 
			// bloque tous les styles non explicitement autorisé
			//'hook_tag' => 'htmlawed_tag_post_processor',
			
			'schemes' => '*:http,https,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto',
			// apparent this doesn't work.
			// 'style:color,cursor,text-align,font-size,font-weight,font-style,border,margin,padding,float'
		);
	// add nofollow to all links on output
	if (!elgg_in_context('input')) { $htmlawed_config['anti_link_spam'] = array('/./', ''); }
	$htmlawed_config = elgg_trigger_plugin_hook('config', 'htmlawed', null, $htmlawed_config);
	if (!is_array($var)) {
		$result = htmLawed($var, $htmlawed_config);
	} else {
		array_walk_recursive($var, 'htmLawedArray', $htmlawed_config);
		$result = $var;
	}
	return $result;
}


// LDAP HOOKS

// Modify cleaning group name function
function theme_inria_ldap_clean_group_name($hook, $type, $result, $params) {
	//$infos = $params['infos'];
	//error_log("LDAP hook : clean_group_name");
	return $result;
}

// Modify check_profile behaviour
// Add an "active account" validity check
// Then use own functions to directly check and update profile
// Note : this deprecates the "update_profile" hook
// Note 2 : always prefer data from contacts branch
function theme_inria_ldap_check_profile($hook, $type, $result, $params) {
	$debug = false;
	if ($debug) error_log("LDAP hook : check_profile");
	$mainpropchange = false;
	$user = $params['user'];
	
	// Do not update accounts that do not have an active LDAP account 
	// because they are now "out of Inria", and we do not want to update their email
	// Anyway, Inria directory information are not displayed anymore if people are not active anymore
	if (!ldap_auth_is_active($user->username)) return false;
	
	// Check that user at least exists in auth branch
	$auth_result = ldap_user_exists($user->username);
	if (!$auth_result) { return false; }
	
	if ($debug) error_log("LDAP hook : update_profile (theme_inria)");
	
	// Get some config
	$mail_field = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'mail');
	$username_field = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$updatename = elgg_get_plugin_setting('updatename', 'ldap_auth', false);
	
	// Get user email
	$user_mail = ldap_get_email($user->username);
	// Get all available data from auth branch (people)
	$ldap_auth = ldap_get_search_infos("$username_field={$user->username}", ldap_auth_settings_auth(), array('*'));
	// Get all available data from infos branch (contacts)
	$ldap_infos = ldap_get_search_infos("$mail_field=$user_mail", ldap_auth_settings_info(), array('*'));
	
	// Update email if we got one from LDAP
	if (!empty($user_mail) && ($user->email != $user_mail)) {
		if ($debug) error_log("LDAP hook : update_profile : updating email from {$user->email} to $user_mail");
		$user->email = $user_mail;
		$mainpropchange = true;
	}
	
	// Update name
	// ..if asked to, but also if empty name, or if name is equal to username (which means account was just created)
	if (($updatename == 'yes') || empty($user->name) || ($user->name == $user->username)) {
		// Get name data
		if ($ldap_infos) {
			$firstname = $ldap_infos[0]['givenName'][0];
			$lastname = $ldap_infos[0]['sn'][0];
			$fullname = $ldap_infos[0]['displayName'][0];
			if (empty($fullname)) $fullname = $ldap_infos[0]['cn'][0];
		}
		// Fallback : try auth branch (people)
		if (empty($firstname)) { $firstname = $ldap_auth[0]['givenName'][0]; }
		if (empty($lastname)) { $lastname = $ldap_auth[0]['sn'][0]; }
		if (empty($fullname)) { $fullname = $ldap_auth[0]['cn'][0]; }
		
		// MAJ du nom à partir des infos disponibles
		if (!empty($firstname) && !empty($lastname)) {
			// NOM Prénom, ssi on dispose des 2 infos
			if (function_exists('esope_uppercase_name')) {
				$user->name = strtoupper($lastname) . ' ' . esope_uppercase_name($firstname);
			} else {
				$user->name = strtoupper($lastname) . ' ' . $firstname;
			}
			$mainpropchange = true;
		} else if (!empty($fullname)) {
			// Nom complet sinon
			$user->name = $fullname;
			$mainpropchange = true;
		}
	}
	
	// Process other profile fields : extract data, them process wanted fields
	$location = $rooms = $phones = $secretary = array();
	// Extract some hidden data from infos fields
	if ($ldap_infos && $ldap_infos[0]) {
		if ($debug) error_log("LDAP hook : update_profile : processing INFOS branch (contacts) fields");
		// Note : cannot use config fields here because office and phone do not have a unique name
		foreach ($ldap_infos[0] as $key => $val) {
			// We don't want to update some fields that were processed in auth
			if (in_array($key, array('cn', 'sn', 'givenName', 'displayName', 'email'))) { continue; }
			
			// Extraction de la localisation
			if (strpos($key, 'x-location-')) {
				$find_loc = explode('x-location-', $key);
				$location[] = $find_loc[1];
				if ($debug) error_log("ldap_auth_update_profile (theme_inria) : found location from $key = {$find_loc[1]}");
			}
			
			// Extraction Bureau, Téléphone et Secrétariat
			if (substr($key, 0, 10) == 'roomNumber') {
				$rooms[] = $val[0];
			} else if (substr($key, 0, 15) == 'telephoneNumber') {
				$phones[] = $val[0];
			} else if (substr($key, 0, 9) == 'secretary') {
				$secretary[] = $val[0];
			}
		}
	}
	
	// Note : empty values are valid (updated in LDAP)
	$profile_fields = inria_get_profile_ldap_fields();
	foreach($profile_fields as $field) {
		$new = ''; // Inria prefers empty field to null field
		// Update only fields that were not already handled
		// And postpone those which are computed based on other values
		if (in_array($field, array('cn', 'sn', 'givenName', 'displayName', 'email'))) { continue; }
		
		// Almost each field is specific...
		// Note : 201506 now handling multiple values as array, as it is used in selects and searches
		switch($field) {
			// Centre de rattachement : "ou", branche people uniquement - valeur unique
			case 'inria_location_main':
				if ($ldap_auth[0]['ou'][0]) {
					$new = $ldap_auth[0]['ou'][0];
					$new = str_replace('UR-', '', $new);
				}
				if ($user->inria_location_main != $new) $user->inria_location_main = $new;
				break;
			
			// Localisation
			case 'inria_location':
				// Process localisation : déduit des contacts tél et room - peut être un array
				if ($location) {
					$location = array_unique($location);
					$new = theme_inria_ldap_convert_locality($location);
					//$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				} else {
					// Si pas d'info, renseigner avec la résidence administrative (champ ou de la branche people), en supprimant "UR-"
					if ($ldap_auth[0]['ou'][0]) {
						$new = $ldap_auth[0]['ou'][0];
						$new = str_replace('UR-', '', $new);
					}
				}
				//if ($user->inria_location != $new) 
				$user->inria_location = $new;
				break;
			
			// EPI ou service : "ou", branche contacts uniquement - peut être un array
			case 'epi_ou_service':
				if ($ldap_infos[0]['ou'][0]) {
					$new = $ldap_infos[0]['ou'];
					//$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				//if ($user->epi_ou_service != $new) 
				$user->epi_ou_service = $new;
				break;
			
			// Bureau - peut être un array
			case 'inria_room':
				if ($rooms) {
					$new = array_unique($rooms);
					//$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				//if ($user->inria_room != $new) 
				$user->inria_room = $new;
				break;
			
			// Téléphone - peut être un array
			case 'inria_phone':
				if ($phones) {
					$new = array_unique($phones);
					//$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				//if ($user->inria_phone != $new) 
				$user->inria_phone = $new;
				break;
			
			// Secrétariat
			case 'secretary':
			case 'inria_secretary':
				if ($secretary) {
					$new = array_unique($secretary);
					//$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				//if ($user->inria_secretary != $new) 
				$user->inria_secretary = $new;
				break;
			
			default:
				// In case it happens, use a prefix to avoid any conflict
				if (isset($ldap_infos[0][$field][0])) {
					$new = $ldap_infos[0][$field][0];
				} else if (isset($ldap_infos[0][$field][0])) {
					$new = $ldap_auth[0][$field][0];
				}
				if ($user->{"ldap_$field"} != $new) $user->{"ldap_$field"} = $new;
		}
	}
	
	// Some changes require saving entity
	if ($mainpropchange) {
		if ($user->save()) {
			if ($debug) error_log("ldap_auth_update_profile (theme_inria) : saved");
		} else {
			if ($debug) error_log("ldap_auth_update_profile (theme_inria) : NOT SAVED");
		}
	}
	if ($debug) error_log("ldap_auth_update_profile (theme_inria) : DONE");
	
	// Tell update has been successfully done
	return true;
	// Not updated : keep going
	//return $result;
}


// Intercept sending to provide a blocking hook for plugins which handle email control through eg. roles or status
// @TODO Digest doesn't use that hook, requires another method (eg. private setting digest_1 = none to block site digest)
function theme_inria_block_email($hook, $type, $return, $params) {
	$recipient = get_user_by_email($params['to']);
	if (is_array($recipient)) { $recipient = $recipient[0]; }
	// Closed accounts should not receive email at all
	if (elgg_instanceof($recipient, 'user')) {
		if ($recipient->memberstatus == 'closed') {
			// Block email sending
			// Note : html_email_handler réécrit le 'to' à partir des paramètres passés (donc impossible d'overrider $to)
			// et le blocage ne peut pas être fait en "vidant" le destinataire, le titre ou le contenu ($return['to'] = '';) car ceux-ci sont redéfinis par la suite
			return false;
		}
	}
	// Do not change behaviour otherwise (= send email)
	return $return;
}


// Block sending notification in some groups' discussions (new topic object only)
// Return true to block sending
// See also event function theme_inria_annotation_notifications_event_block
function theme_inria_send_before_notifications_block($hook, $entity_type, $returnvalue, $params) {
	$object = $params['event']->getObject();
	if (elgg_instanceof($object, 'object')) {
		$subtype = $object->getSubtype();
		if (in_array($subtype, array('groupforumtopic', 'discussion_reply'))) {
			//$block_o = elgg_get_plugin_setting('block_notif_forum_groups_object', 'theme_inria');
			//$block_r = elgg_get_plugin_setting('block_notif_forum_groups_replies', 'theme_inria');
			$block = elgg_get_plugin_setting('block_notif_forum_groups_object', 'theme_inria');
			//error_log("DEBUG notif block : $subtype / $block_o / $block_r- {$object->container_guid}");
			if ($block == 'yes') {
				// Get blocked groups setting
				$blocked_guids = elgg_get_plugin_setting('block_notif_forum_groups', 'theme_inria');
				$blocked_guids = esope_get_input_array($blocked_guids);
				$group_guid = $object->getContainerGUID();
				if ($group_guid && is_array($blocked_guids) && in_array($group_guid, $blocked_guids)) { return true; }
			}
		}
	}
	// Don't change default behaviour
	return $returnvalue;
}


/* Cron (daily) tasks
 * Perfom some checks and cleanup
 * Note : registered as hourly, but runs only at a specific hour (this is to avoid overlap with other cron)
 */
function theme_inria_daily_cron($hook, $entity_type, $returnvalue, $params) {
	elgg_set_context('cron');
	
	// Run only once per day, at 4 AM (in this hour at least)
	// Also allow forced run (for admins)
	// This avoids running at the same time as another cron, which would block it (if it doesn't have time limit settings, etc.)
	$cron_hour = 4;
	$current_hour = date('H');
	if (($cron_hour == $current_hour) || ($params['force'] == 'yes')) {
	// Avoid any time limit while processing
	set_time_limit(0);
	access_show_hidden_entities(true);
	$ia = elgg_set_ignore_access(true);
	
	// LDAP accounts check : check LDAP validity
	if (elgg_is_active_plugin('ldap_auth')) {
		error_log("CRON : LDAP start " . date('Ymd H:i:s'));
		$debug_0 = microtime(TRUE);
		$users_options = array('types' => 'user', 'limit' => 0);
		$batch = new ElggBatch('elgg_get_entities', $users_options, 'theme_inria_cron_ldap_check', 10);
		$debug_1 = microtime(TRUE);
		error_log("CRON : LDAP end " . date('Ymd H:i:s') . " => " . round($debug_1-$debug_0, 4) . " secondes");
		echo '<p>' . elgg_echo('theme_inria:cron:ldap:done') . '</p>';
	}
	
	elgg_set_ignore_access($ia);
	echo '<p>' . elgg_echo('theme_inria:cron:done') . '</p>';
	}
}

// CRON : LDAP user check
function theme_inria_cron_ldap_check($user, $getter, $options) {
	//$debug_0 = microtime(TRUE);
	// Check LDAP data
	inria_check_and_update_user_status('login:before', 'user', $user);
	
	// Process all and any users, BUT only clear some metadata when account is not Inria (valid LDAP)
	if (!$user->isEnabled() || $user->isbanned() || ($user->memberstatus == 'closed')) {
		// Clean up Inria fields for any non-active Inria accounts
		foreach(inria_get_profile_ldap_fields() as $field) { $user->{$field} = null; }
	}
	// Skip not-enabled accounts
	if (!$user->isEnabled()) { return; }
	// Skip banned accounts
	if ($user->isbanned()) { return; }
	// Skip archived accounts
	if ($user->memberstatus == 'closed') { return; }
	
	//$debug_1 = microtime(TRUE);
	//error_log("  - {$user->guid} : {$user->name} => " . round($debug_1-$debug_0, 4));
	
}


// Modify the way we count users (exclude archived users from count)
function theme_inria_members_count_hook($hook, $entity_type, $returnvalue, $params) {
	$access = "";
	if (!$show_deactivated) {
		$access = "and " . _elgg_get_access_where_sql(array('table_alias' => 'e'));
	}
	
	// Inria : do not count members where memberstatus= closed
	$dbprefix = elgg_get_config('dbprefix');
	$name_metastring_id = elgg_get_metastring_id('memberstatus');
	$value_metastring_id = elgg_get_metastring_id('closed');
	$where = "and NOT EXISTS (
		SELECT 1 FROM {$dbprefix}metadata md
		WHERE md.entity_guid = e.guid
			AND md.name_id = $name_metastring_id
			AND md.value_id = $value_metastring_id)";
	
	$query = "SELECT count(*) as count 
		from {$dbprefix}entities e 
		where e.type='user' 
		$where 
		$access";
	
	$result = get_data_row($query);
	
	if ($result) { return $result->count; }
	return false;
}


// Members count in group listing menu + various changes to entity menu (comments and likes out)
function theme_inria_entity_menu_setup($hook, $type, $return, $params) {
	
	if (elgg_in_context('widgets')) { return $return; }

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);

	if (elgg_instanceof($entity, 'object', 'thewire')) {
		foreach ($return as $index => $item) {
			if ($item->getName() == 'thread') { unset($return[$index]); }
			if ($item->getName() == 'reply') { unset($return[$index]); }
			if ($item->getName() == 'previous') { unset($return[$index]); }
		}
	}
	
	if (elgg_instanceof($entity, 'object', 'file')) {
		if ($entity->canEdit()) {
			// @TODO édition en lightbox
			$return[] = ElggMenuItem::factory(array(
					'name' => 'upload_version',
					'text' => elgg_echo('file:upload:version'),
					'href' => "#file-upload-version-{$entity->guid}",
					'rel' => 'popup', 
					'priority' => 100,
				));
		}
	}
	
	if (elgg_instanceof($entity, 'object')) {
		foreach ($return as $index => $item) {
			if (in_array($item->getName(), array('likes', 'unlike', 'likes_count', 'access'))) {
				unset($return[$index]);
			}
		}
	}
	
	/* @var ElggGroup $entity */
	if ($handler == 'groups') {
		//if (elgg_instanceof($entity, 'group')) {}
		// Replace members count if set
		foreach ($return as $index => $item) {
			if ($item->getName() == 'members') {
				unset($return[$index]);
				// number of members
				$nb_members_wheres[] = "NOT EXISTS (
					SELECT 1 FROM " . elgg_get_config('dbprefix') . "metadata md
					WHERE md.entity_guid = e.guid
						AND md.name_id = " . elgg_get_metastring_id('memberstatus') . "
						AND md.value_id = " . elgg_get_metastring_id('closed') . ")";
				$active_members = $entity->getMembers(array('wheres' => $nb_members_wheres, 'count' => true));
				$all_members = $entity->getMembers(array('count' => true));
				//$members_string = elgg_echo('groups:member');
				$members_string = $all_members . ' ' . elgg_echo('groups:member');
				if ($all_members != $active_members) {
					if ($active_members > 1) {
						$members_string = elgg_echo('theme_inria:groups:entity_menu', array($all_members, $active_members));
					} else {
						if ($all_members > 1) {
							$members_string = elgg_echo('theme_inria:groups:entity_menu:singular', array($all_members, $active_members));
						} else {
							$members_string = elgg_echo('theme_inria:groups:entity_menu:none', array($all_members, $active_members));
						}
					}
				}
				$options = array(
					'name' => 'members',
					'text' => $members_string,
					'href' => false,
					'priority' => 200,
				);
				$return[] = ElggMenuItem::factory($options);
			}
		}
	}
	
	return $return;
}


// Add thewire menu in group tools
function theme_inria_thewire_group_menu($hook, $type, $return, $params) {
	$page_owner = elgg_get_page_owner_entity();
	if (elgg_instanceof($page_owner, 'group')) {
		if ($page_owner->isMember() || elgg_is_admin_logged_in()) {
			$add_wire = elgg_get_plugin_setting('groups_add_wire', 'esope');
			switch ($add_wire) {
				case 'yes': break; 
				case 'groupoption':
					if ($page_owner->thewire_enable != 'yes') { return $return; }
					break; 
				default: return $return;
			}
			$title = elgg_echo('esope:thewire:group:title');
			$return[] = new ElggMenuItem('thewire_group', $title, 'thewire/group/' . $page_owner->getGUID());
		}
	}
	return $return;
}


function theme_inria_groups_edit_event_listener($event, $object_type, $group) {
	if (!elgg_instanceof($group, 'group')) { return false; }
	
	$warnings = array();
	$user_guid = elgg_get_logged_in_user_guid();
	
	// Handle group / city images (attached to group and not group owner)
	$images = array('banner');
	foreach($images as $meta_name) {
		// Attachment upload
		if (isset($_FILES[$meta_name]['name']) && !empty($_FILES[$meta_name]['name']) && ($attachment_file = get_uploaded_file($meta_name))) {
			// create file
			$prefix = "groups/" . $group->guid;
			$fh = new ElggFile();
			$fh->owner_guid = $group->guid;
			$fh->setFilename($prefix . $meta_name);
			if($fh->open("write")){
				$fh->write($attachment_file);
				$fh->close();
			}
			$group->{$meta_name} = $meta_name;
			$group->{$meta_name.'_name'} = htmlspecialchars($_FILES[$meta_name]['name'], ENT_QUOTES, 'UTF-8');
		}
	}

	return true;
}



function theme_inria_user_icon_hook($hook, $type, $return, $params) {
	static $algorithm = false;
	static $enabled = false;
	if (!$algorithm) {
		$enabled = elgg_get_plugin_setting('default_user');
		if ($enabled != 'no') {
			$enabled = true;
			$algorithm = elgg_get_plugin_setting('default_user_alg');
			$algorithm_opt = default_icons_get_algorithms();
			if (!isset($algorithm_opt[$algorithm])) { $algorithm = 'ringicon'; }
		} else {
			$enabled = false;
		}
	}
	
	
	// Detect default icon (but cannot use file_exists because it's an URL)
	if ($enabled && (strpos($return, '_graphics/icons/user/') !== false)) {
		// GUID seed will ensure static result on a single site (so an entity with same GUID on another site will have the same rendering)
		// Username-based seed enables portable avatar on other sites
		$seed = $params['entity']->guid;
		$background = elgg_get_plugin_setting('background', 'default_icons');
		$profile_type = esope_get_user_profile_type($params['entity']);
		if (empty($profile_type)) { $profile_type = 'external'; }
		if ($profile_type == 'external') { $background = 'F7A621'; }
		$size = $params['size'];
		$icon_sizes = elgg_get_config('icon_sizes');
		$img_base_url = elgg_get_site_url() . "default_icons/icon?seed=$seed";
		if (!isset($icon_sizes[$size])) { $size = 'medium'; }
		/*
		if (!empty($num)) $img_base_url .= "&num=$num";
		if (!empty($mono)) $img_base_url .= "&mono=$mono";
		*/
		$img_base_url .= "&algorithm=$algorithm";
		$img_base_url .= '&width=' . $icon_sizes[$size]['w'];
		if (!empty($background)) $img_base_url .= "&background=$background";
		return $img_base_url;
	}
	
	return $return;
}



// Override object icons with images (but we use FA icons)
/*
function theme_inria_object_icon_hook($hook, $type, $url, $params) {
	
	// Detect default icon (but cannot use file_exists because it's an URL)
	if (!$url || empty($url) || (strpos($url, '_graphics/icons/default/') !== false)) {
		$subtype = $params['entity']->getSubtype();
	
		$title = $params['entity']->title;
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8', false);
	
		// Get size
		$size = $params['size'];
		//$sizes = array('small', 'medium', 'large', 'tiny', 'master', 'topbar');
		//if (!in_array($size, $sizes)) { $size = "medium"; }
		$icon_sizes = elgg_get_config('icon_sizes');
		if (!isset($icon_sizes[$size])) { $size = 'medium'; }
		
		return elgg_get_site_url() . "mod/theme_inria/graphics/objects/{$subtype}.png";
	}
	
	return $url;
}
*/



