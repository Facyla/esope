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

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') $fixedwidth = false; else $fixedwidth = true;

?>
/* <style> /**/

/* ***************************************
	ESOPE Form Elements
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
label.elgg-state-disabled {
	opacity: 0.6;
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

input[type=email]:focus,
input[type=password]:focus,
input[type=text]:focus,
input[type=url]:focus,
textarea:focus {
	border: solid 1px #4690d6;
	background: #e4ecf5;
	color:#333;
	/* We remove outlines from specific input types so we can leave the browser
	   defaults (like glows) for everything else */
	outline: 0 none;
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
	border-radius:0;
	width:auto;
}
select {
 border: 1px solid #ccc;
 font-size: 0.9em;
}
.elgg-input-checkboxes.elgg-horizontal li,
.elgg-input-radios.elgg-horizontal li {
	display: inline;
	padding-right: 10px;
}
.elgg-input-checkboxes li label, .elgg-input-radio li label {
  font-weight: normal;
}

.elgg-form-login, .elgg-form-account {
	max-width: 450px;
	margin: 0 auto;
}

.elgg-form-account input[type="text"],
.elgg-form-account input[type="password"] {
	width: 300px;
}

form.elgg-form {
	background: #f6f6f6;
	float: left;
	padding: 1% 2%;
	width: 94%;
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

/* ESOPE group search */
.elgg-form-groups-find input[type='text'] { width:250px; }
.elgg-form-groups-find input.elgg-button-submit { vertical-align:20%; margin:0; }
/* New integrated in-group search */
.elgg-sidebar .elgg-form.elgg-form-groups-search { border: 0; background: white; padding: 0; margin-bottom: 20px; width:100%; }
.elgg-form.elgg-form-groups-search #q { height:24px; width:84%; border:0; margin:0; }
.groups-search-submit-button { height:24px; width:auto; border:1px solid grey; vertical-align: top; float:right; border:0; background-color:#ccc; padding:5px 7px 5px 8px; }
.groups-search-submit-button:hover, .groups-search-submit-button:active, .groups-search-submit-button:focus { background-color:#999; }


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
	/* float: left; */
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


/* ESOPE : Formulaire de recherche principal */
.elgg-page-header form, #transverse form {
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
	margin: 6px 0;
}
form input#esope-search-input {
	border: 0 none;
	border-radius: 8px 0 0 8px;
	-moz-border-radius: 8px 0 0 8px;
	-webkit-border-radius: 8px 0 0 8px;
	-o-border-radius: 8px 0 0 8px;
	height: 27px;
	padding: 2px 7px;
	width: 210px;
	float: left;
	color: #999;
	font-size: 0.8em;
}
form input#esope-search-input:active, 
form input#esope-search-input:focus {
  color:#333;
}
form input#esope-search-submit-button {
	background: #ccc;
	border-radius: 0 7px 7px 0;
	-moz-border-radius: 0 7px 7px 0;
	-webkit-border-radius: 0 7px 7px 0;
	-o-border-radius: 0 7px 7px 0;
	/* float: right; */
	float:none;
	height: 27px;
	padding: 5px 7px 5px 8px;
	width:auto;
}
form input#esope-search-submit-button:hover, 
form input#esope-search-submit-button:active, 
form input#esope-search-submit-button:focus {
  background-color: #999;
  border:1px solid #999;
}
.elgg-search input[type=text]:focus, .elgg-search input[type=text]:active { outline:0; }
.elgg-page-header .elgg-search input[type=submit] { display: inline-block !important; }

/* ESOPE search */
#esope-search-form { padding: 15px 0px; }
.esope-search-metadata { float: left; margin-right: 1em; }
#esope-search-form select { width: 7em; margin-left: 0.5em; }
.esope-search-fulltext { width: 80%; float: left; }
#esope-search-form input[type="text"] { max-width: 70%; margin-left: 1em; }
.esope-search-metadata-select select { max-width: 100%; }
.elgg-button-livesearch { float: right; }
.esope-results-count { font-size: 0.8em; color: #808080; }

/* Main search - advanced */
#advanced-search-form { border: 1px dotted #CCC; padding: 6px; margin: 6px 0; background: #FAFAFA; }
#advanced-search-form legend { font-weight: bold; margin-bottom:6px; }
#advanced-search-form input { width:50ex; max-width: 70%; }
#advanced-search-form input.elgg-button-submit { max-width: 20ex; }
#advanced-search-form input.elgg-input-date { max-width: 12ex; }




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
	border-radius: 8px;
}
.friendspicker-savebuttons {
	background: white;
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
	border-radius: 8px;
	margin:10px 0 0;
	padding:10px 10px 0;
}

/* ***************************************
	AUTOCOMPLETE
*************************************** */
<?php //autocomplete will expand to fullscreen without max-width ?>
.ui-autocomplete {
	position: absolute;
	cursor: default;
	z-index: 10000;
}
.elgg-autocomplete-item .elgg-body {
	max-width: 600px;
}
.ui-autocomplete {
	background-color: white;
	border: 1px solid #ccc;
	overflow: hidden;
	border-radius: 5px;
}
.ui-autocomplete .ui-menu-item {
	padding: 0px 4px;
	border-radius: 5px;
}
.ui-autocomplete .ui-menu-item:hover {
	background-color: #eee;
}
.ui-autocomplete a:hover {
	text-decoration: none;
	color: #4690D6;
}
.ui-autocomplete a.ui-state-hover {
	background-color: #eee;
	display: block;
}

/* ***************************************
	USER PICKER
*************************************** */
.elgg-user-picker-list li:first-child {
	border-top: 1px dotted #ccc;
	margin-top:5px;
}
.elgg-user-picker-list > li {
	border-bottom: 1px dotted #ccc;
}
.elgg-user-picker.elgg-state-disabled > input,
.elgg-user-picker.elgg-state-disabled > label {
	display: none;
}
.elgg-user-picker-remove {
	cursor: pointer;
}

/* ***************************************
      DATE PICKER
**************************************** */
.ui-datepicker {
	display: none;

	margin-top: 3px;
	background-color: white;
	border: 1px solid #0054A7;
	border-radius: 6px;
	overflow: hidden;
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
}
.ui-datepicker-inline {
	box-shadow: none;
}

.ui-datepicker-header {
	position: relative;
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




<?php if (!$fixedwidth) { ?>

@media (max-width:700px) {
	/* Recherche */
	form#main-search { float: none; display: inline-block; margin: 1ex 0; width:100%; background:white; border-radius: 0; box-shadow: none; }
	form#main-search #adf-search-input { width: 94%; border-radius: 0; }
	#main-search #adf-search-submit-button { border-radius: 0; }
	#main-search button#adf-search-submit-button { width: 6%; border-radius: 0; }
	
	.elgg-page-header form, #transverse form { width: 90%; float: none; margin: 0 auto; clear: both; padding: 0.3em 1em; display: block; width: 260px; }
	
}

<?php } ?>


