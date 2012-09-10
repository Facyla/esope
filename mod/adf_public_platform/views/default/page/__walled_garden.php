<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");

$site = elgg_get_site_entity();
$title = $site->name;


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


?>


<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

// Set the content type
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
</head>
<body>
<div class="elgg-page elgg-page-walledgarden">
	
	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>
	
	<div class="elgg-page-body">
		<div id="elgg-walledgarden">
		  <?php echo $vars['body']; ?>

      <div id="elgg-walledgarden-bottom">
        <a class="forgot_link" href="<?php echo elgg_get_site_url(); ?>forgotpassword" style="float:right; margin-right:100px;"><?php echo elgg_echo('user:password:lost'); ?></a>
        <?php
      	if (elgg_get_config('allow_registration')) {
      	  echo '<a class="registration_link" href="' . elgg_get_site_url() . 'register" style="float:left; margin-left:100px;">' . elgg_echo('register') . '</a>';
        }
        ?>
      </div>
      <?php
      echo elgg_view('core/walled_garden/lost_password');
      if (elgg_get_config('allow_registration')) { echo elgg_view('core/walled_garden/register'); }
      ?>
    </div>
    
	</div>
	<div class="clearfloat"></div>
  
	<?php echo $stats; ?>
	
<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>

