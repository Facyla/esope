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

	// Actions
	'actions' => [
		'naturalconnect/register' => [
			'access' => 'public',
		],
	],
	*/
	
	
	// Routes
	'routes' => [
		/*
		'groups:files' => [
			'path' => '/groups/file/{guid?}/{title?}',
			'resource' => 'groups/file',
		],
		
		'naturalconnect:places:add' => [
			'path' => '/places/add/{guid?}/{title?}',
			'resource' => 'naturalconnect/places/edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		*/
		
	],
	
	
	'hooks' => [
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
		/*
		// Remove "more" submenu
		'prepare' => [
			'menu:site' => [
				'naturalconnect_prepare_site_menu' => ['priority' => 1000],
			],
			'menu:topbar' => [
				'naturalconnect_prepare_topbar_menu' => ['priority' => 1000],
			],
		],
		'head' => [
			'page' => [
				'naturalconnect_head_page_hook' => ['priority' => 1000],
			],
		],
		// Set URL handler for 'organisations', 'hubs' and 'services' objects
		'entity:url' => [
			'object' => [
				'naturalconnect_entities_url' => [],
			],
			'group' => [
				'naturalconnect_places_url' => ['priority' => 600],
			],
		],
		'register' => [
			// Set up topbar menu
			'menu:topbar' => [
				'naturalconnect_topbar_menu' => ['priority' => 1000],
			],
			'menu:notifications' => [
				'naturalconnect_notifications_menu' => ['priority' => 1000],
			],
			// Set up main menu
			'menu:site' => [
				'naturalconnect_site_menu' => ['priority' => 1000],
			],
			// Set up footer menu => static view
			//'menu:footer' => [
			//	'naturalconnect_footer_menu' => ['priority' => 1000],
			//],
			// Set object edit menu URL
			'menu:entity' => [
				'naturalconnect_entities_menu' => [],
			],
		],
		// Set icons for custom entities
		'entity:icon:url' => [
			'object' => [
				'naturalconnect_set_icon_url' => [],
			],
		],
		*/
	],
	
	
	'events' => [
		'init' => [
			'system' => [
				'theme_adf_init' => [],
			],
		],
		/*
		// Handle group subtypes and custom fields
		'create' => [
			'group' => [
				'naturalconnect_groups_edit_event_listener' => [],
			],
		],
		'update' => [
			'group' => [
				'naturalconnect_groups_edit_event_listener' => [],
			],
		],
		// Determines and sets the current environment
		'pagesetup' => [
			'system' => [
				'naturalconnect_pagesetup' => ['priority' => 0],
			],
		],
		*/
		
	],
	
	
	// Widgets
	'widgets' => [
		/*
		// Module générique (affichage de tous types de vues via divers éléments de configuration)
		'naturalconnect_generic' => ['context' => $widgets_context, 'multiple' => true],
		*/
	],
	
];

