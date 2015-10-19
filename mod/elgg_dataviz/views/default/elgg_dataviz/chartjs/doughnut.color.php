<?php
// 		<script src="../src/Chart.Core.js"></script>
// 		<script src="../src/Chart.Doughnut.js"></script>
elgg_load_js('elgg:dataviz:chartjs');

$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "500px");
$height = elgg_extract('height', $vars, "500px");

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
	$js_data = '[
		{value: 1, label: "One"},
		{value: 2, label: "Two"},
		{value: 3, label: "Three"},
		{value: 4, label: "Four"},
		{value: 5, label: "Five"}
	]';
}

$content = '';
$content .= '<canvas id="' . $dataviz_id . '" height="' . $height . '" width="' . $width . '"></canvas>';

/*
		<div id="canvas-holder">
			<canvas id="chart-area" width="500" height="500"/>
		</div>
*/
?>

<script>
var doughnutData = <?php echo $js_data; ?>;
window.onload = function(){
	var ctx = document.getElementById("<?php echo $dataviz_id; ?>").getContext("2d");
	window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true});
};
</script>

