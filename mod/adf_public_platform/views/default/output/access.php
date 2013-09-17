<?php
/**
 * Displays HTML for entity access levels.
 * Requires an entity because some special logic for containers is used.
 *
 * @uses int $vars['entity'] - The entity whose access ID to display.
 */

//sort out the access level for display
if (isset($vars['entity']) && elgg_instanceof($vars['entity'])) {
	$access_id = $vars['entity']->access_id;
	$access_class = 'elgg-access';
	$access_id_string = get_readable_access_level($access_id);
	$access_id_string = htmlspecialchars($access_id_string, ENT_QUOTES, 'UTF-8', false);

	// if within a group or shared access collection display group name and open/closed membership status
	// @todo have a better way to do this instead of checking against subtype / class.
	$container = $vars['entity']->getContainerEntity();

	if ($container && $container instanceof ElggGroup) {
		// we decided to show that the item is in a group, rather than its actual access level
		// not required. Group ACLs are prepended with "Group: " when written.
		//$access_id_string = elgg_echo('groups:group') . $container->name;
		$membership = $container->membership;

		if ($membership == ACCESS_PUBLIC) {
			$access_class .= ' elgg-access-group-open';
		} else {
			$access_class .= ' elgg-access-group-closed';
		}

		// @todo this is plugin specific code in core. Should be removed.
	} elseif ($container && $container->getSubtype() == 'shared_access') {
		$access_class .= ' shared_collection';
	} elseif ($access_id == ACCESS_PRIVATE) {
		$access_class .= ' elgg-access-private';
	}
	
	
	// Plus d'infos sur les niveaux d'accès
	switch($access_id) {
		case -1 :
			$help_details = elgg_echo('adf_platform:access:default:help');
			$access_class .= ' elgg-access-default';
			break;
		case 0 :
			$help_details = elgg_echo('adf_platform:access:private:help');
			$access_class .= ' elgg-access-private';
			break;
		case 1 :
			$help_details = elgg_echo('adf_platform:access:members:help');
			$access_class .= ' elgg-access-members';
			break;
		case 2 :
			$help_details = elgg_echo('adf_platform:access:public:help');
			$access_class .= ' elgg-access-public';
			break;
		case -2 :
			$help_details = elgg_echo('adf_platform:access:friends:help');
			$access_class .= ' elgg-access-friends';
			break;
		default :
			$acl = get_access_collection($access_id);
			if ($collection_owner = get_entity($acl->owner_guid)) {
				if (elgg_instanceof($collection_owner, 'group')) {
					$help_details = elgg_echo('adf_platform:access:group:help');
					$access_class .= ' elgg-access-group';
				} else if (elgg_instanceof($collection_owner, 'user')) {
					$help_details = elgg_echo('adf_platform:access:collection:help');
					$access_class .= ' elgg-access-collection';
				} else {
					$help_details = elgg_echo('adf_platform:access:other:help');
					$access_class .= ' elgg-access-other';
					error_log("Access output/access : type acces non defini."); // Note : dans ce cas il faut pouvoir ajouter la prise en charge...
				}
			} else {
				$help_details = elgg_echo('adf_platform:access:other:help');
				$access_class .= ' elgg-access-other';
				error_log("Access output/access : type acces non defini. Aucun owner ACL."); // Note : dans ce cas il faut pouvoir ajouter la prise en charge...
			}
	}
	

	$help_text = elgg_echo('access:help') . " : " . $help_details;

	echo "<span title=\"$help_text\" class=\"$access_class\">$access_id_string</span>";
}
