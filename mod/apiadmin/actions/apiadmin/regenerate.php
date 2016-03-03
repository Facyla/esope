<?php
/**
 * Elgg API Admin
 * Implementation of the Regenerate Keys option on an API Key object
 * 
 * @package ElggAPIAdmin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * 
 * @author Moodsdesign Ltd
 * @copyright Moodsdesign Ltd 2012
 * @link http://www.elgg.org
*/

admin_gatekeeper();

$key = (int)get_input('keyid');

$obj = get_entity($key);

if ($obj && elgg_instanceof($obj, 'object') && ($obj->subtype == get_subtype_id('object', 'api_key'))) {
	$site = elgg_get_site_entity();
	if (remove_api_user($site->guid, $obj->public)) {
		$keypair = create_api_user($site->guid);
		if ($keypair) {
			$obj->public = $keypair->api_key;
		} else {
			register_error(elgg_echo('apiadmin:regenerationfail'));
		}
		if (!$obj->save()) {
			register_error(elgg_echo('apiadmin:regenerationfail'));
		} else {
			system_message(elgg_echo('apiadmin:regenerated'));
		}
	} else {
		register_error(elgg_echo('apiadmin:regenerationfail'));
	}
}

forward(REFERER);
