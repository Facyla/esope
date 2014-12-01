<?php
/**
* Elgg output page content
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Facyla 2010-2014
* @link http://id.facyla.fr/
*/

// Load Elgg engine
global $CONFIG;


$editor = get_input('editor');

//elgg_load_js('impress.js');
//elgg_load_js('impress-audio');

//elgg_register_css('impress_css', '/mod/impress_js/vendors/impress.js/css/impress-demo.css');
//elgg_load_css('impress_css');


$title = "Impress.js editors";

$content = '';

// Presentation content
/*
$content .= '<div id="impress">';

$content .= '<div id="bored" class="step slide" data-x="-1000" data-y="-1500"><q>Aren \'t you just <b>bored</b> with all those slides-based presentations?</q></div>';

$content .= '<div class="step slide" data-x="0" data-y="-1500"><q>Don\'t you think that presentations given <strong>in modern browsers</strong> shouldn\'t <strong>copy the limits</strong> of \'classic\' slide decks?</q></div>';

$content .= '<div class="step slide" data-x="1000" data-y="-1500"><q>Would you like to <strong>impress your audience</strong> with <strong>stunning visualization</strong> of your talk?</q></div>';

$content .= '<div id="title" class="step" data-x="0" data-y="0" data-scale="4">
	<span class="try">then you should try</span>
	<h1>impress.js<sup>*</sup></h1>
	<span class="footnote"><sup>*</sup> no rhyme intended</span>
	</div>';

$content .= '<div id="its" class="step" data-x="850" data-y="3000" data-rotate="90" data-scale="5">
	<p>It\'s a <strong>presentation tool</strong> <br/>
	inspired by the idea behind <a href="http://prezi.com">prezi.com</a> <br/>
	and based on the <strong>power of CSS3 transforms and transitions</strong> in modern browsers.</p>
	</div>';

$content .= '<div id="big" class="step" data-x="3500" data-y="2100" data-rotate="180" data-scale="6"><p>visualize your <b>big</b> <span class="thoughts">thoughts</span></p></div>';

$content .= '<div id="tiny" class="step" data-x="2825" data-y="2325" data-z="-3000" data-rotate="300" data-scale="1"><p>and <b>tiny</b> ideas</p></div>';

$content .= '<div id="ing" class="step" data-x="3500" data-y="-850" data-rotate="270" data-scale="6"><p>by <b class="positioning">positioning</b>, <b class="rotating">rotating</b> and <b class="scaling">scaling</b> them on an infinite canvas</p></div>';

$content .= '<div id="imagination" class="step" data-x="6700" data-y="-300" data-scale="6"><p>the only <b>limit</b> is your <b class="imagination">imagination</b></p></div>';

$content .= '<div id="source" class="step" data-x="6300" data-y="2000" data-rotate="20" data-scale="4">
	<p>want to know more?</p>
	<q><a href="http://github.com/bartaz/impress.js">use the source</a>, Luke!</q>
	</div>';

$content .= '<div id="one-more-thing" class="step" data-x="6000" data-y="4000" data-scale="2"><p>one more thing...</p></div>';

$content .= '<div id="its-in-3d" class="step" data-x="6200" data-y="4300" data-z="-100" data-rotate-x="-40" data-rotate-y="10" data-scale="2">
	<p><span class="have">have</span> <span class="you">you</span> <span class="noticed">noticed</span> <span class="its">it\'s</span> <span class="in">in</span> <b>3D<sup>*</sup></b>?</p>
	<span class="footnote">* beat that, prezi ;)</span>
	</div>';

$content .= '<div id="overview" class="step" data-x="3000" data-y="1500" data-scale="10"></div>';


$content .= '<div class="hint"><p>Use a spacebar or arrow keys to navigate</p></div>';

$content .= '</div>';
*/

$base_strut = $CONFIG->url . 'mod/impress_js/vendors/Strut/';
$base_impressionist = $CONFIG->url . 'mod/impress_js/vendors/Impressionist/';
$base_builder4impress = $CONFIG->url . 'mod/impress_js/vendors/builder4impress/';

if ($editor == 'strut') {
	$title = "Strut Impress.js editor";
	
	elgg_load_js('swfobject.js');
	
	// JS scripts
	$content = '<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Cache-Control" content="max-age=0">
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
		<meta http-equiv="Pragma" content="no-cache">
		<title>Strut - Beta</title>';
	$content .= '<link rel="stylesheet" href="' . $base_strut . 'styles/main.css">';
	$content .= '<link rel="stylesheet" href="' . $base_strut . 'preview_export/reveal/css/theme/default.css">';
	$content .= '<link rel="stylesheet" type="text/css" href="' . $base_strut . 'styles/built.css">';
	$content .= '<script type="text/javascript" src="' . $base_strut . 'preview_export/download_assist/swfobject.js"></script>';
	$content .= '</head>';
	$content .= '<body class="bg-default">';
	$content .= <<< HTML
<script>
		window.isOptimized = true;
		if (!Function.prototype.bind) {
		  Function.prototype.bind = function (oThis) {
		    if (typeof this !== "function") {
		      // closest thing possible to the ECMAScript 5 internal IsCallable function
		      throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
		    }

		    var aArgs = Array.prototype.slice.call(arguments, 1), 
		        fToBind = this, 
		        fNOP = function () {},
		        fBound = function () {
		          return fToBind.apply(this instanceof fNOP && oThis
		                                 ? this
		                                 : oThis,
		                               aArgs.concat(Array.prototype.slice.call(arguments)));
		        };

		    fNOP.prototype = this.prototype;
		    fBound.prototype = new fNOP();

		    return fBound;
		  };
		}

		if (!Array.prototype.some) {
		  Array.prototype.some = function(fun /*, thisp */) {
		    'use strict';

		    if (this == null) {
		      throw new TypeError();
		    }

		    var thisp, i,
		        t = Object(this),
		        len = t.length >>> 0;
		    if (typeof fun !== 'function') {
		      throw new TypeError();
		    }

		    thisp = arguments[1];
		    for (i = 0; i < len; i++) {
		      if (i in t && fun.call(thisp, t[i], i, t)) {
		        return true;
		      }
		    }

		    return false;
		  };
		}

		if (!Array.prototype.forEach) {
		    Array.prototype.forEach = function (fn, scope) {
		        'use strict';
		        var i, len;
		        for (i = 0, len = this.length; i < len; ++i) {
		            if (i in this) {
		                fn.call(scope, this[i], i, this);
		            }
		        }
		    };
		}

		var head = document.getElementsByTagName('head')[0];
		function appendScript(src) {
			var s = document.createElement("script");
    		s.type = "text/javascript";
    		s.src = src;
    		head.appendChild(s);
		}

		if (window.location.href.indexOf("preview=true") == -1) {
			window.dlSupported = 'download' in document.createElement('a');
			window.hasFlash = swfobject.hasFlashPlayerVersion(9);
			if (!dlSupported && window.hasFlash) {
				appendScript('{$base_strut}preview_export/download_assist/downloadify.min.js');
			}
		}
		</script>
HTML;
	
	$content .= '<script data-main="' . $base_strut . 'scripts/amd-app" src="' . $base_strut . 'scripts/libs/require.js"></script>';
	$content .= '<div id="modals"></div>';
	$content .= '</body>';
	$content .= '</html>';
	// Displays the editor fullscreen
	echo elgg_render_embed_content($content,$title, 'inner');
	exit;
}


$content .= '<p><em>While you may directly edit HTML files to use them with Impress.js, there are also several Impress.js editors which facilitates this tasks. Each of them has its own functionnalities and limitations, but i\'ve tried to include here the most complete and usable ones.</em</p>';


$content .= '<h3>Strut editor</h3>';
$content .= '<p><em>Strut is a complete editor with slides editor, transition editor and viewer. It lets you add Text, Images, Videos, Web sites and Shapes to your presentation, and to use background images or colors. The resulting slides can be arranged using scale and orientation, including 3D). Presentations are saved locally, and can also be exported as a JSON file, or saved as a fully functionnal HTML page.</em</p>';

$content .= '<div class="elgg-output">Presentations are currently saved only locally on <em>this</em> browser. Please save them in another place if you wish to use them from another computer.<br />To load one of these, please open Strut editor, then load the saved presentation.<ul>';
$content .= '<script>
function listStrutSavedPresentations(){  
	for (i=0; i<=localStorage.length-1; i++) {
		key = localStorage.key(i);
		if (key.substr(0, 6) == \'strut-\') {
			var localStrutImpressJSON = localStorage.getItem(key);
			//document.write(\'<p>\' + localStrutImpressJSON + \'</p>\');
			var localStrutImpress = $.parseJSON(localStrutImpressJSON);
			document.write(\'<li>\' + localStrutImpress[\'fileName\'] + \'</li>\');
		}
	}
}
listStrutSavedPresentations();
</script>';
$content .= '</ul></div>';

// Using rewritten URL causes multiple dependencies errors (files not found, etc.)
//$content .= '<p><a href="?editor=strut" target="_blank" class="elgg-button elgg-button-action">Open Strut editor (new window)</a></p>';
// So better use direct, real path
$content .= '<p><a href="' . $base_strut . 'index.html" target="_blank" class="elgg-button elgg-button-action">Open Strut editor (new window)</a></p>';



$content .= '<h3>Impressionist editor</h3>';
// Impressionist decks are saved under impressionist_decks localStorage
$content .= '<p><em>Impressionist is less complete than Strut in terms of types of embeddable content, but might be pretty more straight-forward to create text + images slides, and arrange them. It also features a few style presets, and lets you save your presentations locally.<br />It lets you easily export the HTML snippet that fits for Impress.js, but previewing doesn\'t work as expected.</em</p>';
$content .= '<div class="elgg-output">Presentations are currently saved only locally on <em>this</em> browser. Please save them in another place if you wish to use them from another computer.<br />To load one of these, please open Impressionist editor, then load the saved presentation and export it.<ul>';
$content .= '<script>
function listImpressionistSavedPresentations(){  
	for (i=0; i<=localStorage.length-1; i++) {
		key = localStorage.key(i);
		if (key == \'impressionist_decks\') {
			var localImpressionistJSON = localStorage.getItem(key);
			//document.write(\'<p>\' + localImpressionistJSON + \'</p>\');
			var localImpressionist = $.parseJSON(localImpressionistJSON);
			$.each(localImpressionist, function(index, value) {
				document.write(\'<li>\' + value[\'title\'] + \' (\' + value[\'description\'] + \')</li>\');
			});
		}
	}
}
listImpressionistSavedPresentations();
</script>';
$content .= '</ul></div>';
$content .= '<p><a href="' . $base_impressionist . 'app.html" target="_blank" class="elgg-button elgg-button-action">Open Impressionist editor (new window)</a></p>';



$content .= '<h3>Builder4Impress editor</h3>';
$content .= '<p><em>This is the most "textful" of these editors, but it allows to use raw HTML inside the slides. Also, it allows tu use Impress-presentation while editing. BUT saving doesn\'t work so you should not invest too much time in editing !</em</p>';
$content .= '<p><a href="' . $base_builder4impress . 'index.html" target="_blank" class="elgg-button elgg-button-action">Open Builder4Impress editor (new window)</a></p>';




$sidebar = elgg_view('impress_js/sidebar');

// Render the page
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);



