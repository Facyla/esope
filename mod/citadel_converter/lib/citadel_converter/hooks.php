<?php
/* Hook functions
 * Hooks usually return $result, or other meaningful result
 * $result is passed to the next registered hook
 * $result value may block upcoming registered hooks
 * $params is an array passed by hook triggering code
 
 * See hook triggering code for reference on $result handling and passed $params
 */



function citadel_converter_page_menu($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		// only show menu in converter pages
		if (elgg_in_context('citadel_converter')) {
			$base_url = elgg_get_site_url() . 'citadel_converter';
			$return[] = new ElggMenuItem('citadel_converter', "Accueil convertisseur", 'citadel_converter');
			$return[] = new ElggMenuItem('citadel_converter_template', "Générateur de template de conversion", 'citadel_converter/template');
		}
	}
	return $return;
}
