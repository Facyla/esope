<?php
/* Note : Custom CSS are dynamically loaded, as they should NOT rely on cache (this would break per-view settings)
 * This view can be cached
*/

$imgroot = elgg_get_site_url() . 'mod/slider/graphics/';
$include_url = dirname(dirname(dirname(dirname(__FILE__)))) . '/vendors/anythingslider/';
$vendor_url = elgg_get_site_url() . 'mod/slider/vendors/anythingslider/';

include($include_url . 'css/animate.css');
?>

<?php
// Vendor CSS cannot be included and are directly added below because relative URLs for images won't match otherwise...
//include($include_url . 'css/anythingslider.css');
?>

/* Main plugin styles (editor) */
.slider-edit-slide { margin-top: 0.5ex; min-height:2ex; border:1px solid #ccc; padding:0ex 1ex 1ex 1ex; border-radius: 6px; background: rgba(0,0,0,0.05); }
.slider-edit-highlight { margin-bottom: 1ex; border:1px dashed grey; padding:0.5ex 1ex; height:5ex; }



/*
	AnythingSlider v1.8+ Default theme
	By Chris Coyier: http://css-tricks.com
	with major improvements by Doug Neiner: http://pixelgraphics.us/
	based on work by Remy Sharp: http://jqueryfordesigners.com/
*/

/*****************************
  SET DEFAULT DIMENSIONS HERE
 *****************************/
/* change the ID & dimensions to match your slider */
#slider {
	width: 700px;
	height: 390px;
	list-style: none;
	/* Prevent FOUC (see FAQ page) and keep things readable if javascript is disabled */
	overflow-y: auto;
	overflow-x: hidden;
}

/******************
  SET STYLING HERE
 ******************
 =================================
 Default state (no keyboard focus)
 ==================================*/
/* Overall Wrapper */
.anythingSlider-default {
	margin: 0 auto;
	/* 45px right & left padding for the arrows, 28px @ bottom for navigation */
	padding: 0 45px 28px 45px;
}
/* slider window - top & bottom borders, default state */
.anythingSlider-default .anythingWindow {
	border-top: 3px solid #777;
	border-bottom: 3px solid #777;
}
/* Navigation buttons + start/stop button, default state */
.anythingSlider-default .anythingControls a {
	/* top shadow */
	background: #777 url(<?php echo $vendor_url; ?>images/default.png) center -288px repeat-x;
	color: #000;
	border-radius: 0 0 5px 5px;
	-moz-border-radius: 0 0 5px 5px;
	-webkit-border-radius: 0 0 5px 5px;
}
/* Make sure navigation text is visible */
.anythingSlider-default .anythingControls a span {
	visibility: visible;
}
/* Navigation current button, default state */
.anythingSlider-default .anythingControls a.cur {
	background: #888;
	color: #000;
}

/* start-stop button, stopped, default state */
.anythingSlider-default .anythingControls a.start-stop {
	background-color: #040;
	color: #ddd;
}
/* start-stop button, playing, default state */
.anythingSlider-default .anythingControls a.start-stop.playing {
	background-color: #800;
}

/* start-stop button, default hovered text color (when visible) */
/* hide nav/start-stop background image shadow on hover - makes the button appear to come forward */
.anythingSlider-default .anythingControls a.start-stop:hover,
.anythingSlider-default .anythingControls a.start-stop.hover,
.anythingSlider-default .anythingControls a.start-stop .anythingControls ul a:hover {
	background-image: none;
	color: #ddd;
}

/*
 =================================
 Active State (has keyboard focus)
 =================================
*/
/* slider window - top & bottom borders, active state */
.anythingSlider-default.activeSlider .anythingWindow {
	border-color: #7C9127;
}
/* Navigation buttons, active state */
.anythingSlider-default.activeSlider .anythingControls a {
	/* background image = top shadow */
	background-color: #7C9127;
}
/* Navigation current & hovered button, active state */
.anythingSlider-default.activeSlider .anythingControls a.cur,
.anythingSlider-default.activeSlider .anythingControls a:hover {
	/* background image removed */
	background: #7C9127;
}

/* start-stop button, stopped, active state */
.anythingSlider-default.activeSlider .anythingControls a.start-stop {
	background-color: #080;
	color: #fff;
}
/* start-stop button, playing, active state */
.anythingSlider-default.activeSlider .anythingControls a.start-stop.playing {
	background-color: #d00;
	color: #fff;
}
/* start-stop button, active slider hovered text color (when visible) */
.anythingSlider-default.activeSlider .start-stop:hover,
.anythingSlider-default.activeSlider .start-stop.hover {
	color: #fff;
}

/************************
  NAVIGATION POSITIONING
 ************************/
/* Navigation Arrows */
.anythingSlider-default .arrow {
	top: 50%;
	position: absolute;
	display: block;
}

.anythingSlider-default .arrow a {
	display: block;
	width: 45px;
	height: 140px;
	margin: -70px 0 0 0; /* half height of image */
	text-align: center;
	outline: 0;
	background: url(<?php echo $vendor_url; ?>images/default.png) no-repeat;
}

/* back arrow */
.anythingSlider-default .back { left: 0; }
.anythingSlider-default .back a { background-position: left top; }
.anythingSlider-default .back a:hover,
.anythingSlider-default .back a.hover { background-position: left -140px; }
/* forward arrow */
.anythingSlider-default .forward { right: 0; }
.anythingSlider-default .forward a { background-position: right top; }
.anythingSlider-default .forward a:hover,
.anythingSlider-default .forward a.hover { background-position: right -140px; }

/* Navigation Links */
.anythingSlider-default .anythingControls { outline: 0; display: none; }
.anythingSlider-default .anythingControls ul { margin: 0; padding: 0; float: left; }
.anythingSlider-default .anythingControls ul li { display: inline; }
.anythingSlider-default .anythingControls ul a {
	font: 11px/18px Georgia, Serif;
	display: inline-block;
	text-decoration: none;
	padding: 2px 8px;
	height: 18px;
	margin: 0 5px 0 0;
	text-align: center;
	outline: 0;
}

/* navigationSize window */
.anythingSlider-default .anythingControls .anythingNavWindow {
	overflow: hidden;
	float: left;
}

/* Autoplay Start/Stop button */
.anythingSlider-default .anythingControls .start-stop {
	padding: 2px 5px;
	width: 40px;
	text-align: center;
	text-decoration: none;
	float: right;
	z-index: 100;
	outline: 0;
}

/***********************
  IE8 AND OLDER STYLING
 ***********************/

/* Navigation Arrows */
.as-oldie .anythingSlider-default .arrow {
	top: 30%;
}
.as-oldie .anythingSlider-default .arrow a {
	margin: 0;
}

/* margin between nav buttons just looks better */
.as-oldie .anythingSlider-default .anythingControls li {
	margin-left: 3px;
}

/* When using the navigationSize option, the side margins need to be zero
	None of the navigation panels look good in IE7 now =( */
.as-oldie .anythingSlider-default .anythingControls a {
	margin: 0;
}
.as-oldie .anythingSlider-default .anythingNavWindow {
	margin: 0 2px;
}
.as-oldie .anythingSlider-default .anythingNavWindow li {
	padding: 3px 0 0 0;
}

/***********************
  COMMON SLIDER STYLING
 ***********************/
/* Overall Wrapper */
.anythingSlider {
	display: block;
	overflow: visible !important;
	position: relative;
}
/* anythingSlider viewport window */
.anythingSlider .anythingWindow {
	overflow: hidden;
	position: relative;
	width: 100%;
	height: 100%;
}
/* anythingSlider base (original element) */
.anythingSlider .anythingBase {
	background: transparent;
	list-style: none;
	position: absolute;
	overflow: visible !important;
	top: 0;
	left: 0;
	margin: 0;
	padding: 0;
}

/* Navigation arrow text; indent moved to span inside "a", for IE7;
  apparently, a negative text-indent on an "a" link moves the link as well as the text */
.anythingSlider .arrow span {
	display: block;
	visibility: hidden;
}
/* disabled arrows, hide or reduce opacity: opacity: .5; filter: alpha(opacity=50); */
.anythingSlider .arrow.disabled {
	display: none;
}
/* all panels inside the slider; horizontal mode */
.anythingSlider .panel {
	background: transparent;
	display: block;
	overflow: hidden;
	float: left;
	padding: 0;
	margin: 0;
}
/* vertical mode */
.anythingSlider .vertical .panel {
	float: none;
}
/* fade mode */
.anythingSlider .fade .panel {
	float: none;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 0;
}
/* fade mode active page - visible & on top */
.anythingSlider .fade .activePage {
	z-index: 1;
}

/***********************
  RTL STYLING
 ***********************/
/* slider autoplay right-to-left, reverse order of nav links to look better */
.anythingSlider.rtl .anythingWindow {
	direction: ltr;
	unicode-bidi: bidi-override;
}
.anythingSlider.rtl .anythingControls ul { float: left; } /* move nav link group to left */
.anythingSlider.rtl .anythingControls ul a { float: right; } /* reverse order of nav links */
.anythingSlider.rtl .start-stop { /* float: right; */ } /* move start/stop button - in case you want to switch sides */

/* probably not necessary, but added just in case */
.anythingSlider,
.anythingSlider .anythingWindow,
.anythingSlider .anythingControls ul a,
.anythingSlider .arrow a,
.anythingSlider .start-stop {
	transition-duration: 0;
	-o-transition-duration: 0;
	-moz-transition-duration: 0;
	-webkit-transition-duration: 0;
}



<?php
//include($include_url . 'css/theme-metallic.css');
?>
/*
	AnythingSlider v1.8+ Metallic theme
	By Rob Garrison
*/
/*****************************
  SET DEFAULT DIMENSIONS HERE
 *****************************/
/* change the ID & dimensions to match your slider */
#slider {
	width: 700px;
	height: 390px;
	list-style: none;
	/* Prevent FOUC (see FAQ page) and keep things readable if javascript is disabled */
	overflow-y: auto;
	overflow-x: hidden;
}

/******************
  SET STYLING HERE
 ******************
 =================================
 Default state (no keyboard focus)
 ==================================*/
/* Overall Wrapper */
.anythingSlider-metallic {
	margin: 0 auto;
	/* 23px right & left padding for the navigation arrows */
	padding: 0 23px;
}
/* slider window - top & bottom borders, default state */
.anythingSlider-metallic .anythingWindow {
	border-top: 3px solid #333;
	border-bottom: 3px solid #333;
}
/* Navigation buttons + start/stop button, default state */
.anythingSlider-metallic .anythingControls a {
	background: transparent url(<?php echo $vendor_url; ?>images/arrows-metallic.png) -68px -40px repeat-x;
	color: #000;
	border: #000 1px solid;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
/* Navigation current button, default state */
.anythingSlider-metallic .anythingControls a.cur,
.anythingSlider-metallic .anythingControls a:hover {
	background-position: -70px -137px;
	background-color: #888;
	color: #000;
}

/* start-stop button, stopped, default state */
.anythingSlider-metallic .anythingControls a.start-stop {
	background: #040;
	color: #ddd;
	/* top shadow */
	-moz-box-shadow: inset 1px 2px 5px rgba(0, 0, 0, 0.5);
	-webkit-box-shadow: inset 1px 2px 5px rgba(0, 0, 0, 0.5);
	box-shadow: inset 1px 2px 5px rgba(0, 0, 0, 0.5);
}
/* start-stop button, playing, default state */
.anythingSlider-metallic .anythingControls a.start-stop.playing {
	background-color: #800;
}

/* start-stop button, default hovered text color (when visible) */
/* hide nav/start-stop background image shadow on hover - makes the button appear to come forward */
.anythingSlider-metallic .anythingControls a.start-stop:hover,
.anythingSlider-metallic .anythingControls a.start-stop.hover,
.anythingSlider-metallic .anythingControls a.start-stop .anythingControls ul a:hover {
	color: #fff;
	/* clear top shadow */
	-moz-box-shadow: inset 0 0 0 #000000;
	-webkit-box-shadow: inset 0 0 0 #000000;
	box-shadow: inset 0 0 0 #000000;
}

/*
 =================================
 Active State (has keyboard focus)
 =================================
*/
/* slider window - top & bottom borders, active state */
.anythingSlider-metallic.activeSlider .anythingWindow {
	border-color: #0355a3;
}

/* Navigation buttons, active state */
.anythingSlider-metallic.activeSlider .anythingControls a {
	background-color: transparent;
}
/* Navigation current button, active state */
.anythingSlider-metallic.activeSlider .anythingControls a.cur,
.anythingSlider-metallic.activeSlider .anythingControls a:hover {
	background-position: -76px -57px;
	background-color: #ccc;
}

/* start-stop button, stopped, active state */
.anythingSlider-metallic.activeSlider .anythingControls a.start-stop {
	background: #080;
	color: #fff;
}
/* start-stop button, playing, active state */
.anythingSlider-metallic.activeSlider .anythingControls a.start-stop.playing {
	color: #fff;
	background: #d00;
}
/* start-stop button, active slider hovered text color (when visible) */
.anythingSlider-metallic.activeSlider .start-stop:hover,
.anythingSlider-metallic.activeSlider .start-stop.hover {
	color: #fff;
}

/************************
  NAVIGATION POSITIONING
 ************************/
/* Navigation Arrows */
.anythingSlider-metallic .arrow {
	top: 50%;
	position: absolute;
	display: block;
	z-index: 100;
}

.anythingSlider-metallic .arrow a {
	display: block;
	width: 45px;
	height: 95px;
	margin: -47.5px 0 0 0; /* half height of image */
	text-align: center;
	outline: 0;
	background: url(<?php echo $vendor_url; ?>images/arrows-metallic.png) no-repeat;
}

/* back arrow */
.anythingSlider-metallic .back { left: 0; }
.anythingSlider-metallic .back a { background-position: left bottom; }
.anythingSlider-metallic .back a:hover,
.anythingSlider-metallic .back a.hover { background-position: left top; }
/* forward arrow */
.anythingSlider-metallic .forward { right: 0; }
.anythingSlider-metallic .forward a { background-position: right bottom; }
.anythingSlider-metallic .forward a:hover,
.anythingSlider-metallic .forward a.hover { background-position: right top; }

/* Navigation Links */
.anythingSlider-metallic .anythingControls {
	height: 15px; /* limit height, needed for IE9 of all things */
	outline: 0;
	display: none;
	float: right;
	position: absolute;
	bottom: 5px;
	right: 20px;
	margin: 0 45px;
	z-index: 100;
	opacity: 0.90;
	filter: alpha(opacity=90);
}

.anythingSlider-metallic .anythingControls ul {
	margin: 0;
	padding: 0;
	float: left;
}
.anythingSlider-metallic .anythingControls ul li {
	list-style: none;
	float: left;
	margin: 0;
	padding: 0;
}
.anythingSlider-metallic .anythingControls ul a {
	display: inline-block;
	width: 10px;
	height: 10px;
	margin: 3px;
	padding: 0;
	text-decoration: none;
	text-align: center;
	outline: 0;
}

.anythingSlider-metallic .anythingControls span {
	display: block;
	visibility: hidden;
}

/* navigationSize window */
.anythingSlider-metallic .anythingControls .anythingNavWindow {
	overflow: hidden;
	float: left;
}
/* navigationSize nav arrow positioning */
.anythingSlider-metallic .anythingControls li.prev a span,
.anythingSlider-metallic .anythingControls li.next a span {
	visibility: visible;
	position: relative;
	top: -6px; /* bring navigationSize text arrows into view */
	color: #fff;
}

/* Autoplay Start/Stop button */
.anythingSlider-metallic .anythingControls .start-stop {
	display: inline-block;
	width: 10px;
	height: 10px;
	margin: 3px;
	padding: 0;
	text-align: center;
	text-decoration: none;
	z-index: 100;
	outline: 0;
}

/***********************
IE8 AND OLDER STYLING
***********************/
/* Navigation Arrows */
.as-oldie .anythingSlider-metallic .arrow {
	top: 40%;
}
.as-oldie .anythingSlider-metallic .arrow a {
	margin: 0;
}

/***********************
  COMMON SLIDER STYLING
 ***********************/
/* Overall Wrapper */
.anythingSlider {
	display: block;
	overflow: visible !important;
	position: relative;
}
/* anythingSlider viewport window */
.anythingSlider .anythingWindow {
	overflow: hidden;
	position: relative;
	width: 100%;
	height: 100%;
}
/* anythingSlider base (original element) */
.anythingSlider .anythingBase {
	background: transparent;
	list-style: none;
	position: absolute;
	overflow: visible !important;
	top: 0;
	left: 0;
	margin: 0;
	padding: 0;
}

/* Navigation arrow text; indent moved to span inside "a", for IE7;
	apparently, a negative text-indent on an "a" link moves the link as well as the text */
.anythingSlider .arrow span {
	display: block;
	visibility: hidden;
}
/* disabled arrows, hide or reduce opacity: opacity: .5; filter: alpha(opacity=50); */
.anythingSlider .arrow.disabled {
	display: none;
}
/* all panels inside the slider; horizontal mode */
.anythingSlider .panel {
	background: transparent;
	display: block;
	overflow: hidden;
	float: left;
	padding: 0;
	margin: 0;
}
/* vertical mode */
.anythingSlider .vertical .panel {
	float: none;
}

/* fade mode */
.anythingSlider .fade .panel {
	float: none;
	position: absolute;
	top: 0;
	left: 0;
	z-index: 0;
}
/* fade mode active page - visible & on top */
.anythingSlider .fade .activePage {
	z-index: 1;
}

/***********************
  RTL STYLING
 ***********************/
/* slider autoplay right-to-left, reverse order of nav links to look better */
.anythingSlider.rtl .anythingWindow {
	direction: ltr;
	unicode-bidi: bidi-override;
}
.anythingSlider.rtl .anythingControls ul { float: left; } /* move nav link group to left */
.anythingSlider.rtl .anythingControls ul a { float: right; } /* reverse order of nav links */
.anythingSlider.rtl .start-stop { /* float: right; */ } /* move start/stop button - in case you want to switch sides */

/* probably not necessary, but added just in case */
.anythingSlider .anythingWindow,
.anythingSlider .anythingControls ul a,
.anythingSlider .arrow a,
.anythingSlider .start-stop {
	transition-duration: 0;
	-o-transition-duration: 0;
	-moz-transition-duration: 0;
	-webkit-transition-duration: 0;
}


<?php
// Include transitions CSS lib
include($include_url . 'css/animate.css');



