<?php
use Facyla\TarteAuCitron\Bootstrap;

// Required libs & custom functions
//require_once(__DIR__ . '/vendor/autoload.php');
//require_once(__DIR__ . '/lib/tarteaucitron/functions.php');

$vendors_path = 'mod/tarteaucitron/vendor/AmauriC/tarteaucitron/';

return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,
	
	
	// Actions
	'actions' => [
		'pages/edit' => [],
	],
	
	
	// Routes
	'routes' => [
		/*
		'contributions:index' => [
			'path' => '/contributions/{container_guid?}',
			'resource' => 'contributions',
		],
		*/
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
		'default' => [
			// Dossier complet : utile pour charger toutes les dépendances
			'tarteaucitron/' => [$vendors_path],
			/*
			
			// Fichier par fichier ('name' => 'path/file') ou l'ensemble du dossier ('/' => 'path/')
			'tarteaucitron.js' => $vendors_path . 'tarteaucitron.js',
			'tarteaucitron.css' => $vendors_path . 'css/tarteaucitron.css',
			//'lang/' => $vendors_path . 'lang/',
			*/
		],
	],
	
	'events' => [
	],
	
	
];

