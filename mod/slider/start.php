<?php
/**
 * Slider
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

// @TODO Use AMD for JS scripts

elgg_register_event_handler('init','system','slider_plugin_init');
elgg_register_event_handler('pagesetup','system','slider_pagesetup');

function slider_plugin_init() {
	
	// Note : CSS we will be output anyway directly into the view, so we can embed sliders on other sites
	elgg_extend_view('css','slider/css');
	
	elgg_extend_view('shortcodes/embed/extend', 'slider/extend_shortcodes_embed');
	
	/*
	<!-- Anything Slider optional plugins -->
	<script src="js/jquery.easing.1.2.js"></script>
	<!-- http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js -->
	<script src="js/swfobject.js"></script>

	<!-- Demo stuff -->
	<link rel="stylesheet" href="demos/css/page.css" media="screen">
	<script src="demos/js/jquery.jatt.min.js"></script>

	<!-- AnythingSlider -->
	<link rel="stylesheet" href="css/anythingslider.css">
	<script src="js/jquery.anythingslider.js"></script>

	<!-- AnythingSlider video extension; optional, but needed to control video pause/play -->
	<script src="js/jquery.anythingslider.video.js"></script>

	<!-- Ideally, add the stylesheet(s) you are going to use here,
	 otherwise they are loaded and appended to the <head> automatically and will over-ride the IE stylesheet below -->
	<link rel="stylesheet" href="css/theme-metallic.css">
	<link rel="stylesheet" href="css/theme-minimalist-round.css">
	<link rel="stylesheet" href="css/theme-minimalist-square.css">
	<link rel="stylesheet" href="css/theme-construction.css">
	<link rel="stylesheet" href="css/theme-cs-portfolio.css">
	*/
	
	// Register main page handler
	elgg_register_page_handler('slider', 'slider_page_handler');
	
	// Register actions
	$actions_path = elgg_get_plugins_path() . 'slider/actions/slider/';
	elgg_register_action("slider/edit", $actions_path . 'edit.php');
	elgg_register_action("slider/clone", $actions_path . 'clone.php');
	elgg_register_action("slider/delete", $actions_path . 'delete.php');
	
		// register the JavaScript (autoloaded in 1.10)
	elgg_register_simplecache_view('js/slider/edit');
	$js = elgg_get_simplecache_url('js', 'slider/edit');
	elgg_register_js('elgg.slider.edit', $js);
	
	// AnythingSlider
	slider_register_libraries();
	/*
	$vendor_url = elgg_get_site_url() . 'mod/slider/vendors/anythingslider/';
	elgg_register_js('elgg.slider.anythingslider', $vendor_url . 'js/jquery.anythingslider.js');
	elgg_register_js('elgg.slider.anythingslider.easing', $vendor_url . 'js/jquery.easing.1.2.js');
	elgg_register_js('elgg.slider.anythingslider.swf', $vendor_url . 'js/swfobject.js');
	elgg_register_js('elgg.slider.anythingslider.video', $vendor_url . 'js/jquery.anythingslider.video.js');
	elgg_register_css('elgg.slider.anythingslider', $vendor_url . 'css/anythingslider.css');
	elgg_register_css('elgg.slider.anythingslider.theme-construction', $vendor_url . 'css/theme-construction.css');
	elgg_register_css('elgg.slider.anythingslider.theme-cs-portfolio', $vendor_url . 'css/theme-cs-portfolio.css');
	elgg_register_css('elgg.slider.anythingslider.theme-metallic', $vendor_url . 'css/theme-metallic.css');
	elgg_register_css('elgg.slider.anythingslider.theme-minimalist-round', $vendor_url . 'css/theme-minimalist-round.css');
	elgg_register_css('elgg.slider.anythingslider.theme-minimalist-square', $vendor_url . 'css/theme-minimalist-square.css');
	*/
	
	
	// Register a URL handler for sliders
	elgg_register_plugin_hook_handler('entity:url', 'object', 'slider_url');
	
}


/* Populates the ->getUrl() method for slider objects */
function slider_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'slider')) {
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
		if (elgg_instanceof($slider, 'object', 'slider')) { return $slider; }
		
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
		if (elgg_instanceof($slider, 'object', 'slider')) {
			elgg_set_ignore_access($ia);
			return true;
		}
	}
	elgg_set_ignore_access($ia);
	return false;
}

/* Main tool page handler */
function slider_page_handler($page) {
	$include_path = elgg_get_plugins_path() . 'slider/pages/slider/';
	if (empty($page[0])) { $page[0] = 'index'; }
	switch ($page[0]) {
		case "view":
			// @TODO display slider in one_column layout, or iframe mode ?
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			if (include($include_path . 'view.php')) { return true; }
			break;
			
		case "add":
			if (!empty($page[1])) { set_input('container_guid', $page[1]); }
			// @TODO display slider in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
		
		case "edit":
			if (!empty($page[1])) { set_input('guid', $page[1]); }
			// @TODO display slider in one_column layout, or iframe mode ?
			if (include($include_path . 'edit.php')) { return true; }
			break;
			
		case 'admin':
			// @TODO Forward to plugin settings
			forward('admin/plugin_settings/slider');
			break;
		
		case 'index':
		default:
			if (include($include_path . 'index.php')) { return true; }
	}
	return false;
}



// Foncitons à exécuter après le chargement de tous les plugins
function slider_pagesetup() {
	
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
				if (elgg_instanceof($slider, 'object', 'slider')) {
					$content = elgg_view('slider/view', array('entity' => $slider));
				}
			}
			return $content;
		}
		elgg_add_shortcode('slider', 'slider_shortcode_function');
	}
	
}


function slider_get_vendors_config() {
	$vendors_url = elgg_get_site_url() . 'mod/slider/vendors/';
	
	return array(
			
			// AnythingSlider
			'anythingslider' => array(
					array('type' => 'js', 'url' => $vendors_url . 'anythingslider/js/jquery.anythingslider.js', 'name' => 'elgg.slider.anythingslider'),
					// OPTIONAL JS
					array('type' => 'js', 'url' => $vendors_url . 'anythingslider/js/jquery.easing.1.2.js', 'name' => 'elgg.slider.anythingslider.easing'),
					array('type' => 'js', 'url' => $vendors_url . 'anythingslider/js/swfobject.js', 'name' => 'elgg.slider.anythingslider.swf'),
					array('type' => 'js', 'url' => $vendors_url . 'anythingslider/js/jquery.anythingslider.video.js', 'name' => 'elgg.slider.anythingslider.video'),
					// CSS
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/anythingslider.css', 'name' => 'elgg.slider.anythingslider'),
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/animate.css', 'name' => 'elgg.slider.anythingslider.animate'),
					// Themes
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/theme-construction.css', 'name' => 'elgg.slider.anythingslider.theme-construction'),
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/theme-cs-portfolio.css', 'name' => 'elgg.slider.anythingslider.theme-cs-portfolio'),
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/theme-metallic.css', 'name' => 'elgg.slider.anythingslider.theme-metallic'),
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/theme-minimalist-round.css', 'name' => 'elgg.slider.anythingslider.theme-minimalist-round'),
					array('type' => 'css', 'url' => $vendors_url . 'anythingslider/css/theme-minimalist-square.css', 'name' => 'elgg.slider.anythingslider.theme-minimalist-square'),
				), 
			
			// Coinslider
			'coinslider' => array(
					array('type' => 'js', 'url' => $vendors_url . 'coinslider/coin-slider.min.js', 'name' => 'elgg.slider.coinslider'),
					array('type' => 'css', 'url' => $vendors_url . 'flexslider/coin-slider-styles.css', 'name' => 'elgg.slider.coinslider'),
				), 
				
				// FlexSlider
			'flexslider' => array(
					array('type' => 'js', 'url' => $vendors_url . 'flexslider/jquery.flexslider-min.js', 'name' => 'elgg.slider.flexslider'),
					array('type' => 'css', 'url' => $vendors_url . 'flexslider/flexslider.css', 'name' => 'elgg.slider.flexslider'),
				), 
				
			// NivoSlider
			'nivoslider' => array(
					array('type' => 'js', 'url' => $vendors_url . 'nivoslider/jquery.nivo.slider.pack.js', 'name' => 'elgg.slider.nivoslider'),
					array('type' => 'css', 'url' => $vendors_url . 'nivoslider/nivo-slider.css', 'name' => 'elgg.slider.nivoslider'),
				), 
				
			// ResponsiveSlides
			'responsiveslides' => array(
					array('type' => 'js', 'url' => $vendors_url . 'responsiveslides/responsiveslides.min.js', 'name' => 'elgg.slider.responsiveslides'),
					array('type' => 'css', 'url' => $vendors_url . 'responsiveslides/responsiveslides.css', 'name' => 'elgg.slider.responsiveslides'),
				), 
		);
}



// Check enabled libraries and register the corresponding scripts and CSS
function slider_register_libraries() {
	// List available libraries
	$libraries_config = slider_get_vendors_config();
	
	// @TODO enable only wanted plugins
	
	global $slider_registered_libs;
	$slider_registered_libs = array();
	
	// Register JS scripts and CSS files
	foreach ($libraries_config as $vendor => $lib_config) {
		foreach ($lib_config as $name => $config) {
			switch($config['type']) {
				case 'js':
					$libname = $name;
					if (isset($config['name'])) $libname = $config['name'];
					$location = 'head';
					if (isset($config['location'])) $libname = $config['location'];
					elgg_register_js($libname, $config['url'], $location);
					$slider_registered_libs[$vendor]['js'][] = $libname;
					break;
				case 'css':
					$libname = $name;
					if (isset($config['name'])) $libname = $config['name'];
					elgg_register_css($libname, $config['url']);
					$slider_registered_libs[$vendor]['css'][] = $libname;
					break;
			}
		}
	}
}


// Load registered JS and CSS libraries for a given vendor
function slider_load_libraries($vendor = 'anythingslider') {
	global $slider_registered_libs;
	if (!isset($slider_registered_libs[$vendor])) { $vendor = 'anythingslider'; }
	
	// Load registered libs
	foreach ($slider_registered_libs[$vendor] as $type => $libraries) {
		switch($type) {
			case 'js':
				foreach ($libraries as $name) { elgg_load_js($name); }
				break;
			case 'css':
				foreach ($libraries as $name) { elgg_load_css($name); }
				break;
		}
	}
}


// Use unique ID to allow multiple sliders into a single page..
function slider_unique_id($base = 'slider-uid-') {
	global $sliderUniqueID;
	if (!isset($sliderUniqueID)) { $sliderUniqueID = 0; }
	$sliderUniqueID++;
	return $base . $sliderUniqueID;
}




