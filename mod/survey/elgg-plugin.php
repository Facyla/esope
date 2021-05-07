<?php
use Facyla\Survey\Bootstrap;

// Required libs & custom functions
//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/survey/functions.php');
require_once(__DIR__ . '/lib/survey/hooks.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Entities: register entity types for search
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'survey',
			'class' => 'ElggSurvey',
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'survey_question',
			'class' => 'ElggSurveyQuestion',
			'searchable' => true,
		],
	],
	
	
	// Actions
	'actions' => [
		'survey/edit' => [],
		'survey/delete' => [],
		'survey/response' => [],
	],
	
	
	// Routes
	'routes' => [
		'default:survey' => [
			'path' => '/survey',
			'resource' => 'survey/index',
		],
		'survey:friends' => [
			'path' => '/survey/friends',
			'resource' => 'survey/friends',
		],
		'survey:owner' => [
			'path' => '/survey/owner/{username?}',
			'resource' => 'survey/owner',
		],
		'survey:group' => [
			'path' => '/survey/group/{guid?}',
			'resource' => 'survey/group',
		],
		
		'survey:view' => [
			'path' => '/survey/view/{guid?}/{title?}',
			'resource' => 'survey/view',
		],
		'survey:add' => [
			'path' => '/survey/add/{container_guid?}',
			'resource' => 'survey/edit',
		],
		'default:edit' => [
			'path' => '/survey/edit/{guid?}/{title?}',
			'resource' => 'survey/edit',
		],
		
		'survey:results' => [
			'path' => '/survey/results/{guid?}/{filter?}/{filter_guid?}',
			'resource' => 'survey/results',
		],
		'survey:export' => [
			'path' => '/survey/export/{guid?}',
			'resource' => 'survey/export',
		],
		
	],
	
	
	'hooks' => [
		// add link to owner block
		'register' => [
			'menu:owner_block' => [
				'survey_owner_block_menu' => [],
			],
			'menu:entity' => [
				'survey_entity_menu' => [],
			],
		],
		// Register a URL handler for survey posts
		'entity:url' => [
			'object' => [
				'survey_url' => [],
			],
		],
		/*
		// Set icons for custom entities
		'entity:icon:url' => [
			'object' => [
				'naturalconnect_set_icon_url' => [],
			],
		],
		*/
	],
	
	
	'events' => [
	],
	
	
	// Widgets
	'widgets' => [
		/*
		// Module générique (affichage de tous types de vues via divers éléments de configuration)
		'naturalconnect_generic' => ['context' => $widgets_context, 'multiple' => true],
		*/
	],
	
];

