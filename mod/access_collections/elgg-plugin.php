<?php

use Facyla\AccessCollections\Bootstrap;

// Required libs & custom functions
require_once(__DIR__ . '/lib/access_collections/functions.php');

return [
	'plugin' => [
		'name' => 'Access collections',
		'version' => '7.0.0',
		'activate_on_install' => false,
	],

	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,

	// Settings defaults
	'settings' => [
		'allow_delete' => 'no',
	],

	// Actions
	'actions' => [
		'access_collections/settings/save' => [
			'access' => 'admin',
		],
	],

	// Events
	'events' => [
		// Add custom collections to user read access list
		'access:collections:read' => [
			'user' => [
				'access_collections_add_read_acl' => ['priority' => 999],
			],
		],
		// Add custom collections to user write access list
		'access:collections:write' => [
			'user' => [
				'access_collections_add_write_acl' => ['priority' => 999],
			],
		],
		// Sync ACL membership on metadata update
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
