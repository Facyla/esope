<?php

namespace Facyla\AccessCollections;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritDoc}
	 */
	public function boot(): void {
		// Nothing needed at boot
	}

	/**
	 * {@inheritDoc}
	 */
	public function init(): void {
		// Extend CSS with custom styles
		elgg_extend_view('elgg.css', 'access_collections/main.css', 900);
		elgg_extend_view('admin.css', 'access_collections/admin.css', 900);
	}

	/**
	 * {@inheritDoc}
	 *
	 * On plugin activation, ensure existing profile-type ACLs are initialized.
	 * The ACL id=36 (profiletype:linagora) with 93 members MUST be preserved.
	 * This only creates collections for enabled profile types that don't yet exist.
	 * It does NOT resync members — member sync happens via the metadata event handler.
	 */
	public function activate(): void {
		if (!elgg_is_active_plugin('profile_manager')) {
			return;
		}

		$profile_types = ProfileTypes::getProfileTypes();
		foreach ($profile_types as $guid => $name) {
			$enabled = elgg_get_plugin_setting('profiletype_' . $guid, 'access_collections');
			if ($enabled !== 'yes') {
				continue;
			}

			// Only create if the collection doesn't already exist
			$collection_name = 'profiletype:' . $name;
			$existing = access_collections_get_collection_by_name($collection_name);
			if ($existing) {
				continue; // already exists, do NOT touch
			}

			// Create the ACL (without syncing members here — let the admin action do that)
			$site_guid = elgg_get_site_entity()->guid;
			elgg_create_access_collection($collection_name, $site_guid, 'profiletype');
		}
	}
}
