<?php

	function no_friends_prepare_menu_cleanup_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		// forbidden menu item names
		$forbidden_names = array(
			"friends",
			"friend",
			"groups:invite",
		);
		
		if (!empty($result) && is_array($result)) {
			// loop through the menu sections
			foreach ($result as $section => $menu_items) {
				if (!empty($menu_items) && is_array($menu_items)) {
					// loop through the menu items
					foreach ($menu_items as $index => $menu_item) {
						if (in_array($menu_item->getName(), $forbidden_names)) {
							// remove menu item
							unset($result[$section][$index]);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	function no_friends_register_menu_cleanup_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		// forbidden menu item names
		$forbidden_names = array(
			"remove_friend",
			"add_friend",
		);
		
		if (!empty($result) && is_array($result)) {
			// loop through the menu items
			foreach ($result as $index => $menu_item) {
				if (!empty($menu_item) && ($menu_item instanceof ElggMenuItem)) {
					if (in_array($menu_item->getName(), $forbidden_names)) {
						// remove menu item
						unset($result[$index]);
					}
				}
			}
		}
		
		return $result;
	}
	
	function no_friends_write_access_array_hook($hook, $type, $returnvalue, $params) {
		$result = $returnvalue;
		
		if (!empty($params) && is_array($params)) {
			// remove friends access
			unset($result[ACCESS_FRIENDS]);
			
			// unset access collections
			if (($user_guid = elgg_extract("user_id", $params)) && ($site_guid = elgg_extract("site_id", $params))) {
				if ($access_collections = get_user_access_collections($user_guid, $site_guid)) {
					foreach ($access_collections as $acl) {
						unset($result[$acl->id]);
					}
				}
			}
		}
		
		return $result;
	}