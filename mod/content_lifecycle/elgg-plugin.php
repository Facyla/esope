<?php
use Facyla\ContentLifeCycle\Bootstrap;

// Required libs & custom functions
require_once(__DIR__ . '/lib/content_lifecycle/functions.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	'entities' => [
		/*
		[
			'type' => 'object',
			'subtype' => 'content_lifecycle',
			'class' => 'ElggContentLifeCycle',
			'searchable' => false,
		],
		*/
	],
	
	
	// Actions
	'actions' => [
		//'content_lifecycle/edit' => [],
	],
	
	
	// Routes
	'routes' => [
		'default:content_lifecycle' => [
			'path' => '/content_lifecycle/{guid?}',
			'resource' => 'content_lifecycle/index',
		],
		/*
		'content_lifecycle:add' => [
			'path' => '/content_lifecycle/add/{container_guid?}',
			'resource' => 'content_lifecycle/edit',
		],
		'content_lifecycle:edit' => [
			'path' => '/content_lifecycle/edit/{guid?}',
			'resource' => 'content_lifecycle/edit',
		],
		*/
	],
	
	
	'hooks' => [
		// Actions de suppression d'un compte par admin
		'action' => [
			'admin/user/delete' => [
				'content_lifecycle_delete_user_action' => [],
			],
			'admin/user/bulk/delete' => [
				'content_lifecycle_delete_user_bulk_action' => [],
			],
		],
	],
	
	
	'events' => [
		// Event avant la suppression d'un compte
		'delete' => [
			'user' => [
				'content_lifecycle_delete_user_event' => ['priority' => 1000],
			],
		],
	],
	
	
	// Widgets
	'widgets' => [],
	
];

