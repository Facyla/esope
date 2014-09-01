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


function socialshare_init() {
	//$extended = 'owner_block/extend';
	$extension = 'socialshare/extend';
	$extendviews = elgg_get_plugin_setting('extendviews', 'socialshare');
	if (!empty($extendviews)) {
		$extendviews = str_replace(array(';', ' ', '\n', '\r', '\t'), ',', $extendviews);
		$extendviews = explode(',', $extendviews);
		$extendviews = array-filter($extendviews);
		foreach($extendviews as $view) {
			$view = trim($view);
			if (!empty($view)) {
				elgg_extend_view($view, $extension);
			}
		}
	}
}

elgg_register_event_handler('init','system','socialshare_init');

