<?php
global $CONFIG;

// Ensure that only logged-in users can see this page
gatekeeper();

// Set context and title
elgg_set_context('dashboard');
elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
//$title = elgg_echo('dashboard');
$title = 'Tableau de bord personnalisable';

// Titre de la page
$static = '<h2 class="invisible">' . $title . '</h2>';

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
if (empty($intro)) { $intro = 'Bienvenue sur votre plateforme collaborative.<br />Administrateurs du site, pensez à éditer ce message !'; }


// Composition de la page
//$body = elgg_view_layout('one_column', array('content' => $static . '<div class="clearfloat"></div>' . $widgets));
$body = '<header><div class="intro">' . $static  . $firststeps . $intro . '</div></header>';

// The Wire
$index_wire = elgg_get_plugin_setting('index_wire', 'adf_public_platform');
if ($index_wire == 'yes') {
	$thewire = '<h3><a href="' . $CONFIG->url . 'thewire/all">Le Fil</a></h3>' . elgg_view_form('thewire/add', array('class' => 'thewire-form')) . elgg_view('input/urlshortener');
	elgg_push_context('widgets');
	$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 3, 'pagination' => false));
	elgg_pop_context('widgets');
	$body .= '<div class="clearfloat"></div>' . $thewire;
}

// Widgets + wrap intro message in a div
$params = array(
	'content' => '', // Texte en intro des widgets (avant les 3 colonnes)
	'num_columns' => 3,
	'show_access' => false,
);
$widgets = elgg_view_layout('widgets', $params);
$body .= '<div class="clearfloat"></div>' . $widgets;


// Affichage
echo elgg_view_page($title, $body);

