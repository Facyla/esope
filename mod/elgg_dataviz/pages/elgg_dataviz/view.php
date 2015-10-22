<?php
/**
 * View a dataviz
 *
 */

$library = get_input('library');
$viztype = get_input('viztype');

// Set data root URLs
$data_url = elgg_get_site_url() . "mod/elgg_dataviz/data/$library/";
$dataurl = elgg_get_site_url() . "dataviz/data/$library/$viztype";

elgg_push_breadcrumb(elgg_echo('elgg_dataviz'), '/dataviz');
elgg_push_breadcrumb(elgg_echo("elgg_dataviz:library:$library"), "/dataviz/view/$library");
if (!empty($viztype)) { elgg_push_breadcrumb(elgg_echo($viztype)); }

// Define page title
$title = elgg_echo("elgg_dataviz:library:$library");
if (!empty($viztype)) {
	$title .= '&nbsp;: ' . elgg_echo("elgg_dataviz:viztype:$viztype");
}


switch($library) {
	case 'chartjs':
		elgg_require_js('elgg.dataviz.chartjs');
		switch ($viztype) {
			case 'bar': $content .= elgg_view('elgg_dataviz/chartjs/bar', array('')); break;
			case 'doughnut': $content .= elgg_view('elgg_dataviz/chartjs/doughnut', array('')); break;
			case 'line': $content .= elgg_view('elgg_dataviz/chartjs/line', array('')); break;
			case 'line-customTooltips': $content .= elgg_view('elgg_dataviz/chartjs/line-customTooltips', array('')); break;
			case 'pie': $content .= elgg_view('elgg_dataviz/chartjs/pie', array('')); break;
			case 'pie-customTooltips': $content .= elgg_view('elgg_dataviz/chartjs/pie-customTooltips', array('')); break;
			case 'polar-area': $content .= elgg_view('elgg_dataviz/chartjs/polar-area', array('')); break;
			case 'radar': $content .= elgg_view('elgg_dataviz/chartjs/radar', array('')); break;
			default: $content .= elgg_view('elgg_dataviz/chartjs/bar', array('')); break;
		}
		break;
	
	case 'dygraphs':
		elgg_require_js('elgg.dataviz.dygraphs');
		switch ($viztype) {
			case 'line_chart':
			default: $content .= elgg_view('elgg_dataviz/dygraphs/line_chart', array('')); break;
		}
		break;
	
	case 'vega':
		//elgg_require_js('elgg.dataviz.d3'); // Vega requires D3
		elgg_require_js('elgg.dataviz.vega');
		switch ($viztype) {
			case 'bar_chart':
			default: $content .= elgg_view('elgg_dataviz/vega/bar_chart', array('')); break;
		}
		break;
	
	case 'crossfilter':
		elgg_require_js('elgg.dataviz.crossfilter');
		break;
	
	case 'raphael':
		elgg_require_js('elgg.dataviz.raphael');
		switch ($viztype) {
			case 'sample_clock': $content .= elgg_view('elgg_dataviz/raphael/sample_clock', array('')); break;
			case 'sample':
			default: $content .= elgg_view('elgg_dataviz/raphael/sample', array('')); break;
		}
		break;
	
	case 'nvd3':
		//elgg_require_js('elgg.dataviz.d3');
		elgg_load_css('elgg:dataviz:nvd3');
		elgg_require_js('elgg.dataviz.nvd3');
		switch ($viztype) {
			case 'bar_chart': $content .= elgg_view('elgg_dataviz/nvd3/bar_chart', array('')); break;
			case 'multibar_chart': $content .= elgg_view('elgg_dataviz/nvd3/multibar_chart', array('')); break;
			case 'pie_chart':
			default: $content .= elgg_view('elgg_dataviz/nvd3/pie_chart', array('')); break;
		}
		break;
	
	case 'd3':
		elgg_require_js('elgg.dataviz.d3');
		// D3 samples
		// Call a view corresponding to a visualisation
			switch($viztype) {
	
				case 'd3js_cfl' :
					$content = elgg_view('elgg_dataviz/d3/collapsible_force_layout',array('dataurl' => $dataurl));
					break;
	
				case 'd3js_bubble' :
					$content = elgg_view('elgg_dataviz/d3/bubble_chart',array('dataurl' => $dataurl));
					break;
	
				case 'd3js_circle' :
					$content = elgg_view('elgg_dataviz/d3/circle_packing',array('dataurl' => $dataurl));
					break;
	
				case 'd3js_scatter' :
					$data_url .= 'scatter_data.tsv';
					$content = elgg_view('elgg_dataviz/d3/scatter_plot',array('dataurl' => $data_url));
					break;
	
				case 'd3js_line' :
					$data_url .= 'line_chart_data.tsv';
					$content = elgg_view('elgg_dataviz/d3/line_chart',array('dataurl' => $data_url));
					break;
	
				case 'd3js_sdg' :
					$data_url .= 'sdg_data.js';
					$content = elgg_view('elgg_dataviz/d3/stack_density_graph',array('dataurl' => $data_url));
					break;
	
				case 'd3js_radar' :
					// 1er exemple
					$data = array();
					$description = "Comparaison de devices";
					/*
					Name of the compared variables
					They need to have the same number of axes and the same axes's name
					Variable's name order have to be the same of the declaration order of axes
					*/
					$typeName = array("Smartphone","Tablets","Test");
					$objects = json_encode($typeName);
					/*
					Data displayed of the axes
					All the data possess the same structure : 'axis'=>"Name of the variable" and 'value'=> "Value of the varible"
					The name of the axes have to be the same
					*/
					$data[] = array(
						array("axis"=>"Email","value"=>0.30),
						array("axis"=>"Social Networks","value"=>0.56),
						array("axis"=>"Internet Banking","value"=>0.42),
						array("axis"=>"News Sportsites","value"=>0.34)
						);
					$data[] = array(array("axis"=>"Email","value"=>0.48),array("axis"=>"Social Networks","value"=>0.41),array("axis"=>"Internet Banking","value"=>0.27),array("axis"=>"News Sportsites","value"=>0.28));
					$data[] = array(array("axis"=>"Email","value"=>0.4),array("axis"=>"Social Networks","value"=>0.4),array("axis"=>"Internet Banking","value"=>0.2),array("axis"=>"News Sportsites","value"=>0.2));
					$data = json_encode($data);
					$content = elgg_view('elgg_dataviz/d3/radar_chart', array('data' => $data,'objects' => $objects,'description' => $description, 'size' => 0.5));
					
					// 2e exemple
					$data = array();
					$description = "Radar générique multi-critères";
					// New set of data
					$objects = json_encode(array("Object 1","Object 2"));
					$data[] = array(array("axis"=>"Criteria A","value"=>0.28),array("axis"=>"Criteria B","value"=>0.51),array("axis"=>"Criteria C","value"=>0.37),array("axis"=>"Criteria D","value"=>0.7),array("axis"=>"Criteria E","value"=>0.62),array("axis"=>"Criteria F","value"=>0.3),array("axis"=>"Criteria G","value"=>0.42));
					$data[] = array(array("axis"=>"Criteria A","value"=>0.4),array("axis"=>"Criteria B","value"=>0.29),array("axis"=>"Criteria C","value"=>0.15),array("axis"=>"Criteria D","value"=>0.8),array("axis"=>"Criteria E","value"=>0.35),array("axis"=>"Criteria F","value"=>0.4),array("axis"=>"Criteria G","value"=>0.5));
					$data = json_encode($data);
					$content .= elgg_view('elgg_dataviz/d3/radar_chart', array('data' => $data,'objects' => $objects,'description' => $description, 'size' => 0.5));
					break;
				
				case 'd3js_pie' :
					$content = elgg_view('elgg_dataviz/d3/pie_chart', array('dataurl' => $dataurl));
					break;
			}
		break;
	
	default:
		register_error("Aucune visualisation choisie");
		forward('dataviz');
}




// Compose page content
$sidebar = elgg_view('elgg_dataviz/sidebar');
$body = elgg_view_layout('one_sidebar', array(
	'content' => '<div id="elgg-dataviz-wrapper"><div class="dataviz-' . $library . '-' . $viztype . '">' . $content . '</div></div>',
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

