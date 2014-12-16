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
	// CSV data URL if no data
	$js_data = $dataurl;
}
if (empty($js_data)) {
	$js_data = '// CSV or path to a CSV file.
		"Date,Température,Force du vent\n" +
		"2008-05-07,75,15\n" +
		"2008-05-08,70,22\n" +
		"2008-05-09,80,7\n" +
		"2008-05-10,85,3\n" +
		"2008-05-11,76,5\n" +
		"2008-05-12,79,6\n" +
		"2008-05-13,74,12\n" +
		"2008-05-14,68,18\n" +
		"2008-05-15,69,16\n" +
		"2008-05-16,67,12\n" +
		"2008-05-17,73,9\n" +
		"2008-05-18,79,5\n"';
}


$content = '<div id="' . $id . '" style="height:' . $height . '; width:' . $width . ';"></div>
<script type="text/javascript">
// Containing div, then CSV or path to CSV data
g = new Dygraph(
	document.getElementById("' . $id . '"),
	' . $js_data . '
);
</script>';

echo $content;

