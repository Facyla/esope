<?php
if (!isset($vars['entity'])) { return true; }
$guid = $vars['entity']->getGUID();

if (elgg_is_logged_in() && $vars['entity']->canAnnotate(0, 'collections')) {
	$url = elgg_get_site_url() . "action/collection/selectedit?entity_guid={$guid}";
	
	// Icône et compteur
	// @todo : changer l'icône selon si sélectionné dans au moins un blog ou pas du tout
	//$count = elgg_get_entities_from_relationship(array('metadata_name_value_pairs' => array('name' => 'attached', 'value' => $guid), 'count' => true));
	// @TODO : check if GUID exists in collections entities values
	$count = elgg_get_entities_from_relationship(array('relationship_guid' => $guid, 'relationship' => 'attached', 'inverse_relationship' => true, 'count' => true));
	$text = '<i class="fa fa-list"></i>'; // play-circle(-o)
	if ($count > 0) $text .= ' <span style="font-weight:bold; padding:2px 3px; border-radius:5px; background:#CFCFCF;">' . $count . '</span>';
	$params = array(
			'text' => $text, 'title' => elgg_echo('collections:collectionsthis'),
			'rel' => 'popup', 'href' => "#collections-$guid"
		);
	$list = elgg_view('output/url', $params);
	
	// POPUP : affiché si possibilité d'édition seulement
	$collections = elgg_get_entities(array(
			'types' => 'object', 'subtypes' => 'collection',
			'owner_guid' => elgg_get_logged_in_user_guid(), 'limit' => 99, 'sort' => 'time_created asc',
		));
	/*
	// Ajout des auteurs à l'owner
	$author_collections = elgg_get_entities_from_metadata(array('metadata_name_value_pairs' => array('name' => 'authors_guid', 'value' => elgg_get_logged_in_user_guid()), 'limit' => 99));
	$collections = array_merge($collections, $author_collections);
	*/
	$list .= '<div class="elgg-module elgg-module-popup elgg-collections hidden clearfix" id="collections-' . $guid . '">';
	if (is_array($collections)) {
		foreach ($collections as $collection) {
			if (isset($listed_collections) && in_array($collection->guid, $listed_collections)) { continue; } else { $listed_collections[] = $collection->guid; }
			//if (already_attached($collection->guid, $guid)) {
			if (check_entity_relationship($collection->guid, "attached", $guid)) {
				// Déjà bloggé : on peut retirer de ce blog
				$text = '<span style="color:red;">' . elgg_echo('collections:removefromcollection') . ' ' . $collection->title . '</span>';
				$params = array(
						'href' => $url . '&query=remove&collection=' . $collection->guid,
						//'text' => elgg_view_icon('delete') . ' Retirer de ' . $text,
						'text' => elgg_view_icon('star') . ' ' . $text,
						'title' => strip_tags($collection->description),
						'is_action' => true, 'is_trusted' => true,
					);
				$list .= elgg_view('output/url', $params) . '<br />';
			} else {
				// Pas blogué dans ce blog externe
				$text = $collection->title;
				$params = array(
						'href' => $url . '&query=add&collection=' . $collection->guid,
						//'text' => elgg_view_icon('checkmark') . ' Publier dans ' . $text,
						'text' => elgg_view_icon('star-empty') . ' ' . elgg_echo('collections:publishin') . ' ' . $text,
						'title' => $collection->description,
						'is_action' => true, 'is_trusted' => true,
					);
				$list .= elgg_view('output/url', $params) . '<br />';
			}
		}
	}
	
	// New playlist link
	$params = array(
			'href' => elgg_get_site_url() . 'collection/add/?entity_guid=' . $guid,
			'text' => '<strong><i class="fa fa-plus-circle"></i> ' . elgg_echo('collections:addtocollection') . '</strong>',
			'is_action' => true, 'is_trusted' => true,
		);
	$list .= elgg_view('output/url', $params) . '<br />';
	
	$list .= "</div>";
	
}

echo $list;

