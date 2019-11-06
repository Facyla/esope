<?php
/* Generic view for slider rendering
 * Does not require any entity
 * Uses : 
 * - vendor : slider vendor library to use
 * - theme : vendor-specific theme
 * - slidercontent : slider content (inner slides as HTML list)
 * - or slides : array of slides content
 * - height : enclosing block height
 * - width : enclosing block width
 * - sliderparams : JS parameters for the slider
 * - slidercss_main : CSS for the enclosing block
 * - slidercss_textslide : CSS for the slides
 */

/* Slider vendors :
 * - AnythingSlider : (default) content slider with a few themes and options
 * - Responsiveslides : lightweight content slider, without much interface
 * - NivoSlider : image slider with many options
 * - FlexSlider : content slider
 * - CoinSlider : image/carousel slider
 */

// Slider parameters
$slider_vendor = elgg_extract('vendor', $vars, 'anythingslider'); // slider vendor
$sliderparams = elgg_extract('sliderparams', $vars); // JS additional parameters
$slidercss_main = elgg_extract('slidercss_main', $vars); // CSS for main ul tag
$slidercss_textslide = elgg_extract('slidercss_textslide', $vars); // CSS for li .textslide
$slider_content = elgg_extract('slidercontent', $vars, false); // Complete content - except the first-level <ul> tag (we could use an array instead..)
$slider_slides = elgg_extract('slides', $vars, false); // Slides content
// These are directly passed to the vendor display view
//$slider_theme = elgg_extract('theme', $vars, false); // slider theme
//$height = elgg_extract('height', $vars); // Slider container height
//$width = elgg_extract('width', $vars); // Slider container width

if (empty($sliderparams)) { $sliderparams = elgg_get_plugin_setting('jsparams', 'slider'); }
if (empty($slidercss_main)) { $slidercss_main = elgg_get_plugin_setting('css_main', 'slider'); }
if (empty($slidercss_textslide)) { $slidercss_textslide = elgg_get_plugin_setting('css_textslide', 'slider'); }
// Build content from slides, if needed
if (empty($slider_content)) {
	if ($slider_slides) {
		$slider_content = '<li>' . implode('</li><li>', $slider_slides) . '</li>';
	} else {
		$slider_content = elgg_echo('slider:nocontent');
	}
}
// Remove enclosing <ul> or <ol> from content
// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
if (in_array(substr($slider_content, 0, 4), array('<ol>', '<ul>'))) {
	$slider_content = substr($slider_content, 4);
	// Note : this technique avoids errors when an extra line was added after the list..
	if ($start_list == '<ul>') { $end_pos = strripos($slider_content, '</ul>'); } else { $end_pos = strripos($slider_content, '</ol>'); }
	if ($end_pos !== false) { $slider_content = substr($slider_content, 0, $end_pos); }
}


// Set unique slider id
if (!isset($vars['id']) || empty($vars['id'])) {
	if (!empty($vars['guid'])) {
		$id = 'slider-' . $vars['guid'];
	} else {
		$id = slider_unique_id();
	}
}


// Prepare vendor view params
$slider_vars = array(
		'vendor' => $slider_vendor,
		'theme' => $vars['theme'],
		'content' => $slider_content,
		'js_params' => $sliderparams,
		'css_main' => $slidercss_main,
		'css_textslide' => $slidercss_textslide,
		'width' => $vars['width'],
		'height' => $vars['height'],
		'id' => $id,
	);

echo elgg_view('slider/slider_' . $slider_vendor, $slider_vars);

