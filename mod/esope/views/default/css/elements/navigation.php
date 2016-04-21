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

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') { $fixedwidth = false; } else { $fixedwidth = true; }

?>
/* <style> /**/

/* ***************************************
	ESOPE PAGINATION
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
	font-size: 0.75rem;
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
	font-size: 0.72rem;
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
	ESOPE MENU SUPERIEUR
*************************************** */
/* menu dans le header */
.elgg-page-header .elgg-menu-topbar {
	font-size: 0.8em;
	font-weight: bold;
	margin-top:0;
}
.elgg-menu-topbar li { margin: 0 2em 0 0; }
.elgg-menu-topbar-alt li { margin: 0 0 0 2em; }
.elgg-menu-topbar li:last-child { margin-right:0; }
.elgg-menu-topbar-alt li:first-child { margin-left:0; }
.elgg-menu-topbar li a {
	color: #fff;
	text-shadow: 1px 1px 0px #333;
	margin: 0 0 0.3em 0;
	padding: 0.3em 1px;
	display:inline-block;
}
.elgg-page-header .elgg-menu-topbar li a:hover, .elgg-page-header .elgg-menu-topbar li a:focus, .elgg-page-header .elgg-menu-topbar li a:active { color: #ddd; }

.elgg-menu-topbar .elgg-menu-counter { display:inline-block; padding:1px 4px; background:red; border-radius:8px; font-size:10px; font-family:arial; font-weight:bold; text-shadow:none; }

.elgg-page-header .elgg-menu-topbar li#msg a {}
.elgg-page-header .elgg-menu-topbar li#man a {}
#esope-profil {}
#esope-profil img { float: left; margin-right: 0.5ex; }

.elgg-page-header .elgg-menu-topbar li ul {
	background: #fff;
	float: left;
	left: 0;
	top:20px; /* ajouté */
	position: absolute;
	padding: 5px 0;
	box-shadow: 0px 0px 5px #002e3e inset;
	-moz-box-shadow: 0px 0px 5px #002e3e inset;
	-webkit-box-shadow: 0px 0px 5px #002e3e inset;
	-o-box-shadow: 0px 0px 5px #002e3e inset;
}
.elgg-page-header .elgg-menu-topbar li ul li {
	float: left;
	margin: 2px 5px 2px 10px;
	width: 166px;
}
.elgg-page-header .elgg-menu-topbar li ul li a {
	color: #002e3e;
	text-shadow: none;
}

/* ESOPE : Topbar submenu support */
.elgg-menu-topbar > li > ul {
	display: none;
	position:absolute;
  background-color: transparent;
  padding-top:4px; 
  left:12px; top:21px; 
  width:200px;
}

.elgg-menu-topbar > li > ul a {
  background-color: #333;  
  color:white; 
  padding: 2px 2px 4px 6px;
}
.elgg-menu-topbar > li > ul a:hover, 
.elgg-menu-topbar > li > ul a:focus, 
.elgg-menu-topbar > li > ul a:active {
  text-decoration:none;
  color:<?php echo $linkcolor; ?>;
}

.elgg-menu-topbar > li:hover > ul, 
.elgg-menu-topbar > li:focus > ul, 
.elgg-menu-topbar > li:active > ul {
  display: block;
}

/* Header nav icons (using semantic UI or awesome fonts) */
.elgg-page-header .elgg-menu-topbar .fa { margin-right: 0.5em; }

.elgg-page-header h1 {
	font-family: <?php echo $font2; ?>;
	text-transform: uppercase;
	float: left;
	color:#ffffff;
	font-size:48px;
	font-weight:normal;
	margin:0.5ex auto;
}
.elgg-page-header h1 a { color:#ffffff; }
.elgg-page-header h1 a:hover,
.elgg-page-header h1 a:focus,
.elgg-page-header h1 a:active { color:#ffffff; text-decoration:none; }
.elgg-page-header h1 span { font-size: 1.4em; }



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
	ESOPE MENU DE NAVIGATION
*************************************** */
#transverse {
	background-color: #F6F6F6;
	position: relative;
}
#transverse .elgg-menu-navigation {
	float: left;
	font-family: <?php echo $font3; ?>;
	font-size: 1.25em;
}
#transverse .elgg-menu-navigation { width: 650px; }
#transverse .elgg-menu-navigation li {
	float: left;
	border-right: 1px solid #ccc;
	padding-left: 1px;
	position: relative;
}
#transverse .elgg-menu-navigation li:first-child {
	border-left: 1px solid #ccc;
}
#transverse .elgg-menu-navigation li ul li:first-child { border-left: 0; }
#transverse .elgg-menu-navigation li a {
	color: #333;
	float: left;
	padding: 10px 14px;
}
#transverse .elgg-menu-navigation li a.active, 
#transverse .elgg-menu-navigation li a.elgg-state-selected, 
#transverse .elgg-menu-navigation li a:hover, 
#transverse .elgg-menu-navigation li a:focus, 
#transverse .elgg-menu-navigation li a:active {
	background-color: #ccc;
	text-decoration: none;
}
#transverse .elgg-menu-navigation li ul {
	background: <?php echo $color13; ?>;
	position: absolute;
	top: 40px; /* au lieu de 44px */
	left: -1px;
	z-index: 2;
	box-shadow: 2px 2px 3px #333;
	-moz-box-shadow: 2px 2px 3px #333;
	-webkit-box-shadow: 2px 2px 3px #333;
	-o-box-shadow: 2px 2px 3px #333;
	width: 202px;
}
#transverse .elgg-menu-navigation li ul li {
	clear: left;
	background: <?php echo $color13; ?>;
	width: 200px;
	float: left;
}
#transverse .elgg-menu-navigation li ul li a {
	float: left;
	width: 181px;
	padding: 2px 10px;
	font-size: 0.9em;
	border-bottom: 1px solid #fff;
}

/* Groups sublevels */
#transverse .elgg-menu-navigation li.groups ul { width: 402px; }
#transverse .elgg-menu-navigation li.groups ul li { width: 400px; }
#transverse .elgg-menu-navigation li.groups ul li a { width: 381px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup { margin-left: 6px; width: 394px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup a { width: 375px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-2 { margin-left: 12px; width: 388px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-2 a { width: 369px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-3 { margin-left: 18px; width: 382px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-3 a { width: 363px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-4 { margin-left: 24px; width: 376px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-4 a { width: 357px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-5 { margin-left: 30px; width: 370px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-5 a { width: 351px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-6 { margin-left: 36px; width: 364px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-6 a { width: 345px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-7 { margin-left: 42px; width: 358px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-7 a { width: 339px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-8 { margin-left: 48px; width: 352px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-8 a { width: 333px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-9 { margin-left: 54px; width: 346px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-9 a { width: 327px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-10 { margin-left: 60px; width: 340px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-10 a { width: 321px; }

#transverse .elgg-menu-navigation li.thematiques ul { width: 372px; }
#transverse .elgg-menu-navigation li.thematiques ul li { width: 370px; }
#transverse .elgg-menu-navigation li.thematiques ul li a { width: 351px; }

#transverse .elgg-menu-navigation li ul li img {
  float:left; 
  margin-right:6px;
}
#transverse .elgg-menu-navigation li ul li a:hover, 
#transverse .elgg-menu-navigation li ul li a:focus, 
#transverse .elgg-menu-navigation li ul li a:active {
	background: #333;
	color: #fff;
}

.elgg-menu-navigation {  }
.elgg-menu-navigation > li { float: left; }
.elgg-menu-navigation li ul { z-index: 100; }
.elgg-menu-navigation li.group-invites, .elgg-menu-navigation li.group-invites,
.elgg-menu-navigation li.invites, .elgg-menu-navigation li.invites { margin:-6px 0 0 4px; }
.elgg-menu-navigation li.group-invites, .elgg-menu-navigation li.invites { margin:-8px 0 0 -22px; border:0; }
#transverse .elgg-menu-navigation li.group-invites a, #transverse ul li.group-invites a:hover, #transverse ul li.group-invites a:focus, #transverse ul li.group-invites a:active, #transverse .elgg-menu-navigation li.invites a, #transverse ul li.invites a:hover, #transverse ul li.invites a:focus, #transverse ul li.invites a:active {
	float: right;
	background: #CD190A;
	color: #fff;
	font-size: 0.75rem;
	font-weight: bold;
	padding: 2px 5px 2px 6px;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	-o-border-radius: 4px;
	box-shadow: 1px 1px 2px #333333;
	-moz-box-shadow: 1px 1px 2px #333333;
	-webkit-box-shadow: 1px 1px 2px #333333;
	-o-box-shadow: 1px 1px 2px #333333;
}

.elgg-menu-navigation li, #transverse ul li { list-style-type: none; }

#transverse .elgg-menu-navigation .elgg-menu-counter { border: 0 none; left: -20px; margin: 0; padding: 0; position: relative; }
#transverse .elgg-menu-navigation li.elgg-menu-counter a { background: red; border-radius: 8px; color: white; font-family: arial; font-size: 0.75rem; font-weight: bold; margin: 2px; padding: 1px 4px; text-shadow: none; }



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
	padding-top: 0.5rem;
	padding-bottom: 0.5rem;
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


/* ESOPE : Sidebar */
.elgg-sidebar { width: 211px; float: right; }
.elgg-sidebar ul.elgg-menu-page, elgg-sidebar ul.elgg-menu-groups-my-status {
	background: #fff;
	float: left;
	width: 211px;
}
.elgg-sidebar ul.elgg-menu-page > li, elgg-sidebar ul.elgg-menu-groups-my-status > li {
	border-bottom: 1px solid #CCCCCC;
	float: left;
	/* width: 211px; */
	width:100%;
}
.elgg-sidebar ul.elgg-menu-page li h3 {
	background: #333333;
	border-radius: 3px 3px 0 0;
	-moz-border-radius: 3px 3px 0 0;
	-webkit-border-radius: 3px 3px 0 0;
	-o-border-radius: 3px 3px 0 0;
	color: #fff;
	font-weight: normal;
	margin: 0;
	padding: 4px 10px;
	text-transform: uppercase;
}
.elgg-sidebar .elgg-menu-page li:first-child, .elgg-sidebar .elgg-menu-page li:last-child, .elgg-sidebar .elgg-menu-groups-my-status li:first-child, .elgg-sidebar .elgg-menu-groups-my-status li:last-child { border-bottom: 0 none; }
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a { color: #333333; font-weight: normal; }
/*
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a span {
	color: #002e6f;
	float: left;
	font-family: <?php echo $font2; ?>;
	font-size: 1.7em;
	font-weight: bold;
	line-height: 0.7em;
	margin-right: 5px;
	text-shadow: 0 2px 2px #999999;
}
*/



/* ***************************************
	WIDGET MENU
*************************************** */
.elgg-menu-widget > li {
	/*
	position: absolute;
	top: 4px;
	*/
	display: inline-block;
	/*
	width: 18px;
	height: 18px;
	padding: 2px 2px 0 0;
	*/
	padding: 0;
}

.elgg-menu-widget > .elgg-menu-item-collapse {
	/* left: 5px; */
}
.elgg-menu-widget > .elgg-menu-item-delete {
	/* right: 8px; */
}
.elgg-menu-widget > .elgg-menu-item-settings {
	/* right: 28px; */
}
.elgg-menu-widget { width: auto; float: right; }




/* ESOPE Responsive menus */
.menu-topbar-toggle, .menu-navigation-toggle, .menu-sidebar-toggle { display:none; font-weight:bold; padding: 0 0 0.5ex 0; width:100%; font-size:1.5rem; }

/* Responsive menu */
.menu-sidebar-toggle { text-align: left; }


<?php if (!$fixedwidth) { ?>

/* Pour la fluidité en général */
.elgg-layout-one-sidebar .elgg-main { width: 70%; min-width: 0; padding:1.5%; }
.elgg-sidebar { width: 24%; min-width: 211px; margin:0 0 0 1%; }
.elgg-sidebar ul.elgg-menu-page, elgg-sidebar ul.elgg-menu-groups-my-status { width:100%; }
.elgg-sidebar-alt { width: 24%; min-width: 211px; margin:0 1% 0 0; padding:0; }
.elgg-layout-two-sidebar .elgg-main { width: 48%; padding:13px 1%; }
.elgg-layout-two-sidebar .elgg-sidebar {  }
.elgg-layout-two-sidebar .elgg-sidebar_alt {  }

/* Menus */
.elgg-menu-navigation { width:auto; }



@media (max-width:1020px) {
	/* Sidebar menu */
	.elgg-sidebar { display:none; }
	.elgg-sidebar * { min-width:0; }
	.elgg-sidebar.menu-enabled { display:block; }
	.elgg-page .elgg-layout .elgg-sidebar { background: none !important; box-shadow: none !important; }
	.menu-sidebar-toggle { display:inline-block; text-align: center; padding: 0.3em; }
}


@media (max-width:980px) {
	.elgg-sidebar { min-width: 50px; width: 26%; margin:0 0 0 0; }
	.elgg-layout-one-sidebar .elgg-main { min-width: 140px; width: 70%; padding:1%; }
}


@media (max-width:700px) {
	
	/* Top menu */
	.menu-topbar-toggle { display:inline-block; text-align: center; padding: 0.3em 0; }
	.elgg-menu-topbar { display:none; }
	.elgg-menu-topbar * { min-width:0; }
	.elgg-menu-topbar.menu-enabled { display:block; }
	.elgg-page-header .elgg-menu-topbar { float:none; width:100%; position:initial; font-size:1rem; padding: 0; margin: 0; }
	.elgg-page-header .elgg-menu-topbar li { padding: 0; margin:0; float: none; }
	.elgg-page-header .elgg-menu-topbar li a { padding: 0 0.5em; margin:0; }
	.elgg-page-header .elgg-menu-topbar li, .elgg-page-header .elgg-menu-topbar li li { width:100%; margin-left:0; font-size:100%; line-height: 2; border-right:0; border-top: 1px solid #FFF; border-top: 1px solid #ccc; }
	#menu-topbar.elgg-menu-topbar #user img { float: none; margin-right: 0; }
	.elgg-page-header .elgg-menu-topbar li a, .elgg-page-header .elgg-menu-topbar li li a { width:100%; display:inline-block; padding-left:0; padding-right:0; font-size:1rem;  }
	.elgg-page-header .elgg-menu-topbar li.invites { max-width: 5ex; position: absolute; right: 1ex; border: 0 !important; margin: 0 0 !important; text-align: center; display: inline; text-indent: 0; z-index:2; font-size:1rem; }
	.elgg-page-header .elgg-menu-topbar li.invites a { padding: 0; margin: 2px 0; }
	
	.elgg-page-header .elgg-menu-topbar li#msg > a { max-width: 70%; }
	.elgg-page-header .elgg-menu-topbar li#msg a.elgg-menu-counter { position: relative; width: auto; max-width: 30%; padding: 0 1em; float: right; border-radius: 0; }
	
	/* Navigation menu */
	/* Toggle menu */
	.menu-navigation-toggle { display:inline-block; text-align: center; padding: 0.3em 0; }
	#transverse .elgg-menu-navigation { display:none; float: none; width:100%; padding: 0; margin: 0; font-size:1rem; }
	#transverse .elgg-menu-navigation * { min-width:0; }
	#transverse .elgg-menu-navigation.menu-enabled { display:inline-block; }
	#transverse .elgg-menu-navigation li { width: 100%; display:inline-block; padding:0; border-left:0 !important; border-right:0 !important; border-top: 1px solid #FFF; border-bottom: 1px solid #ccc; font-size:1rem; }
	#transverse .elgg-menu-navigation li a { width:100%; padding: 0.5em 0; text-indent: 0.5em; background: transparent; }
	#transverse .elgg-menu-navigation li li { width:100%; display:inline-block; border-left:0; border-right:0; border-top: 1px solid #FFF; border-bottom: 1px solid #ccc; font-size:0.9em; text-indent: 3ex; }
	#transverse .elgg-menu-navigation li li a { width:100%; padding-left:0; padding-right:0;  }
	/* Always display submenu (with indent) */
	#transverse .elgg-menu-navigation li ul { display:block; padding:0; width: 100% !important; position:initial; top:0; left:0; }
	#transverse .elgg-menu-navigation li ul.hidden { display: block !important; }
	#transverse .elgg-menu-navigation li ul li { width: 100% !important; border:0; padding:0; text-indent:0; }
	#transverse .elgg-menu-navigation li ul li a { width: 100% !important; border:0; padding:0; text-indent:2em; }
	#transverse .elgg-menu-navigation li ul li img { float: none; margin-right: 0.3em; display: inline-block; line-height : 25px; }
	
	/* Sidebar menu */
	.elgg-sidebar { display:none; }
	.elgg-sidebar * { min-width:0; }
	.elgg-sidebar.menu-enabled { display:block; }
	.elgg-page .elgg-layout .elgg-sidebar { background: none !important; box-shadow: none !important; }
	.menu-sidebar-toggle { display:inline-block; text-align: center; padding: 0.3em; }
	
	/* Footer menu */
	.elgg-page .elgg-page-footer ul { width: 100%; max-width: none; max-width: 100%; }
	.elgg-page .elgg-page-footer ul li { margin: 0; padding: 0; float:none; width: 100%; }
	.elgg-page .elgg-page-footer ul li a { margin: 0; padding: 0.5rem 0; display: inline-block; width: 100%; }
	
	
}



/*
@media (max-width:600px) {
	.elgg-sidebar { width: 100%; margin:0 0 0 0; }
	.elgg-sidebar { height: 70px; overflow: hidden; border-bottom: 3px solid black; }
	.elgg-layout-one-sidebar .elgg-main { width: 100%; padding:1%; }
}
*/

<?php } ?>

