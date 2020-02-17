<?php

use Facyla\ContentFacets\Bootstrap;

require_once(__DIR__ . '/vendor/autoload.php');

return [
	'bootstrap' => Bootstrap::class,
	
	'routes' => [
		'default:content_facets' => [
			'path' => '/content_facets',
			'resource' => 'content_facets/index',
		],
	],
	
	
];
