<?php
// Couleur des liens : #002e6e
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
// #0A2C83 - lien actif/au survol
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
// Couleur 2 : #F75C5C - haut du dégradé des modules
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3 : #C61B15 - bas du dégradé des modules
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');


/*
Vert clair : #5dc21a
Vert logo : #46A729
Bleu logo Dialogue+ : #474F71
Teintes : en jouant sur la dose de Noir (CMJN) pour obtenir un niveau de luminosité souhaité
Atténuations : en jouant sur la transparence
*/
?>

/*
html, body { background-color: #5F5C54; }
.interne-content { background: white; padding-top: 20px; }
*/
body { border-top:0; }

.elgg-page .home-static { padding:0; box-shadow: none; margin-bottom:2ex; }
.home-static h3 { background: <?php echo $color2; ?>; color: white; padding: 3px 4px 1px 6px; }
.home-static h3 a { color: white; }
.home-static #profile_completeness_container { background: transparent; width: auto; padding: 0.5ex 0 1ex 0; position: relative; }
.home-static #profile_completeness_progress { position: absolute; width: 100%; border: 1px solid #AAA; }
.home-events-ateliers h3 { display:none; }
.afparh-news .elgg-tags { display:none; }

.elgg-widget-add-control { text-align: center; border-top: 1px dotted <?php echo $color2; ?>; padding-top: 1ex; }
.elgg-widget-add-control .elgg-button-action { font-size: 120%; padding: 0.5ex 3ex; }

section div.module.elgg-module-widget { background:transparent; }
.elgg-module-widget footer { display: none; }
/*
.elgg-module-widget div.elgg-body.activites { border-left:1px solid <?php echo $color2; ?>; border-right:1px solid <?php echo $color2; ?>; }
*/



/* Styles génériques */
input, textarea { border-color: <?php echo $color2; ?>; }
input:hover, input:focus, input:active, textarea:hover, textarea:focus, textarea:active { border-color: <?php echo $linkcolor; ?>; background-color: #efe; }

/* Bandeau et menus supérieurs */
header { background:#FFFFFF; border-top:0; height:100px; }
header h1 { margin-top:2ex; margin-bottom:0.5ex; width: 100%; color: #474F71; line-height: 60px; text-align: center; text-transform: capitalize; }
header h1 img { height: 60px; width:auto; }
header .logo-afpa { float:right; }
header .logo-dialogueplus { height: auto; padding: 10px 0 9px 0; float:left; }
header nav { top: 5px; right: 0px; }
header #adf-profil, header nav ul li a { color:#333; text-shadow:none; padding-bottom:0;  }
header #adf-profil:hover, header #adf-profil:active, header #adf-profil:focus, header nav ul li a:hover, header nav ul li a:active, header nav ul li a:focus { color:#000; }

div#transverse { background: white; /* box-shadow: 0px 3px 2px 0px #999; */ box-shadow: none; border-bottom: 0; }
#transverse nav ul li, #transverse nav ul li:first-child { border-left:0; border-right:0; }
#transverse nav ul li a { padding: 9px 10px; font-size: 16px; transition-duration:0.5s; border-bottom: 4px solid whitesmoke; }
#transverse nav ul li a.active, #transverse nav ul li a.elgg-state-selected { border-bottom: 4px solid <?php echo $color2; ?>; background-color: white; }
#transverse nav ul li a:hover, #transverse nav ul li a:focus, #transverse nav ul li a:active { transition-duration:0s; border-bottom: 4px solid <?php echo $linkcolor; ?>; background-color: whitesmoke; }
#transverse nav ul li li a:hover, #transverse nav ul li li a:focus, #transverse nav ul li li a:active { border-bottom: 1px solid #fff; }

header nav ul li { margin-left: 3ex; }
header nav ul li a { padding:2px; display:inline-block; }
.profile-link img { float: left; margin-right: 1ex; margin-top: -2px; }

#transverse li.process-rh ul { width: 502px; }
#transverse li.process-rh ul li { width: 500px; }
#transverse li.process-rh ul li a { width: 481px; }


#transverse #main-search { border: 2px solid <?php echo $color2; ?>; /* #72c63a */ }
#transverse #main-search:hover, #transverse #main-search:active, #transverse #main-search:focus { border: 2px solid <?php echo $linkcolor; ?>; }
#main-search #adf-search-submit-button { background: <?php echo $color2; ?>; border-color: <?php echo $color2; ?>; }
#main-search #adf-search-submit-button:hover, #main-search #adf-search-submit-button:focus, #main-search #adf-search-submit-button:active { background: <?php echo $linkcolor; ?>; border-color: <?php echo $linkcolor; ?>; }


/* Groupes */
.elgg-form-groups-edit .ui-multiselect { width: auto !important; }

.elgg-module-info > .elgg-head { border-radius: 0; }
.elgg-module-info > .elgg-body { border-color: <?php echo $color2; ?>; }
.elgg-widget-more { background: none repeat scroll 0% 0% #E2F1DF; }
.elgg-sidebar .elgg-module .elgg-form.elgg-form-groups-search { border: 1px solid <?php echo $color2; ?>; }
.elgg-form.elgg-form-groups-search .groups-search-submit-button { background-color:<?php echo $color2; ?>; }
.elgg-form.elgg-form-groups-search .groups-search-submit-button:hover, .elgg-form.elgg-form-groups-search .groups-search-submit-button:active, .elgg-form.elgg-form-groups-search .groups-search-submit-button:focus { background-color:<?php echo $linkcolor; ?>; }
/* Menu top du groupe */
.group-top_menu .elgg-menu-group-topmenu { background:transparent; }
.group-top_menu .elgg-menu-group-topmenu li a { background: #474F71; color: white; font-size: initial; padding: 1ex 3ex; margin: 1ex 2ex 1ex 0ex; text-transform: uppercase; }
div#group-tool-tabs .group-tool-tab.elgg-state-selected, div#group-tool-tabs .group-tool-tab:hover, div#group-tool-tabs .group-tool-tab:active, div#group-tool-tabs .group-tool-tab:focus { background:white; color:<?php echo $linkhovercolor; ?>; }

.groups-pole-group { border: 1px dotted #ccc; padding: 1ex 1ex 0ex 1ex; margin: 1ex 0; }
#group-tool-tabs { text-align:center; }
.afparh-departements { padding:1ex; text-align:center; float:left; min-height: 130px; max-width: 120px; }


/* Member search */
.esope-search-metadata { width: 46%; min-height: 5ex; margin: 0ex 2% 1ex 0%; }
.esope-search-metadata label { float: left; width: 100%; }


/* Boutons */
.elgg-button-action, .elgg-menu .elgg-button-action, .elgg-button-submit { border-radius: 0; text-shadow: 1px 1px 0 #060; }



/* Pied de page */
#site-footer { background:white; color:#333; height:auto; }
#site-footer .interne { border-top:4px solid <?php echo $color2; ?>; }
#site-footer ul { margin:0; }
#site-footer ul li { margin: 12px 7px 20px 0px; }
#site-footer ul li:first-child { margin-left: 0; padding-left: 0; }
#site-footer ul li a { color:<?php echo $linkcolor; ?>; font-size: 16px; }
#site-footer ul li a:hover, #site-footer ul li a:active, #site-footer ul li a:focus { color:<?php echo $linkhovercolor; ?>; }



