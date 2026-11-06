<?php

use Facyla\OpenidConnect\Bootstrap;

require_once(__DIR__ . '/lib/openid_connect/functions.php');

return [
	'plugin' => [
		'name' => 'openid_connect',
		'activate_on_install' => false,
	],
	'bootstrap' => Bootstrap::class,

	'actions' => [],
	'routes' => [
		'default:openid_connect' => [
			'path' => '/openid_connect',
			'resource' => 'openid_connect/index',
		],
		'default:openid_connect:login' => [
			'path' => '/openid_connect/login',
			'resource' => 'openid_connect/login',
		],
		'default:openid_connect:logout' => [
			'path' => '/openid_connect/logout',
			'resource' => 'openid_connect/logout',
		],
	],
	'hooks' => [],
];