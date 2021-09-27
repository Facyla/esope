<?php
use Facyla\RegistrationFilter\Bootstrap;

// Required libs & custom functions
require_once(__DIR__ . '/lib/registration_filter/functions.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	'entities' => [],
	
	
	// Actions
	'actions' => [],
	
	
	// Routes
	'routes' => [
		'default:registration_filter' => [
			'path' => '/registration_filter',
			'resource' => 'registration_filter/index',
		],
	],
	
	
	'hooks' => [
		'registeruser:validate:email' => [
			'all' => [
				'registration_filter_validate_email_hook' => [
					'priority' => 1,
				],
			],
		],
	],
	
	
	'events' => [],
	
	
	// Widgets
	'widgets' => [],
	
];

