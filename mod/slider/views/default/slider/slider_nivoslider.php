<?php
/* NivoSlider display slider
 * This slider is best used for images, optionnaly with HTML caption
 * Documentation : http://docs.dev7studios.com/jquery-plugins/nivo-slider
 * Github : https://github.com/gilbitron/Nivo-Slider
 */

// JS
elgg_require_js('slider.nivoslider.js');
// CSS
elgg_require_css('slider.nivoslider.css');


// Slider parameters
$slider_theme = elgg_extract('theme', $vars, 'cs-portfolio'); // slider theme
$id = elgg_extract('id', $vars); // Slider container width
$slider_content = elgg_extract('content', $vars); // Complete content - except the first-level <ul> tag (we could use an array instead..)
$js_params = elgg_extract('js_params', $vars); // JS additional parameters
$css_main = elgg_extract('css_main', $vars); // CSS for main ul tag
$css_textslide = elgg_extract('css_textslide', $vars); // CSS for li .textslide
$height = elgg_extract('height', $vars); // Slider container height
$width = elgg_extract('width', $vars); // Slider container width

$container_style = '';
if ($height) $container_style .= "height:$height; ";
if ($width) $container_style .= "width:$width; ";

// @TODO : this slider requires a custom content structure

/*
<div id="slider" class="nivoSlider">
	<img src="images/slide1.jpg" alt="" />
	<a href="http://dev7studios.com"><img src="images/slide2.jpg" alt="" title="#htmlcaption" /></a>
	<img src="images/slide3.jpg" alt="" title="This is an example of a caption" />
	<img src="images/slide4.jpg" alt="" />
</div>
<div id="htmlcaption" class="nivo-html-caption">
	<strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
</div>

$('#slider').nivoSlider({
    effect: 'random',                 // Specify sets like: 'fold,fade,sliceDown'
    slices: 15,                     // For slice animations
    boxCols: 8,                     // For box animations
    boxRows: 4,                     // For box animations
    animSpeed: 500,                 // Slide transition speed
    pauseTime: 3000,                 // How long each slide will show
    startSlide: 0,                     // Set starting Slide (0 index)
    directionNav: true,             // Next & Prev navigation
    controlNav: true,                 // 1,2,3... navigation
    controlNavThumbs: false,         // Use thumbnails for Control Nav
    pauseOnHover: true,             // Stop animation while hovering
    manualAdvance: false,             // Force manual transitions
    prevText: 'Prev',                 // Prev directionNav text
    nextText: 'Next',                 // Next directionNav text
    randomStart: false,             // Start on a random slide
    beforeChange: function(){},     // Triggers before a slide transition
    afterChange: function(){},         // Triggers after a slide transition
    slideshowEnd: function(){},     // Triggers after all slides have been shown
    lastSlide: function(){},         // Triggers when last slide is shown
    afterLoad: function(){}         // Triggers when slider has loaded
});

Effects : sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft, fold, fade, random, slideInRight, slideInLeft, boxRandom, boxRain, boxRainReverse, boxRainGrow, boxRainGrowReverse
*/


echo <<<HTML
<!-- Slider #$id -->
<script type="text/javascript">
require(['jquery', 'slider.nivoslider'], function ($, nivoSlider) {
	$('#$id').nivoSlider();
});
</script>

<style>
</style>

<ul id="$id" style="$container_style">
	$slider_content
</ul>
<!-- END Slider #$id -->
HTML;


