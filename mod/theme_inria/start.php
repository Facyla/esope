<?php

// Initialise log browser
register_elgg_event_handler('init','system','theme_inria_init');

/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;

	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	elgg_unregister_widget_type('thewire');
	elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', "Mes outils", "Une série d'outils pratiques");
	
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_inria_index');
	} else {
	  if (!$CONFIG->walled_garden) {
	    elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
	    elgg_register_plugin_hook_handler('index','system','theme_inria_public_index');
	  }
	}
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	
}

// f(n) theme inria index
function theme_inria_index(){
  global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_inria/loggedin_homepage.php');
	return true;
}

function theme_inria_public_index() {
  global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_inria/public_homepage.php');
  return true;
}


