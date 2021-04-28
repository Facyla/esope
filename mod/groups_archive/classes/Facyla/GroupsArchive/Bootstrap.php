<?php

namespace Facyla\GroupsArchive;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	public function boot() {
	}
	
	public function init() {
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'groups_archive/groups_archive.css');
		elgg_extend_view('admin.css', 'groups_archive/groups_archive.css');
		
	}
	
	public function activate() {
	}
	
}
