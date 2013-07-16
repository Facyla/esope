<?php
/**
 * CSS form/input elements
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$color1 = $css['color1'];
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
?>

/* ***************************************
	Form Elements
*************************************** */
fieldset > div {
	margin-bottom: 15px;
}
fieldset > div:last-child {
	margin-bottom: 0;
}
.elgg-form-alt > fieldset > .elgg-foot {
	border-top: 1px solid #CCC;
	padding: 10px 0;
}

label {
	font-weight: bold;
	color: #333;
	font-size: 0.9em;
}

input, textarea {
	border: 1px solid #ccc;
	color: #666;
	font: 0.9em Arial, Helvetica, sans-serif;
	width: 100%;	
	border-radius: none;
  padding: 3px 5px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
input:focus, textarea:focus {
	border: solid 1px #4690d6;
	background: #e4ecf5;
	color:#333;
}

textarea {
	height: 200px;
}


.elgg-longtext-control {
	float: right;
	margin-left: 14px;
	font-size: 80%;
	cursor: pointer;
}


.elgg-input-access {
	margin:5px 0 0 0;
}

input[type="checkbox"],
input[type="radio"] {
  margin: 0 3px 0 5px;
	padding:0;
	border:none;
	width:auto;
}
select {
 border: 1px solid #ccc;
 font-size: 0.9em;
}
.elgg-input-checkboxes.elgg-horizontal li,
.elgg-input-radio.elgg-horizontal li {
	display: inline;
	padding-right: 10px;
}
.elgg-input-checkboxes li label, .elgg-input-radio li label {
  font-weight: normal;
}

.elgg-form-account input[type="text"],
.elgg-form-account input[type="password"] {
	width: 300px;
}

form.elgg-form {
	background: #f6f6f6;
	float: left;
	padding: 8px 12px;
	width: 92%;
}
form.elgg-form-groups-find {
	margin: 10px 0 20px;
}
form.elgg-form label {
	/* float: left; */
	font-size: 14px;
	margin-right: 20px;
}
form.elgg-form-groups-find label {
	margin-top: 5px;
}
form.elgg-form input[type=text] {
	border-radius: 0;
	/* float: left; */
	font-size: 0.9em;
}

form.elgg-form-groups-search, 
form.elgg-form-groups-find {
	border: 1px solid #d6d6d6;
	/* float: left; */
}
.event_add_or_remove_form {
	margin-top:20px;
	border: 1px solid #d6d6d6;
	padding: 12px 20px;
	background:#F6F6F6;
}
form.elgg-form input[type=text] {
	/* float: left; */
}
form.elgg-form-groups-find input {
	height: 30px;
	margin: 0 10px 0 0;
}
.elgg-sidebar form.elgg-form {
  border: 1px solid #d6d6d6;
	width: auto;
	padding: 12px 10px 12px 14px;
}
.elgg-sidebar form.elgg-form input[type=text] {
	width: auto;
}
.elgg-widget-edit {
  float:left;
  background: #f6f6f6;
}

section div.module form.elgg-form-widgets-save {
	float: left;
	width: 280px;
	padding: 0px 5px 10px 5px;
	background: transparent;
	border-bottom: 0px solid #ccc;
}
section div.module form.elgg-form-widgets-save label {
	font-weight: bold;
	font-size: 0.9em;
	float: left;
	clear: left;
	margin-right: 10px;
}
section div.module form.elgg-form-widgets-save select {
	border: 1px solid #002e3e;
	margin: 5px 0 10px;
	float: left;
}
section div.module form.elgg-form-widgets-save * { max-width:100%; }

input.button {
	border-radius: 5px;
	border: 1px solid #002e3e;
	color: #fff;
	text-shadow: 1px 1px 1px #333;
	margin-top: 10px;
	padding: 2px 5px 4px;
	background-image: linear-gradient(top, #014FBC 35%, #033074 80%);
	background-image: -o-linear-gradient(top, #014FBC 35%, #033074 80%);
	background-image: -moz-linear-gradient(top, #014FBC 35%, #033074 80%);
	background-image: -webkit-linear-gradient(top, #014FBC 35%, #033074 80%);
	background-image: -ms-linear-gradient(top, #014FBC 35%, #033074 80%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.35, #014FBC), color-stop(0.8, #033074));
}

/* Formulaire de recherche principale */
#transverse form, header form {
	float: right;
	border: 2px solid <?php echo $color1; ?>;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	-o-border-radius: 10px;
	box-shadow: 0 0 2px #999999 inset;
	-o-box-shadow: 0 0 2px #999999 inset;
	-moz-box-shadow: 0 0 2px #999999 inset;
	-webkit-box-shadow: 0 0 2px #999999 inset;
	height: 27px;
	margin-top: 6px;
}
form input#adf-search-input {
	border: 0 none;
	border-radius: 10px 0 0 10px;
	-moz-border-radius: 10px 0 0 10px;
	-webkit-border-radius: 10px 0 0 10px;
	-o-border-radius: 10px 0 0 10px;
	height: 27px;
	padding: 2px 7px;
	width: 210px;
	float: left;
	color: #999;
	font-size: 0.8em;
}
form input#adf-search-input:active, 
form input#adf-search-input:focus {
  color:#333;
}
form input#adf-search-submit-button {
	background: #ccc;
	border-radius: 0 7px 7px 0;
	-moz-border-radius: 0 7px 7px 0;
	-webkit-border-radius: 0 7px 7px 0;
	-o-border-radius: 0 7px 7px 0;
	float: right;
	padding: 5px 7px 5px 8px;
	width:auto;
}
form input#adf-search-submit-button:hover, 
form input#adf-search-submit-button:active, 
form input#adf-search-submit-button:focus {
  background-color: #999;
  border:1px solid #999;
}



/* ***************************************
	FRIENDS PICKER
*************************************** */
.friends-picker-main-wrapper {
	margin-bottom: 15px;
}
.friends-picker-container h3 {
	font-size:4em !important;
	text-align: left;
	margin:10px 0 20px !important;
	color:#999 !important;
	background: none !important;
	padding:0 !important;
}
.friends-picker .friends-picker-container .panel ul {
	text-align: left;
	margin: 0;
	padding:0;
}
.friends-picker-wrapper {
	margin: 0;
	padding:0;
	position: relative;
	width: 100%;
}
.friends-picker {
	position: relative;
	overflow: hidden;
	margin: 0;
	padding:0;
	width: 730px;
	height: auto;
	background-color: #dedede;
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
}
.friendspicker-savebuttons {
	background: white;
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	
	margin:0 10px 10px;
}
.friends-picker .friends-picker-container { /* long container used to house end-to-end panels. Width is calculated in JS  */
	position: relative;
	left: 0;
	top: 0;
	width: 100%;
	list-style-type: none;
}
.friends-picker .friends-picker-container .panel {
	float:left;
	height: 100%;
	position: relative;
	width: 730px;
	margin: 0;
	padding:0;
}
.friends-picker .friends-picker-container .panel .wrapper {
	margin: 0;
	padding:4px 10px 10px 10px;
	min-height: 230px;
}
.friends-picker-navigation {
	margin: 0 0 10px;
	padding:0 0 10px;
	border-bottom:1px solid #ccc;
}
.friends-picker-navigation ul {
	list-style: none;
	padding-left: 0;
}
.friends-picker-navigation ul li {
	float: left;
	margin:0;
	background:white;
}
.friends-picker-navigation a {
	font-weight: bold;
	text-align: center;
	background: white;
	color: #999;
	text-decoration: none;
	display: block;
	padding: 0;
	width:20px;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
.tabHasContent {
	background: white;
	color:#333 !important;
}
.friends-picker-navigation li a:hover {
	background: #333;
	color:white !important;
}
.friends-picker-navigation li a.current {
	background: #4690D6;
	color:white !important;
}
.friends-picker-navigation-l, .friends-picker-navigation-r {
	position: absolute;
	top: 46px;
	text-indent: -9000em;
}
.friends-picker-navigation-l a, .friends-picker-navigation-r a {
	display: block;
	height: 40px;
	width: 40px;
}
.friends-picker-navigation-l {
	right: 48px;
	z-index:1;
}
.friends-picker-navigation-r {
	right: 0;
	z-index:1;
}
.friends-picker-navigation-l {
	background: url("<?php echo elgg_get_site_url(); ?>_graphics/friendspicker.png") no-repeat left top;
}
.friends-picker-navigation-r {
	background: url("<?php echo elgg_get_site_url(); ?>_graphics/friendspicker.png") no-repeat -60px top;
}
.friends-picker-navigation-l:hover {
	background: url("<?php echo elgg_get_site_url(); ?>_graphics/friendspicker.png") no-repeat left -44px;
}
.friends-picker-navigation-r:hover {
	background: url("<?php echo elgg_get_site_url(); ?>_graphics/friendspicker.png") no-repeat -60px -44px;
}
.friendspicker-savebuttons .elgg-button-submit,
.friendspicker-savebuttons .elgg-button-cancel {
	margin:5px 20px 5px 5px;
}
.friendspicker-members-table {
	background: #dedede;
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	
	margin:10px 0 0;
	padding:10px 10px 0;
}

/* ***************************************
	USER PICKER
*************************************** */

.user-picker .user-picker-entry {
	clear:both;
	height:25px;
	padding:5px;
	margin-top:5px;
	border-bottom:1px solid #cccccc;
}
.user-picker-entry .elgg-button-delete {
	margin-right:10px;
}
/* ***************************************
      DATE PICKER
**************************************** */
.ui-datepicker {
	margin-top: 3px;
	background-color: white;
	border: 1px solid #0054A7;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	overflow: hidden;
}

.ui-datepicker-header {
	background: #4690D6;
	color: white;
	padding: 2px 0;
	border-bottom: 1px solid #0054A7;
}
.ui-datepicker-header a {
	color: white;
}
.ui-datepicker-prev, .ui-datepicker-next {
    position: absolute;
    top: 5px;
	cursor: pointer;
}
.ui-datepicker-prev {
    left: 6px;
}
.ui-datepicker-next {
    right: 6px;
}
.ui-datepicker-title {
    line-height: 1.8em;
    margin: 0 30px;
    text-align: center;
	font-weight: bold;
}
.ui-datepicker-calendar {
	margin: 4px;
}
.ui-datepicker th {
	color: #0054A7;
	border: none;
    font-weight: bold;
    padding: 5px 6px;
    text-align: center;
}
.ui-datepicker td {
	padding: 1px;
}
.ui-datepicker td span, .ui-datepicker td a {
    display: block;
    padding: 2px;
	line-height: 1.2em;
    text-align: right;
    text-decoration: none;
}
.ui-datepicker-calendar .ui-state-default {
	border: 1px solid #ccc;
    color: #4690D6;;
	background: #fafafa;
}
.ui-datepicker-calendar .ui-state-hover {
	border: 1px solid #aaa;
    color: #0054A7;
	background: #eee;
}
.ui-datepicker-calendar .ui-state-active,
.ui-datepicker-calendar .ui-state-active.ui-state-hover {
	font-weight: bold;
    border: 1px solid #0054A7;
    color: #0054A7;
	background: #E4ECF5;
}
