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



// Construction de la page proprement dite
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
  <?php echo elgg_view('page/elements/head', $vars); ?>
  <?php echo '<script type="text/javascript">' . elgg_view('js/walled_garden') . '</script>'; ?>
</head>

<body>

<header>
  <div class="interne">
    <?php
    $headertitle = elgg_get_plugin_setting('headertitle', 'adf_public_platform');
    if (empty($headertitle)) '<h1 class="invisible">' . $CONFIG->site->name . '</h1>';
    else echo '<h1><a href="' . $url . '" title="Aller sur la page d\'accueil">' . $headertitle . '</a></h1>';
    ?>
  </div>
</header>

<div class="elgg-page-messages">
  <?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
</div>

<div class="clearfloat"></div>

<div id="adf-homepage" class="interne">
  
  <div id="adf-public-col1">
    <?php
    $intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
    if (!empty($intro)) echo $intro . '<div class="clearfloat"></div>';
    
    echo '<div id="adf-loginbox">';
    echo '<h2>Connexion</h2>';
    // Connexion + mot de passe perdu
	  echo elgg_view_form('login');
	  echo $lostpassword_form;
	  echo '<div class="clearfloat"></div>';
    echo '</div>';
    ?>
  </div>

  <div id="adf-public-col2">
    <?php
    // Création nouveau compte
    if (elgg_get_config('allow_registration')) { echo $register_form; }
    ?>
  </div>
  
  <div class="clearfloat"></div>
  <br />
  <?php echo $stats; ?>

</div>

<?php echo elgg_view('page/elements/footer'); ?>

</body>
</html>

