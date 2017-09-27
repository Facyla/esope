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



// Iris v2 fonts override
// Codes couleurs
$iris_blue = "#1488CA";
$iris_sidegrey = "#3C4458";
$iris_topgrey = "#454C5F";
$iris_textgrey = "rgba(255,255,255,0.5)";
$iris_texttopgrey = "#384257";
/* Used colors in Iris v2 theme
$iris_lightgrey = "#969696";
#6C6C6C
*/

$titlecolor = $iris_blue;



$module_title_color = $titlecolor;
$module_bg_color = $color2;
// Force settings
$module_title_color = '#6D2C4F';
$module_bg_color = '#F8F4F5';

// Main width (on desktop screen)
$main_width = "80%";
$main_maxwidth = "80%";

/* DIMENSIONS
- navigation : fixe 12.5rem / 200px
- sidebar 1 : flex 0 1 20rem 15-20rem / 240-320px
- sidebar 2 : flex 0 1 20rem 15-20rem / 240-320px
- principal : flex 1 1 33rem 28-46rem / 448-736px
*/


// @TODO Bug Safari : normalement on utilise flex x x 0%  MAIS sur safari le conteneur ne s'adapte pas et considère que la base est de 0. 
// Pose des pbs sur l'accueil, et sur les pages de contenus en vue complète notamment
// Ca fonctionne moins mal avec 0 ou auto mais crée d'autres effets de bord ailleurs (liste des feedbacks par ex.)
// Pb avec 0% : la compression CSS la transforme en 0, qui ne marche pas...
// Note : une solution semble d'ajouter flex-basis: 0% ou auto ? à chaque utilisation de flex-direction column : voir si pas d'effet de bord ?
/* Pages concernées : accueil, profil membre, listing des feedbacks... */
$width = array(
	/*
	'navigation' => "min-width: 12.5rem; max-width: 12.5rem; flex: 0 0 12.5rem;",
	'sidebar' => "min-width: 15rem; max-width: 20rem; flex: 1 1 15rem; margin: 0 2.5rem 2.5rem 0;",
	'sidebar_alt' => "min-width: 15rem; max-width: 20rem; flex: 1 1 15rem; margin: 0 2.5rem 2.5rem 0;",
	'main' => "min-width: 28rem; max-width: 46rem; flex: 1 1 28rem; margin: 0 2.5rem 2.5rem 0;",
	*/
	'navigation' => "min-width: 12.5rem; max-width: 12.5rem; flex: 0 0 12.5rem;",
	'sidebar' => "min-width: 15rem; max-width: 22rem; flex: 1 1 0%; margin: 0 2.5rem 2.5rem 0;",
	'sidebar_alt' => "min-width: 15rem; max-width: 22rem; flex: 1 1 0%; margin: 0 2.5rem 2.5rem 0;",
	'main' => "min-width: 28rem; max-width: 46.5rem; flex: 2 1 0%; margin: 0 2.5rem 2.5rem 0;",
	'col' => "min-width: 28rem; max-width: 46.5rem; flex: 1 1 0%; margin: 0 2.5rem 2.5rem 0;",
);

?>

/* <style> /**/


* { box-sizing: border-box !important; }

/* Main width */
.elgg-page-default {
	/* min-width: 800px; */
}
.elgg-page { background: #F1F1F1; }
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


/* LAYOUTS */

#iris-topbar { position:fixed; top:0; left:0; right:0; height:5rem; z-index: 500; display: flex; flex-direction: row; /* max-width: 113rem; */ }
.iris-logo { <?php echo $width['navigation']; ?> height:5rem; background: <?php echo $iris_topgrey; ?>; }
.iris-topbar-menu { max-width: 100.5rem; }

#iris-navigation { <?php echo $width['navigation']; ?> min-height: 100vh; display:flex; flex-direction:column; background: <?php echo $iris_sidegrey; ?>; padding: 1rem 1rem; }
#iris-topbar .menu-navigation-toggle { padding: 0.75rem 1.5rem 0.75rem 1rem; z-index: 2; flex: 0 0 1.5rem; margin-right: -1.5rem; }
#iris-navigation .menu-navigation-toggle { font-size: 1rem; padding: 0.5rem 0 0.5rem 1rem; font-weight: normal; }
#iris-navigation.menu-enabled { display: flex; }

#iris-page { display:flex; flex-direction:row; margin-top: 5rem; background: #F1F1F1; }

#iris-body { max-width: 100.5rem; width: 100%; }

.elgg-layout { display: flex; flex-wrap: wrap; padding: 0 0 0 2.5rem; margin-top: 2.5rem; }
.elgg-layout.elgg-context-profile { padding-left: 0; margin-top: 0; }
.elgg-layout.elgg-context-profile.elgg-context-profile_edit { padding-left: 2.5rem; margin-top: 2.5rem; }
.elgg-layout-group { display: flex; flex-direction: row; flex-wrap: wrap; margin-top: 2.5rem; }
.elgg-layout-group-add { display: flex; flex-direction: row; flex-wrap: wrap; padding: 0; margin-top: 0; }


/* Sidebars */
.elgg-sidebar, .iris-search-sidebar { <?php echo $width['sidebar']; ?> }
.elgg-page .elgg-layout .sidebar-alt.menu-enabled, 
.elgg-page .elgg-layout .elgg-sidebar.menu-enabled { display: block; }

/* Main content */
.iris-cols { display:flex; flex-direction:row; flex-wrap: wrap; /* max-width: 100.5rem; */ width: 100%; /* justify-content: space-evenly; */ justify-content: space-around; justify-content: flex-start; }
.iris-cols.form-groups-add { padding: 0 0 0 2.5rem; }
.elgg-context-profile .iris-cols { padding: 0 0 0 2.5rem; margin-top: 2.5rem; }
.iris-col { <?php echo $width['col']; ?> padding: 0 0; /* margin: 0 auto; */ }
.iris-col:last-of-type { /* margin: 0 auto 0 0; */ }

/* Colonnes égales */
/*
.elgg-context-main .iris-col { display: flex; flex-direction: column; flex-basis: 0%; }
*/
.elgg-context-main .iris-col { display: block; }
.iris-box:last-of-type { flex: 1; display: flex; flex-direction: column; flex-basis: 0%; }


.elgg-main { <?php echo $width['main']; ?> min-height: initial; }

.elgg-layout-one-column .elgg-main { max-width: initial; margin-right: 0; }
.elgg-context-dashboard > .elgg-main { padding: 0; }
.elgg-layout-one-sidebar .elgg-main { <?php echo $width['main']; ?> }
#iris-body .elgg-main { padding:0; background: transparent; }


#iris-body .elgg-layout-one-sidebar.elgg-context-invite_external .elgg-main, 
#iris-body .elgg-layout-one-sidebar.elgg-context-messages .elgg-main, 
#iris-body .elgg-layout-user-owner:not(.elgg-layout-content) .elgg-main { <?php echo $width['main']; ?> background: white; padding: 2rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }

#iris-body .elgg-layout-one-sidebar.elgg-layout-user-owner.elgg-context-friend_request .elgg-main, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-blog-save, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-bookmarks-save, 
.elgg-context-event_calendar #calendar, 
.elgg-layout-one-sidebar:not(.elgg-layout-group) .elgg-form-event-calendar-edit, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-pages-edit, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-poll-edit { background: white; padding: 2rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-newsletter-edit, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-form-file-upload { background: white; padding: 2rem; border-radius: 0 0 4px 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-menu-newsletter-steps, 
.elgg-layout-one-sidebar.elgg-layout-user-owner .elgg-main #file-tools-upload-tabs { margin-bottom: 0; }
#iris-body .elgg-layout-user-owner.elgg-context-friends .elgg-main { background: none; padding: 0; box-shadow: none; }
#iris-body .iris-search .elgg-main { <?php echo $width['main']; ?> }
#iris-body .iris-listing .elgg-main { width: 100%; padding: 0; display: flex; flex-wrap: wrap; }
#iris-body .elgg-layout-one-sidebar .elgg-main { /* padding: 2.5rem 0 0 0; */ }
#iris-body .elgg-layout-one-sidebar.elgg-context-settings .elgg-main { <?php echo $width['main']; ?> background: white; padding: 2rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
#iris-body .elgg-layout-one-column.elgg-context-profile_edit .elgg-main { <?php echo $width['main']; ?> width: 100%; margin: 2.5rem auto; float: none; padding: 0 2.5rem 3rem 2.5rem; background:white; display: flex; flex-wrap: wrap; flex-direction: column; flex-basis: 0%; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
#iris-body .elgg-layout-one-column.elgg-context-avatar.elgg-context-profile_edit .elgg-main { margin-top: 0; background: none; box-shadow: none; padding: 0; }
#iris-body .iris-group .elgg-main { background: white; padding: 2rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; }
/*
#iris-body .iris-group div:not(.elgg-context-groups) .elgg-main { <?php echo $width['main']; ?> }
*/
#iris-body .iris-group .elgg-context-group_workspace .elgg-main { background: transparent; border: 0; padding: 0; box-shadow: none; padding: 4px; margin: -4px calc(2.5rem - 4px) calc(2.5rem - 4px) -4px; }
#iris-body .iris-group .elgg-context-group_content .elgg-main { <?php echo $width['main']; ?> padding: 4px 4px 4px 4px; /* margin-left: 4.675rem; */ }
#iris-body .elgg-layout-user-owner .elgg-main .iris-object-full { background: white; padding: 2rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; margin: 0; }

.group-profile-main { margin-bottom: 2rem; background: white; padding: 2rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 0 0 4px 4px; }

.elgg-body-transp { <?php echo $width['main']; ?> display: flex; flex-direction: column; flex-basis: auto; margin: 0 2.5rem 2.5rem 0; }
.elgg-body-transp .elgg-main { flex-basis: auto; }
.elgg-body-transp .elgg-main, 
#iris-body .iris-group .elgg-body-transp .elgg-main { margin: 0; }

#iris-body .iris-group .elgg-context-group_edit .elgg-main, 
#iris-body .iris-group .elgg-context-group_members .elgg-main, 
#iris-body .iris-group .elgg-context-group_invites .elgg-main, 
#iris-body .iris-group .elgg-context-group_profile .elgg-main { margin-top: -4px; padding: 4px; box-shadow: none; background: transparent; }

/* Fullscreen screens */
.full-screen #iris-body .iris-group .elgg-main { position: absolute; top: 0; left: 0; right: 0; z-index: 1111; margin: 3rem 5rem; padding: 3rem 2rem; }






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

.elgg-access {     line-height: 1.4rem; }
.elgg-autocomplete-item .elgg-access a { display: none; }
.ui-autocomplete li.ui-menu-item { border-radius: 0; padding: 0.3rem 0.5rem 0.1rem 0.5rem; }
.ui-autocomplete li.ui-menu-item a { padding:0; }
.elgg-image-block.elgg-autocomplete-item { padding: 0; }
.elgg-image-block.elgg-autocomplete-item .elgg-image { margin-right: 0.3rem; }



/* Header */
body { border-top:0; background:white; font-size:16px; }
body.cke_editable { font-size:16px; }
section { background:white; }
.elgg-page-header { background: #6F2D50 !important; border-top: 0; height:auto !important; }
.elgg-page-header .elgg-inner h1 { margin: 0; padding:0; font-size:1rem; }

.elgg-form-login, .elgg-form-account { max-width: none; }
#iris-body .elgg-context-login .elgg-main, #iris-body .elgg-context-register .elgg-main { max-width: 46.5rem; border: 1px solid #CCCCCC; padding: 0.5em 1em; margin-top: 2em; background: #F6F6F6; margin: 0 auto; }
.elgg-layout.elgg-context-login .elgg-module-aside { float: none; width: auto; }
#adf-homepage .elgg-main { margin: auto; float: none; }
#adf-homepage .inria-login a, #adf-homepage .inria-login a:visited { color: white; }
#adf-homepage .inria-login a:hover, #adf-homepage .inria-login a:focus, #adf-homepage .inria-login a:active { color: #FFF; text-shadow:none; }
.cas-login { float:left; }
.basic-login { float:right; }
.cas-login, .basic-login { margin: 0 0.5rem 1rem 0.5rem; }
#adf-persistent { margin: 0.5rem 0; }
.adf-lostpassword-toggle { font-weight: bold; font-size: 0.85rem; padding: 0.5rem 0 0 0; display: inline-block; }
.basic-login-toggle, #adf-homepage .inria-login .basic-login-toggle { float:right; color: white; }
.elgg-context-login .elgg-module-aside { float: right; width: 50%; }

/* Main menu */
.elgg-page-header { background: <?php echo $module_bg_color; ?>; border: 0; box-shadow: none; min-height: 37px; }

/* Search */
input:focus, textarea:focus { background: #FFFAF0; }
.elgg-page-header form, #iris-navigation form { /* float: right; */ border: 0; border-radius: 0; box-shadow: none; margin-top: 5px; }
#iris-navigation form input#esope-search-input { height: 27px; border: 1px solid #EF783E; border-radius: 0; color: #EF783E; font-weight:bold; }
#iris-navigation form input#esope-search-input:active, #iris-navigation form input#esope-search-input:focus { color: #EF783E; }
#iris-navigation form input#esope-search-submit-button { background: #EF783E; border-color: #EF783E; border-radius: 0; }
#iris-navigation form input#esope-search-submit-button:hover, #iris-navigation form input#esope-search-submit-button:active, #iris-navigation form input#esope-search-submit-button:focus { background-color: #6D2C4F; border: 1px solid #6D2C4F; }

/* Members search */
.esope-search-metadata { width: 30%; height:auto; min-height: 3rem; border-left: 1px solid #ccc; padding: 0.5%; background: #f0f0f0; margin-right: 2%; margin-bottom: 0.5rem; }
/* Search filters */
.search-filter-menu { padding:6px; margin:4px 0; border:1px dotted #CCC; }
.search-filter-menu a { padding:2px 4px; margin: 0 10px 6px 0; background: #F8F4F5; display: inline-block; }

/* Members menu */
.elgg-menu-item-members { background-image: none; }

/* Sidebar */
.elgg-sidebar { border-left: 0px dotted #CCC; }
.elgg-context-groups .elgg-sidebar { /* border-left: 1px dotted #CCC; padding-top:1%; */ }
.elgg-sidebar .elgg-module-aside h3 { font-size: 1.125rem; padding: 0; color: #384257; }

/* Titre objets dans les widgets notamment */
.elgg-module .entity_title { font-size: 0.875rem; }

/* Titre listing des groupes */
.groups-profile-icon .au_subgroups_group_icon-large { height: auto; width: auto; }
.groups-profile-icon .au_subgroups_group_icon-large img { height: auto; width: auto; max-height: 100px; max-width: 200px; }
.elgg-context-groups .elgg-list-entity h3 { /* font-size: 1rem; display:inline-block; */ display:inline; }
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
.elgg-button.elgg-button-action { font-family: <?php echo $font2; ?>; border: 0; background: <?php echo $iris_blue; ?>; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; font-family: "Inria Sans", sans-serif; text-shadow: none; /* transition-duration:0.2s; */ opacity:0.5; }
.elgg-button.elgg-button-action:hover, .elgg-button.elgg-button-action:active, .elgg-button.elgg-button-action:focus { border: 0; background: <?php echo $iris_blue; ?>; color:white; opacity:1; }

.elgg-button.elgg-button-submit { font-family: <?php echo $font2; ?>; border: 0; background: <?php echo $iris_blue; ?>; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; font-family: "Inria Sans", sans-serif; text-shadow: none; /* transition-duration:0.2s; */ opacity:0.5; }
.elgg-button.elgg-button-submit[name=preview] { background-color: #384257; }
.elgg-button.elgg-button-submit:hover, .elgg-button.elgg-button-submit:active, .elgg-button.elgg-button-submit:focus { border: 0; background: <?php echo $iris_blue; ?>; color:white; opacity:1; }

.elgg-button.elgg-button-cancel { font-family: <?php echo $font2; ?>; border: 0; background: #DDDDDD; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; font-family: "Inria Sans", sans-serif; text-shadow: none; /* transition-duration:0.2s; */ opacity:0.5; }
.elgg-button.elgg-button-cancel:hover, .elgg-button.elgg-button-cancel:focus, .elgg-button.elgg-button-cancel:active { color:white; opacity:1; }

.elgg-button.elgg-button-delete { font-family: <?php echo $font2; ?>; border: 0; background: #FF0000; color:white; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; font-family: "Inria Sans", sans-serif; text-shadow: none; /* transition-duration:0.2s; */ opacity:0.5; box-shadow:none; }
.elgg-button.elgg-button-delete:hover, .elgg-button.elgg-button-delete:active, .elgg-button.elgg-button-delete:focus { border: 0; color:white; opacity:1; }
.elgg-button-comment-toggle { margin-top: 1rem; }
.group-workspace-add-tabs a.workspace-button-join { background: white; color: #384257; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; vertical-align: baseline; display: inline-block; text-decoration: none; }


/* Page d'accueil */
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
.wire-input { display: flex; }
.home-wire #thewire-textarea { margin-top: 0; height: 4em; width: calc(100% - 4rem); flex: 1 1 auto; }
.home-wire .thewire-form { padding: 0; }
.home-wire .thewire-form .elgg-button-submit { margin-top:3px; }
.elgg-context-thewire .thewire-form select, 
.home-wire .thewire-form select { margin: 0.25rem 0 0.25rem 3.5rem; padding: 0.25rem; max-width: 10rem; }

.home-wire, .home-activity { background:white; padding:0; }
.home-wire h2 a, .home-activity h2 a { font-size:1.375rem; margin-bottom: 0; color:<?php echo $titlecolor; ?>; }
.home-wire .elgg-list-access, .home-activity .elgg-list-access { display: none; }
.iris-add-button { font-weight: bold; padding: 11px 0px; border: thin dotted <?php echo $titlecolor; ?>; background-color: #F8F4F5; width:100%; text-align:center; display:block; }
.home-activity .elgg-list .elgg-item .elgg-image-block { margin-left: -1rem; }
.home-activity .elgg-river-responses .elgg-list .elgg-item .elgg-image-block { margin: 0; }
.home-activity .elgg-river-responses .elgg-list .elgg-item .elgg-image-block .elgg-image { margin-right: 0.5rem; }
.home-activity .elgg-menu-item-access { margin-top: 0; }
.home-activity .elgg-item .elgg-content { margin: 6px 0px 2px 0px; }
.elgg-menu-river > li > a {  }
.elgg-list-river > li:hover { background-color: transparent !important; }
.home-activity .elgg-list-river > li:hover { background-color: #FFFFFF; }
.home-activity .elgg-river-attachments, .home-activity .elgg-river-message, .home-activity .elgg-river-content { margin: 2px 0 0px 0; }
.elgg-river-attachments, .elgg-river-message, .elgg-river-content { border-left: 0 !important; padding-left: 0; /* border-left: 1px solid #666; */ }
/* The Wire */
.thewire-inria-info { margin: 12px auto 24px auto; border: 1px solid grey; padding: 10px 20px; font-size: 1.1em; width: 70%; }
.elgg-form-thewire-group-add .elgg-foot { padding: 0 0 0.5em 0; }
/*
.elgg-form-thewire-group-add #thewire-textarea { width: 80%; float: left; height: 3em; margin-top: 0; }
*/
.elgg-form-thewire-group-add #thewire-textarea { height: 4em; padding: 1px 3px; }
.elgg-form-thewire-group-add #thewire-characters-remaining span { margin: 0 12px 0 0; float:none; font-size: 1.2em; }
.thewire-remaining-message { color: red; }
.elgg-form-thewire-group-add .elgg-button-submit { margin-top: 0; }
.theme_inria-thewire-group-add {}
.theme_inria-thewire-group-add h3 { margin-top: 20px; }
.elgg-form-thewire-group-add select { margin: 0.25rem 0 0.25rem 0; padding: 0.25rem; max-width: 10rem; }

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
.full-width-pages-nav { color: white; padding: 1.5rem; border-radius: 4px 4px 0 0; background-color: rgba(56, 66, 87, 0.5); box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); margin: -2rem -2rem 1rem -2rem; }
.elgg-layout-user-owner .full-width-pages-nav { margin: 0rem -2rem 2rem -2rem; }
.full-width-pages-nav a[rel=toggle] { color: white; font-weight: bold; }
.full-width-pages-nav a[rel=toggle] .fa { margin-right: 1rem; }
#full-width-pages-nav-content { margin-top: 0.5rem; }
.treeview { background: white; }
.treeview.pages-nav a { color: #384257; }
.pages-nav.treeview a:hover, .pages-nav.treeview a:active, .pages-nav.treeview a:focus { color: #384257; }
.treeview li { font-size: 1rem; }
.elgg-body-transp .elgg-image-block { margin: 0 -2rem 2rem -2rem; padding: 0 2rem 1rem 2rem; border-bottom: 2px solid #F1F1F1; }
.elgg-body-transp .elgg-content .elgg-output { margin: 0 -2rem 0rem -2rem; padding: 0 2rem 0rem 2rem; /* border-bottom: 2px solid #F1F1F1; */ }
.elgg-body-transp #group-replies .elgg-content .elgg-output { margin: 0; padding: 0; border-bottom: 0; }
#group-replies.elgg-comments .elgg-list > li { margin: 0; }
.elgg-body-transp .esope-subpages-menu { margin: 0 0rem 2rem 0rem; padding: 1rem 0 0rem 0; border-top: 2px solid #F1F1F1; border-bottom: 2px solid #F1F1F1; }
.elgg-body-transp .pages-subpages .esope-subpages-menu { margin: 0 -2rem 0rem -2rem; padding: 0 2rem 0rem 2rem; border-top: 0; }
.elgg-body-transp .comment_trackerWrapper { margin: 2rem -2rem 2rem -2rem; padding: 2rem 2rem 0rem 2rem; border-top: 2px solid #F1F1F1; }

.views-counter-container.views_counter { background: rgba(56,66,87,.5); color: white; border-radius: 4px; border: 0; padding: 0.1rem 0.25rem; margin: 0 0 0.25rem 0.25rem; }
.views_counter a { color: white; }


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
.elgg-menu-group-filter > .elgg-state-selected,
.elgg-menu-group-filter > li:hover,
.elgg-menu-group-filter > li:active,
.elgg-menu-group-filter > li:focus, { border-color: #ccc; background: white; }
.elgg-menu-group-filter > .elgg-state-selected > a,
.elgg-menu-group-filter > li:hover > a,
.elgg-menu-group-filter > li:hover > a,
.elgg-menu-group-filter > li:hover > a { position: relative; top: 2px; background: white; }
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
.iris-profile-icon, 
.elgg-avatar img { border: 1px solid transparent; /* background-size: calc(100% - 2px) !important; */ border-radius: 50% !important; }
.elgg-avatar.profile-type- img, 
.elgg-avatar.profile-type-inria img { border: 1px solid transparent; }
.elgg-avatar.profile-type-external img { border: 1px solid #F7A621; padding: 1px; }
.elgg-avatar.profile-type-archive img { border: 1px solid #384257; padding: 1px; }
/* Bordure large seulement sur page de profil */
.elgg-avatar.elgg-avatar-large.profile-type-inria img, 
.elgg-avatar.elgg-avatar-medium.profile-type-inria img { border: 3px solid transparent; padding: 3px; }
.elgg-avatar.elgg-avatar-large.profile-type-external img, 
.elgg-avatar.elgg-avatar-medium.profile-type-external img { border: 3px solid #F7A621; padding: 3px; }
.elgg-avatar.elgg-avatar-large.profile-type-archive img, 
.elgg-avatar.elgg-avatar-medium.profile-type-archive img { border: 3px solid #384257; padding: 3px; background-color: #384257; background-blend-mode: overlay; }
.iris-profile-icon.profile-type-external { border: 3px solid #F7A621; /* background-size: calc(100% - 6px) !important; */ /* background-color: #F7A621; background-blend-mode: multiply; */ }
.iris-profile-icon.profile-type-archive { border: 3px solid #384257; /* background-size: calc(100% - 6px) !important; */ background-color: #384257; background-blend-mode: overlay; }
/* 
.elgg-avatar.profile-type-external:after { background: #F7A621; content: ''; display: inline-block; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 12; }
.elgg-avatar.profile-type-archive:after { background: #384257; content: ''; display: inline-block; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 12; }
*/
.profiletype-badge { position: absolute; width: 100%; height: 100%; /* border: 3px solid transparent; */ }
.profiletype-badge-inria { position: absolute; right: 0px; bottom: 0; background: #e33729; color: white; padding: 4px 2px 0px 6px; border-radius: 8px 0 0 0; font-weight: bold; z-index: 11; }
.profiletype-badge-external { position: absolute; right: 0px; bottom: 0; background: #F7A621; color: white; padding: 0.15rem 0.15rem 0 0.4rem; border-radius: 0.5rem 0 0 0; font-weight: bold; z-index: 11; }

.iris-badge span { font-size: 0.9rem; text-transform: uppercase; font-family: "Inria Sans", sans-serif; padding: 0.75rem 1rem 0.5rem 1rem; border-radius: 1rem; font-weight: bold; margin: 0rem 0rem 0rem 1rem; vertical-align: top; color: white; }
.iris-badge-external { background-color: #F7A621; }
.iris-badge-archive { background-color: #384257; } 
h2 .iris-badge span { font-size: 0.9rem; }
h3 .iris-badge span { font-size: 0.75rem; padding: 0.5rem 0.75rem 0.35rem 0.75rem; }
.elgg-item-user h3 .iris-badge span { display: inline-block; margin: 0 0 0 0; }
.iris-object .iris-badge span { font-size: 0.75rem; padding: 0.3rem 0.5rem 0.2rem 0.5rem; }
.elgg-image .iris-badge { display: block; width: 100%; margin-top: 0.5rem; }
.elgg-image .iris-badge span { display: block; width: 100%; margin-top: 0.5rem; margin: 0; }
.elgg-item-user h3 .iris-badge { margin-top: 0.25rem; }

#esope-search-results .elgg-item-user .elgg-menu-entity { text-align: right; }
#esope-search-results .elgg-item-user .elgg-menu-entity > li { text-align: right; padding-left: 1rem; margin-right: 0; }
.elgg-menu-item-profile-manager-user-summary-control-entity-menu { width: 100%; }
.elgg-menu-item-profile-manager-user-summary-control-entity-menu .elgg-tag { margin: 0 0 0.25rem 0; }


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
#groupchat-sitelink { z-index: 900; }

/* Impression */
.elgg-print-message { display:none; }
.footer-inria .print-page { float:left; color:white; margin: 26px 0 10px 0; font-size: 0.75rem; }

pre, code, blockquote { background-color: #F8F4F5; font-family: Neo Sans Std,Arial; /* font-size: 0.875rem; */ }


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





/* NEW IRIS DESIGN v2 */

/* TOPBAR */
.iris-logo a { display: inline-block; }
.iris-logo img { height: 2.5rem; margin: 1.1875rem 4rem; }

.iris-topbar-menu { flex: 1 0 auto; background:white; display: flex; padding: 1rem; }
#iris-topbar .language_selector { position: initial; }
#iris-topbar .language-selector { flex: 0; padding: 0.75rem 1.5rem 0.75rem 1rem; }
#iris-topbar-search { flex: 1; font-size: 1.2rem; padding: 0.75rem 0 0.75rem 1.5rem; }
#iris-topbar-search button { border: 1px solid transparent; background: none; font-size: 1.2rem; float: left; }
#iris-topbar-search button svg { width:1.3125rem; height:1.3125rem; }
input#iris-topbar-search-input { width: auto; font-size: 1.2rem; }
input#iris-topbar-search-input:focus { width: auto; font-size: 1.2rem; }
.iris-topbar-item { flex:0 0 auto; position: relative; }
.iris-topbar-item a { font-size:1.375rem; font-weight:bold; color: <?php echo $iris_texttopgrey; ?>; padding: 0.75rem 1rem; display:inline-block; }
.iris-topbar-item.elgg-menu-topbar li a { font-size:1rem; font-weight:bold; color: <?php echo $iris_texttopgrey; ?>; text-shadow: none; margin: 0 0 0 0; display:inline-block; }
.iris-topbar-item.elgg-menu-topbar > li > a { padding:0; line-height: 2.5rem; }
.iris-topbar-item.elgg-menu-topbar > li > a > img { height: 2.5rem; }
.elgg-menu-topbar > li > ul { display: block; }
.iris-topbar-item a .fa { font-size: 1.375rem; }
.iris-topbar-item.elgg-menu-topbar ul { position: relative; padding-top: 0px; left: 0; top: 0; width: auto; margin: 0; background: white; }
.iris-topbar-item.elgg-menu-topbar-alt ul li { margin:0; }
.iris-topbar-item.elgg-menu-topbar  ul > li > a { background: white; margin:0; width: 100%; text-indent: 0.5em; padding:1rem 0; font-size: 0.875rem; }
.iris-topbar-item #user { margin: 0.5rem 0rem 0rem 1rem; }
.iris-topbar-item #user img { float: left; margin-right: 0.375rem; border-radius: 1.125rem; height: 2.25rem }
.login-as-arrow { vertical-align: 20%; color: black; margin: 0 -0.45rem; }

.iris-new { position: relative; bottom: 0.8rem; right: 0;height: 8px; /*  width: 8px; background: red; */ border-radius: 8px; display: inline-block; font-size: 8px; width: auto; color:red; text-align: center; vertical-align: middle; line-height: 8px; }

#notifications .notifications-panel { display:hidden; position: absolute; top: 2.5rem; right: -8rem; width: 38rem; z-index: 2; background: white; padding: 1rem 0; box-shadow: 0 0 4px 0; }
#notifications:hover .notifications-panel { display: block; }
#notifications .notifications-panel .tabs a { font-size: 0.9rem; background: white; margin: 0 0 0 2rem; padding: 0.5rem 0; color: #384257; opacity:0.3; border-bottom: 4px transparent; }
#notifications .notifications-panel .tabs a.elgg-state-selected,
#notifications .notifications-panel .tabs a:hover,
#notifications .notifications-panel .tabs a:active,
#notifications .notifications-panel .tabs a:focus { opacity:1; border-bottom: 4px solid; text-decoration: none; }
.iris-topbar-notifications-tab .iris-topbar-notifications-tab-content { min-height: 100px; padding: 1rem; max-height: 60vh; margin-bottom: 1rem; overflow: auto; }
.iris-topbar-notifications-tab-content .elgg-body { font-size: 0.9375rem; }
.iris-topbar-item .iris-topbar-notifications-tab a { padding: 0; font-weight: initial; font-size: 0.9rem; }
#notifications .elgg-item-object-site_notification { padding: 0 0 0.5rem 0; margin: 0.5rem 1rem 1rem 1rem; box-shadow: none; border: 0; }
#notifications .elgg-image-block .elgg-image { margin: 0 0.5rem 0 0; }
.notifications-pending-group-invites { border-bottom: 1px solid #DCDCDC; margin: 0 1rem; }
.elgg-image-block.notifications-pending-invitations { margin: 0.5rem 0 1rem 0; }
.notifications-pending-groups-requests { border-bottom: 1px solid #DCDCDC; padding: 1rem 0; margin: 0 1rem; }
#notificationstable td.sitetogglefield a { cursor: default; }

.elgg-layout-one-sidebar .elgg-main .elgg-form-site-notifications-process .elgg-list-container { /* background: transparent; padding: 0; */ }
.elgg-list .elgg-item.elgg-item-object-site_notification .elgg-image-block { display: block; }
#notifications .elgg-item-object-site_notification .elgg-image-block { display: flex; }
.elgg-form-site-notifications-process input[type="checkbox"] { margin: 1rem 1rem; }
.elgg-form-site-notifications-process .elgg-item-object-site_notification img, .elgg-form-site-notifications-process ul.elgg-list li.elgg-item-object-site_notification div.elgg-image a img { margin-right: 1rem; }
.elgg-item-object-site_notification .elgg-image-alt { order: 3; }

#friend_request_received_listing, 
#friend_request_sent_listing { padding: 1rem; margin: 0; }
#iris-body .elgg-layout-one-sidebar #friend_request_received_listing .elgg-head, 
#iris-body .elgg-layout-one-sidebar #friend_request_sent_listing .elgg-head { padding: 0; width: 100%; margin-bottom: 1rem; }
#friend_request_received_listing h3, 
#friend_request_sent_listing h3 { padding:0; color: #384257; }
/*
#friend_request_sent_listing .elgg-image-block { background: white; margin: 0 4px 1rem 0px; padding: 1rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; }
*/

.elgg-layout-one-sidebar.elgg-context-friends .elgg-main .elgg-list-container { background: transparent; box-shadow: none; padding: 0; }

#friends_collections_accordian li { background: white; margin: 0 4px 1rem 0px; padding: 1rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; }

.elgg-layout-one-sidebar .elgg-main .elgg-form-messages-process .elgg-list-container { background: transparent; padding: 0; box-shadow: none; }
/* .elgg-form-messages-process .elgg-item { padding: 1rem 0; box-shadow: none; margin: 0; } */
.elgg-item-object-messages .elgg-image-block { display: flex; }
.elgg-form-messages-process input[type="checkbox"] { margin: 0.5rem 1rem 0 0; }
.elgg-list-entity .messages-owner { float: none; width: 100%; line-height: 2rem; margin-bottom: 0.5rem; }
.elgg-list-entity .messages-owner .elgg-avatar { float: left; margin-right: 0.5rem; }
.elgg-list-entity .messages-subject { float: none; width: 100%; display: inline-block; width: auto; }
.elgg-list-entity .messages-timestamp { float: none; width: 100%; display: inline-block; width: auto; }
.elgg-list-entity .messages-delete { float: right; width: 2em; }
.elgg-list-entity .messages-reply { margin-top: 0.5rem; }
.elgg-context-messages .messages-container .elgg-list-entity li { padding: 0rem 0rem 1rem 0; border-radius: 0px; }
#iris-body .elgg-layout-one-sidebar.elgg-context-messages .elgg-main li.elgg-item-message { padding: 0; margin: 0; }
.elgg-form-messages-process .select-all { padding-bottom: 1rem; border-bottom: 1px solid #DCDCDC; }


.elgg-sidebar ul.elgg-menu-page { margin-bottom: 1rem; float: none; background: transparent; }
.elgg-sidebar ul.elgg-menu-page:last-of-type { margin-bottom: -1rem; }
.elgg-sidebar ul.elgg-menu-page li { float: none; margin-bottom: 1rem; }
.elgg-sidebar ul.elgg-menu-page li a { display: inline-block; padding: 0.5rem 0; }

.elgg-menu-owner-block {  }

.elgg-menu-owner-block li {  }

.elgg-menu-owner-block li a, 
.elgg-sidebar ul.elgg-menu-page li a { color: #384257; font-size: 1.0rem; font-weight: normal; background: transparent; padding: 0; }

.elgg-menu-page .elgg-state-selected a, .elgg-menu-page a:hover, .elgg-menu-page a:focus, .elgg-menu-page a:active, 
.elgg-menu-owner-block li.elgg-state-selected a, 
.elgg-menu-owner-block li a:hover, 
.elgg-menu-owner-block li a:active, 
.elgg-menu-owner-block li a:focus { font-weight:bold; background: transparent; color: #384257; }
.elgg-sidebar ul.elgg-menu-page .elgg-state-selected a, 
.elgg-sidebar ul.elgg-menu-page a:hover, 
.elgg-sidebar ul.elgg-menu-page a:focus, 
.elgg-sidebar ul.elgg-menu-page a:active { color: #384257 !important; font-weight:bold; background: transparent; }
.elgg-menu-page li.elgg-state-selected { background: none; }

.group-workspace-sidebar-membership { margin-top: 2rem; margin-bottom: 1.75rem; }
#iris-body .iris-group-sidebar .group-workspace-sidebar-membership a { color: white; }


.elgg-menu-filter { margin-bottom: 1.625rem; border: 0; }
.elgg-menu-filter > li { background: transparent; padding:0; margin:0 2.5rem 0 0; border:0; }
.elgg-menu-filter > .elgg-state-selected { background: transparent; }
.elgg-menu-filter li a { font-size: 1.125rem; height: auto; border-bottom: 4px solid transparent; color: rgba(56, 66, 87, 0.3); font-weight: bold; padding: 0 0 0.8rem 0; }
.elgg-menu-filter > .elgg-state-selected a { top:initial; border-bottom: 4px solid; background: transparent; color: #384257; }
.elgg-menu-filter > li:hover, .elgg-menu-filter > li:focus, .elgg-menu-filter > li:active { background:transparent; }
.elgg-menu-filter > li > a:hover, .elgg-menu-filter > li > a:focus, .elgg-menu-filter > li > a:active { background:transparent; color: #384257; }

.elgg-menu-navigation { z-index:2; background: <?php echo $iris_sidegrey; ?>; }
#iris-navigation ul.elgg-menu-navigation li, #iris-navigation ul.elgg-menu-navigation li:first-child { border:0; float: none; }
#iris-navigation ul.elgg-menu-navigation li a { width: 100%; padding: 1rem 0 0.5rem 0; text-indent: 1rem; text-transform:uppercase; text-decoration: none; color: <?php echo $iris_textgrey; ?>; font-family: "Inria Sans", sans-serif; font-size: 0.95rem; margin: 0 0 0 0; }
.elgg-menu-topbar li a svg { height:1.25rem; vertical-align: middle; margin-right: 0.5rem; fill: <?php echo $iris_texttopgrey; ?>; }
.elgg-menu-navigation li a svg { height:1.25rem; vertical-align: bottom; margin-right: 0.5rem; fill: <?php echo $iris_textgrey; ?>; }
#iris-navigation ul.elgg-menu-navigation li a.active, #iris-navigation ul.elgg-menu-navigation li a.elgg-state-selected, #iris-navigation ul.elgg-menu-navigation li a:hover, #iris-navigation ul.elgg-menu-navigation li a:focus, #iris-navigation ul.elgg-menu-navigation li a:active { color: white; }
.elgg-menu-navigation li a.active svg, .elgg-menu-navigation li a.elgg-state-selected svg, .elgg-menu-navigation li a:hover svg, .elgg-menu-navigation li a:focus svg, .elgg-menu-navigation li a:active svg { fill:white; }
#iris-navigation ul.elgg-menu-navigation li ul { background: transparent; margin-bottom: 0.5rem; left: 0px; box-shadow:none; }
#iris-navigation ul.elgg-menu-navigation li ul li { background: transparent; }
#iris-navigation ul.elgg-menu-navigation li ul li a { border-bottom: 0; text-transform: none; font-weight: normal; font-size: 0.875rem; padding: 0.5rem 0.75rem; color: <?php echo $iris_textgrey; ?>; width: 100%; display: inline-block; padding: 0.3rem 0; margin: 0; }
#iris-navigation ul.elgg-menu-navigation li ul li a:hover, #iris-navigation ul.elgg-menu-navigation li ul li a:focus, #iris-navigation ul.elgg-menu-navigation li ul li a:active { color: white; }
.elgg-state-selected ul.hidden { display: block !important; }
.elgg-menu-navigation li.elgg-state-selected > a { color: white !important; }
.elgg-menu-navigation .fa.fa-angle-down { float: right; }


#iris-body h2 { padding: 0rem 0 0 0; margin-bottom: 1rem; margin-right: 0; font-size: 2rem; font-weight: normal; font-family:"Inria Serif", serif; }
#iris-body .iris-listing h2 { /* margin-top: 2.5rem; */ width: 100%; padding:0; }
#iris-body .iris-box h2 { font-size: 1.75rem; }
#iris-body .elgg-sidebar h2 { padding-top: 0; margin-bottom:2.5rem; }

#iris-body .elgg-layout-one-sidebar h2.elgg-heading-main { margin:2.5rem 0 1rem 0; }
#iris-body .iris-listing .elgg-layout-one-sidebar .elgg-main h2 { padding-top: 0; margin:0 0 2rem 0; }
#iris-body .elgg-layout-one-sidebar .elgg-head { padding: 0 2.5rem 0rem 2.5rem; float: left; min-width: 20rem; width: 30%; }
#iris-body .elgg-layout-one-sidebar .elgg-module .elgg-head { float: none; }
.elgg-sidebar .elgg-module-aside { float: none; }

#iris-body .elgg-layout-one-sidebar.elgg-context-settings .elgg-module-info .elgg-head { float: none; width: auto; margin-bottom: 1rem; padding: 0.5rem; }
#iris-body .elgg-layout-one-sidebar.elgg-context-settings .elgg-module-info .elgg-body { margin-bottom: 2rem; }


#iris-footer { /* margin-top: auto; */ position: absolute; bottom: 0; <?php echo $width['navigation']; ?> }
.footer-inria { padding:1rem 2rem; }
#iris-footer li a { color:<?php echo $iris_textgrey; ?>; width: 100%; text-indent: 0rem; display: inline-block; padding: 0.2em 0; margin: 0.1em 0; font-size: 0.94rem; }
#iris-footer .language_selector { display: inline-block; position: initial; width:100%; }
#iris-footer .language_selector a { display: inline; }
#iris-footer li a.inria-intranet { color:#95C11F; }


/* Accueil */
.iris-home-my-groups { display: flex; flex-wrap: wrap; justify-content: space-between; }
.iris-home-group { display: inline-block; margin: 0 0.6rem 0.3rem 0; }
.iris-home-group:last-of-type { margin-right: 0; }
.iris-home-group img, .iris-home-group a { width:5rem; height:5rem; display: inline-block; }
.iris-home-discover-groups { display: flex; justify-content: space-between; }
.iris-home-group-category { float:left; width: 5rem; height: 8rem; border: 1px solid <?php echo $iris_blue; ?>; padding: 0.5rem 0.125rem; margin: 0 0.7rem 0.3rem 0; text-align: center; color:<?php echo $iris_blue; ?>; font-weight:normal; font-size:0.8rem; flex: 1 1 auto; max-width: 6rem; min-width: 4rem; }
.iris-home-group-category:last-of-type { margin-right: 0; }
.iris-home-group-category img { width: 4rem; height: 4rem; margin: 0.5em 0 0.5em 0; }
.iris-home-group-category a { text-decoration:none; }

/* Profile */
.iris-profile-header { position: relative; background: #243546; height:15rem; background-blend-mode: multiply; }
.iris-profile-icon { position: relative; top: 4rem; left: 3rem; width: 13rem; height: 13rem; z-index: 2; border-radius: 13rem; display:flex; background-repeat: no-repeat; background-position: center; background-size: cover; }
.iris-profile-title { position: absolute; top: 5rem; left: 20rem; color: white; }
#iris-body .iris-profile-title h2 { color: white; font-size:2.5rem; padding:0; margin-bottom: 0.75rem; }
.iris-profile-info { background: white; font-size:0.75rem; color: #969696; margin-bottom: 1rem; padding: 1rem 1rem 1rem 20rem; text-transform: uppercase; font-weight: bold; display:flex; flex-wrap: wrap; }
.iris-profile-info a {  }
.iris-profile-info-field { flex: 0 1 auto; margin-right: 3rem; max-width: 16rem; }
.iris-profile-info-field:last-of-type { margin-right: 0; }
.iris-profile-info-field strong, .iris-profile-info-field a { color: #384257; text-transform: initial; display: inline-block; padding-top: 0.5rem; font-size: 0.94rem; }
.iris-profile-info-field .elgg-tags > li { margin-bottom:0; }

.iris-profile-submenu { background: white; font-size:0.75rem; color: #969696; margin-bottom: 1rem; padding: 0rem 0rem 0rem 0rem; /* text-transform: uppercase; */ font-weight: bold; display:flex; min-height: 3rem; }
.iris-profile-submenu .elgg-menu-owner-block li { float: left; margin-right: 0rem; }
.iris-profile-submenu .elgg-menu-owner-block li a { color: #384257; /* font-size: 1.125rem; */ padding: 2.375rem 0 1.25rem 0; margin: 0 1rem; font-weight: bold; border-bottom: 4px solid transparent; display: inline-block; text-decoration:none; opacity: 0.3; }
.iris-profile-submenu .elgg-menu-owner-block li.elgg-state-selected a,
.iris-profile-submenu .elgg-menu-owner-block li a:hover,
.iris-profile-submenu .elgg-menu-owner-block li a:active,
.iris-profile-submenu .elgg-menu-owner-block li a:focus { border-bottom: 4px solid #384257; opacity:1; }

.iris-profile-editavatar { opacity:0; margin: auto; font-size: 0.94rem; text-align: center; color: white; display: inline-block;  background: rgba(0,0,0,0.2); position: absolute; border-radius: 7rem; left: 0; top: 0; right: 0; bottom: 0; padding: 5rem 0; }
.iris-profile-editavatar:hover { opacity:1; text-decoration:none; }
.iris-profile-icon:hover .iris-profile-editavatar {  }
.iris-profile-editavatar .fa { font-size: 2.5rem; }
.iris-round-button, .iris-profile-addfriend, .iris-profile-isfriend, .iris-profile-removefriend, .iris-profile-pendingfriend, .iris-profile-sendmessage { position: absolute; display: inline-block; width: 3rem; height: 3rem; border-radius: 3rem; color: white; text-align: center; line-height: 3rem; font-size: 1.4rem; }
.iris-round-button { background: #384257; color: white; }
.iris-profile-addfriend { right: 0rem; top: 1rem; background: <?php echo $iris_blue; ?>; }
.iris-profile-removefriend { right: 0rem; top: 1rem; background: #FF0000; }
.iris-profile-isfriend { right: 0rem; top: 1rem; background: #95C11F; }
.iris-profile-pendingfriend { right: 0rem; top: 1rem; background: #E09000; }
.iris-profile-sendmessage { right: -1.5rem; top: 4.5rem; background: #384257; }
.iris-profile-field { padding: 1rem; border-bottom: 2px solid #E0E0E0; display: flex; flex-wrap: wrap; justify-content: space-between; }
.iris-profile-field:last-of-type { border: 0; }
.iris-profile-field h4 { width: 100%; }
.profile-activity-river { /* padding: 1rem; */ }
.profile-activity-river .elgg-list-river { margin: 0; }
.profile-activity-river .elgg-river-item { padding: 0; }
.iris-profile-field .profile-aboutme-contents { padding: 0 0 1.5rem 0; }
.profile-admin-menu-wrapper, .profile-admin-menu-wrapper a { color: red; padding: 0; margin: 0; }
.profile-admin-menu-wrapper::before { display: none; }
.profile-admin-menu-wrapper h4 { padding: 0; margin: 0; }
.profile-admin-menu { margin-bottom: 1rem; }
.iris-user-groups { margin: 0 0 0.25rem 0; flex: 1 0 5.5rem; }
.iris-user-groups img { height:  5rem; width: 5rem; }
.iris-user-groups-add { height:5rem; width:5rem; border:1px dashed #384257; display:flex; text-align:center; line-height:5rem; font-size:2rem; }
.iris-user-groups-add a { width: 100%; color: #384257; text-decoration:none; }
.iris-user-friend { margin: 0 0 0.25rem 0; flex: 1 0 3.625rem; }
.iris-user-friend img { height:3.375rem; width:3.375rem; border-radius:3.375rem; }
.iris-user-friends-add { height:3.375rem; width:3.375rem; border:1px dashed #384257; display:flex; text-align:center; line-height:3.375rem; font-size:1rem; }
.iris-user-friends-add a { width: 100%; color: #384257; text-decoration:none; }

/* Styles génériques */
/* Forms */
::-webkit-input-placeholder { color: rgba(56, 66, 87, 0.5); opacity: 1; }
:-moz-placeholder { color: rgba(56, 66, 87, 0.5); opacity: 1; }
::-moz-placeholder { color: rgba(56, 66, 87, 0.5); opacity: 1; }
-ms-input-placeholder { color: rgba(56, 66, 87, 0.5); opacity: 1; }
input::placeholder, textarea::placeholder { color: rgba(56, 66, 87, 0.5); opacity: 1; }

/* Correct offset for anchors links */
a[name*=comment] { position: absolute; padding-top: 7rem; margin-top: -7rem; display: block; width: 0; }
/* Correct offset for list items
li[id*=elgg-object-]:before { content:""; display:block; height:7rem; margin:-7rem 0 0; }
*/

/* CKEditor controls : unhide toggle menu so we can start with editor disabled */
.ckeditor-toggle-editor.elgg-longtext-control.hidden { display: block; }


/* Fullscreen */
.elgg-button.elgg-button-fullscreen { padding: 0.5em 0.75em; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.full-screen .elgg-body-transp .elgg-button-fullscreen { position: absolute; z-index: 1112; right: 7rem; top: 3.75rem; padding: 0.5em 0.75em; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.elgg-button-fullscreen .fa-compress { display:none; }
.full-screen .elgg-button-fullscreen .fa-compress { display:block; }
.full-screen .elgg-button-fullscreen .fa-expand { display:none; }
/* Fullscreen base & overlay */
.full-screen div { max-width: initial !important; }
.overlay { background: rgba(0,0,0,1); position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; opacity: 0; transition-duration:1s; }
.full-screen .overlay { z-index: 1000; opacity: 0.9; }
.full-screen .full-width-pages-nav { margin-top: 0.5rem; border-radius: 0; }


h4 { font-size: 1.125rem; margin-bottom: 0.75rem;; }
.elgg-breadcrumbs { display: none; }
.iris-topbar-item .iris-topbar-notifications-tab a.view-all, 
.view-all { color: <?php echo $iris_blue; ?>; font-size: 1rem; font-family: <?php echo $font2; ?>; font-variant: small-caps; font-weight:bold; }
.iris-topbar-item .iris-topbar-notifications-tab a.view-all:hover, 
.view-all:hover { text-decoration:none; }
.elgg-context-profile .view-all { line-height: 2rem; }
#iris-body .elgg-context-profile h2 { padding-top: 0; }
.group-workspace-members a.iris-manage,
.iris-manage { color: #969696; font-size: 0.75rem; font-style: normal; text-transform: uppercase; font-weight: bold; float: right; }
.add-plus { height: 2.25rem; width: 2.25rem; border-radius: 1.125rem; background: #1488CA; color: white; font-size: 2rem; line-height: 2.5rem; text-align: center; }
.readmore { /* margin-left: 1rem; */ float: right; }
a.iris-object-readmore { color: #384257; }
a.iris-object-readmore .readmore { color: #1488CA; font-size: 0.9em; font-weight:bold; }
a.iris-object-readmore:hover, a.iris-object-readmore:active, a.iris-object-readmore:focus { text-decoration: none; /* text-shadow: 0 0 0 black; */ }
a.iris-object-readmore:hover .readmore, a.iris-object-readmore:active .readmore, a.iris-object-readmore:focus .readmore { text-decoration: underline; /* text-shadow: 0 0 0 black; */ }


.elgg-tags > li { float: none; display: inline-block; margin: 0 0.625rem 0.625rem 0; }
.group-profile-main .elgg-list .elgg-tags > li { float: none; display: inline-block; margin: 0 0.625rem 0.625rem 0; }
.elgg-tags li.elgg-tag:after { content:''; }
.elgg-tag {  }
.elgg-tag a { display:inline-block; padding: 0.3em 0.8em 0.2em 0.8em; border: 1px solid <?php echo $iris_blue; ?>; border-radius: 1rem; font-size: 0.75rem; text-transform: uppercase; font-weight: bold; line-height: 1.2; }
.small .elgg-icon-tag.fa { font-size: inherit; }
.elgg-pagination { text-align: right; margin: 0; padding: 0.5rem 0 1.5rem 0; }
.elgg-pagination a, .elgg-pagination span {}
.elgg-pagination-infinite a, .elgg-pagination-infinite span { border-radius: 1em; background: <?php echo $iris_blue; ?>; color: white; border: 0; font-size: 1rem; padding: 0.5rem 1rem; }
.iris-topbar-item .iris-topbar-notifications-tab .elgg-pagination a { font-size: 1rem; padding: 0.5rem 1rem; }

.iris-box { background: #FFFFFF; min-width:10rem; max-width:32.625rem; margin:0 0 1rem 0; }
.iris-cols .iris-box { border: 1px solid #CCC; padding: 2rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.iris-box h3, .iris-box h3 a { font-size:1rem; font-family:<?php echo $font2; ?>; font-weight:bold; margin-bottom: 0.8em; color:<?php echo $titlecolor; ?>; }

.thewire-form img { border-radius: 50%; margin: 1.125rem 1rem 1.125rem 0; /* margin: 0.75rem 1rem 1.125rem 0; */ width: 2.5rem; height: 2.5rem; flex: 0 0 auto; }
.thewire-reply-inline .thewire-form img { margin: 0.75rem 0.5rem 0.75rem 0; }
.iris-box.home-wire textarea { /* width: 80%; */ height:3em; }
.iris-box.home-wire textarea::placeholder { color: #D3D3D3; }
.thewire-form #thewire-characters-remaining { display: inline-block; font-size: 1em; float: none; margin-right: 1em; }
.elgg-foot #thewire-characters-remaining { float: none; }
#thewire-characters-remaining span { margin: 0; float: none; font-size: 1em; }
.home-wire .thewire-form .elgg-button-submit { display: inline-block; float: none; }
.elgg-layout-one-sidebar .thewire-form textarea { width: auto; height: 4rem; }
.iris-box.home-wire .elgg-item-object .elgg-image-block .elgg-image a.medium img { margin: 0 1.3125rem 0 0.3125rem !important; width: 2.5rem; height: 2.5rem; padding: 0; }
.elgg-layout-one-sidebar .thewire-reply-inline .elgg-form.thewire-form { background: transparent; border: 0; padding: 0; box-shadow: none; margin: 0; }


/* Pages de recherche : membres, groupes, publications */
.iris-search { display:flex;flex-direction:column; }
.iris-search-header { width:100%; background-color: rgba(28,36,48,1); height:18.75rem; position: relative; /* margin-bottom: 3.5rem; */ }
.iris-search-quickform { position: absolute; top: 4.8125rem; left: 18.75rem; color: white; }
.iris-group-header .iris-search-quickform { position: initial; margin-top: 1.875rem; }
#iris-body .iris-search-quickform h2 { float:left; font-size: 2.5rem; line-height: 2.75rem; margin-bottom: 1.875rem; padding:0; color: white; }
.iris-search-q-results { float: right; line-height: 2.75rem; vertical-align: bottom; font-size:1.0625rem; font-weight:bold; margin-left:2rem; }
#iris-search-quickform { border: 1px solid white; height: 3.125rem; line-height: 3.125rem; width: 24.625rem; font-size: 1.1rem; padding: 0 0 0 0.8125rem; clear:both; }
#iris-search-quickform #iris-search-header-input { border: 0; background: transparent; color: white; text-transform: uppercase; font-size: 0.75rem; font-weight: bold; line-height: 1.5rem; padding: 0; width:22rem; }
.iris-search-reset, #iris-search-quickform input[type="reset"] { background: none; color: white; border: 0; width: auto; /* font-size: 0.75rem; */ font-size: 0.9rem; padding: 0; margin: 0; line-height: 3rem; }

.iris-search-image { width:13.125rem; height:13.125rem; position: relative; top: 2.8125rem; left: 2.8125rem; background:#384257; z-index:3; color: white; font-size: 5rem; padding: 4.0625rem; }
.iris-search-image { fill:white; }

.iris-search-menu { z-index:2; background:white; position: absolute; bottom: 0; left: 0; right: 0; padding-left: 18.75rem; }
.iris-search-menu a { color: #384257; font-size: 1.125rem; padding: 1.375rem 0 1.25rem 0; margin: 0 1.5rem; font-weight: bold; display: inline-block; opacity:0.3; border-bottom:4px solid transparent; text-decoration:none; }
.iris-search-menu a:first-of-type { margin-left:0; }
.iris-search-menu a.elgg-state-selected,
.iris-search-menu a:hover,
.iris-search-menu a:active,
.iris-search-menu a:focus { border-bottom: 4px solid #384257; opacity:1; }

.elgg-sidebar, .iris-search-sidebar { float:left; clear:left; min-width: 20rem; width: 30%; }
.iris-search-filters { float:left; }

#esope-search-form { padding: 0 0 0rem 0rem; width: 100%; }
.elgg-sidebar h3, 
#esope-search-form h3 { text-transform: uppercase; font-size: 1rem; padding: 0;  margin-bottom: 2.125rem; }
.iris-search-fulltext { display:none; }
.esope-search-metadata { width: 100%; min-height: initial; border: 0; border-bottom: 1px solid #C8C8C8; padding: 0 0 1.25rem 0; margin: 0 0 1.4375rem 0; float: none; display: block; color: #384257; }
.esope-search-metadata:last-of-type { border: 0; margin-bottom: 0; }
.esope-search-metadata label { font-size: 1rem; color: #384257; font-weight:normal; line-height: 2rem; height: 2rem; }
.esope-search-metadata-select label { font-size: 1.0rem; font-weight:bold; line-height: 2rem; height: 2rem; }
#esope-search-form .esope-search-metadata select, #esope-search-form .esope-search-metadata input { float: right; min-width: initial; width: 10rem; font-size: 0.75rem; line-height: 2rem; height: 2rem; }
#esope-search-form .esope-search-metadata input[type="checkbox"] { width: auto; margin: 0.125rem 0.25rem 0 0; float: left; }
.iris-search-sort { margin-bottom: 1.625rem; }
.esope-date-filter select[name="date_filter"], .esope-date-filter #elgg-river-selector { margin: 0 0 0 0.5rem; }
.iris-search-count { color: #6C6C6C; font-size: 0.9375rem; }
.esope-results-count { color: #6C6C6C; font-size: 0.9375rem; margin-top: -1.5rem; margin-bottom: 2rem; display: block; }
.esope-noresult { margin-top: 3rem; }
.iris-search-order { color: #384257; font-size: 1rem; font-weight:bold; text-transform:uppercase; float:right; }
.iris-search-order select { color: #384257; font-size: 1rem; font-weight:normal; text-transform:initial; }
.iris-search-order select:selected, .iris-search-order select:hover, .iris-search-order select:active, .iris-search-order select:focus {  }
.iris-search .elgg-layout-one-sidebar .elgg-list-container { max-width: initial; }
#iris-body h2.search-heading-category { font-size: 1.75rem; color: #384257; line-height: 2.75rem; padding: 0; margin: 0; }
.elgg-item-more { border: 0; box-shadow: none; background: transparent; padding: 0; margin-bottom: 2.5rem; text-align: right; font-weight: bold; text-transform: uppercase; font-size: 0.8125rem; }



/* Boutons */
#esope-esearch-loadmore a { background: <?php echo $iris_blue; ?>; padding: 0.5em 1.5em; border-radius: 2em; font-size: 0.9375rem; font-weight: bold; font-family: "Inria Sans", sans-serif; color: white; text-decoration: none; display: inline-block; }

#iris-footer #feedbackWrapper { top:initial; bottom:150px; }
#feedBackToggler #feedBackTogglerLink { background: transparent; border: 0; box-shadow: none; }
#feedbackWrapper #feedBackContent { padding: 0.5rem 1rem; }
#feedBackIntro { font-size: 1rem; }
#feedBackFormInputs, #feedBackForm, #feedBackForm label, #feedBackForm input, #feedBackForm select { font-size: 0.9rem; }
#feedBackForm label { margin: 0 0.5rem 0.5rem 0; display: inline-block; }
#feedbackWrapper #feedBackContent .elgg-head { background: none; padding: 0; }
#feedbackWrapper #feedBackContent .elgg-head h3 { color: #384257; margin: 0 0 0.5rem 0; padding: 0; font-size: 2rem; font-weight: normal; font-family: "Inria Serif", serif; text-transform: initial; }
#feedbackWrapper .feedbackText, #feedbackWrapper textarea#feedback_txt { font-size: 1rem; margin: 0.2rem 0 0.2rem 0; }
#feedbackWrapper #feedbackDisplay a { background: #384257; color: white; padding: 0.5rem 1rem; display: inline-block; border-radius: 2rem; margin: 0.5rem 0 0 0; font-size: 0.9rem; }
#feedbackWrapper #feedbackDisplay a:hover, #feedbackWrapper #feedbackDisplay a:active, #feedbackWrapper #feedbackDisplay a:focus { color:white; text-decoration: none; }

/* River and listings */
.elgg-river-layout .elgg-list-river { /* background: white; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); max-width: 32.625rem; padding: 2.5rem; */ border-top:0; }

.elgg-list-river .elgg-item { padding: 1.8rem 0 1.2rem 0; }
.elgg-list-river .elgg-item:first-of-type { padding-top: 0; }
.elgg-menu-river { width: 100%; clear: both; text-align: right; margin: 1rem 0 0 0; /* line-height:1.2rem; */ line-height:normal; font-size: 0.8125rem; height: auto; }

.elgg-river-summary strong a, 
a.elgg-river-subject { font-weight: bold; color: #384257; font-size: .9em; }
a.elgg-river-target, a.elgg-river-object {  }

.elgg-no-results { width: 100%; }

.elgg-image-block { /* display:flex; */ overflow:visible; padding: 0.5rem 0; }
.iris-sidebar-content .elgg-image-block { display: block; }
.elgg-image-block .elgg-body { overflow: visible; }
.elgg-list .elgg-item { background: white; margin: 0 0 1.25rem 0; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); padding: 1.5rem 2rem; }
.elgg-context-thewire:not(.elgg-context-workspace-content) .elgg-list .elgg-item, 
.iris-box .elgg-list .elgg-item { padding: 0 0 1rem 0; box-shadow: none; }
.elgg-layout-group:not(.elgg-context-workspace) .elgg-list .elgg-item.elgg-item-object-thewire { border: 0; margin: 0 0 1.25rem 0; padding: 1.5rem 2rem; }
.elgg-layout-group.elgg-context-thewire-thread .elgg-list .elgg-item.elgg-item-object-thewire { padding: 0; margin: 0; }
.elgg-river-item .elgg-river-message .elgg-river-target { margin-left: 1rem; float: none; font-variant: initial; font-size: 0.85em; }
.iris-box .elgg-river-responses .elgg-list .elgg-item { padding: 0.25rem; }
#group-workspace-content-filter select { margin-left: 0.5rem; }
.group-workspace-activity { padding: 0 1rem; }
.group-workspace-activity .elgg-item { padding: 1rem 0; margin: 0; border-width: 0px 0 2px 0; box-shadow: none; }
.group-workspace-activity .elgg-item:last-of-type { border:0; }
.group-workspace-activity .elgg-no-results { padding: 1rem 0; }
.elgg-list .elgg-item .elgg-image-block { padding: 0; }
.elgg-image-block .elgg-image { margin: 0 1.875rem 0 0; position:relative; }
.workspace-subtype-content .elgg-image-block .elgg-image { margin: 0 1.475rem 0 0; }
.workspace-subtype-content .elgg-river-timestamp { margin-bottom: 0.1rem; }
.workspace-subtype-content.file { display: flex; flex-wrap: wrap; }
.workspace-subtype-content .file a { height: 100%; width: 100%; display: flex; }
.workspace-subtype-content .file a img { margin: auto; }
.elgg-river-responses .elgg-image-block .elgg-image { margin: 0 0.5rem 0 0; }

.elgg-image-block.elgg-river-item .elgg-image { margin: 1.5rem 1.875rem 0 0; margin:0; }
.elgg-image-block.elgg-river-item .elgg-image a { display: flex; width: 6rem; height: 4rem; }
.elgg-image-block.elgg-river-item .elgg-image span, .elgg-image-block.elgg-river-item .elgg-image img { margin: auto !important; color: #384257; }
.elgg-image-block.elgg-river-item .elgg-image .fa { color: rgba(56, 66, 87, 0.5); }

.elgg-river-item .elgg-river-responses form.elgg-form { border:0; padding:0.5rem 1rem; background: #FAFAFA; /* display: flex; */ font-size:1rem; }
.thewire-reply-inline { border:0; padding:0.5rem 1rem; background: #FAFAFA; display: flex; font-size:1rem; }
.iris-box.home-wire .thewire-reply-inline img { width: 2rem; height: 2rem; margin: 0.5rem 0.5rem 0.5rem 0; }
.home-wire .thewire-reply-inline textarea { height: 3rem; font-size:1rem; flex: 1 1 auto; padding: 6px; }
.thewire-reply-inline .wire-input textarea { flex: 1 1 auto; width: 10rem; }
.thewire-reply-inline .elgg-button.elgg-button-submit {}
.elgg-menu.elgg-menu-entity { float: none; text-align: right; max-width: none; width: 100%; text-align: right; margin: 0.5rem 0; }
.elgg-menu .elgg-menu-item-access { float:left; margin-right: 1rem; margin-left: 0; }
.elgg-menu .elgg-menu-item-container { float:left; margin-right: 1rem; margin-left: 0; }
.elgg-menu-item-container svg { height: 1rem; line-height: 1rem; fill: rgba(56, 66, 87, 0.5); float: left; }
.elgg-menu .iris-container { font-weight: bold; font-size: 0.8125rem; color: rgba(56, 66, 87, 0.5); line-height: 1.4rem; }
.elgg-menu .elgg-menu-item-access { float:left; }
.elgg-pages-subtitle { color: #969696; font-size: 0.75rem; font-style: normal; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem; }
.elgg-river-timestamp { color: #969696; font-size: 0.75rem; font-style: normal; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem; display: inline-block; }
.elgg-river-comments { margin: 1rem 0 0 0; }
.elgg-river-comments .elgg-item { padding: 0 0.5rem; }
.elgg-river-comments > li { border-width: 1px; }
.elgg-river-comments > li:first-of-type { border-top: 0; }
.elgg-river-message .elgg-river-target { float: right; color: #1488CA; font-size: 1rem; font-variant: small-caps; font-weight: bold; }

.elgg-comments { margin-top: 1.5rem; /* margin: 0 -2rem; padding:1rem 2rem 0 2rem; border-top: 2px solid #F1F1F1; */ }
.elgg-layout-one-sidebar .elgg-main .elgg-comments .elgg-list-container { box-shadow: none; border: 0; }
.elgg-comments .elgg-list { /* border-top: 0; */ }
.elgg-comments .elgg-list > li { border-width: 1px; }
.elgg-comments .elgg-list.elgg-list-entity-replies .elgg-item.elgg-item-object-thewire { border: 1px solid #DCDCDC; margin-bottom: 1rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.elgg-comments .elgg-list.elgg-list-entity-replies .elgg-item.elgg-item-object-thewire:first-of-type {border-top: 0; }
.elgg-comments .elgg-list > li:first-of-type { border-top: 0; }
.elgg-latest-comments li { border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.elgg-latest-comments .iris-object-actions li { box-shadow: none; border-radius: 0; }
.elgg-sidebar .elgg-module-aside .elgg-body .elgg-menu-entity-alt li { float: none; }
.elgg-layout-user-owner .elgg-comments .elgg-list > li { border: 0; padding: 0; }
.elgg-layout-user-owner ul.elgg-list.elgg-list-entity { border: 0; }
.elgg-layout-user-owner ul.elgg-list.elgg-list-entity:before { content: ''; display: none; }
.elgg-layout-user-owner .elgg-comments a[rel=toggle] { margin-top: 1rem; }
.elgg-list.elgg-latest-comments li.elgg-item { padding: 1rem; }
.elgg-list.elgg-latest-comments li.elgg-item h4 { margin: 0; }
.elgg-list.elgg-latest-comments li.elgg-item .elgg-image-block { display: flex; }
.elgg-list.elgg-latest-comments li.elgg-item .elgg-image-block .elgg-image { margin-right: 0.5rem; }
.elgg-list-container .elgg-list-entity li.elgg-item-object-comment { padding: 0 0.5rem; }
.elgg-list-entity li.elgg-item-object-comment .elgg-image-block { padding-bottom: 0; display: flex; }
.elgg-form-comment-save { margin-bottom: 0.5rem; }
.elgg-comments .elgg-avatar-medium > a > img { width: 46px; height: 46px;}

.elgg-menu-title { float: none; text-align: right; margin-bottom: 1rem; }

.elgg-item-user .elgg-menu.elgg-menu-entity { width:auto; display: inline-block; float: right; max-width: 40%; margin: 0 0 0 1rem; }
.elgg-menu-item-message .iris-user-message,
.elgg-menu-entity li.elgg-menu-item-add-friend a,
.elgg-item-user li.elgg-menu-item-add-friend a,
.elgg-menu-entity li.elgg-menu-item-remove-friend a,
.elgg-item-user li.elgg-menu-item-remove-friend a,
.elgg-menu-entity li.elgg-menu-item-friend-request a,
.elgg-item-user li.elgg-menu-item-friend-request a,
.elgg-item-entity li.elgg-menu-item-is-friend a,
.elgg-item-user li.elgg-menu-item-is-friend a { height: 2.875rem; width: 2.875rem; line-height:2.875rem; border-radius: 1.5rem; display: inline-block; overflow: hidden; font-size: 1rem; color: white; text-align:center; }
.elgg-menu-item-message .iris-user-message { background-color: #384257; }
.elgg-menu-entity li.elgg-menu-item-add-friend a, 
.elgg-item-user li.elgg-menu-item-add-friend a { background: <?php echo $iris_blue; ?>; }
.elgg-item-user li.elgg-menu-item-remove-friend a { background: #FF0000; }
.elgg-item-user li.elgg-menu-item-friend-request a { background: #d47d00; }
.elgg-item-user li.elgg-menu-item-is-friend a { background: #95C11F; cursor: initial; }

.elgg-subtext { font-size: 1.1rem; font-style: normal; color: <?php echo $iris_texttopgrey; ?>; }
.elgg-subtext time { font-size: 0.75rem; text-transform: uppercase; margin-left: 1em; }
.time-sep { font-size: 0.75rem; margin: 0 -1em 0 0; }

.elgg-item-user .elgg-image-block { display: flex; }
.elgg-item-user .elgg-image img { border-radius: 50%; }
.elgg-item-user .elgg-subtext { font-size: 0.9375rem; color: #6C6C6C; }
.elgg-item-user h3 { margin-bottom: 0.375rem; line-height: 1; }
.elgg-item-user h3 a { padding:0; font-size: 1.375rem; color: #384257; margin-right: 1rem; }
.elgg-item-user h4 { margin-bottom: 0.3125rem; font-size: 0.9375rem; }
.elgg-item-user .username { font-size: 1rem; }

.elgg-list .elgg-item.elgg-item-group { padding:0; }
.elgg-item-group .elgg-menu.elgg-menu-entity { margin: 0 0 0.8125rem 0; display: block; text-transform: uppercase; font-size: 0.75rem; font-weight: bold; color: #969696; }
.elgg-item-group h3 { padding: 0; margin: 0 0 0.625rem 0; }
.elgg-item-group h3 a { padding: 0; margin: 0; font-size: 1.375rem; color: #384257; text-decoration:none; }
.elgg-item-group .elgg-image-block .elgg-image { background: #FAFAFA; box-shadow: 0 0 4px 0 rgba(0,0,0,0.2); }
.elgg-item-group .elgg-image-block .elgg-image a { width: 12.5rem; height: 12.5rem; overflow: hidden; line-height: 12.5rem; display: flex; }
ul.elgg-list li.elgg-item.elgg-item-group div.elgg-image a img, .elgg-item-group .elgg-image img { width: 12.5rem; margin: auto; }
.elgg-item-group .iris-group-body { padding: 1.5rem 2rem 1.5rem 0rem; }
.elgg-item-group .elgg-menu-item-access, 
.elgg-item-group .elgg-menu-item-members, 
.elgg-item-group .elgg-menu-item-membership { float: left; margin-left: 0; margin-right: 1rem; }
.iris-object .elgg-menu-entity.float .elgg-access { margin: 0; }
.already-member { color: #95C11F; }
.elgg-menu-item-access .elgg-access a { color: rgba(56, 66, 87, 0.5); font-style: normal; font-weight: bold; }


.iris-groups-community { flex: 1 1 22rem; display: flex; min-height:12.5rem; max-width: 32rem; border-radius: 4px; background-color: #FFFFFF; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); margin: 0 2rem 2rem 0; padding: 2rem 2rem 2rem 0rem; position: relative; overflow: auto; }
.iris-community-icon { width: 6.375rem; height: 6.375rem; margin: 1rem; float: left; }
.iris-groups-community .iris-community-hover { position: absolute; top: 0; left: 0; bottom: 0; right: 0; /* background: <?php echo $iris_blue; ?>; opacity: 0.9; */ background:rgba(20, 136, 202, 0.9); border-radius: 4px; font-size: 1.875rem; font-weight: bold; color: white; text-align: center; line-height: 12.5rem; text-transform: uppercase; }
.iris-groups-community:hover .iris-community-hover { display: block; }
.iris-community-body { font-size:0.9375rem; color:#6C6C6C; }
.iris-community-groups-count { color: #969696; font-size: 0.75rem; font-weight: bold; margin-bottom: 0.625rem; }
.iris-community-body h3, .iris-community-body h3 a { color: #384257; font-size: 1.375rem; padding: 0; margin-bottom: 0.8125rem; }

.elgg-list-entity .elgg-menu-entity { margin: 1rem 0 0 0; line-height:1.2rem; font-size: 0.8125rem; }
.elgg-menu-entity .elgg-menu-item-edit a { background: none; border: 0; box-shadow: none; color: inherit; padding: 0; margin: 0; font-size: inherit; border-radius:0; }
.elgg-menu-entity .elgg-menu-item-edit a:hover, .elgg-menu-entity .elgg-menu-item-edit a:focus, .elgg-menu-entity .elgg-menu-item-edit a:active { color:inherit; background:none; font-size: 0.9375rem; text-decoration:underline; }
.entity-submenu { display:inline-block; position: relative; }
.entity-submenu a { display: block; padding: 0 0.5rem; }
.entity-submenu a .fa { color: rgba(56, 66, 87, 0.5); font-size: 1.25rem; }

/* Alternative for pure hover (no click to keep menu visible) 
.entity-submenu-content { position: absolute; right: 0; top: 0; padding: 1.5rem 0 0 0; z-index: 2; }
.elgg-list-entity .entity-submenu-content ul { background: white; box-shadow: 0 0 4px 0 rgba(0,0,0,0.5); width: 13rem; max-width: 16rem; padding: 0.5rem 1.25rem; margin: 0; display: flex; flex-direction: column; flex-basis: 0%; }
*/
.entity-submenu-content { position: absolute; top: 1rem; right: 0; background: white; box-shadow: 0 0 4px 0 rgba(0,0,0,0.5); width: 11rem; max-width: 16rem; padding: 0.5rem 1.25rem; z-index: 2; }
.elgg-list-entity .entity-submenu-content ul { margin: 0; display: flex; flex-direction: column; flex-basis: 0%; }
.iris-object .entity-submenu-content .elgg-menu-entity { margin: 0; }
.iris-object .entity-submenu-content .elgg-menu-entity li a, 
.elgg-list-entity .entity-submenu-content ul li { margin: 0; /* padding: 0.3rem 0 0.2rem 0; */ padding: 0; text-align: left; color: #384257; }
.elgg-list-entity .entity-submenu-content ul li a { color: #384257; padding: 0; margin: 0; }
.entity-submenu:hover .entity-submenu-content, .entity-submenu:active .entity-submenu-content, .entity-submenu:focus .entity-submenu-content { display: block; }
/* Enlarge the hovered zone so we don't loose the submenu too easily
.entity-submenu:hover a, .entity-submenu:active a, .entity-submenu:focus a { padding: 0 0.5rem 0 0.5rem; }
*/
.iris-object .entity-submenu-content .elgg-menu-entity li { display: block; margin: 0; padding: 0.5rem 0 0.3rem 0; text-align: left; color: #384257; float: none; }
.iris-object .entity-submenu-content .elgg-menu-entity li.elgg-menu-multilingual { display: inline-block; padding-right: 1rem; }
.iris-object .entity-submenu-content ul li *, 
.elgg-list-entity .entity-submenu-content ul li * { color: #384257; font-weight: normal; font-size: 0.9375rem; }
.iris-object .entity-submenu-content .elgg-menu-entity li.elgg-menu-item-access span { margin: 0; }

.file-upload-version { padding:1rem; width: 30rem; max-width: 30rem; }

.entity-headline { line-height: 1.2rem; margin-bottom: 0.6875rem; }
.entity-headline .elgg-avatar img { width:2rem; height:2rem; }
.elgg-context-groups.elgg-context-workspace-content .elgg-list-entity h3, .elgg-context-groups.elgg-context-workspace-content .elgg-list-entity h3 a { font-size: 1.3125rem; color: #384257; }
.elgg-context-workspace-content .elgg-item { /* height: 12.5rem; */ min-height: 12.5rem; /* overflow: hidden; */ }
.elgg-context-workspace-content .elgg-image-block { margin: -1.5rem -2rem -1.5rem -2rem; display: flex; }
.elgg-context-workspace-content .elgg-image-block .elgg-image { width: 12.5rem; min-height: 12.5rem; display: flex; background: #FAFAFA; box-shadow: 0 0 4px 0 rgba(0,0,0,0.2); margin-right:0; flex: 0 0 12.5rem; }
.elgg-context-workspace-content .elgg-image-block .elgg-body { min-height: 12.5rem; padding: 1.5rem 2rem 0rem 2rem; }
.elgg-context-workspace-content .elgg-image-block .elgg-image > * { margin: auto; }
.iris-object .elgg-image-block .elgg-body { display: flex; flex-direction: column; }
.iris-object .elgg-image-block .elgg-body .iris-object-actions { margin-top: auto; padding-top: 0.5rem; }
.iris-object .elgg-image-block .elgg-body .iris-object-readmore, .iris-object .elgg-image-block .elgg-body .elgg-content { flex: 1 1 auto; }
.elgg-context-workspace-content .thewire-parent .elgg-image-block { margin: 0; }
.elgg-context-workspace-content .thewire-parent .elgg-image-block .elgg-body { min-height: initial; padding: initial; }
.elgg-context-workspace-content .thewire-parent .elgg-image-block .elgg-image { width: initial; min-height: initial; display: initial; background: initial; box-shadow: initial; margin-right: initial; flex: initial; }

.pages-subpages { border-top: 2px solid #F1F1F1; margin: 1rem -2rem 0rem -2rem; padding: 0 2rem; }
.elgg-context-pages .elgg-list-annotation li .elgg-image-block { margin: 0; border: 0; }
.elgg-context-pages .elgg-list-annotation li { box-shadow: none; margin: 0; padding: 1rem 0; }
.pages-content { border-top: 2px solid #F1F1F1; padding: 1rem 0; margin-bottom: 1rem; }


#iris-body .iris-listing .elgg-main .elgg-list-entity { display: flex; flex-wrap: wrap; }
.elgg-layout-content .elgg-list-entity li { padding: 0 0 1rem 0; box-shadow: none; }

.elgg-list-entity .elgg-item-object-thewire .elgg-image img { /* max-width: 3.4rem; */ border-radius: 1.7rem; }
.iris-listing .elgg-list .elgg-item.elgg-item-group, .iris-groups-member-new { flex: 1 0 28rem; overflow:hidden; height:12.5rem; max-width: 46rem; border-radius: 4px; background-color: #FFFFFF; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); margin: 0 2rem 2rem 0rem; padding: 0; position: relative; }
.iris-listing .elgg-item-group h3, .iris-listing .elgg-item-group h3 a { color: #384257; font-size: 1.375rem; padding: 0; margin-bottom: 0.8125rem; }
.iris-listing .elgg-item-group .elgg-subtext { font-size:0.9375rem; color:#6C6C6C; }
.iris-groups-member-new {  }
.iris-groups-member-new .iris-groups-member-new-image { float: left; width: 9.5rem; height: 9.5rem; text-align: center; line-height: 9.5rem; font-size: 4.8rem; border: 1px dashed; margin: 1.5rem; }
.iris-groups-member-new .iris-groups-member-new-body { padding: 3rem; text-align: center; }
.iris-groups-member-new-body a { margin-bottom: 1.5625rem; }

.elgg-list .elgg-item .elgg-image-block.notifications-pending-requests, 
.elgg-list .elgg-item .elgg-image-block.notifications-pending-invitations { padding: 1rem; display: flex; }
.elgg-item-group .notifications-pending-requests .elgg-image img, 
.elgg-item-group .notifications-pending-invitations .elgg-image img { width: initial; }
#notifications .elgg-item.elgg-item-group { padding: 0; margin: 0; }
#notifications .elgg-list .elgg-item .elgg-image-block.notifications-pending-requests, 
#notifications .elgg-list .elgg-item .elgg-image-block.notifications-pending-invitations { padding: 0; }
#notifications.iris-topbar-item .iris-topbar-notifications-tab a.elgg-button { padding: 0.5rem 1rem; color: white; }
.notifications-pending-groups-requests h4 { margin: 0; }
#notifications .elgg-river-timestamp { margin-bottom: 0.25rem; }



/* The Wire */
/* .messages-buttonbank, */
.elgg-layout-one-sidebar .elgg-form.thewire-form, 
.elgg-layout-one-sidebar .elgg-main .elgg-list-container { max-width: 32.625rem; margin: 0; padding: 1rem; background: white; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; }
.elgg-layout-one-sidebar .elgg-form.thewire-form { margin-bottom:1.25rem; }
.iris-search .elgg-layout-one-sidebar .elgg-main .elgg-list-container { background: none; border: 0; max-width: initial; box-shadow: none; padding: 0; }
.iris-search .elgg-input-radios label { font-weight: normal; color: #384257; line-height: 1.875rem; font-size: 1rem; }
.elgg-item .thewire-parent { padding: 0.5rem 0; margin-left: 0; background: #FAFAFA; }
.elgg-item .thewire-parent .entity-headline { display: none; }
.elgg-item-object .thewire-parent .elgg-image-block .elgg-image a.medium img { width: 2rem; height: 2rem; margin: 0 0.5rem !important; }
.thewire-parent .thewire-post { padding: 0.25rem; }
.thewire-parent .thewire-parent { margin: 0.5rem 0 0 -3rem; padding-top: 0.5rem; border-top: 1px solid #C8C8C8; }
.thewire-parent .iris-object.iris-object-full { margin: 0; padding: 0 1rem; }
.thewire-parent .thewire-parent .iris-object.iris-object-full { margin: 0 0rem 0 2rem; }
/* Threads and replies levels */
.wire-thread { background: white; padding: 2rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; margin: 1rem 0 0 0; }
.thewire-parent-top {  }
.thewire-reply {  }
.thewire-reply-top {  }
#esope-search-results .elgg-menu-entity { text-align: left; }
#esope-search-results .elgg-menu-entity > li { margin-left:0; margin-right:1rem; }



/* Groupes */
/* Pages de recherche : membres, groupes, publications */
.iris-group { display:flex; flex-direction:column; }
.iris-group-header { width:100%; background: #454C5F; min-height:18.75rem; position: relative; /* margin-bottom: 3.5rem; */ }
.iris-group-header-alt { width:100%; background: #454C5F; height:15rem; position: relative; /* margin-bottom: 3.5rem; */ }
.iris-group-header-alt h2 { color: white; margin-left: 3rem; }
.iris-group-image { width:13.125rem; height:13.125rem; position: relative; top: 3.5rem; left: 3rem; background:#384257; z-index:3; color: white; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; }
.iris-group-title { position: absolute; top: 4.5rem; left: 20rem; right: 3rem; color: white; }
.iris-group-title a { color: white; }
#iris-body .iris-group-title h2 { font-size: 2.5rem; line-height: 2.75rem; margin-bottom: 0rem; padding:0; color: white; }
.iris-group-subtitle { margin: 0.9rem 0 1.5rem 0; font-size:1.0625rem; font-weight:bold; }
/* .iris-group-community { font-size: 0.75rem; color: #969696; text-transform: uppercase; font-weight: bold; margin-bottom: 1rem; } */
.iris-group-rules .iris-group-community, .iris-group-rules .group-access, .iris-group-rules .group-membership { margin-right: 1.5rem; }

.iris-group-menu { z-index:2; background:white; position: absolute; bottom: 0; left: 0; right: 0; padding-left: 18.75rem; }
.iris-group-menu a, .iris-group-menu .tab-more { color: #384257; font-size: 1.125rem; padding: 1.375rem 0 1.25rem 0; margin: 0 1rem; font-weight: bold; border-bottom: 4px solid transparent; display: inline-block; text-decoration:none; }
.iris-group-menu a.tab { opacity:0.6; }
.iris-group-menu a.search, .iris-group-menu span.search { border: 0; margin: 0 1.5rem 0 0rem; line-height: 1.125rem; }
/* .iris-group-menu a.add { color:#1488CA; font-size:0.75rem; text-transform:uppercase; } */
.iris-group-menu a.add { color: white; background: #1488CA; font-size:0.75rem; border-radius: 3rem; padding: 0.5rem 0.75rem 0.25rem 0.75rem; margin: 0.5rem 1rem 1rem 0; width: 10rem; text-align: center; hyphens: none; }
.iris-group-menu a.tab:first-of-type { margin-left:0; }
.iris-group-menu a.tab.elgg-state-selected,
.iris-group-menu span.tab.elgg-state-selected,
.iris-group-menu a.tab:hover,
.iris-group-menu a.tab:active,
.iris-group-menu a.tab:focus { border-bottom: 4px solid #384257; opacity:1; }
.iris-group-menu span.tab.elgg-state-selected a.tab.elgg-state-selected { border-bottom: 1px solid #CCC; }

.tab.tab-more { display: inline-block; position: relative; padding:0; }
.tab.tab-more a { display: inline-block; margin:0; border:0; }
.tab-more-content { display: flex; }
.iris-group-menu .tab-more-content { position: absolute; background: white; min-width: 16rem; top: 3.5rem; right: -1rem; box-shadow: 0 0 4px 0 rgba(0,0,0,0.5); flex-direction: column; flex-basis: 0%; }
.iris-group-menu .tab.tab-more:hover .tab-more-content { display: flex; }
.iris-group-menu .tab-more-content a { padding: 0.5rem 1rem; margin: 0; border-bottom: 1px solid #CCC; }
.iris-group-menu .tab-more-content a:hover, .iris-group-menu .tab-more-content a:active, .iris-group-menu .tab-more-content a:focus { border-bottom: 1px solid #CCC; }

.iris-group-sidebar { flex: 0 0 auto; min-width: 20rem; width: 20rem; padding: 0 1rem 1rem 3rem; }
.iris-group-sidebar h3 { margin-bottom: 0.875rem; text-transform: none; }
.iris-group-sidebar-alt { <?php echo $width['sidebar_alt']; ?> padding: 0rem 2.5rem 1rem 1rem; }
.iris-group-sidebar .elgg-module .elgg-body, .iris-group-sidebar .elgg-module .elgg-content, .iris-group-sidebar .elgg-module .elgg-river-summary { padding: 0 2.5rem 0rem 2.5rem; }
.iris-sidebar-content { background: white; padding: 1.5rem 2rem; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px; margin-bottom: 1.25rem; }
.iris-sidebar-content:last-of-type { margin-bottom: 0; }
.iris-sidebar-content h3 { font-size: 1.125rem; }
.iris-back { background-color: #1488CA; margin-bottom: 0.625rem; }
.iris-back a, #iris-body .iris-group-sidebar .iris-back a { font-family: "Inria Sans", sans-serif; background-color:#1488CA; display:block; color: white; font-weight: bold; font-size: 0.9375rem; }
.elgg-sidebar .iris-profile-back { background: none; margin-bottom:2rem; }
.elgg-sidebar .iris-profile-back a { padding: 1.5rem 2rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
#iris-body .iris-group-sidebar .iris-back a { color: white; font-weight: bold; font-size: 0.9375rem; }
#iris-body .iris-group-sidebar .iris-back a:hover, #iris-body .iris-group-sidebar .iris-back a:active, #iris-body .iris-group-sidebar .iris-back a:focus { color: white; }
.elgg-heading-main .iris-back { background:none; float: right; margin:0; }
.elgg-heading-main .iris-back a { padding: 0rem 1rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.group-content-back { padding: 0rem 0rem 1rem 0rem; margin: 0; }
.group-content-back .back { line-height:2rem; font-size: 0.8125rem; text-transform:uppercase; font-weight: bold; }
.group-content-back .add {  }
#iris-body .iris-group-sidebar, #iris-body .iris-group-sidebar a, .workspace-subtype-content a { font-size: 0.9375rem; color: #384257; font-family: "Inria Sans", sans-serif; border: 0; }
#iris-body .iris-group-sidebar a.elgg-state-selected, 
#iris-body .iris-group-sidebar a:hover, #iris-body .iris-group-sidebar a:active, #iris-body .iris-group-sidebar a:focus, 
.workspace-subtype-content a:hover, .workspace-subtype-content a:active, .workspace-subtype-content a:focus { color: #1488CA; }
#iris-body .iris-group-sidebar a.elgg-button:active, #iris-body .iris-group-sidebar a.elgg-button:focus, #iris-body .iris-group-sidebar a.elgg-button:hover { color: white; }
#iris-body .iris-group-sidebar h2 { font-size: 1.125rem; color: #384257; font-weight: bold; font-family: "Inria Sans", sans-serif; }
.iris-group-sidebar .fa-angle-right { /* float: right; */ }
.iris-group-sidebar li { margin-bottom: 2rem; }
.iris-sidebar-content .elgg-module-aside { padding: 0; margin-top: 0; margin-bottom: 1rem; }
.iris-group-sidebar .elgg-module li { padding: 0; margin-bottom: 1rem; }
.iris-group-sidebar .elgg-module li a { padding: 0.5rem 0; }
.iris-group-sidebar .elgg-menu-page label { font-weight: normal; }
.iris-group-sidebar .iris-workspace-rules { margin-bottom: 1rem; }
.elgg-workspace-description { margin-bottom: 2.5rem; }
.group-workspace-tabs { /* margin: -2rem -2rem 2rem -2rem; background: #F1F1F1; */ }
.group-workspace-tabs .elgg-tabs { margin: 0; border: 0; padding: 0; display: flex; flex-wrap: wrap; border-radius: 4px 4px 0 0; box-shadow: -4px 0px 4px -4px rgba(0,0,0,0.1); }
.group-workspace-tabs .elgg-tabs > li { flex: 0 0 auto; margin: 0; border: 0; padding: 0; border-radius:0; background:white; /* box-shadow: inset 4px -4px 4px -4px rgba(0,0,0,0.1); */ opacity:0.6; display: flex; }
.group-workspace-tabs .elgg-tabs > li > a { padding: 1rem 1rem; margin: auto; height: initial; font-size: 0.9375rem; font-weight: bold; color: #384257; }
.group-workspace-tabs .elgg-tabs > li:first-of-type { border-radius: 4px 0 0 0; }
.group-workspace-tabs .elgg-tabs > li.elgg-state-selected { box-shadow: 4px -4px 4px -4px rgba(0,0,0,0.1); }
.group-workspace-tabs .elgg-tabs .elgg-state-selected, 
.group-workspace-tabs .elgg-tabs .active, 
.group-workspace-tabs .elgg-tabs li:hover,
.group-workspace-tabs .elgg-tabs li:active,
.group-workspace-tabs .elgg-tabs li:focus { opacity:1; box-shadow: 4px -4px 4px -4px rgba(0,0,0,0.1); }
.group-workspace-tabs .elgg-tabs .elgg-state-selected a { top:initial; }
.group-workspace-tabs .tab-more-content { position: absolute; background: white; width: 12rem; top: 2.9375rem; right: 0; box-shadow: 0 0 4px 0 rgba(0,0,0,0.5); flex-direction: column; flex-basis: 0%; }
.group-workspace-tabs .tab.tab-more:hover .tab-more-content { display: flex; }
.group-workspace-tabs .tab-more-content li { opacity: 0.6; border: 0; background: transparent; margin: 0; border-radius: 0; float: none; display: flex; }
.group-workspace-tabs .tab-more-content a { padding: 0.5rem 1rem; margin: 0; color: #384257; border-bottom: 1px solid #CCC; flex: 1 1 auto; margin: 0; text-align: left; display: block; height: initial; }
.group-workspace-tabs .tab-more-content a:hover, .group-workspace-tabs .tab-more-content a:active, .group-workspace-tabs .tab-more-content a:focus { opacity: 1; border-bottom: 1px solid #CCC; }

.group-members-count { font-size: 5.5rem; /* text-align: center; */ color: #1488CA; margin: 1rem 0 1.5rem 0; }
.group-profile-main .elgg-list li { box-shadow: none; margin-bottom: 0; }
.group-profile-main .iris-round-button { color:white; font-size: 1rem; height: 2rem; width: 2rem; line-height: 2.2rem; opacity: 0.6; }
.group-operator:hover .iris-round-button, .group-member:hover .iris-round-button { opacity: 1; }
.make-group-owner { top: 3.5rem; left: 1rem; }
.remove-group-operator { top: 3.5rem; left: 3.5rem; }
.group-profile-main .group-member .iris-round-button { float: right; position: initial; margin-left: 0.5rem; }
.group-members-search { display:flex; margin: 1rem 0; }
.group-members-search .fa { margin-right: 1rem; }
.group-members .elgg-avatar { display:block; }
#group-members-livefilter {  }
.iris-invite-external { margin-top: 3rem; }
.group-member img { border-radius: 50%; float: left; margin-right: 0.5rem; }
.group-workspace-main { background: white; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); border-radius: 4px 4px 4px 4px; margin-bottom: 1rem; /* overflow: hidden; */ }
.group-workspace-module { margin-bottom: 2.5rem; }
.group-workspace-admins { display:flex; }
.group-workspace-admins .group-admin { flex: 0 0 auto; margin-right: 2.5rem; max-width: 8rem; text-align: center; }
.group-workspace-admins .group-operators { flex: 1; }
.group-workspace-admins .group-operator { float:left; margin-right: 0.625rem; max-width: 7rem; font-size: 0.9375rem; text-align: center; }
.group-workspace-admins .operators-more { width: 6.25rem; height: 6.25rem; line-height: 6.75rem; font-size: 2.125rem; background: #384257; color: white; border-radius: 3.125rem; display: inline-block; font-weight: bold; border: 3px solid transparent; padding: 3px; }
.group-workspace-admins img { border-radius: 50px; }
.group-admin, .group-operator:not(.more) { min-height: 10rem; position: relative; }
.group-admin img, .group-operator img { margin-bottom: 0.5rem; }
.group-admin a, .group-operator a { color: #384257; }
.group-operator.more { margin-right: 0; border: 3px solid transparent; padding: 3px; border-radius: 50%; }
.group-workspace-members img { width: 2rem; border-radius: 1rem; /* margin: 0 0.4375rem 0.4375rem 0; */ }
.group-workspace-members a, 
.group-workspace-members .members-more { margin: 0 0.4375rem 0.4375rem 0; font-size:1rem; color: #384257; font-weight:bold; height:2.5rem; line-height:2.5rem; float: left; }
.group-members-online img { width: 2rem; border-radius: 1rem; margin: 0 0.4375rem 0.4375rem 0; }
.group-workspace-add-tabs { background: #384257; padding: 1.25rem 3rem 1rem 3rem; font-size: 1.375rem; }
.group-workspace-add-tabs p, .group-workspace-add-tabs p a { color: white; opacity: 1; }
.group-workspace-add-tabs a { color: white; margin-right: 2.25rem; opacity: 0.6; }
.group-workspace-add-tabs a.elgg-state-selected, .group-workspace-add-tabs a:hover, .group-workspace-add-tabs a:active, .group-workspace-add-tabs a:focus { opacity: 1; }
.group-workspace-add-content { padding: 1.375rem 2.5rem 1.375rem 2.5rem; }
.group-workspace-add-content img { width: 3rem; border-radius: 100%; margin-top: 1rem; }

.elgg-context-invite_external textarea, 
.elgg-river-responses textarea, 
.iris-object .elgg-form-discussion-reply-save textarea, 
.iris-object .elgg-form-comment-save textarea, 
.group-workspace-add-content textarea { height: 3rem; transition-duration: 1s; transition-delay: 1s;/* border: 0; */ }
/* Note : delay car siinon l'envoi ne fonctionnera pas à moins car il perd le focus */
.elgg-context-invite_external textarea:active, .elgg-context-invite_external textarea:focus, 
.elgg-river-responses textarea:active, .elgg-river-responses textarea:focus, 
.iris-object .elgg-form-discussion-reply-save textarea:active, .iris-object .elgg-form-discussion-reply-save textarea:focus, 
.iris-object .elgg-form-comment-save textarea:active, .iris-object .elgg-form-comment-save textarea:focus, 
.group-workspace-add-content textarea:active, .group-workspace-add-content textarea:focus { height: 12rem; transition-delay: 0s; transition-duration: 1s; }

.elgg-context-invite_external label em { font-weight:normal; }

#group-workspace-add-file { /* text-align: center; */ }
#group-workspace-add-blog { text-align: center; }
#group-workspace-add-blog a:first-of-type { margin-right:0.625rem; margin-bottom: 1rem; }
.group-workspace-activity-filter { padding: 1rem 2.5rem; text-align: right; border-bottom: 2px solid #E0E0E0; }

.group-content-filter.tabs { margin-bottom: 0.5625rem; }
.group-content-filter.tabs a { font-size: 1.125rem; font-weight: bold; color: #384257; opacity: 0.3; margin: 0 2.5625rem 1rem 0; padding-bottom: 0.625rem; border-bottom: 4px solid transparent; display: inline-block; }
.group-content-filter.tabs a:last-of-type { margin-right: 0; }
.group-content-filter.tabs a.elgg-state-selected, .group-content-filter.tabs a:hover, .group-content-filter.tabs a:active, .group-content-filter.tabs a:focus { opacity: 1; border-bottom: 4px solid #384257; }



.iris-group-main { padding: 0rem; }
.elgg-context-au_subgroups .iris-group-main { padding: 0 2rem; }

.embed-wrapper .elgg-item { padding: 0.5rem 0; box-shadow: none; margin: 0; }
.embed-wrapper .elgg-image-block { display: block; } 


/* Formulaires */
fieldset { min-width: initial; }
form.elgg-form { padding: 0rem; width: initial; background: transparent; float: none; }
fieldset > div { /* max-width: 30rem; */ }
.ui-multiselect { max-width: 100%; }
.ui-multiselect-checkboxes label { font-size: 0.75rem; color: #6C6C6C !important; font-weight: normal !important; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { background: #F1F1F1; border: 0; }

#iris-body .elgg-form.elgg-form-alt.elgg-form-groups-edit { width: initial; }

#iris-body .iris-group-header-alt h2 { padding-top: 3rem; }

.form-groups-add .iris-group-sidebar { /* padding: 0 4rem 1rem 3rem; */ }
.form-groups-add .iris-group-sidebar .iris-sidebar-content { height: 13rem; }
.iris-group-header label[for="icon"], 
.iris-group-header label[for="banner"], 
.form-groups-add .iris-sidebar-content label { display: block; width: 100%; height: 100%; padding: 3rem 0 0 0; border: 1px dashed #D3D3D3; text-align: center; color: #D3D3D3; }
.iris-group-header label[for="icon"] { border: 0; padding: 5rem 0 0 0; /* text-shadow: 1px 1px 3px black; */ }
.iris-group-header label[for="banner"] { height: auto; margin: 8rem 0rem 0rem 0rem; position: absolute; width: 13rem; right: 2rem; border: 0; padding: 0; }
.iris-group-header label[for="icon"] .fa, 
.iris-group-header label[for="banner"] .fa, 
.form-groups-add .iris-sidebar-content .fa { font-size: 2rem; margin-bottom: 0.8rem; }
.iris-group-header label[for="icon"]:hover, .iris-group-header label[for="icon"]:active, .iris-group-header label[for="icon"]:focus { color:#384257; /* text-shadow: 1px 1px 3px white; */ cursor: pointer; }
.iris-group-header label[for="banner"]:hover, .iris-group-header label[for="banner"]:active, .iris-group-header label[for="banner"]:focus { color: white; cursor: pointer; }
.form-groups-add .iris-sidebar-content label:hover, .form-groups-add .iris-sidebar-content label:active, .form-groups-add .iris-sidebar-content label:focus { color:#384257; cursor: pointer; }
.iris-group-sidebar .feedback-menu { margin: -1.5rem -2rem; }
.elgg-sidebar.iris-group-sidebar #feedbacks h2 { padding: 0.5rem 2rem; }
#iris-body .elgg-menu-feedback li { margin:0; }
#iris-body .elgg-sidebar .elgg-menu-feedback li > a { font-weight:bold; padding: 1rem 2rem; }
#iris-body .elgg-menu-feedback li.elgg-state-selected > a,
#iris-body .elgg-menu-feedback li > a:hover,
#iris-body .elgg-menu-feedback li > a:active,
#iris-body .elgg-menu-feedback li > a:focus { background: white; color: #1488CA; }

.elgg-sidebar form.elgg-form-newsletter-subscribe { padding: 0; border: 0; }
form.elgg-form-newsletter-subscribe label { margin: 0; }

#esope-search-form-invite-groups { margin-top: 2.5rem; }
#esope-search-form-invite-groups .esope-search-metadata { background: transparent; border: 0; padding: 0; margin-bottom: 0.5rem; margin-right: 2.5rem; display: inline-block; width: auto; }
#esope-search-form-invite-groups .esope-search-metadata select { margin-left: 0.5rem; }
#esope-search-form-invite-groups .esope-search-metadata label { margin-right: 0; }
#esope-form-email-invite-groups { margin-top: 2.5rem; }

.form-groups-add .iris-group-sidebar-alt { /* padding: 0 3rem 1rem 4rem; */ }
.form-groups-add .iris-group-sidebar-alt .iris-group-image-input { background: transparent; box-shadow: none; }
.form-groups-add .iris-group-image-input label { display: block; width: 13rem; text-align: center; color: rgba(56, 66, 87, 0.5); color: #D3D3D3; }
.form-groups-add .iris-group-image-input .fa { font-size: 2rem; margin-bottom: 0.8rem; }
.form-groups-add .iris-group-image-input label:hover, .form-groups-add .iris-group-image-input label:active, .form-groups-add .iris-group-image-input label:focus { color: white; cursor: pointer; }

.form-groups-add .elgg-main h3 { padding-bottom: 3rem; }
.groups-edit-field { display: flex; flex-direction: row; margin-bottom: 1rem; }
.form-label, .groups-edit-field .groups-edit-label { width: 9rem; flex: 0 0 auto; display: inline-block; margin: 0; padding: 0.5rem 1rem 0 0; min-height: 2rem; color: #6C6C6C; font-weight: normal; font-size: 0.9375rem; text-align: right; }
.form-label label, form.elgg-form .groups-edit-field label { color: #6C6C6C; font-weight: normal; font-size: 0.9375rem; text-align: right; margin:0; }
.form-input, .groups-edit-field .groups-edit-input { flex: 1 1 auto; min-height: 2rem; font-size: 0.75rem; color: #969696; }
.form-input select, .form-input select option, .form-input .input-multiselect button, 
.form-input .elgg-color-picker, 
.form-input textarea, .form-input input, 
.groups-edit-field select, .groups-edit-field select option, .groups-edit-field .input-multiselect button, 
.groups-edit-field .elgg-color-picker, 
.groups-edit-field textarea, 
form.elgg-form .groups-edit-field input { width: 100%; max-width: 100% !important; padding:0.5rem; font-size: 0.75rem; color: #969696; background: white; border-radius: 0; }
.form-input .elgg-color-picker, .groups-edit-field .elgg-color-picker { max-width:none; }
.form-input .input-multiselect, .groups-edit-field .input-multiselect, 
.form-input .input-multiselect button, .groups-edit-field .input-multiselect button { max-width: 22rem !important; }
.form-input ::placeholder, .groups-edit-field ::placeholder { text-transform: uppercase; font-weight: bold; }
.groups-edit-checkbox { margin-left: 9rem; margin-bottom: 0.8rem; }
.groups-edit-checkbox label { color: #6C6C6C; font-size: 0.875rem; font-weight: normal; }
.iris-group-delete { margin-top: 2rem; padding: 2rem 0 4rem 0; border-top: 2px solid #E0E0E0; }
.group-delete-label { width:60%; float:left; }
#iris-body .elgg-context-group_edit .elgg-module-info { border-top: 2px solid #E0E0E0; border-radius: 0; background: transparent; margin-top: 2rem; padding: 2rem 0 0rem 0; }
#iris-body .elgg-context-group_edit .elgg-module-info .elgg-head { background: none; padding: 0; min-height: initial; }
#iris-body .elgg-context-group_edit .elgg-module-info .elgg-head h3 { margin:0; padding: 0; font-weight: bold; color: #384257; font-size: 1.17rem; font-family: "Inria Sans", sans-serif; text-transform: initial; }
#iris-body .elgg-context-group_edit .elgg-module-info .elgg-body { padding: 0; font-size: initial; border: 0; }
#iris-body .elgg-context-groups .elgg-head { width: 100%; float: none; }
.elgg-form-alt > fieldset > .elgg-foot { border:0; }
.elgg-form-theme-inria-file-quick-upload fieldset > div { display: flex; }
.form-input input[type="checkbox"], .form-input input[type="radio"] { width: auto; }


/* Contents and subtype rendering */
.workspace-subtype-header { padding: 1rem 2rem 1rem 2rem; margin: 0 -2rem 0 -2rem; border-bottom: 2px solid #E0E0E0; line-height: 2.25rem; }
.workspace-subtype-header:first-of-type { margin-top: -1.5rem; }
.workspace-subtype-header:last-of-type { margin-bottom: -1.5rem; }
.iris-group-sidebar-alt .workspace-subtype-header { margin-bottom:1rem; }
.workspace-subtype-header h3 { margin:0; padding:0; text-transform: initial; }
.workspace-subtype-header h3 a { font-size: 1.125rem; color: #384257; }
.iris-group-sidebar .workspace-subtype-header .fa-angle-right { line-height: 2.25rem; }
.workspace-subtype-content img { /* max-width: 2.375rem; max-height: 2.375rem; */ max-width:100%; max-height:100%; }
.iris-group-sidebar-alt .workspace-subtype-content .elgg-image-block, 
.iris-group-sidebar .workspace-subtype-content .elgg-image-block { padding:0; display: flex; margin-bottom: 0.625rem; }
.iris-group-sidebar .workspace-subtype-content .elgg-image-block .elgg-image,
.iris-group-sidebar-alt .workspace-subtype-content .elgg-image-block .elgg-image { width:2.5rem; height:2.5rem; margin: 0 0.9375rem 0 0; display:flex; flex: 0 0 auto; }
.workspace-subtype-content .elgg-body { font-size: 0.8125rem; font-weight: bold; margin: auto; }
.workspace-subtype-content .elgg-image span { margin:auto; }
.workspace-subtype-content .file { width:2.5rem; height:2.5rem; display: inline-block; margin: 0 0.625rem 0.625rem 0; border: 1px solid rgba(56, 66, 87, 0.2); }
.workspace-subtype-content .blog .elgg-image, 
.workspace-subtype-content .pages .elgg-image, 
.workspace-subtype-content .bookmarks .elgg-image, 
.workspace-subtype-content .newsletter .elgg-image, 
.workspace-subtype-content .poll .elgg-image, 
.workspace-subtype-content .feedback .elgg-image { border: 1px solid rgba(56, 66, 87, 0.2); }
.workspace-subtype-content .blog {  }
.workspace-subtype-content .pages {  }
.workspace-subtype-content .bookmarks {  }
.workspace-subtype-content .newsletter {  }
.workspace-subtype-content .poll {  }
.workspace-subtype-content .event_calendar {  }
.workspace-subtype-content .feedback {  }

.bookmarks-address { margin-bottom: 1rem; word-break: break-all; }

.elgg-image .date-in-month { background: #FD6356; }
.calendar-action { color: #1488CA; font-size: 1.3125rem; }
.workspace-subtype-content .calendar-action { color: #1488CA; font-size: 1.3125rem; }
.workspace-subtype-content h4, .workspace-subtype-content h4 a, .workspace-subtype-content a h4 { font-size: 0.9375rem; color: #384257; margin:0; }

.elgg-form-poll-vote, .poll_post_body { margin-bottom: 1.5rem; }
.poll-show-link { background: #1488CA; color: white; padding: 0.5rem 1rem 0.3rem 1rem; border-radius: 2rem; }
a.poll-show-link, a.poll-show-link:hover, a.poll-show-link:active, a.poll-show-link:focus { color: white !important; }
.elgg-form-poll-vote li { display: inline-block; }
.iris-object-full .elgg-form-poll-vote label { font-size: 1.3rem; }

.iris-sidebar-content .ui-datepicker-inline { max-width: 100%; font-size: 0.75rem; }
.iris-sidebar-content .ui-datepicker td { padding: 0; }
.iris-sidebar-content .ui-state-highlight, .iris-sidebar-content .ui-widget-content .ui-state-highlight, .iris-sidebar-content .ui-widget-header .ui-state-highlight { border:0; }
.iris-sidebar-content .ui-state-default, .iris-sidebar-content .ui-widget-content .ui-state-default, .iris-sidebar-content .ui-widget-header .ui-state-default { border:0; background:white; height:26px; width:26px; line-height:22px; text-align:center; display:inline-block; border-radius:13px; }
.iris-sidebar-content .ui-datepicker-current-day a.ui-state-default, .iris-sidebar-content .ui-datepicker-today a.ui-state-default { background: #384257; color: white; }
.iris-sidebar-content #calendarmenucontainer { display: none; /* left:initial; margin: 0 auto; font-size: 0.75rem; */ }

.membership-group-open, .membership-group-closed { background: none;padding-left: 0; }

.iris-group-sidebar .group-membership-actions { padding: 0rem 0rem 3rem 0rem; }
#iris-body .iris-group-sidebar .group-membership-actions a { color: white; }
.iris-group-title .group-membership-actions { float: right; }
.iris-group-title .group-membership-actions a { width: 3rem; height: 3rem; border-radius: 3rem; color: white; text-align: center; line-height: 3.4rem; font-size: 1.4rem; background: #384257; display: inline-block; margin: 0rem 0 0 2rem; }
.iris-group-title .group-membership-actions a.group-join { background: #00D424; /* #1488CA */ }
.iris-group-title .group-membership-actions a.group-request { background: #1488CA; /* #D47D00 */ }
.iris-group-title .group-membership-actions a.group-leave { background: #FF0000; }

.group-workspace-select { padding: 1rem 0 3rem 0; }
.group-workspace-select select { max-width: 30rem; }



/* TESTS */
/*
menu : 12.75 = 204
contenu : 40 + 8 + 33 = 81 = 1500

*/

.elgg-layout-group { flex-wrap: nowrap; }
.iris-group-sidebar { <?php echo $width['sidebar']; ?> margin-left: 0rem; padding: 0; }


.elgg-sidebar { <?php echo $width['sidebar']; ?> }
.sidebar-alt { <?php echo $width['sidebar_alt']; ?> }
#iris-body .elgg-layout-one-sidebar .elgg-sidebar { /* padding: 2.5rem 0rem 2.5rem 0; */ }

.iris-box { max-width: initial; }

.messages-buttonbank, .elgg-layout-one-sidebar .elgg-form.thewire-form, .elgg-layout-one-sidebar .elgg-main .elgg-list-container { max-width: initial; }
.elgg-foot.messages-buttonbank input { margin-bottom: 1rem; }
.elgg-layout-one-sidebar .thewire-form textarea { /* width: calc(100% - 6rem); */ margin-top: 0; flex: 1 1 auto; }

.elgg-main #event_list { min-width: 20rem; flex: 1 1 0%; margin: 0 2.5rem 2.5rem 0; max-width: 46rem; background: white; padding: 1rem 1rem; border-radius: 4px; box-shadow: 0 0 4px 0 rgba(189,189,189,0.5); }
.event_calendar_agenda .event_calendar_agenda_date { margin-bottom: 1rem; }
.event_calendar_agenda .event_calendar_agenda_date_section tr { padding: 0.5rem 1rem; }
.event_calendar_agenda .event_calendar_agenda_date_section td { padding: 0.5rem 1rem; }
.elgg-context-event_calendar .elgg-sidebar .iris-object-actions { display: none; }

.iris-group-sidebar-alt { <?php echo $width['sidebar']; ?> padding: 0 0rem 1rem 0rem; }

.elgg-module-aside .elgg-head, .elgg-module.elgg-module-aside .elgg-body { margin: 0; padding: 0; }

.elgg-body-transp .comment_trackerWrapper { margin: 0rem 0rem 1rem 0rem; padding: 0; border: 0; }
form.elgg-form-rate-rate { margin: 0 -2rem 2rem -2rem; padding: 0 2rem 1rem 2rem; border-bottom: 2px solid #F1F1F1; }



/* LISTINGS - NORMALISED */
.elgg-item-object .elgg-image-block .elgg-image { margin:0; }
.elgg-image-block.elgg-river-item, 
.iris-object-listing .elgg-image-block, 
.iris-object-content .elgg-image-block { display: flex; }
.iris-object-content .elgg-image-block .elgg-image { /* margin-right: 2rem; */ }
.elgg-item-object .elgg-image-block .elgg-image a { display: flex; /* width: 6rem; height: 5rem; */ }
.elgg-item-object .elgg-image-block .elgg-image a.medium img { margin: 0 1.3125rem !important; }
.elgg-context-workspace .elgg-item-object .elgg-image-block .elgg-image a.medium img { width: 3.375rem; height: 3.375rem; }
.elgg-item-object .elgg-image-block .elgg-image a span.small { width: 3.375rem; height: 3.375rem; margin: 0 1.3125rem !important; }

.elgg-item-object .elgg-image-block .elgg-image a.file-image { width: 6rem; min-height: 3.375rem; }
.elgg-item-object .elgg-image-block .elgg-image a.file-image img { margin: auto; max-width: 5rem; }

.elgg-image-block .elgg-image .fa { color: #aaa; }
.elgg-item-object-file .iris-object { word-break: break-all; }

.entity-headline { display:flex; margin-bottom: 0.2rem;}
.entity-headline .owner-icon { flex:0; margin-right: 1rem; }
.entity-headline .entity-title { flex:1; margin-right: 1rem; line-height: 2rem; }
.iris-object .elgg-river-timestamp { line-height: 1rem; margin: 0 0 0 1rem; }
.iris-object .elgg-access { margin: 0 0 0 1rem; line-height: 1rem; }
.iris-object .elgg-access a { color: rgba(56, 66, 87, 0.5); font-size: 0.75rem; }
.entity-headline .entity-menu { flex:0; }

.elgg-item-object.elgg-item-object-feedback .elgg-image-block { display: flex; }
.elgg-item-object.elgg-item-object-feedback .elgg-image-block .elgg-image { margin-right: 1rem; }
.elgg-context-feedback:not(.elgg-context-workspace-content) .elgg-body > .elgg-list-container { margin: -2rem; }
.elgg-context-feedback:not(.elgg-context-workspace-content) .elgg-body > .elgg-list-container .elgg-list-entity { margin: 0; }
.elgg-context-feedback:not(.elgg-context-workspace-content) .elgg-body > .elgg-list-container .elgg-list-entity li.elgg-item-object-feedback { margin: 0; }
.elgg-context-feedback:not(.elgg-context-workspace-content) .elgg-body > .elgg-item-object.elgg-item-object-feedback .elgg-image-block { margin: 0; border: 0; }
.elgg-context-feedback:not(.elgg-context-workspace-content) .elgg-body > .elgg-item-object.elgg-item-object-feedback .elgg-image-block .elgg-image { margin-right: 2rem; }
.elgg-context-feedback .elgg-body-transp .elgg-image-block { margin: 0; padding: 1rem; border: 0; }
/*
*/
.elgg-context-feedback:not(.elgg-layout-group) .elgg-body { <?php echo $width['main']; ?> }
.elgg-context-feedback:not(.elgg-layout-group) .elgg-body .elgg-image-block { margin: 1rem 0 0 0; }



.object-poll-workspace { margin-bottom: 2rem; }
.object-poll-workspace:first-of-type {  }
.object-poll-workspace:last-of-type { margin-bottom: 0; }
.poll_input-poll-choice { margin-bottom: 0.2rem; }
.elgg-form-poll-edit #add-choice { }
div.poll_closing-date-open, div.poll_closing-date-closed { color: #969696; }


/* Object types workspace rendering */
p.file-meta { margin-bottom: 1rem; margin-top: -1rem; }
.file-filename { display: block; font-weight: bold; padding: 0.5rem 0; }
.file-simpletype, 
.file-mimetype, 
.file-size, 
.file-extension { font-size: 0.75rem; font-weight: bold; color: #969696; margin-right: 0.5rem; }
.file-size, 
.file-extension { text-transform: uppercase; }
.file-mimetype:before { content:'('; }
.file-mimetype:after { content:')'; }
.iris-object-content .file-filename { display: inline; margin-right: 1rem; }
.elgg-list .elgg-item .elgg-image-block.iris-object-inner { border: 1px solid rgba(56, 66, 87, 0.2); padding: 0.5rem; margin-bottom: 0.5rem; display: block; }
.elgg-image-block.iris-object-inner .elgg-image { min-width: 2rem; min-height: 3.75rem; display: flex; }
.elgg-image-block.iris-object-inner .elgg-image img { flex: 0 0 auto; margin-top: auto; margin-bottom: auto; }
.elgg-list .elgg-item .elgg-image-block.iris-object-inner .elgg-photo { border: 0; padding: 0; margin-right: 0.5rem; }
.elgg-button .file-size, .elgg-button .file-extension { margin: 0 0 0 1rem; color: #CCCCCC; }
.file-photo a { display: block; position: relative; margin: 0 -2rem 0 -2rem; }
.file-photo img.elgg-photo { /* width: 100%; */ border:0; }
.file-photo a .file-colorbox-link { background: #1488CA; position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.6; }
.file-photo a .file-colorbox-link i { color: white; margin: auto; font-size: 2rem; }
.file-photo a:hover .file-colorbox-link, .file-photo a:active .file-colorbox-link, .file-photo a:focus .file-colorbox-link { display: flex; }

.elgg-event-timestamp { color: #969696; font-size: 0.9rem; font-style: normal; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem; display: inline-block; }
.elgg-event-location { text-transform: uppercase; font-size: 0.85em; font-weight: bold; }
.event_calendar-date { margin-bottom: 1rem; }
.elgg-item-object .elgg-image-block.event_calendar-date .elgg-image { padding: 0.5rem 0 0 0; margin-right: 1rem; }
.event_calendar-date .elgg-body { padding: 0.5rem 0; }
.event-calendar-repeating-wrapper { display: flex; }
.event-calendar-repeating-selected, 
.event-calendar-repeating-unselected { font-size: 1rem; flex: 1 1 2rem; }


#iris-body .iris-object h3 { display: block; padding: 0; margin-bottom: 0.5rem; }
#iris-body .iris-object h3 a { color: #384257; padding: 0; }
#iris-body .iris-object h2 { padding: 0; }

.entity-menu a { color: rgba(56, 66, 87, 0.5); font-size: 1.25rem; }
/*
*/
.iris-object-actions { display: flex; margin-top: 1rem; }
.iris-object-actions ul { flex: 1 1 auto; }
.iris-object .elgg-menu-entity, .iris-object .elgg-menu-entity-alt { margin: 0 0 0.5rem 0; max-width: none; font-size: 0.8125rem; text-align: left; }
.iris-object .elgg-menu-entity-alt { text-align: right; }
.iris-object .elgg-menu-entity li, .iris-object .elgg-menu-entity-alt li { display: inline-block; color: rgba(56, 66, 87, 0.5); margin: 0; }
.iris-object .elgg-menu-entity li a { margin: 0 1rem 0 0; }
.elgg-menu-entity-alt li a { display: inline-block; margin-left: 1rem; }
.iris-object .elgg-menu-entity a, .iris-object .elgg-menu-entity-alt a { color: rgba(56, 66, 87, 0.5); }
.iris-object .elgg-menu-entity a:hover, .iris-object .elgg-menu-entity-alt a:hover { color: #384257; }
a[name=like] { color: rgba(56, 66, 87, 0.5); }
a[name=unlike] { color: #1488CA !important; }
.iris-object .elgg-menu-entity svg { height: 0.8125rem; line-height: 0.8125rem; fill: rgba(56, 66, 87, 0.5); }

.iris-object .elgg-content { margin: 0.5rem 0; line-height: 1.25; }

#cboxWrapper { /* max-width: 36rem; width: 36rem; */ }
#cboxContent { /* padding: 1rem 1rem 3rem 1rem;*/ /* min-width: 27rem; width: 32rem; max-width: 100%; */ }
/*
#cboxLoadedContent { margin: 0 0 2rem 0; padding: 0rem; max-width: calc(100% - 2rem); max-width: 32rem; }
*/
#cboxLoadedContent { margin: 2rem auto 0 auto; padding: 0rem; /* min-width: 32rem; width: auto; */ max-width: 100%; }
#cboxLoadedContent .elgg-pagination { /* display: inline-block; */ text-align: center; }
#cboxClose { top: 0; bottom: initial; }
.embed-wrapper { /* width: 32rem; max-width: 100%; */ width: unset !important; }

.cke_reset_all a, .cke_reset_all * { box-sizing: content-box !important; }

.elgg-likes-popup { max-width: 100%; width: 100%; }
.elgg-likes-popup .elgg-list { margin: 0; }
.elgg-likes-popup .elgg-list .elgg-item { padding: 0rem 0rem 0rem 0rem; box-shadow: none; border: 0; margin: 0 0 1rem 0; }

.iris-object.iris-object-full { margin: 0 -2rem 2rem -2rem; padding: 0 2rem 1rem 2rem; /* border-bottom: 2px solid #F1F1F1; */ }
.iris-object.iris-object-full .entity-headline { margin: 0 -2rem 0 -2rem; padding: 0 2rem 1rem 2rem; /* border-bottom: 2px solid #F1F1F1; */ }
.elgg-layout-user-owner .iris-object.iris-object-full .entity-headline { margin: 0; padding: 0 0rem 1rem 0rem; }

.elgg-body-transp .elgg-comments .elgg-image-block { margin: 0; border: 0; padding: 0.5rem 0rem; }
.elgg-body-transp .elgg-comments .elgg-image-block .elgg-image { margin: 0rem 0.5rem 0rem 0rem; }

.elgg-body-transp .elgg-comments .elgg-menu-entity li { margin: 0 0.5rem 0 0; }





/* FLEX SAFARI DEBUG */
/*
.elgg-context-main .iris-col, .iris-col { flex-basis: 0 !important; }
.elgg-main { flex-basis: auto !important; }
.elgg-main { flex-basis: auto !important; }
*/

/* Valeurs valides selon les navigateurs
Accueil : .elgg-context-main .iris-col
	Chrome flex-basis 0% ou 0, pas auto
	Firefox flex-basis 0% ou 0, pas auto
	Safari

Profil : .iris-col
	Chrome flex-basis 0% ou 0, pas auto
	Firefox flex-basis 0% ou 0, pas auto
	Safari

Accueil groupe : .elgg-main
	Chrome flex-basis 0% ou 0, pas auto
	Firefox flex-basis 0% ou 0, pas auto
	Safari

Feedback : .elgg-main
	Chrome flex-basis 0% ou auto, pas 0
	Firefox flex-basis 0% ou auto, pas 0
	Safari


Conclusions : 
iris-col => 0 ou 0%
elgg-main => 0% marche partout, 0 et auto selon les endroits

*/



/*
@media (max-width:1550px) {
	.elgg-sidebar { order:1; }
	.sidebar-alt { order:2; }
	.elgg-main { order: 3; }
}
*/


/* VUES RESPONSIVE */

@media (max-width:1400px) {
	#iris-navigation { display: none; }
	.menu-navigation-toggle { display: block; }
}

@media (max-width:1200px) {
	.elgg-layout { flex-wrap: wrap; }
	
	.elgg-page .elgg-layout .sidebar-alt, 
	.elgg-page .elgg-layout .elgg-sidebar { display: block; <?php echo $width['sidebar']; ?>; margin: 0 2.5rem 2.5rem 0 !important; }
	.menu-sidebar-toggle { display: none; }
}


@media (max-width:1088px) {
	/*
	.elgg-layout.elgg-context-workspace { flex-wrap: wrap; }
	.elgg-context-workspace .elgg-main { order: 1; }
	.elgg-context-workspace .elgg-sidebar { order: 2; }
	.elgg-context-workspace .sidebar-alt { order: 3; }
	*/
	
	.elgg-layout-group-add .sidebar, .elgg-layout-group-add .sidebar-alt { display: none; }
	
}


@media (max-width:1020px) {
	.elgg-main, .elgg-page .elgg-layout .elgg-main { /* padding: 1rem 2rem !important; */ margin: 0 2.5rem 2.5rem 0; }
	.full-screen #iris-body .iris-group .elgg-main { width: auto; margin: 0.2rem 0.3rem; }
	.full-screen .elgg-body-transp .elgg-button-fullscreen { right: 1rem; top: 0.75rem; }
	
	.elgg-page .elgg-layout .sidebar-alt, 
	.elgg-page .elgg-layout .elgg-sidebar { display: block; <?php echo $width['sidebar']; ?>; padding: 0; }
	.menu-sidebar-toggle { display: none; }
}


@media (max-width:980px) {
	.elgg-menu-topbar { /* position:absolute; top: 11px; right:5px; margin-left: 140px; */ }
	.elgg-layout { flex-direction: column; }
	.elgg-layout-group { margin-top: 0; }
	.menu-topbar-toggle { color: white; }
	
	.elgg-body-transp { flex-basis: auto; }
	#iris-body .iris-group .elgg-context-group_content .elgg-main { flex-basis: auto; }
	
	.profile-col-profile { width:40%; }
	.profile-col-details { width:60%; }
	.profile-col-activity { width:100%; }
	.profile-col-profile2 { width:33%; }
	.profile-col-largedetails { width:66%; }
	
	.elgg-page .elgg-layout .sidebar-alt, 
	.elgg-page .elgg-layout .elgg-sidebar { display: none; width: auto; }
	
	.elgg-sidebar { order: 1; }
	.sidebar-alt { order: 2; }
	.elgg-main { flex-basis: auto; order: 3; }
	.menu-sidebar-toggle { display: initial; min-width: 1.5rem; flex: 0 0 auto; padding: 2.5rem 0; margin: -2.5rem -0.5rem 0rem -2.5rem; font-size: 1.5rem; }
	.elgg-sidebar .menu-sidebar-toggle { display: block; padding: 2.5rem 0 1rem 0; margin: -3rem -1rem 1rem -1rem; }

	#iris-body .elgg-layout-one-sidebar .elgg-main { width: auto; padding:0; max-width: none; flex-basis: auto; }
	.elgg-page .elgg-layout .elgg-main { flex-basis: auto; }
	#iris-body .elgg-layout-one-sidebar .elgg-sidebar { width: auto; max-width: none; /* background: rgba(0,0,0,0.1) !important; */ padding: 0.5rem 1rem; border: 0; /* box-shadow: 0px 6px 5px -5px rgba(189,189,189,0.5) !important; */ }
	.iris-group-sidebar-alt { max-width: none; }
	
	#iris-body .elgg-context-login .elgg-main, #iris-body .elgg-context-register .elgg-main { margin: 1rem 0; }
	
	.group-content-filter.tabs { clear: both; }
	.group-content-filter.tabs a { margin-right: 1.125rem; }
	
	.elgg-context-workspace-content .elgg-image-block { margin: 0; }
	.elgg-context-workspace-content .elgg-image-block .elgg-image { display: block; min-height: 6rem; flex: 0 0 auto; margin: 0; box-shadow: none; width: auto; background: none; }
	.elgg-context-workspace-content .elgg-image-block .elgg-body { min-height: 6rem; padding: 0; }
	.iris-object-actions { margin-bottom: 1rem; }
	
	.elgg-item-object .elgg-image-block .elgg-image a.medium img { margin: 0 1rem 0 0 !important; }
	
	#iris-topbar-search-input { display: none; }
	
}



/* VUES MOBILES */
@media (max-width:768px) {
	* { min-width: initial !important; max-width: initial !important; }
	
	/* Topbar */
	.iris-logo { flex: 0 0 8.5rem; }
	.iris-logo img { margin: 1.1875rem 2rem; }
	.elgg-menu-topbar { margin-left: 0; display: block; }
	.iris-topbar-item.elgg-menu-topbar ul { position: fixed; top: 5.1rem; right: 0.1rem; left: 0.1; padding: 0 1rem 0 0; }
	.iris-topbar-menu #user { max-width: 2.5rem; height: 4rem; overflow: hidden; margin-left: 0.5rem; }
	.iris-topbar-item.elgg-menu-topbar li#user > a { padding: 0; line-height: 2.5rem; width: 2.25rem; height: 2.25rem; overflow: hidden; }
	.iris-topbar-item > a { padding-bottom: 1.75rem; }
	#logout a.login-as-topbar { padding: .75rem 0.5rem; text-decoration: none; }
	#notifications .notifications-panel { position: fixed; left: 0.1rem; right: 0.1rem; top: 5.1rem; width: auto; }
	#notifications .notifications-panel .tabs a { margin-left: 1rem; }
	
	/* Navigation menu */
	#iris-navigation.menu-enabled { padding-top: 0; }
	#iris-navigation ul.elgg-menu-navigation li a { font-size: 1.5rem; line-height: 2rem; display: inline-block; }
	#iris-navigation ul.elgg-menu-navigation svg { height: 2rem; }
	#iris-navigation ul.elgg-menu-navigation li ul li a { display: block; font-size: 1.2rem; }
	
	/* Footer */
	#iris-footer { position: initial; bottom: 0; left: 0; right: 0; margin: 1rem -1rem -1rem -1rem; border-top: 1px solid rgba(255,255,255,0.5); }
	.footer-logo-inria { margin: 12px 0; }
	#iris-footer li a { font-size: 1.2rem; }
	
	/* Main layout */
	.elgg-layout.elgg-context-profile.elgg-context-profile_edit, 
	.elgg-layout { padding: 0 1.5rem; flex-direction: column; /* flex-basis: 0%; */ }
	.elgg-layout .elgg-main h2 { margin-top: 1rem; }
	#iris-page { display: block; }
	#iris-navigation ul.elgg-menu-navigation li ul.hidden { display: block !important; }
	.iris-cols { display: block; }
	#iris-body .elgg-layout-one-sidebar.elgg-context-invite_external .elgg-main, #iris-body .elgg-layout-one-sidebar.elgg-context-messages .elgg-main, #iris-body .elgg-layout-user-owner:not(.elgg-layout-content) .elgg-main { margin-right: 0; }
	#iris-body .elgg-layout-one-sidebar .elgg-main { margin-right: 0; }
	
	/* Sidebar */
	.elgg-page .elgg-layout .elgg-sidebar, 
	.elgg-page .elgg-layout .sidebar-alt { max-width: none; width: auto; }
	.elgg-menu-owner-block li a, .elgg-sidebar ul.elgg-menu-page li a { border: 0; }
	.menu-sidebar-toggle { margin: -2.5rem -1.5rem -0.5rem -1.5rem; }
	.elgg-sidebar .menu-sidebar-toggle { /* margin: 0 -1.5rem; */ }
	/* Alt Sidebar */
	.iris-group-sidebar-alt { margin: 0 0 2.5rem 0; }
	
	/* Listings */
	.elgg-list .elgg-item { padding: 1rem; }
	
	/* Recherche group user object */
	.iris-search-header { height: 14rem; }
	#iris-body .iris-search-quickform h2 { font-size: 1.75rem; line-height: 2rem; margin-bottom: 1rem; }
	.iris-search-image { top: 1rem; left: 1rem; padding: 0.5rem; width: 6rem; height: 6rem; }
	.iris-search-quickform { top: 1rem; left: 8rem; width: 18rem; }
	#iris-search-quickform { height: 2.5rem; line-height: 2.5rem; width: 18rem; }
	#iris-search-quickform #iris-search-header-input { width: 16rem; }
	.iris-search-reset, #iris-search-quickform input[type="reset"] { line-height: 2rem; }
	.iris-search-menu { padding-left: 1rem; }
	#esope-search-results .elgg-menu-entity { text-align: center; float: none; }
	#esope-search-results .elgg-item-user h3 { margin: 0.5rem; padding: 0; font-size: 1rem; }
	
	.elgg-sidebar h3, #esope-search-form h3 { margin-bottom: 1rem; }
	.esope-search-metadata { padding-bottom: 0.5rem; margin-bottom: 0.5rem; }
	
	span.iris-badge { display: block; margin-top: 0.5rem; }
	
	/* Profil */
	.elgg-layout.elgg-context-profile { padding: 0; }
	.iris-profile-header { min-height: 10rem; height: auto; }
	.iris-profile-header > a { display: flex; flex-wrap: wrap; }
	.iris-profile-header > a .iris-profile-icon { flex: 0 0 auto; position: initial; margin: 2rem 0rem 2rem 2rem; }
	.iris-profile-header > a .iris-profile-title { flex: 1 1 0%; position: initial; margin: 2rem 0rem 2rem 2rem; }
	.iris-profile-title { top: 1rem; left: 8rem; }
	#iris-body .iris-profile-title h2 { font-size: 1.75rem; line-height: 2rem; }
	.iris-profile-icon { top: 1rem; left: 1rem; width: 6rem; height: 6rem; }
	.iris-profile-editavatar { padding: 2rem 1rem; }
	.iris-profile-editavatar .fa { font-size: 1.5rem; }
	.iris-profile-addfriend { right: -1rem; top: -1rem; }
	.iris-profile-removefriend { right: -1rem; top: 1rem; }
	.iris-profile-isfriend { right: -1rem; top: -11rem; }
	.iris-profile-pendingfriend { right: -1rem; top: -1rem; }
	.iris-profile-sendmessage { right: -1.5rem; top: 3.5rem; }
	.iris-profile-info { padding-left: 1rem; }
	.profile-col-profile, .profile-col-details { width:46%; }
	.profile-col-activity { width:100%; }
	.profile-col-profile2, .profile-col-largedetails { width:100%; }
	.profile-col-profile .profile { float:none; width:40%; }
	
	/* Groupe */
	.iris-group-header { min-height: 16rem; }
	.iris-group-image { height: 6rem; width: 6rem; top: 1rem; left: 1rem; }
	.iris-group-title { top: 1rem; right: 1rem; left: 8rem; }
	#iris-body .iris-group-title h2 { font-size: 1.75rem; line-height: 2rem; }
	.iris-group-menu { padding-left: 1rem; }
	.iris-group-subtitle { margin: 0.5rem 0 1rem 0; font-size: 0.9rem; font-weight: normal; }
	.iris-group-rules { font-size: 1rem; }
	.iris-group-menu a, .iris-group-menu .tab-more { font-size: 1rem; padding: 1rem 0; }
	.iris-group-menu a.add { width: auto; padding: .25rem .75rem 0rem .75rem; margin: 0.5rem; }
	
	.groups-edit-field { display: block; }
	.groups-edit-field .groups-edit-label, 
	.groups-edit-field .groups-edit-input { width: auto; text-align:justify; }
	
	/* River */
	.elgg-menu-river lifloat, .elgg-menu-river li.elgg-menu-item-container, .elgg-menu-river li.elgg-menu-item-access { clear: left; }
	
	/* Feedback */
	#feedbackWrapper #feedBackContentWrapper { background: #384257; z-index: 501; }
	#feedbackWrapper #feedBackContent { width: auto; padding: 1rem; margin: 1rem; }
	
	
	/* Chat */
	.elgg-page #groupchat-grouplink, 
	.elgg-page #groupchat-sitelink { display: block; border: 0; box-shadow: none; color: rgba(255,255,255,0.5); background: transparent; margin: 0; width: auto; height: auto; padding: 1rem 0 0.5rem 1rem; text-indent: 0; text-transform: uppercase; text-decoration: none; font-size: 1.5rem; }
	
	
}


@media (max-width: 700px) {
	.cas-login, .basic-login-toggle { float: none; }
	.inria-login { text-align: center; }
	.basic-login-toggle, #adf-homepage .inria-login .basic-login-toggle { float:none; }
	
	body .elgg-page-messages .elgg-system-messages { right: auto; top: 5rem; margin: 0 1rem; width: calc(100% - 2rem); }
	
	/* Feedback */
	#feedbackWrapper { position: fixed; bottom: 0; top: initial; }
	#feedBackContentWrapper { background: #384257; z-index: 501; }
	#feedBackContent { width: auto; padding: 1rem; margin: 1rem; }
	
}


@media (max-width: 600px) {
	div.elgg-subtext { float:none; margin-right: 0; }
	
}

@media (max-width: 500px) {
	#esope-search-results .elgg-menu-entity { margin-bottom: 0.5rem; }
	.elgg-item-group .iris-group-body { padding: 0.5rem 1rem 0.5rem 1rem; }
	.elgg-item-group .elgg-image-block .elgg-image a { width: 7.5rem; min-height: 7.5rem; height: auto; }
	.elgg-item-group .elgg-image-block .elgg-image { margin-right: 0.875rem; }
	
	.iris-listing .elgg-list .elgg-item.elgg-item-group, .iris-groups-member-new { flex-shrink: 1;  margin-right: 0; height: auto; margin-bottom: 1rem; }
	.iris-object-actions { margin-bottom: 0.5rem; }
	
		/* Home */
	.entity-headline .entity-title { line-height: normal; }
	.iris-home-discover-groups { flex-wrap: wrap; margin: 0 -0.25rem; }
	.iris-home-group-category, .iris-home-group-category:last-of-type { margin: 0.25rem; }
	
	.elgg-list .elgg-item { margin-bottom: 0.5rem; padding-bottom: 0.5rem; }
	.elgg-context-thewire:not(.elgg-context-workspace-content) .elgg-list .elgg-item, .iris-box .elgg-list .elgg-item { padding-bottom: 0.5rem; }
	
	
	
}

@media (max-width: 420px) {
	.iris-topbar-menu { padding-left: 0; }
	#iris-topbar-search { padding-left: 0.5rem; }
	.iris-topbar-item > a { padding: 0.75rem 0.5rem; }
	.iris-topbar-menu #user { margin-left: 0; }
	
	.iris-groups-community { flex-direction: column; padding: 0 1rem 1rem 1rem; margin-right: 0; min-height: initial; }
	.iris-community-icon { margin: 0 auto; }
	.iris-community-body { text-align: center; }
	div.iris-community-icon, .iris-community-icon img { width: 4.375rem; height: 4.375rem; }
	
	.elgg-item-group .elgg-image-block .elgg-image, .elgg-item-group .elgg-image-block .elgg-body { float: none; margin: 0; }
	.elgg-item-group .elgg-image-block .elgg-image a { text-align: center; margin: 0; display: block; min-height: 0; height: 7.5rem; width: auto; }
	ul.elgg-list li.elgg-item.elgg-item-group div.elgg-image a img, .elgg-item-group .elgg-image img { height: auto; width: auto; }
	
	.esope-results-count { margin-top: 0; margin-bottom: 0; min-width: 10rem; }
	
}

