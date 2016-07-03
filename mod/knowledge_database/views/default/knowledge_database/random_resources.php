<?php
// Selection of random resources

$max = elgg_extract('max', $vars, 3);
$title = elgg_extract('title', $vars, elgg_echo("knowledge_database:latestresources"));

// Set default allowed list
$defaults = array('type' => 'object');
$search_vars = array_merge($defaults, $vars);

if (empty($search_vars['subtypes'])) { $search_vars['subtypes'] = knowledge_database_get_allowed_subtypes(); }

// Get random recent resources
$latest = elgg_get_entities($search_vars);
shuffle($latest);
$latest = array_slice($latest, 0, $max);

// Format the results
echo elgg_view('knowledge_database/resources_showcase', array('entities' => $latest, 'title' => $title, 'class' => 'knowledge_database-random-resources'));

