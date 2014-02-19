<?php
/**
 * CSS typography
 *
 * @package Elgg.Core
 * @subpackage UI
 */

$css = elgg_extract('theme-config-css', $vars);
$titlecolor = $css['titlecolor'];
$textcolor = $css['textcolor'];
$linkcolor = $css['linkcolor'];
$backgroundcolor = $css['backgroundcolor'];
$backgroundimg = $css['backgroundimg'];
$linkhovercolor = $css['linkhovercolor'];
$urlfonts = $vars['url'] . 'mod/adf_public_platform/fonts/';
$urlicon = $vars['url'] . 'mod/adf_public_platform/img/theme/';
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

/* ***************************************
	Typography
*************************************** */
/* Thème ADF - Urbilog */

@charset "utf-8";
/* CSS Document */

* {
	margin: 0;
	padding: 0;
}

/* TODO : Replace by free, open fonts
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


/**** Change font and colour here ***********/
html {
	<?php if (!empty($backgroundimg)) { ?>
	background: <?php echo $backgroundcolor; ?> url("<?php echo $backgroundimg; ?>") left top repeat scroll !important;
	<?php } ?>
	font-family: <?php echo $font4; ?>;
}
body {
	font-size: 90%;
/* Supprimé du thème ADF - ou à forcer avec d'autres valeurs
	line-height: 1.4em;
	font-family:  <?php echo $font4; ?>;
  color:#221907;
*/
	<?php if (!empty($backgroundimg)) { ?>
	background: <?php echo $backgroundcolor; ?> url("<?php echo $backgroundimg; ?>") left top repeat scroll !important;
	<?php } ?>
	position: relative;
	border-top: 5px solid #333333;
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
	/* text-decoration: underline; */
}
a:hover, 
a:focus, 
a:active { text-decoration: underline; }

p {
	margin-bottom: 15px;
	color: <?php echo $textcolor; ?>;
}
/*
p, ul li { font-size: 0.85em; }
*/

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
	border:none;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
  background: #e5e7f5;
  font-size: 0.85em;
}

/********* Change header text color here ***********/

h1, h2, h3, h4, h5, h6 {
	font-weight: bold;
	color: <?php echo $titlecolor; ?>;
}

h1 { font-size: 1.8em; }
h2 { font-size: 1.5em; line-height: 1.1em; margin-bottom:5px; color: #333; }
h3 { font-size: 1.3em; margin-bottom:4px; }
h4 { font-size: 1.1em; margin-bottom:3px; }
h5 { font-size: 1.0em; margin-bottom:2px; }
h6 { font-size: 0.9em; margin-bottom:1px; }

.elgg-heading-site, .elgg-heading-site:hover, 
.elgg-heading-site, .elgg-heading-site:focus, 
.elgg-heading-site, .elgg-heading-site:active {
	font-size: 2em;
	line-height: 1.4em;
	color: white;
	font-style: italic;
	font-family: <?php echo $font6; ?>;
	text-shadow: 1px 2px 4px #333333;
	text-decoration: none;
}

header h1 {
	font-family: <?php echo $font2; ?>;
	text-transform: uppercase;
	float: left;
	margin-top: 40px;
	font-size: 32px;
	color:#ffffff;
}
header h1 a { color:#ffffff; }
header h1 a:hover,
header h1 a:focus,
header h1 a:active { color:#ffffff; }
header h1 span {
	font-size: 1.4em;
}

.elgg-heading-main {
	float: left;
	max-width: 530px;
	margin-right: 10px;
}
.elgg-heading-basic {
	color: <?php echo $titlecolor; ?>;
	font-size: 1.2em;
	font-weight: bold;
}

.elgg-subtext {
	color: #666666;
	font-size: 0.8em;
	line-height: 1.4em;
	font-style: italic;
	/* float: left; */ /* pb avec commentaires */
	clear: left;
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

/* Arborescence : taille de plus en plus petite */
.treeview { font-size:16px; }
.treeview li { font-size:0.95em; }
.treeview li.elgg-state-selected a.selected {
  color:white; 
  background-color:<?php echo $linkcolor; ?>;
  font-weight: bold;
  padding: 2px 7px;
}

.elgg-widget-more {
  line-height:32px; color:<?php echo $linkcolor; ?>;
  background: #F2F1EF;
  display:block;
  width: 100%;
  /* float: left; */
}
.elgg-widget-more:before {
    content: "+ ";
    font-family: <?php echo $font2; ?>;
    font-size: 24px;
    font-weight: bold;
    margin-left: 9px;
    text-shadow: 0 2px 2px #999999;
    vertical-align: bottom;
}

/* ***************************************
	USER INPUT DISPLAY RESET
*************************************** */
.elgg-output {
	margin-top: 10px;
}

.elgg-output dt { font-weight: bold }
.elgg-output dd { margin: 0 0 1em 1em }

.elgg-output ul, ol {
	margin: 0 1.5em 1.5em 0;
	padding-left: 1.5em;
}
.elgg-output ul {
	list-style-type: disc;
}
.elgg-output ol {
	list-style-type: decimal;
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
}

