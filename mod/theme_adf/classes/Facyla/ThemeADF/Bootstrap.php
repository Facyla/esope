<?php

namespace Facyla\ThemeADF;

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
		elgg_extend_view('elgg.css', 'theme_adf/main.css', 900);
		elgg_extend_view('admin.css', 'theme_adf/admin.css', 900);
		elgg_extend_view('walled_garden.css', 'theme_adf/walled_garden.css', 900);
		
		elgg_extend_view('page/elements/owner_block', 'theme_adf/groups/sidebar/search', 0);
		
		//elgg_extend_view('page/elements/owner_block/extend', 'groups/sidebar/pages', 1000);
		elgg_extend_view('page/elements/page_menu', 'groups/sidebar/pages', 1000);
		
		// Digest
		// Add all groups excerpt to digest
		elgg_unextend_view('digest/elements/site', 'digest/elements/site/blog');
		elgg_unextend_view('digest/elements/site', 'digest/elements/site/groups');
		elgg_unextend_view('digest/elements/site', 'digest/elements/site/river');
		elgg_extend_view('digest/elements/site', 'digest/elements/site/own_infos', 100);
		elgg_extend_view('digest/elements/site', 'digest/elements/site/thewire', 300);
		elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
		//elgg_extend_view('digest/elements/site', 'digest/elements/site/thewire', 503);
		
		
		//elgg_extend_view('page/elements/body', 'page/elements/group-header', 0);
		//elgg_extend_view('page/elements/owner_block', 'page/elements/group-search', 0);
		
		elgg_unextend_view('forms/register', 'forms/theme_adf_register_extend');
		// Ajouté manuellement sur la page d'accueil
		elgg_unextend_view('river/filter', 'thewire_tools/activity_post');
		
		// Suppression des signets en footer
		elgg_unregister_plugin_hook_handler('register', 'menu:footer', 'bookmarks_footer_menu');
		
		elgg_unregister_plugin_hook_handler('container_logic_check', 'object', \Elgg\File\GroupToolContainerLogicCheck::class);
		
	}
	
	public function activate() {
		// Dirty hack to update classes (use Bootstrap activate)
		
	}
	
	
}
