<?php
/*
 * $data : should be a generic data structure, processed here to fit into the dataviz
*/

$data = elgg_extract('data', $vars);
$dataurl = elgg_extract('dataurl', $vars);
$width = elgg_extract('width', $vars, "400px");
$height = elgg_extract('height', $vars, "500px");

$id = dataviz_id('dataviz_');


$js_data = '';
// $data = array('key1' => 'val1', 'key2' => 'val2');
if ($data) {
	foreach ($data as $key => $val) {
		$js_data[] = '{"label": "' . $key . '", "value" : ' . $val . '}';
	}
	$js_data = '[' . implode(', ', $js_data) . ']';
} else {
	// @TODO : process data URL if no data
	$js_data = '';
}
if (empty($js_data)) {
	$js_data = '[
		{"label": "One", "value" : 29.765957771107}, 
		{"label": "Two", "value" : 0}, 
		{"label": "Three", "value" : 32.807804682612}, 
		{"label": "Four", "value" : 196.45946739256}, 
		{"label": "Five", "value" : 0.19434030906893}, 
		{"label": "Six", "value" : 98.079782601442}, 
		{"label": "Seven", "value" : 13.925743130903}, 
		{"label": "Eight", "value" : 5.1387322875705}
		]';
}


$content = '<div id="' . $id . '"><svg style="height:' . $height . '; width:' . $width . ';"></svg></div>
<script type="text/javascript">
// Regular pie chart example
nv.addGraph(function() {
	var chart = nv.models.pieChart()
		.x(function(d) { return d.label })
		.y(function(d) { return d.value })
	// Add labels on the pie chart
		.showLabels(false);
	
	d3.select("#' . $id . ' svg")
		.datum(data_' . $id . '())
		.transition().duration(350)
		.call(chart);
	return chart;
});

// Pie chart data. Note how there is only a single array of key-value pairs.
function data_' . $id . '() {
	return ' . $js_data . ';
}
</script>';

echo $content;

