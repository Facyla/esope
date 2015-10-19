<?php
/**
 * Navigation
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// ESOPE : Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$urlicon = $css['urlicon'];
$titlecolor = $css['titlecolor'];
$linkcolor = $css['linkcolor'];
$linkhovercolor = $css['linkhovercolor'];
$color1 = $css['color1'];
$color2 = $css['color2'];
$color3 = $css['color3'];
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
$color13 = $css['color13']; // Couleur de fond du sous-menu déroulant
$font1 = $css['font1'];
$font2 = $css['font2'];
$font3 = $css['font3'];
$font4 = $css['font4'];
$font5 = $css['font5'];
$font6 = $css['font6'];
?>
/* <style> /**/

/* ***************************************
	PAGINATION
*************************************** */
.elgg-pagination {
	margin: 10px 0;
	display: block;
	text-align: center;
}
.elgg-pagination li {
	display: inline-block;
	margin: 0 6px 0 0;
	text-align: center;
}
.elgg-pagination a, .elgg-pagination span {
	border-radius: 4px;
	display: block;
	padding: 2px 6px;
	color: <?php echo $linkcolor; ?>;
	border: 1px solid <?php echo $linkcolor; ?>;
	font-size: 12px;
}
.elgg-pagination a:hover,
.elgg-pagination a:focus,
.elgg-pagination a:active {
	background: <?php echo $linkcolor; ?>;
	color: white;
	text-decoration: none;
}
.elgg-pagination .elgg-state-disabled span {
	color: #CCCCCC;
	border-color: #CCCCCC;
}
.elgg-pagination .elgg-state-selected span {
	background: <?php echo $linkcolor; ?>;
	color: white;
	border-color: <?php echo $linkcolor; ?>;
}

/* ***************************************
	TABS
*************************************** */
.elgg-tabs {
	margin-bottom: 5px;
	border-bottom: 2px solid #cccccc;
	display: table;
	width: 100%;
}
.elgg-tabs li {
	float: left;
	border: 2px solid #ccc;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 10px;
	border-radius: 5px 5px 0 0;
}
.elgg-tabs a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0 10px;
	text-align: center;
	height: 21px;
	color: #999;
}
.elgg-tabs a:hover, 
.elgg-tabs a:focus, 
.elgg-tabs a:active {
	background: white;
	color: #333333;
}
.elgg-tabs .elgg-state-selected {
	border-color: #ccc;
	background: white;
}
.elgg-tabs .elgg-state-selected a {
	position: relative;
	top: 2px;
	background: white;
	color:#333333;
}

/* ***************************************
	BREADCRUMBS
*************************************** */
.elgg-breadcrumbs {
	font-size: 80%;
	font-weight: bold;
	line-height: 1.2em;
	color: #bababa;
}
.elgg-breadcrumbs > li {
	display: inline-block;
}
.elgg-breadcrumbs > li:after{
	content: "\003E";
	padding: 0 4px;
	font-weight: normal;
}
.elgg-breadcrumbs > li > a {
	display: inline-block;
	color: #999;
}
.elgg-breadcrumbs > li > a:hover,
.elgg-breadcrumbs > li > a:focus,
.elgg-breadcrumbs > li > a:active {
	color: <?php echo $linkhovercolor; ?>;
	text-decoration: underline;
}

.elgg-main .elgg-breadcrumbs {
	position: relative;
	top: -6px;
	left: 0;
}

/* ***************************************
	TOPBAR MENU
*************************************** */
.elgg-menu-topbar {
	float: left;
}

.elgg-menu-topbar > li {
	float: left;
}

.elgg-menu-topbar > li > a {
	padding-top: 2px;
	color: #eee;
	margin: 1px 15px 0;
}

.elgg-menu-topbar > li > a:hover, 
.elgg-menu-topbar > li > a:focus, 
.elgg-menu-topbar > li > a:active {
	color: <?php echo $linkcolor; ?>;
	text-decoration: none;
}

.elgg-menu-topbar-alt {
	float: right;
}

.elgg-menu-topbar .elgg-icon {
	vertical-align: middle;
	margin-top: -1px;
}

.elgg-menu-topbar > li > a.elgg-topbar-logo {
	margin-top: 0;
	padding-left: 5px;
	width: 38px;
	height: 20px;
}

.elgg-menu-topbar > li > a.elgg-topbar-avatar {
	width: 18px;
	height: 18px;
}

/* ***************************************
	SITE MENU
*************************************** */
.elgg-menu-site {
	z-index: 1;
}

.elgg-menu-site > li > a {
	font-weight: bold;
	padding: 3px 13px 0px 13px;
	height: 20px;
}

.elgg-menu-site > li > a:hover,
.elgg-menu-site > li > a:focus,
.elgg-menu-site > li > a:active {
	text-decoration: none;
}

.elgg-menu-site-default {
	position: absolute;
	bottom: 0;
	left: 0;
	height: 23px;
}

.elgg-menu-site-default > li {
	float: left;
	margin-right: 1px;
}

.elgg-menu-site-default > li > a {
	color: white;
}

.elgg-menu-site > li > ul {
	display: none;
	background-color: white;
}

.elgg-menu-site > li:hover > ul,
.elgg-menu-site > li:focus > ul,
.elgg-menu-site > li:active > ul {
	display: block;
}

.elgg-menu-site-default > .elgg-state-selected > a,
.elgg-menu-site-default > li:hover > a, 
.elgg-menu-site-default > li:focus > a, 
.elgg-menu-site-default > li:active > a {
	background: white;
	color: #555;
	box-shadow: 2px -1px 1px rgba(0, 0, 0, 0.25);
	border-radius: 4px 4px 0 0;
}

.elgg-menu-site-more {
	position: relative;
	left: -1px;
	width: 100%;
	min-width: 150px;
	border: 1px solid #999;
	border-top: 0;
	border-radius: 0 0 4px 4px;
	box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
}

.elgg-menu-site-more > li > a {
	background-color: white;
	color: #555;
	border-radius: 0;
	box-shadow: none;
}

.elgg-menu-site-more > li > a:hover, 
.elgg-menu-site-more > li > a:focus, 
.elgg-menu-site-more > li > a:active {
	background: <?php echo $linkhovercolor; ?>;
	color: white;
}

.elgg-menu-site-more > li:last-child > a,
.elgg-menu-site-more > li:last-child > a:hover, 
.elgg-menu-site-more > li:last-child > a:focus, 
.elgg-menu-site-more > li:last-child > a:active {
	-webkit-border-radius: 0 0 4px 4px;
	-moz-border-radius: 0 0 4px 4px;
	border-radius: 0 0 4px 4px;
}

.elgg-more > a:before {
	content: "\25BC";
	font-size: smaller;
	margin-right: 4px;
}

/* ***************************************
	TITLE
*************************************** */
.elgg-menu-title {
	float: right;
}

.elgg-menu-title > li {
	display: inline-block;
	margin-left: 4px;
}

/* ***************************************
	FILTER MENU
*************************************** */
.elgg-menu-filter {
	margin-bottom: 5px;
	border-bottom: 2px solid #ccc;
	display: table;
	width: 100%;
}
.elgg-menu-filter > li {
	float: left;
	border: 2px solid #ccc;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 10px;
	border-radius: 5px 5px 0 0;
}
.elgg-menu-filter > li:hover, 
.elgg-menu-filter > li:focus, 
.elgg-menu-filter > li:active {
	background: #dedede;
}
.elgg-menu-filter > li > a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0;
	text-align: center;
	height: 21px;
	color: #999;
}

.elgg-menu-filter > li > a:hover, 
.elgg-menu-filter > li > a:focus, 
.elgg-menu-filter > li > a:active {
	background: #dedede;
	color: #333;
}
.elgg-menu-filter > li > a:focus {
	text-decoration: underline;
}
.elgg-menu-filter > .elgg-state-selected {
	border-color: #ccc;
	background: white;
}
.elgg-menu-filter > .elgg-state-selected > a {
	position: relative;
	top: 2px;
	background: white;
}

/* ***************************************
	PAGE MENU
*************************************** */
.elgg-menu-page {
	margin-bottom: 15px;
}

/* Esope : page menu is a serie of rectangle blocks */
.elgg-menu-page a {
	display: block;
	border-radius: 0;
	
	/* background-color: white; */
	margin: 0 0 3px;
	padding: 4px 4px 4px 8px;
	margin-bottom: 0;
}
.elgg-menu-page a:hover, 
.elgg-menu-page a:focus, 
.elgg-menu-page a:active {
	background-color: #d6d6d6;
	color: #333;
	text-decoration: none;
}
.elgg-menu-page .elgg-state-selected a,
.elgg-menu-page .elgg-state-selected a:hover, 
.elgg-menu-page .elgg-state-selected a:focus, 
.elgg-menu-page .elgg-state-selected a:active {
	background-color:<?php echo $linkcolor; ?>;
	color: #FFF;
	text-decoration: none;
}

.elgg-menu-page li.elgg-state-selected > a {
	/* background-color: <?php echo $linkhovercolor; ?>; */
	color: white;
}
 .elgg-menu-page li.elgg-state-selected {
 background-color:<?php echo $linkcolor; ?>;
}
.elgg-menu-page .elgg-child-menu {
	display: none;
	margin-left: 15px;
}
.elgg-menu-page .elgg-state-selected > .elgg-child-menu {
	display: block;
}
.elgg-menu-page .elgg-menu-closed:before, .elgg-menu-opened:before {
	display: inline-block;
	padding-right: 4px;
}
.elgg-menu-page .elgg-menu-closed:before {
	content: "\25B8";
}
.elgg-menu-page .elgg-menu-opened:before {
	content: "\25BE";
}

/* ***************************************
	HOVER MENU
*************************************** */
.elgg-menu-hover {
	display: none;
	position: absolute;
	z-index: 10000;

	overflow: hidden;

	min-width: 165px;
	max-width: 250px;
	border: solid 1px;
	border-color: #E5E5E5 #999 #999 #E5E5E5;
	background-color: #FFF;
	box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
}
.elgg-menu-hover > li {
	border-bottom: 1px solid #ddd;
}
.elgg-menu-hover > li:last-child {
	border-bottom: none;
}
.elgg-menu-hover .elgg-heading-basic {
	display: block;
}
.elgg-menu-hover a {
	padding: 2px 8px;
	font-size: 92%;
}
.elgg-menu-hover a:hover, 
.elgg-menu-hover a:focus, 
.elgg-menu-hover a:active {
	background: #ccc;
	text-decoration: none;
}
.elgg-menu-hover-admin a {
	color: red;
}
.elgg-menu-hover-admin a:hover, 
.elgg-menu-hover-admin a:focus, 
.elgg-menu-hover-admin a:active {
	color: white;
	background-color: red;
}

/* ***************************************
	SITE FOOTER
*************************************** */
.elgg-menu-footer > li,
.elgg-menu-footer > li > a {
	display: inline-block;
	color:#999;
}

.elgg-menu-footer > li:after {
	content: "\007C";
	padding: 0 4px;
}

.elgg-menu-footer-default {
	float: right;
}

.elgg-menu-footer-alt {
	float: left;
}

.elgg-menu-footer-meta {
	float: left;
}

/* ***************************************
	GENERAL MENU
*************************************** */
.elgg-menu-general > li,
.elgg-menu-general > li > a {
	display: inline-block;
	color: #999;
}

.elgg-menu-general > li:after {
	content: "\007C";
	padding: 0 4px;
}

/* ***************************************
	ENTITY AND ANNOTATION
*************************************** */
<?php // height depends on line height/font size ?>
.elgg-menu-entity, .elgg-menu-annotation {
	float: right;
	margin-left: 15px;
	font-size: 90%;
	color: #aaa;
	line-height: 16px;
	height: 16px;
}
.elgg-menu-entity > li, .elgg-menu-annotation > li {
	margin-left: 15px;
}
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	color: #aaa;
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-entity > li > a, .elgg-menu-annotation > li > a {
	display: block;
}
.elgg-menu-entity > li > span, .elgg-menu-annotation > li > span {
	vertical-align: baseline;
	font-style: italic;
}

/* ***************************************
	OWNER BLOCK
*************************************** */
.elgg-menu-owner-block li a {
	display: block;
	/* border-radius: 0px; */
	background-color: white;
	margin: 0;
	padding: 4px 4px 4px 8px;
}
.elgg-menu-owner-block li a:hover, 
.elgg-menu-owner-block li a:focus, 
.elgg-menu-owner-block li a:active {
}

.elgg-menu-owner-block li a:hover,
.elgg-menu-owner-block li a:focus,
.elgg-menu-owner-block li a:active {
	background-color: <?php echo $linkcolor; ?>;
	color: white;
	text-decoration: none;
}
.elgg-menu-owner-block li.elgg-state-selected > a {
	background-color: <?php echo $linkcolor; ?>;
	color: white;
}

/* ***************************************
	LONGTEXT
*************************************** */
.elgg-menu-longtext {
	float: right;
}

/* ***************************************
	RIVER
*************************************** */
.elgg-menu-river {
	float: right;
	margin-left: 15px;
	font-size: 90%;
	color: #aaa;
	line-height: 16px;
	height: 16px;
}
.elgg-menu-river > li {
	display: inline-block;
	margin-left: 5px;
}
.elgg-menu-river > li > a {
	color: #aaa;
	height: 16px;
}
<?php // need to override .elgg-menu-hz ?>
.elgg-menu-river > li > a {
	display: block;
}
.elgg-menu-river > li > span {
	vertical-align: baseline;
}

/* ***************************************
	SIDEBAR EXTRAS (rss, bookmark, etc)
*************************************** */
.elgg-menu-extras {
	margin-bottom: 15px;
}
.elgg-menu-extras a:focus span {
	outline: thin dotted #000;
}

/* ***************************************
	WIDGET MENU
*************************************** */
.elgg-menu-widget > li {
	/*
	position: absolute;
	top: 4px;
	*/
	display: inline-block;
	width: 18px;
	height: 18px;
	padding: 2px 2px 0 0;
}

.elgg-menu-widget > .elgg-menu-item-collapse {
	left: 5px;
}
.elgg-menu-widget > .elgg-menu-item-delete {
	right: 8px;
}
.elgg-menu-widget > .elgg-menu-item-settings {
	right: 28px;
}
