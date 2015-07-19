<?php
/* FlexSlider display slider
 * Flex slider is a responsive slider that can be used for images, images + caption or carousel
 * Documentation : http://flexslider.woothemes.com/
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


/* Documentation complète : http://flexslider.woothemes.com/
div class="flexslider">
  <ul class="slides">
    <li>
      <img src="slide1.jpg" />
      <p class="flex-caption">Adventurer Cheesecake Brownie</p>
    </li>
    <li>
      <img src="slide2.jpg" />
      <p class="flex-caption">Adventurer Lemon</p>
    </li>
    <li>
      <img src="slide3.jpg" />
      <p class="flex-caption">Adventurer Donut</p>
    </li>
    <li>
      <img src="slide4.jpg" />
      <p class="flex-caption">Adventurer Caramel</p>
    </li>
  </ul>
</div>
*/



echo <<<HTML
<!-- Slider #$id -->
<script type="text/javascript">
// Can also be used with $(document).ready()
$(window).load(function() {
	$('#$id').flexslider({
		animation: "slide"
	});
});
</script>

<style>
</style>

<div id="$id" style="$container_style">
	<ul class="slides">
		$slider_content
	</ul>
</div>
<!-- END Slider #$id -->
HTML;


