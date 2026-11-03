<?php

return [
	'plugin' => [
		'version' => '7.2',
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'entity_attachment',
			'class' => \EntityAttachment::class,
		],
	],
	'actions' => [
		'entity_attachments/add' => [],
		'entity_attachments/sort' => [],
	],
	'events' => [
		'seeds' => [
			'database' => [
				'ColdTrick\EntityAttachments\Seeder::register' => ['priority' => 600],
			],
		],
		'view_vars' => [
			'object/elements/full' => [
				'ColdTrick\EntityAttachments\Views::addAttachments' => [],
			],
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'entity_attachments/list.css' => [],
		],
	],
	'view_options' => [
		'forms/entity_attachments/add' => ['ajax' => true],
	],
];
