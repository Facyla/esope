<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */


$site = elgg_get_site_entity();
$title = $site->name;


// Les 2 formulaires masqués
$forms = '';
$forms .= '<div id="adf-walledgarden-password" style="display:none;"><h3>' . elgg_echo('user:password:lost') . '</h3>' . elgg_view_form('user/requestnewpassword') . '</div>';
if (elgg_get_config('allow_registration')) {
  $forms .= '<div id="adf-walledgarden-register" style="display:none;"><h3>' . elgg_echo('register') . '</h3>' . elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode'), )) . '</div>';
}

// Statistiques du site
$stats = '';
$displaystats = elgg_get_plugin_setting('displaystats', 'adf_public_platform');
if ($displaystats == "yes") {
  $stats .= '<div style="background: url(' . $vars['url'] . '_graphics/walled_garden_backgroundfull_top.gif) no-repeat left top;">';
  $stats .= '<div style="padding:30px 30px 0 30px;">';
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
  $stats .= '<div style="height:54px; background: url(' . $url . '_graphics/walled_garden_backgroundfull_bottom.gif) no-repeat left bottom;"></div>';
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
<div class="elgg-page elgg-page-walledgarden">
	
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
	
  <div id="elgg-walledgarden" class="elgg-body-walledgarden">
    
    <?php
    $content .= '<div style="background: url(' . $vars['url'] . '_graphics/walled_garden_backgroundfull_top.gif) no-repeat left top;">';
      $content .= '<div style="padding:30px 35px 0 35px;">' . elgg_view_title(elgg_echo('walled_garden:welcome') . ' : ' . $title) . '<br />'
        . elgg_view('core/account/login_box') . '</div>' . '<div class="clearfloat"></div>';

      // Liens création compte + mot de passe perdu
      $content .= '<div>';
      /* S'inspirer de ce type de méthode pour être plus  accessible
        $content .= '<a class="forgot_link elgg-button-action" href="' . elgg_get_site_url() . 'forgotpassword" onclick="$(.elgg-walledgarden-password).toggle();" style="float:right; margin-right:100px;">' . elgg_echo('user:password:lost') . '</a>';
        if (elgg_get_config('allow_registration')) {
          $content .= '<a class="registration_link elgg-button-action" href="' . elgg_get_site_url() . 'register" onclick="$(.elgg-walledgarden-register).toggle();" style="float:left; margin-left:100px;">' . elgg_echo('register') . '</a>';
        }
      */
      $content .= '<a class="elgg-button-action" href="javascript:void(0);" onclick="$(\'#adf-walledgarden-password\').toggle(); $(\'#adf-walledgarden-register\').hide();" style="float:right; margin-right:100px;">' . elgg_echo('user:password:lost') . '</a>';
      if (elgg_get_config('allow_registration')) {
        $content .= '<a class="elgg-button-action" href="javascript:void(0);" onclick="$(\'#adf-walledgarden-register\').toggle(); $(\'#adf-walledgarden-password\').hide(); return true;" style="float:left; margin-left:100px;">' . elgg_echo('register') . '</a>';
      }
      $content .= '<div class="clearfloat"></div>';
      $content .= '</div>';
      $content .= '<div style="padding:30px 35px 0 35px; background: url(' . $vars['url'] . '_graphics/walled_garden_backgroundfull_extend.gif) repeat-y 0 0;">' . $forms . '</div>';
      $content .= '<div style="height:54px; background: url(' . $url . '_graphics/walled_garden_backgroundfull_bottom.gif) no-repeat left bottom;"></div>';
    $content .= '</div>';
    
    echo $content;
    ?>
    <div class="clearfloat"></div>
    <?php echo $stats; ?>
  </div>
	
</div>

<?php echo elgg_view('page/elements/foot'); ?>

</body>
</html>

