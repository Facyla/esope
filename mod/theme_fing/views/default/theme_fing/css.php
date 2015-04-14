/* Fing colors
 * Verts : #3f732e
 */

<?php
global $CONFIG;
$imgurl = $CONFIG->url . 'mod/theme_fing/graphics/';
$fonturl = $CONFIG->url . 'mod/theme_fing/fonts/';
$font_neris = $fonturl . 'neris/';
$font_lettergothic = $fonturl . 'LetterGothicStd/';
?>

/* Replace main icons sprite */
.elgg-icon { background-image: url(<?php echo $imgurl; ?>elgg_sprites_fing.png); }


/* Add some fonts */

/* NERIS FONT */
@font-face {
	font-family: 'neris'; font-weight: 100; font-style: normal;
	src: url('<?php echo $font_neris; ?>neris_thin/Neris-Thin-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_thin/Neris-Thin-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_thin/Neris-Thin-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_thin/Neris-Thin-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_thin/Neris-Thin-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neristhin_italic'; font-weight: 100; font-style: italic;
	src: url('<?php echo $font_neris; ?>neris_thinitalic/Neris-ThinItalic-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_thinitalic/Neris-ThinItalic-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_thinitalic/Neris-ThinItalic-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_thinitalic/Neris-ThinItalic-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_thinitalic/Neris-ThinItalic-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neris'; font-weight: normal; font-style: normal;
	src: url('<?php echo $font_neris; ?>neris_light/Neris-Light-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_light/Neris-Light-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_light/Neris-Light-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_light/Neris-Light-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_light/Neris-Light-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neris'; font-weight: normal; font-style: italic;
	src: url('<?php echo $font_neris; ?>neris_lightitalic/Neris-LightItalic-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_lightitalic/Neris-LightItalic-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_lightitalic/Neris-LightItalic-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_lightitalic/Neris-LightItalic-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_lightitalic/Neris-LightItalic-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neris'; font-weight: 500; font-style: normal;
	src: url('<?php echo $font_neris; ?>neris_semibold/Neris-SemiBold-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_semibold/Neris-SemiBold-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_semibold/Neris-SemiBold-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_semibold/Neris-SemiBold-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_semibold/Neris-SemiBold-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neris'; font-weight: 500; font-style: italic;
	src: url('<?php echo $font_neris; ?>neris_semibolditalic/Neris-SemiBoldItalic-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_semibolditalic/Neris-SemiBoldItalic-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_semibolditalic/Neris-SemiBoldItalic-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_semibolditalic/Neris-SemiBoldItalic-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_semibolditalic/Neris-SemiBoldItalic-webfont.svg#neristhin') format('svg');
}
@font-face {
	font-family: 'neris'; font-weight: bold; font-style: italic;
	src: url('<?php echo $font_neris; ?>neris_bolditalic/Neris-BoldItalic-webfont.eot');
	src: url('<?php echo $font_neris; ?>neris_bolditalic/Neris-BoldItalic-webfont.eot?#iefix') format('embedded-opentype'),
		url('<?php echo $font_neris; ?>neris_bolditalic/Neris-BoldItalic-webfont.woff') format('woff'),
		url('<?php echo $font_neris; ?>neris_bolditalic/Neris-BoldItalic-webfont.ttf') format('truetype'),
		url('<?php echo $font_neris; ?>neris_bolditalic/Neris-BoldItalic-webfont.svg#neristhin') format('svg');
}

/* LETTER GOTHIC STD */
@font-face {
	font-family: 'LetterGothic'; font-weight:normal; font-style: normal;
	src: url('<?php echo $font_lettergothic; ?>LetterGothicStd.otf') format("opentype");
}
@font-face {
	font-family: 'LetterGothic'; font-weight:bold; font-style: normal;
	src: url('<?php echo $font_lettergothic; ?>LetterGothicStd-Bold.otf') format("opentype");
}
@font-face {
	font-family: 'LetterGothic'; font-weight:bold; font-style: italic;
	src: url('<?php echo $font_lettergothic; ?>LetterGothicStd-BoldSlanted.otf') format("opentype");
}


body { border-top: 1px solid #333333; }
header { height:94px; }
header h1 { font: normal 36px Lato,sans-serif; color: #3e3e3e; background: url('<?php echo $vars['url']; ?>mod/theme_fing/graphics/fing/accueil_fing.png') no-repeat; width:804px; height:94px; margin-top:0px; }
header h1 a { color: #333; float: right; text-decoration:none; margin-top: 24px; }
header h1 a:hover, header h1 a:focus, header h1 a:active { color: #000; text-decoration:none; }


#fing-homepage {
	background: white !important;
	box-shadow: 0px 0px 32px #EEE;
	-webkit-box-shadow: 0px 0px 32px #EEE;
	moz-box-shadow: 0px 0px 32px #EEE;
}

/* Bandeau de titre et Page d'accueil */
.fing_title { padding:0 0 0 0; margin:0 auto; background: none repeat scroll 0 0 #EEEEEE; }


.fing_title h3 { font: bold 18px arial,sans-serif; color: #969696; }

.home_pin_full img { max-width: 100%; }
#home_pin_blocks .search_listing:nth-child(even) { background: #F0F0F0; }
#home_pin_blocks .home_pin_public { padding: 1ex; }

#fing-homepage .river_item { padding: 1ex; }
#fing-homepage .river_item:nth-child(even) { background: #F0F0F0; }

#fing-homepage .elgg-item:nth-child(even) { background: #F0F0F0; }


/* Menu */
header nav ul li a, #adf-profil { color: #333; font-size: 14px; font-weight: normal; padding-bottom: 10px; text-shadow: none; }

header nav ul li a:hover, header nav ul li a:focus, header nav ul li a:active, #adf-profil:hover, #adf-profil:focus, #adf-profil:active { color: #000; }

/* Social presence */
#social-presence { position:absolute; top:70px; right:5px; }
#social-presence ul li { float:left; }
#social-presence ul li a { font-weight: bold; font-size: 20px; margin: 0 0 0 1ex; color: #333; }
#social-presence ul li a:hover, #social-presence ul li a:focus, #social-presence ul li a:active { text-decoration:none;color: #000; }

/* Menu principal */
div#transverse { background: white; box-shadow: 0px 0px 3px 1px #CCC; }
#transverse nav ul li, #transverse nav ul li:first-child { border:0; }
#transverse nav ul li a { text-transform: uppercase; font-size: 16px; border:0; border-bottom: 3px solid transparent; }
#transverse nav ul li ul { top:41px; }
#transverse nav ul li ul li a { text-transform:initial;  border-bottom: 3px solid transparent; }
#transverse nav ul li a.active, #transverse nav ul li a.elgg-state-selected, #transverse nav ul li a:hover, #transverse nav ul li a:focus, #transverse nav ul li a:active { background-color:white; border-bottom: 3px solid #3f732e; }
input:focus, textarea:focus { background: #ccc; }

/* Types de profils */
section div.module div.activites ul li .profile-type { margin: 0 2px 0 2px; }
section div.module div.activites ul li .profile-type img { margin: 0; }

/*
.profile-type-adherents { background: #3F732E; }
.profile-type-fing { background: #95328F; }
*/

ul.elgg-list li.elgg-item div.elgg-image .elgg-avatar-tiny a img { margin-right:0; }
.elgg-avatar.elgg-avatar-tiny.elgg-autocomplete-item.profile-type > a { padding: 0; }
.elgg-avatar-tiny { width: 25px; border-radius: 3px; border: 1px solid transparent; margin-right:5px; }
.elgg-avatar-tiny.profile-type-adherents { border: 1px solid #3F732E; }
.elgg-avatar-tiny.profile-type-fing { border: 1px solid #95328F; }

.elgg-avatar-small { width: 40px; border-radius: 5px; }
.elgg-avatar-small { border: 1px solid transparent; }
.elgg-avatar-small.profile-type-adherents { border: 1px solid #3F732E; }
.elgg-avatar-small.profile-type-adherents:before { content: "Adhérent"; position: absolute; bottom: 0; left: 0; background: #3F732E; padding: 2px; color:white; border-radius: 0 3px 0 0; font-size: 9px; }
.elgg-avatar-small.profile-type-fing { border: 1px solid #95328F; }
.elgg-avatar-small.profile-type-fing:before { content: "FING"; position: absolute; bottom: 0; left: 0; background: #95328F; padding: 2px; color:white; border-radius: 0 3px 0 0; font-size: 9px; }

.elgg-avatar-large { border: 3px solid transparent; }
.elgg-avatar-large.profile-type-adherents { border: 3px solid #3F732E; }
.elgg-avatar-large.profile-type-adherents:before { content: "Adhérent"; position: absolute; bottom: 0; left: 0; background: #3F732E; padding: 2px 8px 0 4px;; color:white; border-radius: 0 8px 0 0; font-size: 16px; }
.elgg-avatar-large.profile-type-fing { border: 3px solid #95328F; }
.elgg-avatar-large.profile-type-fing:before { content: "FING"; position: absolute; bottom: 0; left: 0; background: #95328F; padding: 2px 8px 0 4px;; color:white; border-radius: 0 8px 0 0; font-size: 16px; }


/* Modifs des groupes pour un rendu mieux navigable en mode public */
#group-top-block {  }
#group-top-block h1 { /* line-height:50px; */ margin-top: 1.5ex; }
#group-top-block img { float:left; height:100px; margin-right:1ex; }
.elgg-public .elgg-context-group_profile .elgg-main .elgg-head { display: none; }

.elgg-context-groups .elgg-menu-title li a.elgg-button.elgg-button-action { border-radius: 5px; font-size: 12px; font-weight: normal; padding: 3px 6px; }


/* Menu des groupes */
.elgg-menu-group-topmenu { padding: 0 1.5ex; }
.elgg-menu-group-topmenu li { margin-right:1px; }
.elgg-menu-group-topmenu li a { padding: 1ex 2ex; font-size: 16px; }
.elgg-menu-group-topmenu li a:hover, .elgg-menu-group-topmenu li a:active, .elgg-menu-group-topmenu li a:focus, .elgg-menu-group-topmenu li.elgg-state-selected a { background: none repeat scroll 0 0 rgba(0, 0, 0, 0.5); }




/* Slider */
/* Limit slides content size */
.fing-slider { height: 250px; overflow:hidden; }
.fing-slider #slider1 img { max-height: 200px !important; }
.fing-slider #slider1 .textSlide { max-height: 200px; padding: 6px 12px; }
.textSlide h3, h3.textSlide { font-size: 20px; }
/* Slider styles */
.anythingSlider li.panel { display:none; }
.anythingSlider li.panel.activePage { display:block; }
.anythingSlider-cs-portfolio .arrow { bottom: 2px; position: absolute; z-index:1; }
.anythingSlider .arrow span { visibility:visible; font-size: 50px; color:#fff; }
.anythingSlider .arrow a, .anythingSlider .arrow a:hover, .anythingSlider .arrow a:active { text-decoration: none; }
span.arrow { width: 40px; height: 40px; border-radius: 20px; line-height: 40px; background: rgba(0,0,0,0.4); /* box-shadow: 0 0 1px 1px #666; */ text-align: center; }
.arrow.back { left: 20px; }
.arrow.forward { right: 20px; }
.fing-slider .anythingControls { position: absolute; bottom: 11px; left: 20%; z-index:1; }
.fing-slider .anythingControls li { float:left; }
.fing-slider .anythingSlider .anythingControls ul a, .fing-slider .anythingSlider .start-stop, .fing-slider .anythingSlider-cs-portfolio .anythingControls a.start-stop, .fing-slider .anythingSlider-cs-portfolio .anythingControls a.start-stop.playing { background-color: #999999; margin: 3px 4px; transition-duration: 0.3s; float:left; border: 0; border-radius: 16px; color: transparent; height: 16px; width: 16px; opacity:0.6; }
.fing-slider .anythingSlider-cs-portfolio .anythingControls a.cur, .fing-slider .anythingSlider-cs-portfolio .anythingControls a:hover { background-color: #3f732e; width: 22px; height: 22px; margin: 0px 1px; border-radius:22px; }


/* Home timeline */
.home-timeline { padding-bottom:20px; padding-left:0; padding-right:0; margin-left: 10px; margin-right: 10px; }
.home-timeline br.clearfloat { display: none; }
.home-timeline h3 { margin-left:7px; margin-right:7px; }
.home-timeline hr { margin-left:7px; margin-right:7px; }
.home-timeline .timeline-event { float: left; width: 20%; }
.home-timeline .timeline-event-content { padding:0 7px; margin-top: 6px; }
.home-timeline h3.timeline-title { background: #999; color: white; margin: 0 0 6px 0; padding:0 0px; display: block;}
.home-timeline h3.timeline-title a { color: white; font-weight:bold; font-size:11px; text-transform: capitalize; padding: 0 6px; }
.home-timeline .timeline-event-description { padding: 0 6px; font-size:11px; color:#808080; }


/* Footer */
#site-footer { height:auto; margin-bottom: 2ex; }
#site-footer ul { width:auto; }
#site-footer ul li { margin-top:50px; }
#site-footer ul li a { font-size: 14px; }
#site-footer .fing-logo img { float: left; height:130px; width:auto; border:0; }
#site-footer .partenaires { float: right; border:0; margin:15px 0 15px 0; }
.interne.credits { margin-bottom: 2ex; }
/*
#site-footer { background:#EEE; border-top: 3px solid #333; border-bottom: 3px solid #333; }
#fingfooter, #fingfooter p, #fingfooter a { color:#333; }
#site-footer .vcard, footer p { max-width: 60%; margin-right:10%; margin-bottom:2ex; }
#site-footer .partenaires { float:right; }
*/
#bande { display:none; }


.public-comments-notice { font-size: 1.2em; padding: 1ex 2ex; border: 1px solid red; }
.public-comments-notice .fa { color: red;  float: left; font-size: 2em; margin-right: 1ex; }


.socialshare-links-menu a { color: #800080; font-size: 2em !important; }
.socialshare-links-menu a:hover, .socialshare-links-menu a:active, .socialshare-links-menu a:focus { color: black; }

