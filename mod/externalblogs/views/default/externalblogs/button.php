<?php
if (!isset($vars['entity'])) { return true; }
$guid = $vars['entity']->getGUID();

if (elgg_is_logged_in() && $vars['entity']->canAnnotate(0, 'externalblog')) {
	/* @todo 2 versions selon qu'on a déjà publié ou non dans un blog externe
	if (!elgg_annotation_exists($guid, 'externalblog')) {
	} else {
	}
	*/
	$url = elgg_get_site_url() . "action/externalblogs/selectedit?guid={$guid}";
	/*
	$params = array(
		'href' => $url,
		'text' => elgg_view_icon('share'),
		'title' => elgg_echo('externalblogs:externalblogthis'),
		'is_action' => true, 'is_trusted' => true,
	);
	$externalblogs_button = elgg_view('output/url', $params);
	*/
	
	// Icône et compteur
	// @todo : changer l'icône selon si sélectionné dans au moins un blog ou pas du tout
	//$count = elgg_get_entities_from_relationship(array('metadata_name_value_pairs' => array('name' => 'attached', 'value' => $guid), 'count' => true));
	$count = elgg_get_entities_from_relationship(array('relationship_guid' => $guid, 'relationship' => 'attached', 'inverse_relationship' => true, 'count' => true));
	$text = elgg_view_icon('share');
	if ($count > 0) $text .= ' <span style="font-weight:bold; padding:2px 3px; border-radius:5px; background:#CFCFCF;">' . $count . '</span>';
	$params = array(
		  'text' => $text, 'title' => elgg_echo('externalblogs:externalblogthis'),
		  'rel' => 'popup', 'href' => "#externalblogs-$guid"
	  );
	$list = elgg_view('output/url', $params);
	
	// POPUP : affiché si possibilité d'édition seulement
  $owner_externalblogs = elgg_get_entities(array(
      'types' => 'object', 'subtypes' => 'externalblog',
      'owner_guid' => elgg_get_logged_in_user_guid(), 'limit' => 99, 'sort' => 'time_created asc',
    ));
  // Ajout des auteurs à l'owner
  $author_externalblogs = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'authors_guid', 'value' => elgg_get_logged_in_user_guid()), 'limit' => 99));
  $externalblogs = array_merge($owner_externalblogs, $author_externalblogs);
  $list .= "<div class='elgg-module elgg-module-popup elgg-externalblogs hidden clearfix' id='externalblogs-$guid'>";
  if (is_array($externalblogs)) {
    foreach ($externalblogs as $externalblog) {
	    if (isset($listed_externablog) && in_array($externalblog->guid, $listed_externablog)) { continue; } else { $listed_externablog[] = $externalblog->guid; }
	    if (already_attached($externalblog->guid, $guid)) {
	      // Déjà bloggé : on peut retirer de ce blog
	      $text = '<span style="color:red;">Retirer de ' . $externalblog->title . ' (' . $externalblog->blogname . ')</span>';
	      $params = array(
		        'href' => $url . '&unselect=unselect&externalblog_guid=' . $externalblog->guid,
		        //'text' => elgg_view_icon('delete') . ' Retirer de ' . $text,
		        'text' => elgg_view_icon('star') . ' ' . $text,
		        'title' => strip_tags($externalblog->description),
		        'is_action' => true, 'is_trusted' => true,
	        );
      	$list .= elgg_view('output/url', $params) . '<br />';
    	} else {
	      // Pas blogué dans ce blog externe
	      $text = $externalblog->title . ' (' . $externalblog->blogname . ')';
	      $params = array(
		        'href' => $url . '&externalblog_guid=' . $externalblog->guid,
		        //'text' => elgg_view_icon('checkmark') . ' Publier dans ' . $text,
		        'text' => elgg_view_icon('star-empty') . ' Publier dans ' . $text,
		        'title' => $externalblog->description,
		        'is_action' => true, 'is_trusted' => true,
	        );
      	$list .= elgg_view('output/url', $params) . '<br />';
	    }
    }
  } else { $list .= 'Aucun blog de publication<br />'; }
  $params = array(
      'href' => elgg_get_site_url() . 'externalblog',
      'text' => elgg_view_icon('share') . ' Accueil des blogs externes',
      'title' => strip_tags($externalblog->description),
      'is_action' => true, 'is_trusted' => true,
    );
  $list .= elgg_view('output/url', $params) . '<br />';
  $list .= "</div>";
	
	
}

echo $list;

