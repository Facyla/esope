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
	$js_data = $data;
} else {
	// JSON data URL if no data
	$js_data = $dataurl;
}



//$content = '<div id="' . $id . '" style="height:' . $height . '; width:' . $width . ';"></div>
$content = '<div id="' . $id . '"></div>
<script type="text/javascript">
// Creates canvas width=320 × height=200 at x=200, y=300
var paper = Raphael(200, 300, 320, 200);
paper.attr("fill", "#00f");

// Creates circle at x = 200, y = 100, with radius 80
var circle = paper.circle(200, 100, 80);
// Sets the fill attribute of the circle to red (#f00)
circle.attr("fill", "#f00");

// Sets the stroke attribute of the circle to white
circle.attr("stroke", "#fff");

window.onload = function () {
	var paper = Raphael("' . $id . '", 640, 480),
		btn = document.getElementById("run"),
		cd = document.getElementById("code");

	(btn.onclick = function () {
		paper.clear();
		paper.rect(0, 0, 640, 480, 10).attr({fill: "#fff", stroke: "none"});
		try {
			(new Function("paper", "window", "document", cd.value)).call(paper, paper);
		} catch (e) {
			alert(e.message || e);
		}
	})();
};
</script>';

echo $content;

