<?php

use Facyla\SocialShare\Bootstrap;

//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/socialshare/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	
	/*
	'routes' => [
		'default:content_facets' => [
			'path' => '/content_facets',
			'resource' => 'content_facets/index',
		],
	],
	*/
	
	'hooks' => [
		'register' => [
			'menu:entity' => [
				'socialshare_entity_menu_setup' => ['priority' => 600],
			],
		],
	],
	
	'events' => [
		'pagesetup' => [
			'system' => [
				'socialshare_pagesetup' => [],
			],
		],
	],
	
];
