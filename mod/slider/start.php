<?php
/**
 * Slider
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2013
 * @link http://id.facyla.net/
 */

elgg_register_event_handler('init','system','slider_plugin_init');
elgg_register_event_handler('pagesetup','system','slider_pagesetup');

function slider_plugin_init() {
	global $CONFIG;
	
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
	elgg_register_action("slider/delete", $actions_path . 'delete.php');
	
		// register the JavaScript (autoloaded in 1.10)
	elgg_register_simplecache_view('js/slider/edit');
	$js = elgg_get_simplecache_url('js', 'slider/edit');
	elgg_register_js('elgg.slider.edit', $js);
	
	// Register a URL handler for CMS pages
	elgg_register_entity_url_handler('object', 'slider', 'slider_url');
	
}


/* Populates the ->getUrl() method for cmspage objects */
function slider_url($slider) {
	return elgg_get_site_url() . "slider/view/" . $slider->guid;
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
			$slider_content = '';
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


