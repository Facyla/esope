<?php
/**
 * Navigation
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// Get all needed vars
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
?>

/* ***************************************
	PAGINATION
*************************************** */
.elgg-pagination {
	margin: 20px 0 10px;
	float: left;
	width: 100%;
	display: block;
	text-align: center;
}
.elgg-pagination li {
	display: inline;
	margin: 0 6px 6px 0;
	text-align: center;
}
.elgg-pagination a, .elgg-pagination span {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	padding: 2px 6px;
	color: <?php echo $linkcolor; ?>;
	border: 1px solid <?php echo $linkcolor; ?>;
	font-size: 0.85em;
}
.elgg-pagination a:hover,
.elgg-pagination a:focus,
.elgg-pagination a:active {
	background: #d6d6d6;
	color: #333;
	border: 1px solid #333;
	text-decoration: none;
}
.elgg-pagination .elgg-state-disabled span {
	color: #CCCCCC;
	border-color: #CCCCCC;
}
.elgg-pagination .elgg-state-selected span {
	color: #333;
	border-color: #333;
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
	background: #F0F0F0;
	margin: 0 0 0 10px;
	
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
	border-radius: 5px 5px 0 0;
}
.elgg-tabs a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0 10px;
	text-align: center;
	height: 21px;
	color: #666666;
}
.elgg-tabs a:hover, 
.elgg-tabs a:focus, 
.elgg-tabs a:active {
	background: #FFFFFF;
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
  font-size: 0.8em;
	font-weight: normal;
	line-height: 1.2em;
	color: #999;
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
	padding: 2px 15px 0;
	color: #eee;
	margin-top: 1px;
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

/* ADF : Topbar submenu support */
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

.elgg-menu-site > li >hover,
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

	-webkit-box-shadow: 2px -1px 1px rgba(0, 0, 0, 0.25);
	-moz-box-shadow: 2px -1px 1px rgba(0, 0, 0, 0.25);
	box-shadow: 2px -1px 1px rgba(0, 0, 0, 0.25);

	-webkit-border-radius: 4px 4px 0 0;
	-moz-border-radius: 4px 4px 0 0;
	border-radius: 4px 4px 0 0;
}

.elgg-menu-site-more {
	position: relative;
	left: -1px;
	width: 100%;
	min-width: 150px;
	border: 1px solid #999;
	border-top: 0;

	-webkit-border-radius: 0 0 4px 4px;
	-moz-border-radius: 0 0 4px 4px;
	border-radius: 0 0 4px 4px;

	-webkit-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
	-moz-box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
	box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.25);
}

.elgg-menu-site-more > li > a {
	background-color: white;
	color: #555;

	-webkit-border-radius: 0;
	-moz-border-radius: 0;
	border-radius: 0;

	-webkit-box-shadow: none;
	-moz-box-shadow: none;
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
	ADF MENU
*************************************** */
/* menu dans le header */
header nav {
	position: absolute;
	top: 7px;
	right: 5px;
	font-weight: bold;
	font-size: 0.8em;
}
header nav ul li {
	float: left;
	margin-left: 35px;
	position: relative;
}
header nav ul li a {
	color: #fff;
	padding-bottom:10px;
	text-shadow: 2px 2px 2px #333;
}
header nav ul li#msg a {
	background: transparent url("<?php echo $urlicon; ?>icon-msg.png") left top no-repeat scroll;
	padding: 2px 0 3px 23px;
}
header nav ul li#man a {
	background: transparent url("<?php echo $urlicon; ?>icon-profil.png") left top no-repeat scroll;
	padding: 3px 0 3px 23px;
}
#adf-profil {
    color: #FFFFFF;
    float: left;
    font-size: 0.8em;
    font-weight: bold;
    left: 5px;
    margin-top: -2px;
    position: absolute;
    top: 5px;
    text-shadow: 2px 2px 2px #333333;
}
#adf-profil img {
  float: left;
  margin-right: 5px;
}

header nav ul li ul {
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
header nav ul li ul li {
	float: left;
	margin: 2px 5px 2px 10px;
	width: 166px;
}
header nav ul li ul li a {
	color: #002e3e;
	text-shadow: none;
}
header nav ul li a:hover, 
header nav ul li a:focus, 
header nav ul li a:active { color: #ddd; }

/* Menu de navigation */
#transverse {
	background-image: linear-gradient(top, #FFFFFF 25%, #F6F6F6 75%);
	background-image: -o-linear-gradient(top, #FFFFFF 25%, #F6F6F6 75%);
	background-image: -moz-linear-gradient(top, #FFFFFF 25%, #F6F6F6 75%);
	background-image: -webkit-linear-gradient(top, #FFFFFF 25%, #F6F6F6 75%);
	background-image: -ms-linear-gradient(top, #FFFFFF 25%, #F6F6F6 75%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.25, #FFFFFF), color-stop(0.75, #F6F6F6));
	background-color: #F6F6F6;
	box-shadow: 0px 1px 5px #777;
	-o-box-shadow: 0px 1px 5px #777;
	-moz-box-shadow: 0px 1px 5px #777;
	-webkit-box-shadow: 0px 1px 5px #777;
	position: relative;
	border-bottom: 1px solid #ccc;
	width: 700px;
}
#transverse nav {
	float: left;
	font-family: itc-gothic;
	font-size: 1.25em;
}
#transverse nav ul { width: 650px; }
#transverse nav ul li {
	float: left;
	border-right: 1px solid #ccc;
	padding-left: 1px;
	position: relative;
}
#transverse nav ul li:first-child {
	border-left: 1px solid #ccc;
}
#transverse nav ul li ul li:first-child { border-left: 0; }
#transverse nav ul li a {
	color: #333;
	float: left;
	padding: 10px 14px;
}
#transverse nav ul li a.active, 
#transverse nav ul li a.elgg-state-selected, 
#transverse nav ul li a:hover, 
#transverse nav ul li a:focus, 
#transverse nav ul li a:active {
	background-color: #ccc;
	text-decoration: none;
}
#transverse nav ul li ul {
	background-color: #ccc;
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
#transverse nav ul li ul li {
	clear: left;
	background: #ccc;
	width: 200px;
	float: left;
}
#transverse nav ul li ul li a {
	float: left;
	width: 181px;
	padding: 3px 10px;
	font-size: 0.9em;
	border-bottom: 1px solid #fff;
}

#transverse nav ul li.groups ul { width: 302px; }
#transverse nav ul li.groups ul li { width: 300px; }
#transverse nav ul li.groups ul li a { width: 281px; }

#transverse nav ul li.thematiques ul { width: 372px; }
#transverse nav ul li.thematiques ul li { width: 370px; }
#transverse nav ul li.thematiques ul li a { width: 351px; }

#transverse nav ul li ul li img {
  float:left; 
  margin-right:6px;
}
#transverse nav ul li ul li a:hover, 
#transverse nav ul li ul li a:focus, 
#transverse nav ul li ul li a:active {
	background: #333;
	color: #fff;
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
	
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
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

/*********    Change tab hover here    ********/
.elgg-menu-filter > li > a:hover, 
.elgg-menu-filter > li > a:focus, 
.elgg-menu-filter > li > a:active {
	background: #dedede;
	color: #000;
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

.elgg-menu-page a {
	display: block;
	
	-webkit-border-radius: 0;
	-moz-border-radius: 0;
	border-radius: 0;
	
	/* background-color: white; */
	margin: 0 0 3px;
	padding: 5px 10px 6px 10px;
	font-weight: bold;
	font-size: 14px;
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
	color: #FFF !important;
	text-decoration: none;
}


/****** Change colour for 'ALL Groups' link in sidebar *********/
.elgg-menu-page li.elgg-state-selected > a {
	/* background-color: <?php echo $linkhovercolor; ?>; */
	color: #FFF;
}
 .elgg-menu-page li.elgg-state-selected {
 background-color:<?php echo $linkcolor; ?>;
}
.elgg-menu-page .elgg-child-menu {
	display: none;
	margin-left: 15px;
}
.elgg-menu-page .elgg-menu-closed:before, .elgg-menu-opened:before {
	display: inline-block;
	padding-right: 4px;
}
.elgg-menu-page .elgg-menu-closed:before {
	content: "\002B";
}
.elgg-menu-page .elgg-menu-opened:before {
	content: "\002D";
}

/* ***************************************
	HOVER MENU
*************************************** */
.elgg-menu-hover {
	display: none;
	position: absolute;
	z-index: 10000;

	width: 165px;
	border: solid 1px;
	border-color: #E5E5E5 #999 #999 #E5E5E5;
	background-color: #FFF;
	
	-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
	-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.50);
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
	FOOTER
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

/* ***************************************
	ENTITY AND ANNOTATION
*************************************** */
<?php // height depends on line height/font size ?>
.elgg-menu-entity, elgg-menu-annotation {
	float: right;
	/* margin-left: 15px; */ /* modif */
	font-size: 90%;
	color: #666;
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
}
.elgg-menu-item-membership {}
.elgg-menu-item-members {}


/* ***************************************
	OWNER BLOCK
*************************************** */
.elgg-menu-owner-block li a {
	display: block;
	
/*
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
*/
	
	background-color: white;
	padding: 6px 10px 5px 35px;
	margin: 0;
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
	background-position: 9px -19px;
}

/* Various tools icons : activity, event-calendar, announcements, blog, file, discussion, brainstorm, bookmarks, pages */
.elgg-menu-item-activity a { padding-left:32px; background: url("<?php echo $urlicon; ?>activity.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-activity a:hover, .elgg-menu-item-activity a:focus, .elgg-menu-item-activity a:active { background: url("<?php echo $urlicon; ?>activity.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-event-calendar a { padding-left:32px; background: url("<?php echo $urlicon; ?>event_calendar.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-event-calendar a:hover, .elgg-menu-item-event-calendar a:focus, .elgg-menu-item-event-calendar a:active { background: url("<?php echo $urlicon; ?>event_calendar.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-announcements a { padding-left:32px; background: url("<?php echo $urlicon; ?>announcements.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-announcements a:hover, .elgg-menu-item-announcements a:focus, .elgg-menu-item-announcements a:active { background: url("<?php echo $urlicon; ?>announcements.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?>; color: #fff; }
.elgg-menu-item-blog a { padding-left:32px; background: url("<?php echo $urlicon; ?>blog.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-blog a:hover, .elgg-menu-item-blog a:focus, .elgg-menu-item-blog a:active { background: url("<?php echo $urlicon; ?>blog.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-file a { padding-left:32px; background: url("<?php echo $urlicon; ?>file.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-file a:hover, .elgg-menu-item-file a:focus, .elgg-menu-item-file a:active { background: url("<?php echo $urlicon; ?>file.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-owner-block .elgg-menu-item-discussion a { background: url("<?php echo $urlicon; ?>discussion.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-owner-block .elgg-menu-item-discussion a:hover, .elgg-menu-owner-block .elgg-menu-item-discussion a:focus, .elgg-menu-owner-block .elgg-menu-item-discussion a:active { background: url("<?php echo $urlicon; ?>discussion.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-brainstorm a { padding-left:32px; background: url("<?php echo $urlicon; ?>brainstorm.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-brainstorm a:hover, .elgg-menu-item-brainstorm a:focus, .elgg-menu-item-brainstorm a:active { background: url("<?php echo $urlicon; ?>brainstorm.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-bookmarks a { padding-left:32px; background: url("<?php echo $urlicon; ?>bookmarks.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-bookmarks a:hover, .elgg-menu-item-bookmarks a:focus, .elgg-menu-item-bookmarks a:active { background: url("<?php echo $urlicon; ?>bookmarks.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
.elgg-menu-item-pages a { padding-left:32px; background: url("<?php echo $urlicon; ?>pages.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-pages a:hover, .elgg-menu-item-pages a:focus, .elgg-menu-item-pages a:active { background: url("<?php echo $urlicon; ?>pages.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }


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

.elgg-sidebar #site-categories h2 {
    background: none repeat scroll 0 0 #333333;
    border-radius: 3px 3px 0 0;
    clear: both;
    color: #FFFFFF;
    font-size: 1.3em;
    font-weight: normal;
    margin: 0;
    padding: 6px 10px 4px;
    text-transform: uppercase;
}
.elgg-sidebar #site-categories ul li a {
   padding: 6px 10px 5px;
}

