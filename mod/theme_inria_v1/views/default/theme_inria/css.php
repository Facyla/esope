<?php

$url = elgg_get_site_url();
$fonturl = $url . 'mod/theme_inria/fonts/';
$imgurl = $url . 'mod/theme_inria/graphics/';
$tools_url = $imgurl . 'inria_widget/';

// Configurable elements : pass theme as $vars['theme-config-css']
// Image de fond du header
$headerimg = elgg_get_plugin_setting('headerimg', 'esope');
if (!empty($headerimg)) { $headerimg = $url . $headerimg; }
$backgroundcolor = elgg_get_plugin_setting('backgroundcolor', 'esope');
$backgroundimg = elgg_get_plugin_setting('backgroundimg', 'esope');
if (!empty($backgroundimg)) { $backgroundimg = $url . $backgroundimg; }
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'esope');
$textcolor = elgg_get_plugin_setting('textcolor', 'esope');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'esope');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'esope');
// Couleur 1 : Haut dégradé header
$color1 = elgg_get_plugin_setting('color1', 'esope');
// Couleur 4 : Bas dégradé header
$color4 = elgg_get_plugin_setting('color4', 'esope');
// Couleur 2 : Haut dégradé widgets/modules
$color2 = elgg_get_plugin_setting('color2', 'esope');
// Couleur 3 : Bas dégradé widgets/modules
$color3 = elgg_get_plugin_setting('color3', 'esope');
// Couleur 5-8 : Dégradés des boutons + dégradé hover
$color5 = elgg_get_plugin_setting('color5', 'esope');
$color6 = elgg_get_plugin_setting('color6', 'esope');
$color7 = elgg_get_plugin_setting('color7', 'esope');
$color8 = elgg_get_plugin_setting('color8', 'esope');
// Divers tons de gris par défaut et éléments de l'interface
$color9 = elgg_get_plugin_setting('color9', 'esope'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'esope'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'esope'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'esope'); // #DEDEDE
// Couleur de fond du sous-menu déroulant
$color13 = elgg_get_plugin_setting('color13', 'esope');
// Module title
$color14 = elgg_get_plugin_setting('color14', 'esope');
// Button title
$color15 = elgg_get_plugin_setting('color15', 'esope');
// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'esope');
// Fonts
$font1 = elgg_get_plugin_setting('font1', 'esope');
$font2 = elgg_get_plugin_setting('font2', 'esope');
$font3 = elgg_get_plugin_setting('font3', 'esope');
$font4 = elgg_get_plugin_setting('font4', 'esope');
$font5 = elgg_get_plugin_setting('font5', 'esope');
$font6 = elgg_get_plugin_setting('font6', 'esope');


$module_title_color = $titlecolor;
$module_bg_color = $color2;
// Force settings
$module_title_color = '#6D2C4F';
$module_bg_color = '#F8F4F5';

// Main width (on desktop screen)
$main_width = "80%";
$main_maxwidth = "80%";

?>
/* <style> /**/


/* Main width */
.elgg-page-default {
	/* min-width: 800px; */
}
.elgg-page-default .elgg-page-header > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner, 
.elgg-page-default .elgg-page-sitemenu > .elgg-inner {
	max-width: <?php echo $main_maxwidth; ?>;
	width:auto;
}
#page_container {
	width:<?php echo $main_width; ?>;
}
/*
.elgg-layout-one-sidebar .elgg-main { width: 70%; }
.elgg-sidebar { width: 24%; }
*/



/* Change Elgg sprites image */
/*
.elgg-icon { background-image: url(<?php echo $imgurl; ?>elgg_sprites-iris.png); }
*/
.elgg-icon { background-image: none; }

/* Add some fonts */
@font-face {
	font-family: 'Neo Sans Std'; font-weight: 100; font-style: normal;
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-light-webfont.eot');
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-light-webfont.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-light-webfont.woff') format('woff'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-light-webfont.ttf') format('truetype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-light-webfont.svg#neo_sans_stdregular') format('svg');
}
@font-face {
	font-family: 'Neo Sans Std'; font-weight: normal; font-style: normal;
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.eot');
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.woff') format('woff'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.ttf') format('truetype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-regular-webfont.svg#neo_sans_stdregular') format('svg');
}
@font-face {
	font-family: 'Neo Sans Std'; font-weight: 600; font-style: normal;
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-medium-webfont.eot');
	src: url('<?php echo $fonturl; ?>NeoFont/neosansstd-medium-webfont.eot?#iefix') format('embedded-opentype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-medium-webfont.woff') format('woff'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-medium-webfont.ttf') format('truetype'),
		 url('<?php echo $fonturl; ?>NeoFont/neosansstd-medium-webfont.svg#neo_sans_stdregular') format('svg');
}


/* Effet sur listes */
.elgg-list .elgg-item { opacity: 1.0; }

/* Slider */
/* Limit slides content size */
.iris-news { height: auto; overflow:hidden; }
.iris-news #slider1 img { max-height: 200px !important; }
/* Slider styles */
.anythingSlider li.panel { display:none; }
.anythingSlider li.panel.activePage { display:block; }
.anythingSlider-cs-portfolio .arrow { top: 40%; position: absolute; z-index:10; }
.anythingSlider .arrow span { visibility:visible; font-size: 50px; }
.anythingSlider .arrow a, .anythingSlider .arrow a:hover, .anythingSlider .arrow a:active { text-decoration: none; }
.arrow.back { left: 20px; }
.arrow.forward { right: 20px; }
.iris-news .anythingControls { position: absolute; bottom: 4px; left: 20%; }
.iris-news .anythingSlider .anythingControls ul a, .iris-news .anythingSlider .start-stop, .iris-news .anythingSlider-cs-portfolio .anythingControls a.start-stop, .iris-news .anythingSlider-cs-portfolio .anythingControls a.start-stop.playing { background-color: #6D2D4F; margin: 3px 4px; transition-duration: 0.3s; }
.iris-news .anythingSlider-cs-portfolio .anythingControls a.cur, .iris-news .anythingSlider-cs-portfolio .anythingControls a:hover { background-color: #EF793E; width: 22px; height: 22px; margin: 0px 1px; }

.elgg-autocomplete-item .elgg-access a { display: none; }



/* Header */
body { border-top:0; background:white; /* font-size:0.75rem; */ }
section { background:white; }
.elgg-page-header { background: #6F2D50 !important; border-top: 0; height:auto !important; }
.elgg-page-header .elgg-inner h1 { margin: 0; padding:0; font-size:1rem; }
.elgg-menu-topbar { position:absolute; top: 27px; right:5px; margin-left: 140px; }
.elgg-menu-topbar #user img { float: left; margin-right: 6px; }
.elgg-menu-topbar li a { font-size:0.75rem; font-weight:normal; color: #fff; text-shadow: none; font-family: Arial, Helvetica, sans-serif; }

#adf-homepage .inria-login a, #adf-homepage .inria-login a:visited { color: white; }
#adf-homepage .inria-login a:hover, #adf-homepage .inria-login a:focus, #adf-homepage .inria-login a:active { color: #333; text-shadow:none; }
.cas-login { float:left; }
.basic-login { float:right; }
.basic-login-toggle, #adf-homepage .inria-login .basic-login-toggle { float:right; color:<?php echo $linkcolor; ?>; }
.elgg-context-login .elgg-module-aside { float: right; width: 50%; }

/* Main menu */
.elgg-page-header { background: <?php echo $module_bg_color; ?>; border: 0; box-shadow: none; min-height: 37px; }
#transverse ul.elgg-menu-navigation li, #transverse ul.elgg-menu-navigation li:first-child { border:0; padding:0; }
#transverse ul.elgg-menu-navigation li a { text-transform:uppercase; color: #EF783E; font-family: <?php echo $font2; ?>; font-size: 0.875rem; font-weight: bold; }
#transverse ul.elgg-menu-navigation li a.active, #transverse ul.elgg-menu-navigation li a.elgg-state-selected, #transverse ul.elgg-menu-navigation li a:hover, #transverse ul.elgg-menu-navigation li a:focus, #transverse ul.elgg-menu-navigation li a:active { background-color: <?php echo $module_bg_color; ?>; color:#6D2D4F; }
#transverse ul.elgg-menu-navigation li ul li a:hover, #transverse ul.elgg-menu-navigation li ul li a:focus, #transverse ul.elgg-menu-navigation li ul li a:active { background: <?php echo $module_bg_color; ?>; color: #6D2D4F; }
#transverse ul.elgg-menu-navigation li ul { background: <?php echo $module_bg_color; ?>; top: 36px; left: 0px; box-shadow:none; }
#transverse ul.elgg-menu-navigation li ul li { background: <?php echo $module_bg_color; ?>; }
#transverse ul.elgg-menu-navigation li ul li a { border-bottom: 0; text-transform: none; font-weight: normal; font-size: 0.875rem; padding: 0.5em 0.75em; }

/* Search */
input:focus, textarea:focus { background: #FFFAF0; }
.elgg-page-header form, #transverse form { /* float: right; */ border: 0; border-radius: 0; box-shadow: none; margin-top: 5px; }
#transverse form input#esope-search-input { height: 27px; border: 1px solid #EF783E; border-radius: 0; color: #EF783E; font-weight:bold; }
#transverse form input#esope-search-input:active, #transverse form input#esope-search-input:focus { color: #EF783E; }
#transverse form input#esope-search-submit-button { background: #EF783E; border-color: #EF783E; border-radius: 0; }
#transverse form input#esope-search-submit-button:hover, #transverse form input#esope-search-submit-button:active, #transverse form input#esope-search-submit-button:focus { background-color: #6D2C4F; border: 1px solid #6D2C4F; }

/* Members search */
.esope-search-metadata { width: 30%; height:auto; min-height: 3rem; border-left: 1px solid #ccc; padding: 0.5%; background: #f0f0f0; margin-right: 2%; margin-bottom: 0.5rem; }
/* Search filters */
.search-filter-menu { padding:6px; margin:4px 0; border:1px dotted #CCC; }
.search-filter-menu a { padding:2px 4px; margin: 0 10px 6px 0; background: #F8F4F5; display: inline-block; }

/* Members menu */
.elgg-menu-item-members { background-image: none; }

/* Sidebar */
.elgg-sidebar { border-left: 0px dotted #CCC; }
.elgg-context-groups .elgg-sidebar { border-left: 1px dotted #CCC; padding-top:1%; }
.elgg-sidebar .elgg-module-aside h3 { font-size:0.875rem; }

/* Titre objets dans les widgets notamment */
.elgg-module .entity_title { font-size: 0.875rem; }

/* Titre listing des groupes */
.groups-profile-icon .au_subgroups_group_icon-large { height: auto; width: auto; }
.groups-profile-icon .au_subgroups_group_icon-large img { height: auto; width: auto; max-height: 100px; max-width: 200px; }
.elgg-context-groups .elgg-list-entity h3 { font-size: 1rem; }
.elgg-context-groups .elgg-list-entity .elgg-image .au_subgroups_group_icon-medium { width: 50px; height: 50px; }
.elgg-context-groups .elgg-list-entity .elgg-image .au_subgroups_group_icon-medium img { width: 100%; height: 100%; }
.au_subgroups_group_icon span.au_subgroup { display: none; }
.au_subgroup.au_subgroup_icon-tiny { font-size:0.25rem; padding:3px 0px; }
.groups-profile .groups-profile-fields .odd, .groups-profile .groups-profile-fields .even { border: 0; }

/* Flux RSS des groupes */
.elgg-list .simplepie-list li { border-top: 1px solid #ccc; padding: 3px; padding-top: 6px; margin-bottom: 0; }
.elgg-list .simplepie-list li h4 { font-weight:normal }


/* Forms */
::-webkit-input-placeholder { color: #EF783E; }
:-moz-placeholder { color: #EF783E; }
::-moz-placeholder { color: #EF783E; }
-ms-input-placeholder { color: #EF783E; }


/* Footer */
.elgg-page .elgg-page-footer {
	background: #6d2d4f;
	background: -moz-linear-gradient(top, #bf8279 0%, #6d2d4f 75%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#bf8279), color-stop(75%,#6d2d4f));
	background: -webkit-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: -o-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: -ms-linear-gradient(top, #bf8279 0%,#6d2d4f 75%);
	background: linear-gradient(to bottom, #bf8279 0%,#6d2d4f 75%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#bf8279', endColorstr='#6d2d4f',GradientType=0 );
}
.elgg-page .elgg-page-footer .elgg-inner { padding: 0; }
.elgg-page-footer ul { margin: 0 auto; max-width: 500px; }
.elgg-page-footer ul li { padding-left: 13px; margin: 26px 7px 10px 0; background: transparent url("<?php echo $url; ?>mod/esope/img/theme/puce-footer.png") left 7px no-repeat scroll; color: #fff; }
.footer-logo-inria { margin: 12px 0; }

/* Buttons */
.elgg-button.elgg-button-action { border-radius: 5px; border: 1px solid <?php echo $color6; ?>; color: white; font-weight: normal; font-size: 0.81rem; font-family: <?php echo $font2; ?>; padding: 4px 6px; }
.elgg-button.elgg-button-action:hover, .elgg-button.elgg-button-action:active, .elgg-button.elgg-button-action:focus { border: 1px solid <?php echo $color8; ?>; color:#333; }
.elgg-button.elgg-button-submit { border-radius: 5px; border: 1px solid <?php echo $color6; ?>; color: white; font-weight: normal; font-size: 0.81rem; font-family: <?php echo $font2; ?>; padding: 4px 6px; }
.elgg-button.elgg-button-submit:hover, .elgg-button.elgg-button-submit:active, .elgg-button.elgg-button-submit:focus { border: 1px solid <?php echo $color8; ?>; color:#333; }
.elgg-button.elgg-button-cancel:hover, .elgg-button.elgg-button-cancel:focus, .elgg-button.elgg-button-cancel:active { color:white; }


/* Page d'accueil */
.elgg-context-dashboard > .elgg-main { padding: 0; }
.home-news { /* background:#efefef; */ padding:0.5em 1em; margin-bottom:1em; }
.elgg-context-dashboard .elgg-form-thewire-add { width: 100%; }
.elgg-context-dashboard .elgg-form-thewire-add #thewire-characters-remaining { float:none; margin: 22px 0 0 0; }
.elgg-context-dashboard .elgg-form-thewire-add .elgg-foot { padding: 0 0 0.5em 0; text-align: left; margin: 0; }

.thewire-form #thewire-characters-remaining { font-weight: normal !important; color: #999 !important; float:none; font-size: 1.2em; }
.thewire-form #thewire-characters-remaining.thewire-characters-remaining-warning { font-weight: bold !important; color: #F00 !important; }
/* Note : si on veut ajouter un message il faudra modifier le JS et la structure HTML...
#thewire-characters-remaining .thewire-characters-remaining-message { display:none; }
#thewire-characters-remaining.thewire-characters-remaining-warning .thewire-characters-remaining-message { display:inline; }
*/
#thewire-characters-remaining span { margin: 3px 12px 0 0; float:none; font-size: 1.2em; }
#thewire-textarea { font-size: 1.2em; height:4em; }
.home-wire #thewire-textarea { margin-top: 0; }
.home-wire .thewire-form { padding: 0; }
.home-wire .thewire-form .elgg-button-submit { margin-top:3px; }

.home-box { margin-bottom: 1em; background: <?php echo $module_bg_color; ?>; padding: 0.5em 0.5em; border-radius: 5px; }
.home-box h3:first-child, .home-box h3:first-child a { font-size:0.875rem; font-family:<?php echo $font2; ?>; margin-bottom: 0.8em; color:<?php echo $titlecolor; ?>; }
.home-wire, .home-activity { background:white; padding:0; }
.home-wire h2 a, .home-activity h2 a { font-size:1.375rem; margin-bottom: 0; color:<?php echo $titlecolor; ?>; }
.home-wire .elgg-list-access, .home-activity .elgg-list-access { display: none; }
.home-wire #thewire-textarea { height: 4em; padding: 1px 3px; }
.home-wire .elgg-item .elgg-content { margin: 6px 0px 2px 0px; }
.iris-add-button { font-weight: bold; padding: 11px 0px; border: thin dotted <?php echo $titlecolor; ?>; background-color: #F8F4F5; width:100%; text-align:center; display:block; }
.home-activity .elgg-menu-item-access { margin-top: 0; }
.home-activity .elgg-item .elgg-content { margin: 6px 0px 2px 0px; }
.home-activity .elgg-list-river > li:hover { background-color: #FFFFFF; }
.home-activity .elgg-river-attachments, .home-activity .elgg-river-message, .home-activity .elgg-river-content { margin: 2px 0 0px 0; }
.elgg-river-attachments, .elgg-river-message, .elgg-river-content { border-left: 0 !important; padding-left: 0; }
/* The Wire */
.thewire-inria-info { margin: 12px auto 24px auto; border: 1px solid grey; padding: 10px 20px; font-size: 1.1em; width: 70%; }
.elgg-form-thewire-group-add .elgg-foot { padding: 0 0 0.5em 0; }
/*
.elgg-form-thewire-group-add #thewire-textarea { width: 80%; float: left; height: 3em; margin-top: 0; }
*/
.elgg-form-thewire-group-add #thewire-textarea { height: 4em; padding: 1px 3px; }
.elgg-form-thewire-group-add #thewire-characters-remaining span { margin: 0 12px 0 0; float:none; font-size: 1.2em; }
.thewire-remaining-message { color: red; }
.elgg-form-thewire-group-add .elgg-button-submit { margin-top: 3px; }
.theme_inria-thewire-group-add {}
.theme_inria-thewire-group-add h3 { margin-top: 20px; }
.elgg-form-thewire-group-add select { max-width: 20ex; float: right; }

/* Réduction des contenus de la rivière : voir si home seule ou partout */
.elgg-river .elgg-item img, .elgg-river .elgg-item iframe { max-width: 100%; max-height: 50px; }
.river-inria-info { margin: 24px auto 12px auto; border: 1px solid grey; padding: 10px 20px; font-size: 1.1em; width: 70%; }


/* Widgets */
.elgg-widget-add-control { clear: both; padding-top: 20px; }
section .elgg-inner .elgg-layout-one-column div.module { border: 0; background: <?php echo $module_bg_color; ?>; }
section .elgg-inner div.module header { background: <?php echo $module_bg_color; ?>; }
section .elgg-inner div.module header h2 { color:<?php echo $module_title_color; ?>; font-size:0.875rem; text-transform:initial; font-weight: bold; }
section .elgg-inner div.module div.activites { background-color: <?php echo $module_bg_color; ?>; }
.elgg-widget-more { background-color: <?php echo $module_bg_color; ?>; }

.elgg-widget-handle { cursor: move; }
/* Edit widgets list */
#widgets-add-panel { border: 0; background: white; }
.elgg-widgets-add-panel li { border: 0; border-radius: 3px; background: #F8F4F5; text-indent: 0px; text-align: center; border:1px dotted #6D2D4F; color:#6D2D4F; }
/* Hide unavailable widgets */
.elgg-widgets-add-panel .elgg-state-unavailable { display: none; }


/* Page animation */
.anim-stats .elgg-table-alt td:first-child { max-width: 180px !important; }

/* Navigation des pages wiki en pleine largeur */
.full-width-pages-nav { border-top: 1px solid #ccc; margin-top: 0.5em; margin-bottom: 1em; padding: 0.5em; background: #efefef; }

/* Anciens groupes */
.inria-group-oldactivity { border:1px dotted black; background:yellow; padding:0.5rem 0;; margin: 0 0; text-align:center; font-size: 1rem; }
.group-oldactivity { display:block; left:0; position: absolute; top:0; width: 100%; text-align:center; border:0; color:black; }
.group-oldactivity-tiny { background: rgba(255,255,0,0.5); font-size: 0.4rem; margin:0; padding: 0px 0px; text-transform: lowercase; line-height: 1; }
.group-oldactivity-small { background: rgba(255,255,0,0.7); font-size: 0.5rem; padding: 2px 1px; }
.group-oldactivity-medium { background: rgba(255,255,0,0.8); font-size: 0.8rem; padding: 2px 1px; }


/* Messages */
.elgg-page-messages .elgg-system-messages { top: 110px; left: auto; right: 20px; }
.elgg-state-success { background-color: #6d2d4f; }

/* Tabs et filtres */
.elgg-menu-filter { font-size: 0.75rem; }
.elgg-menu-filter > li { margin: 0 0 0 4px; }
.elgg-menu-filter > li > a { height: 18px; }

.elgg-tabs { font-size: 0.75rem; }
.elgg-tabs > li { margin: 0 0 0 4px; }
.elgg-tabs > li > a { height: 18px; }


/* Groups */
.elgg-owner-block .elgg-head { /* background: #F8F4F5; */ background: #FFFFFF; }
/* Eviter car nécessite de revoir tous les outils
.elgg-menu-owner-block li a { background-color: #F8F4F5; }
*/
.elgg-form.elgg-form-au-subgroups-transfer.elgg-form-alt.elgg-form-groups-edit + div { padding-top:20px; }
.elgg-form-au-subgroups-transfer .au-subgroups-parentable h3, .elgg-form-au-subgroups-transfer .au-subgroups-non-parentable h3 { font-size: 0.875rem; }
.elgg-form-au-subgroups-transfer .au-subgroups-result-col { width: 100%; float: none; }
.elgg-form-au-subgroups-transfer .elgg-image-block .elgg-image { float: right; }
.elgg-form-groups-search .blockform { border: 1px solid #ccc; }

.elgg-form-groups-edit { margin-bottom: 20px; }
.au-subgroups-non-parentable { display: none; }

.elgg-context-groups .elgg-module-aside li .elgg-image-block > .elgg-body { border-bottom: 1px dotted #CCCCCC; }



/* Group tabs */
/* ***************************************
	GROUP FILTER MENU
*************************************** */
.group-top-menu { width: 100%; margin-bottom: 5px; border-bottom: 2px solid #CCC; }
.elgg-menu-group-filter, .elgg-menu-group-filter-alt { border-bottom: 0px solid #ccc; display: table; margin-bottom: 0; min-width: 30%; }

/* Left (filter) menu */
.elgg-menu-group-filter > li { float: left; border: 2px solid #ccc; border-bottom: 0; background: #eee; margin: 3px 0 0 4px; -webkit-border-radius: 5px 5px 0 0; -moz-border-radius: 5px 5px 0 0; border-radius: 5px 5px 0 0; }
.elgg-menu-group-filter > li:hover, 
.elgg-menu-group-filter > li:focus, 
.elgg-menu-group-filter > li:active { background: transparent; }
.elgg-menu-group-filter > li > a { text-decoration: none; display: block; padding: 3px 10px 0; text-align: center; height: 18px; color: #999; font-family: <?php echo $font2; ?>; font-size: 0.75rem; }
.elgg-menu-group-filter > li > a:hover, .elgg-menu-group-filter > li > a:focus, .elgg-menu-group-filter > li > a:active { background: white; color: #000; border-radius: 3px; }
.elgg-menu-group-filter > .elgg-state-selected { border-color: #ccc; background: white; }
.elgg-menu-group-filter > .elgg-state-selected > a { position: relative; top: 2px; background: white; }
.elgg-menu-group-filter > li.elgg-menu-item-pages a, .elgg-menu-group-filter > li.elgg-menu-item-pages a:hover, .elgg-menu-group-filter > li.elgg-menu-item-pages a:active, .elgg-menu-group-filter > li.elgg-menu-item-pages a:focus { background: transparent !important; }
.elgg-menu-group-filter > li:first-child { margin-left: 0px; }

/* Hide group extras tools */
/*
.elgg-context-groups .elgg-menu-extras { display: none; }
.elgg-menu-item-rss { display: none !important; }
*/
.elgg-menu-item-bookmark, .elgg-menu-item-report-this { display: none !important; }

/* Modify title menu action buttons */
.elgg-menu-group-filter-alt > li { float: right; background: <?php echo $color6; ?>; border-color: <?php echo $color6; ?>; font-family: <?php echo $font2; ?>; font-size: 0.75rem; border-radius: 5px 5px 0 0; margin: 3px 0 0 4px; }
.elgg-menu-group-filter-alt > li a.elgg-button.elgg-button-action { height:18px; color: white; background: initial; padding: 3px 10px 0; font-family: <?php echo $font2; ?>; font-size: 0.75rem; border: 2px solid transparent; border-bottom: 0; }
.elgg-menu-group-filter-alt > li:hover, .elgg-menu-group-filter-alt > li:focus, .elgg-menu-group-filter-alt > li:active { background: <?php echo $color8; ?>; border-color: <?php echo $color8; ?>; }
.elgg-menu-group-filter-alt > li > a.elgg-button.elgg-button-action:hover, .elgg-menu-group-filter-alt > li > a.elgg-button.elgg-button-action:focus, .elgg-menu-group-filter-alt > li > a.elgg-button.elgg-button-action:active { background: <?php echo $color8; ?>; }


/* PROFILE */
.elgg-context-profile .elgg-widgets { float: left; }
/* Widgets du profil façon Linkedin - style défini globalement par ailleurs pour ce bouton
.profile-widgets .elgg-widget-add-control { float:left; text-align: left; margin: 1%; background: #eee; height: 30px; border: 2px dotted #aaa; padding: 10px 1% 0px 1%; }
*/
#elgg-widget-col-1 { clear: both; }
.inria-ldap-details { border: 1px solid black; padding: 4px; margin: 0 0 10px 0; background: white; }

a.avatar_edit_hover { position: absolute; z-index: 10; width: 200px; height: 200px; text-align: center; vertical-align: 50%; line-height: 200px; opacity:0; color:#FFF; text-decoration:none; border:3px solid transparent; }
.avatar_edit_hover:hover, .avatar_edit_hover:active, .avatar_edit_hover:focus { opacity:1; background:rgba(0,0,0,0.3); }

.view-profile-as { border:1px dotted grey; padding:2px 6px; }
.edit-profile-linkedin { border:1px dotted grey; padding:2px 6px; }
.linkedin-link { background: url(<?php echo $url; ?>mod/hybridauth/graphics/linkedin_long.png) no-repeat 0 0; background-size: contain; color: transparent !important; display: inline-block; height: 2ex; width: 8ex; }


/* Profils différenciés */
.elgg-avatar img { border: 1px solid transparent; background-size: cover !important; }
.elgg-avatar.profile-type- img { border: 1px solid transparent; }
.elgg-avatar.profile-type-inria img { border: 1px solid #e33729;; }
.elgg-avatar.profile-type-external img { border: 1px solid #333333; }
/* Bordure large seulement sur page de profil */
#profile-owner-block .elgg-avatar img { border-width: 3px; }

.profiletype-badge { position: absolute; width: 200px; height: 200px; border: 3px solid transparent; }
.profiletype-badge-inria { position: absolute; right: 0px; bottom: 0; background: #e33729; color: white; padding: 4px 2px 0px 6px; border-radius: 8px 0 0 0; font-weight: bold; z-index: 11; }
.profiletype-badge-external { position: absolute; right: 0px; bottom: 0; background: #333333; color: white; padding: 0.15rem 0.15rem 0 0.4rem; border-radius: 0.5rem 0 0 0; font-weight: bold; z-index: 11; }

.update-ldap-details { font-size:11px; margin-top:6px; padding-top:4px; text-align:center; }

#profile-details { clear: right; }
#profile-owner-block { max-width: 100%; width: auto; }
.profile-col-profile { float:left; width:24%; min-width:230px; }
.profile-col-details { float:left; width:50%; min-width:230px; }
.profile-col-activity { float:left; width:24%; }
.profile-col-largedetails { float:left; width:74%; }


/* Réduction de la hauteur pour embed des fichiers */
.elgg-form-embed .cke_contents { height: 100px !important; }
.elgg-form-embed #prevent_notification { display: none; }
.elgg-form-embed.elgg-form-file-upload .elgg-input-plaintext { height: 100px; }


/* Widgets */
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a { color: <?php echo $titlecolor; ?> !important; }
/* Inria Tools Widget */
.inria-tool-widget .elgg-horizontal label { float: left; clear: none !important; }
.elgg-button.inria-tool-link { background-repeat: no-repeat !important; padding: 3px 5px 3px 34px !important; margin: 4px; min-width: 10ex; /* color: black; font-size: 16px; */ }
.inria-tool-forge { background-image: url(<?php echo $tools_url; ?>GForge.png) !important; }
.inria-tool-notepad { background-image: url(<?php echo $tools_url; ?>NOTEPAD.png) !important; }
.inria-tool-framadate { background-image: url(<?php echo $tools_url; ?>FRAMADATE.png) !important; }
.inria-tool-webinar { background-image: url(<?php echo $tools_url; ?>Visioconference.png) !important; }
.inria-tool-ftp { background-image: url(<?php echo $tools_url; ?>TRANSFER.png) !important; }
.inria-tool-share { background-image: url(<?php echo $tools_url; ?>PARTAGE.png) !important; }
.inria-tool-confcall { background-image: url(<?php echo $tools_url; ?>AUDIOCONFERENCE.png) !important; }
.inria-tool-intranet { background-image: url(<?php echo $tools_url; ?>intranet.png) !important; }
.inria-tool-evo { background-image: url(<?php echo $tools_url; ?>EVO.png) !important; }
.inria-tool-mailinglist { background-image: url(<?php echo $tools_url; ?>Listedediffusion.png) !important; }
.inria-tool-mailer { background-image: url(<?php echo $tools_url; ?>MAILER.png) !important; }
.inria-tool-mission { background-image: url(<?php echo $tools_url; ?>IZIGFD.png) !important; }
.inria-tool-mission2 { background-image: url(<?php echo $tools_url; ?>ORELI.png) !important; }
.inria-tool-holidays { background-image: url(<?php echo $tools_url; ?>CASA.png) !important; }
.inria-tool-annuaire { background-image: url(<?php echo $tools_url; ?>ANNUAIRE.png) !important; }
.inria-tool-tickets { background-image: url(<?php echo $tools_url; ?>TICKETS.png) !important; }


/* Agenda */
.event_add_or_remove_form #group_id { max-width: 50%; }

/* Texte des boutons :hover */
.elgg-menu-entity .elgg-menu-item-edit a:hover, .elgg-menu-entity .elgg-menu-item-edit a:focus, .elgg-menu-entity .elgg-menu-item-edit a:active { color: black; text-shadow: none; }
.elgg-button:hover, .elgg-button:active, .elgg-button:focus { color: #666; text-shadow: none; }


/* Group chat */
.groupchat-grouplink-theme .fa-comments-o { color: #999; }
.groupchat-grouplink-theme .fa-comments {  }

/* Impression */
.elgg-print-message { display:none; }
.footer-inria .print-page { float:left; color:white; margin: 26px 0 10px 0; font-size: 0.75rem; }

pre, code, blockquote { background-color: #F8F4F5; font-family: Neo Sans Std,Arial; font-size: 0.875rem; }


/* Folders (masquer réglage) */
/* #file_tools_structure_management_enable, label[for="file_tools_structure_management_enable"] { display: none; } */

#profile_manager_profile_edit_tabs { clear:left; }

.elgg-menu-item-postbymail { display:none; }

/* Twitter intent link generator */
.inria-twitter-intent { border: 1px solid #DDD; padding: 1rem 2rem; display: inline-block; border-radius: 0rem; margin: 1rem; }
.inria-twitter-intent a { font-size: 1.4rem; font-weight: 200; color: #BBB; text-decoration: none; }
.inria-twitter-intent a:hover, .inria-twitter-intent a:active, .inria-twitter-intent a:focus { color: #999; }
.inria-twitter-intent a.inria-twitter-intent-click { font-size:0.8rem; font-weight:bold; color:#999; float:right; text-transform: uppercase; margin-top: 0.5rem; }
.inria-twitter-intent a.inria-twitter-intent-click:hover, .inria-twitter-intent a.inria-twitter-intent-click:focus, .inria-twitter-intent a.inria-twitter-intent-click:active { color:#666; }
.inria-twitter-intent a.inria-twitter-intent-click .fa-twitter { color: #5BD; }





@media (max-width:980px) {
	.elgg-menu-topbar { position:absolute; top: 11px; right:5px; margin-left: 140px; }
	.menu-topbar-toggle { color: white; }
	
	.profile-col-profile { width:40%; }
	.profile-col-details { width:60%; }
	.profile-col-activity { width:100%; }
	.profile-col-profile2 { width:33%; }
	.profile-col-largedetails { width:66%; }
	
}

@media (max-width:700px) {
	.elgg-menu-topbar { margin-left: 0; }
	.footer-logo-inria { margin: 12px 0; }
	
	.profile-col-profile, .profile-col-details { width:46%; }
	.profile-col-activity { width:100%; }
	.profile-col-profile2, .profile-col-largedetails { width:100%; }
	.profile-col-profile .profile { floatabl:none; :40%; }
	
}



