<?php
$entity = elgg_extract('entity', $vars);

// Object title and content (description)
if (elgg_instanceof($entity)) {
	
	// Check plugin setting
	$add_comments = elgg_get_plugin_setting('add_comments', 'pdf_export');
	if ($add_comments != 'yes') { return; }
	
	$comments = elgg_get_entities(array('types' => 'object', 'subtypes' => 'comment', 'container_guid' => $entity->guid, 'limit' => false, 'preload_owners' => true));
	foreach($comments as $ent) {
		$commenter = $ent->getOwnerEntity();
		//echo '<img src="' . $commenter->getIconURL(array('size' => 'tiny')) . '" />';
		echo '<h4>';
		echo $commenter->name;
		echo ' &nbsp; <em>' . elgg_view_friendly_time($ent->time_created) . '</em>';
		echo '</h4>';
		
		echo elgg_view('output/longtext', array('value' => $ent->description));
	}

}

