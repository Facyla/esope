<?php
/**
 * Elgg icons - ESOPE version (overrides Core and Fontawesome version)
 *
 * @package Elgg.ESOPE
 * @subpackage UI
 */

?>
/* <style> */

/* ***************************************
	ESOPE ICONS
*************************************** */
.fa {
	/* ESOPE : use regular text color
	color: #CCC;
	*/
}
.fa.elgg-icon {
	font-size: 16px;
}

:focus > .fa,
.fa:hover,
.fa-hover {
	/* ESOPE : use regular text color
	color: #4690D6;
	*/
}

h1 > .fa,
h2 > .fa,
h3 > .fa,
h4 > .fa,
h5 > .fa,
h6 > .fa {
	font-size: 1em;
}

.elgg-icon {
	/*
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat left;
	width: 16px;
	height: 16px;
	*/
	min-width: 16px;
	min-height: 16px;
	margin: 0 2px;
}

.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	position: absolute;
	right: 0;
	bottom: 0;
	/*
	right: -6px;
	bottom: -2px;
	font-size: 25px;
	text-align: right;
	height: auto;
	height: 18px;
	vertical-align: bottom;
	color: white;
	*/
	text-shadow: 0px 2px 1px #000;
	margin: 0;
	cursor: pointer;
}

.elgg-ajax-loader {
	background: white url(<?php echo elgg_get_site_url(); ?>_graphics/ajax_loader_bw.gif) no-repeat center center;
	min-height: 31px;
	min-width: 31px;
}

/* ***************************************
	AVATAR ICONS
*************************************** */
.elgg-avatar {
	position: relative;
	display: inline-block;
}
.elgg-avatar > a > img {
	display: block;
}
.elgg-avatar-tiny > a > img {
	width: 25px;
	height: 25px;
	
	/* remove the border-radius if you don't want rounded avatars in supported browsers */
	border-radius: 3px;
	
	background-clip:  border;
	background-size: 25px;
}
.elgg-avatar-small > a > img {
	width: 40px;
	height: 40px;
	
	/* remove the border-radius if you don't want rounded avatars in supported browsers */
	border-radius: 5px;
	
	background-clip:  border;
	background-size: 40px;
}
.elgg-avatar-medium > a > img {
	width: 100px;
	height: 100px;
}
.elgg-avatar-large {
	width: 100%;
}
.elgg-avatar-large > a > img {
	width: 100%;
	height: auto;
}
.elgg-state-banned {
	opacity: 0.5;
}
