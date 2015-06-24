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


// Init plugin
elgg_register_event_handler('init', 'system', 'multilingual_init');


/**
 * Init multilingual plugin.
 */
function multilingual_init() {
	
	elgg_extend_view('css', 'multilingual/css');
	
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
	
	
}



function multilingual_display_view_hook($hook_name, $entity_type, $return_value, $parameters){
	$view_name = $parameters['view']; // eg. output/longtext
	$entity = $parameters['vars']['entity']; // eg. output/longtext
	$entity = $parameters['vars']['input']['guid']; // eg. output/longtext
	
	$return_value = $return_value . "<hr />TRANSLATIONS : ";
	$return_value .= $view_name . " " . print_r($parameters['vars'], true);
	
	return $return_value;
}

// Other useful functions
// prefixed by plugin_name_
/*
function multilingual_function() {
	
}
*/



