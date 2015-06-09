<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @package Elgg
 * @subpackage Core
 *
 */

// Apply privacy rule if owner uses profile opt-out mode
$owner = elgg_get_page_owner_entity();
if (elgg_instanceof($owner, 'user')) {
	esope_user_profile_gatekeeper($owner);
}

