<?php
/* CoinSlider display slider
 * CoinSlider is an image slider
 * Documentation : http://workshop.rs/projects/coin-slider/
 * Github : https://github.com/kopipejst/coin-slider
 */

// JS
elgg_require_js('slider.coinslider.js');
// CSS
elgg_require_css('slider.coinslider.css');


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

// @TODO : content for this slider requires a specific structure
//$slider_content = str_replace(array('<li', '</li>'), array('<a href="javascript:void(0);"', '</a>'), $slider_content);

/*
<div id='coin-slider'>
  <a href="img01_url" target="_blank">
    <img src='img01.jpg' >
    <span>
      Description for img01
    </span>
  </a>
  ......
  ......
  <a href="imgN_url">
    <img src='imgN.jpg' >
    <span>
      Description for imgN
    </span>
  </a>
</div>

width: 565, // width of slider panel
height: 290, // height of slider panel
spw: 7, // squares per width
sph: 5, // squares per height
delay: 3000, // delay between images in ms
sDelay: 30, // delay beetwen squares in ms
opacity: 0.7, // opacity of title and navigation
titleSpeed: 500, // speed of title appereance in ms
effect: '', // random, swirl, rain, straight
navigation: true, // prev next and buttons
links : true, // show images as links
hoverPause: true // pause on hover
*/


echo <<<HTML
<!-- Slider #$id -->
<script type="text/javascript">
require(['jquery', 'slider.coinslider'], function ($, coinslider) {
	$('#$id').coinslider();
});
</script>

<style>
</style>

<div id="$id" style="$container_style">
	$slider_content
</div>
<!-- END Slider #$id -->
HTML;


