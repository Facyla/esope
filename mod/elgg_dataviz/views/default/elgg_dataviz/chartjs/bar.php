<?php
// <script src="../Chart.js"></script>
elgg_load_js('elgg:dataviz:chartjs');

$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "600px");
$height = elgg_extract('height', $vars, "450px");

$id = dataviz_id('dataviz_');

// $data = array('serie_key' => array(key1' => 'val1', 'key2' => 'val2'));
if (empty($js_data) && $data) {
	/* @TODO
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
	*/
} else {
	$js_label = '["January","February","March","April","May","June","July"]';
	$js_data = '[
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
	]';
}

$content = '';
$content .= '<canvas id="' . $dataviz_id . '" height="' . $height . '" width="' . $width . '"></canvas>';
?>


<script>
var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

var barChartData = {
	labels : <?php echo $js_label; ?>,
	datasets : <?php echo $js_data; ?>
}
window.onload = function(){
	var ctx = document.getElementById("<?php echo $dataviz_id; ?>").getContext("2d");
	window.myBar = new Chart(ctx).Bar(barChartData, {
		responsive : true
	});
}
</script>


