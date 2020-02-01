<?php
/**
 * Slider
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013-2019
 * @link https://facyla.fr/
 */

// @TODO Use AMD for JS scripts


function slider_init() {
	
	// Note : CSS we will be output directly into the view, so we can embed sliders on other sites (without the whole interface)
	elgg_extend_view('css','slider/css');
	
	// Integration with shortcodes plugin
	elgg_extend_view('shortcodes/embed/extend', 'slider/extend_shortcodes_embed');
	
	// register the JavaScript
	// note : cannot use resqire_js() as we need to insert a (static) php view into JS code // AMD modules do not accept .js.php files
	elgg_register_simplecache_view('js/slider/edit');
	
	// Register a URL handler for sliders
	elgg_register_plugin_hook_handler('entity:url', 'object', 'slider_url');
	
}


/* Populates the ->getUrl() method for slider objects */
function slider_url(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$entity = $hook->getParam('entity');
	if ($entity instanceof ElggSlider) {
		return elgg_get_site_url() . 'slider/view/' . $entity->guid;
	}
}


/* Gets a slider by its name, allowing theming on different instances
 * In case several sliders are found, only first match is displayed with an alert
 */
function slider_get_entity_by_name($name = '') {
	if (!empty($name)) {
		// Check first by GUID
		$slider = get_entity($name);
		if ($slider instanceof ElggSlider) { return $slider; }
		
		// Alternate method #2 by slider name
		$sliders = elgg_get_entities_from_metadata(array(
				'types' => 'object', 'subtypes' => 'slider', 
				'metadata_name_value_pairs' => array('name' => 'name', 'value' => $name), 
			));
		if ($sliders) {
			if (count($sliders) == 1) {
				return $sliders[0];
			} else {
				register_error(elgg_echo('slider:error:multiple'));
			}
		}
	}
	return false;
}

/* Checks if a given name is already used by a slider */
function slider_exists($name = '') {
	$ia = elgg_set_ignore_access(true);
	if (!empty($name)) {
		$slider = slider_get_entity_by_name($name);
		if ($slider instanceof ElggSlider) {
			elgg_set_ignore_access($ia);
			return true;
		}
	}
	elgg_set_ignore_access($ia);
	return false;
}


// Fonctions à exécuter après le chargement de tous les plugins
function slider_system_ready() {
	
	// Add slider shortcode for easier embedding of sliders
	if (elgg_is_active_plugin('shortcodes')) {
		elgg_load_library('elgg:shortcode');
		/**
		 * Slider shortcode
		 * [slider id="GUID"]
		 */
		function slider_shortcode_function($atts, $content='') {
			extract(elgg_shortcode_atts(array(
					'width' => '100%',
					'height' => '300px',
					'id' => '',
				), $atts));
			if (!empty($id)) {
				$slider = get_entity($id);
				if ($slider instanceof ElggSlider) {
					$content = elgg_view('slider/view', array('entity' => $slider));
				}
			}
			return $content;
		}
		elgg_add_shortcode('slider', 'slider_shortcode_function');
	}
	
}


// Use unique ID to allow multiple sliders into a single page..
function slider_unique_id($base = 'slider-uid-') {
	global $sliderUniqueID;
	if (!isset($sliderUniqueID)) { $sliderUniqueID = 0; }
	$sliderUniqueID++;
	return $base . $sliderUniqueID;
}


return function() {
	elgg_register_event_handler('init','system','slider_init');
	elgg_register_event_handler('ready','system','slider_system_ready');
};


