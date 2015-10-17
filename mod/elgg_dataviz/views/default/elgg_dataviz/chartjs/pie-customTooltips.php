<?php
// Pie Chart with Custom Tooltips</title>
elgg_load_js('elgg:dataviz:chartjs');
// <script src="../Chart.js"></script>
// <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "300px");
$height = elgg_extract('height', $vars, "300px");

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
	$js_data = '[{
  value: 300,
  color: "#F7464A",
  highlight: "#FF5A5E",
  label: "Red"
}, {
  value: 50,
  color: "#46BFBD",
  highlight: "#5AD3D1",
  label: "Green"
}, {
  value: 100,
  color: "#FDB45C",
  highlight: "#FFC870",
  label: "Yellow"
}, {
  value: 40,
  color: "#949FB1",
  highlight: "#A8B3C5",
  label: "Grey"
}, {
  value: 120,
  color: "#4D5360",
  highlight: "#616774",
  label: "Dark Grey"
}]';
}

$content = '';
$content .= '<canvas id="' . $dataviz_id . '1" height="50" width="50"></canvas>
<canvas id="' . $dataviz_id . '2" height="' . $height . '" width="' . $width . '"></canvas>
<canvas id="' . $dataviz_id . '-tooltip" height="' . $height . '" width="' . $width . '"></canvas>';

/*
<div id="canvas-holder">
	<canvas id="<?php echo $dataviz_id; ?>1" width="50" height="50" />
</div>
<div id="canvas-holder">
	<canvas id="<?php echo $dataviz_id; ?>2" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
</div>
<div id="<?php echo $dataviz_id; ?>-tooltip"></div>
*/
?>

<style>
#canvas-holder {
	width: 100%;
	margin-top: 50px;
	text-align: center;
}
#chartjs-tooltip {
	opacity: 1;
	position: absolute;
	background: rgba(0, 0, 0, .7);
	color: white;
	padding: 3px;
	border-radius: 3px;
	-webkit-transition: all .1s ease;
	transition: all .1s ease;
	pointer-events: none;
	-webkit-transform: translate(-50%, 0);
	transform: translate(-50%, 0);
}
#chartjs-tooltip.below {
	-webkit-transform: translate(-50%, 0);
	transform: translate(-50%, 0);
}
#chartjs-tooltip.below:before {
	border: solid;
	border-color: #111 transparent;
	border-color: rgba(0, 0, 0, .8) transparent;
	border-width: 0 8px 8px 8px;
	bottom: 1em;
	content: "";
	display: block;
	left: 50%;
	position: absolute;
	z-index: 99;
	-webkit-transform: translate(-50%, -100%);
	transform: translate(-50%, -100%);
}
#chartjs-tooltip.above {
	-webkit-transform: translate(-50%, -100%);
	transform: translate(-50%, -100%);
}
#chartjs-tooltip.above:before {
	border: solid;
	border-color: #111 transparent;
	border-color: rgba(0, 0, 0, .8) transparent;
	border-width: 8px 8px 0 8px;
	bottom: 1em;
	content: "";
	display: block;
	left: 50%;
	top: 100%;
	position: absolute;
	z-index: 99;
	-webkit-transform: translate(-50%, 0);
	transform: translate(-50%, 0);
}
</style>


<script>
Chart.defaults.global.customTooltips = function(tooltip) {
	// Tooltip Element
	var tooltipEl = $('#<?php echo $dataviz_id; ?>-tooltip');

	// Hide if no tooltip
	if (!tooltip) {
		tooltipEl.css({opacity: 0});
		return;
	}

	// Set caret Position
	tooltipEl.removeClass('above below');
	tooltipEl.addClass(tooltip.yAlign);

	// Set Text
	tooltipEl.html(tooltip.text);

	// Find Y Location on page
	var top;
	if (tooltip.yAlign == 'above') {
		top = tooltip.y - tooltip.caretHeight - tooltip.caretPadding;
	} else {
		top = tooltip.y + tooltip.caretHeight + tooltip.caretPadding;
	}

	// Display, position, and set styles for font
	tooltipEl.css({
		opacity: 1,
		left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
		top: tooltip.chart.canvas.offsetTop + top + 'px',
		fontFamily: tooltip.fontFamily,
		fontSize: tooltip.fontSize,
		fontStyle: tooltip.fontStyle,
	});
};

var pieData = <?php echo $js_data; ?>;

window.onload = function() {
	var ctx1 = document.getElementById("<?php echo $dataviz_id; ?>1").getContext("2d");
	window.myPie = new Chart(ctx1).Pie(pieData);

	var ctx2 = document.getElementById("<?php echo $dataviz_id; ?>2").getContext("2d");
	window.myPie = new Chart(ctx2).Pie(pieData);
};
</script>


