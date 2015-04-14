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

function slider_plugin_init() {
	global $CONFIG;

	elgg_extend_view('css','slider/css');
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



