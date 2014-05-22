<?php
global $CONFIG;

// Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$urlicon = $css['urlicon'];
$linkcolor = $css['linkcolor'];
$linkhovercolor = $css['linkhovercolor'];
$color1 = $css['color1'];
$color2 = $css['color2'];
$color3 = $css['color3'];
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
$color14 = $css['color14'];
$color15 = $css['color15'];
$font1 = $css['font1'];
$font2 = $css['font2'];
$font3 = $css['font3'];
$font4 = $css['font4'];
$font5 = $css['font5'];
$font6 = $css['font6'];
?>

/* ***************************************
	Modules
*************************************** */

.elgg-module { overflow: hidden; margin-bottom: 20px; }

/* Aside */
.elgg-module-aside .elgg-head {
	/* border-bottom: 1px solid #CCC; */
	margin-bottom: 5px;
	padding-bottom: 5px;
}

#pages-navigation .elgg-body {
	background: none repeat scroll 0 0 #FFFFFF;
	font-size: 0.8em;
	padding: 5px 10px 0 5px;
}
#pages-navigation .elgg-body ul li a { padding-left: 5px; }



/* Info */
.elgg-module-info > .elgg-head {
	background: #e4e4e4;
	padding: 1px 3px 0px;
	margin-bottom: 10px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	background-image: linear-gradient(top, <?php echo $color2; ?> 0%, <?php echo $color3; ?> 100%);
	background-image: -o-linear-gradient(top, <?php echo $color2; ?> 0%, <?php echo $color3; ?> 100%);
	background-image: -moz-linear-gradient(top, <?php echo $color2; ?> 0%, <?php echo $color3; ?> 100%);
	background-image: -webkit-linear-gradient(top, <?php echo $color2; ?> 0%, <?php echo $color3; ?> 100%);
	background-image: -ms-linear-gradient(top, <?php echo $color2; ?> 0%, <?php echo $color3; ?> 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, <?php echo $color2; ?>), color-stop(1, <?php echo $color3; ?>));
	background-color: <?php echo $color3; ?>;
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
	border-top: 0 none;
	min-height: 25px;
	margin-bottom:0;
}
.elgg-module-info > .elgg-head * { color: #333; }
.elgg-module-info {
	/* background: url("<?php echo $urlicon; ?>ombre-module.png") no-repeat scroll left 5px transparent; */
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
	padding: 0 14px;
	min-width:200px;
}
.elgg-module-info > .elgg-head h3 {
	color: <?php echo $color14; ?>;
	/*
	float: left;
	font-size: 1.25em;
	*/
	margin: 7px 0 0 5px;
	font-family: <?php echo $font1; ?>;
	font-size: 1.1em;
	text-transform: uppercase;
	font-weight: normal;
	padding: 4px 0 5px 30px;
}
.elgg-module-info > .elgg-body {
	padding:7px 10px 0;
	/* background: white url("<?php echo $urlicon; ?>bottom-module.png") 50% bottom no-repeat scroll; */
	background:white; /* Pour masquer ombrage si largeur supérieure */
	border-bottom: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
	border-right: 1px solid #CCCCCC;
}


/* Popup */
.elgg-module-popup {
	background-color: white;
	border: 1px solid #ccc;
	
	z-index: 9999;
	margin-bottom: 0;
	padding: 5px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	
	-webkit-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
}
.elgg-module-popup > .elgg-head { margin-bottom: 5px; }
.elgg-module-popup > .elgg-head * { color: <?php echo $titlecolor; ?>; }

/* Dropdown */
.elgg-module-dropdown {
	background-color:white;
	border:5px solid #CCC;
	
	-webkit-border-radius: 5px 0 5px 5px;
	-moz-border-radius: 5px 0 5px 5px;
	border-radius: 5px 0 5px 5px;
	
	display:none;
	
	width: 210px;
	padding: 12px;
	margin-right: 0px;
	z-index:100;
	
	-webkit-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	-moz-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	
	position:absolute;
	right: 0px;
	top: 100%;
}

/* Featured */
.elgg-module-featured {
	border: 1px solid <?php echo $titlecolor; ?>;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}
.elgg-module-featured > .elgg-head {
	padding: 5px;
	background-color: <?php echo $titlecolor; ?>;
}
.elgg-module-featured > .elgg-head * { color: white; }
.elgg-module-featured > .elgg-body { padding: 10px; }


/* ***************************************
	Widgets
*************************************** */
.elgg-widgets {
	float: right;
	min-height: 30px;
}
.elgg-widget-add-control {
	text-align: right;
	margin: 5px 5px 15px;
}
.elgg-widgets-add-panel {
	padding: 10px;
	margin: 0 5px 15px;
	background: #dedede;
	border: 2px solid #ccc;
}
<?php //@todo location-dependent style: make an extension of elgg-gallery ?>
.elgg-widgets-add-panel li {
	float: left;
	margin: 2px 10px;
	width: 200px;
	padding: 4px;
	background-color: #ccc;
	border: 2px solid #b0b0b0;
	font-weight: bold;
}
.elgg-widgets-add-panel li a {
	display: block;
}
.elgg-widgets-add-panel .elgg-state-available {
	color: #333;
	cursor: pointer;
}
.elgg-widgets-add-panel .elgg-state-available:hover, 
.elgg-widgets-add-panel .elgg-state-available:focus, 
.elgg-widgets-add-panel .elgg-state-available:active {
	background-color: #bcbcbc;
}
.elgg-widgets-add-panel .elgg-state-unavailable {
	color: #888;
}

.elgg-module-widget {
	background-color: #dedede;
	padding: 2px;
	margin: 0 5px 15px;
	position: relative;
}
.elgg-module-widget:hover, 
.elgg-module-widget:focus, 
.elgg-module-widget:active {
	background-color: #ccc;
}
.elgg-module-widget > .elgg-head {
	background-color: #eeeeee;
	height: 26px;
	overflow: hidden;
}
.elgg-module-widget > .elgg-head h3 {
	float: left;
	padding: 4px 45px 0 20px;
	color: #666;
}
.elgg-module-widget.elgg-state-draggable > .elgg-head {
	cursor: move;
}
.elgg-module-widget > .elgg-head a {
	position: absolute;
	top: 4px;
	display: inline-block;
	width: 18px;
	height: 18px;
	padding: 2px 2px 0 0;
}
a.elgg-widget-collapse-button {
	left: 5px;
	color: #c5c5c5;
}
a.elgg-widget-collapse-button:hover,
a.elgg-widget-collapse-button:focus,
a.elgg-widget-collapse-button:active,
a.elgg-widget-collapsed:hover, 
a.elgg-widget-collapsed:focus, 
a.elgg-widget-collapsed:active {
	color: #9d9d9d;
	text-decoration: none;
}
a.elgg-widget-collapse-button:before {
	content: "\25BC";
}
a.elgg-widget-collapsed:before {
	content: "\25BA";
}
a.elgg-widget-delete-button {
	right: 5px;
}
a.elgg-widget-edit-button {
	right: 25px;
}
.elgg-module-widget > .elgg-body {
	background-color: white;
	width: 100%;
	overflow: hidden;
	/* border-top: 2px solid #dedede; */
}
.elgg-widget-edit {
	display: none;
	width: 96%;
	padding: 2%;
	border-bottom: 2px solid #dedede;
	background-color: #f9f9f9;
}
.elgg-widget-content {
	padding: 10px;
}
.elgg-widget-placeholder {
	border: 2px dashed #dedede;
	margin-bottom: 15px;
}

section div.module div.activites .elgg-widget-content .widget-title-details {
	font-family: <?php echo $font1; ?>;
	font-size: 1.10em;
	text-transform: uppercase;
	font-weight: normal;
}
section div.module div.activites ul li { padding-left: 0; }
section div.module div.activites ul li div.elgg-image a img { margin-left: 0; }


/* Pied des widgets */
section div.module footer {
	background: transparent url("<?php echo $urlicon; ?>bottom-module.png") 50% top no-repeat scroll;
	height: 30px;
	margin-top: 0;
	text-align: center;
	padding-bottom: 8px;
	border-top: 1px solid #ccc;
}
section div.module footer a {
	font-size: 24px;
	color: <?php echo $linkcolor; ?>;
	font-family: <?php echo $font2; ?>;
	text-shadow: 0 2px 2px #999;
	padding: 0 10px;
}
section div.module footer a:hover, 
section div.module footer a:focus, 
section div.module footer a:active { text-decoration: none; }


/* Widget et Module de groupe Agenda */
.elgg-module-group-event-calendar > .elgg-body, 
.elgg-module-widget > .elgg-body { overflow:visible; }
.elgg-module-group-event-calendar .entity_title, 
.elgg-widget-instance-event_calendar .entity_title { display:none; }
.elgg-module-group-event-calendar .elgg-body h3, 
.elgg-widget-instance-event_calendar h3 {
	float: left;
	color: <?php echo $linkcolor; ?>;
	font-size: 0.9em;
	font-weight: bold;
	height: 23px;
	padding-left: 20px;
	margin: 0 0 0 -3px;
	padding: 2px 0 0 35px;
	background: transparent url("<?php echo $urlicon; ?>puce-evenement.png") left top no-repeat scroll;
	position:relative; left:-21px;
}
.elgg-module-group-event-calendar p.date, 
.elgg-widget-instance-event_calendar p.date {
	border: 1px solid <?php echo $linkcolor; ?>;
	color: <?php echo $linkcolor; ?>;
	float: left;
	clear: left;
	font-size: 0.85em;
	margin: 5px 10px 0 10px;
	padding: 3px;
	text-align: center;
	width: 40px;
	font-style: normal;
}
.elgg-module-group-event-calendar p.date span,
.elgg-widget-instance-event_calendar p.date span {
	font-size: 1.8em;
	font-weight: bold;
}
.elgg-widget-instance-event_calendar p {
	font-size: 0.75em;
	float: left;
	width: 220px;
	font-style: italic;
	margin-top:10px;
}
/* Spécifique Module agenda de groupe */
.elgg-module-group-event-calendar .elgg-body h3 {
  left:-12px;
}
.elgg-module-group-event-calendar p.date { font-size: 1em; }
.elgg-module-group-event-calendar p {
	font-size: 1.2em;
	float: left;
	width: 220px;
	font-style: italic;
	margin-top:10px;
}


/* Icônes dans les entêtes des modules des groupes */
.elgg-module-group .elgg-head h3 {
	background-position: left 0px; background-color: transparent; background-repeat: no-repeat;
	min-height: 20px; padding-left: 36px; margin: 5px 0 3px 5px;
}
.elgg-module-group-activity .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>activity-module.png"); }
.elgg-module-group-event-calendar .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>event_calendar-module.png"); }
.elgg-module-group-announcements .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>announcements-module.png"); }
.elgg-module-group-blog .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>blog-module.png"); }
.elgg-module-group-file .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>file-module.png"); }
.elgg-module-group-discussion .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>discussion-module.png"); }
.elgg-module-group-brainstorm .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>brainstorm-module.png"); }
.elgg-module-group-bookmarks .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>bookmarks-module.png"); }
.elgg-module-group-pages .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>pages-module.png"); }


/* à vérifier pour effets sur diverses pages */
.elgg-module .elgg-body .mts { float: left; clear: left; font-size: 0.9em; }
.groups-widget-viewall { margin:10px 6px 0 0; }
.elgg-module span.groups-widget-viewall a { color: <?php echo $color14; ?>; font-size: 1em; }
.elgg-module-info > .elgg-body { padding: 7px 0 0; }
.elgg-module-info .elgg-image-block .elgg-body .elgg-river-summary { float: left; width: 200px; }
.elgg-module-info .elgg-image-block .elgg-body a.ouvrir { clear: none; padding: 20px 10px; }
.elgg-module-info .elgg-river { border-top: 0 none; }


/* Modules similaires à ceux des groupes sur la page de profil (pas d'ombre et pas de rivets en fin de bloc) */
section .elgg-layout-one-column div.module { background:none; padding:0; margin-left:10px; border:1px solid #CCC; }
section .elgg-layout-one-column div.module footer { background: none; height:0; border:0; margin:0; padding:0; }


/* Icônes pour les widgets */
section div.module header h2 {
	padding: 5px 0 5px 30px; margin:0 0 0 4px; max-width: 190px; min-height:24px;
	/* padding: 5px 0 5px 30px; margin:0 75px 0 4px; min-height:24px; */
}

section div.elgg-widget-instance-a_users_groups header h2 {
	background: url("<?php echo $urlicon; ?>a_users_groups-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-activity header h2 {
	background: url("<?php echo $urlicon; ?>activity-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-announcements header h2 {
	background: url("<?php echo $urlicon; ?>announcements-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-blog header h2 {
	background: url("<?php echo $urlicon; ?>blog-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-bookmarks header h2 {
	background: url("<?php echo $urlicon; ?>bookmarks-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-brainstorm header h2 {
	background: url("<?php echo $urlicon; ?>brainstorm-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-discussion header h2 {
	background: url("<?php echo $urlicon; ?>discussion-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-event_calendar header h2 {
	background: url("<?php echo $urlicon; ?>event_calendar-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-export_embed header h2 {
	background: url("<?php echo $urlicon; ?>export_embed-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-filerepo header h2 {
	background: url("<?php echo $urlicon; ?>file-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-friends header h2 {
	background: url("<?php echo $urlicon; ?>friends-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-group_activity header h2 {
	background: url("<?php echo $urlicon; ?>group_activity-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-messages header h2 {
	background: url("<?php echo $urlicon; ?>messages-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-pages header h2 {
	background: url("<?php echo $urlicon; ?>pages-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-profile_completeness header h2 {
	background: url("<?php echo $urlicon; ?>profile_completeness-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-river_widget header h2 {
	background: url("<?php echo $urlicon; ?>river_widget-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-tagcloud header h2 {
	background: url("<?php echo $urlicon; ?>tagcloud-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-thewire header h2 {
	background: url("<?php echo $urlicon; ?>thewire-widget.png") no-repeat scroll 0 2px transparent;
}
section div.elgg-widget-instance-twitter header h2 {
	background: url("<?php echo $urlicon; ?>twitter-widget.png") no-repeat scroll 0 2px transparent;
}



