<?php
global $CONFIG;
$fonturl = $CONFIG->url . 'mod/theme_inria/fonts/';
$imgurl = $CONFIG->url . 'mod/theme_inria/graphics/';
$tools_url = $imgurl . 'inria_widget/';
?>

/* Change Elgg sprites image */
.elgg-icon { background-image: url(<?php echo $imgurl; ?>elgg_sprites-iris.png); }

/* Add some fonts */
@font-face {
	font-family: 'NeoFont'; font-weight: normal; font-style: normal;
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.eot');
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.woff') format('woff'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.ttf') format('truetype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.svg#neo_sans_stdregular') format('svg');
}

/* Header */
body { border-top:0; }
header { background: #6F2D50; border-top: 0; height:70px; }
header .interne h1 { margin-top: 0; }
header nav { top: 27px; }
header nav #user img { float: left; margin-right: 6px; }
header nav ul li a { font-size:12px; font-weight:normal; color: #fff; text-shadow: none; font-family: Arial, Helvetica, sans-serif; }

/* Main menu */
#transverse { background: #F8F4F5; border: 0; box-shadow: none; height: 37px; }
#transverse nav ul li, #transverse nav ul li:first-child { border:0; padding:0; }
#transverse nav ul li a { text-transform:uppercase; color: #EF783E; font-family: NeoFont, Arial, sans-serif; font-size: 14px; font-weight: bold; }
#transverse nav ul li a.active, #transverse nav ul li a.elgg-state-selected, #transverse nav ul li a:hover, #transverse nav ul li a:focus, #transverse nav ul li a:active { background-color: #F8F4F5; color:#6D2D4F; }
#transverse nav ul li ul li a:hover, #transverse nav ul li ul li a:focus, #transverse nav ul li ul li a:active { background: #F8F4F5; color: #6D2D4F; }
#transverse nav ul li ul { background: #F8F4F5; top: 37px; left: 0px; box-shadow:none; }
#transverse nav ul li ul li { background: #F8F4F5; }
#transverse nav ul li ul li a { border-bottom: 0; text-transform: none; font-weight: normal; font-size: 14px; padding: 0.5em 0.75em; }

/* Search */
#transverse form, header form { float: right; border: 0; border-radius: 0; box-shadow: none; margin-top: 5px; }
form input#adf-search-input { border: 0 none; border-radius: 0; color: #EF783E; }
form input#adf-search-input:active, form input#adf-search-input:focus { color: #EF783E; }
form input#adf-search-submit-button { background: #EF783E; border-color: #EF783E; border-radius: 0; }
form input#adf-search-submit-button:hover, form input#adf-search-submit-button:active, form input#adf-search-submit-button:focus { background-color: #EF783E; border: 1px solid #EF783E; }

/* Forms */
::-webkit-input-placeholder { color: #EF783E; }
:-moz-placeholder { color: #EF783E; }
::-moz-placeholder { color: #EF783E; }
-ms-input-placeholder { color: #EF783E; }



/* Footer */
footer.footer-inria {
	background: #6d2d4f;
	background: -moz-linear-gradient(top, #bf8279 0%, #6d2d4f 75%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bf8279), color-stop(75%,#6d2d4f));
	background: -webkit-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: -o-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: -ms-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: linear-gradient(to bottom, #bf8279 0%,#6d2d4f 75%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bf8279', endColorstr='#6d2d4f',GradientType=0 );
}
.footer-logo-inria { margin-top: 12px; }



/* Page d'accueil */
.home-news { background:#efefef; padding:0.5em 1em; margin-bottom:1em; }
.elgg-context-dashboard .elgg-form-thewire-add { width: 100%; }
.elgg-context-dashboard .elgg-form-thewire-add #thewire-characters-remaining { float:none; margin: 22px 0 0 0; }
.elgg-context-dashboard .elgg-form-thewire-add .elgg-foot { padding: 0 5%; text-align: center; margin: 0; }
.home-box { margin-bottom:30px; }
.home-wire { margin-bottom:30px; }
.home-activity {  }
.iris-news {  }


/* Page animation */
.anim-stats .elgg-table-alt td:first-child { max-width: 180px !important; }

/* Navigation des pages wiki en pleine largeur */
.full-width-pages-nav { border-top: 1px solid #ccc; margin-top: 3em; padding: 0.5em 0.5em 1em 0.5em; background: #efefef; }


/* Inria tools */
.inria-tool-widget .elgg-horizontal label { float: left; clear: none !important; }
.inria-tool-link { padding: 3px 5px; margin: 4px; display: inline-block; }



/* Group tabs */
/* ***************************************
	GROUP FILTER MENU
*************************************** */
.elgg-menu-group-filter {
	margin-bottom: 5px;
	border-bottom: 2px solid #ccc;
	display: table;
	width: 100%;
}
.elgg-menu-group-filter > li {
	float: left;
	border: 2px solid #ccc;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 10px;
	
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
	border-radius: 5px 5px 0 0;
}
.elgg-menu-group-filter > li:hover, 
.elgg-menu-group-filter > li:focus, 
.elgg-menu-group-filter > li:active {
	background: #dedede;
}
.elgg-menu-group-filter > li > a {
	text-decoration: none;
	display: block;
	padding: 3px 10px 0;
	text-align: center;
	height: 21px;
	color: #999;
}

/*********	Change tab hover here	********/
.elgg-menu-group-filter > li > a:hover, 
.elgg-menu-group-filter > li > a:focus, 
.elgg-menu-group-filter > li > a:active {
	background: #dedede;
	color: #000;
}
.elgg-menu-group-filter > .elgg-state-selected {
	border-color: #ccc;
	background: white;
}
.elgg-menu-group-filter > .elgg-state-selected > a {
	position: relative;
	top: 2px;
	background: white;
}

.group-top-menu .elgg-menu-group-filter { margin-bottom: 0; }
.elgg-menu-group-filter > li.grouptab-action { float: right; background: #ccc; border-color: #ccc; }
.elgg-menu-group-filter > li.grouptab-action a { color: white; }
.elgg-menu-group-filter > li.grouptab-action:hover, .elgg-menu-group-filter > li.grouptab-action:focus, .elgg-menu-group-filter > li.grouptab-action:active { background: #ddd; border-color: #ddd; }
/*
.elgg-menu-group-filter > li.grouptab-action a:hover, .elgg-menu-group-filter > li.grouptab-action a:focus, .elgg-menu-group-filter > li.grouptab-action a:active { color:white; }
*/
.elgg-menu-group-filter > li.elgg-menu-item-pages a, .elgg-menu-group-filter > li.elgg-menu-item-pages a:hover, .elgg-menu-group-filter > li.elgg-menu-item-pages a:active, .elgg-menu-group-filter > li.elgg-menu-item-pages a:focus { background: transparent !important; }
.elgg-menu-group-filter > li:first-child { margin-left: 0px; }

/* Hide group extras tools */
/*
.elgg-context-groups .elgg-menu-extras { display: none; }
*/
.elgg-menu-item-bookmark, .elgg-menu-item-report-this, .elgg-menu-item-rss { display: none !important; }


/* PROFILE */
.elgg-context-profile .elgg-widgets { float: left; }
/* Widgets du profil façon Linkedin */
.profile-widgets .elgg-widget-add-control { float:left; text-align: left; margin: 1%; background: #eee; height: 30px; border: 2px dotted #aaa; padding: 10px 1% 0px 1%; }
#elgg-widget-col-1 { clear: both; }
.inria-ldap-details { border: 1px solid black; padding: 4px; margin: 0 0 10px 0; background: white; }


/* Inria Tools Widget */
.inria-tool-link { padding-left: 34px; color: black; font-size: 18px; }
.inria-tool-forge { background: url(<?php echo $tools_url; ?>GForge.png) no-repeat top left; }
.inria-tool-notepad { background: url(<?php echo $tools_url; ?>NOTEPAD.png) no-repeat top left; }
.inria-tool-framadate { background: url(<?php echo $tools_url; ?>FRAMADATE.png) no-repeat top left; }
.inria-tool-webinar { background: url(<?php echo $tools_url; ?>Visioconference.png) no-repeat top left; }
.inria-tool-ftp { background: url(<?php echo $tools_url; ?>TRANSFER.png) no-repeat top left; }
.inria-tool-share { background: url(<?php echo $tools_url; ?>PARTAGE.png) no-repeat top left; }
.inria-tool-confcall { background: url(<?php echo $tools_url; ?>AUDIOCONFERENCE.png) no-repeat top left; }
.inria-tool-evo { background: url(<?php echo $tools_url; ?>EVO.png) no-repeat top left; }
.inria-tool-mailinglist { background: url(<?php echo $tools_url; ?>Listedediffusion.png) no-repeat top left; }
.inria-tool-mailer { background: url(<?php echo $tools_url; ?>MAILER.png) no-repeat top left; }
.inria-tool-mission { background: url(<?php echo $tools_url; ?>IZIGFD.png) no-repeat top left; }
.inria-tool-mission2 { background: url(<?php echo $tools_url; ?>ORELI.png) no-repeat top left; }
.inria-tool-holidays { background: url(<?php echo $tools_url; ?>CASA.png) no-repeat top left; }
.inria-tool-annuaire { background: url(<?php echo $tools_url; ?>ANNUAIRE.png) no-repeat top left; }
.inria-tool-tickets { background: url(<?php echo $tools_url; ?>TICKETS.png) no-repeat top left; }




