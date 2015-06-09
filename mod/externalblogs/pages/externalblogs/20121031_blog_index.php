<?php
/**
 * Elgg externalblogs plugin everyone page
 *
 * @package Elggexternalblogs
 */
global $CONFIG;

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('externalblogs'));

//$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = full_url();
$request_uri = explode('?', $request_uri);
$request_url = $request_uri[0];
$request_params = $request_uri[1];
$request_url = explode($CONFIG->url, $request_url);
$request_url = explode('/', $request_url[1]);
// Données utiles : blog, article, titre article
$blogname = $request_url[0];
$article_guid = $request_url[1];
$article_name = $request_url[2];

// Contenu de la page
// $externalblog = get_entities_from_metadata(array());
$externalblogs = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'blogname', 'value' => $blogname)));
$externalblog = $externalblogs[0];

// Contrôle d'accès
if (elgg_is_logged_in()) {
  if (!$externalblog) { register_error('externalblog:unknown'); forward(); }
} else {
  // Blog externe non valide ou blog non public => exit
  if (!$externalblog || ($externalblog->access_id != 2)) { register_error('externalblog:unknown'); forward(); }
}
// Contrôle de mot de passe du blog si défini
if (!empty($externalblog->password)) {
  $logout = get_input('logout', false);
  if ($logout == 'yes') {
    unset($_SESSION['externalblog']);
    //if (logout())
    system_message('externalblog:sessiondestroyed');
  }
  $passhash = md5($CONFIG->url . $externalblog->password);
  if ($_SESSION['externalblog'][$externalblog->guid]['passhash'] !== $passhash) {
    $input_password = get_input('password', false);
    $hash_input_password = md5($CONFIG->url . $input_password);
    if ($input_password && ($hash_input_password == $passhash)) {
      $_SESSION['externalblog'][$externalblog->guid]['passhash'] = $passhash;
    } else {
      $content = '<form method="post" action="">' . elgg_view('input/password', array('name' => 'password')) . elgg_view('input/submit', array('text' => 'logout')) . '</form>';
      $title = elgg_echo('externalblog:passwordprotected');
      $body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'filter' => ''));
      echo elgg_view_page($title, $body);
      exit;
    }
  }
}
if (isset($_SESSION['externalblog'])) {
  // Si connecté via mot de passe de blog : Bouton de déconnexion
  $unset_session = '<form method="post" action="">' . elgg_view('input/hidden', array('name' => 'logout', 'value' => 'yes')) . elgg_view('input/submit', array('value' => 'Fermer ma session')) . '</form>';
  $unset_session = $unset_session . '<br />';
  //$unset_session = '<span style="float:right; font-weight:bold; font-size:80%;">' . $unset_session . '</span>';
}

// Articles
$content .= elgg_view('externalblogs/blog_home', array('entity' => $externalblog)) . '<br />';

if (empty($article_guid)) {
  // Tous les articles
  //$articles = get_attachments($externalblog->guid, 'object');
  //$articles = get_entity_relationships($externalblog->guid, false);
  $articles = elgg_get_entities_from_relationship(array('relationship_guid' => $externalblog->guid, 'relationship' => 'attached', 'inverse_relationship' => false));
} else {
  // Article choisi en pleine page
  $article = get_entity($article_guid);
  $articles = array($article);
}
// Affichage du ou des articles
set_context('blog');
foreach ($articles as $article) {
  if (isset($listed_article) && in_array($article->guid, $listed_article)) { continue; } else { $listed_article[] = $article->guid; }
  //$content .= elgg_view_entity($article, array('full_view' => true));
  // @todo Mettre en place une vue pour l'affichage homogène des contenus
  //$content .= elgg_view('externalblog/blog_article', array('full_view' => true));
  $content .= '<h3><a href="' . $CONFIG->url . $blogname . '/' . $article->guid . '/' . friendly_title($article->title) . '">' . $article->title . '</a></h3>';
  $content .= '<div>' . $article->description . '</div>';
  $content .= '<div style="font-size:80%; color:grey;">Publié ' . friendly_time($article->time_created) . '</div>';
}
set_context('externalblog');



// Menu latéral
$sidebar = elgg_view('externalblogs/sidebar');



// Rendu de la page
//$title = elgg_echo('externalblogs:blog');
$title = $externalblog->title;
$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter' => ''));
echo elgg_view_page($title, $body);

