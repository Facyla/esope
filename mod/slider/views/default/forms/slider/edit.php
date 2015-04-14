<?php

elgg_load_js('elgg.slider.edit');

global $CONFIG;
global $anythingSliderUniqueID;

$vendor_url = elgg_get_site_url() . 'mod/slider/vendors/anythingslider/';

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



// Get current slider (if exists)
$guid = get_input('guid', false);
$slider = get_entity($guid);

// Get slider vars
if (elgg_instanceof($slider, 'object', 'slider')) {
	$slider_title = $slider->title; // Slider title, for easier listing
	$slider_description = $slider->description; // Clear description of what this slider is for
	$slider_slides = $slider->slides; // Complete slider content - except the first-level <ul> tag (we could use an array instead..) - Use several blocks si we can have an array of individual slides
	$slider_config = $slider->config; // JS additional parameters
	$slider_css = $slider->css; // CSS
	//$slidercss_textslide = ''; // CSS for li .textslide
	//$container_style = '';
	$slider_height = $slider->height; // Slider container height
	$slider_width = $slider->width; // Slider container width
	$slider_access = $slider->access_id; // Default access level
	
	// Compute some usseful vars
	// Add inner div to support rich content slides ? <div >class="textSlide">...</div>
	$slidercontent = '<li>' . implode('</li><li>', $slider_slides) . '</li>'; // Content without enclosing <ul> (we need id)
	
} else {
	// Set default slider using main config
	$slidercontent = $vars['slidercontent']; // Complete content - except the first-level <ul> tag (we could use an array instead..)
	$slider_config = $vars['sliderparams']; // JS additional parameters
	$slider_height = $vars['height']; // Slider container height
	$slider_width = $vars['width']; // Slider container width
	$slider_access = get_default_access(); // Default access level
	
	$slidercss_main = $vars['slidercss_main']; // CSS for main ul tag
	$slidercss_textslide = $vars['slidercss_textslide']; // CSS for li .textslide
	
}


// Edit form
// Param vars
$content = '';
if ($slider) $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid)) . '</p>';
$content .= '<p><label>' . elgg_echo('slider:edit:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $slider_title)) . '</label><br /><em></em></p>';
$content .= '<p><label>' . elgg_echo('slider:edit:description') . ' ' . elgg_view('input/plaintext', array('name' => 'description', 'value' => $slider_description)) . '</label><br /><em></em></p>';

// @TODO Add sortable blocks
// @TODO Add JS new blocks
$content .= '<div class="slider-edit-slides">';
$content .= '<em>' . elgg_echo('slider:edit:content:details') . '</em><br />';
if (!empty($slider_slides) && !is_array($slider_slides)) { $slider_slides = array($slider_slides); }
if (is_array($slider_slides)) {
	foreach($slider_slides as $slide_content) {
		$content .= elgg_view('slider/input/slide', array('value' => $slide_content));
	}
} else {
	$content .= elgg_view('slider/input/slide');
}
$content .= '</div>';
$content .= elgg_view('input/button', array(
		'id' => 'slider-edit-add-slide',
		'value' => elgg_echo('slider:edit:addslide'),
		'class' => 'elgg-button elgg-button-action',
	));
$content .= '<div class="clearfloat"></div><br />';

$content .= '<p><label>' . elgg_echo('slider:edit:config') . ' ' . elgg_view('input/plaintext', array('name' => 'config', 'value' => $slider_config)) . '</label><br /><em></em></p>';
$content .= '<p><label>' . elgg_echo('slider:edit:css') . ' ' . elgg_view('input/plaintext', array('name' => 'css', 'value' => $slider_css)) . '</label><br /><em></em></p>';
$content .= '<p><label>' . elgg_echo('slider:edit:height') . ' ' . elgg_view('input/text', array('name' => 'height', 'value' => $slider_height)) . '</label><br /><em></em></p>';
$content .= '<p><label>' . elgg_echo('slider:edit:width') . ' ' . elgg_view('input/text', array('name' => 'width', 'value' => $slider_width)) . '</label><br /><em></em></p>';

$content .= '<p><label>' . elgg_echo('slider:edit:access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $slider_access)) . '</label><br /><em></em></p>';
$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('slider:edit:submit'))) . '</p>';


// AFFICHAGE DU formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/slider/edit", 'body' => $content, 'id' => "slider-edit-form", 'enctype' => 'multipart/form-data'));


// Prévisualisation
if ($slider) {
	echo '<div class="clearfloat"></div><br /><br />';
	echo '<hr />';
	echo '<h3>' . elgg_echo('slider:edit:preview') . '</h3>';
	echo elgg_view('slider/view', array('entity' => $slider));
}

/* Documentation complète de Anythingslider
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


