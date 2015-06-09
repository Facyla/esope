<?php
/*
Taken from http://bl.ocks.org/mbostock/3887235#index.html
*/

$liburl = $vars['url'] . 'mod/elgg_d3js/data/';
$dataurl = elgg_extract('dataurl', $vars, $vars['url'] . 'd3js/data');

global $elgg_d3js_unique_id;
if(!isset($elgg_d3js_unique_id)) $elgg_d3js_unique_id = 1;
else $elgg_d3js_unique_id++;
$id = 'd3js_chart_' . $elgg_d3js_unique_id;

// Dimensions
$w = elgg_extract('width', $vars, 500);
$h = elgg_extract('height', $vars, 400);

$content = '<div id="' . $id . '" style="display:inline-block;"></div>

<script>
var width = ' . $w . ',
    height = ' . $h . ',
    radius = Math.min(width, height) / 2;

var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00", "#7D74FE","#7DFF26","#F84F1B","#28D8D5","#FB95B6","#9D9931","#F12ABF","#27EA88","#549AD5","#FEA526","#7B8D8B","#BB755F","#432E16", "#D75CFB","#44E337","#51EBE3","#ED3D24","#4069AE","#E1CC72","#E33E88","#D8A3B3","#428B50","#66F3A3","#E28A2A","#B2594D","#609297","#E8F03F","#3D2241", "#954EB3","#6A771C","#58AE2E","#75C5E9","#BBEB85","#A7DAB9","#6578E6","#932C5F","#865A26","#CC78B9","#2E5A52","#8C9D79","#9F6270","#6D3377","#551927","#DE8D5A", "#E3DEA8","#C3C9DB","#3A5870","#CD3B4F","#E476E3","#DCAB94","#33386D","#4DA284","#817AA5","#8D8384","#624F49","#8E211F","#9E785B","#355C22","#D4ADDE", "#A98229","#E88B87","#28282D","#253719","#BD89E1","#EB33D8","#6D311F","#DF45AA","#E86723","#6CE5BC","#765175","#942C42","#986CEB","#8CC488","#8395E3", "#D96F98","#9E2F83","#CFCBB8","#4AB9B7","#E7AC2C","#E96D59","#929752","#5E54A9","#CCBA3F","#BD3CB8","#408A2C","#8AE32E","#5E5621","#ADD837","#BE3221","#8DA12E", "#3BC58B","#6EE259","#52D170","#D2A867","#5C9CCD","#DB6472","#B9E8E0","#CDE067","#9C5615","#536C4F","#A74725","#CBD88A","#DF3066","#E9D235","#EE404C","#7DB362", "#B1EDA3","#71D2E1","#A954DC","#91DF6E","#CB6429","#D64ADC"]);
    

var arc= d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.size; });

var svg' . $elgg_d3js_unique_id . ' = d3.select("#' . $id . '").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

d3.json("' . $dataurl . '", function(error, data) {

  data.forEach(function(d) {
    d.size = +d.size;
  });

  var g = svg' . $elgg_d3js_unique_id . '.selectAll(".arc")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.name); });

  g.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.data.name; });

  g.append("title")
      .text(function(d) { return d.data.name; });


	// @TODO : Test ajout Nom au survol
	var focus = svg.append("g")
			.attr("class", "focus")
			.style("display", "none");

	focus.append("text")
			.attr("x", 9)
			.attr("dy", ".35em");

	svg.append("rect")
			.attr("class", "overlay")
			.attr("width", width)
			.attr("height", height)
			.on("mouseover", function() { focus.style("display", null); })
			.on("mouseout", function() { focus.style("display", "none"); })
			.on("mousemove", mousemove);

	function mousemove() {
		focus.select("text").text(function(d) { return d.data.name; });
	}
	// Fin test

});
</script>';

echo $content;

