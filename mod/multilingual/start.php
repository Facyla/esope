<?php
/**
 * multilingual plugin
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Florian DANIEL aka Facyla
 * @copyright Florian DANIEL aka Facyla 2015
 * @link http://id.facyla.fr/
 */

/* Dev notes
 * Several possible implementations : 
   - use same field and add markers (similar to qtranslate) - but limits even more the max length
   - add annotations for alternate languages versions
 * Constraints : 
   - handle content types such as blog, which also uses briefdescription
   - as generic as possible (handle new content types)
   - 
 * Design / technical specs options :
   - framework for plugins to implement alternate language content ? (but not directly usable)
   - plug'n'play plugin so one can just enable and use it ? (but overrides other plugins' views)
 */

/* TODO

	OK Clone original entity + add specific metadata + add relation to original entity

	@TODO Handle entity lifecycle : 
	 - synchronize updates (access_id, owner_guid, container_guid) 
	 - handle deletes (could possibly let user select whether trasnlations should be destroyed, or a new "main" translation set)

	@TODO Access through main entity only, which determines access, URL

	@TODO Handle HTML META to tell there are other translations of a given content

	@TODO Hook entity display to check if a given entity is a translation (and redirect to main entity)

*/

// Init plugin
elgg_register_event_handler('init', 'system', 'multilingual_init');


/**
 * Init multilingual plugin.
 */
function multilingual_init() {
	
	elgg_extend_view('css', 'multilingual/css');
	
	// Translate button to entities
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'multilingual_entity_menu_setup', 600);
	
	
	
	/* Useful hooks to insert language links and provide the chosen translation version :
	Note : we need to translate at least title + description
	Versions : display:view plugin hook is deprecated by view:view_name
	
	
	 - view/
	 view_vars, <view_name>
    Filters the $vars array passed to the view
view, <view_name>
    Filters the returned content of the view
    
		 elgg_register_plugin_hook_handler('display', 'view', 'profile_manager_display_view_hook');
	 function profile_manager_display_view_hook($hook_name, $entity_type, $return_value, $parameters){
		$view = $parameters["view"];
		
		if(($view == "output/datepicker" || $view == "input/datepicker") && !elgg_view_exists($view)){
			
			if($view == "output/datepicker"){
				$new_view = "output/pm_datepicker";
			} else {
				$new_view = "input/pm_datepicker";
			}
			 
			return elgg_view($new_view, $parameters["vars"]);
		}
	}
	*/
	
	// Note : un hook sur la vue ne fonctionne pas car on a besoin du GUID de l'entité pour avoir une version dans une autre langue
	//elgg_register_plugin_hook_handler('view', 'output/longtext', 'multilingual_display_view_hook');
	
	
	
	/*
	// Register PHP library - use with : elgg_load_library('elgg:multilingual');
	elgg_register_library('elgg:multilingual', elgg_get_plugins_path() . 'multilingual/lib/multilingual.php');
	
	// Register JS script - use with : elgg_load_js('multilingual');
	elgg_register_js('multilingual', '/mod/multilingual/vendors/multilingual.js', 'head');
	
	// Register CSS - use with : elgg_load_css('multilingual');
	elgg_register_simplecache_view('css/multilingual');
	$multilingual_css = elgg_get_simplecache_url('css', 'multilingual');
	elgg_register_css('multilingual', $multilingual_css);
	*/
	
	// Get a plugin setting
	//$setting = elgg_get_plugin_setting('setting_name', 'multilingual');
	
	// Get a user plugin setting (makes sense only if logged in)
	/*
	if (elgg_is_logged_in()) {
		$user_guid = elgg_get_logged_in_user_guid();
		$usersetting = elgg_get_plugin_user_setting('user_plugin_setting', $user_guid, 'multilingual');
	}
	*/
	
	elgg_register_page_handler('multilingual','multilingual_page_handler');
	
}




// Page handler for custom URL
function multilingual_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'multilingual/pages/multilingual/';
	if (isset($page[1])) set_input('guid', $page[1]);
	if (isset($page[2])) set_input('locale', $page[2]);
	switch ($page[0]) {
		case 'translate':
		case 'default':
			if (include($include_path . 'translate.php')) { return true; }
	}
	
	return false;
}



// Langues autorisées pour les traductions
function multilingual_available_languages() {
	$languages = elgg_get_plugin_setting('languages', 'multilingual');
	$languages = str_replace(array(' ', "\n", "\r", ','), ',', $languages);
	$languages = explode(',', $languages);
	$languages = array_unique($languages);
	$languages = array_filter($languages);
	
	if (is_array($languages)) {
		$available_languages = array();
		foreach ($languages as $code) {
			$available_languages[$code] = elgg_echo($code);
		}
		return $available_languages;
	}
	return false;
}



// Bouton d'ajout de traduction
function multilingual_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	//$entity_types = elgg_get_plugin_setting('types', 'multilingual');
	//if (elgg_instanceof($entity, 'object')) {
	if (elgg_instanceof($entity)) {
		
		$languages = multilingual_available_languages();
		
		$translations = multilingual_get_translations($entity);
		// Existing translations
		if ($translations) {
			foreach ($translations as $ent) {
				$href = $ent->getURL() . '?lang=' . $ent->lang;
				// <i class="fa fa-eye"></i>
				$text = '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $ent->lang . '.gif" alt="' . $ent->lang . '" />';
				$title = elgg_echo('multilingual:menu:viewinto', array($languages[$ent->lang]));
				$options = array('name' => 'multilingual-version-' . $ent->lang, 'href' => $href, 'priority' => 500, 'text' => $text, 'title' => $title);
				$return[] = ElggMenuItem::factory($options);
				// Remove from new translations array
				unset($languages[$ent->lang]);
			}
		}
		
		// @TODO : use a different access rule for translations ?  then maybe a translator role could allow editing other languages versions (but alternative versions *only* - and not the main content)
		if ($entity->canEdit()) {
			foreach ($languages as $lang_code => $lang_name) {
				$href = elgg_get_site_url() . 'multilingual/translate/' . $entity->guid . '/' . $lang_code;
				// <i class="fa fa-plus"></i>
				$text = '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang_code . '.gif" alt="' . $lang_code . '" />';
				$title = elgg_echo('multilingual:menu:translateinto', array($languages[$lang_code]));
				$options = array('name' => 'multilingual-version-' . $lang_code, 'href' => $href, 'priority' => 501, 'text' => $text, 'title' => $title, 'style' => "opacity:0.3;", 'is_action' => true, 'is_trusted' => true, 'confirm' => elgg_echo('multilingual:translate:confirm'));
				$return[] = ElggMenuItem::factory($options);
			}
		}
		
		/* Alternate version : single popup menu
		$options = array('name' => 'multilingual-versions', 'href' => false, 'priority' => 900, 'text' => elgg_view('multilingual/menu/versions', array('entity' => $entity)));
		$return[] = ElggMenuItem::factory($options);
		*/
	}
	return $return;
}



/* Return existing translations
 */
function multilingual_get_translations($entity){
	// Get existing translation
	$translations = elgg_get_entities_from_relationship(array(
			'relationship' => 'has_translation',
			'relationship_guid' => $entity->guid,
			'inverse_relationship' => false,
			'limit' => 0,
		));
	if ($translations) { return $translations; }
	return false;
}

/* Return existing translation in a given language
 */
function multilingual_get_translation($entity, $lang_code = 'en'){
	// Get existing translation
	$translations = elgg_get_entities_from_relationship(array(
			'relationship' => 'has_translation',
			'relationship_guid' => $entity->guid,
			'inverse_relationship' => false,
			'metadata_name_value_pairs' => array('name' => 'lang', 'value' => $lang_code),
			// Alternate version which supports regional variants
			//'metadata_name_value_pairs' => array('name' => 'lang', 'value' => $lang_code . '%', 'operand' => 'LIKE'),
		));
	if ($translations) { return $translations[0]; }
	return false;
}



/* Return main entity for a given translation
 */
function multilingual_get_translated_entity($translation){
	// Get existing translated entity
	$entities = elgg_get_entities_from_relationship(array(
			'relationship' => 'translation_of',
			'relationship_guid' => $translation->guid,
			'inverse_relationship' => false,
		));
	if ($entities) { return $entities[0]; }
	return false;
}



/* Add new translation to entity, or update existing translation
 */
function multilingual_add_translation($entity, $lang_code = 'en'){
	// Check existing translation
	$translation = multilingual_get_translation($entity, $lang_code);
	
	if (!elgg_instanceof($translation)) {
		$translation = clone $entity;
		$translation->owner_guid = $entity->guid;
		$translation->container_guid = $entity->guid;
		$translation->access_id = $entity->access_id;
		$translation->lang = $lang_code;
		
		// Set a specific view so we can switch to main entity
		$translation->view = 'entity/multilingual';
		
		$translation->save();
		
		$success_rel = $entity->addRelationship($translation->guid, 'has_translation');
		$success_rel = $translation->addRelationship($entity->guid, 'translation_of');
	}
	
	// @TODO Should be performed only for new entities, but better update it while developping...
	$translation->view = 'entity/multilingual';
	$success_rel = $entity->addRelationship($translation->guid, 'has_translation');
	$success_rel = $translation->addRelationship($entity->guid, 'translation_of');
	
	return $translation;
}




