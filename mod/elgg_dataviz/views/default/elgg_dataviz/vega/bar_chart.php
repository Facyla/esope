<?php
/*
 * $data : should be a generic data structure, processed here to fit into the dataviz
*/

$data = elgg_extract('data', $vars);
$dataurl = elgg_extract('dataurl', $vars);
//$width = elgg_extract('width', $vars, "100%");
//$height = elgg_extract('height', $vars, "400px");

$id = dataviz_id('dataviz_');


$js_data = '';
if ($data) {
	$js_data = $data;
} else {
	// JSON data URL if no data
	$js_data = $dataurl;
}
if (empty($js_data)) {
	$js_data = $CONFIG->url . 'mod/elgg_dataviz/data/vega/basic.json';
}


//$content = '<div id="' . $id . '" style="height:' . $height . '; width:' . $width . ';"></div>
$content = '<div id="' . $id . '"></div>
<script type="text/javascript">
	// parse a spec and create a visualization view
	function parse(spec) {
		vg.parse.spec(spec, function(chart) { chart({el:"#' . $id . '"}).update(); });
	}
	// Load specification file (chart spec + data)
	parse("' . $js_data . '");
</script>';

echo $content;

