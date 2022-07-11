<?php
use Facyla\RssSimplepie\Bootstrap;
//use Elgg\Router\Middleware\AdminGatekeeper;

// Required libs & custom functions
require_once(__DIR__ . '/lib/rss_simplepie/functions.php');


return [
	// Bootstrap must implement \Elgg\PluginBootstrapInterface
	'bootstrap' => Bootstrap::class,


	// Actions
	'actions' => [
		//'rss_simplepie/edit' => [],
	],


	// Routes
	'routes' => [
/*
		'default:rss_simplepie' => [
			'path' => '/feed-reader',
			'resource' => 'rss_simplepie/index',
			'middleware' => [
				AdminGatekeeper::class,
			],
		],
*/
	],


	'hooks' => [
	],


	'events' => [],


	// Widgets
	'widgets' => [
		'rss_feed_reader' => [
			'context' => ['profile', 'dashboard'],
			'multiple' => true,
			'name' => elgg_echo('rss_simplepie:widget:title'),
			'description' => elgg_echo('rss_simplepie:widget:description'),
		],
	],

];

