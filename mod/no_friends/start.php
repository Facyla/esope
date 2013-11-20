<?php

	require_once(dirname(__FILE__) . "/lib/hooks.php");

	elgg_register_event_handler("init", "system", "no_friends_init");
	
	function no_friends_init() {
		// cleanup some menu's
		elgg_register_plugin_hook_handler("prepare", "menu:topbar", "no_friends_prepare_menu_cleanup_hook");
		elgg_register_plugin_hook_handler("prepare", "menu:filter", "no_friends_prepare_menu_cleanup_hook");
		elgg_register_plugin_hook_handler("register", "menu:user_hover", "no_friends_register_menu_cleanup_hook", 999999);
		
		if (!elgg_is_active_plugin("group_tools")) {
			elgg_register_plugin_hook_handler("prepare", "menu:title", "no_friends_prepare_menu_cleanup_hook");
		}
		
		// remove the friends widget
		elgg_unregister_widget_type("friends");
		
		// remove friends access
		elgg_register_plugin_hook_handler("access:collections:write", "user", "no_friends_write_access_array_hook");
		
		// remove some page handlers
		elgg_unregister_page_handler("friends");
		elgg_unregister_page_handler("collections");
	}