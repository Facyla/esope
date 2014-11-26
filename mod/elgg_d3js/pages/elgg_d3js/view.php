<?php
/**
 * View a bookmark
 *
 * @package ElggBookmarks
 */
 global $CONFIG;
$viztype = get_input('viztype',''); 

// Set data root URLs
$data_url = $CONFIG->url . 'mod/elgg_d3js/data/';
$dataurl = $CONFIG->url . 'd3js/data/' . $viztype;

elgg_push_breadcrumb(elgg_echo('elgg_d3js'), '/d3js');
if (!empty($viztype)) elgg_push_breadcrumb(elgg_echo($viztype));

// Load D3 lib
elgg_load_js('elgg:elgg_d3js');


// Call a view corresponding to a visualisation
switch($viztype) {
	
	case 'd3js_cfl' :
		$content = elgg_view('elgg_d3js/collapsible_force_layout',array('dataurl' => $dataurl));
		break;
	
	case 'd3js_bubble' :
		$content = elgg_view('elgg_d3js/bubble_chart',array('dataurl' => $dataurl));
		break;
	
	case 'd3js_circle' :
		$content = elgg_view('elgg_d3js/circle_packing',array('dataurl' => $dataurl));
		break;
	
	case 'd3js_scatter' :
		$data_url .= 'data.tsv';
		$content = elgg_view('elgg_d3js/scatter_plot',array('dataurl' => $data_url));
		break;
	
	case 'd3js_line' :
		$data_url .= 'data2.tsv';
		$content = elgg_view('elgg_d3js/line_chart',array('dataurl' => $data_url));
		break;
	
	case 'd3js_sdg' :
		$data_url .= 'SDGdata.js';
		$content = elgg_view('elgg_d3js/stack_density_graph',array('dataurl' => $data_url));
		break;
	
	case 'd3js_radar' :
			$data = array();
		/*
		Name of the variable compared
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
		
		// New set of data
		$objects2 = json_encode(array("Object 1","Object 2"));
		$data2[] = array(array("axis"=>"Criteria A","value"=>0.28),array("axis"=>"Criteria B","value"=>0.51),array("axis"=>"Criteria C","value"=>0.37),array("axis"=>"Criteria D","value"=>0.7),array("axis"=>"Criteria E","value"=>0.62),array("axis"=>"Criteria F","value"=>0.3),array("axis"=>"Criteria G","value"=>0.42));
		$data2[] = array(array("axis"=>"Criteria A","value"=>0.4),array("axis"=>"Criteria B","value"=>0.29),array("axis"=>"Criteria C","value"=>0.15),array("axis"=>"Criteria D","value"=>0.8),array("axis"=>"Criteria E","value"=>0.35),array("axis"=>"Criteria F","value"=>0.4),array("axis"=>"Criteria G","value"=>0.5));
		$data2 = json_encode($data2);

		//Legend
		$description = "Nombre de membres par groupe :";
		$content = elgg_view('elgg_d3js/radar_chart', array('data' => $data,'objects' => $objects,'description' => $description, 'size' => 0.5));
		$description2 = "Radar générique multi-critères :";
		$content .= elgg_view('elgg_d3js/radar_chart', array('data' => $data2,'objects' => $objects2,'description' => $description2, 'size' => 0.5));
		break;
	
	case 'd3js_pie' :
		$content = elgg_view('elgg_d3js/pie_chart', array('dataurl' => $dataurl));
		$content .= elgg_view('elgg_d3js/pie_chart', array('dataurl' => $dataurl));
		break;
	
	default :
		register_error("Aucune visualisation choisie");
		forward('d3js');
}


// Compose page content
$body = elgg_view_layout('one_column', array(
	'content' => '<div id="elgg-d3js-wrapper"><div class="d3js-' . $viztype . '">' . $content . '</div></div>',
	'title' => $title,
));

echo elgg_view_page($title, $body);

