<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

$site = elgg_get_site_entity();
$title = $site->name;

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="adf-lostpassword" style="display:none;">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';

// Formulaire d'inscription
if (elgg_get_config('allow_registration')) {
  $register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
}

// Statistiques du site
$stats = '';
$displaystats = elgg_get_plugin_setting('displaystats', 'adf_public_platform');
if ($displaystats == "yes") {
  $stats .= '<div style="background:transparent;">';
  $stats .= '<h2>Quelques chiffres</h2>';
  //$subtypes = get_registered_entity_types();
  //access_show_hidden_entities(true); // Accès aux entités désactivés
  elgg_set_ignore_access(true); // Pas de vérification des droits d'accès
  $stats .= '<strong>' . get_number_users() . '</strong> membres inscrits<br />';
  $stats .= '<strong>' . find_active_users(600, 10, 0, true) . '</strong> membres connectés en ce moment<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'group', 'count' => true)) . '</strong> groupes de travail<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'groupforumtopic', 'count' => true)) . '</strong> sujets de discussion dans les forums<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'announcement', 'count' => true)) . '</strong> annonces dans les groupe<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'idea', 'count' => true)) . '</strong> idées / remue-méninges dans les groupe<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => array('page','page_top'), 'count' => true)) . '</strong> pages wikis : ';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'page_top', 'count' => true)) . '</strong> wikis et ';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'page', 'count' => true)) . '</strong> sous-pages<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'blog', 'count' => true)) . '</strong> articles de blog<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'bookmarks', 'count' => true)) . '</strong> liens partagés<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'file', 'count' => true)) . '</strong> fichiers<br />';
  $stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'event_calendar', 'count' => true)) . '</strong> événements<br />';
  //access_show_hidden_entities(false);
  elgg_set_ignore_access(false);
  
  //echo elgg_view('admin/statistics/numentities');
  /* Autre méthode..
  $stats = get_entity_statistics();
  $stat_types = array('page_top', 'page', 'pages', 'blog', 'bookmarks', 'file', 'groupforumtopic', 'event_calendar', 'idea', 'announcement', 'message');
  foreach ($stats as $k => $entry) {
    arsort($entry);
    foreach ($entry as $a => $b) {
      // Don't display everything
      if (!in_array($a, $stat_types)) continue;
      //This function controls the alternating class
      $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
      if ($a == "__base__") {
        $a = elgg_echo("item:{$k}");
        if (empty($a)) $a = $k;
      } else {
        if (empty($a)) { $a = elgg_echo("item:{$k}"); } else { $a = elgg_echo("item:{$k}:{$a}"); }
        if (empty($a)) { $a = "$k $a"; }
      }
      echo '<p class="'.$even_odd.'"><strong>' . $b . '</strong> ' . $a . '</p>';
    }
  }
  */
  $stats .= '</div>';
}


$content = '<div id="adf-homepage" class="interne">';

/*
texte d'accueil (idem celui en mode intranet)
liste des groupes publics (icône + titre) - aléatoire parmi les groupes en Une
fil d'activité global

bloc agenda
bloc de connexion
bloc d'inscription
*/

$content .= '<div style="width:400px; float:left; margin-left:40px;">';
  $intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
  if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
  
  // Evenements proches
  if (elgg_is_active_plugin('event_calendar')) {
    require_once($CONFIG->pluginspath . "event_calendar/models/model.php");
    $content .= '<h2>Agenda</h2>';
    $start_date = date('Y-m-d');
    $start_ts = strtotime($start_date);
    $end_ts = $start_ts + 50000000;
	  $events_count = event_calendar_get_events_between($start_ts,$end_ts,true,3,0);
	  $events = event_calendar_get_events_between($start_ts,$end_ts,false,3,0);
	  if ($events) $content .= elgg_view_entity_list($events, $events_count, 0, 3, false, false);
	  else $content .= '<p>Aucun événement public pour le moment.<br />Connectez-vous pour accéder aux événements réservés aux membres.</p>';
  }
  
  // Liste des groupes avec icônes
  $content .= '<div class="clearfloat"></div><br />';
  $content .= '<div>';
    $content .= '<h2>Les Groupes</h2>';
    $groups = elgg_get_entities(array('types' => 'group', 'limit' => 9999, 'reverse_order_by' => false));
    //shuffle($groups);
    //$content .= elgg_view_entity_list($groups, '', 0, 99, false, false, false);
    foreach ($groups as $group) {
      if ($group->featured_group == 'yes') {
        $content .= '<a href="' . $group->getURL() . '">';
        $content .= '<div style="float:left; clear:left; padding-bottom:16px; width:100%;">';
        $content .= '<img src="' . $group->getIconURL('medium') . '" style="float:left; margin:0 6px 4px 0;"/>';
        $content .= '<h3>' . $group->name . '</h3>';
        $content .= '<p style="font-size:11px;">' . $group->briefdescription . '</p>';
        $content .= '</div>';
        $content .= '</a>';
      }
    }
  $content .= '</div>';
  
$content .= '</div>';

$content .= '<div style="width:460px; float:right; margin-right:40px;">';
  $content .= '<div style="border:1px solid #CCCCCC; padding:10px 20px; margin-top:30px; background:#F6F6F6;">';
  $content .= '<h2>Connexion</h2>';
  // Connexion + mot de passe perdu
  $content .= elgg_view_form('login');
  $content .= $lostpassword_form;
  $content .= '<div class="clearfloat"></div>';
  $content .= '</div>';
  // Création nouveau compte
  if (elgg_get_config('allow_registration')) { $content .= $register_form; }
  $content .= '</div>';
  $content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';

$content .= $stats;

//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

