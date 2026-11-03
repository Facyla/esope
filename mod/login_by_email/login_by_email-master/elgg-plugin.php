<?php

use ColdTrick\LoginByEmail\Bootstrap;
use ColdTrick\LoginByEmail\Controllers\Confirm;
use ColdTrick\LoginByEmail\Controllers\RequestLinkAction;
use ColdTrick\LoginByEmail\Notifications\RequestLoginCodeHandler;
use ColdTrick\LoginByEmail\PluginSettings;
use Elgg\Router\Middleware\LoggedOutGatekeeper;
use Elgg\Router\Middleware\SignedRequestGatekeeper;

return [
	'plugin' => [
		'version' => '3.1',
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'code_validity' => 5,
		'disable_classic_login' => 1,
	],
	'actions' => [
		'login_by_email/code' => ['access' => 'logged_out'],
		'login_by_email/request_link' => [
			'access' => 'logged_out',
			'controller' => RequestLinkAction::class,
		],
	],
	'routes' => [
		'default:login_by_email:code' => [
			'path' => 'login_by_email/code',
			'resource' => 'login_by_email/code',
			'middleware' => [
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
		'default:login_by_email:confirm' => [
			'path' => 'login_by_email/confirm/{guid}',
			'controller' => Confirm::class,
			'middleware' => [
				SignedRequestGatekeeper::class,
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
		'default:login_by_email:request_link' => [
			'path' => 'login_by_email/request_link',
			'resource' => 'login_by_email/request_link',
			'middleware' => [
				LoggedOutGatekeeper::class,
			],
			'walled' => false,
		],
	],
	'events' => [
		'register' => [
			'menu:login' => [
				'\ColdTrick\LoginByEmail\Menus\Login::removePasswordReset' => [],
				'\ColdTrick\LoginByEmail\Menus\Login::register' => [],
			],
		],
		'setting' => [
			'plugin' => [
				PluginSettings::class => [],
			],
		],
		'view_vars' => [
			'forms/login' => [
				'\ColdTrick\LoginByEmail\Views::preventClassicLoginForm' => [],
			],
		],
	],
	'notifications' => [
		'user' => [
			'user' => [
				'request_login_code' => [
					RequestLoginCodeHandler::class => [],
				],
			],
		],
	],
];
