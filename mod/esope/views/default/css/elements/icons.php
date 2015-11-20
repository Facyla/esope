<?php
/**
 * Elgg icons
 *
 * @package Elgg.Core
 * @subpackage UI
 */

?>
/* <style> */

/* ***************************************
	ICONS
*************************************** */
.fa {
	/* ESOPE : use text color
	color: #CCC;
	*/
}
.fa.elgg-icon {
	font-size: 16px;
}

:focus > .fa,
.fa:hover,
.fa-hover {
	/* ESOPE : use text color
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
	min-width: 16px;
	min-height: 16px;
	margin: 0 2px;
}

.elgg-avatar > .elgg-icon-hover-menu {
	display: none;
	position: absolute;
	right: 0;
	bottom: 0;
	margin: 0;
	cursor: pointer;
	text-shadow: 0px 1px 1px #000;
	color: white;
	font-size: 25px;
	text-align: right;
	height: auto;
	height: 18px;
	vertical-align: bottom;
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
