<?php
// ESOPE configurable styles

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
$color14 = $css['color14'];
$color15 = $css['color15'];
$font1 = $css['font1'];
$font2 = $css['font2'];
$font3 = $css['font3'];
$font4 = $css['font4'];
$font5 = $css['font5'];
$font6 = $css['font6'];
?>

/* <style> /**/

/* ***************************************
	ESOPE Modules
*************************************** */
.elgg-module {
	overflow: hidden;
	margin-bottom: 20px;
}

/* Aside */
.elgg-module-aside .elgg-head {
	/* border-bottom: 1px solid #CCC; */
	margin-bottom: 5px;
	padding-bottom: 5px;
}

.elgg-sidebar .elgg-module-aside h3 { color:<?php echo $color14; ?>; font-size: 16px; padding: 0.4em 0.5em 0.0em 0.5em;; }
.elgg-sidebar .elgg-module-aside .elgg-body ul li { float: left; width: auto; }
.elgg-sidebar .elgg-module-aside .elgg-body ul li a img {
	float: left;
	/*
	margin-right: 5px;
	height: 25px;
	width: 25px;
	*/
}
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a {
	float: left;
	font-size: 0.75em;
}
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:hover,
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:focus,
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:active {
	color: #333333;
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
.elgg-page-body div.elgg-module.elgg-owner-block .elgg-head { background: transparent; }
.elgg-module-info > .elgg-head * { color: <?php echo $color14; ?>; }
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
	padding: 4px 0 5px 0px;
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
	border-radius: 6px;
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
}
.elgg-module-popup > .elgg-head {
	margin-bottom: 5px;
}
.elgg-module-popup > .elgg-head * {
	color: <?php echo $titlecolor; ?>;
}

/* Dropdown */
.elgg-module-dropdown {
	background-color:white;
	border:5px solid #CCC;
	border-radius: 5px 0 5px 5px;
	display:none;
	width: 210px;
	padding: 12px;
	margin-right: 0px;
	z-index:100;
	box-shadow: 0 3px 3px rgba(0, 0, 0, 0.45);
	position:absolute;
	right: 0px;
	top: 100%;
}

/* Featured */
.elgg-module-featured {
	border: 1px solid <?php echo $titlecolor; ?>;
	border-radius: 6px;
}
.elgg-module-featured > .elgg-head {
	padding: 5px;
	background-color: <?php echo $titlecolor; ?>;
}
.elgg-module-featured > .elgg-head * {
	color: white;
}
.elgg-module-featured > .elgg-body {
	padding: 10px;
}

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
.elgg-widget-add-control .elgg-button {
	display: inline;
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
	/* background-color: #dedede; */
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
.elgg-module-widget.elgg-state-draggable .elgg-widget-handle {
	cursor: move;
}
a.elgg-widget-collapse-button {
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
.elgg-module-widget > .elgg-body {
	background-color: white;
	width: 100%;
	overflow: hidden;
	/* border-top: 2px solid #dedede; */
}
.elgg-module-widget > .elgg-body { overflow:visible; }
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
.elgg-module-widget { background-color: transparent; }
.elgg-module-widget:hover,
.elgg-module-widget:focus,
.elgg-module-widget:active { background-color: transparent; }
.elgg-module-widget > .elgg-head { height:auto; }
.elgg-module-widget h3 { padding:0.5em; }
.elgg-page-body div.elgg-module .elgg-head .elgg-widget-title {
	color: <?php echo $color14; ?>;
	float: left;
	font-family: <?php echo $font1; ?>;
	font-size: 1.25em;
	text-transform: uppercase;
	font-weight: normal;
	max-width:none;
	float:none;
}

/* Contenu des modules */
.elgg-page-body div.elgg-module .elgg-head ul { float: right; margin: 0px 0.5em 0.5em 0.5em; /* position: absolute; top: 0; right: 0; */ }
.elgg-page-body div.elgg-module ul li { padding-left: 0; float: none; right: initial; left: inherit; margin-left: 0em; }

.elgg-page-body div.elgg-module .elgg-head ul li a { float: none; margin:0; right: initial; }

.elgg-page-body div.module div.activites { background-color: #fff; float: left; padding-top: 5px; width: 300px; }
.elgg-page-body div.module div.activites h3 { margin: 5px 7px; font-size: 1.1em; color: #333333; float: left; font-size: 1em; }
.elgg-page-body div.module div.activites ul li { padding-bottom: 1px; }
.elgg-page-body div.module div.activites ul li img { margin: 0 5px 0 7px; }
.elgg-page-body div.module div.activites ul li div span { color: #666; font-style: italic; }

/* Widgets - à corriger pour utiliser les classes natives d'Elgg */
.elgg-page-body div.elgg-module {
	background: none; padding: 0; width: auto; min-width: 200px;
	float: left;
	/*
	margin: 0 0.5em 1em 0.5em;
	float: none;
	*/
	width: 96%;
	margin: 0 auto 1em auto;
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
}
.elgg-page-body div.elgg-module .elgg-head {
	background-image: linear-gradient(top, <?php echo $color2; ?> 45%, <?php echo $color3; ?> 55%);
	background-image: -o-linear-gradient(top, <?php echo $color2; ?> 45%, <?php echo $color3; ?> 55%);
	background-image: -moz-linear-gradient(top, <?php echo $color2; ?> 45%, <?php echo $color3; ?> 55%);
	background-image: -webkit-linear-gradient(top, <?php echo $color2; ?> 45%, <?php echo $color3; ?> 55%);
	background-image: -ms-linear-gradient(top, <?php echo $color2; ?> 45%, <?php echo $color3; ?> 55%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.45, <?php echo $color2; ?>), color-stop(0.55, <?php echo $color3; ?>));
	background-color: <?php echo $color3; ?>;
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
	border-top: 0 none;
	min-height: 26px;
}


/* Suppression des styles du core, qui géraient les flèches en carac spéciaux */
a.elgg-widget-collapse-button,
a.elgg-widget-collapse-button:hover,
a.elgg-widget-collapse-button:focus,
a.elgg-widget-collapse-button:active,
a.elgg-widget-collapsed:hover,
a.elgg-widget-collapsed:focus,
a.elgg-widget-collapsed:active {
	color: transparent;
}
a.elgg-widget-collapse-button:before { content: ""; }
a.elgg-widget-collapsed:before { content: ""; }
/*
a.elgg-widget-edit-button { right: 12px; }
*/

div.elgg-widgets div.elgg-body { font-size: 0.90em; }
.elgg-module .elgg-body, .elgg-module .elgg-content, .elgg-module .elgg-river-summary { font-size:14px; }
.elgg-module .entity_title { font-size:16px; }
.elgg-widget-instance-event_calendar p { font-size: 1.3em; }

/* Boutons des widgets */
.elgg-menu-widget button { outline: none; border: 0; background: transparent; margin:0; padding:2px 4px; color: <?php echo $color14; ?>; }

/* Widgets activité des groupes */
.elgg-page-body div.elgg-widget-instance-group_activity div.elgg-body.activites,
.elgg-page-body div.elgg-widget-instance-group_activity div.elgg-body.activites .elgg-widget-content { padding:0; }
.elgg-page-body div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
	padding:0 14px;
	background:<?php echo $color3; ?>;
	/* margin-top:-8px; */
}
.elgg-page-body div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
	color:white;display:block;
	font-family: <?php echo $font1; ?>;
	font-size:14px;
}
.widget-group-content { padding: 0 10px 10px 10px; }

.elgg-widget-more {
	line-height:32px; color:<?php echo $linkcolor; ?>;
	background: #F2F1EF;
	display:block;
	width: 100%;
	/* float: left; */
}
.elgg-widget-more:before {
	content: "+ ";
	font-family: <?php echo $font2; ?>;
	font-size: 24px;
	font-weight: bold;
	margin-left: 9px;
	text-shadow: 0 2px 2px #999999;
	vertical-align: bottom;
}


.elgg-page-body div.elgg-module .elgg-widget-content .widget-title-details {
	font-family: <?php echo $font1; ?>;
	font-size: 1.10em;
	text-transform: uppercase;
	font-weight: normal;
}
.elgg-page-body div.elgg-module ul li div.elgg-image a img { margin-left: 0; }


/* Pied des widgets */
.elgg-page-body div.elgg-module:after footer {
	background: transparent url("<?php echo $urlicon; ?>bottom-module.png") 50% top no-repeat scroll;
	height: 30px;
	margin-top: 0;
	text-align: center;
	padding-bottom: 8px;
	border-top: 1px solid #ccc;
}
.elgg-page-body div.elgg-module footer a {
	font-size: 24px;
	color: <?php echo $linkcolor; ?>;
	font-family: <?php echo $font2; ?>;
	text-shadow: 0 2px 2px #999;
	padding: 0 10px;
}
.elgg-page-body div.elgg-module footer a:hover, 
.elgg-page-body div.elgg-module footer a:focus, 
.elgg-page-body div.elgg-module footer a:active { text-decoration: none; }


/* Widget et Module de groupe Agenda */
.elgg-module-group-event-calendar > .elgg-body, 
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
	min-height: 20px; /* padding-left: 36px; */
	margin: 0.3em 0 0.2em 0.4em;
}
/*
.elgg-module-group-activity .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>activity-module.png"); }
.elgg-module-group-event-calendar .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>event_calendar-module.png"); }
.elgg-module-group-announcements .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>announcements-module.png"); }
.elgg-module-group-blog .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>blog-module.png"); }
.elgg-module-group-file .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>file-module.png"); }
.elgg-module-group-discussion .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>discussion-module.png"); }
.elgg-module-group-brainstorm .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>brainstorm-module.png"); }
.elgg-module-group-bookmarks .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>bookmarks-module.png"); }
.elgg-module-group-pages .elgg-head h3 { background-image: url("<?php echo $urlicon; ?>pages-module.png"); }
*/


/* à vérifier pour effets sur diverses pages */
.elgg-module .elgg-body .mts { float: left; clear: left; font-size: 0.9em; }
.groups-widget-viewall { margin:10px 6px 0 0; }
.elgg-module span.groups-widget-viewall a { color: <?php echo $color14; ?>; font-size: 1em; }
.elgg-module-info > .elgg-body { padding: 7px 0 0; }
.elgg-module-info .elgg-image-block .elgg-body .elgg-river-summary { float: left; width: 200px; }
.elgg-module-info .elgg-image-block .elgg-body a.ouvrir { clear: none; padding: 20px 10px; }
.elgg-module-info .elgg-river { border-top: 0 none; }


/* Modules similaires à ceux des groupes sur la page de profil (pas d'ombre et pas de rivets en fin de bloc) */
.elgg-page-body .elgg-layout-one-column div.elgg-module { background:none; padding:0; margin-left:10px; border:1px solid #CCC; }
.elgg-page-body .elgg-layout-one-column div.elgg-module footer { background: none; height:0; border:0; margin:0; padding:0; }





/* Icônes spécifiques pour les divers types de widgets - remplacé par icone FA dans le titre */
/*
.elgg-page-body div.elgg-module .elgg-head .elgg-widget-title {
	padding: 5px 0 5px 30px; margin:0 0 0 4px; max-width: 190px; min-height:24px;
}

.elgg-page-body div.elgg-widget-instance-a_users_groups .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>a_users_groups-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-activity .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>activity-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-announcements .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>announcements-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-blog .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>blog-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-bookmarks .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>bookmarks-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-brainstorm .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>brainstorm-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-discussion .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>discussion-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-event_calendar .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>event_calendar-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-export_embed .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>export_embed-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-filerepo .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>file-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-friends .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>friends-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-group_activity .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>group_activity-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-messages .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>messages-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-pages .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>pages-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-profile_completeness .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>profile_completeness-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-river_widget .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>river_widget-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-tagcloud .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>tagcloud-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-thewire .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>thewire-widget.png") no-repeat scroll 0 2px transparent;
}
.elgg-page-body div.elgg-widget-instance-twitter .elgg-head .elgg-widget-title {
	background: url("<?php echo $urlicon; ?>twitter-widget.png") no-repeat scroll 0 2px transparent;
}
*/



