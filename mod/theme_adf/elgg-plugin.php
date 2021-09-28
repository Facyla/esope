<?php
use Facyla\ThemeADF\Bootstrap;

// Required libs & custom functions
//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/theme_adf/functions.php');
require_once(__DIR__ . '/lib/theme_adf/hooks.php');



return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	/*
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'naturalconnect_organisation',
			'class' => 'ElggNaturalConnectOrganisation',
			'searchable' => true,
		],
	],
	*/

	// Actions
	'actions' => [
		'pages/edit' => [],
	],
	
	
	// Routes
	'routes' => [
		'contributions:index' => [
			'path' => '/contributions/{container_guid?}',
			'resource' => 'contributions',
		],
		
	],
	
	
	'hooks' => [
		'head' => [
			'page' => [
				'theme_adf_head_page_hook' => ['priority' => 1000],
			],
		],
		// Public pages - permet d'intégrer les icônes dans les digest
		'public_pages' => [
			'walled_garden' => [
				'theme_adf_public_pages' => [],
			],
		],
		// Add / modify menu items
		'register' => [
			// Set up topbar menu
			'menu:topbar' => [
				'theme_adf_topbar_menu' => ['priority' => 1000],
			],
			// Set up site menu
			'menu:site' => [
				'theme_adf_site_menu' => ['priority' => 1000],
			],
		],
	],
	
	
	'events' => [
		'init' => [
			'system' => [
				'theme_adf_init' => [],
			],
		],
	],
	
	
	// Widgets
	'widgets' => [
		/*
		// Module générique (affichage de tous types de vues via divers éléments de configuration)
		'naturalconnect_generic' => ['context' => $widgets_context, 'multiple' => true],
		*/
	],
	
	/* Pourrait être intéressant pour gérer les dépendances mais n'apparaît pas dans la page des plugins 
	'plugin' => [
		'name' => 'Thème ADF - Départements en Réseaux', // readable plugin name
		'activate_on_install' => false, // only used on a fresh install
		'version' => '3.3.0', // version of the plugin
		'dependencies' => [
			// optional list of plugin dependencies
			'groups' => [
				'position' => 'after',
				'must_be_active' => true,
			],
			'members' => [
				'position' => 'after',
				'must_be_active' => true,
			],
			'profile' => [
				'position' => 'after',
				'must_be_active' => true,
			],
			'search' => [
				'position' => 'after',
				'must_be_active' => true,
			],
			'notifications' => [],
//			'blog' => [],
//			'activity' => [
//				'position' => 'after',
//				'must_be_active' => false,
//			],
//			'file' => [
//				'position' => 'before',
//				'version' => '>2', // composer notation of required version constraint
//			],
		],
	],
	*/
	
];

