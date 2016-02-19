<?php
/**
 * CSS buttons
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// ESOPE : Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$linkcolor = $css['linkcolor'];
$linkhovercolor = $css['linkhovercolor'];
$color5 = $css['color5']; // #014FBC
$color6 = $css['color6']; // #033074
$color7 = $css['color7']; // #FF0000
$color8 = $css['color8']; // #990000
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
$color14 = $css['color14'];
$color15 = $css['color15'];
?>
/* <style> /**/
 
/* **************************
	ESOPE BUTTONS
************************** */

/* Base */
.elgg-button {
	font-size: 14px;
	font-weight: bold;
	border-radius: 5px;
	width: auto;
	padding: 2px 4px;
	cursor: pointer;
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	background-color: #ccc;
}
a.elgg-button {
	padding: 3px 6px;
}

.elgg-button:hover,
.elgg-button:focus {
	background: #eee;
}

/* Submit: This button should convey, "you're about to take some definitive action" */
.elgg-button-action, 
.elgg-menu .elgg-button-action,
.elgg-button-submit {
	background: <?php echo $color6; ?>;
	background-color: <?php echo $color6; ?>;
	border-radius: 8px;
	-o-border-radius: 8px;
	border: 0 none;
	box-shadow: none;
	color: <?php echo $color15; ?>;
	text-shadow: 1px 1px 1px #333;
	/* margin-top: 10px; */
	padding: 5px 9px 6px;
	background-image: linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -o-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -moz-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -webkit-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -ms-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, <?php echo $color5; ?>), color-stop(0.8, <?php echo $color6; ?>));
}
.elgg-item .elgg-button-action { margin:0 6px 4px 0; }


.elgg-button-action:hover, 
.elgg-button-action:focus,
.elgg-button-action:active,
.elgg-menu .elgg-button-action:hover,
.elgg-menu .elgg-button-action:focus,
.elgg-menu .elgg-button-action:active,
.elgg-button-submit:hover, 
.elgg-button-submit:focus, 
.elgg-button-submit:active {
	border-color: #000;
	text-decoration: none;
	color: white;
	background: <?php echo $color5; ?>;
	background-image: linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -o-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -moz-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -webkit-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -ms-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, <?php echo $color7; ?>), color-stop(0.8, <?php echo $color8; ?>));
}

.elgg-button-action.elgg-state-disabled, 
.elgg-menu .elgg-button-action.elgg-state-disabled,
.elgg-button-submit.elgg-state-disabled {
	background: #999;
	border-color: #999;
	cursor: default;
}

/* Cancel: This button should convey a negative but easily reversible action (e.g., turning off a plugin) */
.elgg-button-cancel {
	color: #333;
	background: #ddd url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	border: 1px solid #999;
}
.elgg-button-cancel:hover, 
.elgg-button-cancel:focus, 
.elgg-button-cancel:active {
	color: #444;
	background-color: #999;
	background-position: left 10px;
	text-decoration: none;
}

/* Action: This button should convey a normal, inconsequential action, such as clicking a link */
/* ESOPE : idem .elgg-button-submit
.elgg-button-action {
	background: #ccc url(<?php echo elgg_get_site_url(); ?>_graphics/button_background.gif) repeat-x 0 0;
	border:1px solid #999;
	color: #333;
	padding: 2px 15px;
	text-align: center;
	font-weight: bold;
	text-decoration: none;
	text-shadow: 0 1px 0 white;
	cursor: pointer;
	border-radius: 5px;
	box-shadow: none;
}
*/

/* ESOPE : idem .elgg-button-submit
/*
.elgg-button-action:hover,
.elgg-button-action:focus,
.elgg-button-action:active {
	background: #ccc url(<?php echo elgg_get_site_url(); ?>_graphics/button_background.gif) repeat-x 0 -15px;
	color: #111;
	text-decoration: none;
	border: 1px solid #999;
}
*/

/* Delete: This button should convey "be careful before you click me" */
.elgg-button-delete {
	color: #bbb;
	text-decoration: none;
	border: 1px solid #333;
	background: #555 url(<?php echo elgg_get_site_url(); ?>_graphics/button_graduation.png) repeat-x left 10px;
	text-shadow: 1px 1px 0px black;
}
.elgg-button-delete:hover, 
.elgg-button-delete:focus, 
.elgg-button-delete:active {
	color: #999;
	background-color: #333;
	background-position: left 10px;
	text-decoration: none;
}

.elgg-button-dropdown {
	padding:3px 6px;
	text-decoration:none;
	display:block;
	font-weight:bold;
	position:relative;
	margin-left:0;
	color: white;
	background-color: transparent;
	border:1px solid #71B9F7;
	border-radius:4px;
	box-shadow: 0 0 0;
}

.elgg-button-dropdown:after {
	content: " \25BC ";
	font-size:smaller;
}

.elgg-button-dropdown:hover, 
.elgg-button-dropdown:focus
.elgg-button-dropdown:active {
	background-color:#71B9F7;
	text-decoration:none;
	/* border:1px solid #ccc; */
}
.elgg-button-dropdown:focus {
	text-decoration: none;
}
.elgg-button-dropdown.elgg-state-active {
	background: #ccc;
	outline: none;
	color: #333;
	border:1px solid #ccc;
	border-radius:4px 4px 0 0;
}



/* ADF : New custom button style : not too much visible button, for inline actions */

.elgg-menu-item-change-owner a, 
.elgg-menu-item-drop-privileges a, 
.elgg-menu-item-history a, 
.elgg-menu-item-feature a, 
.elgg-menu-item-featured a, 
.elgg-menu-entity .elgg-menu-item-edit a, 
.elgg-menu-entity .elgg-menu-item-reply a, 
.elgg-widget-button {

	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;

	width: auto;
	padding: 2px 4px;
	cursor: pointer;
	outline: none;
	
	-webkit-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	-moz-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.40);

  font-size:12px;
  color:<?php echo $linkcolor; ?>;
  font-weight:normal;
  margin:0 4px 2px 0;
  background:#eee;
  background-image: linear-gradient(top, #EEEEEE 35%, #DDDDDD 80%);
  background-image: -o-linear-gradient(top, #EEEEEE 35%, #DDDDDD 80%);
  background-image: -moz-linear-gradient(top, #EEEEEE 35%, #DDDDDD 80%);
  background-image: -webkit-linear-gradient(top, #EEEEEE 35%, #DDDDDD 80%);
  background-image: -ms-linear-gradient(top, #EEEEEE 35%, #DDDDDD 80%);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, #EEEEEE), color-stop(0.8, #DDDDDD));
}
.elgg-menu-entity .elgg-menu-item-history a:hover, .elgg-menu-entity .elgg-menu-item-history a:focus, .elgg-menu-entity .elgg-menu-item-history a:active, 
.elgg-menu-item-feature a:hover, .elgg-menu-item-feature a:focus, .elgg-menu-item-feature a:active, 
.elgg-menu-item-featured a:hover, .elgg-menu-item-featured a:focus, .elgg-menu-item-featured a:active, 
.elgg-menu-entity .elgg-menu-item-edit a:hover, .elgg-menu-entity .elgg-menu-item-edit a:focus, .elgg-menu-entity .elgg-menu-item-edit a:active, 
.elgg-menu-entity .elgg-menu-item-reply a:hover, .elgg-menu-entity .elgg-menu-item-reply a:focus, .elgg-menu-entity .elgg-menu-item-reply a:active, 
.elgg-widget-button:hover, .elgg-widget-button:focus, .elgg-widget-button:active {
  font-size:12px;
  font-weight:normal;
  color:#333;
  text-decoration:none;
  background:#ddd;
  background-image: linear-gradient(top, #DDDDDD 35%, #CCCCCC 80%);
  background-image: -o-linear-gradient(top, #DDDDDD 35%, #CCCCCC 80%);
  background-image: -moz-linear-gradient(top, #DDDDDD 35%, #CCCCCC 80%);
  background-image: -webkit-linear-gradient(top, #DDDDDD 35%, #CCCCCC 80%);
  background-image: -ms-linear-gradient(top, #DDDDDD 35%, #CCCCCC 80%);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, #DDDDDD), color-stop(0.8, #CCCCCC));
}

/* Différenciation de certaines actions */
.elgg-menu-item-change-owner a, 
.elgg-menu-item-drop-privileges a, 
.elgg-menu-entity li.elgg-menu-item-history a, 
.elgg-menu-entity li.elgg-menu-item-reply a {
  color: #333;
  background: -moz-linear-gradient(center bottom , #CCCCCC 10%, #F6F6F6 60%) repeat scroll 0 0 transparent;
  border: 1px solid #999;
}
.elgg-menu-entity .elgg-menu-item-edit a {
  color: <?php echo $color15; ?>;
  padding: 3px 6px;
	background-image: linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -o-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -moz-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -webkit-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -ms-linear-gradient(top, <?php echo $color5; ?> 35%, <?php echo $color6; ?> 80%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, <?php echo $color5; ?>), color-stop(0.8, <?php echo $color6; ?>));
}
.elgg-menu-entity .elgg-menu-item-edit a:hover, .elgg-menu-entity .elgg-menu-item-edit a:focus, .elgg-menu-entity .elgg-menu-item-edit a:active {
  color:white;
	background-image: linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -o-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -moz-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -webkit-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -ms-linear-gradient(top, <?php echo $color7; ?> 35%, <?php echo $color8; ?> 80%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, <?php echo $color7; ?>), color-stop(0.8, <?php echo $color8; ?>));
}


