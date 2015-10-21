<?php
// Pie chart

elgg_require_js('elgg.dataviz.chartjs');

$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "100%");
$height = elgg_extract('height', $vars, "400px");

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
	// Demo data
	$js_data = '[
		{value: 300, color:"#F7464A", highlight: "#FF5A5E", label: "Red"},
		{value: 50, color: "#46BFBD", highlight: "#5AD3D1", label: "Green"},
		{value: 100, color: "#FDB45C", highlight: "#FFC870", label: "Yellow"},
		{value: 40, color: "#949FB1", highlight: "#A8B3C5", label: "Grey"},
		{value: 120, color: "#4D5360", highlight: "#616774", label: "Dark Grey"}
	]';
}

$content = '';
$content .= '<div style="width:' . $width . '; height="' . $height . ';">
		<canvas id="' . $id . '" style="width:' . $width . '; height="' . $height . ';"></canvas>
	</div>';
?>

<script>
require(["elgg.dataviz.chartjs"], function(d3) {
	var pieData = <?php echo $js_data; ?>;

	var ctx = document.getElementById("<?php echo $id; ?>").getContext("2d");
	new Chart(ctx).Pie(pieData);
});
</script>

<?php echo $content; ?>

