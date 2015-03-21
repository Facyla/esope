<?php
/**
 * Externalblogs edit form
 *
 */
global $CONFIG;
$entity = $vars['entity'];
$container_guid = $vars['container_guid'];

$form_body .= '<h3>' . elgg_echo('externalblogs:bloginfos') . '</h3>';

// Liens pratiques (vers le blog et la prévisualisation comme en mode public)
$form_body .= 'URL du blog public&nbsp;: <a target="_new" href="' . $CONFIG->url . $entity->blogname . '">' . $CONFIG->url . $entity->blogname . '</a><br />';
$form_body .= '<a target="_new" href="' . $CONFIG->url . $entity->blogname . '?public=true">&raquo;&nbsp;Prévisualiser le blog (seuls les changements enregistrés sont visualisés)</a><br /><br />';

// Informations de base du blog
$form_body .= '<strong>Nom du blog</strong> ' . elgg_view('input/text', array('name' => 'title', 'value' => $entity->title, 'js' => ' style="width:500px;"')) . '<br /><br />';
$form_body .= '<strong>URL du blog</strong> ' . $CONFIG->url . elgg_view('input/text', array('name' => 'blogname', 'value' => $entity->blogname, 'js' => ' style="width:200px;"')) . '<br /><br />';
$form_body .= '<strong>Edito du blog</strong> (s\'affiche en entête sur la page d\'accueil) ' . elgg_view('input/longtext', array('name' => 'description', 'value' => $entity->description)) . '<br />';
$form_body .= '<strong>Accès</strong> ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $entity->access_id)) . '<br /><br />';
$form_body .= '<strong>Mot de passe</strong> (facultatif, seulement hors connexion) : ' . elgg_view('input/text', array('name' => 'password', 'value' => $entity->password, 'js' => ' style="width:200px;"')) . '<br /><br />';


// Liste des GUIDs de tous les membres du site
$members_select = '<select>';
$members = elgg_get_entities(array('types' => 'user', 'limit' => 99999));
foreach($members as $ent) { $members_select .= '<option>' . $ent->guid . ' : ' . $ent->name . '</option>'; }
$members_select .= '</select>';


// Auteur du blog
$blogowner = get_entity($entity->owner_guid);
if ($blogowner) {
  $form_body .= '<strong>Auteur du blog&nbsp;:</strong> ' . $blogowner->name . ' (' . $blogowner->guid . ')<br /><br />';
}

// Admins du blog$blogowner->name
$form_body .= '<strong>GUIDS des administrateurs du blog, séparés par virgules</strong> ';
$form_body .= elgg_view('input/tags', array('name' => 'blogadmin_guids', 'value' => $entity->blogadmin_guids, 'js' => ' style="width:300px;"' )) . '<br />';
$form_body .= 'Aide : liste des GUID des membres ' . $members_select . '<br /><br />';

// Auteurs autorisés
$members_select = '<select>';
$members = elgg_get_entities(array('types' => 'user', 'limit' => 99999));
foreach($members as $ent) { $members_select .= '<option>' . $ent->guid . ' : ' . $ent->name . '</option>'; }
$members_select .= '</select>';
$form_body .= '<strong>GUIDS des auteurs, séparés par virgules</strong> ';
//if (is_array($entity->author_guids)) $author_guids = implode(',', $entity->author_guids);
$form_body .= elgg_view('input/tags', array('name' => 'author_guids', 'value' => $entity->author_guids, 'js' => ' style="width:300px;"' )) . '<br />';
$form_body .= 'Aide : liste des GUID des membres ' . $members_select . '<br /><br />';


// Layouts & mise en page
$template_options = array('' => "Par défaut (celle de ce site)", 'custom' => "Personnalisé (blocs prédéfinis à personnaliser)", 'zones' => "Mode expert (zones et modules configurables)");
$form_body .= elgg_view('input/dropdown', array( 'name' => 'template', 'options_values' => $template_options, 'value' => $vars['entity']->template, 'js' => ' style="float:right;" onchange="javascript:$(\'.toggle_detail\').hide(); $(\'.toggle_detail.field_\'+this.value).show();"' ));
$form_body .= '<h3>' . elgg_echo('externalblogs:layouts') . '</h3>';
$form_body .= elgg_echo('externalblogs:layouts:description') . '<br /><br />';

// Hide proper parameters
if ($entity->template != 'custom') $hidecustom = 'style="display:none;" '; else $hidecustom = '';
if ($entity->template != 'zones') $hidezones = 'style="display:none;" '; else $hidezones = '';

// custom : Template personnalisé (header & footer)
//if ($entity->template == 'custom') {
  $form_body .= '<div class="toggle_detail field_custom" '.$hidecustom.'>';
  $form_body .= '<h4>' . elgg_echo('externalblogs:customtemplate') . '</h4>';
  $form_body .= 'Bandeau supérieur : ' . elgg_view('input/plaintext', array('name' => 'layout_header', 'value' => $entity->layout_header)) . '<br />';
  $form_body .= 'Pied de page : ' . elgg_view('input/plaintext', array('name' => 'layout_footer', 'value' => $entity->layout_footer)) . '<br />';
  //$form_body .= 'Template d\'article (nom des champs encadrés par des %%title%%) : ' . elgg_view('input/plaintext', array('name' => 'layout_blogtemplate', 'value' => $entity->layout_blogtemplate)) . '<br />';
  $form_body .= 'CSS du blog : ' . elgg_view('input/plaintext', array('name' => 'layout_css', 'value' => $entity->layout_css)) . '<br />';
  $form_body .= '</div>';
//}

// Mises en page élaborées : pointent vers des listes de CMSpages (contenus ou modules) via leur pagetype
//if ($entity->template == 'zones') {

  $form_body .= '<div class="toggle_detail field_zones" '.$hidezones.'>';
  $form_body .= '<h4>' . elgg_echo('externalblogs:zones') . '</h4>' . elgg_echo('externalblogs:zones:description');
  // Liste des options de layout
  $layout_options = array( '1column' => elgg_echo('1 colonne'), '2column' => elgg_echo('2 colonnes'), '3column' => elgg_echo('3 colonnes'), );
  // Liste des pages CMS
  $params = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true);
  $cmspages_count = elgg_get_entities($params);
  $params['limit'] = $cmspages_count;
  $params['count'] = false;
  $cmspages = elgg_get_entities($params);
  foreach ($cmspages as $cmspage) {
    $cmspages_options[$cmspage->pagetype] = $cmspage->pagetype . ' : ' . $cmspage->pagetitle;
  }
  $form_body .= "Pages CMS disponibles : " . elgg_view('input/dropdown', array('options_values' => $cmspages_options)) . '<br />';
  $form_body .= '<a target="_new" href="' . $CONFIG->url . 'cmspages">&raquo;&nbsp;Gérer les blocs via cmspages</a><br /><br />';
  // @TODO : remplacer le champ fulltext de configuration par un simple sélecteur de template
  // elgg_view('input/dropdown', array('options_values' => $cmspages_options)
  // HOME
  $form_body .= '<div style="width:46%; float:left;">';
  $form_body .= elgg_view('input/dropdown', array( 'name' => 'zones_home_layout', 'options_values' => $layout_options, 'value' => $vars['entity']->zones_home_layout, 'js' => ' style="float:right;"' ));
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:home') . '</strong><br />';
  $form_body .= elgg_view('input/plaintext', array('name' => 'zones_home', 'value' => $entity->zones_home)) . '</div>';
  // CATEGORY
  $form_body .= '<div style="width:46%; float:right;">';
  $form_body .= elgg_view('input/dropdown', array( 'name' => 'zones_category_layout', 'options_values' => $layout_options, 'value' => $vars['entity']->zones_category_layout, 'js' => ' style="float:right;"' ));
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:category') . '</strong><br />';
  $form_body .= elgg_view('input/plaintext', array('name' => 'zones_category', 'value' => $entity->zones_category)) . '</div>';
  $form_body .= '<div class="clearfloat"></div>';
  // FULLVIEW
  $form_body .= '<div style="width:46%; float:left;">';
  $form_body .= elgg_view('input/dropdown', array( 'name' => 'zones_fullview_layout', 'options_values' => $layout_options, 'value' => $vars['entity']->zones_fullview_layout, 'js' => ' style="float:right;"' ));
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:fullview') . '</strong><br />';
  $form_body .= elgg_view('input/plaintext', array('name' => 'zones_fullview', 'value' => $entity->zones_fullview)) . '</div>';
  // PAGES CMS
  $form_body .= '<div style="width:46%; float:right;">';
  $form_body .= elgg_view('input/dropdown', array( 'name' => 'zones_cmspages_layout', 'options_values' => $layout_options, 'value' => $vars['entity']->zones_cmspages_layout, 'js' => ' style="float:right;"' ));
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:cmspages') . '</strong><br />';
  $form_body .= elgg_view('input/plaintext', array('name' => 'zones_cmspages', 'value' => $entity->zones_cmspages)) . '</div>';
  $form_body .= '<div class="clearfloat"></div>';
  // LISTING
  $form_body .= '<div style="width:46%; float:left;">';
  $form_body .= elgg_view('input/dropdown', array( 'name' => 'zones_listing_layout', 'options_values' => $layout_options, 'value' => $vars['entity']->zones_listing_layout, 'js' => ' style="float:right;"' ));
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:listing') . '</strong><br />';
  $form_body .= elgg_view('input/plaintext', array('name' => 'zones_listing', 'value' => $entity->zones_listing)) . '</div>';
  $form_body .= '<div class="clearfloat"></div>';
  $form_body .= '<strong>' . elgg_echo('externalblogs:zones:css') . '</strong> ' . elgg_view('input/plaintext', array('name' => 'zones_css', 'value' => $entity->zones_css)) . '<br />';
  $form_body .= '</div>';
//}


// Widgets
// Définir de nouveaux widgets => doit passer dans le start, appelé selon les modules définis (externablog_module)
// Voir comment on peut définir de nouveaux widgets à la volée, sans fichiers..
// elgg_register_widget_type('blog', elgg_echo('adf_platform:widget:blog:title'), elgg_echo('blog:widget:description'), 'all');
/*
$params = array(
	'content' => '', // Texte en intro des widgets (avant les 3 colonnes)
	'num_columns' => 3,
	'show_access' => false,
);
$widgets = elgg_view_layout('widgets', $params);
$form_body .= $widgets;

// Config => N * (module + config)
*/

/*
$externalblog_contexts = array('externalblog_home', 'externalblog_fullview', 'externalblog_category', 'externalblog_listing');
elgg_push_context('widgets');
$widget_types = elgg_get_widget_types();
foreach ($externalblog_contexts as $context) {
  $widgets_body .= '<div class="clearfloat"></div>';
  $widgets_body .= '<h2>' . $externalblog_context . '</h2>';
  
  // Widgets pour chacun des contextes définis
  // on peut ensuite mettre comme paramètre leur position
  elgg_set_context($context);
  $widgets = elgg_get_widgets($entity->owner_guid, $context.'_'.$entity->guid); // widgets associés à l'entité 'externalblog'
  $params = array('widgets' => $widgets, 'context' => $context, 'exact_match' => false);
  $widgets_body .= elgg_view('externalblogs/add_button', $params) . elgg_view('externalblogs/add_panel', $params);
  
  // Colonnes : 3 maxi (en dur) 
  // => on charge zone par zone, donc 1 seule utilisée à la fois (mais pls contextes et zones)
  $num_columns = 1;
  $widget_class = "elgg-col-1of{$num_columns}";
  for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
	  if (isset($widgets[$column_index])) {
		  $column_widgets = $widgets[$column_index];
	  } else {
		  $column_widgets = array();
	  }
	  $widgets_body .= "<div style=\"background:#DADADA; width:".(int)((100-$num_columns)/$num_columns)."%; float:left;\" class=\"$widget_class elgg-widgets\" id=\"elgg-widget-col-$column_index\">";
	  if (sizeof($column_widgets) > 0) {
		  foreach ($column_widgets as $widget) {
			  if (array_key_exists($widget->handler, $widget_types)) {
				  $widgets_body .= elgg_view_entity($widget, array('show_access' => $show_access));
			  }
		  }
	  }
	  $widgets_body .= '</div>';
	  //if (is_int($column_index/2)) $widgets_body .= '<div class="clearfloat"></div>';
  }

}
*/


// Hidden fields & save button
$form_body .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $entity->guid));
$form_body .= '<br /><br />';
$form_body .= '<div class="elgg-foot">';
$form_body .= elgg_view('input/submit', array('value' => elgg_echo('save')));
$form_body .= '</div>';

// Compose form
echo elgg_view('input/form', array('action' => $CONFIG->wwwroot . 'action/externalblogs/edit', 'body' => $form_body));

echo $widgets_body;


