<?php
use Facyla\AccountLifeCycle\Bootstrap;

// Required libs & custom functions
require_once(__DIR__ . '/lib/account_lifecycle/functions.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'account_lifecycle',
			'class' => 'ElggAccountLifeCycle',
			'searchable' => false,
		],
	],
	
	
	// Actions
	'actions' => [
		'account_lifecycle/edit' => [],
	],
	
	
	// Routes
	'routes' => [
		'default:account_lifecycle' => [
			'path' => '/account_lifecycle',
			'resource' => 'account_lifecycle/index',
		],
		'account_lifecycle:add' => [
			'path' => '/account_lifecycle/add/{container_guid?}',
			'resource' => 'account_lifecycle/edit',
		],
		'account_lifecycle:edit' => [
			'path' => '/account_lifecycle/edit/{guid?}',
			'resource' => 'account_lifecycle/edit',
		],
	],
	
	
	'hooks' => [
		'registeruser:validate:email' => [
			'all' => [
				'account_lifecycle_validate_email_hook' => [
					'priority' => 1,
				],
			],
		],
		'cron' => [
			'daily' => [
				'account_lifecycle_cron' => [],
			],
		],
	],
	
	
	'events' => [],
	
	
	// Widgets
	'widgets' => [],
	
];

