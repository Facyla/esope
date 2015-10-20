<?php
/*
Taken from http://mbostock.github.io/d3/talk/20111116/pack-hierarchy.html
*/

$liburl = elgg_get_site_url() . 'mod/elgg_dataviz/data/d3/';
$dataurl = elgg_extract('dataurl', $vars, elgg_get_site_url() . 'dataviz/data/d3/');

$id = dataviz_id('dataviz_');

$width = elgg_extract('width', $vars, "600");
$height = elgg_extract('height', $vars, "600");

$content = '<div id="' . $id . '"></div>

<style>
#' . $id . ' text { font-size: 9px; pointer-events: none; }
#' . $id . ' text.parent { font-size: 16px; fill: #1f77b4;}
#' . $id . ' circle { fill: #ccc; stroke: #999; pointer-events: all; }
#' . $id . ' circle.parent { fill: #1f77b4; fill-opacity: .1; stroke: steelblue; }
#' . $id . ' circle.parent:hover { stroke: #ff7f0e; stroke-width: .5px; }
#' . $id . ' circle.child { pointer-events: none;}
</style>

<script>
require(["elgg.dataviz.d3"], function(d3) {
	
	// Zoomable version
	var w = ' . $width . ',
			h = ' . $height . ',
			r = ' . (min($height, $width)-60) . ',
			x = d3.scale.linear().range([0, r]),
			y = d3.scale.linear().range([0, r]),
			node,
			root;

	var pack = d3.layout.pack()
			.size([r, r])
			.value(function(d) { return d.size; })

	var vis = d3.select("#' . $id . '").insert("svg:svg", "h2")
			.attr("width", w)
			.attr("height", h)
		.append("svg:g")
			.attr("transform", "translate(" + (w - r) / 2 + "," + (h - r) / 2 + ")");

	d3.json("' . $dataurl . '", function(data) {
		node = root = data;

		var nodes = pack.nodes(root);

		vis.selectAll("circle")
				.data(nodes)
			.enter().append("svg:circle")
				.attr("class", function(d) { return d.children ? "parent" : "child"; })
				.attr("cx", function(d) { return d.x; })
				.attr("cy", function(d) { return d.y; })
				.attr("r", function(d) { return d.r; })
				.on("click", function(d) { return zoom(node == d ? root : d); });

		vis.selectAll("text")
				.data(nodes)
			.enter().append("svg:text")
				.attr("class", function(d) { return d.children ? "parent" : "child"; })
				.attr("x", function(d) { return d.x; })
				.attr("y", function(d) { return d.y; })
				.attr("dy", ".35em")
				.attr("text-anchor", "middle")
				.style("opacity", function(d) { return d.r > 20 ? 1 : 0; })
				.text(function(d) { return d.name; });

		d3.select(window).on("click", function() { zoom(root); });
	});

	function zoom(d, i) {
		var k = r / d.r / 2;
		x.domain([d.x - d.r, d.x + d.r]);
		y.domain([d.y - d.r, d.y + d.r]);

		var t = vis.transition()
				.duration(d3.event.altKey ? 7500 : 750);

		t.selectAll("circle")
				.attr("cx", function(d) { return x(d.x); })
				.attr("cy", function(d) { return y(d.y); })
				.attr("r", function(d) { return k * d.r; });

		t.selectAll("text")
				.attr("x", function(d) { return x(d.x); })
				.attr("y", function(d) { return y(d.y); })
				.style("opacity", function(d) { return k * d.r > 20 ? 1 : 0; });

		node = d;
		d3.event.stopPropagation();
	}
	
	/* Basic version
	var diameter = ' . $width . ',
		format = d3.format(",d");

	var pack = d3.layout.pack()
		.size([diameter - 4, diameter - 4])
		.value(function(d) { return d.size; });

	var svg = d3.select("#' . $id . '").append("svg")
		.attr("width", diameter)
		.attr("height", diameter)
	.append("g")
		.attr("transform", "translate(2,2)");

	d3.json("' . $dataurl . '", function(error, root) {
		var node = svg.datum(root).selectAll(".node")
			.data(pack.nodes)
		.enter().append("g")
			.attr("class", function(d) { return d.children ? "node" : "leaf node"; })
			.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

		node.append("title")
			.text(function(d) { return d.name + (d.children ? "" : ": " + format(d.size)); });

		node.append("circle")
			.attr("r", function(d) { return d.r; });

		node.filter(function(d) { return !d.children; }).append("text")
			.attr("dy", ".3em")
			.style("text-anchor", "middle")
			.text(function(d) { return d.name.substring(0, d.r / 3); });
	});

	d3.select(self.frameElement).style("height", diameter + "px");
	*/
	
});
</script>';

echo $content;

