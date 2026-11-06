<?php

namespace Facyla\OpenidConnect;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::boot()
	 */
	public function boot() {

	}

	/**
	 * {@inheritDoc}
	 * @see \Elgg\DefaultPluginBootstrap::init()
	 */
	public function init() {
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'openid_connect/main.css', 900);
		elgg_extend_view('admin.css', 'openid_connect/admin.css', 900);
		elgg_extend_view('walled_garden.css', 'openid_connect/walled_garden.css', 900);

		// Form de connexion
		elgg_extend_view('forms/login', 'openid_connect/login_sso', 300);
		//elgg_extend_view('core/account/login_box', 'openid_connect/login_sso', 900);

		// Menu supérieur
		if (!elgg_in_context('login')) {
			elgg_extend_view('core/account/login_dropdown', 'openid_connect/login_sso_dropdown', 900);
			elgg_extend_view('resources/account/login', 'openid_connect/login_sso_dropdown', 300);
		}
	}

	public function activate() {

	}


}