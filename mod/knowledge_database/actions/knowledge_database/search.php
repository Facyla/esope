<?php
// Automatic mode
//echo esope_esearch(array('count' => true));

// Manual mode (more control over results display)

// Limit to some subtypes
$subtypes = knowledge_database_get_allowed_subtypes();

$results = esope_esearch(array('add_count' => true, 'returntype' => 'entities', 'entity_subtype' => $subtypes));

// Count results
$count = sizeof($results);
echo '<p><strong><span class="esope-results-count">';
if ($count > 1) {
	echo elgg_echo('knowledge_database:resultscount', array($count));
} else if ($count == 1) {
	echo elgg_echo('knowledge_database:resultscount1', array($count));
} else {
	echo elgg_echo('knowledge_database:noresult');
}
echo '</span></strong></p>';

// Display results
if ($results) {
	echo '<ul class="elgg-list elgg-list-entity">';
	foreach ($results as $ent) {
		echo elgg_view('knowledge_database/result', array('entity' => $ent));
	}
	echo '</ul>';
}

exit;

