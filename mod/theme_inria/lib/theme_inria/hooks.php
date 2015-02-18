<?php
/* Core and plugins hooks rewritten or used by Inria
 * 
 */


// INDEX PAGES

// Theme inria logged in index page
function theme_inria_index(){
	global $CONFIG;
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/loggedin_homepage.php');
	return true;
}

// Theme inria public index page
function theme_inria_public_index() {
	global $CONFIG;
	include(elgg_get_plugins_path() . 'theme_inria/pages/theme_inria/public_homepage.php');
	return true;
}


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
		}
		return $return;
	}
}

/* Modification des Boutons des widgets */
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


// NOTFICATIONS

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
		if ($debug) error_log("LDAP hook : update_profile : updated email from {$user->email} to $user_mail");
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
		if ($debug) error_log("LDAP hook : update_profile : processing CONTACTS branch fields");
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
		$new = ''; // Inria prefers empty field to null fields
		// Update only fields that were not already handled
		// And postpone those which are computed based on other values
		if (in_array($field, array('cn', 'sn', 'givenName', 'displayName', 'email'))) { continue; }
		
		// Almost each field is specific...
		switch($field) {
			// Centre de rattachement : "ou", branche people uniquement
			case 'inria_location_main':
				if ($ldap_auth[0]['ou'][0]) {
					$new = $ldap_auth[0]['ou'][0];
					$new = str_replace('UR-', '', $new);
				}
				if ($user->{$field} != $new) $user->{$field} = $new;
				break;
			
			// Localisation
			case 'inria_location':
				// Process localisation : déduit des contacts tél et room
				if ($location) {
					$location = array_unique($location);
					$new = theme_inria_ldap_convert_locality($location);
					$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				} else {
					// Si pas d'info, renseigner avec la résidence administrative (champ ou de la branche people), en supprimant "UR-"
					if ($ldap_auth[0]['ou'][0]) {
						$new = $ldap_auth[0]['ou'][0];
						$new = str_replace('UR-', '', $new);
					}
				}
				if ($user->{$field} != $new) $user->{$field} = $new;
				break;
			
			// EPI ou service : "ou", branche contacts uniquement
			case 'epi_ou_service':
				if ($ldap_infos[0]['ou'][0]) { $new = $ldap_infos[0]['ou'][0]; }
				if ($user->{$field} != $new) $user->{$field} = $new;
				break;
			
			// Bureau
			case 'inria_room':
				if ($rooms) {
					$new = array_unique($rooms);
					$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				if ($user->{$field} != $new) $user->{$field} = $new;
				break;
			
			// Téléphone
			case 'inria_phone':
				if ($phones) {
					$new = array_unique($phones);
					$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				if ($user->{$field} != $new) $user->{$field} = $new;
				break;
			
			// Secrétariat
			case 'secretary':
			case 'inria_secretary':
				if ($secretary) {
					$new = array_unique($secretary);
					$new = implode(', ', $new); // Note : we need a string to be able to compare changes
				}
				if ($user->{$field} != $new) $user->{$field} = $new;
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
	if ($mainpropchange) $user->save();
	
	// Tell update has been successfully done
	return true;
	// Not updated : keep going
	//return $result;
}


// Hook principal pour gérer la MAJ des infos du profil à partir des données LDAP
function theme_inria_ldap_update_profile($hook, $type, $result, $params) {
	$debug = false;
	$user = $params['user'];
	$auth = $params['auth'];
	$infos = $params['infos'];
	$fields = $params['fields'];
	if ($debug) error_log("LDAP hook : update_profile (theme_inria)");
	
	$mail_field = elgg_get_plugin_setting('mail_field_name', 'ldap_auth', 'mail');
	$username_field = elgg_get_plugin_setting('username_field_name', 'ldap_auth', 'inriaLogin');
	$infos = ldap_get_search_infos("$mail_field=$ldap_mail", ldap_auth_settings_info(), array('*'));
	$mainpropchange = false;
	
	$ldap_mail = ldap_get_email($user->username);
	// Update using auth fields first
	$auth_fields = ldap_auth_settings_auth_fields();
	// Also update using infos fields (so empty values are updated)
	$fields = ldap_auth_settings_info_fields();
	
	// Update email
	if (!empty($ldap_mail) && ($user->email != $ldap_mail)) {
		if ($debug) error_log("LDAP hook : update_profile : updated email from {$user->email} to $ldap_mail");
		$user->email = $ldap_mail;
		$mainpropchange = true;
	}
	// Some data are only in auth branch
	if ($auth) {
		if ($debug) error_log("LDAP hook : update_profile : processing PEOPLE branch fields");
		foreach ($auth_fields as $key => $elgg_field) {
			$val = $auth[0][$key];
			if ($debug) error_log("$key => $elgg_field = $val[0]");
			if ($key == 'cn') {
				$fullname = $val[0];
			} else if ($key == 'sn') {
				$lastname = $val[0];
			} else if ($key == 'givenName') {
				$firstname = $val[0];
			} else if ($key == 'ou') {
				// Note : "we want to use only contacts branch for the 'ou' field
				// But here it can be used for the location
				// $ou[] = $val[0];
				//$location_ou = $val[0];
				// Latest update : used for main location (centre de rattachement)
				if ($user->inria_location_main != $val[0]) {
					$user->inria_location_main = $val[0];
				}
			} else {
				// Update only defined metadata
				if (empty($elgg_field)) continue;
				// Value : empty value is a valid value (updated in LDAP to empty)
				$new = $val[0];
				$current = $user->$elgg_field;
				if ($current != $new) {
					$user->$elgg_field = $new;
				}
			}
		}
		// Finally update displayed name : if asked, or empty name, or name is username (which means it was just created)
		$updatename = elgg_get_plugin_setting('updatename', 'ldap_auth', false);
		if (($updatename == 'yes') || empty($user->name) || ($user->name == $user->username)) {
			$mainpropchange = true;
			// MAJ du nom : NOM Prénom, ssi on dispose des 2 infos
			if (!empty($firstname) && !empty($lastname)) {
				$user->name = strtoupper($lastname) . ' ' . esope_uppercase_name($firstname);
			} else if (!empty($fullname)) {
				$user->name = $fullname;
			}
		}
	}
	
	// Then Update using infos fields (contacts branch - optional)
	if (true || $infos) {
		if ($debug) error_log("LDAP hook : update_profile : processing CONTACTS branch fields");
		// Note : cannot use config fields here because office and phone do not have a unique name
		if ($infos[0]) foreach ($infos[0] as $key => $val) {
			$val = $infos[0][$key];
			$elgg_field = $fields[$key];
			// We don't want to update some fields that were processed in auth
			if (!in_array($key, array('cn', 'sn', 'givenName', 'displayName', 'email'))) {
				// Extraction de la localisation
				if (strpos($key, 'x-location-')) {
					$find_loc = explode('x-location-', $key);
					$location[] = $find_loc[1];
					if ($debug) error_log("ldap_auth_update_profile (theme_inria) : found location from $key = {$find_loc[1]}");
				}
				// Traitement des données
				if (substr($key, 0, 10) == 'roomNumber') {
					$roomNumber[] = $val[0];
				} else if (substr($key, 0, 15) == 'telephoneNumber') {
					$telephoneNumber[] = $val[0];
				} else if (substr($key, 0, 9) == 'secretary') {
					$secretary[] = $val[0];
				} else if ($key == 'ou') {
					//$ou[] = $val[0];
				} else {
					// Update only defined metadata
					if (empty($elgg_field)) continue;
					// Value : empty value is a valid value (updated in LDAP to empty)
					$new = $val[0];
					$current = $user->$elgg_field;
					if ($current != $new) {
						$user->$elgg_field = $new;
					}
				}
			}
		}
	}
	
	// Clean configured entries that are not defined anymore in contact branch
	foreach ($fields as $key => $elgg_field) {
		if (empty($infos[0][$key])) $user->$elggfield = null;
	}
	
	// Process special fields (arrays, multiple keys, etc.)
	$special_fields = array('roomNumber', 'telephoneNumber', 'secretary', 'ou');
	foreach ($special_fields as $special_field) {
		if ($$special_field) {
			$$special_field = array_unique($$special_field);
			$meta_name = $fields[$special_field];
			// Update only defined metadata
			if (empty($meta_name)) continue;
			$new = implode(', ', $$special_field);
			$current = $user->$meta_name;
			if ($current != $new) {
				$user->$meta_name = $new;
				/*
				if (!create_metadata($user->guid, $meta_name, $new, 'text', $user->getOwner(), ACCESS_LOGGED_IN)) {
					error_log("ldap_auth_update_profile (theme_inria) : failed create_metadata for guid " . $user->guid . " name=$meta_name, val: " . $new);
				}
				*/
			}
		}
	}
	
	// Cas très particulier de la localisation : déduit des contacts tél et room
	if ($location) {
		$location = array_unique($location);
		$location = theme_inria_ldap_convert_locality($location);
		// Add the other location field from people branch if it exists
		//if (!empty($loation_ou)) $location[] = $location_ou;
		$new = implode(', ', $location);
		$current = $user->inria_location;
		if ($current != $new) { $user->inria_location = $new; }
	} else {
		if (!empty($user->inria_location)) $user->inria_location = null;
	}
	
	// Some changes require saving entity
	if ($mainpropchange) $user->save();
	
	// Tell update has been successfully done
	return true;
	// Not updated : keep going
	//return $result;
}


// Intercept sending to provide a blocking hook for plugins which handle email control through eg. roles or status
function theme_inria_block_email($hook, $type, $return, $params) {
	$to = $params['to'];
	// Closed accounts should not receive email at all
	if (elgg_instanceof($to, 'user')) {
		if ($to->memberstatus == 'closed') {
			// Block email sending
			return true;
		}
	}
	// Do not change behaviour otherwise (= send email)
	return $return;
}


// Block sending notification in some groups' discussions (new topic object only)
// Return true to block sending
// See also event function theme_inria_annotation_notifications_event_block
function theme_inria_object_notifications_block($hook, $entity_type, $returnvalue, $params) {
	$subtype = $params['object']->getSubtype();
	$block_o = elgg_get_plugin_setting('block_notif_forum_groups_object', 'theme_inria');
	$block_r = elgg_get_plugin_setting('block_notif_forum_groups_replies', 'theme_inria');
	//error_log("DEBUG notif block : $subtype / $block_o / $block_r- {$params['object']->container_guid}");
	if ($subtype == 'groupforumtopic') {
		$block = elgg_get_plugin_setting('block_notif_forum_groups_object', 'theme_inria');
		if ($block == 'yes') {
			// Get blocked groups setting
			$blocked_guids = elgg_get_plugin_setting('block_notif_forum_groups', 'theme_inria');
			$blocked_guids = esope_get_input_array($blocked_guids);
			$group_guid = $params['object']->getContainerGUID();
			if ($group_guid && is_array($blocked_guids) && in_array($group_guid, $blocked_guids)) { return true; }
		}
	}
	// Don't change default behaviour
	return $returnvalue;
}


