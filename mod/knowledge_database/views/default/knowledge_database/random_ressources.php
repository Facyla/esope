<?php
// Selection of random ressources

$max = elgg_extract('max', $vars, 3);
$title = elgg_extract('title', $vars, elgg_echo("knowledge_database:latestressources"));
$search_vars = elgg_extract('search_vars', $vars, array());

// Set default allowed list
$defaults = array('type' => 'object');
$search_vars = array_merge($defaults, $search_vars);

if (empty($vars['subtypes'])) { $search_vars['subtypes'] = knowledge_database_get_allowed_subtypes(); }

// Get random recent resources
$latest = elgg_get_entities($search_vars);
shuffle($latest);
$latest = array_slice($latest, 0, $max);

// Format the results
echo elgg_view('knowledge_database/resources_showcase', array('entities' => $latest, 'title' => $title, 'class' => 'knowledge_database-random-ressources'));

