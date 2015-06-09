<?php
/**
 * Elgg externalblog view
 *
 * @package Elggexternalblog
 */

$full = elgg_extract('full_view', $vars, FALSE);
$externalblog = elgg_extract('entity', $vars, FALSE);
if (!$externalblog) { return; }

//$date = elgg_view_friendly_time($externalblog->time_created);
//$authors = elgg_get_entities_by_relationship(array()); // sous forme de relationships pour pouvoir les récupérer plus facilement

$metadata = elgg_view_menu('entity', array(
	  'entity' => $vars['entity'], 'handler' => 'externalblog',
	  'sort_by' => 'priority', 'class' => 'elgg-menu-hz',
  ));
// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) { $metadata = ''; }


// Compose view
if ($full && !elgg_in_context('gallery')) {
  // full view
  $body .= '<h3>' . $externalblog->title . ' (<a href="' . $CONFIG->url . $externalblog->blogname . '">' . $CONFIG->url . $externalblog->blogname . '</a>)</h3>';
  if (!empty($externalblog->password)) $body .= 'Mot de passe : ' . $externalblog->password . '<br />';
  if (!empty($externalblog->template)) $body .= 'Template : ' . $externalblog->template . '<br />';
  if (!empty($externalblog->description)) $body .= $externalblog->description . '<br />';
  if (elgg_is_logged_in() && $externalblog->canEdit()) {
    $body .= '<a href="' . $CONFIG->url . 'externalblog/edit/' . $externalblog->guid . '">Modifier</a>&nbsp; &nbsp;';
    $body .= elgg_view('output/url', array('href' => $CONFIG->url . 'action/externalblogs/delete?guid=' . $externalblog->guid, 'is_action' => true, 'text' => 'Supprimer')) . '<br />';
  }
} elseif (elgg_in_context('gallery')) {
	// gallery view
	$body = '<div class="externalblog-gallery-item">';
  $body .= '<h3>' . $externalblog->title . '</h3>';
  $body .= '<p class="subtitle">' . $authors . ' ' . $date . '</p>';
  $body .= '</div>';
  
} else {
	// brief view
	$subtitle = "$authors $date";
	$excerpt = elgg_get_excerpt($externalblog->description);
	if ($excerpt) { $excerpt = " - $excerpt"; }
	$params = array(
		  'entity' => $externalblog, 'metadata' => $metadata,
		  'subtitle' => $subtitle, 'content' => $excerpt,
	  );
	$body = elgg_view('object/elements/summary', $params);
}

echo $body;

