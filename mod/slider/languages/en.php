<?php
$en = array(
	
	'slider' => "Slider",

	/* Settings */
	'slider:settings:description' => "Main slider settings",
	'slider:settings:defaultslider' => "Slider default content",
	'slider:settings:defaultslider:help' => "This plugin is mainly designed to give developpers a view that can be used in themes. FOr more commodity, a default slider content can be configured below, and called directement with the view 'slider/slider', without any configuration array.<br />",
	
	'slider:settings:content' => "Default slider content",
	'slider:settings:content:help' => "The slider content is defined by a unordened list, each item defining a slide. A slide content can be an image, a video, or any rich media content combining these elements.<br />Leave empty to get default values back.",
	'slider:settings:css_main' => "Slider global CSS properties (main &lt;ul&gt;)",
	'slider:settings:css_main:help' => "Please set only properties, e.g.: : width:600px; height:280px;<br />Leave empty to get default values back.",
	'slider:settings:jsparams' => "JS params of the slider",
	'slider:settings:jsparams:help' => "Add here the slider JS params, as a list of parameters like this one : <strong>parameter : value,<br />parameter2 : value2,</strong><br />Leave empty to get default values back.",
	'slider:settings:css_textslide' => "CSS properties for slides containing text",
	'slider:settings:css_textslide:help' => "Specific CSS properties for slides using the .textSlide class : add only properties, e.g.: color:#333;<br />Leave empty to get default values back.",
	'slider:settings:css' => "CSS override for ythe slider",
	'slider:settings:css:help' => "Override stylesheet for the slider : these are the complete CSS that should be added for the slider after the default styles.<br />Leave empty to get default values back.",
	'slider:settings:slider_access' => "Allow members to edit sliders",
	'slider:settings:slider_access:details' => "By default, the access to the slider editing tool is reserved to administrators. You can also allow site members to use it by choosing \"Yes\"",
	'slider:option:yes' => "Yes",
	'slider:option:no' => "No",
	
	
'slider:showinstructions' => "Display instructions",
	'slider:instructions' => "The sliders can be created here, and then inserted into articles and other publications through a shortcode <q>[slider id=\"12345\"]</q>",
	'slider:add' => "Create a new slider",
	'slider:edit' => "Slider edit",
	'slider:edit:title' => "Title",
	'slider:edit:title:details' => "The title is a readable identification for the slider. It is not otherwise used when displaying it.",
	'slider:edit:description' => "Description",
	'slider:edit:description:details' => "The description lets you define some additionnal information about this slider. It is not displayed either.",
	'slider:edit:content' => "Slides",
	'slider:edit:content:details' => "Add new slides, and reorder them to your convenience.",
	'slider:edit:slide' => "Slide",
	'slider:edit:addslide' => "Add a slide",
	'slider:edit:deleteslide' => "Delete this slide",
	'slider:edit:deleteslide:confirm' => "WARNING, deleted slides will be lost and cannot be restored. Delete anyway ?",
	'slider:edit:config' => "Slider JS parameters",
	'slider:edit:config:details' => "JavaScript slider configuration parameters (AnythingSlider).",
	'slider:edit:config:toggledocumentation' => "<i class=\"fa fa-toggle-down\"></i>Display full parameters documentation",
	'slider:edit:css' => "CSS",
	'slider:edit:css:details' => "CSS elements to be added while displaying this slider.<br /> Note: to select this slider, please use the following selector: <strong>#slider-%s</strong>",
	'slider:edit:height' => "Height",
	'slider:edit:height:details' => "The slider dimensions are determined by the parent block. To force specific dimensions, set its dimensions here.<br />Note: any valid \"height\" CSS property values are allowed, in px, %, and other units, including \"auto\".",
	'slider:edit:width' => "Width",
	'slider:edit:width:details' => "The slider dimensions are determined by the parent block. To force specific dimensions, set its dimensions here.<br />Note: any valid \"width\" CSS property values are allowed, in px, %, and other units, including \"auto\".",
	'slider:edit:access' => "Visibility",
	'slider:edit:submit' => "Save",
	'slider:saved' => "Your changes have been saved",
	'slider:edit:preview' => "Preview",
	
	'slider:shortcode:slider' => "Slider (already defined)",
	'slider:embed:instructions' => "How to embed this slider ?",
	'slider:shortcode:instructions' => " - with a shortcode, into a publication (blog, page, etc.): <strong>[slider id=\"%s\"]</strong>",
	'slider:cmspages:instructions' => " - with a template code, into a template CMSPage: <strong>{{:slider/view|guid=%s}}</strong>",
	'slider:cmspages:instructions:shortcode' => " - with a template short, alternatively, into a template CMSPage: <strong>{{[slider id=\"%s\"]}}</strong>",
	'slider:cmspages:notice' => "IMPORTANT: only CMS pages of type \"Template\" can display sliders! You may need to update page type to display it.",
	'slider:iframe:instructions' => " - with an embed code, on any other sites: <strong>&lt;iframe src=\"" . elgg_get_site_url() . "slider/view/%s?embed=full\"&gt;&lt;/iframe&gt;</strong>",
	
);

add_translation("en",$en);

