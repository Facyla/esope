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
		// Form de connexion
		elgg_extend_view('forms/login', 'openid_connect/login_sso', 300);
		//elgg_extend_view('core/account/login_box', 'openid_connect/login_sso', 900);

		// Menu supérieur
		if (!elgg_in_context('login')) {
			elgg_extend_view('core/account/login_dropdown', 'openid_connect/login_sso_dropdown', 900);
			elgg_extend_view('resources/account/login', 'openid_connect/login_sso_dropdown', 300);
		}

		// Enregistrer le handler pour le logout OIDC
		// Format string uniquement (gotcha Elgg 7 #1)
		elgg_register_event_handler('logout:after', 'user', 'openid_connect_on_logout_after');
	}

	public function activate() {

	}


}