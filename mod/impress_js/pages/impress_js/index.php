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

elgg_load_js('impress.js');
elgg_load_js('impress-audio');

//elgg_register_css('impress_css', '/mod/impress_js/vendors/impress.js/css/impress-demo.css');
//elgg_load_css('impress_css');


$title = "Impress.js";

$content = '';

// Presentation content
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


// JS scripts
$content .= '<script>
if ("ontouchstart" in document.documentElement) { 
	document.querySelector(".hint").innerHTML = "<p>Tap on the left or right to navigate</p>";
}
</script>';
$content .= '<script>$( document ).ready(function() { impress().init(); });</script>';



$sidebar = "Contenu de la sidebar";



// Render the page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);


