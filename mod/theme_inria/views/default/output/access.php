<?php
/**
 * Displays HTML for entity access levels.
 * Requires an entity because some special logic for containers is used.
 *
 * @uses int $entity - The entity whose access ID to display.
 */

// Displaying access levels when we're logged out is a nonsense : it's always public...
// Note : we need to block it here because access is added in core : /engine/lib/navigation.php
if (!elgg_is_logged_in()) { return; }

//sort out the access level for display
$entity = elgg_extract('entity', $vars, false);

// Default hide text in widgets context, except if forced
//if (elgg_in_context('widgets') || elgg_in_context('listing')) { $hide_text = true; }
if (elgg_in_context('widgets')) { $hide_text = true; }
$hide_text = elgg_extract('hide_text', $vars, $hide_text);
// Iris v2 : force access name display in activity
if (elgg_in_context('activity')) { $hide_text = false; }

$access_class = 'elgg-access';

// Get access id
if (elgg_instanceof($entity)) {
	$access_id = $entity->access_id;

	// if within a group or shared access collection display group name and open/closed membership status
	// @todo have a better way to do this instead of checking against subtype / class.
	$container = $entity->getContainerEntity();
	
	// Special : group membership
	if (elgg_instanceof($container, 'group')) {
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
} else if (isset($vars['value'])) {
	$access_id = $vars['value'];
}

if (!isset($access_id)) { return true; }


// Should we display the access text ?
if (!$hide_text) {
	$access_id_string = access_icons_get_readable_access_level($access_id);
	$access_id_string = elgg_echo($access_id_string);
	$access_id_string = '<span class="access-icon-placeholder"></span>' . htmlspecialchars($access_id_string, ENT_QUOTES, 'UTF-8', false);
} else {
	$access_id_string = '&nbsp;';
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
		$collection_owner = get_entity($acl->owner_guid);
		if (elgg_instanceof($collection_owner, 'group')) {
			$help_details = elgg_echo('access_icons:group:details');
			$access_class .= ' elgg-access-group';
			if (!$hide_text) {
				$access_id_string = '<span class="access-icon-placeholder"></span>' . htmlspecialchars($collection_owner->name, ENT_QUOTES, 'UTF-8', false);
			}
		} else if (elgg_instanceof($collection_owner, 'user')) {
			$help_details = elgg_echo('access_icons:collection:details');
			$access_class .= ' elgg-access-collection';
			if (!$hide_text) {
				$access_id_string = '<span class="access-icon-placeholder"></span>' . htmlspecialchars($collection_owner->name, ENT_QUOTES, 'UTF-8', false);
			}
		} else if (elgg_instanceof($collection_owner, 'site')) {
			$help_details = elgg_echo('access_icons:site:details');
			$access_class .= ' elgg-access-site';
			if (!$hide_text) {
				$access_id_string = '<span class="access-icon-placeholder"></span>' . htmlspecialchars($collection_owner->title, ENT_QUOTES, 'UTF-8', false);
			}
		} else {
			// Container inconnu, typiquement car pas d'accès suffisant
			$help_details = elgg_echo('access_icons:other:details');
			$access_class .= ' elgg-access-other';
			//error_log("Access output/access : undefined type access. Container cannot be accessed to.");
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


