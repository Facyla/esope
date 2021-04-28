<?php
use Facyla\GroupsArchive\Bootstrap;

// Required libs & custom functions
require_once(__DIR__ . '/lib/groups_archive/functions.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	'entities' => [
	],
	
	
	// Actions
	'actions' => [
	],
	
	
	// Routes
	'routes' => [
		// Register a page handler on "groups_archive/"
		'default:groups_archive' => [
			'path' => '/groups-archive',
			'resource' => 'groups_archive/index',
		],
		'groups_archive:view' => [
			'path' => '/groups-archive/view/{guid?}',
			'resource' => 'groups_archive/view',
		],
	],
	
	
	'hooks' => [
		// group entity menu
		'register' => [
			'menu:entity' => [
				'groups_archive_entity_menu_setup' => [],
			],
		],
	],
	
	
	'events' => [],
	
	
	// Widgets
	'widgets' => [
		// @TODO : archived groups (for admins)
	],
	
];

