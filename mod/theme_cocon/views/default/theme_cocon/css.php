<?php
global $CONFIG;
$fonturl = $CONFIG->url . 'mod/theme_cocon/fonts/';
$imgurl = $CONFIG->url . 'mod/theme_cocon/graphics/';
$picto_module = $imgurl . 'pictos/module_';
$sideicon = $imgurl . 'side_icons/';
$sidecolor = "#00668c";
// @TODO : list tools colors here for quicker changes

?>

/* Add some fonts : local + GFont as failsafe */
@font-face {
	font-family: 'Montserrat'; font-style: normal; font-weight: 400;
	src: local('Montserrat-Regular'), url('<?php echo $fonturl; ?>Montserrat/Montserrat-Regular.ttf') format('truetype'), url(http://themes.googleusercontent.com/static/fonts/montserrat/v4/zhcz-_WihjSQC0oHJ9TCYBsxEYwM7FgeyaSgU71cLG0.woff) format('woff');
}
@font-face {
	font-family: 'Montserrat'; font-style: normal; font-weight: 700;
	src: local('Montserrat-Bold'), url('<?php echo $fonturl; ?>Montserrat/Montserrat-Bold.ttf') format('truetype'), url(http://themes.googleusercontent.com/static/fonts/montserrat/v4/IQHow_FEYlDC4Gzy_m8fcgFhaRv2pGgT5Kf0An0s4MM.woff) format('woff');
}
@font-face {
	font-family: 'MontserratBold'; font-style: normal; font-weight: 700;
	src: local('Montserrat-Bold'), url('<?php echo $fonturl; ?>Montserrat/Montserrat-Bold.ttf') format('truetype'), url(http://themes.googleusercontent.com/static/fonts/montserrat/v4/IQHow_FEYlDC4Gzy_m8fcgFhaRv2pGgT5Kf0An0s4MM.woff) format('woff');
}


/* Interface */
html, body { background: url(<?php echo $imgurl; ?>background.jpg) top left no-repeat; background-size: cover; background-attachment:fixed; border-top:0; }
header { background: transparent; border-top:0; height:120px; }
header h1 { margin-top: 17px; }
header h1:hover { text-decoration:none; }
header nav { background: #00668c; top: 0; padding: 4px 4px 1px 4px; border-radius: 0 0 12px 12px; }
header nav ul li { margin-left:3px; margin-right:3px; float:none; display: inline-block; height:23px; }
header nav ul li a { line-height: 20px; text-align: center; font-size: 10px; font-weight: normal; color:white; text-shadow:none; padding: 0; display: inline-block; vertical-align: top; text-decoration: none !important; }
header nav ul li a img { width: 18px; height: 18px; background: transparent; border-radius: 10px; border:0; }
header nav a .fa { margin-right: 0; width: 18px; height: 18px; line-height: 18px; background: white; border-radius: 10px; font-size:10px; color: #00658d; }
#user img { float: left; }
header .interne nav ul li.invites a, header .interne nav ul li.group-invites a { width: auto; height: auto; background: red !important; line-height: initial; padding: 2px 5px 2px 6px !important; font-size:10px !important; }
#transverse nav ul li.group-invites, .interne nav ul li.group-invites, #transverse nav ul li.invites, .interne nav ul li.invites { margin: -6px 4px 0 0 !important; }

#transverse { box-shadow:none; border-bottom:0; background:white; height:40px; }
#transverse nav ul li { border-right:0; padding-left:0; }
#transverse nav ul li:first-child { border-left:0; }
#transverse nav ul li a { color:#2a7d9f; line-height: 40px; padding: 0 10px; font-size: 17px; }
#transverse nav ul li ul li a { line-height: 2em; font-weight:normal; }
#transverse nav ul li a.active, #transverse nav ul li a.elgg-state-selected, #transverse nav ul li a:hover, #transverse nav ul li a:focus, #transverse nav ul li a:active { background-color: #02658e; color: white; }
#transverse nav ul li ul li a:hover, #transverse nav ul li ul li a:focus, #transverse nav ul li ul li a:active { background: #02658e; }
/* Search form */
#transverse form { border: 0; }
::-webkit-input-placeholder { color:#2a7d9f; }
:-moz-placeholder { color:#2a7d9f; }
::-moz-placeholder { color:#2a7d9f; }
:-ms-input-placeholder { color:#2a7d9f; }
form input#adf-search-input, form input#adf-search-input:active, form input#adf-search-input:focus { color:#2a7d9f; border-radius:0; background:#e4ecf5; }
form input#adf-search-submit-button, form input#adf-search-submit-button:active, form input#adf-search-submit-button:focus { background:white !important; border:0 !important; padding: 0px 0px 0px 8px; height: 27px; }
.elgg-form.elgg-form-groups-search #q { background:#e4ecf5; }

/* Footer */
footer.footer-cocon { height: 37px; background:#2a7d9f; }
footer.footer-cocon ul { width:auto; }
footer.footer-cocon ul li { margin: 10px 7px 6px 0; }
footer.footer-cocon ul li:first-child { padding-left:0; }
footer.footer-cocon ul li a { font-size: 14px; font-family: Montserrat, sans-serif; }
footer.footer-cocon ul li { background: transparent url("<?php echo $imgurl; ?>puce_footer.png") left 5px no-repeat; }


/* Barre latérale */
/*
.elgg-sidebar { background: rgba(255,255,255,0.9); }
*/
.elgg-sidebar .elgg-module-aside { background: white; }

/* Agenda */
.elgg-context-event_calendar .elgg-sidebar { background: transparent; }


/* Boutons */
.elgg-button {
	/* border: 1px solid white !important; */
	/* background: transparent !important; */
	box-shadow: 0 1px 3px #00668c;
	border-radius: 16px !important;
	border:0;
}
/* Boutons action & submit */
.elgg-button-action, .elgg-menu .elgg-button-action, .elgg-button-submit { color:#00658f; text-shadow: none; }
.elgg-menu.elgg-menu-entity li a { color:#00658f; text-shadow: none; }
.elgg-button-action:hover, .elgg-button-action:focus, .elgg-button-action:active, .elgg-menu .elgg-button-action:hover, .elgg-menu .elgg-button-action:focus, .elgg-menu .elgg-button-action:active, .elgg-button-submit:hover, .elgg-button-submit:focus, .elgg-button-submit:active, .elgg-button.elgg-button-action.profile-manager-account-change-username:hover, .elgg-button.elgg-button-action.profile-manager-account-change-username:active, .elgg-button.elgg-button-action.profile-manager-account-change-username:focus { background:#00658f; color:white; border:0; }

/* Bouton delete */
.elgg-button-delete { background:#c34840; border-color:#993333; text-shadow: none; box-shadow: 0 1px 3px 0 #c34840 !important; color:white; }
.elgg-button-cancel { background: #ddd; box-shadow: 0 1px 3px 0 #666; }
/* Bouton désactivé */
.elgg-button.elgg-state-disabled { color: #333; box-shadow: 0px 1px 3px 0 #666 !important; }
/* View all button */
.home-box .viewall, span.groups-widget-viewall { border-radius: 20px; display: inline-block; padding: 3px 6px; text-align: center; text-transform: uppercase; margin: 20px 7px 0 0; background: white; color: #00668e; font-size: 8px; }
.home-box .viewall a, .elgg-module span.groups-widget-viewall a { font-size: 8px; font-weight:bold; color:#00668e; text-decoration:none; }
.home-box .viewall a:hover, .home-box .viewall a:focus, .home-box .viewall a:active, module span.groups-widget-viewall a:hover, .elgg-module span.groups-widget-viewall a:focus, .elgg-module span.groups-widget-viewall a:active {  }


/* Messages */
.elgg-message.elgg-state-success { background-color:#78ad45; }
.elgg-state-error { background-color:#c34840; }
.elgg-state-notice { background-color:#397188; }

/* Accueil déconnecté */
#adf-loginbox { padding-top:6px; }
#adf-homepage form.elgg-form.elgg-form-register { background: #FAFAFA; padding: 10px; margin-top: 30px; }

/* Accueil */
.elgg-context-dashboard .elgg-main, .elgg-context-dashboard #slider1 { background: transparent; }
.elgg-context-dashboard .anythingSlider { min-height: 300px; background: #397188; font-family: Montserrat; }
.elgg-context-dashboard .anythingSlider * { color: white; }
.anythingSlider h3, .anythingSlider p { padding: 12px 0 0 10px; }
.anythingSlider ul ul, .anythingSlider li li { padding-left: 10px; font-size:14px; }
#adf-homepage .anythingSlider li li { /* list-style-type: circle; */ }
.elgg-context-dashboard .anythingControls { position: absolute; bottom: 20px; left: 20px; display: none; }
.elgg-context-dashboard .anythingControls li { width: 40px; border-radius: 20px; border: 1px solid white; height: 40px; text-align: center; line-height: 40px; color: white; }
.elgg-context-dashboard .anythingSlider .arrow span { visibility:initial; }
.elgg-context-dashboard span.arrow { position: absolute; bottom: 20px; width: 40px; border-radius: 20px; border: 1px solid white; height: 40px; text-align: center; line-height: 40px; color: white; z-index: 11; background:rgba(0,0,0,0.5); }
.elgg-context-dashboard span.back { left: 20px; content: "<"; }
.elgg-context-dashboard span.forward { right: 20px; content: ">"; }

.home-box { background:white; }
.home-box .sidebarBox, .home-box #sidebar-featured-groups { margin: 0 0 30px 0; }
.home-box h2, .home-box h3, .home-box h2 a, .home-box h3 a { color: white; text-decoration:none; font-family: Montserrat; font-weight: normal; font-size: 17px; }
.sidebarBox h3, #sidebar-featured-groups h3 { background: #c5dc1c; min-height: 35px; padding: 12px 4px 0 10px; line-height:1.2; }
.home-box h2 img { float:left; margin-right:10px; }
/* Activity */
.home-box.home-activity { background:white; }
.home-box.home-activity h2 { padding: 8px 10px; line-height:40px; background:#98519d; min-height: 45px; }
.home-box.home-activity .elgg-river-item { padding: 12px 10px; }
.elgg-context-dashboard .elgg-list-river > li:hover { background-color: transparent; }
/* Members */
.membersWrapper { padding: 0 10px; }

/* The Wire */
.home-box.home-wire { background:white; }
.home-box.home-wire h2 { background: #e45833; padding: 8px 0 0 0px; width: 100%; line-height:40px; min-height: 45px; }
.home-box.home-wire .elgg-item { padding: 0 10px; }

/* Widgets */
section .elgg-layout-one-column div.module { border-radius:0; border:0; }
section .elgg-layout-one-column div.module header { border-radius:0; }
.cocon-widget-add-control { width: 22%; float: right; background: #00668c; padding: 8px 10px; margin-bottom: 10px; text-align: left; }
.cocon-widget-add-control img { float: left; margin-right: 4px; height: 20px; }
.cocon-widget-add-button { background: white; color: #00668c; border-radius: 14px; padding: 5px 8px; font-size: 8px; text-transform: uppercase; font-weight: bold; display: inline-block; }
#widgets-add-panel { background: white; border: 0; }
#widgets-add-panel li { border: 0; color: white; background-color: #00668c; }
.elgg-widgets-add-panel .elgg-state-unavailable { opacity: 0.4; }


/* Couleurs associées aux outils */
/* Choix des widgets */
li#elgg-widget-type-group_activity { background-color: #98519d; }
li#elgg-widget-type-a_users_groups { background-color: #c5dc1c; }
li#elgg-widget-type-messages { background-color: #c8596a; }
li#elgg-widget-type-event_calendar { background-color: #78ad45; }
li#elgg-widget-type-thewire { background-color: #f23a32; }
li#elgg-widget-type-profile_completeness { background-color: #feb743; }
li#elgg-widget-type-blog { background-color: #7e88c3; }
li#elgg-widget-type-bookmarks { background-color: #c07a9e; }
li#elgg-widget-type-pages { background-color: #c34840; }
li#elgg-widget-type-filerepo { background-color: #80aa84; }
li#elgg-widget-type-friends { background-color: #397188; }
li#elgg-widget-type-points_left { background-color: #eace6d; }

/* Widgets */
section div.module div.activites .elgg-widget-content .widget-title-details.group-widget a { background: #98519d !important; }
.module.elgg-widget-instance-group_activity header { background: #98519d; }
.module.elgg-widget-instance-a_users_groups header { background: #c5dc1c; }
.module.elgg-widget-instance-messages header { background: #c8596a; }
.module.elgg-widget-instance-event_calendar header { background: #78ad45; }
.module.elgg-widget-instance-thewire header { background: #f23a32; }
.module.elgg-widget-instance-profile_completeness header { background: #feb743; }
.module.elgg-widget-instance-blog header { background: #7e88c3; }
.module.elgg-widget-instance-bookmarks header { background: #c07a9e; }
.module.elgg-widget-instance-pages header { background: #c34840; }
.module.elgg-widget-instance-filerepo header { background: #80aa84; }
.module.elgg-widget-instance-friends header { background: #397188; }
.module.elgg-widget-instance-points_left header { background: #eace6d; }

section div.module header h2 { margin: 4px 0 0 8px; padding: 10px 0 4px 42px; background-size: 34px; max-width: 176px; min-height: 30px; }
section div.elgg-widget-instance-activity header h2 { background-image: url("<?php echo $picto_module; ?>activity.png"); }
section div.elgg-widget-instance-group_activity header h2 { background-image: url("<?php echo $picto_module; ?>groups_activity.png"); }
section div.elgg-widget-instance-a_users_groups header h2 { background-image: url("<?php echo $picto_module; ?>groups.png"); }
section div.elgg-widget-instance-messages header h2 { background-image: url("<?php echo $picto_module; ?>messages.png"); }
section div.elgg-widget-instance-event_calendar header h2 { background-image: url("<?php echo $picto_module; ?>event_calendar.png"); }
section div.elgg-widget-instance-thewire header h2 { background-image: url("<?php echo $picto_module; ?>thewire.png"); }
section div.elgg-widget-instance-profile_completeness header h2 { background-image: url("<?php echo $picto_module; ?>profile.png"); }
section div.elgg-widget-instance-blog header h2 { background-image: url("<?php echo $picto_module; ?>blog.png"); }
section div.elgg-widget-instance-bookmarks header h2 { background-image: url("<?php echo $picto_module; ?>bookmarks.png"); }
section div.elgg-widget-instance-pages header h2 { background-image: url("<?php echo $picto_module; ?>pages.png"); }
section div.elgg-widget-instance-filerepo header h2 { background-image: url("<?php echo $picto_module; ?>files.png"); }
section div.elgg-widget-instance-friends header h2 { background-image: url("<?php echo $picto_module; ?>friends.png"); }
section div.elgg-widget-instance-points_left header h2 { background: url("<?php echo $picto_module; ?>brainstorm.png") no-repeat scroll 0 2px #eace6d; }


/* Bloc more des widgets
 * @TODO : pour mettre un fond sur les blocs more, mais hack pas forcément très compatible :
 */
div.elgg-module-widget .elgg-widget-more { background: #00668c; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-module-widget .elgg-widget-more a { color: white; }
div.elgg-widget-instance-group_activity .elgg-widget-more { background: #98519d; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-a_users_groups .elgg-widget-more { background: #c5dc1c; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-messages .elgg-widget-more { background: #c8596a; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-event_calendar .elgg-widget-more { background: #78ad45; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-thewire .elgg-widget-more { background: #f23a32; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-profile_completeness .elgg-widget-more { background: #feb743; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-blog .elgg-widget-more { background: #7e88c3; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-bookmarks .elgg-widget-more { background: #c07a9e; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-pages .elgg-widget-more { background: #c34840; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-filerepo .elgg-widget-more { background: #80aa84; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-friends .elgg-widget-more { background: #397188; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }
div.elgg-widget-instance-points_left .elgg-widget-more { background-color: #c5dc1c; color: white; margin: 0 -10px -10px -10px; display: block; padding: 4px 10px; }


/* Modules des groupes */
.elgg-module-group .elgg-head { background: #00668c; border-radius: 0; padding: 4px 6px 4px 6px; }
.elgg-module-group-activity .elgg-head { background-color: #97519c; }
.elgg-module-group-event-calendar .elgg-head { background-color: #78ad45; }
.elgg-module-group-blog .elgg-head { background-color: #7e88c3; }
.elgg-module-group-bookmarks .elgg-head { background-color: #c07a9e; }
.elgg-module-group-pages .elgg-head { background-color: #c34840; }
.elgg-module-group-file .elgg-head { background-color: #80aa84; }
.elgg-module-group-brainstorm .elgg-head { background-color: #eace6d; }
.elgg-module-group-announcements .elgg-head { background-color: #7e89c1; }
.elgg-module-group-discussion .elgg-head { background-color: #f43930; }

.elgg-module-group .elgg-head h3 { background-size: 34px; padding: 8px 0px 0px 40px; min-height: 30px; background-image: url("<?php echo $picto_module; ?>groups.png"); }
.elgg-module-group-activity .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>groups_activity.png"); }
.elgg-module-group-event-calendar .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>event_calendar.png"); }
.elgg-module-group-blog .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>blog.png"); }
.elgg-module-group-bookmarks .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>bookmarks.png"); }
.elgg-module-group-pages .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>pages.png"); }
.elgg-module-group-file .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>files.png"); }
.elgg-module-group-brainstorm .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>brainstorm.png"); }
.elgg-module-group-announcements .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>announcements.png");}
.elgg-module-group-discussion .elgg-head h3 { background-image: url("<?php echo $picto_module; ?>discussion.png"); }

/* Bordures des modules des groupes */
.elgg-module-group > .elgg-body { border-color: #00668c; }
.elgg-module-group-activity .elgg-body { border-color: #97519c; }
.elgg-module-group-event-calendar .elgg-body { border-color: #78ad45; }
.elgg-module-group-blog .elgg-body { border-color: #7e88c3; }
.elgg-module-group-bookmarks .elgg-body { border-color: #c07a9e; }
.elgg-module-group-pages .elgg-body { border-color: #c34840; }
.elgg-module-group-file .elgg-body { border-color: #80aa84; }
.elgg-module-group-brainstorm .elgg-body { border-color: #c5dc1c; }
.elgg-module-group-announcements .elgg-body { border-color: #eace6d; }
.elgg-module-group-discussion .elgg-body { border-color: #f43930; }

/* Bloc more des modules des groupes */
.elgg-module-group .elgg-widget-more { background: #00668c; color: white; padding: 4px; }
.elgg-module-group .elgg-widget-more a { color: white; }
.elgg-module-group-group-activity .elgg-widget-more { background-color: #97519c; color: white; }
.elgg-module-group-event-calendar .elgg-widget-more { background-color: #78ad45; color: white; }
.elgg-module-group-blog .elgg-widget-more { background-color: #7e88c3; color: white; }
.elgg-module-group-bookmarks .elgg-widget-more { background-color: #c07a9e; color: white; }
.elgg-module-group-pages .elgg-widget-more { background-color: #c34840; color: white; }
.elgg-module-group-file .elgg-widget-more { background-color: #80aa84; color: white; }
.elgg-module-group-brainstorm .elgg-widget-more { background-color: #eace6d; color: white; }
.elgg-module-group-announcements .elgg-widget-more { background-color: #7e89c1; color: white; }
.elgg-module-group-discussion .elgg-widget-more { background-color: #f43930; color: white; }

/* Various tools icons : activity, event-calendar, announcements, blog, file, discussion, brainstorm, bookmarks, pages */
<?php <<<CSS
/* Group activity */
.elgg-menu-item-activity a { padding-left:32px; background: url("<?php echo $sideicon; ?>activity.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-activity a:hover, .elgg-menu-item-activity a:focus, .elgg-menu-item-activity a:active { background: url("<?php echo $sideicon; ?>activity.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Event calendar */
.elgg-menu-item-event-calendar a { padding-left:32px; background: url("<?php echo $sideicon; ?>event_calendar.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-event-calendar a:hover, .elgg-menu-item-event-calendar a:focus, .elgg-menu-item-event-calendar a:active { background: url("<?php echo $sideicon; ?>event_calendar.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Announcements */
.elgg-menu-item-announcements a { padding-left:32px; background: url("<?php echo $sideicon; ?>announcements.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-announcements a:hover, .elgg-menu-item-announcements a:focus, .elgg-menu-item-announcements a:active { background: url("<?php echo $sideicon; ?>announcements.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?>; color: #fff; }
/* Blog */
.elgg-menu-item-blog a { padding-left:32px; background: url("<?php echo $sideicon; ?>blog.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-blog a:hover, .elgg-menu-item-blog a:focus, .elgg-menu-item-blog a:active { background: url("<?php echo $sideicon; ?>blog.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Feedback */
.elgg-menu-item-feedback a { padding-left:32px; background: url("<?php echo $sideicon; ?>feedback.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-feedback a:hover, .elgg-menu-item-feedback a:focus, .elgg-menu-item-feedback a:active { background: url("<?php echo $sideicon; ?>feedback.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?>; color: #fff; }
/* File */
.elgg-menu-item-file a { padding-left:32px; background: url("<?php echo $sideicon; ?>file.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-file a:hover, .elgg-menu-item-file a:focus, .elgg-menu-item-file a:active { background: url("<?php echo $sideicon; ?>file.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Folder */
.elgg-menu-item-folder a { padding-left:32px; background: url("<?php echo $sideicon; ?>folder.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-folder a:hover, .elgg-menu-item-folder a:focus, .elgg-menu-item-folder a:active { background: url("<?php echo $sideicon; ?>folder.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Forum - discussion */
.elgg-menu-owner-block .elgg-menu-item-discussion a { background: url("<?php echo $sideicon; ?>discussion.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-owner-block .elgg-menu-item-discussion a:hover, .elgg-menu-owner-block .elgg-menu-item-discussion a:focus, .elgg-menu-owner-block .elgg-menu-item-discussion a:active { background: url("<?php echo $sideicon; ?>discussion.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Brainstorm */
.elgg-menu-item-brainstorm a { padding-left:32px; background: url("<?php echo $sideicon; ?>brainstorm.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-brainstorm a:hover, .elgg-menu-item-brainstorm a:focus, .elgg-menu-item-brainstorm a:active { background: url("<?php echo $sideicon; ?>brainstorm.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Bookmarks */
.elgg-menu-item-bookmarks a { padding-left:32px; background: url("<?php echo $sideicon; ?>bookmarks.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-bookmarks a:hover, .elgg-menu-item-bookmarks a:focus, .elgg-menu-item-bookmarks a:active { background: url("<?php echo $sideicon; ?>bookmarks.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }
/* Pages */
.elgg-menu-item-pages a { padding-left:32px; background: url("<?php echo $sideicon; ?>pages.png") no-repeat scroll 9px 5px #FFFFFF; }
.elgg-menu-item-pages a:hover, .elgg-menu-item-pages a:focus, .elgg-menu-item-pages a:active { background: url("<?php echo $sideicon; ?>pages.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }

/* More group tools and info icons */
/* Group membership */
.elgg-menu-item-membership-status a { padding-left: 32px !important; background: url("<?php echo $sideicon; ?>members.png") no-repeat scroll 9px 5px #FFFFFF !important; }
.elgg-menu-item-membership-status a:hover, .elgg-menu-item-membership-status a:focus, .elgg-menu-item-membership-status a:active {
background: url("<?php echo $sideicon; ?>members.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important;
}
/* Group notifications */
.elgg-menu-item-subscription-status a { padding-left: 32px !important; background: url("<?php echo $sideicon; ?>notification.png") no-repeat scroll 9px 5px #FFFFFF !important; }
.elgg-menu-item-subscription-status a:hover { background: url("<?php echo $sideicon; ?>notification.png") no-repeat scroll 9px -19px <?php echo $sidecolor; ?> !important; }

/* Group listing menu */
.elgg-menu-item-members { background: url("<?php echo $sideicon; ?>members.png") no-repeat scroll -2px -26px transparent; }
CSS;
?>

/* File tree */
#file_tools_list_tree_container div.elgg-body { padding: 6px; }


/* More button */
.elgg-widget-more { line-height: 36px; /* color: white; */ background: transparent; font-size: 0.9em; }
.elgg-widget-more:before { text-shadow: none; border: 1px solid white; border-radius: 15px; text-align: center; width: 30px; height: 30px; line-height: 30px; /* color: white; */ display: inline-block; margin: 2px 6px 2px 0; }

/* Users and avatars */
.elgg-avatar-tiny > a > img { border-radius: 10px; border: 1px solid white; }
.elgg-avatar-small > a > img { border-radius: 20px; border: 1px solid white; }

/* Feedback */
body #feedbackWrapper { top: 170px; }

/* Chat */
.elgg-page #groupchat-sitelink { height: 30px; width:28px; line-height:30px; border: 0; border-radius:15px; padding: 0px 16px 0px 6px; top: 38px; }
.elgg-page #groupchat-sitelink i.fa { font-size: 30px; }
.elgg-page #groupchat-grouplink { height: 30px; width:28px; line-height:30px; border: 0; border-radius:15px; padding: 0px 16px 0px 6px; color: white; background: #c5dc1c; top: 80px; }
.elgg-page #groupchat-grouplink i.fa { font-size: 30px; }


