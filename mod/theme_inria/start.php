<?php

	/* Elgg Theme Simple Example */

	
	
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
		if (elgg_is_logged_in())
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
			elgg_register_plugin_hook_handler('index','system','theme_inria_index');
		}

	// f(n) theme inria index
	function theme_inria_index(){
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
    
    
		$thewire = '<h3>Micromessages</h3>' . elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
		elgg_push_context('widgets');
		$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 2, 'pagination' => false));
		elgg_pop_context('widgets');
		
		 // Tableau de bord
		 elgg_set_context('dashboard');
		 elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
		 $params = array( 'content' => '', 'num_columns' => 3, 'show_access' => false);
		 $widget_body = elgg_view_layout('widgets', $params);
		 
		 
		 $body = '<header><div class="intro">' . $firststeps . $intro . '</div></header>' 
		  . '<div class="clearfloat"></div>
		  
		  <div style="width:18%;margin-right:2%;float:left;">' . elgg_view('theme_inria/sidebar_groups') . '</div>
		  
		  <div style="width:60%;float:left;">' . $thewire . '</div>
		  
		  <div style="width:18%;margin-left:2%;float:left;"> ' . elgg_view('theme_inria/users/online') . elgg_view('theme_inria/users/newest') . '</div>
		  
		  <div class="clearfloat"></div><br />' . $widget_body;
	  
	  $params = array( 'content' => $body, 'sidebar' => "");
		$body = elgg_view_layout('one_column', $params);

		echo elgg_view_page($title, $body);

		return true;
  }


