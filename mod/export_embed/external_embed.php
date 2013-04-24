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
 * Si le contenu est public, on doit puvoir a minima bypasser le wlledgarden
 * Si le contenu est privé, on devrait pouvoir y accéder 
  - via un clef d'accès exlusive (clef générée à partir du guid, de la clef privée du site, et autre à voir - éléments stables en tous cas)
  - via mot de passe
  - en l'absence de mot de passe ou de clef (ou si vide) => vide ou invite de connexion ou invite à saisir le mot de passe selon les cas
*/

global $CONFIG;

$embedurl = get_input('embedurl', false);
if (empty($embedurl)) {
  $site_url = get_input('site_url', false);
  $embedtype = get_input('embedtype', false);
}
$group_guid = get_input('group_guid', false);
$user_guid = get_input('user_guid', false);
$limit = get_input('limit', 5); if ($limit > 100) $limit = 100;
$offset = get_input('offset', 0);
$params = get_input('params', 0);
$key = get_input('key', false);

$body = '';
$style = '';

// echo "Paramètres $embedtype $group_guid $limit";

switch ($embedtype) {
  
  // fil d'activité global
  case 'site_activity':
    $title = "Activité de " . $CONFIG->site->name;
    $options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
    $body = elgg_list_river($options);
    if (!$body) { $body = elgg_echo('river:none'); }
    $body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">Voir toute l\'activité du site</a></span>';
    break;
  
  // fil d'activité de ses contacts
  case 'friends_activity':
    $title = "Activité de mes contacts";
    $options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
		$options['relationship_guid'] = elgg_get_logged_in_user_guid();
		$options['relationship'] = 'friend';
    $body = elgg_list_river($options);
    if (!$body) { $body = elgg_echo('river:none'); }
    $body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">Voir toute l\'activité du site</a></span>';
    break;
  
  // fil d'activité personnel
  case 'my_activity':
    $title = "Activité de " . elgg_get_logged_in_user_entity()->name;
    $options = array('limit' => $limit, 'offset' => $offset, 'pagination' => true);
    $options['subject_guid'] = elgg_get_logged_in_user_guid();
    $body = elgg_list_river($options);
    if (!$body) { $body = elgg_echo('river:none'); }
    $body .= '<span class="elgg-widget-more"><a href="' . $CONFIG->url . 'activity">Voir toute l\'activité du site</a></span>';
    break;
  
  // Activité d'un groupe
  case 'group_activity':
    $ignore_access = elgg_get_ignore_access();
    elgg_set_ignore_access(true);
    $group = get_entity($group_guid);
    elgg_set_ignore_access($ignore_access);
    // Test group activity
    if ($group_guid && elgg_instanceof($group, 'group')) {
      $title = "Activité récente du groupe " . $group->name . " de " . $CONFIG->site->name;
      $body .= "<div class=\"embed embed-group-activity\"><h4>" . '<a href="' . $group->getURL() . '">' . $group->name . "</a></h4></div>";
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
error_log('EXT EMBED');
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
    } else { $body = '<p>Pas d\'accès au groupe ou GUID du groupe incorrect</p>'; }
    break;
  
  // liste des groupes publics (icône + titre)
  case 'groups_list':
    $title = "Liste des groupes de " . $CONFIG->site->name;
    $groups = elgg_get_entities(array('types' => 'group', 'limit' => 9999, 'reverse_order_by' => false));
    $body = elgg_view_entity_list($groups, '', 0, 99, false, false, false);
    break;
  
  // agenda du site
  case 'agenda':
    $title = "Agenda de " . $CONFIG->site->name;
    // Load event calendar model
    elgg_load_library('elgg:event_calendar');
    $num = 5;
    // Get the events
    if (elgg_is_logged_in()) {
    $events = event_calendar_get_personal_events_for_user(elgg_get_page_owner_guid(),$num);
    } else {
      $start_date = date('Y-m-d');
      $start_ts = strtotime($start_date);
      $end_ts = $start_ts + 50000000;
  	  $events = event_calendar_get_events_between($start_ts,$end_ts,false,$num,0);
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
  
  
  // Defaults to help
  default:
    $body .= "<p>Ce widget n'est pas encore configuré (ou les paramètres fournis sont invalides).</p>
      <p>
        Pour afficher les widgets de ce site sur un autre site, veuillez utiliser les informations suivantes&nbsp;:
        <ul>
          <li>Adresse du site&nbsp;: <strong>" . $CONFIG->url . "</strong></li>
          <li>Types de widgets&nbsp;:
            <ul>
            </ul>
          </li>
          >> <strong>" . $CONFIG->url . "embed/site_activity</strong> pour l'activité générale du site</li>
          <li><strong>friends_activity</strong> pour l'activité de vos contacts</li>
          <li><strong>my_activity</strong> pour votre activité</li>
          <li><strong>group_activity&group_guid=<em>XXXXX</em></strong> pour l'activité d'un groupe en particulier : remplacer <strong><em>XXXXX</em></strong> par le numéro du groupe à afficher, que vous trouverez dans l'adresse de la page d'accueil du groupe : <em>groups/profile/<strong>XXXXX</strong>/nom-du-groupe</em></li>
          <li><strong>groups_list</strong> pour la liste des groupes du site</li>
          <li><strong>agenda</strong> pour l'agenda du site</li>
        </ul>
      </p>";
}


// Message si vide
if (empty($body)) {
  $body = '<p>Pas de contenu pour le moment.</p>';
}

// Alerte si non connecté
if (!elgg_is_logged_in()) {
  $body = "<div style=\"background:#FAA; border:1px dashed #A00; padding:3px 6px; margin:3px;\">ATTENTION, vous n'êtes pas connecté sur " . $CONFIG->site->name . ". Veuillez <a href=\"" . $CONFIG->url . "\" target=\"_top\">vous connecter</a> pour accéder au contenu réservé aux membres.</div>" . $body;
} else {
  $body = '<div style="background:#AFA; border:1px dashed #0A0; padding:3px 6px; margin:3px;"><a href="' . $CONFIG->url . '" target="_top">Accéder à ' . $CONFIG->sitename . ' dans une nouvelle fenêtre</a>.</div>' . $body;
}



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
