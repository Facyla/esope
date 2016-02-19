<?php
/**
 * CSS typography
 *
 * @package Elgg.Core
 * @subpackage UI
 */

$url = elgg_get_site_url();

// ESOPE : configurable colors
$css = elgg_extract('theme-config-css', $vars);
$titlecolor = $css['titlecolor'];
$textcolor = $css['textcolor'];
$linkcolor = $css['linkcolor'];
$backgroundcolor = $css['backgroundcolor'];
$backgroundimg = $css['backgroundimg'];
$linkhovercolor = $css['linkhovercolor'];
$urlfonts = $url . 'mod/esope/fonts/';
$urlicon = $url . 'mod/esope/img/theme/';
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
$font1 = $css['font1'];
$font2 = $css['font2'];
$font3 = $css['font3'];
$font4 = $css['font4'];
$font5 = $css['font5'];
$font6 = $css['font6'];
?>

/********************/
/* ESOPE Typography */
/********************/

/* ESOPE Fonts */

/* Use free, open fonts
 * Gill Sans => Puritan ou Lato (Book 400) ou Cabin
 * ITC Avant Garde Gothic Std => Tex Gyre Adventor ou Raleway (plus large) ou Didact Gothic
	
	font-family: 'Lato', sans-serif;
	font-family: 'Puritan', sans-serif;
	font-family: 'Didact Gothic', sans-serif;
 */
@import url(http://fonts.googleapis.com/css?family=Lato:400,700);
@import url(http://fonts.googleapis.com/css?family=Puritan:400,700,400italic,700italic);
@import url(http://fonts.googleapis.com/css?family=Didact+Gothic&subset=latin,latin-ext);


/*
@font-face {
	font-family: 'gill-sans';
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.otf');	
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.eot');
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.woff') format('woff'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.ttf') format('truetype'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans.svg#DIN30640StdNeuzeitGroteskLt') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'gill-sans-bold';
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.otf');
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.eot');
	src: url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.woff') format('woff'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.ttf') format('truetype'),
		 url('<?php echo $urlfonts; ?>Gill_Sans_1/GillSans-Bold.svg#DIN30640StdNeuzeitGroteskLt') format('svg');
	font-weight: bold;
	font-style: normal;
}
@font-face {
	font-family: 'itc-gothic', Arial;
	src: url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.otf');	
	src: url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.eot');
	src: url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.woff') format('woff'),
		 url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.ttf') format('truetype'),
		 url('<?php echo $urlfonts; ?>ITC_Avant_Garde_Gothic_Std_1/ITCAvantGardeStd-MdCn.svg#DIN30640StdNeuzeitGroteskLt') format('svg');
	font-weight: normal;
	font-style: normal;
}
*/

/* Remplacement par des polices libres similaires */
@font-face {
	font-family: 'puritan';
	src: url('<?php echo $urlfonts; ?>/Puritan/Puritan-Regular.otf');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'puritan-bold';
	src: url('<?php echo $urlfonts; ?>/Puritan/Puritan-Bold.otf');
	font-weight: bold;
	font-style: normal;
}
@font-face {
	font-family: 'texgyreadventor';
	src: url('<?php echo $urlfonts; ?>/TexGyreAdventor/texgyreadventor-regular.otf');
	font-weight: normal;
	font-style: normal;
}

/* <style> /**/

/* ***************************************
	Typography
*************************************** */
html {
	<?php if (!empty($backgroundimg)) { ?>
	background: <?php echo $backgroundcolor; ?> url("<?php echo $backgroundimg; ?>") left top repeat scroll !important;
	<?php } ?>
	/* font-family: <?php echo $font4; ?>; */
}
body {
	font-size: 0.9rem;
	font-family:  <?php echo $font4; ?>;
	color: <?php echo $textcolor; ?>;
/* Supprimé du thème ADF - ou à forcer avec d'autres valeurs
	line-height: 1.4em;
*/
	<?php if (!empty($backgroundimg)) { ?>
	background: <?php echo $backgroundcolor; ?> url("<?php echo $backgroundimg; ?>") left top repeat scroll !important;
	<?php } ?>
	position: static; /* Other than static breaks avatar cropper on Chrome */
}

a {
	text-decoration: none;
	color: <?php echo $linkcolor; ?>;
}

a:hover,
a:focus,
a:active,
a.selected { <?php //@todo remove .selected ?>
	color: <?php echo $linkhovercolor; ?>;
	text-decoration: underline;
}

p {
	margin-bottom: 15px;
	/* color: <?php echo $textcolor; ?>; */
}

p:last-child {
	margin-bottom: 0;
}

pre, code {
	font-family: <?php echo $font5; ?>;
	font-size: 12px;
	
	background:#EBF5FF;
	color:#000000;
	overflow:auto;

	overflow-x: auto; /* Use horizontal scroller if needed; for Firefox 2, not needed in Firefox 3 */

	white-space: pre-wrap;
	word-wrap: break-word; /* IE 5.5-7 */
	word-break:break-all;
	
}

pre {
	padding:3px 15px;
	margin:0px 0 15px 0;
	line-height:1.3em;
}

code {
	padding:2px 3px;
}

.elgg-monospace {
	font-family: <?php echo $font5; ?>;
}

blockquote {
	line-height: 1.3em;
	padding:3px 15px;
	margin:0px 0 15px 0;
	background:#EBF5FF;
	border:none;
	border-radius: 4px;
}

h1, h2, h3, h4, h5, h6 {
	font-weight: bold;
	color: <?php echo $titlecolor; ?>;
}

h1 { font-size: 1.8em; }
h2 { font-size: 1.35em; line-height: 1.1em; padding-bottom:5px; }
h3 { font-size: 1.17em; padding-bottom:4px; }
h4 { font-size: 0.99em; padding-bottom:3px; }
h5 { font-size: 0.9em; padding-bottom:2px; }
h6 { font-size: 0.81em; padding-bottom:1px; }

/* Sub and sup CSS style - from https://gist.github.com/unruthless/413930 */
sub, sup {
	/* Specified in % so that the sup/sup is the right size relative to the surrounding text */
	font-size: 0.75em;
	/* Zero out the line-height so that it doesn't interfere with the positioning that follows */
	line-height: 0;
	/* Where the magic happens: makes all browsers position the sup/sup properly, relative to the surrounding text */
	position: relative;
	/* Note that if you're using Eric Meyer's reset.css, this is already set and you can remove this rule */
	vertical-align: baseline;
}
/* Move the superscripted text up */
sup { top: -0.5em; }
/* Move the subscripted text down, but only half as far down as the superscript moved up */
sub { bottom: -0.25em; }


.elgg-heading-site, 
.elgg-heading-site:hover, 
.elgg-heading-site:focus, 
.elgg-heading-site:active {
	font-size: 2em;
	line-height: 1.4em;
	color: white;
	font-style: italic;
	font-family: <?php echo $font6; ?>;
	text-shadow: 1px 2px 4px #333;
	text-decoration: none;
}

.elgg-heading-site:hover,
.elgg-heading-site:focus {
	text-shadow: 1px 2px 8px #000;
}

.elgg-heading-main {
	/*
	float: left;
	max-width: 530px;
	*/
	margin-right: 10px;
}
.elgg-heading-basic {
	color: <?php echo $titlecolor; ?>;
	font-size: 1.2em;
	font-weight: bold;
}

.elgg-subtext {
	color: #666666;
	font-size: 0.75rem;
	line-height: 1.2em;
	font-style: italic;
}

.elgg-text-help {
	display: block;
	font-size: 85%;
	font-style: italic;
}

.elgg-quiet {
	color: #666;
}

.elgg-loud {
	color: <?php echo $titlecolor; ?>;
}

/* ***************************************
	USER INPUT DISPLAY RESET
*************************************** */
.elgg-output {
	margin-top: 10px;
}

.elgg-output dt { font-weight: bold }
.elgg-output dd { margin: 0 0 1em 1em }

.elgg-output ul, .elgg-output ol {
	margin: 0 1.5em 1.5em 0;
	padding-left: 1.5em;
}
.elgg-output ul {
	list-style-type: disc;
}
.elgg-output ol {
	list-style-type: decimal;
	list-style-position: inside;
	padding-left: .4em;
}
.elgg-output table {
	border: 1px solid #ccc;
}
.elgg-output table td {
	border: 1px solid #ccc;
	padding: 3px 5px;
}
.elgg-output img {
	max-width: 100%;
	height: auto;
}

