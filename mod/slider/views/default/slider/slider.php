<?php
global $CONFIG;
global $anythingSliderUniqueID;

$vendor_url = $CONFIG->url . 'mod/slider/vendors/anythingslider/';

// Use unique ID to include scripts once, and allow multiple sliders into a sinngle page..
if (!isset($anythingSliderUniqueID)) {
	$anythingSliderUniqueID = 1;
	echo '<script src="' . $vendor_url . 'js/jquery.anythingslider.js"></script>';
	// Anything Slider optional plugins
	echo '<script src="' . $vendor_url . 'js/jquery.easing.1.2.js"></script>';
	// http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js
	echo '<script src="' . $vendor_url . 'js/swfobject.js"></script>';
	// AnythingSlider video extension; optional, but needed to control video pause/play
	echo '<script src="' . $vendor_url . 'js/jquery.anythingslider.video.js"></script>';
} else {
	$anythingSliderUniqueID++;
}

// Param vars
$slidercontent = $vars['slidercontent']; // Complete content - except the first-level <ul> tag (we could use an array instead..)
$sliderparams = $vars['sliderparams']; // JS additional parameters
$slidercss_main = $vars['slidercss_main']; // CSS for main ul tag
$slidercss_textslide = $vars['slidercss_textslide']; // CSS for li .textslide
$height = $vars['height']; // Slider container height
$width = $vars['width']; // Slider container width
$container_style = '';
if ($height) $container_style .= "height:$height; ";
if ($width) $container_style .= "width:$width; ";

if (empty($slidercss_main)) {
	$slidercss_main = elgg_get_plugin_setting('css_main', 'slider');
}
if (empty($slidercss_textslide)) {
	$slidercss_textslide = elgg_get_plugin_setting('css_textslide', 'slider');
}

if (empty($slidercontent)) { $slidercontent = elgg_get_plugin_setting('content', 'slider'); }
if (!empty($slidercontent)) {
	// Si on a un <ul> ou <ol> au début et </ul> ou </ol> à la fin de la liste
	if (in_array(substr($slidercontent, 0, 4), array('<ol>', '<ul>'))) {
		$slidercontent = substr($slidercontent, 4);
	}
	if (in_array(substr($slidercontent, -5), array('</ol>', '</ul>'))) {
		$slidercontent = substr($slidercontent, 0, -5);
	}
}

if (empty($sliderparams)) {
	$sliderparams = elgg_get_plugin_setting('jsparams', 'slider');
}

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
?>

<script>
// Set up Slider
// *************
$(function(){
	$('#slider<?php echo $anythingSliderUniqueID; ?>').anythingSlider({
		theme : 'metallic',
		autoPlay : true,
		mode : 'f',   // fade mode,
		hashTags : false,
		<?php echo $sliderparams; ?>
	});
});
</script>


<!-- AnythingSlider #slider<?php echo $anythingSliderUniqueID; ?> -->
<style>
#slider<?php echo $anythingSliderUniqueID; ?> { list-style: none; background:white; <?php echo $slidercss_main; ?> }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide { <?php echo $slidercss_textslide; ?> }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide h3 { font-size: 1.4em; margin: 4px 0 16px 0; }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide a { font-weight:bold; }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide div { margin: 20px 36px 0 12px; }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide div * { font-size: 16px; }
#slider<?php echo $anythingSliderUniqueID; ?>  img { max-width: 100% !important; max-height: 100% !important; }
#slider<?php echo $anythingSliderUniqueID; ?> .textSlide img { width: auto !important; height: auto !important; }
</style>

<ul id="slider<?php echo $anythingSliderUniqueID; ?>" style="<?php echo $container_style; ?>">
	<?php echo $slidercontent; ?>
</ul>
<!-- END AnythingSlider #1 -->

