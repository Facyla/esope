<?php
/**
* Elgg output content as embed block
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

/* Le principe est de donner accès à un contenu de manière à pouvoir l'embarquer sous forme d'iframe
 * Si le contenu est public, on doit pouvoir a minima bypasser le walledgarden
 * Si le contenu est privé, on devrait pouvoir y accéder 
	- en l'absence de mot de passe ou de clef (ou si vide) => via une invite de connexion (lien)
	- @TODO : ou formulaire de connexion avec login et mot de passe selon les cas
	- @TODO : via un clef d'accès exlusive (clef générée à partir du guid, de la clef privée du site, et autre à voir - éléments stables en tous cas)
	- @TODO : via mot de passe
*/

global $CONFIG;

$embedurl = get_input('embedurl', false);
if (empty($embedurl)) {
	$site_url = get_input('site_url', false);
	$embedtype = get_input('embedtype', false);
}
$group_guid = get_input('group_guid', false);
$user_guid = get_input('user_guid', false);
$username = get_input('username', false);
$limit = get_input('limit', 5); if ($limit > 100) $limit = 100;
$offset = get_input('offset', 0);
$guid = get_input('guid', false);
$types = get_input('types', false);
$subtypes = get_input('subtypes', false);
$full_view = get_input('full_view', false);
// Non utilisés pour le moment
$params = get_input('params', false);
$key = get_input('key', false);
$code = get_input('code', false);

$body = '';
$style = '';

// echo "Paramètres $embedtype $group_guid $limit";

switch ($embedtype) {
	
	// fil d'activité global
	case 'site_activity':
		$title = elgg_echo('export_embed:site_activity', array($CONFIG->site->name));
		$options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
		$body = elgg_list_river($options);
		if (!$body) { $body = elgg_echo('river:none'); }
		$body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">' . elgg_echo('export_embed:site_activity:viewall') . '</a></span>';
		break;
	
	// fil d'activité de ses contacts
	case 'friends_activity':
		$title = elgg_echo('export_embed:friends_activity');
		$options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
		$options['relationship_guid'] = elgg_get_logged_in_user_guid();
		$options['relationship'] = 'friend';
		$body = elgg_list_river($options);
		if (!$body) { $body = elgg_echo('river:none'); }
		$body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">' . elgg_echo('export_embed:friends_activity:viewall') . '</a></span>';
		break;
	
	// fil d'activité personnel
	case 'my_activity':
		$title = elgg_echo('export_embed:friends_activity', array(elgg_get_logged_in_user_entity()->name));
		$options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
		$options['subject_guid'] = elgg_get_logged_in_user_guid();
		$body = elgg_list_river($options);
		if (!$body) { $body = elgg_echo('river:none'); }
		$body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">' . elgg_echo('export_embed:my_activity:viewall') . '</a></span>';
		break;
	
	// Activité d'un groupe
	case 'group_activity':
		// Ignore access only to get the group !
		$ignore_access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);
		$group = get_entity($group_guid);
		// Restore initial access before getting the content
		elgg_set_ignore_access($ignore_access);
		// Test group activity
		if ($group_guid && elgg_instanceof($group, 'group')) {
			$title = elgg_echo('export_embed:group_activity', array($group->name, $CONFIG->site->name));
			$body .= "<div class=\"embed embed-group-activity\"><h4>" . '<a href="' . $group->getURL() . '">' . elgg_echo('export_embed:group_activity:viewall', array($group->name)) . "</a></h4></div>";
			$db_prefix = elgg_get_config('dbprefix');
			$activity = '';
			$activities_count = elgg_get_river(array(
				'count' => true,
				'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array("(e1.container_guid = $group_guid)"),
			));
			//$activity .= "Activités : $activities_count<br />";
			$activities = elgg_get_river(array(
				'limit' => $activities_count,
				'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array("(e1.container_guid = $group_guid)"),
			));
			//error_log('EXT EMBED');
			foreach ($activities as $item) {
				if (elgg_instanceof($item)) {
					$id = "elgg-{$item->getType()}-{$item->getGUID()}";
				} else {
					$id = "item-{$item->getType()}-{$item->id}";
				}
				$activity .= '<div id="'.$id.'">' . elgg_view_list_item($item, $vars) . '</div>';
			}
			if (empty($activity)) { $activity = '<p>' . elgg_echo('dashboard:widget:group:noactivity') . '</p>'; }
			$body .= '<div class="embed-group-content">' . $activity . '</div>';
		} else { $body = '<p>' . elgg_echo('export_embed:group_activity:noaccess') . '</p>'; }
		break;
	
	// liste des groupes (icône + titre)
	case 'groups_list':
		$title = elgg_echo('export_embed:group_activity', array($CONFIG->site->name));
		$body = elgg_list_entities(array('types' => 'group', 'limit' => $limit, 'offset' => $offset, 'full_view' => $full_view, 'reverse_order_by' => false));
		break;
	
	// liste des groupes en Une (icône + titre)
	case 'groups_featured':
		$title = elgg_echo('export_embed:group_activity', array($CONFIG->site->name));
		$body = elgg_list_entities_from_metadata(array('metadata_name' => 'featured_group', 'metadata_value' => 'yes', 'type' => 'group', 'limit' => $limit, 'offset' => $offset, 'full_view' => $full_view));
		break;
	
	// liste des groupes en Une (icône + titre)
	case 'profile_card':
		$user = get_user_by_username($username);
		if (elgg_instanceof($user, 'user')) {
			elgg_set_page_owner_guid($user->guid);
			$title = $user->name;
			$body = elgg_view('esope/profile/profile_card', array('user' => $user));
		}
		break;
	
	// agenda du site
	case 'agenda':
		$title = elgg_echo('export_embed:agenda', array($CONFIG->site->name));
		// Load event calendar model
		elgg_load_library('elgg:event_calendar');
		// Get the events
		if (elgg_is_logged_in()) {
			$events = event_calendar_get_personal_events_for_user(elgg_get_page_owner_guid(),$limit);
		} else {
			$start_date = date('Y-m-d');
			$start_ts = strtotime($start_date);
			$end_ts = $start_ts + 50000000;
			$events = event_calendar_get_events_between($start_ts,$end_ts,false,$limit,0);
		}
		// If there are any events to view, view them
		if (is_array($events) && sizeof($events) > 0) {
			$body .= '<div id="widget_calendar">';
			foreach($events as $event) {
				$body .= elgg_view("object/event_calendar", array('entity' => $event));
			}
			$body .= '</div>';
		}
		break;
	
	// listings configurables
	case 'list':
		$body = elgg_list_entities(array('types' => $types, 'subtypes' => $subtypes, 'limit' => $limit, 'offset' => $offset, 'full_view' => $full_view));
		/*
		if (elgg_instanceof($entity, 'object')) {
			$body = elgg_view_entity($entity, array('full_view' => $full_view));
		} else { $body = '<p>Pas d\'accès ou GUID incorrect</p>'; }
		*/
		break;
	
	// liste des groupes publics (icône + titre)
	case 'entity':
		if ($entity = get_entity($guid)) {
			$title = $entity->title;
			if (empty($title)) $title = $entity->name;
			$title = elgg_echo('export_embed:entity', array($title));
			$body = elgg_view_entity($entity, array('full_view' => $full_view));
		} else { $body = '<p>' . elgg_echo('export_embed:entity:noaccess') . '</p>'; }
		break;
	
	// liste des groupes publics (icône + titre)
	case 'entities':
		$body = '';
		$guids = explode(',', $guid);
		$body = elgg_list_entities(array('guids' => $guids, 'limit' => $limit, 'offset' => $offset, 'full_view' => $full_view));
		if (empty($body)) { $body = '<p>' . elgg_echo('export_embed:entities:noaccess'). '</p>'; }
		break;
	
	// Defaults to help
	default:
		$body .= '<p>' . elgg_echo('export_embed:notconfigured') . '</p>';
		/*
				<ul>
					<li>Adresse du site&nbsp;: <strong>" . $CONFIG->url . "</strong></li>
					<li>Types de widgets&nbsp;:
						<ul>
						</ul>
					</li>
					>> <strong>" . $CONFIG->url . "export_embed/site_activity</strong> pour l'activité générale du site</li>
					<li><strong>friends_activity</strong> pour l'activité de vos contacts</li>
					<li><strong>my_activity</strong> pour votre activité</li>
					<li><strong>group_activity&group_guid=<em>XXXXX</em></strong> pour l'activité d'un groupe en particulier : remplacer <strong><em>XXXXX</em></strong> par le numéro du groupe à afficher, que vous trouverez dans l'adresse de la page d'accueil du groupe : <em>groups/profile/<strong>XXXXX</strong>/nom-du-groupe</em></li>
					<li><strong>groups_list</strong> pour la liste des groupes du site</li>
					<li><strong>agenda</strong> pour l'agenda du site</li>
				</ul>

		*/
}


// Message si vide
if (empty($body)) {
	$body = elgg_echo('export_embed:nocontent');
}

// Alerte si non connecté
if (!elgg_is_logged_in()) {
	$body = '<div style="background:#FAA; border:1px dashed #A00; padding:3px 6px; margin:3px;">' . elgg_echo('export_embed:notconnected', array($CONFIG->site->name, $CONFIG->url)) . '</div>' . $body;
} else {
	$body = '<div style="background:#AFA; border:1px dashed #0A0; padding:3px 6px; margin:3px;"><a href="' . $CONFIG->url . '" target="_blank">' . elgg_echo('export_embed:openintab', array($CONFIG->sitename)) . '</a>.</div>' . $body;
}


// Remove framekiller view (would break out of widgets)
elgg_unextend_view('page/elements/head', 'security/framekiller');


// Display page
// Send page headers : tell at least it's UTF-8
$vars['title'] = $title;
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title><?php echo $title; ?></title>
	<?php echo elgg_view('page/elements/head', $vars); ?>
	<style>
	html, body { background:#FFFFFF !important; }
	</style>
</head>
<body>
	<div style="padding:0 4px;">
		<?php echo $body; ?>
	</div>
</body>
</html>
<?php exit(); ?>
