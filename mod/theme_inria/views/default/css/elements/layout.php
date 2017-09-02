<?php
/**
 * Page Layout
 *
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$headerimg = $css['headerimg'];
$urlicon = $css['urlicon'];
$linkcolor = $css['linkcolor'];
$textcolor = $css['textcolor'];
$linkhovercolor = $css['linkhovercolor'];
$color1 = $css['color1'];
$color2 = $css['color2'];
$color3 = $css['color3'];
$color4 = $css['color4'];
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth == 'yes') { $fixedwidth = true; } else { $fixedwidth = false; }

// Main width (on desktop screen)
$main_width = "990px";
$main_maxwidth = "990px";

if ($fixedwidth) {
	$content_width = "width:717px;";
	$sidebar_width = "width:210px;";
	$sidebar_alt_width = "width:160px;";
} else {
	$main_width = "990px";
	$main_maxwidth = "100%";
	$content_width = "width:70%; /* min-width:717px; */";
	$sidebar_width = "width:24%; min-width:210px; padding:1.5%; margin:0;";
	$sidebar_alt_width = "width:18%; min-width:160px; padding:1.5%; margin:0;";;
}

?>
/* <style> /**/


/****************/
/* ESOPE Layout */
/****************/

/* ***************************************
	PAGE LAYOUT
*************************************** */
.elgg-page-walledgarden { width:100%; }


/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	min-width: 800px;
}

.interne { position: relative; }

/* Set global layout width */
.interne, 
.elgg-page-walledgarden .elgg-page-header > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-body > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-footer > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-sitemenu > .elgg-inner, 
.elgg-page-default .elgg-page-header > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner, 
.elgg-page-default .elgg-page-sitemenu > .elgg-inner {
	min-width: <?php echo $main_width; ?>;
	width: 70%;
	max-width: 100%;
}

.interne, 
.elgg-page-walledgarden .elgg-page-header > .elgg-inner, 
.elgg-page-default .elgg-page-header > .elgg-inner {
	margin: 0 auto;
	/* height: 90px; */
}
.elgg-page-walledgarden .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner {
	margin: 0 auto;
}
.elgg-page-walledgarden .elgg-page-footer > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner {
	margin: 0 auto;
	padding: 5px 0;
	border-top: 1px solid #DEDEDE;
}

/* BLOC DU CONTENU PRINCIPAL - MAIN CONTENT */
#page_container {
	width: 100%;
	max-width: <?php echo $main_width; ?>;
	margin:0px auto; background:#fff; min-height: 100%;
	-moz-box-shadow: 0 0 10px #888; -webkit-box-shadow: 0 0 10px #888; box-shadow: 0 0 10px #181a2f;
}

/* Largeur de page standard */
.elgg-page-default .elgg-page-sitemenu > .elgg-inner {
	margin: 0 auto;
}


/***** TOPBAR ******/
.elgg-page-topbar {
	background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	border-bottom: 1px solid #000000;
	padding: 0 10px;
	position: relative;
	height: 24px;
	z-index: 9000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 24px;
	right: 20px;
	max-width:90%;
	width: 500px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
	/*
	padding: 0 10px;
	position: relative;
	background: #fff url(<?php echo elgg_get_site_url(); ?>_graphics/header_shadow.png) repeat-x bottom left;
	*/
}
.elgg-page-header > .elgg-inner {
	position: relative;
}

/***** PAGE BODY LAYOUT ******/
.elgg-page-body {
	padding: 0 1em;
}

.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
  /* background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/sidebar_background.gif) repeat-y right top; */
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}
.elgg-layout-widgets > .elgg-widgets {
	float: right;
}
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	margin: 0 0 0 10px;
	background:transparent;
	<?php echo $sidebar_width; ?>
	padding:0;
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	margin: 0 10px 0 0;
	<?php echo $sidebar_alt_width; ?>
	padding:0;
}

.elgg-menu-extras {
	background:transparent;
	float: right;
	margin:0;
	/* padding:6px 4px 0 4px; */
}
.elgg-owner-block { clear:both; }
.elgg-owner-block .elgg-head { background:#e5e7f6; margin:0; padding:0 4px 2px 4px;  }
.elgg-owner-block .elgg-menu { background:white; margin:0; padding: 0; }
.elgg-sidebar .elgg-module-aside {
	background:transparent; 
	float: left;
	margin: 20px 0 0 0;
	padding:6px 4px 2px 4px;
}

/****** Change colour of main white content area here */
.elgg-main {
	position: relative;
	padding: 13px;
	float: left;
	background: #fff;
	min-height:500px;
	height:auto;
}
.elgg-layout-one-sidebar .elgg-main {
	<?php echo $content_width; ?>
}

.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
.elgg-page-footer {
	color: #999;
	padding: 0 1em;
	position: relative;
}
.elgg-page-footer {
	color: #999;
	background:#333;
}
.elgg-page-footer a:hover, 
.elgg-page-footer a:focus, 
.elgg-page-footer a:active {
	color: #666;
}




<?php if (!$fixedwidth) { ?>

@media (max-width:1225px) {
	
}

@media (max-width:1020px) {
.interne, 
.elgg-page-walledgarden .elgg-page-header > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-body > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-footer > .elgg-inner, 
.elgg-page-walledgarden .elgg-page-sitemenu > .elgg-inner, 
.elgg-page-default .elgg-page-header > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner, 
.elgg-page-default .elgg-page-sitemenu > .elgg-inner {
		min-width: 200px;
		width: 98%;
		max-width: 100%;
		margin: 0 1%;
	}
	.elgg-page-default .elgg-page-body > .elgg-inner, 
	.elgg-page-default .elgg-page-footer > .elgg-inner {
		min-width: 200px;
		width: 100%;
		max-width: 100%;
	}
	
	/*
	.elgg-page .elgg-layout .elgg-main { width:100%; }
	.elgg-page .elgg-layout .elgg-sidebar { width: 100%; }
	*/
	
}


@media (max-width:980px) {
	
}

@media (max-width:700px) {
	
	.interne, 
	.elgg-page-walledgarden .elgg-page-header > .elgg-inner, 
	.elgg-page-default .elgg-page-header > .elgg-inner { padding: 0 0.5%; }
	.elgg-page-default #transverse > .elgg-inner { padding: 0 0.5%; }
	
	.elgg-page #transverse { display:block; }
	
	/* Layout */
	header, #transverse, section, .elgg-page-footer, #bande { float: none; clear: both; margin:0; padding: 1ex 0; /* display: inline-block; */ max-width: 100%; }
	.elgg-page .elgg-layout .elgg-main { width:100%; /* margin: 1ex 0 2ex 0 !important; padding: 0 !important;*/  }
	.elgg-page .elgg-layout .elgg-sidebar { width: 100%; background:rgba(0,0,0,0.3); box-shadow: 0px 3px 3px -2px #666; margin: 1ex 0 2ex 0 !important; padding: 0 0.5em !important; }
	.elgg-page-walledgarden { padding: 0; margin: 0px auto 0px auto !important; }
	
	.elgg-col-1of3, .elgg-col-2of3, .elgg-col-3of3 { min-width: 100%; }
	.elgg-page .elgg-widgets { min-width: 100%; min-height: 0 !important; }
	
}


<?php } else { ?>

@media (max-width:1020px) {
		.elgg-layout-one-sidebar .elgg-main { min-width:initial;  }
		.elgg-sidebar { min-width:initial; }
		.elgg-sidebar-alt { min-width:initial; }
}


<?php } ?>

