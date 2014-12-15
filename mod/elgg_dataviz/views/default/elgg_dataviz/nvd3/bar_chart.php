<?php
/*
 * $data : should be a generic data structure, processed here to fit into the dataviz
*/

$data = elgg_extract('data', $vars);
$dataurl = elgg_extract('dataurl', $vars);
$width = elgg_extract('width', $vars, "100%");
$height = elgg_extract('height', $vars, "400px");

$id = dataviz_id('dataviz_');


$js_data = '';
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


$content = '<div id="' . $id . '" style="height:' . $height . '; width:' . $width . ';"><svg></svg></div>
<script type="text/javascript">
nv.addGraph(function() {
	var chart = nv.models.discreteBarChart()
		.x(function(d) { return d.label })    //Specify the data accessors.
		.y(function(d) { return d.value })
		.staggerLabels(true)    //Too many bars and not enough room? Try staggering labels.
		.tooltips(false)        //Don\'t show tooltips
		.showValues(true)       //...instead, show the bar value right on top of each bar.
		.transitionDuration(350)
		;
	
	d3.select("#' . $id . ' svg")
		.datum(data_' . $id . '())
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

