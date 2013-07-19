<?php global $CONFIG;
$font_base = $CONFIG->url . '/mod/theme_compnum/fonts/';
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
?>

/* TYPOS de la plateforme */

@font-face {
	font-family: "Lato"; src: url('<?php echo $font_base; ?>Lato/Lato-Regular.ttf');
}
@font-face {
	font-family: "Lato"; src: url('<?php echo $font_base; ?>Lato/Lato-Bold.ttf');
	font-weight:bold;
}
@font-face {
	font-family: "Lato"; src: url('<?php echo $font_base; ?>Lato/Lato-Italic.ttf');
	font-style:italic;
}
@font-face {
	font-family: "Lato"; src: url('<?php echo $font_base; ?>Lato/Lato-BoldItalic.ttf');
	font-weight:bold;
	font-style:italic;
}

@font-face {
	font-family: "LatoLight"; src: url('<?php echo $font_base; ?>Lato/Lato-Light.ttf');
}
@font-face {
	font-family: "LatoLight"; src: url('<?php echo $font_base; ?>Lato/Lato-LightItalic.ttf');
	font-style:italic;
}

@font-face {
	font-family: "LatoHairline"; src: url('<?php echo $font_base; ?>Lato/Lato-Hairline.ttf');
}
@font-face {
	font-family: "LatoHairline"; src: url('<?php echo $font_base; ?>Lato/Lato-HairlineItalic.ttf');
	font-style:italic;
}

@font-face {
	font-family: "LatoBlack"; src: url('<?php echo $font_base; ?>Lato/Lato-Black.ttf');
}
@font-face {
	font-family: "LatoBlack"; src: url('<?php echo $font_base; ?>Lato/Lato-BlackItalic.ttf');
	font-style:italic;
}


/* Général */
html { font-family:Lato; }

#home_static { clear:both; }
.home_static_widget { float:left; width:300px; height:200px; overflow:hidden; overflow-y:auto; margin: 4px 6px 8px 6px; border: 0; box-shadow: 2px 2px 5px 0 #999; }

.elgg-main { box-shadow: 2px 2px 5px 0px #888; }
form.elgg-form { background: transparent; }

/* Bandeau (commun) */
header * { font-family:Lato; }

/* Bandeau déconnecté */
header.notloggedin { background: #523866; border-top: 0; height: 48px; }
header.notloggedin h1 { margin-top: 0; font-size: 16px; font-family:Lato; font-weight:bold; }
header.notloggedin h1 a:hover { text-decoration:none; }
header.notloggedin .header-subtitle { font-size: 13.5px; margin-top:0; font-family:LatoLight; }
header.notloggedin nav { top:0; }
header.notloggedin nav ul li a { background: url("<?php echo $CONFIG->url; ?>mod/theme_compnum/graphics/coche.png") no-repeat scroll left top transparent; padding-left:36px; display:block; height:47px; line-height:44px; font-size:17px; text-transform:lowercase; margin-top:0; padding-left:50px; }

#adf-homepage #home_intro p { color:#777; font-family:Lato; font-size:18px; padding: 8px 30px 20px 20px; width:580px; text-align:justify; }
#adf-homepage a { color:#777 !important; background: whitesmoke; border-radius: 5px; width: 230px; float: left; box-shadow: 0 2px 3px; font-family: Lato; font-size: 18px; text-shadow:none; margin: 0 20px; padding: 8px 12px; }
#adf-homepage a:hover, #adf-homepage a:active, #adf-homepage a:focus { background: #fafafa; color: #666 !important; text-shadow: none; }

.anythingslider { box-shadow: 0px 0px 1px 2px #696; }
.anythingSlider-cs-portfolio .anythingControls a.cur, .anythingSlider-cs-portfolio .anythingControls a:hover { background-color: #92b025; }
.home-slider p { margin-bottom: 15px; color: white; font-family: Lato; font-size: 27px; text-transform: uppercase; font-weight: bold; }
.home-slider a { color:#888; background:#efefef; text-shadow: -1px 1px 0px #666;
font-size: 20px !important; font-family:Lato; padding: 15px 32px; border-radius: 24px; border: 2px solid #696; box-shadow: 0 0 12px 0px #fff; text-decoration: none; text-transform: uppercase; font-weight: normal !important; }
.home-slider img { float:right; width:350px; margin-right:40px; }
.textSlide a:hover, .textSlide a:active, .textSlide a:focus { background: #fafafa; color:#666; }


/* Bandeau connecté */
header.loggedin { background:#523866; border-top:0; height:76px; }
header.loggedin h1 { font-family:Lato; font-size: 22px; text-transform:none; }
header.loggedin h1 a:hover { text-decoration:none; }
header.loggedin .header-subtitle { margin-top: 0px; font-family: LatoLight; font-size: 13.5px; }
header.loggedin nav ul li a { font-size: 12px; line-height: 12px; padding-top: 0px !important; }
#adf-profil { font-size: 12px; }
#theme_compnum-search { margin-top: -16px; }
form input#adf-search-submit-button { background:#888; border: 1px solid #888; padding: 5px 7px 6px 8px; }
form input#adf-search-submit-button:hover, form input#adf-search-submit-button:active, form input#adf-search-submit-button:focus { background:<?php echo $color1; ?>; border: 1px solid <?php echo $color1; ?>; padding: 5px 7px 6px 8px; }


/* Footer */
footer { height:auto !important; background: #7FB622 !important; box-shadow: 0px -2px 1px 0 #696; }
#theme-compnum-footer { margin-top:12px; }
footer * { font-family:Lato; color:#fafafa; font-size:14px; font-weight:bold; }
footer a:hover, footer a:active, footer a:focus { color:white; }
#footer-contacts { float:right; width:250px; margin: 12px 0 16px 30px; padding: 4px 10px; background:#92B025; box-shadow: 0 1px 3px 1px #669966; }
#footer-contacts * { font-family:LatoLight; }
#footer-contacts a img { float:left; margin: 0px 2px; opacity:0.8; }
#footer-contacts a img:hover { opacity:1; }

/* Modules - widgets */
section div.module header { min-height:30px; }
section div.module header h2 { font-family: Lato; text-transform: none; }
section div.module header ul { margin: 4px 6px 0 0; }
section div.module header ul li a { margin: 0 0 0 6px; }

.groups-profile-icon img { width: 120px; float: left; margin-right:12px; }
.groups-stats { margin-top:0; padding-top:2px; }
.groups-profile > .elgg-image { margin-right:12px; width:260px; float:left; }

.elgg-module-info > .elgg-head { padding: 0 5px 2px; }
.elgg-module-info > .elgg-head h3 { font-family: Lato; margin-top:2px; }
.elgg-module-info > .elgg-body { padding: 0 0 0; }
.groups-widget-viewall { margin: 6px 4px 0 0; }

.elgg-owner-block { box-shadow: 0 0 3px #666; }
.elgg-sidebar .elgg-module-aside { margin-top:20px; }
.elgg-menu-groups-my-status li a { width: 191px !important; }
.elgg-menu-groups-my-status li a:hover { width: 191px !important; background-color: <?php echo $linkcolor; ?> !important; }


/* Boutons */
.elgg-button-action, .elgg-menu .elgg-button-action, .elgg-button-submit { color: #666; text-shadow: 0px 1px 1px #fff; }
.elgg-button-action:hover, .elgg-button-action:focus, .elgg-button-action:active, .elgg-menu .elgg-button-action:hover, .elgg-menu .elgg-button-action:focus, .elgg-menu .elgg-button-action:active, .elgg-button-submit:hover, .elgg-button-submit:focus, .elgg-button-submit:active { text-shadow: 1px 1px 1px #666; }
.elgg-menu-entity .elgg-menu-item-edit a { color: #777; }

/* Profil */
#profile-owner-block { background-color: transparent !important; }
#profile-owner-block a.elgg-button-action { width: 200px; text-align: center; margin: 4px auto; }
#profile_completeness_container { background: transparent !important; }
#profile-details .odd, #profile-details .even { background-color: transparent !important; margin: 3px 0 4px; font-size: 14px; }



