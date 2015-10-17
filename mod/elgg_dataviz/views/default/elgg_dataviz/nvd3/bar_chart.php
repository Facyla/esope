<?php
/*
 * $data : should be a generic data structure, processed here to fit into the dataviz
*/

$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "100%");
$height = elgg_extract('height', $vars, "400px");

$id = dataviz_id('dataviz_');

// $data = array('serie_key' => array(key1' => 'val1', 'key2' => 'val2'));
if (empty($js_data) && $data) {
	foreach ($data as $serie_key => $serie_data) {
		$js_data_serie = array();
		foreach ($serie_data as $key => $val) {
			$js_data_serie[] = '{"label": "' . $key . '", "value" : ' . $val . '}';
		}
		$js_data[] = '{
				key: "' . $serie_key . '",
				values: [' . implode(', ', $js_data_serie) . ']
			}';
	}
	$js_data = '[' . implode(', ', $js_data) . ']';
} else {
	// @TODO : process data URL if no data
	$js_data = '';
}
if (empty($js_data)) {
	$js_data = '[ 
		{
			key: "Cumulative Return",
			values: [
				{"label" : "A Label" , "value" : -29.765957771107} , 
				{"label" : "B Label" , "value" : 0} , 
				{"label" : "C Label" , "value" : 32.807804682612} , 
				{"label" : "D Label" , "value" : 196.45946739256} , 
				{"label" : "E Label" , "value" : 0.19434030906893} , 
				{"label" : "F Label" , "value" : -98.079782601442} , 
				{"label" : "G Label", "value" : -13.925743130903} , 
				{"label" : "H Label", "value" : -5.1387322875705}
			]
		}
	]';
}


$content = '<div id="' . $id . '" style="height:' . $height . '; width:' . $width . ';"><svg style="height:' . $height . '; width:' . $width . ';"></svg></div>
<script type="text/javascript">
nv.addGraph(function() {
	// x, y : Specify the data accessors.
	// tooltips : Don\'t show tooltips
	// staggerLabels : Too many bars and not enough room? Try staggering labels.
	// showValues : ...instead, show the bar value right on top of each bar.
	var chart = nv.models.discreteBarChart()
		.x(function(d) { return d.label })
		.y(function(d) { return d.value })
		.staggerLabels(true)
		.tooltips(true)
		.showValues(true)
		;
	
	d3.select("#' . $id . ' svg")
		.datum(data_' . $id . '())
		.transition().duration(350)
		.call(chart);
	
	nv.utils.windowResize(chart.update);
	
	return chart;
});

//Each bar represents a single discrete quantity.
function data_' . $id . '() {
	return ' . $js_data . ';
}
</script>';

echo $content;

