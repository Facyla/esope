<?php
/**
 * ProfileTypes helper — centralizes profile type queries
 * PSR-4: Facyla\AccessCollections\ProfileTypes
 *
 * Always defined here (no fallback to esope plugin needed for Elgg 7).
 */

namespace Facyla\AccessCollections;

class ProfileTypes {

	/**
	 * Returns all profile types as array of $profiletype_guid => $profiletype_name
	 *
	 * @param bool $use_translation If true, return translated display name
	 * @param bool $use_meta_key    If true (with translation), use metadata_name as key
	 * @return array
	 */
	public static function getProfileTypes(bool $use_translation = false, bool $use_meta_key = false): array {
		$profile_types = [];

		// Define constant if not already done (profile_manager might skip it in Elgg 7)
		if (!defined('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE')) {
			define('CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE', 'custom_profile_type');
		}

		$options = [
			'type' => 'object',
			'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			'owner_guid' => elgg_get_site_entity()->guid,
			'limit' => false,
		];

		$custom_profile_types = elgg_get_entities($options);
		if (!$custom_profile_types) {
			return $profile_types;
		}

		foreach ($custom_profile_types as $type) {
			$profile_type = strtolower((string) $type->metadata_name);

			if ($use_translation) {
				$profile_type_name = $type->metadata_label ?: elgg_echo('profile:types:' . $profile_type);
				if ($use_meta_key) {
					$profile_types[$profile_type] = $profile_type_name;
				} else {
					$profile_types[$type->guid] = $profile_type_name;
				}
			} else {
				$profile_types[$type->guid] = $profile_type;
			}
		}

		return $profile_types;
	}

	/**
	 * Returns guid for a specific profile type name (false if not found)
	 *
	 * @param string $profiletype_name The metadata_name to look up
	 * @return int|false
	 */
	public static function getProfileTypeGuid(string $profiletype_name): int|false {
		$profile_types = self::getProfileTypes();
		foreach ($profile_types as $guid => $name) {
			if ($name === $profiletype_name) {
				return (int) $guid;
			}
		}
		return false;
	}
}
