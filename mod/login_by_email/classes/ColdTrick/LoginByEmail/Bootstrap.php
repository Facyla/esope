<?php

namespace ColdTrick\LoginByEmail;

use ColdTrick\LoginByEmail\Middleware\PreventClassicLogin;
use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap
 */
class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function boot() {
		$this->elgg()->events->registerHandler('route:config', 'account:password:change', [$this, 'registerMiddleware']);
		$this->elgg()->events->registerHandler('route:config', 'account:password:reset', [$this, 'registerMiddleware']);
		$this->elgg()->events->registerHandler('route:config', 'action:login', [$this, 'registerMiddleware']);
		$this->elgg()->events->registerHandler('route:config', 'action:user/changepassword', [$this, 'registerMiddleware']);
		$this->elgg()->events->registerHandler('route:config', 'action:user/requestnewpassword', [$this, 'registerMiddleware']);
	}
	
	/**
	 * Add middleware to certain routes/actions to disable classic login
	 *
	 * @param \Elgg\Event $event 'route:config', '<route name>'
	 *
	 * @return array
	 */
	public function registerMiddleware(\Elgg\Event $event): array {
		$route_params = $event->getValue();
		
		$middleware = (array) elgg_extract('middleware', $route_params, []);
		$middleware[] = PreventClassicLogin::class;
		
		$route_params['middleware'] = $middleware;
		
		return $route_params;
	}
}
