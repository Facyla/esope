<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_cocon_init');


/* Initialise the theme */
function theme_cocon_init(){
	global $CONFIG;
	$action_url = dirname(__FILE__) . "/actions/";
	
	// Modified to make pages top_level / sub-pages
	//elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	elgg_extend_view('css', 'theme_cocon/css');
	elgg_extend_view('css/admin', 'theme_cocon/admin_css');
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_cocon/extend_user_owner_block', 501);
	
	// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_cocon_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_cocon_public_index');
		}
	}
	
	// Remplacement du modèle d'event_calendar
	//elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_cocon/lib/event_calendar/model.php');
	
	// Modification des menus standards des widgets
	/*
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'theme_cocon_widget_menu_setup');
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
	//elgg_register_event_handler('create','object', 'theme_cocon_notify_event_owner', 900);
	
	// Filtrage des contenus saisis
	/*
	if (elgg_is_active_plugin('htmlawed')) {
		elgg_unregister_plugin_hook_handler('validate', 'input', 'adf_platform_htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('validate', 'input', 'theme_cocon_htmlawed_filter_tags', 1);
	}
	*/
	
}


// Theme Cocon index
function theme_cocon_index(){
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_cocon/loggedin_homepage.php');
	return true;
}

function theme_cocon_public_index() {
	global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_cocon/public_homepage.php');
	return true;
}


function cocon_page_handler($page){
	switch($page[0]){
		default:
			include(dirname(__FILE__) . '/pages/theme_cocon/index.php');
	}
	return true;
}

/* Boutons des widgets */
function theme_cocon_widget_menu_setup($hook, $type, $return, $params) {
	global $CONFIG;
	$urlicon = $CONFIG->url . 'mod/theme_cocon/graphics/';
	
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
		$file_content = elgg_view('theme_cocon/attached_event_calendar', array('entity' => $entity));
		$file_content = elgg_view('theme_cocon/attached_event_calendar_wrapper', array('body' => $file_content));
		$file_content = chunk_split(base64_encode($file_content));
		$attachments[] = array('mimetype' => $mimetype, 'filename' => $filename, 'content' => $file_content);
		
		// Build $options array
		$options['attachments'] = $attachments;
		
		return $options;
	}
	return $returnvalue;
}

/* Sends also a message to the event owner */
function theme_cocon_notify_event_owner($event, $type, $object) {
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
function theme_cocon_htmlawed_filter_tags($hook, $type, $result, $params) {
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


