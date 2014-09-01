<?php
/**
* Elgg socialshare plugin
* 
* @package
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL http://id.facyla.net/
* @copyright Florian DANIEL
* @link http://id.facyla.net/
*/

elgg_register_event_handler('init','system','socialshare_init');

function socialshare_init() {
	
	elgg_extend_view('css/elgg', 'socialshare/css');
	/*
	//$extended = 'owner_block/extend';
	$extension = 'socialshare/extend';
	$extendviews = elgg_get_plugin_setting('extendviews', 'socialshare');
	if (!empty($extendviews)) {
		$extendviews = str_replace(array(';', ' ', '\n', '\r', '\t'), ',', $extendviews);
		$extendviews = explode(',', $extendviews);
		$extendviews = array_filter($extendviews);
		foreach($extendviews as $view) {
			$view = trim($view);
			if (!empty($view)) {
				elgg_extend_view($view, $extension);
			}
		}
	}
	*/
	
	elgg_register_event_handler("pagesetup", "system", "socialshare_pagesetup");
	
}

function socialshare_pagesetup(){
	elgg_register_menu_item("extras", array(
		"name" => "socialshare",
		"href" => false,
		"text" => elgg_view("socialshare/extend"),
		"priority" => 10000,
	));
}

