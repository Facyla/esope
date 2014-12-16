<?php
/**
 * Elgg Dataviz home page
 *
 * @package ElggDataviz
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('dataviz'));
*/
global $CONFIG;
$view_url = $CONFIG->url . 'dataviz/view/';

$title = elgg_echo('elgg_dataviz:index');

$content = '';

$content .= '<h3>' . 'Bibliothèques de visualisation' . '</h3>';

$content .= '<p><a href="' . $view_url . 'd3" class="elgg-button elgg-button-action">D3</a> generic visualisation library</p>';
$content .= '<p><a href="' . $view_url . 'nvd3" class="elgg-button elgg-button-action">NVD3</a> reusable charts based on D3. http://nvd3.org/</p>';
$content .= '<p><a href="' . $view_url . 'vega" class="elgg-button elgg-button-action">Vega</a> visualisation grammar. "Vega provides a higher-level visualization specification language on top of D3". https://github.com/trifacta/vega/wiki/</p>';
//$content .= '<p><a href="' . $view_url . 'datawrapper" class="elgg-button elgg-button-action">DataWrapper</a> visualisation tool (process)</p>';
$content .= '<p><a href="' . $view_url . 'dygraphs" class="elgg-button elgg-button-action">Dygraphs</a> charting library http://dygraphs.com/</p>';
$content .= '<p><a href="' . $view_url . 'crossfilter" class="elgg-button elgg-button-action">Crossfilter</a> Fast Multidimensional Filtering for Coordinated Views</p>';
$content .= '<p><a href="' . $view_url . 'raphael" class="elgg-button elgg-button-action">Raphaël</a> SVG visualisations</p>';
$content .= '<br />';
$content .= '<br />';


$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

