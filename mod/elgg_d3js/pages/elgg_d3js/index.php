<?php
/**
 * Elgg plugin everyone page
 *
 * @package Elggd3js
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('d3js'));
*/
global $CONFIG;
$url = $CONFIG->url . 'd3js/view/';

$content = '';

$content .= '<p><a href="' . $url . 'd3js_cfl" class="elgg-button elgg-button-action">Collapsible force layout</a></p>';
$content .= '<p><a href="' . $url . 'd3js_sdg" class="elgg-button elgg-button-action">Stack density graph</a></p>';
$content .= '<p><a href="' . $url . 'd3js_radar" class="elgg-button elgg-button-action">Radar chart</a></p>';
$content .= '<p><a href="' . $url . 'd3js_bubble" class="elgg-button elgg-button-action">Bubble chart</a></p>';
$content .= '<p><a href="' . $url . 'd3js_scatter" class="elgg-button elgg-button-action">Scatter plot</a></p>';
$content .= '<p><a href="' . $url . 'd3js_circle" class="elgg-button elgg-button-action">Circle packing</a></p>';
$content .= '<p><a href="' . $url . 'd3js_pie" class="elgg-button elgg-button-action">Pie chart</a></p>';
$content .= '<p><a href="' . $url . 'd3js_line" class="elgg-button elgg-button-action">Line chart</a></p>';

$title = elgg_echo('elgg_d3js:everyone');

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);