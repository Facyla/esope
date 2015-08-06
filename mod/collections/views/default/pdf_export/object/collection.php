<?php
$entity = elgg_extract('entity', $vars);

if (elgg_instanceof($entity, 'object', 'collection')) {
	$title = $entity->title;
	if (empty($title)) $title = $entity->name;
	if (empty($title)) $title = elgg_echo('untitled');
	
	// Build collection content
	$collection_content = '<div class="collections-listing">';
	$entities = (array) $entity->entities;
	$entities_comment = (array) $entity->entities_comment;
	elgg_push_context('widgets');
	foreach($entities as $k => $entity_guid) {
		$publication = get_entity($entity_guid);
		if (elgg_instanceof($publication, 'object')) {
			$publication_comment = $entities_comment[$k];
			$collection_content .= '<div class="">';
			$collection_content .= '<hr />';
			
			$collection_content .= '<blockquote><p>' . $publication_comment . '</blockquote>';
			
			//$collection_content .= elgg_view_entity($publication, array('full_view' => $full_content, 'list_type' => 'list'));
			$entity_type = $publication->getType();
			$entity_subtype = $publication->getSubtype();
			if (elgg_view_exists("pdf_export/object/$entity_subtype")) {
				$collection_content .= elgg_view("pdf_export/$entity_type/$entity_subtype", array('entity' => $publication));
			} else if (elgg_view_exists("pdf_export/$entity_type")) {
				$collection_content .= elgg_view("pdf_export/$entity_type", array('entity' => $publication));
			}
			
			//$collection_content .= '</li>';
			$collection_content .= '</div>';
		}
	}
	elgg_pop_context();
	//$collection_content .= '</ul>';
	$collection_content .= '</div>';
	
		echo elgg_view_title($title);
	if ($entity->icontime) { echo elgg_view_entity_icon($entity, 'master', array()); }
	echo elgg_view('output/longtext', array('value' => $entity->description));
	echo $collection_content;
	
}

