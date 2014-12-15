<?php
/**
 * Elgg Dataviz home page
 *
 * @package ElggDataviz
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('dataviz'));
*/
global $CONFIG;
$view_url = $CONFIG->url . 'dataviz/view/';

$library = get_input('library');

$title = elgg_echo('elgg_dataviz:index');

$content = '';

$content .= '<h3>' . 'Bibliothèques de visualisation' . '</h3>';

$content .= '<p><a href="?library=d3" class="elgg-button elgg-button-action">D3</a> generic visualisation library</p>';
$content .= '<p><a href="?library=nvd3" class="elgg-button elgg-button-action">NVD3</a> reusable charts based on D3. http://nvd3.org/</p>';
$content .= '<p><a href="?library=vega" class="elgg-button elgg-button-action">Vega</a> visualisation grammar. "Vega provides a higher-level visualization specification language on top of D3". https://github.com/trifacta/vega/wiki/</p>';
//$content .= '<p><a href="?library=datawrapper" class="elgg-button elgg-button-action">DataWrapper</a> visualisation tool (process)</p>';
$content .= '<p><a href="?library=dygraphs" class="elgg-button elgg-button-action">Dygraphs</a> charting library http://dygraphs.com/</p>';
$content .= '<p><a href="?library=crossfilter" class="elgg-button elgg-button-action">Crossfilter</a> Fast Multidimensional Filtering for Coordinated Views</p>';
$content .= '<p><a href="?library=raphael" class="elgg-button elgg-button-action">Raphaël</a> SVG visualisations</p>';
$content .= '<br />';
$content .= '<br />';


if (!empty($library)) {
	$content .= '<h3>' . 'Bibliothèque ' . $library . '</h3>';
}

switch($library) {
	case 'dygraphs':
		elgg_load_js('elgg:dataviz:dygraphs');
		$content .= '<div id="dataviz-dygraph"></div>
			<script type="text/javascript">
			g = new Dygraph(
				// containing div
				document.getElementById("dataviz-dygraph"),
				// CSV or path to a CSV file.
				"Date,Temperature,Wind\n" +
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
				"2008-05-18,79,5\n"
			);
			</script>';

		break;
	
	case 'vega':
		elgg_load_js('elgg:dataviz:d3'); // Vega requires D3
		elgg_load_js('elgg:dataviz:vega');
		$content .= '<div id="dataviz-vega"></div>
			<script type="text/javascript">
			// parse a spec and create a visualization view
			function parse(spec) {
				vg.parse.spec(spec, function(chart) { chart({el:"#dataviz-vega"}).update(); });
			}
			parse("' . $CONFIG->url . 'mod/elgg_dataviz/data/vega/basic.json");
			</script>';
		break;
	
	case 'crossfilter':
		elgg_load_js('elgg:dataviz:crossfilter');
		break;
	
	case 'raphael':
		elgg_load_js('elgg:dataviz:raphael');
		$content .= '<div id="dataviz-raphael"></div>
			<script type="text/javascript">
			// Creates canvas 320 × 200 at 200, 300
			var paper = Raphael(200, 300, 320, 200);

			// Creates circle at x = 100, y = 70, with radius 80
			var circle = paper.circle(100, 70, 80);
			// Sets the fill attribute of the circle to red (#f00)
			circle.attr("fill", "#f00");

			// Sets the stroke attribute of the circle to white
			circle.attr("stroke", "#fff");
			
			window.onload = function () {
				var paper = Raphael("dataviz-raphael", 640, 480),
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
		break;
	
	case 'nvd3':
		elgg_load_js('elgg:dataviz:d3');
		elgg_load_css('elgg:dataviz:nvd3');
		elgg_load_js('elgg:dataviz:nvd3');
		$content .= elgg_view('elgg_dataviz/nvd3/pie_chart', array(''));
		break;
	
	case 'd3':
		elgg_load_js('elgg:dataviz:d3');
		// D3 samples
		$content .= '<p><a href="' . $view_url . 'd3/d3js_cfl" class="elgg-button elgg-button-action">Collapsible force layout</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_sdg" class="elgg-button elgg-button-action">Stack density graph</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_radar" class="elgg-button elgg-button-action">Radar chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_bubble" class="elgg-button elgg-button-action">Bubble chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_scatter" class="elgg-button elgg-button-action">Scatter plot</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_circle" class="elgg-button elgg-button-action">Circle packing</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_pie" class="elgg-button elgg-button-action">Pie chart</a></p>';
		$content .= '<p><a href="' . $view_url . 'd3/d3js_line" class="elgg-button elgg-button-action">Line chart</a></p>';
		break;
	
	default:
		
}




$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

