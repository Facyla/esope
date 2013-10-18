<?php
global $CONFIG;

gatekeeper();

// Premiers pas (si configuré)
$firststeps_guid = elgg_get_plugin_setting('firststeps_guid', 'adf_public_platform');
$firststeps_page = get_entity($firststeps_guid);
if ($firststeps_page instanceof ElggObject) {
  $firststeps = '<div class="firststeps">
      <a href="javascript:void(0);" onClick="$(\'#firsteps_toggle\').toggle(); $(\'#firststeps_show\').toggle(); $(\'#firststeps_hide\').toggle();">Premiers pas (cliquer pour afficher / masquer)
        <span id="firststeps_show" style="float:right;">&#x25BC;</span>
        <span id="firststeps_hide" style="float:right; display:none;">&#x25B2;</span>
      </a>'
    . '<div id="firsteps_toggle" style="padding:10px; border:0 !important;">'
      . $firststeps_page->description
    . '</div>' 
  . '</div>';
  // Masqué par défaut après les 2 premiers passages
  // @todo : on pourrait le faire si pas connecté depuis X temps..
  if (($_SESSION['user']->last_login >= 0) && ($_SESSION['user']->prev_last_login >= 0)) {
    $first_time = '<script type="text/javascript">
    $(document).ready(function() {
      $(\'#firsteps_toggle\').hide();
    })
    </script>';
    $firststeps .= $first_time;
  }
}

// Texte intro configurable
$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');


$thewire = '<h3><a href="' . $CONFIG->url . 'thewire/all">Inria, le Fil</a></h3>' . elgg_view_form('theme_inria/thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
elgg_push_context('widgets');
$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 4, 'pagination' => false));
elgg_pop_context('widgets');

 // Tableau de bord
 elgg_set_context('dashboard');
 elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
 $params = array( 'content' => '', 'num_columns' => 3, 'show_access' => false);
 $widget_body = elgg_view_layout('widgets', $params);
 
 
 $body = '<header><div class="intro">' . $firststeps . $intro . '</div></header>' 
  . '<div class="clearfloat"></div>
  
  <div style="width:20%; margin-right:2%; float:left;">' . elgg_view('theme_inria/sidebar_groups') . '<div class="clearfloat"></div><br />' . elgg_view('theme_inria/users/online') . '<div class="clearfloat"></div><br />' . elgg_view('theme_inria/users/newest') . '</div>
  
  <div style="width:76%; float:right;">' . $thewire . '</div>
  
  <div class="clearfloat"></div><br />' . $widget_body;

// Supprime le lien "main" (inexistant) de l'accueil
elgg_pop_breadcrumb();

$params = array( 'content' => $body, 'sidebar' => "");
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

