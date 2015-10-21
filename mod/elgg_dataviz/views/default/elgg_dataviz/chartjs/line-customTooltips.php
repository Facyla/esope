<?php
// Line Chart with custom Tooltips

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
	$js_data = '{
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
			{
				label: "My First dataset",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
			}, 
			{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
			}
		]
	}';
}

$content = '';
$content .= '<div style="width:' . $width . '; height:50px;">
		<canvas id="' . $id . '1" style="width:' . $width . '; height:50px;" />
	</div>
	<div style="width:' . $width . '; height="' . $height . ';">
		<canvas id="' . $id . '2" style="width:' . $width . '; height="' . $height . ';" />
	</div>
	<div id="' . $id . '-tooltip"></div>';
?>

<style>
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
.<?php echo $id; ?>-tooltip-key{
	display:inline-block;
	width:10px;
	height:10px;
}
</style>

<script>
require(["elgg.dataviz.chartjs"], function(d3) {
	var chart_options_pointHitDetectionRadius = 1;
	var chart_options_customTooltips = function(tooltip) {
		var tooltipEl = $('#<?php echo $id; ?>-tooltip');

		if (!tooltip) {
			tooltipEl.css({opacity: 0});
			return;
		}

		tooltipEl.removeClass('above below');
		tooltipEl.addClass(tooltip.yAlign);

		var innerHtml = '';
		for (var i = tooltip.labels.length - 1; i >= 0; i--) {
			innerHtml += [
				'<div class="<?php echo $id; ?>-tooltip-section">',
				'	<span class="<?php echo $id; ?>-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
				'	<span class="<?php echo $id; ?>-tooltip-value">' + tooltip.labels[i] + '</span>',
				'</div>'
			].join('');
		}
		tooltipEl.html(innerHtml);

		tooltipEl.css({
			opacity: 1,
			left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
			top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
			fontFamily: tooltip.fontFamily,
			fontSize: tooltip.fontSize,
			fontStyle: tooltip.fontStyle,
		});
	};

	var randomScalingFactor = function() {
		return Math.round(Math.random() * 100);
	};
	var lineChartData = <?php echo $js_data; ?>;

	// First graph : very small, no scale
	var ctx1 = document.getElementById("<?php echo $id; ?>1").getContext("2d");
	new Chart(ctx1).Line(lineChartData, {
		showScale: false,
		pointDot : false,
		responsive: true,
		pointHitDetectionRadius: chart_options_pointHitDetectionRadius,
		customTooltips: chart_options_customTooltips
	});

	// Second graph : regular size
	var ctx2 = document.getElementById("<?php echo $id; ?>2").getContext("2d");
	new Chart(ctx2).Line(lineChartData, {
		responsive: true,
		pointHitDetectionRadius: chart_options_pointHitDetectionRadius,
		customTooltips: chart_options_customTooltips
	});
});
</script>

<?php echo $content; ?>

