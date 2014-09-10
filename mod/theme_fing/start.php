<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_fing_init');


/* Initialise the theme */
function theme_fing_init(){
	global $CONFIG;
	$action_url = dirname(__FILE__) . "/actions/";
	
	// Modified to make pages top_level / sub-pages
	//elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	elgg_extend_view('css', 'theme_fing/css');
	elgg_extend_view('css/admin', 'theme_fing/admin_css');
	
	// Extend groups sidebar (below owner_block and before search and members)
	//if (elgg_is_active_plugin('search')) elgg_extend_view('groups/sidebar/search', 'groups/sidebar/group_news_extend', 100);
	//else elgg_extend_view('groups/sidebar/members', 'groups/sidebar/group_news_extend', 100);
	elgg_extend_view('page/elements/owner_block', 'groups/sidebar/group_news_extend', 800);
	
	// Extend group owner block
	//elgg_extend_view('page/elements/owner_block', 'theme_fing/extend_user_owner_block', 501);
	
	// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_fing_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_fing_public_index');
		}
	}
	
	elgg_register_page_handler("fing", "fing_page_handler");
	
	// Remplacement du modèle d'event_calendar
	elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_fing/lib/event_calendar/model.php');
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_fing/actions/thewire/add.php');
	}
	
	
	// Extend digest
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
	// Replace group and user default icons
	/*
	elgg_register_plugin_hook_handler('entity:icon:url', 'group', 'theme_fing_groups_icon_url_override');
	*/
	
	// @TODO - DEV & TESTING !!
	/*
	if (elgg_is_active_plugin('html_email_handler')) {
		// Modify default events notification message
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'event_calendar_ics_notify_message');
		// Use hook to add attachments
		elgg_register_plugin_hook_handler('notify:entity:params', 'object', 'event_calendar_ics_notify_attachment');
	}
	*/
	// @TODO : ajouter interception création event pour ajouter l'auteur aux personnes notifiées
	//elgg_register_event_handler('create','object', 'theme_fing_notify_event_owner', 900);
	
	// Filtrage des contenus saisis
	/*

	if (elgg_is_active_plugin('htmlawed')) {
		elgg_unregister_plugin_hook_handler('validate', 'input', 'adf_platform_htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('validate', 'input', 'theme_fing_htmlawed_filter_tags', 1);
	}

	*/
	
}


// Theme Fing index
function theme_fing_index(){
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_fing/loggedin_homepage.php');
	return true;
}

function theme_fing_public_index() {
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_fing/public_homepage.php');
	return true;
}



function theme_fing_get_pin_entities() {
	if (elgg_is_active_plugin('pin')) {
		$ent_guid = elgg_get_plugin_setting('homehighlight1', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight2', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight3', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight4', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight5', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight6', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		$ent_guid = elgg_get_plugin_setting('homehighlight7', 'theme_fing'); if ($ent = get_entity($ent_guid)) $ents[] = $ent;
		return $ents;
	} else return false;
}


function fing_page_handler($page){
	$page[0] = strtolower($page[0]);
	switch($page[0]){
		default:
			case 'archive':
			case 'projet':
			case 'prospective':
				set_input('theme', $page[0]);
				include(dirname(__FILE__) . '/pages/theme_fing/groups.php');
				break;
			default:
				include(dirname(__FILE__) . '/pages/theme_fing/index.php');
	}
	return true;
}


/**
 * Override the default entity icon for groups
 *
 * @return string Relative URL
 */
/*
function theme_fing_groups_icon_url_override($hook, $type, $returnvalue, $params) {
	$group = $params['entity'];
	$size = $params['size'];
	
	// Already has an icon
	if ($returnvalue != "mod/groups/graphics/default{$size}.gif") {
		return $returnvalue;
	}
	
	// If using default, return a new default
	return "mod/theme_fing/graphics/groups/{$size}.png";
}
*/



/**
* Returns a more meaningful message for events
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
/*
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
*/


/**
* Add attachment to events
*
* @param unknown_type $hook
* @param unknown_type $entity_type
* @param unknown_type $returnvalue
* @param unknown_type $params
*/
/*
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
		$file_content = elgg_view('theme_fing/attached_event_calendar', array('entity' => $entity));
		$file_content = elgg_view('theme_fing/attached_event_calendar_wrapper', array('body' => $file_content));
		$file_content = chunk_split(base64_encode($file_content));
		$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
		
		// Build $options array
		$options['attachments'] = $attachments;
		
		return $options;
	}
	return $returnvalue;
}
*/

/* Sends also a message to the event owner */
/*
function theme_fing_notify_event_owner($event, $type, $object) {
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
*/


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
/*
function theme_fing_htmlawed_filter_tags($hook, $type, $result, $params) {
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
*/


