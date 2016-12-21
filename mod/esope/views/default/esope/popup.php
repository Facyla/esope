<?php
/* Easing view for popup (unstyled) */

$title = elgg_extract('title', $vars, '<i class="fa fa-expand"></i>');
$content = elgg_extract('content', $vars, '');
$class = elgg_extract('class', $vars, '');
$link_class = elgg_extract('link_class', $vars, '');

if (empty($content)) { return; }

$id = esope_unique_id('elgg-toggle-');

echo elgg_view('output/url', array(
			'text' => $title,
			'href' => "#$id",
			'rel' => 'popup',
			'class' => 'esope-popup-toggle ' . $link_class,
		));
echo '<div class="hidden ' . $class . '" id="' . $id . '">' . $content . '</div>';

