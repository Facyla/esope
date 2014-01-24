<?php
global $CONFIG;
$fonturl = $CONFIG->url . 'mod/theme_inria/fonts/';
$imgurl = $CONFIG->url . 'mod/theme_inria/graphics/';
$tools_url = $imgurl . 'inria_widget/';

// Configurable elements : pass theme as $vars['theme-config-css']
// Image de fond du header
$headerimg = elgg_get_plugin_setting('headerimg', 'adf_public_platform');
if (!empty($headerimg)) $headerimg = $vars['url'] . $headerimg;
$backgroundcolor = elgg_get_plugin_setting('backgroundcolor', 'adf_public_platform');
$backgroundimg = elgg_get_plugin_setting('backgroundimg', 'adf_public_platform');
if (!empty($backgroundimg)) $backgroundimg = $vars['url'] . $backgroundimg;
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
// Couleur 1 : Haut dégradé header
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
// Couleur 4 : Bas dégradé header
$color4 = elgg_get_plugin_setting('color4', 'adf_public_platform');
// Couleur 2 : Haut dégradé widgets/modules
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3 : Bas dégradé widgets/modules
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');
// Couleur 5-8 : Dégradés des boutons + dégradé hover
$color5 = elgg_get_plugin_setting('color5', 'adf_public_platform');
$color6 = elgg_get_plugin_setting('color6', 'adf_public_platform');
$color7 = elgg_get_plugin_setting('color7', 'adf_public_platform');
$color8 = elgg_get_plugin_setting('color8', 'adf_public_platform');
// Divers tons de gris par défaut et éléments de l'interface
$color9 = elgg_get_plugin_setting('color9', 'adf_public_platform'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'adf_public_platform'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'adf_public_platform'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'adf_public_platform'); // #DEDEDE
// Couleur de fond du sous-menu déroulant
$color13 = elgg_get_plugin_setting('color13', 'adf_public_platform');
// Module title
$color14 = elgg_get_plugin_setting('color14', 'adf_public_platform');
// Button title
$color15 = elgg_get_plugin_setting('color15', 'adf_public_platform');
// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'adf_public_platform');
// Fonts
$font1 = elgg_get_plugin_setting('font1', 'adf_public_platform');
$font2 = elgg_get_plugin_setting('font2', 'adf_public_platform');
$font3 = elgg_get_plugin_setting('font3', 'adf_public_platform');
$font4 = elgg_get_plugin_setting('font4', 'adf_public_platform');
$font5 = elgg_get_plugin_setting('font5', 'adf_public_platform');
$font6 = elgg_get_plugin_setting('font6', 'adf_public_platform');


$module_title_color = $titlecolor;
$module_bg_color = $color2;
// Force settings
$module_title_color = '#6D2C4F';
$module_bg_color = '#F8F4F5';
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
body { border-top:0; background:white; font-size:12px; font-size:75%; }
section { background:white; }
padding-top: 25px;
background: white;
header { background: #6F2D50 !important; border-top: 0; height:70px !important; }
header .interne h1 { margin-top: 0; }
header nav { top: 27px; }
header nav #user img { float: left; margin-right: 6px; }
header nav ul li a { font-size:12px; font-weight:normal; color: #fff; text-shadow: none; font-family: Arial, Helvetica, sans-serif; }

/* Main menu */
#transverse { background: <?php echo $module_bg_color; ?>; border: 0; box-shadow: none; height: 37px; }
#transverse nav ul li, #transverse nav ul li:first-child { border:0; padding:0; }
#transverse nav ul li a { text-transform:uppercase; color: #EF783E; font-family: NeoFont, Arial, sans-serif; font-size: 14px; font-weight: bold; }
#transverse nav ul li a.active, #transverse nav ul li a.elgg-state-selected, #transverse nav ul li a:hover, #transverse nav ul li a:focus, #transverse nav ul li a:active { background-color: <?php echo $module_bg_color; ?>; color:#6D2D4F; }
#transverse nav ul li ul li a:hover, #transverse nav ul li ul li a:focus, #transverse nav ul li ul li a:active { background: <?php echo $module_bg_color; ?>; color: #6D2D4F; }
#transverse nav ul li ul { background: <?php echo $module_bg_color; ?>; top: 37px; left: 0px; box-shadow:none; }
#transverse nav ul li ul li { background: <?php echo $module_bg_color; ?>; }
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

/* Buttons */
.elgg-button.elgg-button-action { border-radius: 5px; border: 1px solid <?php echo $color6; ?>; color: white; font-weight: normal; font-size: 13px; font-family: NeoFont, sans-serif; padding: 4px 6px; }
.elgg-button.elgg-button-action:hover, .elgg-button.elgg-button-action:active, .elgg-button.elgg-button-action:focus { border: 1px solid <?php echo $color8; ?>; }


/* Page d'accueil */
.home-news { /* background:#efefef; */ padding:0.5em 1em; margin-bottom:1em; }
.elgg-context-dashboard .elgg-form-thewire-add { width: 100%; }
.elgg-context-dashboard .elgg-form-thewire-add #thewire-characters-remaining { float:none; margin: 22px 0 0 0; }
.elgg-context-dashboard .elgg-form-thewire-add .elgg-foot { padding: 0 5%; text-align: center; margin: 0; }

.home-box { margin-bottom: 30px; background: <?php echo $module_bg_color; ?>; padding: 0.8em 10px; border-radius: 5px; }
.home-box h3:first-child { font-size:14px; font-family:NeoFont; margin-bottom: 0.8em; color:<?php echo $titlecolor; ?>; }
.home-wire, .home-activity { background:white; }
.home-wire h2 a, .home-activity h2 a { font-size:22px; margin-bottom: 0; color:<?php echo $titlecolor; ?>; }
.home-wire .elgg-list-access, .home-activity .elgg-list-access { display: none; }
.iris-news {  }
.iris-news .anythingControls { position: absolute; top: 30px; left: 20px; display:none; }
.iris-add-button { font-weight: bold; padding: 11px 26px; border: thin dotted <?php echo $titlecolor; ?>; background-color: #F8F4F5; }


/* Widgets */
.elgg-widget-add-control { clear: both; }
section .interne .elgg-layout-one-column div.module { border: 0; background: <?php echo $module_bg_color; ?>; }
section .interne div.module header { background: <?php echo $module_bg_color; ?>; }
section .interne div.module header h2 { color:<?php echo $module_title_color; ?>; font-size:14px; text-transform:initial; }
section .interne div.module div.activites { background-color: <?php echo $module_bg_color; ?>; }
.elgg-widget-more { background-color: <?php echo $module_bg_color; ?>; }


/* Page animation */
.anim-stats .elgg-table-alt td:first-child { max-width: 180px !important; }

/* Navigation des pages wiki en pleine largeur */
.full-width-pages-nav { border-top: 1px solid #ccc; margin-top: 3em; padding: 0.5em 0.5em 1em 0.5em; background: #efefef; }




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
.inria-tool-widget .elgg-horizontal label { float: left; clear: none !important; }
.elgg-button.inria-tool-link { background-repeat: no-repeat !important; padding-left: 3px 5px 3px 34px !important; margin: 4px; min-width: 10ex; /* color: black; font-size: 18px; */ }
.inria-tool-forge { background-image: url(<?php echo $tools_url; ?>GForge.png) !important; }
.inria-tool-notepad { background-image: url(<?php echo $tools_url; ?>NOTEPAD.png) !important; }
.inria-tool-framadate { background-image: url(<?php echo $tools_url; ?>FRAMADATE.png) !important; }
.inria-tool-webinar { background-image: url(<?php echo $tools_url; ?>Visioconference.png) !important; }
.inria-tool-ftp { background-image: url(<?php echo $tools_url; ?>TRANSFER.png) !important; }
.inria-tool-share { background-image: url(<?php echo $tools_url; ?>PARTAGE.png) !important; }
.inria-tool-confcall { background-image: url(<?php echo $tools_url; ?>AUDIOCONFERENCE.png) !important; }
.inria-tool-evo { background-image: url(<?php echo $tools_url; ?>EVO.png) !important; }
.inria-tool-mailinglist { background-image: url(<?php echo $tools_url; ?>Listedediffusion.png) !important; }
.inria-tool-mailer { background-image: url(<?php echo $tools_url; ?>MAILER.png) !important; }
.inria-tool-mission { background-image: url(<?php echo $tools_url; ?>IZIGFD.png) !important; }
.inria-tool-mission2 { background-image: url(<?php echo $tools_url; ?>ORELI.png) !important; }
.inria-tool-holidays { background-image: url(<?php echo $tools_url; ?>CASA.png) !important; }
.inria-tool-annuaire { background-image: url(<?php echo $tools_url; ?>ANNUAIRE.png) !important; }
.inria-tool-tickets { background-image: url(<?php echo $tools_url; ?>TICKETS.png) !important; }




