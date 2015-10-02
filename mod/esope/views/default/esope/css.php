<?php
/* CSS site public (ne s'applique pas au backoffice administration) */

$url = elgg_get_site_url();
$urlfonts = $url . 'mod/esope/fonts/';
$urlicon = $url . 'mod/esope/img/theme/';

// Configurable elements and default values

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') $fixedwidth = false; else $fixedwidth = true;

// Image de fond configurable
$headbackground = elgg_get_plugin_setting('headbackground', 'esope');
if (empty($headbackground)) { $headbackground = $url . 'mod/esope/img/headimg.jpg'; }
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
$titlecolor = elgg_get_plugin_setting('titlecolor', 'esope');
// Couleur du texte : #333333
$textcolor = elgg_get_plugin_setting('textcolor', 'esope');
// Couleur des liens : #002e6e
$linkcolor = elgg_get_plugin_setting('linkcolor', 'esope');
// #0A2C83 - lien actif/au survol
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'esope');

// Dégradés
// Couleur 1 : #0050BF - haut du dégradé header et pied de page
$color1 = elgg_get_plugin_setting('color1', 'esope');
// Couleur 4 : #002E6E - bas du dégradé header et pied de page
$color4 = elgg_get_plugin_setting('color4', 'esope');
// Couleur 2 : #F75C5C - haut du dégradé des modules
$color2 = elgg_get_plugin_setting('color2', 'esope');
// Couleur 3 : #C61B15 - bas du dégradé des modules
$color3 = elgg_get_plugin_setting('color3', 'esope');

// Boutons
$color5 = elgg_get_plugin_setting('color5', 'esope'); // #014FBC
$color6 = elgg_get_plugin_setting('color6', 'esope'); // #033074
$color7 = elgg_get_plugin_setting('color7', 'esope'); // #FF0000
$color8 = elgg_get_plugin_setting('color8', 'esope'); // #990000

// Non configurable : éléments bas niveaux de l'interface : fonds et bordures (les gris clairs et foncés)
$color9 = elgg_get_plugin_setting('color9', 'esope'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'esope'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'esope'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'esope'); // #DEDEDE
// Couleur de fond du sous-menu
$color13 = elgg_get_plugin_setting('color13', 'esope'); // #DEDEDE
$color14 = elgg_get_plugin_setting('color14', 'esope'); // Titre modules
$color15 = elgg_get_plugin_setting('color15', 'esope'); // Titre boutons

// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'esope');

$font1 = elgg_get_plugin_setting('font1', 'esope');
$font2 = elgg_get_plugin_setting('font2', 'esope');
$font3 = elgg_get_plugin_setting('font3', 'esope');
$font4 = elgg_get_plugin_setting('font4', 'esope'); // Main font
$font5 = elgg_get_plugin_setting('font5', 'esope');
$font6 = elgg_get_plugin_setting('font6', 'esope');
?>


/* ELEMENTS ET CLASSES DE BASE - BASIC CLASSES AND ELEMENTS */
/* h2 { color: #333; } */
pre, code { word-break:break-all; }
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
#profil img { float: right; margin-left: 10px; }
.esope-more { float: right; font-size: 70%; line-height: 1.6; }


/* MISE EN PAGE ET PRINCIPAUX BLOCS - LAYOUTS AND MAIN BLOCKS */

/* ESOPE : bandeau */
.elgg-page-header {
	background-image: url("<?php echo $headerimg; ?>"), linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -o-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -moz-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -webkit-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -ms-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -webkit-gradient(linear, left top, left bottom, color-stop(0.25, <?php echo $color1; ?>), color-stop(0.75, <?php echo $color4; ?>));
	background-position: left 30px, left top;
	background-repeat: repeat-x, repeat;
	background-color: <?php echo $color4; ?>;
	color: #fff;
}
/* Couleur texte normal pour les header dans le contenu de la page */
.elgg-page-header, .elgg-page-body .intro { color: <?php echo $textcolor; ?>; }


.elgg-page-default .elgg-page-sitemenu > .elgg-inner {
	max-width: 990px;
	margin: 0 auto;
}

.elgg-page-body { padding: 1em; }



/* ***************************************
	ESOPE MENU SUPERIEUR
*************************************** */
/* menu dans le header */
.elgg-page-header .elgg-menu-topbar {
	font-size: 0.8em;
	font-weight: bold;
	margin-top:0.5ex;
}
.elgg-menu-topbar li { margin: 0 2em 0 0; }
.elgg-menu-topbar-alt li { margin: 0 0 0 2em; }
.elgg-menu-topbar li a {
	color: #fff;
	text-shadow: 2px 2px 2px #333;
	margin: 0;
	padding:1px;
	display:inline-block;
}
.elgg-page-header .elgg-menu-topbar li#msg a {}
.elgg-page-header .elgg-menu-topbar li#man a {}
#esope-profil {}
#esope-profil img { float: left; margin-right: 0.5ex; }

.elgg-page-header .elgg-menu-topbar li ul {
	background: #fff;
	float: left;
	left: 0;
	top:20px; /* ajouté */
	position: absolute;
	padding: 5px 0;
	box-shadow: 0px 0px 5px #002e3e inset;
	-moz-box-shadow: 0px 0px 5px #002e3e inset;
	-webkit-box-shadow: 0px 0px 5px #002e3e inset;
	-o-box-shadow: 0px 0px 5px #002e3e inset;
}
.elgg-page-header .elgg-menu-topbar li ul li {
	float: left;
	margin: 2px 5px 2px 10px;
	width: 166px;
}
.elgg-page-header .elgg-menu-topbar li ul li a {
	color: #002e3e;
	text-shadow: none;
}
.elgg-page-header .elgg-menu-topbar li a:hover, 
.elgg-page-header .elgg-menu-topbar li a:focus, 
.elgg-page-header .elgg-menu-topbar li a:active { color: #ddd; }

.elgg-menu-topbar a.elgg-menu-counter { display:inline-block; padding:1px 4px; background:red; border-radius:8px; font-size:10px; font-family:arial; font-weight:bold; text-shadow:none; }

/* ESOPE : Topbar submenu support */
.elgg-menu-topbar > li > ul {
	display: none;
	position:absolute;
  background-color: transparent;
  padding-top:4px; 
  left:12px; top:21px; 
  width:200px;
}

.elgg-menu-topbar > li > ul a {
  background-color: #333;  
  color:white; 
  padding: 2px 2px 4px 6px;
}
.elgg-menu-topbar > li > ul a:hover, 
.elgg-menu-topbar > li > ul a:focus, 
.elgg-menu-topbar > li > ul a:active {
  text-decoration:none;
  color:<?php echo $linkcolor; ?>;
}

.elgg-menu-topbar > li:hover > ul, 
.elgg-menu-topbar > li:focus > ul, 
.elgg-menu-topbar > li:active > ul {
  display: block;
}

/* Header nav icons (using semantic UI or awesome fonts) */
.elgg-page-header .elgg-menu-topbar .fa { margin-right: 0.5em; }
.elgg-page-header .elgg-menu-topbar li#msg a, .elgg-page-header .elgg-menu-topbar li#man a { background:transparent; padding:0; }

.elgg-page-header h1 {
	font-family: <?php echo $font2; ?>;
	text-transform: uppercase;
	float: left;
	color:#ffffff;
	font-size:48px;
	font-weight:normal;
	margin:0.5ex auto;
}
.elgg-page-header h1 a { color:#ffffff; }
.elgg-page-header h1 a:hover,
.elgg-page-header h1 a:focus,
.elgg-page-header h1 a:active { color:#ffffff; }
.elgg-page-header h1 span {
	font-size: 1.4em;
}


/* ***************************************
	ESOPE MENU DE NAVIGATION
*************************************** */
#transverse {
	background-color: #F6F6F6;
	position: relative;
}
#transverse .elgg-menu-navigation {
	float: left;
	font-family: <?php echo $font3; ?>;
	font-size: 1.25em;
}
#transverse .elgg-menu-navigation { width: 650px; }
#transverse .elgg-menu-navigation li {
	float: left;
	border-right: 1px solid #ccc;
	padding-left: 1px;
	position: relative;
}
#transverse .elgg-menu-navigation li:first-child {
	border-left: 1px solid #ccc;
}
#transverse .elgg-menu-navigation li ul li:first-child { border-left: 0; }
#transverse .elgg-menu-navigation li a {
	color: #333;
	float: left;
	padding: 10px 14px;
}
#transverse .elgg-menu-navigation li a.active, 
#transverse .elgg-menu-navigation li a.elgg-state-selected, 
#transverse .elgg-menu-navigation li a:hover, 
#transverse .elgg-menu-navigation li a:focus, 
#transverse .elgg-menu-navigation li a:active {
	background-color: #ccc;
	text-decoration: none;
}
#transverse .elgg-menu-navigation li ul {
	background: <?php echo $color13; ?>;
	position: absolute;
	top: 40px; /* au lieu de 44px */
	left: -1px;
	z-index: 2;
	box-shadow: 2px 2px 3px #333;
	-moz-box-shadow: 2px 2px 3px #333;
	-webkit-box-shadow: 2px 2px 3px #333;
	-o-box-shadow: 2px 2px 3px #333;
	width: 202px;
}
#transverse .elgg-menu-navigation li ul li {
	clear: left;
	background: <?php echo $color13; ?>;
	width: 200px;
	float: left;
}
#transverse .elgg-menu-navigation li ul li a {
	float: left;
	width: 181px;
	padding: 2px 10px;
	font-size: 0.9em;
	border-bottom: 1px solid #fff;
}

#transverse .elgg-menu-navigation li.groups ul { width: 402px; }
#transverse .elgg-menu-navigation li.groups ul li { width: 400px; }
#transverse .elgg-menu-navigation li.groups ul li a { width: 381px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup { margin-left: 6px; width: 394px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup a { width: 375px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-2 { margin-left: 12px; width: 388px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-2 a { width: 369px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-3 { margin-left: 18px; width: 382px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-3 a { width: 363px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-4 { margin-left: 24px; width: 376px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-4 a { width: 357px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-5 { margin-left: 30px; width: 370px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-5 a { width: 351px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-6 { margin-left: 36px; width: 364px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-6 a { width: 345px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-7 { margin-left: 42px; width: 358px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-7 a { width: 339px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-8 { margin-left: 48px; width: 352px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-8 a { width: 333px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-9 { margin-left: 54px; width: 346px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-9 a { width: 327px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-10 { margin-left: 60px; width: 340px; }
#transverse .elgg-menu-navigation li.groups ul li.subgroup-10 a { width: 321px; }

#transverse .elgg-menu-navigation li.thematiques ul { width: 372px; }
#transverse .elgg-menu-navigation li.thematiques ul li { width: 370px; }
#transverse .elgg-menu-navigation li.thematiques ul li a { width: 351px; }

#transverse .elgg-menu-navigation li ul li img {
  float:left; 
  margin-right:6px;
}
#transverse .elgg-menu-navigation li ul li a:hover, 
#transverse .elgg-menu-navigation li ul li a:focus, 
#transverse .elgg-menu-navigation li ul li a:active {
	background: #333;
	color: #fff;
}



/* Pour tous les éléments du menu : .elgg-menu-owner-block .elgg-menu-item-NOM_SUBTYPE */
#wrapper_header {}

/* Styles des modules page d'accueil et profil */
.elgg-page-header { border-top: 0 none; height: auto; }
.elgg-page-body div.intro { font-family:<?php echo $font4; ?>; font-size: 1.25em; }

/*
#transverse { clear:left; }
*/
.elgg-menu-navigation {  }
.elgg-menu-navigation > li { float: left; }
.elgg-menu-navigation li ul { z-index: 100; }
.elgg-menu-navigation li.group-invites, .elgg-menu-navigation li.group-invites,
.elgg-menu-navigation li.invites, .elgg-menu-navigation li.invites { margin:-6px 0 0 4px; }
.elgg-menu-navigation li.group-invites,
.elgg-menu-navigation li.invites { margin:-8px 0 0 -22px; border:0; }
.elgg-menu-navigation li.group-invites a, #transverse ul li.group-invites a:hover, #transverse ul li.group-invites a:focus, #transverse ul li.group-invites a:active,
.elgg-menu-navigation li.group-invites a, .elgg-menu-navigation li.group-invites a:hover, .elgg-menu-navigation li.group-invites a:focus, .elgg-menu-navigation li.group-invites a:active,
.elgg-menu-navigation li.invites a, #transverse ul li.invites a:hover, #transverse ul li.invites a:focus, #transverse ul li.invites a:active,
.elgg-menu-navigation li.invites a, .elgg-menu-navigation li.invites a:hover, .elgg-menu-navigation li.invites a:focus, .elgg-menu-navigation li.invites a:active {
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
.home-static-container {}


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
	/* width: 211px; */
	width:100%;
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
	/*
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

/* Pied de page - HTML spécifique */
.elgg-page-footer {
	background-image: linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -o-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -moz-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -webkit-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -ms-linear-gradient(bottom, #333333 30%, #666666 80%);
	background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0.30, #333333), color-stop(0.80, #666666));
	background-color: #333333;
	/*
	height: 66px;
	margin-top: 25px;
	*/
}
.elgg-page-footer li { float: left; margin-right: 1em; }
/*
.elgg-page-footer ul li:first-child { background: none; }
*/
.elgg-page-footer ul li a { color: #fff; font-size:12px; }
.elgg-page-footer ul li a:hover, .elgg-page-footer ul li a:focus, .elgg-page-footer ul li a:active { color: #ddd; }
.elgg-page-footer img { float: right; }
.elgg-page-default .elgg-page-footer > .elgg-inner { border:0; }

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
	position:absolute; left:0; right:0;
}
.elgg-page-footer .credits { clear:both; font-size: 0.85em; margin-top: 2em; }
.elgg-page-footer .credits p { float: left; margin: 4px 0 5px; color: #DEDEDE; }
.elgg-page-footer .credits a { color: #DEDEDE; text-decoration:underline; }



/* BLOC DU CONTENU PRINCIPAL - MAIN CONTENT */
#page_container {
	width:990px; margin:0px auto; background:#fff; min-height: 100%;
	-moz-box-shadow: 0 0 10px #888; -webkit-box-shadow: 0 0 10px #888; box-shadow: 0 0 10px #181a2f;
}



/* MENUS & NAVIGATION */
.elgg-menu-item-report-this { margin-left:10px; margin-top:5px; }
/* Eviter les recouvrements par le menu des entités */
.elgg-menu-entity { height:auto; text-align: center; }
.elgg-menu-navigation li, #transverse ul li { list-style-type: none; }
ul.elgg-list li.elgg-item ul.elgg-menu { font-size: 0.75em; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-one { width: 40px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-date { width: 60px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members { width: 90px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members a { color: <?php echo $linkcolor; ?>; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-membership { width: 50px; }

.elgg-menu-item-membership {}
.elgg-menu-item-members {}


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

.elgg-pagination a, .elgg-pagination span { display: inline-block; margin-bottom: 1px; }
.elgg-pagination-limit { margin-top:0; }
.elgg-pagination.elgg-pagination-limit li { margin-right:0; }
.elgg-pagination.elgg-pagination-limit a { border-color:transparent; font-size:0.85em; padding:2px 4px 2px 0; }
.elgg-pagination.elgg-pagination-limit a:hover, .elgg-pagination.elgg-pagination-limit a:focus, .elgg-pagination.elgg-pagination-limit a:active { background-color:transparent; border-color:transparent; }
.elgg-pagination-limit .elgg-state-selected span { font-weight:bold; border-color:transparent; }



/* BLOCS SPECIFIQUES : CONNEXION, etc. - MAIN BLOCKS : LOGIN, etc. */
#login-dropdown { position: absolute; top:110px; right:0; z-index: 100; margin-right:10px; }
/* Page de connexion et d'inscription */
.esope-strongseparator { border: 1px solid <?php echo $color4; ?>; clear:both; margin:12px auto; }
.esope-lightseparator { border: 1px solid white; clear:both; margin:16px auto; }

#esope-public-col1 { float:left; width:50%; }
#esope-public-col2 { float:right; width:44%; }

#esope-homepage { margin-top:30px; }
#esope-homepage p { font-size:14px; margin-top:0; margin-bottom:8px; }
#esope-homepage .elgg-form-register { font-size:13px; margin-top:0; margin-bottom:8px; }
#esope-homepage a, #esope-homepage a:visited { color:<?php echo $linkcolor; ?>; }
#esope-homepage a:hover, #esope-homepage a:active, #esope-homepage a:focus { color:red; }
#esope-homepage .elgg-form { background:transparent; }
#esope-homepage h2 { font-size:20px; font-weight:normal; }

#esope-homepage label { width:130px; float:left; margin:0 30px 16px 0; clear:both; text-align:right; }
#esope-homepage input[type='text'],
#esope-homepage input[type='password'],
#esope-homepage select { width:auto; min-width:200px; float:left; margin-bottom:16px; }

#esope-homepage form.elgg-form { width:100%; padding:0; }

#esope-loginbox { border:1px solid #CCCCCC; padding:10px 20px; margin-top:30px; background:#F6F6F6; }
#esope-loginbox form { margin:0; padding:0; }

#esope-homepage #esope-persistent { width:280px; float:right; margin:0; position:relative; top:-16px; }
#esope-homepage #esope-persistent label { width:auto; float:left; margin:0; margin-left:-5px; }

#esope-homepage input[type='submit'],
.esope-lostpassword-link { margin-left:160px; }
#esope-homepage .elgg-form-register input[type='submit'] { margin-left:150px; }

#esope-homepage .esope-lostpassword-link { position:relative; top:-16px; margin-left:168px; }

#esope-homepage ul { list-style-type: square; }
#esope-homepage ul li { margin-bottom:8px; }
#esope-homepage .elgg-form-register fieldset > div, #esope-homepage .elgg-form-register .mandatory { clear: both; }
#esope-homepage .profile_manager_register_category { margin: 15px 0 15px 0 !important; }
#esope-homepage .captcha-left { display:inline-block; }

select#custom_profile_fields_custom_profile_type { margin-bottom: 0.5ex; }
#esope-homepage .register-fullwidth { clear:both; }
#esope-homepage .register-fullwidth label { width:auto; }
#profile_manager_register_left { width:100%; }
.profile_manager_register_input_container { display:inline-block; }
#profile_manager_profile_edit_tabs { clear: both; }
.custom_profile_type_description { float: left; margin-left: 1ex; }
#widget_profile_completeness_progress_bar { background: #090; }

/* FORMULAIRES - FORMS */
/* Aide event_calendar form */
.elgg-form-event-calendar-edit .description { font-style:italic; font-size:0.90em; }
.event-calendar-edit-form-block { width: auto; }
/*
.event-calendar-edit-form { background: transparent; }
.event-calendar-edit-form-block { background-color: transparent; border: 0; }
*/

.elgg-form-groups-find input[type='text'] { width:250px; }
.elgg-form-groups-find input.elgg-button-submit { vertical-align:20%; margin:0; }
/* New integrated in-group search */
.elgg-sidebar .elgg-form.elgg-form-groups-search { border: 0; background: white; padding: 0; margin-bottom: 20px; width:100%; }
.elgg-form.elgg-form-groups-search #q { height:24px; width:84%; border:0; margin:0; }
.groups-search-submit-button { height:24px; width:auto; border:1px solid grey; vertical-align: top; float:right; border:0; background-color:#ccc; padding:5px 7px 5px 8px; }
.groups-search-submit-button:hover, .groups-search-submit-button:active, .groups-search-submit-button:focus { background-color:#999; }

/* ESOPE : new top menu */
.elgg-sidebar #site-categories h2,
.elgg-sidebar #feedbacks h2 {
	background: none repeat scroll 0 0 #333333;
	border-radius: 3px 3px 0 0;
	clear: both;
	color: #FFFFFF;
	font-size: 1.3em;
	font-weight: normal;
	margin: 0;
	padding: 6px 10px 4px;
	text-transform: uppercase;
}

.elgg-sidebar #site-categories ul li a { padding: 6px 10px 5px; }



/* WIDGETS */
.elgg-module-widget { background-color: transparent; }
.elgg-module-widget:hover,
.elgg-module-widget:focus,
.elgg-module-widget:active { background-color: transparent; }
.elgg-module-widget > .elgg-head { height:auto; }
.elgg-module-widget h3 { padding:0.5em; }

/* Widgets - à corriger pour utiliser les classes natives d'Elgg */
.elgg-page-body div.elgg-module {
	background: none; margin: 0 1em 2em 1em; padding: 0; width: auto; min-width: 200px;
	float: left;
	margin: 0 0 20px 0;
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


/* Contenu des modules */
.elgg-page-body div.elgg-module .elgg-head ul { float: right; margin: 0px 0.5em 0.5em 0.5em; }
.elgg-page-body div.elgg-module ul li { padding-left: 0; float: none; right: initial; left: inherit; margin-left: 0em; }

/* Boutons des widgets */
.elgg-page-body div.elgg-module .elgg-head ul li a { float: none; margin:0; right: initial; }
.elgg-menu-widget button { outline: none; border: 0; background: transparent; margin-left: 0.5ex; color: <?php echo $color14; ?>; }


.elgg-page-body div.module div.activites { background-color: #fff; float: left; padding-top: 5px; width: 300px; }
.elgg-page-body div.module div.activites h3 { margin: 5px 7px; font-size: 1.1em; color: #333333; float: left; font-size: 1em; }
.elgg-page-body div.module div.activites ul li { padding-bottom: 1px; }
.elgg-page-body div.module div.activites ul li img { margin: 0 5px 0 7px; }
.elgg-page-body div.module div.activites ul li div span { color: #666; font-style: italic; }

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




/* Thème ADF - Urbilog => Styles à classer et réorganiser */

/* Afficher/masquer les commentaires inline */
a.ouvrir { float: right; padding: 0 4px 0 0; clear:both; }
/* Infos dépliables */
.elgg-page-body div.module div.plus { clear:both; padding-top:2px; }
.elgg-item .plus { clear:both; }

.elgg-page-body article.fichier div.activites ul li a { float: left; font-size: 0.9em; font-weight: bold; width: 245px; }
.elgg-page-body article.fichier div.activites ul li span { color: #666; float: left; font-size: 0.75em; font-style: italic; margin-top: 2px; width: 245px; margin-bottom: 5px; }
.elgg-page-body article.fichier div.activites ul li span a { float: none; font-size: 1em; font-weight: normal; }



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
.elgg-form-usersettings-save .elgg-body input[type=text], .elgg-form-usersettings-save .elgg-body textarea { background: #f6f6f6; }




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


/* Editeur tinymce */
.elgg-longtext-control { font-size: 11px; padding: 1px 5px; margin-left: 3px; border:1px solid transparent; border-radius: 3px; }
.elgg-longtext-control:hover, .elgg-longtext-control:active, .elgg-longtext-control:focus { text-decoration: none; background-color: #e5e7f5; border-color: <?php echo $linkcolor; ?>; }
.mceEditor iframe { min-height: 250px; }
.elgg-form-comments-add .mceEditor iframe { min-height: 100px; }
/* Limit editor max-width to container */
textarea, iframe, .defaultSkin tbody, .defaultSkin * { max-width: 100% !important; }

/* Champs longtext avec éditeur désactivé par défaut */
textarea, .elgg-input-rawtext { width:100%; }
/* Sélecteur de visibilité des champs du profil */
.elgg-input-field-access { margin-bottom: 1ex; margin-left: 0.5ex; display: inline-block; }
form .elgg-input-field-access label { font-size:80%; font-weight:normal; }


/* Pour intégration d'une vue complétion du profil sous l'ownerblock du profil */
#profile_completeness_container { background: none repeat scroll 0 0 #EEEEEE; border-top: 1px solid white; width: 200px; padding: 15px; float: left; clear: left; }
#profile_completeness_progress { width: 200px; line-height: 18px; position: absolute; border: 1px solid black; text-align: center; font-weight: bold; }

/* Menu édition des sous-groupes (saute à droite sous Firefox) */
.elgg-form.elgg-form-alt.elgg-form-groups-edit { width:96%; }
/* Deprecated by au_subgroups/group/transfer view replacement (remove div)
.elgg-form.elgg-form-alt.elgg-form-groups-edit + div { clear: both; margin: 40px 0 0; padding: 0; }
*/
.au-subgroups-result-col { width: auto; }
.au-subgroups-search-results { float:none; width: auto; }


/* Agencement fluide des blocs dans les groupes */
.groups-profile-icon .au_subgroups_group_icon-large { height: auto; }
.elgg-gallery-fluid > li { float: right; }
#groups-tools > li.odd { float: left; }
#groups-tools > li { margin-bottom: 20px; min-height: 100px; width: 50%; min-width: 300px; display:inline-block; }

#groups-tools > li:nth-child(2n+1) { margin-right: 0; margin-left: 0; }
#groups-tools > li:nth-child(2n) { margin-right: 0; margin-left: 0; }

.groups-members-count { float: right; }

/* Anciens groupes */
.group-oldactivity { border:1px dotted black; background:yellow; padding:1ex 3ex; margin: 1ex 0; text-align:center; }
.group-oldactivity { display:block; left:0; position: absolute; top:0; width: 100%; text-align:center; border:0; color:black; }
.group-oldactivity-tiny { background: rgba(255,255,0,0.6); font-size: 6px; padding: 2px 0px; }
.group-oldactivity-small { background: rgba(255,255,0,0.8); font-size: 8px; padding: 3px 1px; }
.group-oldactivity-medium { background: rgba(255,255,0,0.8); font-size: 10px; padding: 3px 1px; }

/* Various tools icons : activity, event-calendar, announcements, blog, file, discussion, brainstorm, bookmarks, pages */
<?php // Keep this block just in case some clients prefer old way but we should use new icons by default (vector)
<<< EOT
/* Group activity */
.elgg-menu-item-activity a { padding-left:32px; background: url("<?php echo $urlicon; ?>activity.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-activity a:hover, .elgg-menu-item-activity a:focus, .elgg-menu-item-activity a:active { background: url("<?php echo $urlicon; ?>activity.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Event calendar */
.elgg-menu-item-event-calendar a { padding-left:32px; background: url("<?php echo $urlicon; ?>event_calendar.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-event-calendar a:hover, .elgg-menu-item-event-calendar a:focus, .elgg-menu-item-event-calendar a:active { background: url("<?php echo $urlicon; ?>event_calendar.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Announcements */
.elgg-menu-item-announcements a { padding-left:32px; background: url("<?php echo $urlicon; ?>announcements.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-announcements a:hover, .elgg-menu-item-announcements a:focus, .elgg-menu-item-announcements a:active { background: url("<?php echo $urlicon; ?>announcements.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?>; color: #fff; }
/* Blog */
.elgg-menu-item-blog a { padding-left:32px; background: url("<?php echo $urlicon; ?>blog.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-blog a:hover, .elgg-menu-item-blog a:focus, .elgg-menu-item-blog a:active { background: url("<?php echo $urlicon; ?>blog.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Feedback */
.elgg-menu-item-feedback a { padding-left:32px; background: url("<?php echo $urlicon; ?>feedback.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-feedback a:hover, .elgg-menu-item-feedback a:focus, .elgg-menu-item-feedback a:active { background: url("<?php echo $urlicon; ?>feedback.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?>; color: #fff; }
/* File */
.elgg-menu-item-file a { padding-left:32px; background: url("<?php echo $urlicon; ?>file.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-file a:hover, .elgg-menu-item-file a:focus, .elgg-menu-item-file a:active { background: url("<?php echo $urlicon; ?>file.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Folder */
.elgg-menu-item-folder a { padding-left:32px; background: url("<?php echo $urlicon; ?>folder.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-folder a:hover, .elgg-menu-item-folder a:focus, .elgg-menu-item-folder a:active { background: url("<?php echo $urlicon; ?>folder.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Forum - discussion */
.elgg-menu-owner-block .elgg-menu-item-discussion a { background: url("<?php echo $urlicon; ?>discussion.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-owner-block .elgg-menu-item-discussion a:hover, .elgg-menu-owner-block .elgg-menu-item-discussion a:focus, .elgg-menu-owner-block .elgg-menu-item-discussion a:active { background: url("<?php echo $urlicon; ?>discussion.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Brainstorm */
.elgg-menu-item-brainstorm a { padding-left:32px; background: url("<?php echo $urlicon; ?>brainstorm.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-brainstorm a:hover, .elgg-menu-item-brainstorm a:focus, .elgg-menu-item-brainstorm a:active { background: url("<?php echo $urlicon; ?>brainstorm.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Bookmarks */
.elgg-menu-item-bookmarks a { padding-left:32px; background: url("<?php echo $urlicon; ?>bookmarks.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-bookmarks a:hover, .elgg-menu-item-bookmarks a:focus, .elgg-menu-item-bookmarks a:active { background: url("<?php echo $urlicon; ?>bookmarks.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }
/* Pages */
.elgg-menu-item-pages a { padding-left:32px; background: url("<?php echo $urlicon; ?>pages.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-pages a:hover, .elgg-menu-item-pages a:focus, .elgg-menu-item-pages a:active { background: url("<?php echo $urlicon; ?>pages.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }

/* More group tools and info icons */
/* Group membership */
.elgg-menu-item-membership-status a { padding-left: 32px !important; background: url("<?php echo $urlicon; ?>members.png") no-repeat scroll 9px 5px #FFFFFF !important; }
.elgg-menu-item-membership-status a:hover, .elgg-menu-item-membership-status a:focus, .elgg-menu-item-membership-status a:active {
background: url("<?php echo $urlicon; ?>members.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important;
}
/* Group notifications */
.elgg-menu-item-subscription-status a { padding-left: 32px !important; background: url("<?php echo $urlicon; ?>notification.png") no-repeat scroll 9px 5px #FFFFFF !important; }
.elgg-menu-item-subscription-status a:hover { background: url("<?php echo $urlicon; ?>notification.png") no-repeat scroll 9px -19px <?php echo $linkcolor; ?> !important; }

/* Group listing menu */
.elgg-menu-item-members { background: url("<?php echo $urlicon; ?>members.png") no-repeat scroll -2px -26px transparent; }
EOT;
?>

/* Note : this replaces the above with FA icons - update translations accordingly if needed
 */
.elgg-menu-owner-block li a { padding-left: 1ex; }
.elgg-sidebar li .fa { display: inline-block; min-width: 2.5ex; }




/* Generic useful classes */
.no-spaces { border: 0 none !important; margin: 0 !important; padding: 0 !important; }

/* Accordion styles */
.ui-icon.ui-icon-triangle-1-s, .ui-icon.ui-icon-triangle-1-e { float: left; margin-right: 6px; }
#custom_fields_userdetails .ui-accordion-header { padding: 0.3em 0 0.3em 1.8em; }
#custom_fields_userdetails .ui-accordion-header .ui-icon { margin-top:0.5em; top:0; }

/* Semantic UI adjustments */
i.icon, i.icon:hover, i.icon:focus, i.icon:active { text-decoration:none; }

/* Effets de survol */
.elgg-item { opacity: 0.75; }
.elgg-item .elgg-item { opacity: 1; } /* Don't double the effect */
.elgg-item:hover, .elgg-item:active, .elgg-item:focus { opacity: 1; }
.elgg-list-river > li:hover { background-color: #F9F9F9; }

/* Autocomplete content : le menu n'est pas utile */
.elgg-autocomplete-item .elgg-menu { max-width: 40%; display:none; }

/* Members alpha sort and search */
.esope-alpha-char a { font-family: <?php echo $font3; ?>; text-decoration: none; margin: 0 0.2em; }



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
.esope-search-metadata-select select { max-width: 100%; }
.elgg-button-livesearch { float: right; }
.esope-results-count { font-size: 0.8em; color: #808080; }

/* Main search - advanced */
#advanced-search-form { border: 1px dotted #CCC; padding: 6px; margin: 6px 0; background: #FAFAFA; }
#advanced-search-form legend { font-weight: bold; margin-bottom:6px; }
#advanced-search-form input { width:50ex; max-width: 70%; }
#advanced-search-form input.elgg-button-submit { max-width: 20ex; }
#advanced-search-form input.elgg-input-date { max-width: 12ex; }


/* Trees and Folders */
/* Arborescence : taille de plus en plus petite */
.treeview { font-size:16px; }
.treeview li { font-size:0.95em; }
.treeview li.elgg-state-selected a.selected {
	color:white;
	background-color:<?php echo $linkcolor; ?>;
	font-weight: bold;
	padding: 2px 7px;
}


#file_tools_list_tree_container { max-width: 100%; padding:0; }
#file_tools_list_tree_container li { max-width: 95%; }
#file_tools_list_tree_container .tree li a, #file_tools_list_tree_container .tree li span { height:auto; white-space: normal; -webkit-hyphens: auto; -moz-hyphens: auto; -ms-hyphens: auto; -o-hyphens: auto; hyphens: auto; }


/* Group topmenu */
.elgg-menu-group-topmenu { background-color: <?php echo $titlecolor; ?>; padding: 0 1ex; border-radius: 10px 10px 0 0; }
.elgg-menu-group-topmenu li a { color: white; opacity:0.8; padding: 1ex; }
.elgg-menu-group-topmenu li a:hover, .elgg-menu-group-topmenu li a:active, .elgg-menu-group-topmenu li a:focus, .elgg-menu-group-topmenu li.elgg-state-selected a { text-decoration:none; opacity:1; }

/* Color picker */
.elgg-color-picker { max-width:45%; }

/* Newsletter */
.elgg-menu-newsletter-steps { counter-reset:li; }
.elgg-menu-newsletter-steps li::before { content:counter(li); counter-increment:li; display:inline-block; position:absolute; font-weight: bold; padding: 5px 5px 6px 5px; background:white; border-radius:10px; padding: 2px 6px; text-indent: 0px; margin: 4px 6px; left:0ex; }
.elgg-sidebar .elgg-module-aside .elgg-body ul.elgg-menu-newsletter-steps li { clear:left; width:100%; text-indent:4ex; }


/* Group tools homepage publication */
#group-tool-tabs { margin-bottom:2ex; }
#group-tool-tabs .group-tool-tab { display:inline-block; text-align: center; padding: 0.5ex 3ex; color:<?php echo $linkcolor; ?>; }
#group-tool-tabs .group-tool-tab .fa { font-size: 3em; }
#group-tool-tabs .group-tool-tab.elgg-state-selected, #group-tool-tabs .group-tool-tab:hover { background-color:<?php echo $linkcolor; ?>; color:white; }

#autorefresh-menu { margin: 0.5ex 0; padding: 1ex 3ex; border: 1px dotted; background: #efefef; }
#loader { position: fixed; top: 0; bottom: 0; left: 0; right: 0; z-index: 10000;
	background: rgba(0,0,0,0.2); color: #FFF; text-shadow: 0px 1px 2px #000;
	text-align: center; font-size: 10ex; padding-top:5ex;
}

/* Responsive menu */
.menu-topbar-toggle, .menu-navigation-toggle, .menu-sidebar-toggle { display:none; font-weight:bold; padding: 0 0 0.5ex 0; width:100%; font-size:24px; }
.menu-sidebar-toggle { text-align: left; }

<?php if (!$fixedwidth) { ?>
/* .elgg-page-body RESPONSIVE DESIGN */

/* Pour la fluidité en général */
.elgg-page-default { min-width:200px; max-width:100%; }
.elgg-layout-one-sidebar .elgg-main { width: 70%; min-width: 0; padding:1.5%; }
.elgg-sidebar { width: 24%; min-width: 211px; margin:0 0 0 1%; }
.elgg-sidebar ul.elgg-menu-page, elgg-sidebar ul.elgg-menu-groups-my-status { width:100%; }
.elgg-sidebar-alt { width: 24%; min-width: 211px; margin:0 1% 0 0; padding:0; }
.elgg-layout-two-sidebar .elgg-main { width: 48%; padding:13px 1%; }
.elgg-layout-two-sidebar .elgg-sidebar {  }
.elgg-layout-two-sidebar .elgg-sidebar_alt {  }
/* Menus */
.elgg-menu-navigation { width:auto; }
/* Largeur de page standard */
.interne { min-width:200px; width:auto; max-width:80%; }
/* Quand on utilise les widgets */
.elgg-widgets { min-width:200px; }
.elgg-page-body div.module { width: 94%; padding: 3%; background-size:100%; }
.elgg-page-body div.module { min-width:180px; }
.elgg-page-body div.module div.activites { width:auto; }
.elgg-page-body div.module footer { background-size: 100%; }
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



@media (max-width:700px) {
	
	/* Top menu */
	.menu-topbar-toggle { display:inline-block; }
	.elgg-menu-topbar { display:none; }
	.elgg-menu-topbar * { min-width:0; }
	.elgg-menu-topbar.menu-enabled { display:block; }
	
	.elgg-page-header { min-height:3ex; height:auto !important; background-color: <?php echo $color3; ?>; }
	.elgg-page-header .interne { margin:0; }
	.elgg-page-header h1 { float:right; margin-top:0; }
	.elgg-page-header .elgg-menu-topbar { float:none; width:100%; position:initial; padding-left:30px; font-size:initial; }
	.elgg-page-header .profile-link { display:inline-block; }
	.elgg-page-header .adf-profil { position:initial; }
	.elgg-page-header .elgg-menu-topbar li, .elgg-page-header .elgg-menu-topbar li li { width:100%; margin-left:0; font-size:100%; line-height: 2; border-right:0; border-top: 1px solid #FFF; border-top: 1px solid #ccc; }
	.elgg-page-header .elgg-menu-topbar li a, .elgg-page-header  .elgg-menu-topbar li li a,
	.elgg-page-header .elgg-menu-topbar li a, .elgg-page-header .elgg-menu-topbar li li a { width:100%; display:inline-block; padding-left:0; padding-right:0; font-size:initial;  }
	.elgg-page-header .elgg-menu-topbar li.invites { max-width: 5ex; position: absolute; right: 1ex; border: 0 !important; margin: 0 0 !important; text-align: center; display: inline; text-indent: 0; z-index:2; font-size:initial; }
	.elgg-page-header .elgg-menu-topbar li.invites a { padding: 0; margin: 2px 0; }
	
	
	/* Navigation menu */
	/* Toggle menu */
	.menu-navigation-toggle { display:inline-block; }
	#transverse .elgg-menu-navigation { display:none; float: none; }
	#transverse .elgg-menu-navigation * { min-width:0; }
	#transverse .elgg-menu-navigation.menu-enabled { display:inline-block; }
	
	#transverse { width: 100%; }
	#transverse form { width: 90%; float: none; margin: 0 auto; clear: both; margin-top: 0.5em; }
	#transverse .interne { max-width:100%; margin:0; }
	#transverse .interne .elgg-menu-navigation { float:none; width:100%; display:inline-block; }
	#transverse .elgg-menu-navigation { width: auto; padding-left:30px; font-size:initial; }
	#transverse .elgg-menu-navigation li { width:100%; display:inline-block; border-left:0; border-right:0; border-top: 1px solid #FFF; border-bottom: 1px solid #ccc; font-size:100%; }
	#transverse .elgg-menu-navigation li a { width:100%; padding-left:0; padding-right:0; background: transparent; }
	#transverse .elgg-menu-navigation li li { width:100%; display:inline-block; border-left:0; border-right:0; border-top: 1px solid #FFF; border-bottom: 1px solid #ccc; font-size:90%; text-indent: 3ex; }
	#transverse .elgg-menu-navigation li li a { width:100%; padding-left:0; padding-right:0;  }
	#transverse .elgg-menu-navigation li ul { width: 100% !important; position:initial; top:0; left:0; }
	
	
	/* Sidebar */
	.menu-sidebar-toggle { display:inline-block; }
	.elgg-sidebar { display:none; }
	.elgg-sidebar * { min-width:0; }
	.elgg-sidebar.menu-enabled { display:block; }
	
	.elgg-page .elgg-layout .elgg-sidebar { background: none; box-shadow: none; }
	
	
	/* Generic rules */
	body { font-size:120%; }
	.floating { position: initial !important; }
	.elgg-page .elgg-breadcrumbs { font-size: small; margin-bottom: 1ex; display: inline-block; top:0; left:0; }
	.elgg-button { font-size: large; }
	
	/* Common tools */
	#feedBackToggler { bottom: 0; transform: rotate(90deg); transform-origin: bottom right; }
	.elgg-page #groupchat-sitelink { position:initial; display: inline-block; border: 0; border-radius: 0; margin: 0; padding: 1ex; border: 0; width:100%; }
	.twitter-timeline { width: 100% !important; }
	
	/* Recherche */
	form#main-search { float: none; display: inline-block; margin: 1ex 0; width:100%; background:white; border-radius: 0; box-shadow: none; }
	form#main-search #adf-search-input { width: 94%; border-radius: 0; }
	#main-search #adf-search-submit-button { border-radius: 0; }
	#main-search button#adf-search-submit-button { width: 6%; border-radius: 0; }
	
	/* Layout */
	header, #transverse, section, footer, #bande { float: none; clear: both; margin:0; padding: 1ex 0; display: inline-block; }
	.elgg-page .elgg-layout .elgg-main { width:100%; margin: 1ex 0 2ex 0 !important; padding: 0 !important; }
	.elgg-page .elgg-layout .elgg-sidebar { width: 100%; background:rgba(0,0,0,0.3); box-shadow: 0px 3px 3px -2px #666; margin: 1ex 0 2ex 0 !important; padding: 0 !important; }
	
	.elgg-col-1of3, .elgg-col-2of3, .elgg-col-3of3 { min-width: 100%; }
	.elgg-page .elgg-widgets { min-width: 100%; min-height: 0 !important; }
	
	/* Groups */
	.groups-profile-fields { width: 100%; }
	ul#groups-tools > li { width: 100% !important; max-width: 100% !important; float: none; }
	
	/* Home */
	.home-static-container { min-width: 100%; margin: 2ex 0 3ex 0 !important; padding: 0 !important; }
	.home-static { min-width: 100%; box-shadow: 0px 3px 3px -2px #666; margin: 1ex 0 2ex 0 !important; padding: 0 !important; }
	.timeline-event, .home-timeline .timeline-event { width: 100%; }
	
	/* Public Home */
	#adf-homepage #adf-public-col1, #adf-homepage #adf-public-col2 { float: none; width: 100%; }
	#adf-public-col2 { padding-top: 3ex; clear: both; }
	#adf-homepage input[type='text'], #adf-homepage input[type='password'], #adf-homepage select { min-width: 0; }
	
	/* Footer */
	#site-footer { margin-bottom: 1ex; padding-bottom: 1ex; }
	#site-footer ul li { clear: both; width: 100%; margin: 0 !important; background: none; font-size: initial; padding-left:0; }
	#site-footer ul li a { padding: 1ex 1ex; display: inline-block; font-size: 120%; }
	div.credits p { float:none !important; }
	
	
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
<?php } 
