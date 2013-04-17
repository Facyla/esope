<?php

// Initialise log browser
register_elgg_event_handler('init','system','theme_inria_init');

/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;

	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	elgg_unregister_widget_type('thewire');
	elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', "Collaboration", "Les outils collaboratifs Inria");

	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_inria_index');
	} else {
	  if (!$CONFIG->walled_garden) {
	    elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
	    elgg_register_plugin_hook_handler('index','system','theme_inria_public_index');
	  }
	}
}

// f(n) theme inria index
function theme_inria_index(){
  global $CONFIG;
  /* 	include(dirname(__FILE__) . '/pages/adf_platform/homepage.php');
	  return true;	*/

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
  
  
	$thewire = '<h3><a href="' . $CONFIG->url . 'thewire/all">Inria, le Fil</a></h3>' . elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
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
  
  $params = array( 'content' => $body, 'sidebar' => "");
	$body = elgg_view_layout('one_column', $params);

	echo elgg_view_page($title, $body);

	return true;
}

function theme_inria_public_index() {
  global $CONFIG;
	include(dirname(__FILE__) . '/pages/theme_inria/public_homepage.php');
  return true;
}


