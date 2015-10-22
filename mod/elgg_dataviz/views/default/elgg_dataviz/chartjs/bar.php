<?php
// Bar chart

elgg_require_js('elgg.dataviz.chartjs');

$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Generic data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "100%");
$height = elgg_extract('height', $vars, "400px");

$id = dataviz_id('dataviz_');

/* JS Data structure : 
 * Nb of data must match nb of labels
 * Multiple datasets allowed (grouped bar per label)
 * 
 * Example :
	$js_data = '{
		labels : ["Label 1","Label 2","etc."],
		datasets : [
			{
				data : [val1,val2,etc.]
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
			},
			{ (other dataset) }
		]
	}';
 */

// $data = array('serie_key' => array(key1' => 'val1', 'key2' => 'val2'));
if (empty($js_data) && $data) {
	/* @TODO : transform generic data to view-specific data
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
	$js_data'{
		labels : [' . implode(', ', $js_labels) . '],
		datasets : [' . implode(', ', $js_data) . ']
	}
	';
	$js_data = json_encode(array(
			'labels' => $labels,
			'datasets' => $data,
		));
	*/
} else {
	// Demo data
	$js_data = '{
		labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
			}
		]
	}';
}

$content = '';
$content .= '<div style="width:' . $width . '; height="' . $height . ';">
		<canvas id="' . $id . '" style="width:' . $width . '; height="' . $height . ';"></canvas>
	</div>';
?>

<script>
require(["elgg.dataviz.chartjs"], function(d3) {
	// Used only for demo
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = <?php echo $js_data; ?>;

	var ctx = document.getElementById("<?php echo $id; ?>").getContext("2d");
	new Chart(ctx).Bar(barChartData, {
		responsive : true
	});
});
</script>

<?php echo $content; ?>

