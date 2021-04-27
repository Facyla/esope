<?php

namespace Facyla\AccessCollections;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {
		
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'access_collections/main.css', 900);
		elgg_extend_view('admin.css', 'access_collections/admin.css', 900);
		
		
		/* Available access and collections hooks
		
		// Determines SQL where clauses for read access to data (return valid SQL clauses)
		elgg_register_plugin_hook_handler('get_sql', 'access', 'access_collections_get_sql', 999);
		//$clauses = _elgg_services()->hooks->trigger('get_sql', 'access', $options, $clauses);
		
		// Not so useful hooks (for this plugin)
		// When adding a collection (return false interrupts collection creation)
		// Note: the collection is created, but doesn't return the collection ID
		elgg_register_plugin_hook_handler('access:collections:addcollection', 'collection', 'access_collections_addcollection')
		// When deleting a collection (return false interrupts collection deletion)
		elgg_register_plugin_hook_handler('access:collections:deletecollection', 'collection', 'access_collections_deletecollection')
		// Add user to collection (return false interrupts user addition)
		elgg_register_plugin_hook_handler('access:collections:add_user', 'collection', 'access_collections_add_user')
		// Remove user from collection (return false interrupts user removal)
		elgg_register_plugin_hook_handler('access:collections:remove_user', 'collection', 'access_collections_remove_user')
		*/
		
	}
	
	public function activate() {
		
	}
	
	
}
