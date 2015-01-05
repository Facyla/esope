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
<div><textarea id="' . $id . '_code">paper.circle(320, 240, 60).animate({fill: "#223fa3", stroke: "#000", "stroke-width": 80, "stroke-opacity": 0.5}, 2000);</textarea></div>
<div><button id="' . $id . '_run" type="button">Run</button></div>
<script type="text/javascript">
window.onload = function () {
	var paper = Raphael("' . $id . '", 640, 480),
		btn = document.getElementById("' . $id . '_run"),
		cd = document.getElementById("' . $id . '_code");

	(btn.onclick = function () {
		paper.clear();
		paper.rect(0, 0, 640, 480, 10).attr({fill: "#ccf", stroke: "none"});
		try {
			(new Function("paper", "window", "document", cd.value)).call(paper, paper);
		} catch (e) {
			alert(e.message || e);
		}
	})();
};
</script>';

echo $content;

