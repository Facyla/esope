<?php
//elgg_load_js('elgg.slider.edit');
elgg_require_js("slider/edit");

// Advanced editor mode by default for admins only
$advanced_mode = get_input('edit_mode', '');
if (!empty($advanced_mode)) {
	if ($advanced_mode == 'basic') { $advanced_mode = false; }
	else { $advanced_mode = true; }
} else {
	$advanced_mode = elgg_is_admin_logged_in();
}

$edit_mode_toggle = '<p>' . elgg_echo('slider:edit_mode') . '&nbsp;: 
	<strong class="slider-mode-basic hidden">' . elgg_echo('slider:edit_mode:basic') . '</strong>
	<a href="javascript:void(0);" id="slider-edit-mode-basic" class="slider-mode-full">' . elgg_echo('slider:edit_mode:basic') . '</a>
	 / 
	<strong class="slider-mode-full">' . elgg_echo('slider:edit_mode:full') . '</strong>
	<a href="javascript:void(0);" id="slider-edit-mode-full" class="slider-mode-basic hidden">' . elgg_echo('slider:edit_mode:full') . '</a>
	</p>';

$edit_mode_toggle .= '<script>';
if ($advanced_mode) {
	$edit_mode_toggle .= "
		require(['jquery', 'slider/edit'], function ($, slider) {
			slider.switchMode('full');
		});
		";
} else {
	$edit_mode_toggle .= "
		require(['jquery', 'slider/edit'], function ($, slider) {
console.log(slider);
			slider.switchMode('basic');
		});
		";
}
$edit_mode_toggle .= '</script>';

// Get current slider (if exists)
$slider = elgg_extract('entity', $vars);
if ($slider instanceof ElggSlider) {
	$guid = get_input('guid', false);
	// Add support for unique identifiers
	$slider = slider_get_entity_by_name($guid);
}


$editor_opts = array('rawtext' => elgg_echo('slider:editor:no'), 'longtext' => elgg_echo('slider:editor:yes'));

// Get slider vars
if ($slider instanceof ElggSlider) {
	$slider_title = $slider->title; // Slider title, for easier listing
	$slider_name = $slider->name; // Slider title, for easier listing
	if (empty($slider_name) && !empty($slider_title)) {
		$slider_name = elgg_get_friendly_title($slider_title);
	}
	$slider_description = $slider->description; // Clear description of what this slider is for
	$slider_slides = $slider->slides; // Complete slider content - except the first-level <ul> tag (we could use an array instead..) - Use several blocks si we can have an array of individual slides
	$slider_config = $slider->config; // JS additional parameters
	$slider_css = $slider->css; // CSS
	//$slidercss_textslide = ''; // CSS for li .textslide
	//$container_style = '';
	$slider_height = $slider->height; // Slider container height
	$slider_width = $slider->width; // Slider container width
	$slider_access = $slider->access_id; // Default access level
	$editor = $slider->editor;
	
} else {
	$slider_config = elgg_get_plugin_setting('jsparams', 'slider'); // JS additional parameters
	$slider_css = elgg_get_plugin_setting('css', 'slider'); // CSS
	$slider_height = '300px'; // Slider container height
	$slider_width = '100%'; // Slider container width
	$slider_access = get_default_access(); // Default access level
	$editor = 'rawtext';
	// Use provided name if set
	$slider_title = get_input('title');
	$slider_name = get_input('name');
	
	//$slidercss_main = $vars['slidercss_main']; // CSS for main ul tag
	//$slidercss_textslide = $vars['slidercss_textslide']; // CSS for li .textslide
	
}


// Edit form
// Param vars
$content = '';
if ($slider) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $slider->guid)) . '</p>'; }
$content .= elgg_view('input/hidden', array('name' => 'edit_mode', 'value' => "")) . '</p>';


$content .= '<div style="width:48%; float:left;" class="slider-mode-full">';
	$content .= '<p><label>' . elgg_echo('slider:edit:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $slider_title, 'style' => "width: 40ex; max-width: 80%;")) . '</label><br /><em>' . elgg_echo('slider:edit:title:details') . '</em></p>';
	$content .= '<p><label>' . elgg_echo('slider:edit:name') . ' ' . elgg_view('input/text', array('name' => 'name', 'value' => $slider_name, 'style' => "width: 40ex; max-width: 80%;")) . '</label><br /><em>' . elgg_echo('slider:edit:name:details') . '</em></p>';
	$content .= '<p><label>' . elgg_echo('slider:edit:description') . ' ' . elgg_view('input/plaintext', array('name' => 'description', 'value' => $slider_description, 'style' => 'height:15ex;')) . '</label><br /><em>' . elgg_echo('slider:edit:description:details') . '</em></p>';

	// JS config
	$content .= '<p><label>' . elgg_echo('slider:edit:config') . ' ' . elgg_view('input/plaintext', array('name' => 'config', 'value' => $slider_config)) . '</label><br /><em>' . elgg_echo('slider:edit:config:details') . '</em></p>';
	// Documentation block
	$content .= '<p><a href="javascript:void(0);" onClick="$(\'#slider-config-documentation\').toggle();">' . elgg_echo('slider:edit:config:toggledocumentation') . '</a></p>';
$content .= '</div>';

$content .= '<div style="width:48%; float:right;" class="slider-mode-full">';
	// Access
	$content .= '<p><label>' . elgg_echo('slider:edit:access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $slider_access)) . '</label><br /><em>' . elgg_echo('slider:edit:access:details') . '</em></p>';
	
	// Container height
	$content .= '<p><label>' . elgg_echo('slider:edit:height') . ' ' . elgg_view('input/text', array('name' => 'height', 'value' => $slider_height, 'style' => "width: 10ex;")) . '</label><br /><em>' . elgg_echo('slider:edit:height:details') . '</em></p>';
	// Container width
	$content .= '<p><label>' . elgg_echo('slider:edit:width') . ' ' . elgg_view('input/text', array('name' => 'width', 'value' => $slider_width, 'style' => "width: 10ex;")) . '</label><br /><em>' . elgg_echo('slider:edit:width:details') . '</em></p>';
	
	// CSS
	$content .= '<p><label>' . elgg_echo('slider:edit:css') . ' ' . elgg_view('input/plaintext', array('name' => 'css', 'value' => $slider_css)) . '</label><br /><em>' . elgg_echo('slider:edit:css:details', array($slider->guid)) . '</em></p>';
$content .= '</div>';

$content .= '<div class="clearfloat"></div>';

// Documentation block
$content .= '<div id="slider-config-documentation" class="hidden">';
$content .= '<pre>';
$content .= '<strong>Anything Slider configuration parameters:</strong>

theme               : "default", // Theme name : default | cs-portfolio | metallic | construction | minimalist-round | minimalist-square
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

<strong>// Function</strong>
enableArrows        : true,      // if false, arrows will be visible, but not clickable.
enableNavigation    : true,      // if false, navigation links will still be visible, but not clickable.
enableStartStop     : true,      // if false, the play/stop button will still be visible, but not clickable. Previously "enablePlay"
enableKeyboard      : true,      // if false, keyboard arrow keys will not work for this slider.

<strong>// Navigation</strong>
startPanel          : 1,         // This sets the initial panel
changeBy            : 1,         // Amount to go forward or back when changing panels.
hashTags            : true,      // Should links change the hashtag in the URL?
infiniteSlides      : true,      // if false, the slider will not wrap & not clone any panels
navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
navigationSize      : false,     // Set this to the maximum number of visible navigation tabs; false to disable

<strong>// Slideshow options</strong>
autoPlay            : false,     // If true, the slideshow will start running; replaces "startStopped" option
autoPlayLocked      : false,     // If true, user changing slides will not stop the slideshow
autoPlayDelayed     : false,     // If true, starting a slideshow will delay advancing slides; if false, the slider will immediately advance to the next slide when slideshow starts
pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover
stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page. This also stops the rewind effect when infiniteSlides is false.
playRtl             : false,     // If true, the slideshow will move right-to-left

<strong>// Times</strong>
delay               : 3000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
resumeDelay         : 15000,     // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds).
animationTime       : 600,       // How long the slideshow transition takes (in milliseconds)
delayBeforeAnimate  : 0,         // How long to pause slide animation before going to the desired slide (used if you want your "out" FX to show).

<strong>// Callbacks</strong>
onBeforeInitialize  : function(e, slider) {}, // Callback before the plugin initializes
onInitialized       : function(e, slider) {}, // Callback when the plugin finished initializing
onShowStart         : function(e, slider) {}, // Callback on slideshow start
onShowStop          : function(e, slider) {}, // Callback after slideshow stops
onShowPause         : function(e, slider) {}, // Callback when slideshow pauses
onShowUnpause       : function(e, slider) {}, // Callback when slideshow unpauses - may not trigger properly if user clicks on any controls
onSlideInit         : function(e, slider) {}, // Callback when slide initiates, before control animation
onSlideBegin        : function(e, slider) {}, // Callback before slide animates
onSlideComplete     : function(slider) {},    // Callback when slide completes; this is the only callback without an event "e" parameter

<strong>// Interactivity</strong>
clickForwardArrow   : "click",         // Event used to activate forward arrow functionality (e.g. add jQuery mobile\'s "swiperight")
clickBackArrow      : "click",         // Event used to activate back arrow functionality (e.g. add jQuery mobile\'s "swipeleft")
clickControls       : "click focusin", // Events used to activate navigation control functionality
clickSlideshow      : "click",         // Event used to activate slideshow play/stop button
allowRapidChange    : false,           // If true, allow rapid changing of the active pane, instead of ignoring activity during animation

<strong>// Video</strong>
resumeOnVideoEnd    : true,      // If true & the slideshow is active & a supported video is playing, it will pause the autoplay until the video is complete
resumeOnVisible     : true,      // If true the video will resume playing (if previously paused, except for YouTube iframe - known issue); if false, the video remains paused.
addWmodeToObject    : "opaque",  // If your slider has an embedded object, the script will automatically add a wmode parameter with this setting
isVideoPlaying      : function(base){ return false; } // return true if video is playing or false if not - used by video extension';
$content .= '<pre>';
$content .= '</div>';


// SLIDES
// Sortable blocks + JS add new block
$content .= '<div class="slider-edit-slides">';
$content .= '<p><strong>' . elgg_echo('slider:edit:content') . '</strong><br />';
$content .= '<em>' . elgg_echo('slider:edit:content:details') . '</em></p>';

// Enable/disable editor (by default)
$content .= '<p class="slider-mode-full"><label>' . elgg_echo('slider:edit:editor') . ' ' . elgg_view('input/pulldown', array('name' => 'editor', 'value' => $vars['entity']->editor, 'options_values' => $editor_opts)) . '</label><br /><em>' . elgg_echo('slider:edit:editor:details') . '</em></p>';

if (!empty($slider_slides) && !is_array($slider_slides)) { $slider_slides = array($slider_slides); }
if (is_array($slider_slides)) {
	foreach($slider_slides as $slide_content) {
		$content .= elgg_view('slider/input/slide', array('value' => $slide_content, 'editor' => $editor));
	}
} else {
	$content .= elgg_view('slider/input/slide', array('editor' => $editor));
}
$content .= '</div>';
$content .= elgg_view('input/button', array(
		'id' => 'slider-edit-add-slide',
		'value' => elgg_echo('slider:edit:addslide'),
		'class' => 'elgg-button elgg-button-action',
	));
$content .= '<div class="clearfloat"></div><br />';


$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('slider:edit:submit'))) . '</p>';



/* AFFICHAGE DE LA PAGE D'ÉDITION */
echo '<h2>' . elgg_echo('slider:edit') . '</h2>';

echo $edit_mode_toggle;

// Affichage du formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/slider/edit", 'body' => $content, 'id' => "slider-edit-form", 'enctype' => 'multipart/form-data'));


// More informations on existing sliders
if ($slider instanceof ElggSlider) {
	// Informations on embed and insert
	echo '<h3><i class="fa fa-info-circle"></i>' . elgg_echo('slider:embed:instructions') . '</h3>';
	echo '<p><blockquote>';
	echo elgg_echo('slider:iframe:instructions', array($slider->guid)) . '<br />';
	if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('slider:shortcode:instructions', array($slider->guid)) . '<br />'; }
	if (elgg_is_active_plugin('cmspages')) {
		echo elgg_echo('slider:cmspages:instructions', array($slider->guid)) . '<br />';
		if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('slider:cmspages:instructions:shortcode', array($slider->guid)) . '<br />'; }
	}
	echo '</blockquote></p>';
	
	// Prévisualisation
	echo '<div class="clearfloat"></div><br /><br />';
	echo '<a href="' . $slider->getURL() . '" style="float:right" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo('slider:edit:view') . '</a>';
	echo '<h2>' . elgg_echo('slider:edit:preview') . '</h2>';
	echo elgg_view('slider/view', array('entity' => $slider));
}


