/* ***************************************
	    JQUERY BUTTONS
*************************************** */

.ui-button {
	height: 35px;
	margin-left: -1px;
	vertical-align: bottom;
}

.ui-button-icon-only .ui-button-text {
	padding: 0.35em;
}

.ui-corner-left {
	-webkit-border-top-right-radius: 0;
	-moz-border-radius-topright: 0;
	border-top-right-radius: 0;

	-webkit-border-bottom-right-radius: 0;
	-moz-border-radius-bottomright: 0;
	border-bottom-right-radius: 0;
}

/* ***************************************
	AUTOSUGGEST BOXES
*************************************** */

.ui-autocomplete-input {
	margin: 0;
	padding: 0.48em 0 0.47em 0.45em;
	height: 35px;
	width: 200px;
}

.ui-autocomplete-input:focus {
	border: 1px solid #DDDDDD;
}

.ui-autocomplete {
	padding: 0px;
	border: 1px solid black;
	background-color: white;
	overflow: hidden;
	width: 200px;
	list-style-position: outside;
	list-style: none;
	padding: 0;
	margin: 0;
}

.ui-autocomplete li a {
	margin: 0px;
	padding: 2px 5px;
	cursor: default;
	display: block;
	/*
	if width will be 100% horizontal scrollbar will apear
	when scroll mode will be used
	*/
	/*width: 100%;*/
	font: menu;
	font-size: 12px;
	/*
	it is very important, if line-height not setted or setted
	in relative units scroll will be broken in firefox
	*/
	line-height: 16px;
	overflow: hidden;
}

.ui-autocomplete-loading {
	background: white url(<?php echo $vars['url']; ?>_graphics/indicator.gif) right center no-repeat;
}

.ui-autocomplete li:nth-child(odd) {
	background-color: #eee;
}

.ui-autocomplete .ui-state-hover {
	background-color: #4690D6;
	color: white !important;
	text-decoration: none;
}

.ui-autocomplete strong {
	font-weight: bold;
}

