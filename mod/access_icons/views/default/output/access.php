<?php
/**
 * Displays HTML for entity access levels.
 * Requires an entity because some special logic for containers is used.
 *
 * @uses int $vars['entity'] - The entity whose access ID to display.
 */

// Displaying access levels when we're logged out is a nonsense : it's always public...
// Note : we need to block it here because access is added in core : /engine/lib/navigation.php
if (!elgg_is_logged_in()) { return; }

//sort out the access level for display
if (isset($vars['entity']) && elgg_instanceof($vars['entity'])) {
	$access_id = $vars['entity']->access_id;
	$access_class = 'elgg-access';
	if (!$vars['hide_text']) {
		$access_id_string = get_readable_access_level($access_id);
		$access_id_string = '<span class="access-icon-placeholder"></span>' . htmlspecialchars($access_id_string, ENT_QUOTES, 'UTF-8', false);
	} else $access_id_string = '&nbsp;';

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
		
	} elseif ($container && $container->getSubtype() == 'shared_access') {
		$access_class .= ' shared_collection';
	} elseif ($access_id == ACCESS_PRIVATE) {
		$access_class .= ' elgg-access-private';
	}
	
	
	// Plus d'infos sur les niveaux d'accès
	switch($access_id) {
		case -1 :
			$help_details = elgg_echo('access_icons:default:details');
			$access_class .= ' elgg-access-default';
			break;
		case 0 :
			$help_details = elgg_echo('access_icons:private:details');
			$access_class .= ' elgg-access-private';
			break;
		case 1 :
			$help_details = elgg_echo('access_icons:members:details');
			$access_class .= ' elgg-access-members';
			break;
		case 2 :
			$help_details = elgg_echo('access_icons:public:details');
			$access_class .= ' elgg-access-public';
			break;
		case -2 :
			$help_details = elgg_echo('access_icons:friends:details');
			$access_class .= ' elgg-access-friends';
			break;
		default :
			$acl = get_access_collection($access_id);
			if ($collection_owner = get_entity($acl->owner_guid)) {
				if (elgg_instanceof($collection_owner, 'group')) {
					$help_details = elgg_echo('access_icons:group:details');
					$access_class .= ' elgg-access-group';
				} else if (elgg_instanceof($collection_owner, 'user')) {
					$help_details = elgg_echo('access_icons:collection:details');
					$access_class .= ' elgg-access-collection';
				} else {
					$help_details = elgg_echo('access_icons:other:details');
					$access_class .= ' elgg-access-other';
					error_log("Access output/access : undefined type access"); // Note : dans ce cas il faut pouvoir ajouter la prise en charge...
				}
			} else {
				$help_details = elgg_echo('access_icons:other:details');
				$access_class .= ' elgg-access-other';
				error_log("Access output/access : type acces non defini. Aucun owner ACL."); // Note : dans ce cas il faut pouvoir ajouter la prise en charge...
			}
	}
	
	$help_text = $help_details . elgg_echo('access_icons:details');
	
	// Add an information page - only if that page is configured with a link or a content, otherwise we keep the basic text without link
	$access_content = elgg_get_plugin_setting('helpurl', 'access_icons');
	$access_textcontent = elgg_get_plugin_setting('helptext', 'access_icons');
	if ($access_content) {
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		$access_id_string = elgg_view('output/url', array('text' => $access_id_string, 'href' => $access_content, 'class' => 'elgg-lightbox'));
	/* @TODO : doesn't work as expected yet
	} else if ($access_textcontent) {
		// Pour lightbox avec texte court dedans
		$access_id_string = elgg_view('output/url', array('text' => $access_id_string, 'href' => "#elgg-lightbox-access-details", 'class' => 'elgg-lightbox'));
		// On ne charge l'explication qu'une seule fois..
		global $elgg_lightbox_access_details;
		if (!$elgg_lightbox_access_details) {
			echo '<div class="hidden">' . elgg_view_module('aside', elgg_echo('access_icons:title'), $access_textcontent, array('id' => 'elgg-lightbox-access-details')) . '</div>';
			$elgg_lightbox_access_details = true;
		}
	*/
	}

	echo "<span title=\"$help_text\" class=\"$access_class\">$access_id_string</span>";
}

