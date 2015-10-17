<?php
// Line Chart with Custom Tooltips
elgg_load_js('elgg:dataviz:chartjs');
// <script src="../Chart.js"></script>
// <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


$js_data = elgg_extract('jsdata', $vars, false); // Ready to use JS data
$data = elgg_extract('data', $vars); // Normalized data structure
$dataurl = elgg_extract('dataurl', $vars); // Data source
$width = elgg_extract('width', $vars, "600px");
$height = elgg_extract('height', $vars, "400px");

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
}

$content = '';
$content .= '<canvas id="' . $dataviz_id . '" height="' . $height . '" width="' . $width . '"></canvas>';
?>

<style>
#canvas-holder1 {
    width: 300px;
    margin: 20px auto;
}
#canvas-holder2 {
    width: 50%;
    margin: 20px 25%;
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
.chartjs-tooltip-key{
	display:inline-block;
	width:10px;
	height:10px;
}
</style>


<div id="canvas-holder1">
    <canvas id="<?php echo $dataviz_id; ?>1" width="300" height="30" />
</div>
<div id="canvas-holder2">
    <canvas id="<?php echo $dataviz_id; ?>2" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
</div>

<div id="chartjs-tooltip"></div>


<script>

Chart.defaults.global.pointHitDetectionRadius = 1;
Chart.defaults.global.customTooltips = function(tooltip) {

    var tooltipEl = $('#chartjs-tooltip');

    if (!tooltip) {
        tooltipEl.css({
            opacity: 0
        });
        return;
    }

    tooltipEl.removeClass('above below');
    tooltipEl.addClass(tooltip.yAlign);

    var innerHtml = '';
    for (var i = tooltip.labels.length - 1; i >= 0; i--) {
    	innerHtml += [
    		'<div class="chartjs-tooltip-section">',
    		'	<span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
    		'	<span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
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
var lineChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
        label: "My First dataset",
        fillColor: "rgba(220,220,220,0.2)",
        strokeColor: "rgba(220,220,220,1)",
        pointColor: "rgba(220,220,220,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }, {
        label: "My Second dataset",
        fillColor: "rgba(151,187,205,0.2)",
        strokeColor: "rgba(151,187,205,1)",
        pointColor: "rgba(151,187,205,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }]
};

window.onload = function() {
    var ctx1 = document.getElementById("<?php echo $dataviz_id; ?>1").getContext("2d");
    window.myLine = new Chart(ctx1).Line(lineChartData, {
    	showScale: false,
    	pointDot : true,
        responsive: true
    });

    var ctx2 = document.getElementById("<?php echo $dataviz_id; ?>2").getContext("2d");
    window.myLine = new Chart(ctx2).Line(lineChartData, {
        responsive: true
    });
};
</script>


