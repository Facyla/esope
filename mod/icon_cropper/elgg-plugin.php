<?php

use ColdTrick\IconCropper\Bootstrap;

$composer_path = '';
if (is_dir(__DIR__ . '/vendor')) {
	$composer_path = __DIR__ . '/';
}

return [
	'bootstrap' => Bootstrap::class,
	'views' => [
		'default' => [
			'cropperjs/' => $composer_path . 'vendor/npm-asset/cropperjs/dist/',
			'jquery-cropper/' => $composer_path . 'vendor/npm-asset/jquery-cropper/dist/',
		],
	],
];
