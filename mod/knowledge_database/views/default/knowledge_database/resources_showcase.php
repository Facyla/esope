<?php
// Selection of random resources

$content = '';

$entities = elgg_extract('entities', $vars, 3);
$title = elgg_extract('title', $vars, elgg_echo("knowledge_database:latestresources"));
$class = elgg_extract('class', $vars, 'knowledge_database-resources-showcase');

$content = '<div class="' . $class . '">';

// Showcase database resources
if ($title) { $content .= '<h3>' . $title . '</h3>'; }

foreach($entities as $ent) {
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

