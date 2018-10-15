<?php

return [
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'file',
			'searchable' => true,
		],
	],
	'actions' => [
		'file/upload' => [],
	],
	'routes' => [
		'default:object:file' => [
			'path' => '/file',
			'resource' => 'file/all',
		],
		'collection:object:file:all' => [
			'path' => '/file/all',
			'resource' => 'file/all',
		],
		'collection:object:file:owner' => [
			'path' => '/file/owner/{username}',
			'resource' => 'file/owner',
		],
		'collection:object:file:friends' => [
			'path' => '/file/friends/{username}',
			'resource' => 'file/friends',
		],
		'collection:object:file:group' => [
			'path' => '/file/group/{guid}',
			'resource' => 'file/owner',
		],
		'add:object:file' => [
			'path' => '/file/add/{guid}',
			'resource' => 'file/upload',
		],
		'edit:object:file' => [
			'path' => '/file/edit/{guid}',
			'resource' => 'file/edit',
		],
		'view:object:file' => [
			'path' => '/file/view/{guid}/{title?}',
			'resource' => 'file/view',
		],
	],
	'widgets' => [
		'filerepo' => [
			'name' => elgg_echo('collection:object:file'),
			'description' => elgg_echo('file:widget:description'),
			'context' => ['profile', 'dashboard'],
		],
	],
];
