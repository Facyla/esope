<?php
/* AnythingSlider display slider
*/

// JS
elgg_require_js('slider.anythingslider.js');
elgg_require_js('slider.anythingslider.easing.js');
elgg_require_js('slider.anythingslider.swf.js');
elgg_require_js('slider.anythingslider.video.js');
// CSS
elgg_require_css('slider.anythingslider.css');
elgg_require_css('slider.anythingslider.css');
// Themes
elgg_require_css('slider.anythingslider.theme-construction.css');
elgg_require_css('slider.anythingslider.theme-cs-portfolio.css');
elgg_require_css('slider.anythingslider.theme-metallic.css');
elgg_require_css('slider.anythingslider.theme-minimalist-round.css');
elgg_require_css('slider.anythingslider.theme-minimalist-square.css');


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


/* Documentation complète
$('#slider').anythingSlider({
  // Appearance
  theme               : "default", // Theme name
  mode                : "horiz",   // Set mode to "horizontal", "vertical" or "fade" (only first letter needed); replaces vertical option
  expand              : false,     // If true, the entire slider will expand to fit the parent element
  resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport
  showMultiple        : false,     // Set this value to a number and it will show that many slides at once
  easing              : "swing",   // Anything other than "linear" or "swing" requires the easing plugin or jQuery UI

  buildArrows         : true,      // If true, builds the forwards and backwards buttons
  buildNavigation     : true,      // If true, builds a list of anchor links to link to each panel
  buildStartStop      : true,      // If true, builds the start/stop button

  appendForwardTo     : null,      // Append forward arrow to a HTML element (jQuery Object, selector or HTMLNode), if not null
  appendBackTo        : null,      // Append back arrow to a HTML element (jQuery Object, selector or HTMLNode), if not null
  appendControlsTo    : null,      // Append controls (navigation + start-stop) to a HTML element (jQuery Object, selector or HTMLNode), if not null
  appendNavigationTo  : null,      // Append navigation buttons to a HTML element (jQuery Object, selector or HTMLNode), if not null
  appendStartStopTo   : null,      // Append start-stop button to a HTML element (jQuery Object, selector or HTMLNode), if not null

  toggleArrows        : false,     // If true, side navigation arrows will slide out on hovering & hide @ other times
  toggleControls      : false,     // if true, slide in controls (navigation + play/stop button) on hover and slide change, hide @ other times

  startText           : "Start",   // Start button text
  stopText            : "Stop",    // Stop button text
  forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
  backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)
  tooltipClass        : "tooltip", // Class added to navigation & start/stop button (text copied to title if it is hidden by a negative text indent)

  // Function
  enableArrows        : true,      // if false, arrows will be visible, but not clickable.
  enableNavigation    : true,      // if false, navigation links will still be visible, but not clickable.
  enableStartStop     : true,      // if false, the play/stop button will still be visible, but not clickable. Previously "enablePlay"
  enableKeyboard      : true,      // if false, keyboard arrow keys will not work for this slider.

  // Navigation
  startPanel          : 1,         // This sets the initial panel
  changeBy            : 1,         // Amount to go forward or back when changing panels.
  hashTags            : true,      // Should links change the hashtag in the URL?
  infiniteSlides      : true,      // if false, the slider will not wrap & not clone any panels
  navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
  navigationSize      : false,     // Set this to the maximum number of visible navigation tabs; false to disable

  // Slideshow options
  autoPlay            : false,     // If true, the slideshow will start running; replaces "startStopped" option
  autoPlayLocked      : false,     // If true, user changing slides will not stop the slideshow
  autoPlayDelayed     : false,     // If true, starting a slideshow will delay advancing slides; if false, the slider will immediately advance to the next slide when slideshow starts
  pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover
  stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page. This also stops the rewind effect when infiniteSlides is false.
  playRtl             : false,     // If true, the slideshow will move right-to-left

  // Times
  delay               : 3000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
  resumeDelay         : 15000,     // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds).
  animationTime       : 600,       // How long the slideshow transition takes (in milliseconds)
  delayBeforeAnimate  : 0,         // How long to pause slide animation before going to the desired slide (used if you want your "out" FX to show).

  // Callbacks
  onBeforeInitialize  : function(e, slider) {}, // Callback before the plugin initializes
  onInitialized       : function(e, slider) {}, // Callback when the plugin finished initializing
  onShowStart         : function(e, slider) {}, // Callback on slideshow start
  onShowStop          : function(e, slider) {}, // Callback after slideshow stops
  onShowPause         : function(e, slider) {}, // Callback when slideshow pauses
  onShowUnpause       : function(e, slider) {}, // Callback when slideshow unpauses - may not trigger properly if user clicks on any controls
  onSlideInit         : function(e, slider) {}, // Callback when slide initiates, before control animation
  onSlideBegin        : function(e, slider) {}, // Callback before slide animates
  onSlideComplete     : function(slider) {},    // Callback when slide completes; this is the only callback without an event "e" parameter

  // Interactivity
  clickForwardArrow   : "click",         // Event used to activate forward arrow functionality (e.g. add jQuery mobile's "swiperight")
  clickBackArrow      : "click",         // Event used to activate back arrow functionality (e.g. add jQuery mobile's "swipeleft")
  clickControls       : "click focusin", // Events used to activate navigation control functionality
  clickSlideshow      : "click",         // Event used to activate slideshow play/stop button
  allowRapidChange    : false,           // If true, allow rapid changing of the active pane, instead of ignoring activity during animation

  // Video
  resumeOnVideoEnd    : true,      // If true & the slideshow is active & a supported video is playing, it will pause the autoplay until the video is complete
  resumeOnVisible     : true,      // If true the video will resume playing (if previously paused, except for YouTube iframe - known issue); if false, the video remains paused.
  addWmodeToObject    : "opaque",  // If your slider has an embedded object, the script will automatically add a wmode parameter with this setting
  isVideoPlaying      : function(base){ return false; } // return true if video is playing or false if not - used by video extension
});
*/



echo <<<HTML
<!-- AnythingSlider #$id -->
<script type="text/javascript">
require(['jquery', 'slider.anythingslider'], function ($, anythingSlider) {
	$('#$id').anythingSlider({
		theme : '$slider_theme', // default, cs-portfolio, metallic, etc.
		autoPlay : true,
		mode : 'f',
		resizeContents : true,
		expand : true,
		buildNavigation : true,
		buildStartStop : false,
		//toggleControls : true,
		//toggleArrows : true,
		hashTags : false,
		delay : 5000,
		$js_params
	});
});
</script>

<style>
#$id { list-style: none; background:white; $css_main }
#$id .textSlide { $css_textslide }
#$id .textSlide h3 { font-size: 1.4em; margin: 4px 0 16px 0; }
#$id .textSlide a { font-weight:bold; }
#$id .textSlide div { margin: 20px 36px 0 12px; }
#$id .textSlide div * { font-size: 16px; }
#$id  img { max-width: 100% !important; max-height: 100% !important; }
#$id .textSlide img { width: auto !important; height: auto !important; }
</style>

<ul id="$id" style="$container_style">
	$slider_content
</ul>
<!-- END Slider #$id -->
HTML;


