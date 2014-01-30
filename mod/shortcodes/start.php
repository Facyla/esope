<?php
/**
 *	Elgg Shortcodes integration
 *	Author : Mohammed Aqeel | Team Webgalli + Facyla
 *	Team Webgalli | Elgg developers and consultants
 *	Mail : info@webgalli.com
 *	Web	: http://webgalli.com
 *	Skype : 'team.webgalli'
 *	@package Collections of Shortcodes for Elgg
 *	Licence : GNU2
 *	Copyright : Team Webgalli 2011-2015
 */ 
elgg_register_event_handler('init', 'system', 'elgg_shortcode_init');

function elgg_shortcode_init() {
	$root = dirname(__FILE__);
	
	// Short code processing library (from Wordpress)
	elgg_register_library('elgg:shortcode', "$root/lib/shortcodes.php");	
	elgg_load_library('elgg:shortcode');
	
	// Short code collections 
	elgg_register_library('elgg:elgg_shortcodes', "$root/lib/elgg_shortcodes.php");	
	elgg_load_library('elgg:elgg_shortcodes');
	
	// Extend JS and CSS for shortcode support
	elgg_extend_view('js/elgg', 'shortcodes/js');
	elgg_extend_view('css/elgg', 'shortcodes/css');
	
	// Process the shortcodes
	$views = array('output/longtext','river/item');
	foreach($views as $view){
		elgg_register_plugin_hook_handler("view", $view, "elgg_shortcode_filter", 1000);
	}
	
	// Some plugin functions
	elgg_register_page_handler('shortcodes', 'shortcodes_page_handler');
	if (!elgg_is_active_plugin('embed')) {
		$embed_js = elgg_get_simplecache_url('js', 'shortcodes/embed');
		elgg_register_simplecache_view('js/shortcodes/embed');
		elgg_register_js('elgg.embed', $embed_js, 'footer');
	}
	
	// Add shortcodes embed, or use longtext menu extend otherwise
	if (elgg_is_active_plugin('embed')) {
		elgg_register_plugin_hook_handler('register', 'menu:embed', 'shortcodes_embed_select_tab', 800);
	} else {
		elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	}
	
}

function elgg_shortcode_filter($hook, $entity_type, $returnvalue, $params){
	return elgg_do_shortcode($returnvalue);
}	

function shortcodes_longtext_menu($hook, $type, $items, $vars) {
	$url = 'shortcodes';
	$items[] = ElggMenuItem::factory(array(
		'name' => 'shortcodes',
		'href' => $url,
		'text' => elgg_echo('shortcodes:link'),
		'rel' => 'lightbox',
		'link_class' => "elgg-longtext-control elgg-lightbox",
		'priority' => 50,
	));
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');
	elgg_load_js('jquery.form');
	elgg_load_js('elgg.embed');
	return $items;
}
/**
 * Popup the content for the shortcodes help lightbox
 * @param array $page URL segments
 */
function shortcodes_page_handler($page) {
	
	echo elgg_view('shortcodes/list');
	exit;
}


// Shortcodes embed integration
function shortcodes_embed_select_tab($hook, $type, $items, $vars) {
	$items[] = ElggMenuItem::factory(array(
		'name' => 'shortcodes',
		'text' => elgg_echo('shortcodes:link'),
		'priority' => 600,
		'data' => array(
			'view' => 'embed/shortcodes',
		),
	));
	return $items;
}


