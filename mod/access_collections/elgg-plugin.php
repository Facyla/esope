<?php
use Facyla\AccessCollections\Bootstrap;

// Required libs & custom functions
//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/access_collections/functions.php');



return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Routes
	'routes' => [
	],
	
	
	'hooks' => [
		// Add custom collections to user read access list
		'access:collections:read' => [
			// Set up topbar menu
			'all' => [
				'access_collections_add_read_acl' => ['priority' => 999],
			],
		],
		// Add custom collections to user write access list
		'access:collections:write' => [
			// Set up topbar menu
			'all' => [
				'access_collections_add_write_acl' => ['priority' => 999],
			],
		],
	],
	
	
	'events' => [
		// Adds hook to automatically update collections members on metadata update
		'create' => [
			'metadata' => [
				'access_collections_metadata_update' => [],
			],
		],
		'update' => [
			'metadata' => [
				'access_collections_metadata_update' => [],
			],
		],
	],
	
];

