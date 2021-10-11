<?php
use Facyla\GdprConsent\Bootstrap;
use Elgg\Router\Middleware\AdminGatekeeper;

// Required libs & custom functions
//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/gdpr_consent/functions.php');

return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Actions
	'actions' => [
		'gdpr_consent/consent' => [],
	],
	
	
	// Routes
	'routes' => [
		'gdpr_consent:index' => [
			'path' => '/gdpr_consent',
			'resource' => 'gdpr_consent/index',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
	],
	
	
	'hooks' => [
		/*
		'head' => [
			'page' => [
				'tarteaucitron_head_page_hook' => [],
			],
		],
		// Public pages - permet d'intégrer les icônes dans les digest
		'public_pages' => [
			'walled_garden' => [
				'tarteaucitron_public_pages' => [],
			],
		],
		*/
	],
	
	// VIEWS
	'views' => [
		/*
		'default' => [
			// Dossier complet : utile pour charger toutes les dépendances
			'/' => [$vendors_path],
			
			// Fichier par fichier ('name' => 'path/file') ou l'ensemble du dossier ('/' => 'path/')
			//'tarteaucitron.js' => $vendors_path . 'tarteaucitron.js',
			//'tarteaucitron.css' => $vendors_path . 'css/tarteaucitron.css',
			//'lang/' => $vendors_path . 'lang/',
		],
		*/
	],
	
	'events' => [
	],
	
	
];

