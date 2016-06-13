<?php
/* CSS site public (ne s'applique pas au backoffice administration) */

$url = elgg_get_site_url();
$urlfonts = $url . 'mod/esope/fonts/';
$urlicon = $url . 'mod/esope/img/theme/';

// Configurable elements and default values

$fixedwidth = elgg_get_plugin_setting('fixedwidth', 'esope');
if ($fixedwidth != 'yes') $fixedwidth = false; else $fixedwidth = true;

// Image de fond configurable
$headerimg = elgg_get_plugin_setting('headerimg', 'esope');
if (!empty($headerimg)) { $headerimg = $url . $headerimg; }
$headbackground = elgg_get_plugin_setting('headbackground', 'esope');
if (!empty($headbackground)) { $headbackground = $url . $headbackground; }
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

/* ***************************************
 * ESOPE MAIN CSS
 ************************************** */


/* ELEMENTS ET CLASSES DE BASE - BASIC CLASSES AND ELEMENTS */

/* Set default break and wrap to avoid overflow on long lines */
html, body { word-break:break-word; word-wrap: break-word; hyphens: auto; }

/* h2 { color: #333; } */
.mts { margin-right:10px; }
.elgg-river-comments-tab { color:#cd9928; }
.elgg-input-rawtext { width:99%; }
/* Tableaux */
th { font-weight:bold; background:#CCCCCC; }
/* Access level informations */
.elgg-access {}
.elgg-access-group-closed {}
.elgg-access-group-open {}
.interne { width: 980px; max-width: 96%; position: relative; margin: 0 auto; }
.invisible { position: absolute !important; left: -5000px !important; }
.right { float: right !important; }
.minuscule { text-transform: lowercase; }
img { border: 0 none; overflow:hidden; }
#profil img { float: right; margin-left: 10px; }
.esope-more { float: right; font-size: 70%; line-height: 1.6; }
.esope-toggle { background:url('<?php echo $urlicon; ?>ensavoirplus.png') no-repeat 0 50%; padding-left:24px; }
.esope-toggle.elgg-state-active { background-image:url('<?php echo $urlicon; ?>fermer.png'); }


/* ACCESSIBILITY */
.entity_title {font-weight:bold; }

/* Corrections des styles du core */
:focus { outline: 1px dotted grey; }
input:focus, textarea:focus { outline:0; }
.ui-autocomplete-input:focus { outline:0; }
.elgg-button-action:hover, .elgg-button-action:focus { outline:0; }

/*
// Tous les :hover à compléter par :focus et :active
// Tous les display:none des menus à modifier/remplacer par des left:-5000px

=> fonctionne sans JS mais pas accessible au clavier
=> modifier les display:none => left:-5000px;
=> les afficher via left: valeur; ou right:valeur;

=> remplacer par un masquage en JS
*/


/* MISE EN PAGE ET PRINCIPAUX BLOCS - LAYOUTS AND MAIN BLOCKS */

/* ESOPE : bandeau */
.elgg-page-header {
	<?php if (!empty($headerimg)) {
		echo 'background-image: url("' . $headerimg . '"), linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: url("' . $headerimg . '"), -o-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: url("' . $headerimg . '"), -moz-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: url("' . $headerimg . '"), -webkit-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: url("' . $headerimg . '"), -ms-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: url("' . $headerimg . '"), -webkit-gradient(linear, left top, left bottom, color-stop(0.25, ' . $color1 . '), color-stop(0.75, ' . $color4 . '))';
	} else {
		echo 'background-image: linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: -o-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: -moz-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: -webkit-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: -ms-linear-gradient(top, ' . $color1 . ' 25%, ' . $color4 . ' 75%)';
		echo 'background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0.25, ' . $color1 . '), color-stop(0.75, ' . $color4 . '))';
	} ?>
	background-position: left 30px, left top;
	background-repeat: repeat-x, repeat;
	background-color: <?php echo $color4; ?>;
	color: #fff;
}
/* Couleur texte normal pour les header dans le contenu de la page */
.elgg-page-header, .elgg-page-body .intro { color: <?php echo $textcolor; ?>; }




/* Pour tous les éléments du menu : .elgg-menu-owner-block .elgg-menu-item-NOM_SUBTYPE */
#wrapper_header {}

/* Styles des modules page d'accueil et profil */
.elgg-page-header { border-top: 0 none; height: auto; }
.elgg-page-body div.intro { font-family:<?php echo $font4; ?>; font-size: 1.25em; }

/*
#transverse { clear:left; }
*/



.elgg-form.thewire-form { background: transparent; }
.static, .home-static { background:white; box-shadow:3px 3px 5px 0px #666; padding: 0.2% 0.4%; }
.static-container, .home-static-container {}


.elgg-menu-groups-my-status li a {
	-moz-border-radius:0; -webkit-border-radius:0; border-radius:0;
	width:211px; margin:0; padding:4px 10px;
}
.elgg-menu-groups-my-status li a:hover {
	-moz-border-radius:0; -webkit-border-radius:0; border-radius:0;
	width:211px; margin:0; padding:4px 10px;
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
.elgg-page-footer ul li a { color: #fff; font-size: 0.8rem; }
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
.elgg-page-footer .credits { clear:both; font-size: 0.7em; margin-top: 1.5em; }
.elgg-page-footer .credits p { float: left; margin: 4px 0 5px; color: #DEDEDE; }
.elgg-page-footer .credits a { color: #DEDEDE; text-decoration:underline; }





/* MENUS & NAVIGATION */
.elgg-menu-item-report-this { margin-left:10px; margin-top:5px; }
/* Eviter les recouvrements par le menu des entités */
.elgg-menu-entity { height:auto; text-align: center; max-width:50%; }
ul.elgg-list li.elgg-item ul.elgg-menu { /* font-size: 0.75em; */ }
/* Not sure why that was set but it is counter-useful !
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-one { width: 40px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-date { width: 60px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members { width: 90px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-membership { width: 50px; }
ul.elgg-list li.elgg-item ul.elgg-menu li.elgg-menu-item-members { color: <?php echo $linkcolor; ?>; }
*/

.elgg-menu-item-membership {}
.elgg-menu-item-members {}


/* Profile */
.profile.elgg-col-2of3 { float:left; margin-bottom: 2ex; }
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
.elgg-pagination.elgg-pagination-limit li, .elgg-pagination.elgg-pagination-limit li a, .elgg-pagination.elgg-pagination-limit li span { margin-right:2px; font-size: 0.9em; }
.elgg-pagination.elgg-pagination-limit span { padding: 2px 4px; }
.elgg-pagination.elgg-pagination-limit a { border-color:transparent; padding: 2px 4px; }
.elgg-pagination.elgg-pagination-limit a:hover, .elgg-pagination.elgg-pagination-limit a:focus, .elgg-pagination.elgg-pagination-limit a:active { border-color:transparent; }
.elgg-pagination-limit .elgg-state-selected span { font-weight:bold; border-color:transparent; }



/* BLOCS SPECIFIQUES : CONNEXION, etc. - MAIN BLOCKS : LOGIN, etc. */
#login-dropdown { position: absolute; top:110px; right:0; z-index: 100; margin-right:10px; }
/* Page de connexion et d'inscription */
.esope-strongseparator { border: 1px solid <?php echo $color4; ?>; clear:both; margin:12px auto; }
.esope-lightseparator { border: 1px solid white; clear:both; margin:16px auto; }

#esope-public-col1 { float:left; width:50%; }
#esope-public-col2 { float:right; width:44%; }

/* PAGE D'ACCUEIL PUBLIQUE */
#esope-homepage {  }
.home-intro { margin-bottom:3em; }
.home-calendar { margin-bottom:3em; }
.home-groups { margin-bottom:3em; }
.home-group-item { float:left; clear:left; padding-bottom:16px; width:100%; }
#esope-login { border:1px solid #CCCCCC; padding:1em; margin-bottom:3em; background:#F6F6F6; }
#esope-register { margin-bottom:3em; }
#esope-homepage p { font-size:14px; margin-top:0; margin-bottom:8px; }
#esope-homepage a, #esope-homepage a:visited { color:<?php echo $linkcolor; ?>; }
#esope-homepage a:hover, #esope-homepage a:active, #esope-homepage a:focus { color:<?php echo $linkhovercolor; ?>; }
#esope-homepage .elgg-form { background:transparent; }
#esope-homepage h2 { font-size:20px; font-weight:normal; }
#esope-homepage .elgg-form-register { font-size:13px; margin-top:0; margin-bottom:8px; }

#esope-homepage label { width:130px; float:left; margin:0 30px 16px 0; clear:both; text-align:right; }
#esope-homepage .elgg-foot label { width:auto; float:none; clear:both; }
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
/*
#profile_manager_register_left { width:100%; }
*/
.profile_manager_register_input_container { display:inline-block; }
#profile_manager_profile_edit_tabs { clear: both; }
.register-fullwidth { margin: 1em 0; }
.custom_profile_type_description { float: left; margin-left: 1ex; }
#widget_profile_completeness_progress_bar { background: #090; }
#profile_manager_profile_edit_tabs .elgg-module-info { min-width: auto; margin: 0 0 0px 3px; padding: 0; }



/* FORMULAIRES - FORMS */
/* Aide event_calendar form */
.elgg-form-event-calendar-edit .description { font-style:italic; font-size:0.90em; }
.event-calendar-edit-form-block { width: auto; }
/*
.event-calendar-edit-form { background: transparent; }
.event-calendar-edit-form-block { background-color: transparent; border: 0; }
*/


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

#feedbackDisplay a { color: <?php echo $linkcolor; ?>; }
#feedbackDisplay a:hover, #feedbackDisplay a:focus, #feedbackDisplay a:active { color: <?php echo $linkhovercolor; ?>; }




/* Thème ADF - Urbilog => Styles à classer et réorganiser */

/* Afficher/masquer les commentaires inline */
a.ouvrir { float: right; padding: 0 4px 0 0; clear:both; }
/* Infos dépliables */
.elgg-page-body div.module div.plus { clear:both; padding-top:2px; }
.elgg-item .plus { clear:both; }

.elgg-page-body article.fichier div.activites ul li a { float: left; font-size: 0.9em; font-weight: bold; width: 245px; }
.elgg-page-body article.fichier div.activites ul li span { color: #666; float: left; font-size: 0.75em; font-style: italic; margin-top: 2px; width: 245px; margin-bottom: 5px; }
.elgg-page-body article.fichier div.activites ul li span a { float: none; font-size: 1em; font-weight: normal; }



.elgg-river-attachments, .elgg-river-message, .elgg-river-content { border-left: 1px solid #666; color: #666; /* font-size: 0.85em; */ clear:left; }

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
.messages-owner { width: 25%; margin-right: 1%; }
.messages-subject { width: 50%; margin-right: 1%; }
.messages-timestamp { width: 18%; margin-right: 1%; font-size:0.8em; }
.messages-delete { width: 4%; }
.elgg-item.selected-message { opacity:1; }
.message-item-toggle { text-align: center; padding: 4px; display: block; background: #eee; }
.elgg-item-message .message-content { width: 96%; padding: 0 0.5%; display:none; padding-bottom: 16px; padding-top: 4px; }
.elgg-item-message .message-content.selected-message { display:block; }
.message-sent .message-content { opacity: 1; }
.message-inbox .message-content {	}
.message-sent .message-content { margin-left:3%; background: #EEE; }
.elgg-image-block .elgg-image-block.message { padding: 0 0; }


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


#user-avatar-cropper { float: left; }


.firststeps { background:white; padding:4px 8px; margin-bottom:30px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; font-family:<?php echo $font4; ?>; }



/* Evite débordements du texte alternatif si image non affichée */
.elgg-widget-content .elgg-image { max-width: 40%; overflow: hidden; }

/* Alertes et messages d'erreur */
.elgg-system-messages { max-width: 500px; position: absolute; left: 20px; top: 24px; z-index: 2000; background:transparent; }
.elgg-message { box-shadow: 1px 2px 5px #000000; font-size: 120%; padding: 3px 10px; /* background:white; */ }
.elgg-state-success { background-color: #00FF00; color: black; }

/* Navigation archives des blogs */
.blog-archives li { clear: left; font-weight: bold; padding: 0 0 4px 0; }
.pages-nav li { clear: left; }
.esope-subpages-menu { }


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
.elgg-longtext-control { font-size: 0.7rem; padding: 1px 5px; margin-left: 3px; border:1px solid transparent; border-radius: 3px; }
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
.au_subgroup.au_subgroup_icon-tiny { padding: 1px 0; }
.groups-profile-icon .au_subgroup_icon-tiny { font-size: 0.6rem; line-height: 1; padding: 1px 0; top: 0;  }
.groups-profile-icon .au_subgroups_group_icon-large { height: auto; }
.au_subgroups_group_icon.au_subgroups_group_icon-small span.au_subgroup { padding: 1px 0; font-size: 0.7rem; line-height: 1; }
.au_subgroups_group_icon.au_subgroups_group_icon-medium span.au_subgroup { padding: 3px 0; font-size: 0.9rem; }
.au_subgroups_group_icon.au_subgroups_group_icon-large span.au_subgroup { padding: 0.5rem 0; font-size: 1rem; }

/* Agencement fluide des blocs dans les groupes */
.elgg-gallery-fluid > li { float: right; }
#groups-tools > li.odd { float: left; }
#groups-tools > li { margin-bottom: 20px; min-height: 100px; width: 50%; min-width: 300px; display:inline-block; }

#groups-tools > li:nth-child(2n+1) { margin-right: 0; margin-left: 0; }
#groups-tools > li:nth-child(2n) { margin-right: 0; margin-left: 0; }

.groups-members-count { float: right; }


/* Anciens groupes */
.group-oldactivity { background: rgba(255,255,0,0.8); padding: 0.5rem 0; margin: 0 0; display:block; left:0; position: absolute; top:0; width: 100%; text-align:center; border:0; color:black; font-size: 1rem; }
.group-oldactivity-tiny { background: rgba(255,255,0,0.5); font-size: 0.4rem; padding: 1px 0; margin:0; line-height: 1; }
.group-oldactivity-small { background: rgba(255,255,0,0.7); font-size: 0.5rem; padding: 2px 0; }
.group-oldactivity-medium { background: rgba(255,255,0,0.8); font-size: 0.8rem; padding: 3px 0; }

.group-archive { border:1px dotted black; background:rgba(0,0,0,0.8); color:white; padding:1ex 3ex; margin: 1ex 0; text-align:center; }
.group-archive { display:block; left:0; position: absolute; top:0; width: 100%; text-align:center; border:0; color:white; }
.group-archive-tiny { background: rgba(0,0,0,1); color:white; font-size: 6px; padding: 2px 0px; }
.group-archive-small { background: rgba(0,0,0,1); color:white; font-size: 8px; padding: 3px 1px; }
.group-archive-medium { background: rgba(0,0,0,1); color:white; font-size: 10px; padding: 3px 1px; }

/* Statuts compte utilisateur : Archive (bannière compte archivé), Pas de mail associé au compte */
.profiletype-status { position: absolute; top: 0; right: 0; bottom: 0; left: 0; overflow: hidden; border: 3px solid transparent; width: 200px; height: 200px; z-index: 13; background: rgba(0,0,0,0.2); }
.profiletype-status-closed { position: absolute; width: 200px; height: 80px; line-height: 60px; margin: 70px 0; text-align: center; background: rgba(0,0,0,0.6); font-size: 1.5rem; font-weight: bold; text-transform: uppercase; color: white; }
.profiletype-status-no-mail { position: absolute; bottom: 0; left:0; width: 200px; height: 80px; line-height: 60px; margin: 70px 0; text-align: center; background: rgba(0,0,0,0.6); font-size: 1.5rem; font-weight: bold; text-transform: uppercase; color: white; }

/* Medium */
.elgg-avatar-medium .profiletype-status { position: absolute; border: 1px solid transparent; width: 100px; height: auto; z-index: 13; background: rgba(0,0,0,0.2); }
.elgg-avatar-medium .profiletype-status-closed { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0 0; text-align: center; background: rgba(0,0,0,0.6); font-size: 1rem; font-weight: bold; text-transform: uppercase; color: white; }
.elgg-avatar-medium .profiletype-status-no-mail { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0; text-align: center; background: rgba(255,0,0,0.6); font-size: 1rem; font-weight: bold; text-transform: uppercase; color: white; }

/* Small */
.elgg-avatar-small .profiletype-status { position: absolute; border: 1px solid transparent; width: 40px; height: auto; z-index: 13; background: rgba(0,0,0,0.2); }
.elgg-avatar-small .profiletype-status-closed { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0 0; text-align: center; background: rgba(0,0,0,0.6); font-size: 0.7rem; font-weight: bold; text-transform: initial; color: white; }
.elgg-avatar-small .profiletype-status-no-mail { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0; text-align: center; background: rgba(255,0,0,0.6); font-size: 0.6rem; font-weight: normal; text-transform: initial; color: white; }

/* Tiny */
.elgg-avatar-tiny .profiletype-status { position: absolute; border: 1px solid transparent; width: 25px; height: auto; z-index: 13; background: rgba(0,0,0,0.2); }
.elgg-avatar-tiny .profiletype-status-closed { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0 0; text-align: center; background: rgba(0,0,0,0.6); font-size: 0.5rem; font-weight: normal; text-transform: initial; color: white; }
.elgg-avatar-tiny .profiletype-status-no-mail { position: absolute; width: 100%; height: auto; line-height: 1; margin: 0; text-align: center; background: rgba(255,0,0,0.6); font-size: 0.5rem; font-weight: normal; text-transform: initial; color: white; }

/* Friendspicker */
/* .elgg-avatar-tiny .profiletype-status { left: 0; margin: 5px 10px 5px 5px; } */


/* Various tools icons : activity, event-calendar, announcements, blog, file, discussion, brainstorm, bookmarks, pages */

/* Note : this replaces the above with FA icons - update translations accordingly if needed
 */
.elgg-menu-owner-block li a { padding-left: 1ex; }
/*
.elgg-sidebar li .fa { display: inline-block; min-width: 1em; }
*/
li .fa { display: inline-block; /* min-width: 2.5ex; */ min-width: 1em; }




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



/* Trees and Folders */
/* Arborescence : taille de plus en plus petite */
.treeview { font-size:1rem; }
.treeview li { font-size:0.95em; }
.treeview li.elgg-state-selected a.selected { color:white; background-color:<?php echo $linkcolor; ?>; font-weight: bold; padding: 2px 7px; }
.elgg-page-body div.elgg-module ul.treeview li { padding: 3px 0pt 3px 16px; }


#file_tools_list_tree_container { max-width: 100%; padding:0; }
#file_tools_list_tree_container li { max-width: 95%; }
#file_tools_list_tree_container .tree li a, #file_tools_list_tree_container .tree li span { height:auto; white-space: normal; -webkit-hyphens: auto; -moz-hyphens: auto; -ms-hyphens: auto; -o-hyphens: auto; hyphens: auto; }


/* Group topmenu */
.elgg-menu-group-topmenu { background-color: <?php echo $titlecolor; ?>; padding: 0 1ex; border-radius: 10px 10px 0 0; }
.elgg-menu-group-topmenu li a { color: white; opacity:0.8; padding: 1ex; }
.elgg-menu-group-topmenu li a:hover, .elgg-menu-group-topmenu li a:active, .elgg-menu-group-topmenu li a:focus, .elgg-menu-group-topmenu li.elgg-state-selected a { text-decoration:none; opacity:1; }

/* Friendspicker */
#notificationstable td.namefield p.namefieldlink { vertical-align:30%; display:inline-block; }
.friends-picker { max-width:650px; width:100%; }
.friends-picker-main-wrapper { width:100%; }
.friends-picker-navigation { display: inline-block; }

/* Color picker */
.elgg-color-picker { max-width:45%; }

/* Newsletter */
/*
.elgg-menu-newsletter-steps { counter-reset:li; }
.elgg-menu-newsletter-steps li::before { content:counter(li); counter-increment:li; display:inline-block; position:absolute; font-weight: bold; padding: 5px 5px 6px 5px; background:white; border-radius:10px; padding: 2px 6px; text-indent: 0px; margin: 4px 6px; left:0ex; }
.elgg-sidebar .elgg-module-aside .elgg-body ul.elgg-menu-newsletter-steps li { clear:left; width:100%; text-indent:4ex; }
*/
#newsletter-embed-list { clear: both; }

.elgg-form-alt > fieldset > .elgg-foot { clear: both; }

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


/* Developers gear */
.developers-gear { background: rgba(0,0,0,0.7); border-radius: 1rem 0 0 0; }
.developers-gear:hover { background: rgba(0,0,0,1); }
.developers-gear .elgg-icon-settings-alt::before { content: 'DEV'; color: white; }




<?php if (!$fixedwidth) { ?>
/* .elgg-page-body RESPONSIVE DESIGN */

/* Pour la fluidité en général */
.elgg-page-default { min-width:200px; max-width:100%; }

/* Quand on utilise les widgets */
.elgg-widgets { min-width:200px; }
.elgg-page-body div.module { width: 94%; padding: 3%; background-size:100%; }
.elgg-page-body div.module { min-width:180px; }
.elgg-page-body div.module div.activites { width:auto; }
.elgg-page-body div.module footer { background-size: 100%; }
/* Listing et river */
.elgg-module-info .elgg-image-block .elgg-body .elgg-river-summary { width:auto; }


@media (max-width:1225px) {
}

@media (max-width:980px) {
	.elgg-page-default { min-width:200px; max-width:100%; }
}

@media (max-width: 766px) {
	.elgg-page-header > .elgg-inner h1 { padding-top: 0; }
}

@media (max-width:700px) {
	.elgg-inner { max-width:100%;; }
	
	.elgg-page-header { min-height:3ex; height:auto !important; background-color: <?php echo $color3; ?>; }
	.elgg-page-header .interne { margin:0; }
	.elgg-page-header h1 { margin-top:0; }
	.elgg-page-header .profile-link { display:inline-block; }
	.elgg-page-header .adf-profil { position:initial; }
	
	#transverse { width: 100%; }
	#transverse .interne { max-width:100%; margin:0; }
	
	/* Main content */
	.elgg-page-body { padding: 0 0.5em; }
	
	/* Footer */
	.elgg-page-footer { padding: 0 0.5em; }
	.elgg-page-footer img { float: none; }
	
	/* Generic rules */
	body { font-size:120%; }
	.floating { position: initial !important; }
	.elgg-page .elgg-breadcrumbs { font-size: small; margin-bottom: 1ex; display: inline-block; top:0; left:0; }
	.elgg-button { font-size: large; }
	
	/* Common tools */
	.elgg-page #groupchat-sitelink { position:initial; display: inline-block; border: 0; border-radius: 0; margin: 0; padding: 1ex; border: 0; width:100%; }
	.twitter-timeline { width: 100% !important; }
	
	/* Groups */
	.groups-profile-fields { width: 100%; }
	ul#groups-tools > li { width: 100% !important; max-width: 100% !important; float: none; }
	
	/* Home */
	.static-container, .home-static-container { min-width: 100%; margin: 1ex 0 3ex 0 !important; padding: 0 !important; }
	.static, .home-static { min-width: 100%; box-shadow: 0px 3px 3px -2px #666; margin: 1ex 0 2ex 0 !important; padding: 0 !important; }
	.timeline-event, .home-timeline .timeline-event { width: 100%; }
	
	/* Public Home */
	#adf-homepage #adf-public-col1, #adf-homepage #adf-public-col2 { float: none; width: 100%; }
	#adf-public-col2 { padding-top: 3ex; clear: both; }
	#adf-homepage input[type='text'], #adf-homepage input[type='password'], #adf-homepage select { min-width: 0; }
	
	/* Footer */
	#site-footer { margin-bottom: 1ex; padding-bottom: 1ex; }
	#site-footer ul li { clear: both; width: 100%; margin: 0 !important; background: none; font-size: 1rem; padding-left:0; }
	#site-footer ul li a { padding: 1ex 1ex; display: inline-block; font-size: 120%; }
	div.credits p { float:none !important; }
	
	/* Friends picker */
	.friends-picker { max-width:400px; }
	.friends-picker-navigation-l, .friends-picker-navigation-r { top: 3em; }
	
}


@media (max-width:500px) {
	/* Friends picker */
	.friends-picker { max-width:300px; }
	.friends-picker-navigation-l, .friends-picker-navigation-r { top: 4em; }
	
}

@media (max-width:400px) {
	/* Friends picker */
	.friends-picker { max-width:250px; }
	.friends-picker-navigation-l, .friends-picker-navigation-r { top: 5em; }
	
}

/*
@media (max-width:600px) {
	.elgg-page-default { min-width:200px; max-width:100%; }
	#groups-tools > li { width:100%; }
	
}
*/
<?php
}

