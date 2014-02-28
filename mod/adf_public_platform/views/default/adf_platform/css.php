<?php
$url = $vars['url'];
$urlfonts = $vars['url'] . 'mod/adf_public_platform/fonts/';
$urlicon = $vars['url'] . 'mod/adf_public_platform/img/theme/';

// Configurable elements and default values

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'adf_public_platform');
if ($fixedwidth != 'yes') $fixedwidth = false; else $fixedwidth = true;

// Image de fond configurable
$headbackground = elgg_get_plugin_setting('headbackground', 'adf_public_platform');
if (empty($headbackground)) { $headbackground = $vars['url'] . 'mod/adf_public_platform/img/headimg.jpg'; }
/* Toutes les couleurs de l'interface
#000000 // noir
#2a2a2a // gris quasi-noir
#333333 // gris très sombre
#4c4c4c // gris sombre
#666666 // gris moyen sombre
#888888 // gris moyen
#999999 // gris moyen
#b0b0b0 // gris moyen clair
#cccccc // gris clair
#dedede // gris très clair
#f6f6f6 // gris très pâle
#f9f9f9 // gris quasi-blanc

#e5e3e1 // gris légèrement violet
#ebf5ff // bleu très pâle
#f2f1ef // gris très pâle légèrement violet
#f2f1f0 // gris très pâle légèrement rouge

#ffffff // blanc

#002e3e // bleu marine (tire sur le vert)
#002e6e // bleu marine
#0050bf // bleu roi
#0066cc // bleu clair
#c61b15 // rouge vif
*/

// Couleur des titres : #0A2C83
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
// Couleur du texte : #333333
$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform');
// Couleur des liens : #002e6e
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
// #0A2C83 - lien actif/au survol
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');

// Dégradés
// Couleur 1 : #0050BF - haut du dégradé header et pied de page
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
// Couleur 4 : #002E6E - bas du dégradé header et pied de page
$color4 = elgg_get_plugin_setting('color4', 'adf_public_platform');
// Couleur 2 : #F75C5C - haut du dégradé des modules
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3 : #C61B15 - bas du dégradé des modules
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');

// Boutons
$color5 = elgg_get_plugin_setting('color5', 'adf_public_platform'); // #014FBC
$color6 = elgg_get_plugin_setting('color6', 'adf_public_platform'); // #033074
$color7 = elgg_get_plugin_setting('color7', 'adf_public_platform'); // #FF0000
$color8 = elgg_get_plugin_setting('color8', 'adf_public_platform'); // #990000

// Non configurable : éléments bas niveaux de l'interface : fonds et bordures (les gris clairs et foncés)
$color9 = elgg_get_plugin_setting('color9', 'adf_public_platform'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'adf_public_platform'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'adf_public_platform'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'adf_public_platform'); // #DEDEDE
// Couleur de fond du sous-menu
$color13 = elgg_get_plugin_setting('color13', 'adf_public_platform'); // #DEDEDE
$color14 = elgg_get_plugin_setting('color14', 'adf_public_platform'); // Titre modules
$color15 = elgg_get_plugin_setting('color15', 'adf_public_platform'); // Titre boutons

// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'adf_public_platform');

$font1 = elgg_get_plugin_setting('font1', 'adf_public_platform');
$font2 = elgg_get_plugin_setting('font2', 'adf_public_platform');
$font3 = elgg_get_plugin_setting('font3', 'adf_public_platform');
$font4 = elgg_get_plugin_setting('font4', 'adf_public_platform');
$font5 = elgg_get_plugin_setting('font5', 'adf_public_platform');
$font6 = elgg_get_plugin_setting('font6', 'adf_public_platform');
?>


/* ELEMENTS ET CLASSES DE BASE - BASIC CLASSES AND ELEMENTS */
.mts { margin-right:10px; }
.elgg-river-comments-tab { color:#cd9928; }
.elgg-input-rawtext { width:99%; }
/* Tableaux */
th { font-weight:bold; background:#CCCCCC; }
/* Access level informations */
.elgg-access {}
.elgg-access-group-closed {}
.elgg-access-group-open {}
.interne { width: 980px; position: relative; margin: auto; }
.invisible { position: absolute !important; left: -5000px !important; }
.right { float: right !important; }
.minuscule { text-transform: lowercase; }
img { border: 0 none; overflow:hidden; }
section #profil img { float: right; margin-left: 10px; }



/* MISE EN PAGE ET PRINCIPAUX BLOCS - LAYOUTS AND MAIN BLOCKS */
/* Pour tous les éléments du menu : .elgg-menu-owner-block .elgg-menu-item-NOM_SUBTYPE */
#wrapper_header {}
header, #transverse, section, footer, #bande { width: 100%; float: left; }

/* Styles des modules page d'accueil et profil */
section { padding-top: 25px; }
section header { background: none; border-top: 0 none; height: auto; }
section div.intro { font-family:<?php echo $font4; ?>; font-size: 1.25em; }

#transverse nav ul li.group-invites, .interne nav ul li.group-invites, 
#transverse nav ul li.invites, .interne nav ul li.invites { margin:-6px 0 0 4px; }
#transverse nav ul li.group-invites, 
#transverse nav ul li.invites { margin:-8px 0 0 -22px; border:0; }
#transverse nav ul li.group-invites a, #transverse ul li.group-invites a:hover, #transverse ul li.group-invites a:focus, #transverse ul li.group-invites a:active,
.interne nav ul li.group-invites a, .interne nav ul li.group-invites a:hover, .interne nav ul li.group-invites a:focus, .interne nav ul li.group-invites a:active, 
#transverse nav ul li.invites a, #transverse ul li.invites a:hover, #transverse ul li.invites a:focus, #transverse ul li.invites a:active,
.interne nav ul li.invites a, .interne nav ul li.invites a:hover, .interne nav ul li.invites a:focus, .interne nav ul li.invites a:active {
	float: right;
	background: #CD190A;
	color: #fff;
	font-size:12px;
	font-weight: bold;
	padding: 2px 5px 2px 6px;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	-o-border-radius: 4px;
	box-shadow: 1px 1px 2px #333333;
	-moz-box-shadow: 1px 1px 2px #333333;
	-webkit-box-shadow: 1px 1px 2px #333333;
	-o-box-shadow: 1px 1px 2px #333333;
}
.elgg-form.thewire-form { background: transparent; }
.home-static { background:white; box-shadow:3px 3px 5px 0px #666; padding: 0.2% 0.4%; }


/* Sidebar */
.elgg-sidebar { width: 211px; float: right; }
.elgg-sidebar ul.elgg-menu-page, elgg-sidebar ul.elgg-menu-groups-my-status {
	background: #fff;
	float: left;
	width: 211px;
}
.elgg-sidebar ul.elgg-menu-page > li, elgg-sidebar ul.elgg-menu-groups-my-status > li {
	border-bottom: 1px solid #CCCCCC;
	float: left;
	width: 211px;
}
.elgg-menu-groups-my-status li a {
	-moz-border-radius:0; -webkit-border-radius:0; border-radius:0;
	width:211px; margin:0; padding:4px 10px;
}
.elgg-menu-groups-my-status li a:hover {
	-moz-border-radius:0; -webkit-border-radius:0; border-radius:0;
	width:211px; margin:0; padding:4px 10px;
}
.elgg-sidebar ul.elgg-menu-page li h3 {
	background: #333333;
	border-radius: 3px 3px 0 0;
	-moz-border-radius: 3px 3px 0 0;
	-webkit-border-radius: 3px 3px 0 0;
	-o-border-radius: 3px 3px 0 0;
	color: #fff;
	font-weight: normal;
	margin: 0;
	padding: 4px 10px;
	text-transform: uppercase;
}
.elgg-sidebar .elgg-menu-page li:first-child, .elgg-sidebar .elgg-menu-page li:last-child, .elgg-sidebar .elgg-menu-groups-my-status li:first-child, .elgg-sidebar .elgg-menu-groups-my-status li:last-child { border-bottom: 0 none; }
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a { color: #333333; font-weight: normal; }
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a span {
	color: #002e6f;
	float: left;
	font-family: <?php echo $font2; ?>;
	font-size: 1.7em;
	font-weight: bold;
	line-height: 0.7em;
	margin-right: 5px;
	text-shadow: 0 2px 2px #999999;
}
.elgg-sidebar .elgg-module-aside h3 { color: #333333; font-size: 16px; margin: 0; }
.elgg-sidebar .elgg-module-aside .elgg-body ul li { float: left; width: auto; }
.elgg-sidebar .elgg-module-aside .elgg-body ul li a img {
	float: left;
	margin-right: 5px;
	height: 25px;
	width: 25px;
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

/* Pied de page - HTML spécifique */
footer {
	background-image: linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -o-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -moz-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -webkit-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -ms-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0.30, #333333), color-stop(0.80, #666666));
	background-color: #333333;
	height: 66px;
	margin-top: 25px;
}
footer ul { margin: auto; width: 500px; font-size: 0.75em; }
footer ul li {
	float: left; padding-left: 13px; margin: 26px 7px 10px 0;
	background: transparent url("<?php echo $urlicon; ?>puce-footer.png") left 7px no-repeat scroll;
	color: #fff; font-size:12px;
}
footer ul li:first-child { background: none; }
footer ul li a { color: #fff; font-size:12px; }
footer ul li a:hover, footer ul li a:focus, footer ul li a:active { color: #ddd; }
footer img { float: right; }

/* Bande inférieure du pied de page - HTML spécifique */
#bande {
	background-image: linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: -o-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: -moz-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: -webkit-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: -ms-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.25, <?php echo $color1; ?>),color-stop(0.75, <?php echo $color4; ?>));
	background-color: <?php echo $color4; ?>;
	border-top: 2px solid <?php echo $color1; ?>;
	height: 10px;
}
div.credits { font-size: 0.85em; }
div.credits p { float: left; color: #333333; margin: 4px 0 5px; }
div.credits a { color: #333333; text-decoration:underline; }



/* BLOC DU CONTENU PRINCIPAL - MAIN CONTENT */
#page_container {
	width:990px; margin:0px auto; background:#fff; min-height: 100%;
	-moz-box-shadow: 0 0 10px #888; -webkit-box-shadow: 0 0 10px #888; box-shadow: 0 0 10px #181a2f;
}



/* MENUS & NAVIGATION */
.elgg-menu-item-report-this { margin-left:10px; margin-top:5px; }
/* Eviter les recouvrements par le menu des entités */
.elgg-menu-entity { height:auto; text-align: center; }
nav ul li, #transverse ul li { list-style-type: none; }
ul.elgg-list li.elgg-item ul.elgg-menu { font-size: 0.75em; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-one { width: 40px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-date { width: 60px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members { width: 90px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members a { color: <?php echo $linkcolor; ?>; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-membership { width: 50px; }

.profile-content-menu a { border-radius: 0; }
/* Menus différenciés : navigation secondaire */
.elgg-menu-page .elgg-menu-item-groups-all a, 
.elgg-menu-page .elgg-menu-item-groups-member a, 
.elgg-menu-page .elgg-menu-item-groups-owned a, 
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a, 
.elgg-menu-page .elgg-menu-owner-block-categories li a {
	/* font-weight:bold !important; */ font-size:14px; color:<?php echo $linkcolor; ?>;
}

.elgg-menu-page .elgg-menu-item-groups-all a:hover, .elgg-menu-page .elgg-menu-item-groups-all a:focus, .elgg-menu-page .elgg-menu-item-groups-all a:active, .elgg-menu-page .elgg-menu-item-groups-all.elgg-state-selected > a,
.elgg-menu-page .elgg-menu-item-groups-member a:hover, .elgg-menu-page .elgg-menu-item-groups-member a:focus, .elgg-menu-page .elgg-menu-item-groups-member a:active, .elgg-menu-page .elgg-menu-item-groups-member.elgg-state-selected > a,
.elgg-menu-page .elgg-menu-item-groups-owned a:hover, .elgg-menu-page .elgg-menu-item-groups-owned a:focus, .elgg-menu-page .elgg-menu-item-groups-owned a:active, .elgg-menu-page .elgg-menu-item-groups-owned.elgg-state-selected > a, 
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:hover, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:focus, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:active, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites.elgg-state-selected > a, 
/*
.elgg-sidebar .elgg-menu-groups-my-status li a:hover, .elgg-sidebar .elgg-menu-groups-my-status li a:focus, .elgg-sidebar .elgg-menu-groups-my-status li a:active, .elgg-sidebar .elgg-menu-groups-my-status li.elgg-state-selected > a, 
*/
.elgg-menu-owner-block-categories li a:hover, .elgg-menu-owner-block-categories li a:focus, .elgg-menu-owner-block-categories li a:active, .elgg-menu-owner-block-categories li.elgg-state-selected > a 
{
	background-color: <?php echo $linkcolor; ?>; color: white;
	border-radius:0;
}

/* Menus différenciés : navigation complémentaire */
.elgg-menu-page a { font-weight:normal; font-size:14px; }
.elgg-menu-page a:hover, 
.elgg-menu-page a:focus, 
.elgg-menu-page a:active, 
.elgg-menu-page .elgg-state-selected a,
.elgg-menu-page .elgg-state-selected a:hover, 
.elgg-menu-page .elgg-state-selected a:focus, 
.elgg-menu-page .elgg-state-selected a:active {
	text-decoration: none;
	background-color:<?php echo $linkcolor; ?>;
	color: #FFF !important;
	text-decoration: none;
}

.elgg-sidebar ul.elgg-menu-page > li { border-bottom:0px solid #CCCCCC !important; }
/* Evite que le texte alternatif casse la mise en forme si l'image ne s'affiche pas.. */
.elgg-sidebar .elgg-head .elgg-image { max-width: 60px; overflow: hidden; }

.calendar-navigation { margin:0 0 16px 0; }
.calendar-navigation a {
	-webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;
	padding: 2px 6px; border: 1px solid <?php echo $linkcolor; ?>;
	color: <?php echo $linkcolor; ?>;
	font-size: 0.85em;
}



/* BLOCS SPECIFIQUES : CONNEXION, etc. - MAIN BLOCKS : LOGIN, etc. */
#login-dropdown { position: absolute; top:110px; right:0; z-index: 100; margin-right:10px; }
/* Page de connexion et d'inscription */
.adf-strongseparator { border: 1px solid <?php echo $color4; ?>; clear:both; margin:12px auto; }
.adf-lightseparator { border: 1px solid white; clear:both; margin:16px auto; }

#adf-public-col1 { float:left; width:50%; }
#adf-public-col2 { float:right; width:44%; }

#adf-homepage { margin-top:30px; }
#adf-homepage p { font-size:14px; margin-top:0; margin-bottom:8px; }
#adf-homepage .elgg-form-register { font-size:13px; margin-top:0; margin-bottom:8px; }
#adf-homepage a, #adf-homepage a:visited { color:<?php echo $linkcolor; ?>; }
#adf-homepage a:hover, #adf-homepage a:active, #adf-homepage a:focus { color:red; }
#adf-homepage .elgg-form { background:transparent; }
#adf-homepage h2 { font-size:20px; font-weight:normal; }

#adf-homepage label { width:130px; float:left; margin:0 0 16px 0; clear:both; text-align:right; }
#adf-homepage input[type='text'], 
#adf-homepage input[type='password'], 
#adf-homepage select { width:280px; float:right; margin-bottom:16px; }

#adf-homepage form.elgg-form { width:100%; padding:0; }

#adf-loginbox { border:1px solid #CCCCCC; padding:10px 20px; margin-top:30px; background:#F6F6F6; }
#adf-loginbox form { margin:0; padding:0; }

#adf-homepage #adf-persistent { width:280px; float:right; margin:0; position:relative; top:-16px; }
#adf-homepage #adf-persistent label { width:auto; float:left; margin:0; margin-left:-5px; }

#adf-homepage input[type='submit'], 
.adf-lostpassword-link { margin-left:160px; }
#adf-homepage .elgg-form-register input[type='submit'] { margin-left:150px; }

#adf-homepage .adf-lostpassword-link { position:relative; top:-16px; margin-left:168px; }

#adf-homepage ul { list-style-type: square; }
#adf-homepage ul li { margin-bottom:8px; }
#adf-homepage .elgg-form-register fieldset > div, #adf-homepage .elgg-form-register .mandatory { clear: both; }



/* FORMULAIRES - FORMS */
/* Aide event_calendar form */
.elgg-form-event-calendar-edit .description { font-style:italic; font-size:0.90em; }
.elgg-form-groups-find input[type='text'] { width:250px; }
.elgg-form-groups-find input.elgg-button-submit { vertical-align:20%; margin:0; }
/* New integrated in-group search */
.elgg-sidebar .elgg-form.elgg-form-groups-search { border: 0; background: white; padding: 0; margin-bottom: 20px; width:100%; }
.elgg-form.elgg-form-groups-search #q { height:24px; width:84%; border:0; margin:0; }
.groups-search-submit-button { height:24px; width:auto; border:1px solid grey; vertical-align: top; float:right; border:0; background-color:#ccc; padding:5px 7px 5px 8px; }
.groups-search-submit-button:hover, .groups-search-submit-button:active, .groups-search-submit-button:focus { background-color:#999; }


/* WIDGETS */
.elgg-module-widget:hover, 
.elgg-module-widget:focus, 
.elgg-module-widget:active { background-color: transparent; }
/* Widgets - à corriger pour utiliser les classes du framework Elgg */
section div.module {
	background: url("<?php echo $urlicon; ?>ombre-module.png") no-repeat scroll left 5px transparent;
	width: 300px; /* Imposé par l'image de fond, mais bloque les mises en page fluides */
	float: left;
	margin: 20px -1px 0;
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
	padding: 0 14px;
}
section div.module header {
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
min-height: 33px;
}
section div.module header h2 {
	color: <?php echo $color14; ?>;
	float: left;
	font-family: <?php echo $font1; ?>;
	font-size: 1.25em;
	text-transform: uppercase;
	font-weight: normal;
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
a.elgg-widget-edit-button { right: 12px; }

div.elgg-widgets div.elgg-body { font-size: 0.90em; }
.elgg-module .elgg-body, .elgg-module .elgg-content, .elgg-module .elgg-river-summary { font-size:14px; }
.elgg-module .entity_title { font-size:16px; }
.elgg-widget-instance-event_calendar p { font-size: 1.3em; }


/* Contenu des modules */
section div.module header ul { float: right; margin: 8px 10px 0 0; }

/* Boutons des widgets */
section div.module header ul li a { float: left; margin-left: 6px; margin:0; right: auto; }
.elgg-menu-widget button { outline: none; border: 0; background: transparent; margin-left: 0.5ex; color: <?php echo $color14; ?>; }


section div.module div.activites { background-color: #fff; float: left; padding-top: 5px; width: 300px; }
section div.module div.activites h3 { margin: 5px 7px; font-size: 1.1em; color: #333333; float: left; font-size: 1em; }
section div.module div.activites ul li { padding-bottom: 1px; }
section div.module div.activites ul li img { margin: 0 5px 0 7px; }
section div.module div.activites ul li div span { color: #666; font-style: italic; }

/* Widgets activité des groupes */
section div.elgg-widget-instance-group_activity div.elgg-body.activites, 
section div.elgg-widget-instance-group_activity div.elgg-body.activites .elgg-widget-content { padding:0; }
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
	padding:0 14px; 
	background:<?php echo $color3; ?>;
	/* margin-top:-8px; */
}
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
	color:white;display:block;
	font-family: <?php echo $font1; ?>;
	font-size:14px;
}
.widget-group-content { padding: 0 10px 10px 10px; }





/* Thème ADF - Urbilog => Styles à classer et réorganiser */

/* Afficher/masquer les commentaires inline */
a.ouvrir { float: right; padding: 0 4px 0 0; clear:both; }
/* Infos dépliables */
section div.module div.plus { clear:both; padding-top:2px; }
.elgg-item .plus { clear:both; }

section article.fichier div.activites ul li a { float: left; font-size: 0.9em; font-weight: bold; width: 245px; }
section article.fichier div.activites ul li span { color: #666; float: left; font-size: 0.75em; font-style: italic; margin-top: 2px; width: 245px; margin-bottom: 5px; }
section article.fichier div.activites ul li span a { float: none; font-size: 1em; font-weight: normal; }



.elgg-river-attachments, .elgg-river-message, .elgg-river-content { border-left: 1px solid #666; color: #666; font-size: 0.85em; clear:left; }

/* Rendu des listes */
ul.elgg-list li.elgg-item div.elgg-image a img { margin-right: 5px; }
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:hover, 
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:focus, 
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:active { color: #333333; }


div.entetes-tri ul {
	float: left; width: 717px; margin: 10px 0; padding: 5px 0;
	background: #f6f6f6; color: #000; font-size: 0.75em; text-align: center;
}
div.entetes-tri ul li { float: left; margin-left: 10px; }
div.entetes-tri ul li a { color: #000; }
div.entetes-tri ul li a:hover, 
div.entetes-tri ul li a:focus, 
div.entetes-tri ul li a:active { color: #333333; }
div.entetes-tri ul li a img { float: right; }
div.entetes-tri ul li.elgg-date { margin-left: 385px; width: 70px; }
div.entetes-tri ul li.elgg-annuaire { width: 80px; }
div.entetes-tri ul li.e.elgg-module .elgg-body .mts { float: left; clear: left; font-size: 0.9em; }lgg-acces { width: 60px; }



/* Ajouts à répartir dans les bons fichiers */
.groups-profile { font-size: 0.85em; border-bottom: 1px solid #CCCCCC; }
.groups-stats { background:none; }
.groups-profile-fields .odd, .groups-profile-fields .even { background:none; }
.elgg-output ul { color: #333333; }
.elgg-river > li:last-child { border-bottom: 0 none; }

/* Messages are now conversations, let's style this a little */
.message.unread a { color: <?php echo $linkcolor; ?>; font-weight:bold; }
.messages-owner { width: 26%; margin-right: 2%; }
.messages-subject { width: 55%; margin-right: 2%; }
.messages-timestamp { width: 8%; margin-right: 2%; }
.messages-delete { width: 5%; }
.elgg-item.selected-message { opacity:1; }
.message-item-toggle { text-align: center; padding: 4px; display: block; background: #eee; }
.elgg-item-message .message-content { width: 96%; padding: 0 0.5%; display:none; padding-bottom: 16px; padding-top: 4px; }
.elgg-item-message .message-content.selected-message { display:block; }
.message-sent .message-content { opacity: 1; }
.message-inbox .message-content {	}
.message-sent .message-content { margin-left:3%; background: #EEE; }


/* Mes paramètres */
.elgg-form-usersettings-save .elgg-body { padding-bottom: 10px; }
.elgg-form-usersettings-save .elgg-body input, .elgg-form-usersettings-save .elgg-body textarea { background: #f6f6f6; }




/* Brainstorm - Doit venir en surcharge pour éviter de modifier CSS du plugin */
.brainstorm-list .idea-content .entity_title { clear:none; padding-top:2px; margin-bottom:6px; }
.brainstorm-list .idea-content .elgg-subtext { float:left; clear:none; }
.brainstorm-list .idea-content.mts div.elgg-content { clear:both; }
.elgg-module-group-brainstorm .idea-content.mts { margin:0; width:240px; clear:none; }
.elgg-widget-instance-brainstorm .elgg-item-idea div.entity_title { width:240px; }
.elgg-widget-instance-brainstorm .elgg-item-idea div.entity_title a { font-weight:normal; }


/* Friendspicker */
#notificationstable td.namefield p.namefieldlink { vertical-align:30%; display:inline; }


#user-avatar-cropper { float: left; }


.firststeps { background:white; padding:4px 8px; margin-bottom:30px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; font-family:<?php echo $font4; ?>; }



/* Evite débordements du texte alternatif si image non affichée */
.elgg-widget-content .elgg-image { max-width: 40%; overflow: hidden; }

/* Alertes et messages d'erreur */
.elgg-system-messages { max-width: 500px; position: absolute; left: 20px; top: 24px; z-index: 2000; background:transparent; }
.elgg-message { box-shadow: 1px 2px 5px #000000; font-size: 120%; padding: 3px 10px; /* background:white; */ }
.elgg-state-success { background-color: #00FF00; }

/* Navigation archives des blogs */
.blog-archives li { clear: left; font-weight: bold; padding: 0 0 4px 0; }
.pages-nav li { clear: left; }


/* Agenda à côté et non sous la liste d'événements */
#event_list, #event_list table { width: 100%; }
.elgg-image .date, .elgg-module-group-event-calendar p.date, .elgg-widget-instance-event_calendar p.date { background: white; width: 9ex; padding: 1px; text-align: center; background:<?php echo $linkcolor; ?>; color: white; line-height: 130%; font-size: 90%; }
.elgg-image .date span { font-size: 2em; display: block; font-weight: bold; background: white; color: <?php echo $linkcolor; ?>; padding: 4px 0; }


/* Formulaires : boutons radios verticaux, mais sans casser les groupes (mal construits avec les labels..) */
/* Pas génial, ça casse beaucoup de choses.. mieux vaut corriger ponctuellement le rendu lorsqu'on veut avoir un radio par ligne.
.elgg-vertical label { float: left; clear: left; }
.elgg-form-groups-edit .elgg-vertical label { float: none; clear: none; }
*/

/* Limit editor max-width to container */
textarea, iframe, .defaultSkin tbody, .defaultSkin * { max-width: 100%; }

/* Champs longtext avec éditeur désactivé par défaut */
textarea, .elgg-input-rawtext { width:100%; }

/* Pour intégration d'une vue complétion du profil sous l'ownerblock du profil */
#profile_completeness_container { background: none repeat scroll 0 0 #EEEEEE; border-top: 1px solid white; width: 200px; padding: 15px; float: left; clear: left; }
#profile_completeness_progress { width: 200px; line-height: 18px; position: absolute; border: 1px solid black; text-align: center; font-weight: bold; }

/* Menu édition des sous-groupes (saute à droite sous Firefox) */
.elgg-form.elgg-form-alt.elgg-form-groups-edit { width:96%; }
.elgg-form.elgg-form-alt.elgg-form-groups-edit + div { clear: both; margin: 40px 0 0; padding: 0; }


/* Agencement fluide des blocs dans les groupes */
.elgg-gallery-fluid > li { float: right; }
#groups-tools > li.odd { float: left; }
#groups-tools > li { margin-bottom: 20px; min-height: 100px; width: 50%; min-width: 300px; display:inline-block; }

#groups-tools > li:nth-child(2n+1) { margin-right: 0; margin-left: 0; }
#groups-tools > li:nth-child(2n) { margin-right: 0; margin-left: 0; }

/* Generic useful classes */
.no-spaces { border: 0 none !important; margin: 0 !important; padding: 0 !important; }

/* Accordion styles */
.ui-icon.ui-icon-triangle-1-s, .ui-icon.ui-icon-triangle-1-e { float: left; margin-right: 6px; }
#custom_fields_userdetails .ui-accordion-header { padding: 0.3em 0 0.3em 1.8em; }
#custom_fields_userdetails .ui-accordion-header .ui-icon { margin-top:0.5em; top:0; }

/* Semantic UI adjustments */
i.icon, i.icon:hover, i.icon:focus, i.icon:active { text-decoration:none; }

/* Effets de survol */
/*
.elgg-module-widget, .elgg-module-group { opacity: 0.8; }
.elgg-module-widget:hover, .elgg-module-widget:active, .elgg-module-widget:focus, 
.elgg-module-group:hover, .elgg-module-group:active, .elgg-module-group:focus { opacity: 1; }
*/
.elgg-item { opacity: 0.75; }
.elgg-item .elgg-item { opacity: 1; } /* Don't double the effect */
.elgg-item:hover, .elgg-item:active, .elgg-item:focus { opacity: 1; }
.elgg-list-river > li:hover { background-color: #F9F9F9; }

/* Autocomplete content : le menu n'est pas utile */
.elgg-autocomplete-item .elgg-menu { max-width: 40%; display:none; }

/* Members alpha sort and search */
.esope-alpha-char a { font-family: <?php echo $font3; ?>; text-decoration: none; margin: 0 0.2em; }

/* Header nav icons (using semantic UI or awesome fonts) */
header nav .fa { margin-right: 0.5em; }
header nav ul li#msg a, header nav ul li#man a { background:transparent; padding:0; }


/* Menu fixé en haut lors du scrolling */
.floating { position: fixed !important; z-index: 101; }
/*
header .floating { background:black; width:100%; top:0; height:30px; overflow:hidden; z-index:102; }
*/
header .floating { background:<?php echo $color1; ?>; width:100%; top:0; height:30px; border-top: 5px solid #333333; padding-top: 2px; overflow:hidden; z-index:102; }
#transverse.floating { margin-top: 32px; }

/* ESOPE search */
#esope-search-form { padding: 15px 0px; }
.esope-search-metadata { float: left; margin-right: 1em; }
#esope-search-form select { width: 7em; margin-left: 0.5em; }
.esope-search-fulltext { width: 80%; float: left; }
#esope-search-form input[type="text"] { max-width: 70%; margin-left: 1em; }
.elgg-button-livesearch { float: right; }
.esope-results-count { font-size: 0.8em; color: #808080; }

/* Main search - advanced */
#advanced-search-form { border: 1px dotted #CCC; padding: 6px; margin: 6px 0; background: #FAFAFA; }
#advanced-search-form legend { font-weight: bold; margin-bottom:6px; }
#advanced-search-form input { width:50ex; max-width: 70%; }
#advanced-search-form input.elgg-button-submit { max-width: 20ex; }
#advanced-search-form input.elgg-input-date { max-width: 12ex; }


<?php if (!$fixedwidth) { ?>
/* SECTION RESPONSIVE DESIGN */

/* Pour la fluidité en général */
.elgg-page-default { min-width:200px; max-width:100%; }
.elgg-sidebar { width: 24%; min-width: 211px; margin:0 0 0 1%; }
.elgg-layout-one-sidebar .elgg-main { width: 70%; min-width: 0; padding:1.5%; }
.elgg-sidebar ul.elgg-menu-page, elgg-sidebar ul.elgg-menu-groups-my-status { width:100%; }
/* Menus */
#transverse nav ul { width:auto; }
/* Largeur de page standard */
.interne {min-width:200px; width:auto; max-width:80%; }
/* Quand on utilise les widgets */
.elgg-widgets { min-width:200px; }
section div.module { width: 94%; padding: 3%; background-size:100%; }
section div.module { min-width:180px; }
section div.module div.activites { width:auto; }
section div.module footer { background-size: 100%; }
/* Listing et river */
.elgg-module-info .elgg-image-block .elgg-body .elgg-river-summary { width:auto; }


@media (max-width:1225px) {
	.interne { max-width:980px; }
}

@media (max-width:980px) {
	.interne { max-width:98%; }
	.elgg-page-default { min-width:200px; max-width:100%; }
	.elgg-sidebar { min-width: 50px; width: 26%; margin:0 0 0 0; }
	.elgg-layout-one-sidebar .elgg-main { min-width: 140px; width: 70%; padding:1%; }
}

/*
@media (max-width:600px) {
	.elgg-page-default { min-width:200px; max-width:100%; }
	.elgg-sidebar { width: 100%; margin:0 0 0 0; }
	.elgg-sidebar { height: 70px; overflow: hidden; border-bottom: 3px solid black; }
	.elgg-layout-one-sidebar .elgg-main { width: 100%; padding:1%; }
	#groups-tools > li { width:100%; }
}
*/
<?php } ?>

