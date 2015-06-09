<?php
/*
Taken from http://bl.ocks.org/mbostock/4063269#index.html
*/

$liburl = $vars['url'] . 'mod/elgg_d3js/data/';
$dataurl = elgg_extract('dataurl', $vars, $vars['url'] . 'd3js/data');

global $elgg_d3js_unique_id;
if(!isset($elgg_d3js_unique_id)) $elgg_d3js_unique_id = 1;
else $elgg_d3js_unique_id++;
$id = 'd3js_chart_' . $elgg_d3js_unique_id;

$width = elgg_extract('width', $vars, "960");

$content = '<div id="' . $id . '"></div>
<script>
var diameter = ' . $width . ',
    format = d3.format(",d"),
    color = d3.scale.category20c();

var bubble = d3.layout.pack()
    .sort(null)
    .size([diameter, diameter])
    .padding(1.5);

var svg = d3.select("#' . $id . '").append("svg")
    .attr("width", diameter)
    .attr("height", diameter)
    .attr("class", "bubble");

d3.json("' . $dataurl . '", function(error, root) {
  var node = svg.selectAll(".node")
      .data(bubble.nodes(classes(root))
      .filter(function(d) { return !d.children; }))
    .enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  node.append("title")
      .text(function(d) { return d.className + ": " + format(d.value); });

  node.append("circle")
      .attr("r", function(d) { return d.r; })
      .style("fill", function(d) { return color(d.packageName); });

  node.append("text")
      .attr("dy", ".3em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.className.substring(0, d.r / 3); });
});

// Returns a flattened hierarchy containing all leaf nodes under the root.
function classes(root) {
  var classes = [];

  function recurse(name, node) {
    if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
    else classes.push({packageName: name, className: node.name, value: node.size});
  }

  recurse(null, root);
  return {children: classes};
}

d3.select(self.frameElement).style("height", diameter + "px");

</script>';

echo $content;
