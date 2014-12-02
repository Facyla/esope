<?php
/**
 * Elgg Dataviz home page
 *
 * @package ElggDataviz
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('d3js'));
*/
global $CONFIG;
$view_url = $CONFIG->url . 'dataviz/view/';

$library = get_input('library');

$title = elgg_echo('elgg_dataviz:index');

$content = '';


switch($library) {
	case 'dygraphs':
		elgg_load_js('elgg:dataviz:dygraphs');
		break;
	
	case 'vega':
		elgg_load_js('elgg:dataviz:vega');
		break;
	
	case 'crossfilter':
		elgg_load_js('elgg:dataviz:crossfilter');
		break;
	
	case 'nvd3':
		elgg_load_js('elgg:dataviz:nvd3');
		break;
	
	default:
	case 'd3':
		elgg_load_js('elgg:dataviz:d3');
		// D3 samples
		$content .= '<p><a href="' . $view_url . 'd3/d3js_cfl" class="elgg-button elgg-button-action">Collapsible force layout</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_sdg" class="elgg-button elgg-button-action">Stack density graph</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_radar" class="elgg-button elgg-button-action">Radar chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_bubble" class="elgg-button elgg-button-action">Bubble chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_scatter" class="elgg-button elgg-button-action">Scatter plot</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_circle" class="elgg-button elgg-button-action">Circle packing</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_pie" class="elgg-button elgg-button-action">Pie chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_line" class="elgg-button elgg-button-action">Line chart</a></p>';
		break;
}




$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

