<?php
/* Responsiveslides display slider
 * Nice for lightweight responsive content slider, without much interface
 * Documentation : http://responsiveslides.com/
 */

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


/*
<ul class="rslides">
  <li><img src="1.jpg" alt=""></li>
  <li><img src="2.jpg" alt=""></li>
  <li><img src="3.jpg" alt=""></li>
</ul>

$(".rslides").responsiveSlides({
  auto: true,             // Boolean: Animate automatically, true or false
  speed: 500,            // Integer: Speed of the transition, in milliseconds
  timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
  pager: false,           // Boolean: Show pager, true or false
  nav: false,             // Boolean: Show navigation, true or false
  random: false,          // Boolean: Randomize the order of the slides, true or false
  pause: false,           // Boolean: Pause on hover, true or false
  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  prevText: "Previous",   // String: Text for the "previous" button
  nextText: "Next",       // String: Text for the "next" button
  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
  manualControls: "",     // Selector: Declare custom pager navigation
  namespace: "rslides",   // String: Change the default namespace used
  before: function(){},   // Function: Before callback
  after: function(){}     // Function: After callback
});
*/


echo <<<HTML
<!-- Slider #$id -->
<script type="text/javascript">
$(function(){
	$("#$id").responsiveSlides({
		auto: true,             // Boolean: Animate automatically, true or false
		speed: 500,            // Integer: Speed of the transition, in milliseconds
		timeout: 3000,          // Integer: Time between slide transitions, in milliseconds
		pager: false,           // Boolean: Show pager, true or false
		nav: false,             // Boolean: Show navigation, true or false
		random: false,          // Boolean: Randomize the order of the slides, true or false
		pause: true,           // Boolean: Pause on hover, true or false
		pauseControls: true,    // Boolean: Pause when hovering controls, true or false
		prevText: "Previous",   // String: Text for the "previous" button
		nextText: "Next",       // String: Text for the "next" button
		maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
		navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
		manualControls: "",     // Selector: Declare custom pager navigation
		namespace: "rslides",   // String: Change the default namespace used
		before: function(){},   // Function: Before callback
		after: function(){}     // Function: After callback
	});
});
</script>

<style>
</style>

<ul id="$id" style="$container_style">
	$slider_content
</ul>
<!-- END Slider #$id -->
HTML;


