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

	Clone original entity
	+ add specific metadata (locale)
	+ add a view property to handle proper display of translations (hacky method)
	+ add relation to original entity (has_translation and translation_of)

	@TODO Handle entity lifecycle : events handlers ready, remaining todos :
	 - synchronize updates (access_id, owner_guid, container_guid) 
	 - handle deletes (could possibly let user select whether trasnlations should be destroyed, or a new "main" translation set)

	@TODO Handle properly URLs using lang modifiers
	 - currently using different GUIDs...
	 - the entity/multilingual view enables a hook-like hacks to handle it
	 - use geturl hook to update urls for translated entities ? 
	    would work on 1.11, not 1.8, because we need to modify under somes conditions, not rewrite the handler
	    and 1.8 version only supports 1 handler function
	    * 1.8 :elgg_register_entity_url_handler($entity_type, $entity_subtype, $function_name)

	@TODO almost OK (functional but not best implementation) - Hook entity display to check if a given entity is a translation
	 - redirect to main entity URL + locale is performed lately but surely in the pseudo-hook view

	@TODO Access through main entity only, which determines access, URL
	 - not very clear : access is the same

	@TODO Quick language selector : partly done
	 - OK - auto-select default language if available (based on user choice, then site choice)
	 - auto-determine site language if not logged in (see Coldtrick's plugin which seems to do that great)
	 - quick set current language (idem)

	@TODO Handle HTML META 
	 - tell there are other translations of a given content
	 - provide link to main content (especially for translations which have their own GUID but we prefer not to display it too much)

	@TODO Note on missing hook in elgg_view_entity : we may use the one in elgg_view, using its $params['vars'] to get the viewed entity...

*/

// Init plugin
elgg_register_event_handler('init', 'system', 'multilingual_init');


/**
 * Init multilingual plugin.
 */
function multilingual_init() {
	
	elgg_extend_view('css', 'multilingual/css');
	
	// Translate button to entities
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'multilingual_entity_menu_setup');
	
	// Intercept create/edit event to update metadata on objects
	elgg_register_event_handler("create", "all", "multilingual_create_handler_event");
	elgg_register_event_handler("update", "all", "multilingual_update_handler_event");
	elgg_register_event_handler("delete", "all", "multilingual_delete_handler_event");
	
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
	
	elgg_register_page_handler('multilingual', 'multilingual_page_handler');
	
	// Ensure consistent URL for entities
	elgg_register_plugin_hook_handler('entity:url', 'object', 'multilingual_set_url');
	
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


/**
 * Format and return the URL for multilingual content
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of entity.
 */
function multilingual_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity)) {
		// Update URL only if entity is a translation
		$main_entity = multilingual_get_main_entity($entity);
		if ($main_entity->guid != $entity->guid) {
			return $main_entity->getURL() . '?lang=' . $entity->locale;
		}
	}
}


// Langue principale et par défaut des entités
function multilingual_get_main_language() {
	$main_lang = elgg_get_plugin_setting('main_locale', 'multilingual');
	if (empty($main_lang)) {
		global $CONFIG;
		$main_lang = $CONFIG->language;
	}
	return $main_lang;
}


// Get entity locale
function multilingual_get_entity_language($entity) {
	if (!empty($entity->locale)) { return $entity->locale; }
	
	$main_lang = multilingual_get_main_language();
	// Should we also set the default language ? this accelerates further checks
	$entity->locale = $main_lang;
	
	return $main_lang;
}



// Langues autorisées pour les traductions
// Include main language or not in listing ?
function multilingual_available_languages($include_main = true) {
	$main_lang = multilingual_get_main_language();
	
	$languages = elgg_get_plugin_setting('locales', 'multilingual');
	$languages = str_replace(array(' ', "\n", "\r", ','), ',', $languages);
	$languages = explode(',', $languages);
	$languages = array_unique($languages);
	$languages = array_filter($languages);
	
	if (is_array($languages)) {
		$available_languages = array();
		foreach ($languages as $code) {
			$available_languages[$code] = elgg_echo($code);
		}
		if ($include_main) {
			$available_languages[$main_lang] = elgg_echo($main_lang);
		} else {
			// Just in case it has been also set in available languages settings...
			unset($available_languages[$main_lang]);
		}
		return $available_languages;
	}
	return false;
}


// Returns eligible subtypes for a given entity type (usually object)
function multilingual_get_valid_subtypes($type = 'object') {
	// Note : add new settings if other types are handled
	$object_subtypes = elgg_get_plugin_setting('object_subtypes', 'multilingual');
	$object_subtypes = str_replace(array(' ', "\n", "\r", ','), ',', $object_subtypes);
	$object_subtypes = explode(',', $object_subtypes);
	$object_subtypes = array_filter($object_subtypes);
	return $object_subtypes;
}



// Bouton d'ajout de traduction
function multilingual_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }
	$entity = $params['entity'];
	//$entity_types = elgg_get_plugin_setting('types', 'multilingual');
	//if (elgg_instanceof($entity)) {
	// Limit to objects for the moment (groups and even more users require other special attentions)
	$object_subtypes = multilingual_get_valid_subtypes();
	if (elgg_instanceof($entity, 'object')) {
		$subtype = $entity->getSubtype();
		if (empty($object_subtypes) || in_array($subtype, $object_subtypes)) {
			$main_lang = multilingual_get_main_language();
			$languages = multilingual_available_languages();
		
			$main_entity = multilingual_get_main_entity($entity);
			$current_lang = multilingual_get_entity_language($entity);
		
			$view_url = $main_entity->getURL();
			$translate_url = elgg_get_site_url() . 'multilingual/translate/' . $main_entity->guid . '/';
		
			// Display current entity language
			$class = 'elgg-menu-multilingual';
			if ($entity->guid == $main_entity->guid) {
				$title = elgg_echo('multilingual:menu:currentlocale', array($languages[$main_lang]));
				$href = false;
				$class .= ' elgg-selected';
			} else {
				$title = elgg_echo('multilingual:menu:viewinto', array($languages[$main_lang]));
				$href = $view_url;
			}
			$text = '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $main_lang . '.gif" alt="' . $main_lang . '" title="' . $title . '" />';
			$return[] = ElggMenuItem::factory(array(
					'name' => 'multilingual-current', 
					'text' => $text, 'href' => $href, 'title' => $title, 
					'priority' => 118, 'item_class' => $class, 
				));
			// Remove from new translations array
			unset($languages[$main_lang]);
		
			// Display existing translations
			$translations = multilingual_get_translations($main_entity);
			if ($translations) {
				foreach ($translations as $ent) {
					$class = 'elgg-menu-multilingual';
					if ($entity->guid == $ent->guid) {
						$title = elgg_echo('multilingual:menu:currentlocale', array($languages[$ent->locale]));
						$href = false;
						$class .= ' elgg-selected';
					} else {
						$title = elgg_echo('multilingual:menu:viewinto', array($languages[$ent->locale]));
						//$href = $view_url . '?lang=' . $ent->locale;
						$href = $ent->getURL();
					}
					$text = '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $ent->locale . '.gif" alt="' . $ent->locale . '" title="' . $title . '" />';
					$return[] = ElggMenuItem::factory(array(
							'name' => 'multilingual-version-' . $ent->locale, 
							'text' => $text, 'href' => $href, 'title' => $title, 
							'priority' => 118, 'item_class' => $class, 
						));
					// Remove from new translations array
					unset($languages[$ent->locale]);
				}
			}
		}
		
		// @TODO : use a different access rule for translations ?  then maybe a translator role could allow editing other languages versions (but alternative versions *only* - and not the main content)
		if (elgg_instanceof($main_entity) && $main_entity->canEdit()) {
			foreach ($languages as $lang_code => $lang_name) {
				if ($lang_code == $current_lang) { continue; }
				$class = 'elgg-menu-multilingual';
				$href = $translate_url . $lang_code;
				$text = '<img src="' . elgg_get_site_url() . 'mod/multilingual/graphics/flags/' . $lang_code . '.gif" alt="' . $lang_code . '" />';
				$title = elgg_echo('multilingual:menu:translateinto', array($languages[$lang_code]));
				$return[] = ElggMenuItem::factory(array(
						'name' => 'multilingual-version-' . $lang_code, 
						'text' => $text, 'href' => $href, 'title' => $title, 
						'is_action' => true, 'is_trusted' => true, 
						'confirm' => elgg_echo('multilingual:translate:confirm', array($lang_name)), 
						'priority' => 118, 'item_class' => $class, 'style' => "opacity:0.3;", 
					));
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
			'metadata_name_value_pairs' => array('name' => 'locale', 'value' => $lang_code),
			// Alternate version which supports regional variants
			//'metadata_name_value_pairs' => array('name' => 'locale', 'value' => $lang_code . '%', 'operand' => 'LIKE'),
		));
	if ($translations) { return $translations[0]; }
	return false;
}



/* Return main entity for a given translation
 */
function multilingual_get_main_entity($translation){
	// Get existing translated entity
	$entities = elgg_get_entities_from_relationship(array(
			'relationship' => 'translation_of',
			'relationship_guid' => $translation->guid,
			'inverse_relationship' => false,
		));
	if ($entities) { return $entities[0]; }
	
	// If no translation found, then it is the main entity
	return $translation;
}



/* Add new translation to entity, or update existing translation
 */
function multilingual_add_translation($entity, $lang_code = 'en'){
	// Check existing translation
	$translation = multilingual_get_translation($entity, $lang_code);
	
	// Translate only objects for the moment
	if (!elgg_instanceof($translation, 'object')) {
		// Create new translation only if allowed by settings
		$object_subtypes = multilingual_get_valid_subtypes();
		$subtype = $entity->getSubtype();
		if (in_array($subtype, $object_subtypes)) {
			if ($entity->canEdit()) {
				$translation = clone $entity;
		
				// @TODO decide who is the owner..  it may be the original object (easy deletion + inheritance), or the original owner, or the current editor
		
				// Option 1 : Same owner and container as parent - this is the "cleanest" option
				// No need to change anything then..
		
				// Option 2 : Editor is the new owner (but he's actually not a real owner + access issues)
				//$translation->owner_guid = elgg_get_logged_in_user_guid();
		
				// Option 3 : Set parent object as owner & container
				//$translation->owner_guid = $entity->guid;
				//$translation->container_guid = $entity->guid;
		
				$translation->locale = $lang_code;
		
				// Add a [to be translated into LANG] prefix to main known content properties
				$lang_name = elgg_echo($lang_code);
				$prefix = elgg_echo('multilingual:prefix:todo', array($lang_name));
				$known_prop_and_meta = array('title', 'description', 'briefdescription', 'excerpt');
				foreach($known_prop_and_meta as $meta) {
					if (!empty($translation->{$meta})) { $translation->{$meta} = $prefix . $translation->{$meta}; }
				}
		
				// Set a specific view so we can switch to main entity
				$translation->view = 'entity/multilingual';
		
				$translation->save();
		
				$success_rel = $entity->addRelationship($translation->guid, 'has_translation');
				$success_rel = $translation->addRelationship($entity->guid, 'translation_of');
			} else {
				register_error(elgg_echo('multilingual:error:cannotedit'));
			}
		} else {
			register_error(elgg_echo('multilingual:error:invalidsubtype'));
		}
	}
	
	// Update original entity so it can support multilingual features
	if (empty($entity->locale)) $entity->locale = multilingual_get_main_language();
	if (empty($entity->view)) $entity->view = 'entity/multilingual';
	
	return $translation;
}



// Adds useful metadata for multilingual support
function multilingual_create_handler_event($event, $type, $entity) {
	if (elgg_instanceof($entity)) {
		// Set language to main, if not set
		if (empty($entity->locale)) $entity->locale = multilingual_get_main_language();
		// Also set a multilingual view, so we can intercept the rendering (pseudo-hook)
		if (empty($entity->view)) $entity->view = 'entity/multilingual';
		
		// @TODO If new entity is a translation, force owner and container to the original content 
		// Note : different access id can be useful (draft)
		
	}
}

// Adds metadata for multilingual support
function multilingual_update_handler_event($event, $type, $entity) {
	if (elgg_instanceof($entity)) {
		// Update language to main, if not set
		if (empty($entity->locale)) $entity->locale = multilingual_get_main_language();
		// Also set a multilingual view, so we can intercept the rendering (pseudo-hook)
		if (empty($entity->view)) $entity->view = 'entity/multilingual';
		
		// @TODO If updated entity is a translation, force owner and container to the original content 
		// Note : different access id can be useful (draft)
		
		// @TODO If it is the original content, updated translations accordingly
		// Note : should access be synchronized
		
	}
}

// Performs some cleaning tasks on entity removal
function multilingual_delete_handler_event($event, $type, $entity) {
	if (elgg_instanceof($entity)) {
		
		// @TODO If it is a translation, forward to main entity !
		
		// @TODO If it is the original content, delete all translations
		
	}
	
}


