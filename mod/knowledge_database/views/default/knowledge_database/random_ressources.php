<?php
// Selection of random ressources

$content = '';

$max = elgg_extract('max', $vars, 3);
$search_vars = elgg_extract('search_vars', $vars, array());

// Set default allowed list
$defaults = array('type' => 'object');
$search_vars = array_merge($defaults, $search_vars);

if (empty($vars['subtypes'])) { $search_vars['subtypes'] = knowledge_database_get_allowed_subtypes(); }

$content = '<div class="knowledge_database-random-ressources">';

// Random database ressources
$content .= '<h3>' . elgg_echo("knowledge_database:latestressources") . '</h3>';
$latest = elgg_get_entities($search_vars);
shuffle($latest);
$latest = array_slice($latest, 0, $max);
foreach($latest as $ent) {
	$icon = knowledge_database_get_icon($ent, 'medium');
	$content .= '<div class="kdb-featured">
			<div class="kdb-featured-content">
				<div class="kdb-featured-header">
					<a href="' . $ent->getURL() . '">
						<div class="image-block">' . $icon . '</div>
						<h4>' . $ent->title . '</h4></a>
				</div>
				<p>' . elgg_view('output/tags', array('tags' => $ent->tags)) . '</p>
				<p>' . elgg_get_excerpt($ent->description, 150) . '</p>
			</div>
		</div>';
}

$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

echo $content;

