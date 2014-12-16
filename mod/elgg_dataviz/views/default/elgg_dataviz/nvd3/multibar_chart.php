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
	var chart = nv.models.multiBarChart()
		.transitionDuration(350)
		.reduceXTicks(true)	 //If \'false\', every single x-axis tick label will be rendered.
		.rotateLabels(0)			//Angle to rotate x-axis labels.
		.showControls(true)	 //Allow user to switch between \'Grouped\' and \'Stacked\' mode.
		.groupSpacing(0.1)		//Distance between each group of bars.
		;

	chart.xAxis
		.tickFormat(d3.format(\',f\'));

	chart.yAxis
		.tickFormat(d3.format(\',.1f\'));

	d3.select("#' . $id . ' svg")
		.datum(data_' . $id . '())
		.call(chart);
	
	nv.utils.windowResize(chart.update);
	
	return chart;
});

//Generate some nice data.
function data_' . $id . '() {
	return stream_layers(3,10+Math.random()*100,.1).map(function(data, i) {
		return {
			key: \'Stream #\' + i,
			values: data
		};
	});
}

/* Inspired by Lee Byron\'s test data generator. */
function stream_layers(n, m, o) {
	if (arguments.length < 3) o = 0;
	function bump(a) {
		var x = 1 / (.1 + Math.random()),
				y = 2 * Math.random() - .5,
				z = 10 / (.1 + Math.random());
		for (var i = 0; i < m; i++) {
			var w = (i / m - y) * z;
			a[i] += x * Math.exp(-w * w);
		}
	}
	return d3.range(n).map(function() {
			var a = [], i;
			for (i = 0; i < m; i++) a[i] = o + o * Math.random();
			for (i = 0; i < 5; i++) bump(a);
			return a.map(stream_index);
		});
}

/* Another layer generator using gamma distributions. */
function stream_waves(n, m) {
	return d3.range(n).map(function(i) {
		return d3.range(m).map(function(j) {
				var x = 20 * j / m - i / 3;
				return 2 * x * Math.exp(-.5 * x);
			}).map(stream_index);
		});
}

function stream_index(d, i) {
	return {x: i, y: Math.max(0, d)};
}
</script>';

echo $content;

