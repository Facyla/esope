<?php

use Facyla\Feedback\Bootstrap;

//require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/lib/feedback/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	
	// ACTIONS
	'actions' => [
		'feedback/submit_feedback' => [
			'access' => 'public',
		],
		'feedback/close' => [
			'access' => 'admin',
		],
		'feedback/reopen' => [
			'access' => 'admin',
		],
		'feedback/delete' => [
			'access' => 'admin',
		],
	],
		
		
	// ENTITIES - registers feedbacks for search
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'feedback',
			'class' => 'ElggFeedback',
			'searchable' => true,
		],
	],
	
	
	// HOOKS
	'hooks' => [
		// Register a URL handler for feedbacks
		'entity:url' => [
			'object' => [
				'feedback_url' => [],
			],
		],
		// menu des groupes
		'register' => [
			'menu:owner_block' => [
				'feedback_owner_block_menu' => [],
			],
		],
			// @TODO : override feedback message to use our own content
			// Note : load late to avoid content being modifed by some other plugin
		'prepare' => [
			'notification:create:object:comment' => [
				'feedback_prepare_comment_notification' => ['priority' => 800],
			],
		],
		// Interception des commentaires
		'get' => [
			'subscriptions' => [
				'feedback_comment_get_subscriptions_hook' => [],
			],
		],
	],
	
	
	// ROUTES
	'routes' => [
		'default:feedback' => [
			'path' => '/feedback',
			'resource' => 'feedback/index',
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
		],
		'feedback:view' => [
			'path' => '/feedback/view/{guid?}/{title?}',
			'resource' => 'feedback/view',
			'middleware' => [
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
			],
		],
		'feedback:group' => [
			'path' => '/feedback/group/{group?}',
			'resource' => 'feedback/index',
			'middleware' => [
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
			],
		],
		'feedback:status' => [
			'path' => '/feedback/status/{status?}',
			'resource' => 'feedback/index',
			'middleware' => [
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
			],
		],
		'feedback:about' => [
			'path' => '/feedback/about/{about?}/{status?}',
			'resource' => 'feedback/index',
			'middleware' => [
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
			],
		],
		'feedback:mood' => [
			'path' => '/feedback/mood/{mood?}/{status?}',
			'resource' => 'feedback/index',
			'middleware' => [
			//'middleware' => [\Elgg\Router\Middleware\Gatekeeper::class,],
			],
		],
	],
	/*
	// page handler
	elgg_register_page_handler('feedback','feedback_page_handler');
	switch($page[0]) {
		case 'view':
			set_input('guid', $page[1]);
			include(dirname(__FILE__) . "/pages/feedback/view.php");
			return true;
			break;
		
		// Following all use default page
		case 'group': set_input('group', $page[1]); break;
		case 'status': set_input('status', $page[1]); break;
		case 'about': set_input('about', $page[1]); set_input('status', $page[2], 'open'); break;
		case 'mood': set_input('mood', $page[1]); break;
	}
	include(dirname(__FILE__) . "/pages/feedback/feedback.php");
	*/
	
	
	// WIDGETS
	'widgets' => [
		// Admin widget
		'feedback' => ['context' => 'admin', 'multiple' => true],
	],
	
];
