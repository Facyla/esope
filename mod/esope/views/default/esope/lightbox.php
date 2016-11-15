<?php
/* Easing view for lightbox */

$title = elgg_extract('title', $vars, '<i class="fa fa-expand"></i>');
$href = elgg_extract('href', $vars, '');
$class = elgg_extract('class', $vars, '');
if (empty($title) || empty($href)) { return; }

elgg_load_js('lightbox');
elgg_load_css('lightbox');

echo elgg_view('output/url', array(
			'text' => $title,
			'href' => $href,
			'class' => 'elgg-lightbox esope-lightbox-toggle ' . $class,
		));

