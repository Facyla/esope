<?php

/**
 * Settings view for access_collections plugin (Elgg 7)
 *
 * Displays profile-type ACL status in read-only mode.
 * An admin action (access_collections/update) handles creation/sync/delete
 * to avoid side effects on form render.
 */

use Facyla\AccessCollections\ProfileTypes;

$plugin = elgg_extract('entity', $vars);
/* @var $plugin \ElggPlugin */

$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

echo '<div class="elgg-output">';

if (elgg_is_active_plugin('profile_manager')) {
	echo '<h3>' . elgg_echo('access_collections:collections:profiletypes') . '</h3>';
	echo '<h4>' . elgg_echo('access_collections:profiletypes') . '</h4>';
	echo '<p>' . elgg_echo('access_collections:profiletypes:select') . '</p>';

	$custom_profile_types = ProfileTypes::getProfileTypes();
	if ($custom_profile_types) {
		echo '<ul>';

		foreach ($custom_profile_types as $guid => $name) {
			$setting_value = (string) $plugin->{'profiletype_' . $guid};
			$enabled = ($setting_value === 'yes');

			// CSS class based on state
			$css_class = $enabled ? 'enabled' : 'disabled';
			$collection_name = 'profiletype:' . $name;
			$collection = access_collections_get_collection_by_name($collection_name);

			if (!$enabled && $collection) {
				$css_class = 'existing';
			}

			echo '<li class="' . $css_class . '">';

			// Enable/disable select
			echo '<label>' . $name . ' (' . elgg_echo('access_collections:profiletype_id') . ' ' . $guid . ') ';
			echo elgg_view('input/select', [
				'name' => 'params[profiletype_' . $guid . ']',
				'value' => $setting_value ?: 'no',
				'options_values' => $ny_opt,
			]);
			echo '</label>';

			// Status info
			if ($collection) {
				$cnt = (int) $collection->getMembers(['count' => true]);
				echo ' — ' . elgg_echo('access_collections:acl', [$collection->name, $collection->id]);
				echo ' (' . elgg_echo('access_collections:members_count', [$cnt]) . ')';
			} else {
				echo ' — ' . elgg_echo('access_collections:noacl');
			}

			echo '</li>';
		}
		echo '</ul>';
	}

	// Delete toggle (always reset to 'no' after save by action)
	echo '<p><label>' . elgg_echo('access_collections:delete:enable');
	echo elgg_view('input/select', [
		'name' => 'params[allow_delete]',
		'value' => 'no',
		'options_values' => $ny_opt,
	]);
	echo '</label></p>';
	echo '<p><em>' . elgg_echo('access_collections:delete:enable:details') . '</em></p>';

	echo '<div class="clearfloat"></div><br />';
}

// Admin custom collections (upcoming)
echo '<h3>' . elgg_echo('access_collections:collections:admin') . '</h3>';
echo '<p>' . elgg_echo('access_collections:upcomingfeature') . '</p>';
echo '<div class="clearfloat"></div><br />';

echo '</div>';
