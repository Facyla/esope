<?php
// Pie Chart with custom Tooltips

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
		{value: 300, color: "#F7464A", highlight: "#FF5A5E", label: "Red"}, 
		{value: 50, color: "#46BFBD", highlight: "#5AD3D1", label: "Green"}, 
		{value: 100, color: "#FDB45C", highlight: "#FFC870", label: "Yellow"}, 
		{ value: 40, color: "#949FB1", highlight: "#A8B3C5", label: "Grey"}, 
		{value: 120, color: "#4D5360", highlight: "#616774", label: "Dark Grey"}
	]';
}

$content = '';
$content .= '<div style="width:50px; height:50px; margin-top: 50px; text-align: center;">
		<canvas id="' . $id . '1" style="width:50px; height:50px;" />
	</div>
	<div style="width:' . $width . '; height="' . $height . ';">
		<canvas id="' . $id . '2" style="width:' . $width . '; height="' . $height . ';" />
	</div>
	<div id="' . $id . '-tooltip"></div>';
?>

<style>
#canvas-holder {
	width: 100%;
	margin-top: 50px;
	text-align: center;
}
#<?php echo $id; ?>-tooltip {
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
#<?php echo $id; ?>-tooltip.below {
	-webkit-transform: translate(-50%, 0);
	transform: translate(-50%, 0);
}
#<?php echo $id; ?>-tooltip.below:before {
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
#<?php echo $id; ?>-tooltip.above {
	-webkit-transform: translate(-50%, -100%);
	transform: translate(-50%, -100%);
}
#<?php echo $id; ?>-tooltip.above:before {
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
var chart_options_customTooltips = function(tooltip) {
	// Tooltip Element
	var tooltipEl = $('#<?php echo $id; ?>-tooltip');

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
	var ctx1 = document.getElementById("<?php echo $id; ?>1").getContext("2d");
	window.myPie = new Chart(ctx1).Pie(pieData, {customTooltips: chart_options_customTooltips});

	var ctx2 = document.getElementById("<?php echo $id; ?>2").getContext("2d");
	window.myPie = new Chart(ctx2).Pie(pieData, {customTooltips: chart_options_customTooltips});
};
</script>

<?php echo $content; ?>

