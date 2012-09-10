<?php
/**
 * EasyTheme
 *
 * Contains CSS for EasyTheme
 *
 *  *
 * @package Elgg.Core
 * @subpackage UI
 */

$url = $vars['url'];
$urlfonts = $vars['url'] . 'mod/adf_public_platform/fonts/';
$urlicon = $vars['url'] . 'mod/adf_public_platform/img/theme/';

// Configurable elements and default values

// Image de fond configurable
$headbackground = elgg_get_plugin_setting('headbackground', 'adf_public_platform');
if (empty($headbackground)) { $headbackground = $vars['url'] . 'mod/adf_public_platform/img/headimg.jpg'; }

// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'adf_public_platform');
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
// Couleur 1
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
// Couleur 2
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');

// CSS
$css = elgg_get_plugin_setting('css', 'adf_public_platform');
?>


/***** Main centre panel */	
#page_container {
  width:990px; margin:0px auto; 
  /***** Should it have a border, a coloured background, or an image? */  
  background:#fff;
  /***** This is where you make the centre panel 100% high ~ might need extra code to work in IE */
  min-height: 100%;
  /***** This is the shadow on the centre panel */       
  -moz-box-shadow: 0 0 10px #888;
  -webkit-box-shadow: 0 0 10px#888;
  box-shadow: 0 0 10px #181a2f;
}
    

/* Pour tous les éléments du menu : .elgg-menu-owner-block .elgg-menu-item-NOM_SUBTYPE*/


/**** just a few further tweaks */

/**** changed positioning */
#login-dropdown { position: absolute; top:110px; right:0; z-index: 100; margin-right:10px; }
#wrapper_header {}
.elgg-menu-item-report-this { margin-left:10px; margin-top:5px; }
.mts { margin-right:10px; }

/*********    Change tab hover here ~ 'Members'   ********/
.elgg-river-comments-tab{ color:#cd9928; }



/* Changes for ADF_platform */
.elgg-input-rawtext { width:99%; }

/* Tableaux */
th { font-weight:bold; background:#CCC; }


/* Widgets */
.elgg-module-widget:hover, 
.elgg-module-widget:focus, 
.elgg-module-widget:active { background-color: transparent; }

/* Aide event_calendar form */
.elgg-form-event-calendar-edit .description { font-style:italic; font-size:0.90em; }

/* Eviter les recouvrements par le menu des entités */
.elgg-menu-entity {
	height:auto;
	text-align: center;
}


/* Access level informations */
.elgg-access {}
.elgg-access-group-closed {}
.elgg-access-group-open {}




/* Thème ADF - Urbilog */
header, #transverse, section, footer, #bande {
	width: 100%;
	float: left;
}

.interne {
	width: 980px;
	position: relative;
	margin: auto;
}
.invisible {
	position: absolute !important;
	left: -5000px !important;
}
.right {
	float: right !important;
}
.minuscule {
	text-transform: lowercase;
}

nav ul li, #transverse ul li { list-style-type: none; }
img { border: 0 none; }



.elgg-form-groups-find input[type='text'] { width:250px; }
.elgg-form-groups-find input.elgg-button-submit { vertical-align:20%; margin:0; }


/* Styles des modules page d'accueil et profil */
section {
	padding-top: 25px;
}
section header {
	background: none;
	border-top: 0 none;
	height: auto;
}
section div.intro {
	font-family: gill-sans;
	font-size: 1.25em;
}

#transverse nav ul li.group-invites, 
.interne nav ul li.invites {
  margin:-6px 0 0 4px;
}
#transverse nav ul li.group-invites {
  margin:-8px 0 0 -22px;
  border:0;
}
#transverse nav ul li.group-invites a,
#transverse ul li.group-invites a:hover,
#transverse ul li.group-invites a:focus,
#transverse ul li.group-invites a:active,
.interne nav ul li.invites a,
.interne nav ul li.invites a:hover,
.interne nav ul li.invites a:focus,
.interne nav ul li.invites a:active {
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
	box-shadow: 1px 1px 2px #333;
	-moz-box-shadow: 1px 1px 2px #333;
	-webkit-box-shadow: 1px 1px 2px #333;
	-o-box-shadow: 1px 1px 2px #333;
}

section #profil img {
	float: right;
	margin-left: 10px;
	/* width: 55px; */ /* Si on peut éviter... */
}


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
	background-image: linear-gradient(top, #F75C5C 45%, <?php echo $color3; ?> 55%);
	background-image: -o-linear-gradient(top, #F75C5C 45%, <?php echo $color3; ?> 55%);
	background-image: -moz-linear-gradient(top, #F75C5C 45%, <?php echo $color3; ?> 55%);
	background-image: -webkit-linear-gradient(top, #F75C5C 45%, <?php echo $color3; ?> 55%);
	background-image: -ms-linear-gradient(top, #F75C5C 45%, <?php echo $color3; ?> 55%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.45, #F75C5C), color-stop(0.55, <?php echo $color3; ?>));
	background-color: <?php echo $color3; ?>;
	border-radius: 10px 10px 0 0;
	-moz-border-radius: 10px 10px 0 0;
	-webkit-border-radius: 10px 10px 0 0;
	-o-border-radius: 10px 10px 0 0;
	border-top: 0 none;
	min-height: 35px;
}
section div.module header h2 {
	color: #fff;
	float: left;
	font-family: gill-sans;
	font-size: 1.25em;
	margin: 7px 0px 0 15px;
	max-width:204px;
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

section div.module header ul {
	float: right;
	margin: 8px 10px 0 0;
}
section div.module header ul li a {
	float: left;
	margin-left: 6px;
	margin:0;
}


/* Contenu des modules */
section div.module div.activites {
	background-color: #fff;
	float: left;
	padding-top: 5px;
	width: 300px;
}
section div.module div.activites h3 {
	margin: 5px 7px;
	font-size: 1.1em;
	color: #333;
	float: left;
	font-size: 1em;
}
section div.module div.activites ul {
}
section article.contact div.activites ul {
}
section div.module div.activites ul li {
}
section .contact div.activites ul li {
}
section div.module div.activites ul li img {
	margin: 0 5px 0 7px;
}
section div.module div.activites ul li div {
/* casse le widget contact si utilisé
	width: 195px;
*/
}
section div.module div.activites p {
/*
	font-size: 0.85em;
*/
}
section div.module div.activites ul li div span {
	color: #666;
	font-style: italic;
}

/* Afficher/masquer les commentaires inline */
a.ouvrir {
	float: right;
	padding: 0 4px 0 0;
  clear:both;
}
/* Infos dépliables */
section div.module div.plus {
  clear:both;
  padding-top:2px;
}

section article.fichier div.activites ul li a {
	float: left;
	font-size: 0.9em;
	font-weight: bold;
	width: 245px;
}
section article.fichier div.activites ul li span {
	color: #666;
	float: left;
	font-size: 0.75em;
	font-style: italic;
	margin-top: 2px;
	width: 245px;
	margin-bottom: 5px;
}
section article.fichier div.activites ul li span a {
	float: none;
	font-size: 1em;
	font-weight: normal;
}




/* PIED DE PAGE - HTML spécifique */
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
footer ul {
	margin: auto;
	width: 500px;
	font-size: 0.75em;
}
footer ul li {
	float: left;
	background: transparent url("<?php echo $urlicon; ?>puce-footer.png") left 7px no-repeat scroll;
	padding-left: 13px;
	margin: 26px 7px 10px 0;
}
footer ul li:first-child {
	background: none;
}
footer ul li a {
	color: #fff;
	font-size:12px;
}
footer ul li a:hover, footer ul li a:focus, footer ul li a:active {
	color: #ddd;
}
footer img {
	float: right;
}


/* BANDEAU - HTML spécifique */
#bande {
	background-image: linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $linkcolor; ?> 75%);
	background-image: -o-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $linkcolor; ?> 75%);
	background-image: -moz-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $linkcolor; ?> 75%);
	background-image: -webkit-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $linkcolor; ?> 75%);
	background-image: -ms-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $linkcolor; ?> 75%);
	background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0.25, <?php echo $color1; ?>),color-stop(0.75, <?php echo $linkcolor; ?>));
	background-color: <?php echo $linkcolor; ?>;
	border-top: 2px solid <?php echo $color2; ?>;
	height: 10px;
}
div.credits {
	font-size: 0.85em;
}
div.credits p {
	float: left;
	color: #333;
	margin: 4px 0 5px;
}
div.credits a{
	color: #333;
  text-decoration:underline;
}



/* Modifs en surcharge */
/* elgg.1340375803.css?view=default */
/* ligne 2004 */
.elgg-widget-content {
/*	padding: 0; */
}

div.elgg-widgets div.elgg-body {
	font-size: 0.90em;
}

.elgg-river-attachments, .elgg-river-message, .elgg-river-content {
	border-left: 1px solid #666;
	color: #666;
	font-size: 0.85em;
	clear:left;
}

/* Est-ce qu'on peut déplacer le span.elgg-river-timestamp en dehors de la div.elgg-river-summary ? */

.elgg-module .elgg-body, .elgg-module .elgg-content, .elgg-module .elgg-river-summary { font-size:14px; }
.elgg-module .entity_title { font-size:16px; }
/* .elgg-module .elgg-subtext { font-size:13px; } */

/*
.elgg-river-timestamp { float:right; }
.elgg-widget-instance-event_calendar { font-size:16px; }
.elgg-widget-instance-event_calendar p { font-size:13px; }
*/
.elgg-widget-instance-event_calendar p { font-size: 1.3em; }


/* AJOUT URBILOG */
.elgg-sidebar {
	width: 211px;
	float: right;
}
.elgg-sidebar ul.elgg-menu-page {
	background: #fff;
	float: left;
	width: 211px;
}
.elgg-sidebar ul.elgg-menu-page > li {
	border-bottom: 1px solid #ccc;
	float: left;
	width: 211px;
}
.elgg-sidebar ul.elgg-menu-page li h3 {
	background: #333;
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
.elgg-sidebar .elgg-menu-page li:first-child, .elgg-sidebar .elgg-menu-page li:last-child {
	border-bottom: 0 none;
}
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a {
	color: #333;
	font-weight: normal;
}
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a span {
	color: #002e6f;
	float: left;
	font-family: gill-sans-bold;
	font-size: 1.7em;
	font-weight: bold;
	line-height: 0.7em;
	margin-right: 5px;
	text-shadow: 0 2px 2px #999;
}
.elgg-sidebar .elgg-module-aside h3 {
	color: #333;
	font-size: 0.9em;
	margin: 0;
}
.elgg-sidebar .elgg-module-aside .elgg-body ul li {
	float: left;
/*	margin-bottom: 7px; */
/*	width: 203px; */
	width: auto;
}
.elgg-sidebar .elgg-module-aside .elgg-body ul li a img {
	float: left;
	margin-right: 5px;
	height: 25px;
	width: 25px;
/*
	height: 30px;
	width: 30px;
*/
}
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a {
	float: left;
	font-size: 0.75em;
}
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:hover, 
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:focus, 
.elgg-sidebar .elgg-module-aside .elgg-body .entity_title a:active {
	color: #333;
}


/* AJOUT URBILOG ENVOI2 */
div.elgg-main ul.elgg-list li.elgg-item div.elgg-body div.entity_title {
	/* float: left; */
	/* width: 220px; */
}
div.elgg-main ul.elgg-list li.elgg-item div.elgg-body div.elgg-subtext {
	/* width: 220px; */
}
ul.elgg-list li.elgg-item div.elgg-image a img {
/*
	width: 60px;
	height: 60px;
*/
	margin-right: 5px;
}
/*
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a { font-size: 0.9em; }
*/
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:hover, 
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:focus, 
ul.elgg-list li.elgg-item div.elgg-body div.entity_title a:active {
	color: #333;
}
ul.elgg-list li.elgg-item ul.elgg-menu {
	font-size: 0.75em;
}
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-one {
	width: 40px;
}
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-date {
	width: 60px;
}
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members {
	width: 90px;
}
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members a {
	color: <?php echo $linkcolor; ?>;
}
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-membership {
	width: 50px;
}
div.entetes-tri ul {
	background: #f6f6f6;
	color: #000;
	float: left;
	font-size: 0.75em;
	margin: 10px 0;
	padding: 5px 0;
	width: 717px;
	text-align: center;
}
div.entetes-tri ul li {
	float: left;
	margin-left: 10px;
}
div.entetes-tri ul li a {
	color: #000;
}
div.entetes-tri ul li a:hover, 
div.entetes-tri ul li a:focus, 
div.entetes-tri ul li a:active {
	color: #333;
}
div.entetes-tri ul li a img {
	float: right;
}
div.entetes-tri ul li.elgg-date {
	margin-left: 385px;
	width: 70px;
}
div.entetes-tri ul li.elgg-annuaire {
	width: 80px;
}
div.entetes-tri ul li.e.elgg-module .elgg-body .mts { float: left; clear: left; font-size: 0.9em; }lgg-acces {
	width: 60px;
}



/* Ajouts à répartir dans les bons fichiers */
.groups-profile {
  font-size: 0.85em;
  border-bottom: 1px solid #ccc; 
}
.groups-stats { background:none; }
.groups-profile-fields .odd, .groups-profile-fields .even { background:none; }
.elgg-output ul { color: #333; }
.elgg-river > li:last-child { border-bottom: 0 none; }


.message.unread a {
	color: <?php echo $linkcolor; ?>;
	font-weight:bold;
}


/* Quand on va sur l'agenda à l'aide du menu principal et qu'on choisi un autre onglet (par exemple : tous les évènements)
le menu Agenda (dans le menu principal) n'est pas actif (n'est plus grisé). Il faudrait s'assurer que la class lastfocus reste */


/* Mes paramètres */
.elgg-form-usersettings-save .elgg-body {
	padding-bottom: 10px;
}
.elgg-form-usersettings-save .elgg-body input, .elgg-form-usersettings-save .elgg-body textarea {
	background: #f6f6f6;
}

.profile-content-menu a {
	border-radius: 0;
}


/* Doit venir en surcharge pour éviter de modifier CSS du plugin */
.brainstorm-list .idea-content .entity_title { clear:none; padding-top:2px; margin-bottom:6px; }
.brainstorm-list .idea-content .elgg-subtext { float:left; clear:none; }
.brainstorm-list .idea-content.mts div.elgg-content { clear:both; }

.elgg-module-group-brainstorm .idea-content.mts { margin:0; width:240px; clear:none; }

/* Friendspicker */
#notificationstable td.namefield p.namefieldlink {
  vertical-align:30%;
  display:inline;
}

/* Page de connexion et d'inscription */
.adf-strongseparator { border: 1px solid <?php echo $linkcolor; ?>; clear:both; margin:12px auto; }
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

#adf-loginbox { border:1px solid #CCC; padding:10px 20px; margin-top:30px; background:#F6F6F6; }
#adf-loginbox form { margin:0; padding:0; }

#adf-homepage #adf-persistent { width:280px; float:right; margin:0; position:relative; top:-16px; }
#adf-homepage #adf-persistent label { width:auto; float:left; margin:0; margin-left:-5px; }

#adf-homepage input[type='submit'], 
.adf-lostpassword-link { margin-left:160px; }
#adf-homepage .elgg-form-register input[type='submit'] { margin-left:150px; }

#adf-homepage .adf-lostpassword-link { position:relative; top:-16px; margin-left:168px; }


#adf-homepage ul { list-style-type: square; }
#adf-homepage ul li { margin-bottom:8px; }


/* Widgets activité des groupes */
section div.elgg-widget-instance-group_activity div.elgg-body.activites, 
section div.elgg-widget-instance-group_activity div.elgg-body.activites .elgg-widget-content { padding:0; }
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
  padding:0 14px; 
  background:#c61b15;
  margin-top:-8px;
}
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a {
  color:white;display:block;
  font-family: 'gill-sans';
  font-size:14px;
}
.widget-group-content { padding: 0 10px 10px 10px; }


#user-avatar-cropper { float: left; }


.firststeps {
  padding:4px 8px; margin-bottom:10px; border:2px solid blue;
  -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;
}


/* Menus différenciés : navigation secondaire */
.elgg-menu-page .elgg-menu-item-groups-all a, 
.elgg-menu-page .elgg-menu-item-groups-member a, 
.elgg-menu-page .elgg-menu-item-groups-owned a, 
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a, 
.elgg-menu-page .elgg-menu-owner-block-categories li a {
  font-weight:bold !important; font-size:14px; color:#333333;
}

.elgg-menu-page .elgg-menu-item-groups-all a:hover, .elgg-menu-page .elgg-menu-item-groups-all a:focus, .elgg-menu-page .elgg-menu-item-groups-all a:active, .elgg-menu-page .elgg-menu-item-groups-all.elgg-state-selected > a,
.elgg-menu-page .elgg-menu-item-groups-member a:hover, .elgg-menu-page .elgg-menu-item-groups-member a:focus, .elgg-menu-page .elgg-menu-item-groups-member a:active, .elgg-menu-page .elgg-menu-item-groups-member.elgg-state-selected > a,
.elgg-menu-page .elgg-menu-item-groups-owned a:hover, .elgg-menu-page .elgg-menu-item-groups-owned a:focus, .elgg-menu-page .elgg-menu-item-groups-owned a:active, .elgg-menu-page .elgg-menu-item-groups-owned.elgg-state-selected > a, 
.elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:hover, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:focus, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites a:active, .elgg-sidebar .elgg-menu-page li.elgg-menu-item-groups-user-invites.elgg-state-selected > a, 
.elgg-menu-owner-block-categories li a:hover, .elgg-menu-owner-block-categories li a:focus, .elgg-menu-owner-block-categories li a:active, .elgg-menu-owner-block-categories li.elgg-state-selected > a 
{
  color:#333333 !important; background:#CCCCCC !important;
}

/* Menus différenciés : navigation complémentaire */
.elgg-menu-page a {
  font-weight:normal; font-size:14px;
}
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

.elgg-sidebar ul.elgg-menu-page > li { border-bottom:1px solid #CCCCCC !important; }

.calendar-navigation { margin:0 0 16px 0; }
.calendar-navigation a {
  -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;
  padding: 2px 6px;
  border: 1px solid <?php echo $linkcolor; ?>;
  color: <?php echo $linkcolor; ?>;
  font-size: 0.85em;
}


.elgg-widget-instance-brainstorm .elgg-item-idea div.entity_title { width:240px; }
.elgg-widget-instance-brainstorm .elgg-item-idea div.entity_title a { font-weight:normal; }



