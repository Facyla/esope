/* Visualisations default CSS
 * Override in your theme or plugin using a custom class or id to customise to your needs 
 */


/* Collapsible force layout : .d3js-d3js_cfl */
.d3js-d3js_cfl . circle.node {
  cursor: pointer;
  stroke: #000;
  stroke-width: .5px;
}

.d3js-d3js_cfl line.link {
  fill: none;
  stroke: #9ecae1;
  stroke-width: 1.5px;
}


/* Stack density graph : .d3js-d3js_line */
.d3js-d3js_sdg path{
	fill-opacity:0.8;
	stroke-opacity:0;
}
.d3js-d3js_sdg .vlines, 
.d3js-d3js_sdg .hlines{
	stroke:rgb(150,148,109);
	shape-rendering:crispEdges;
	stroke-width:1px;
	stroke-opacity:0.3;
}
.d3js-d3js_sdg .hlabels line, 
.d3js-d3js_sdg .vlabels line{
	stroke:rgb(150,148,109);
	shape-rendering:crispEdges;
	stroke-width:1px;
	stroke-opacity:0.7;
}
.d3js-d3js_sdg .hlabels text, 
.d3js-d3js_sdg .vlabels text{
	color:rgb(150,148,109);
	font-size:12px;
}

.d3js-d3js_sdg svg{
	display:inline;
	float:left;
	margin-right:2%;
}
.d3js-d3js_sdg .legend{
	display:inline-block;
	margin:0 0 0 10px;
	margin-left:0;
	min-width:190px;
	overflow:auto;
}
.d3js-d3js_sdg .legend table{
	border-collapse:collapse;
	border-spacing:0;
}
.d3js-d3js_sdg .legend tr, 
.d3js-d3js_sdg .legend td, 
.d3js-d3js_sdg .legend div{
	margin:0;
	padding:0;
}
.d3js-d3js_sdg .legend div{
	width:20px;
	height:20px;
	float: left;
}
.d3js-d3js_sdg .legend span{
	padding: 0 5px;
	margin:0
}
.d3js-d3js_sdg .legend tr:hover{
	background:silver;
}
.d3js-d3js_sdg .distquantdiv{
	clear:both;
	padding:10px;
	overflow:hidden;
	margin: 20px;
}
.d3js-d3js_sdg .distquantdiv h3{
	padding-left: 40px;
	margin-bottom:0;
}
.d3js-d3js_sdg .stat{
	font-size:12px;
}


/* Radar chart : .d3js-d3js_radar */


/* Bubble chart : .d3js-d3js_line */
.d3js-d3js_bubble text {
  font: 10px sans-serif;
}


/* Scatter plot : .d3js-d3js_scatter */
.d3js-d3js_scatter {
  font: 10px sans-serif;
}

.d3js-d3js_scatter .axis path,
.d3js-d3js_scatter .axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.d3js-d3js_scatter .dot {
  stroke: #000;
}


/* Circle packing : .d3js-d3js_line */
.d3js-d3js_circle circle {
  fill: rgb(31, 119, 180);
  fill-opacity: .25;
  stroke: rgb(31, 119, 180);
  stroke-width: 1px;
}

.d3js-d3js_circle .leaf circle {
  fill: #ff7f0e;
  fill-opacity: 1;
}

.d3js-d3js_circle .d3js-d3js_circle text {
  font: 10px sans-serif;
}

.d3js-d3js_circle text {
  font-size: 11px;
  pointer-events: none;
}

.d3js-d3js_circle text.parent {
  fill: #1f77b4;
}

.d3js-d3js_circle circle {
  fill: #ccc;
  stroke: #999;
  pointer-events: all;
}

.d3js-d3js_circle circle.parent {
  fill: #1f77b4;
  fill-opacity: .1;
  stroke: steelblue;
}

.d3js-d3js_circle circle.parent:hover {
  stroke: #ff7f0e;
  stroke-width: .5px;
}

.d3js-d3js_circle circle.child {
  pointer-events: none;
}


/* Pie chart : .d3js-d3js_pie */
.d3js-d3js_pie .arc path {
	stroke: #fff;
}



/* Line chart : .d3js-d3js_line */
.d3js-d3js_line .axis path,
.d3js-d3js_line .axis line {
	fill: none;
	stroke: #000;
	shape-rendering: crispEdges;
}

.d3js-d3js_line .x.axis path {
	/* display: none; */
}

.d3js-d3js_line .line {
	fill: none;
	stroke: steelblue;
	stroke-width: 1.5px;
}

.d3js-d3js_line .overlay {
	fill: none;
	pointer-events: all;
}

.d3js-d3js_line .focus circle {
	fill: none;
	stroke: steelblue;
}

.d3js-d3js_line .focus text {
	font-weight: bold;
	text-shadow: 1px 1px 1px #fff;
}

.d3js-d3js_line .focus text {
	font-weight: bold;
	text-shadow: 1px 1px 1px #fff;
}


