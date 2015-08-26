<?php
$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_transitions2/graphics/';
?>


/* Generic styles */
a { color: #223300; }
img { max-width: 100%; }
select { max-width: 98%; }
input, textarea { max-width: 100%; font-family: FontAwesome, Lato; }
h2 { text-transform: uppercase; font-size: 30px; font-weight: normal; color: #003923; margin-bottom:20px; }
h2 span { color: #4B8F74; }

.flexible-block { float:left; }

/* Boutons */
.elgg-button { font-family: FontAwesome, Lato; }
.elgg-button-action { background: #89BF4E; color:white; border:0; border-radius:0; border-bottom: 3px solid #6F9A3F; }
.elgg-button-action:hover, .elgg-button-action:active, .elgg-button-action:focus { background: #9bd759; color:#023824; }
.elgg-button-cancel { background: #abd660; color:white; border:0; border-radius:0; border-bottom: 3px solid #93b853; }
.elgg-button-cancel:hover, .elgg-button-cancel:active, .elgg-button-cancel:focus { background: #b5e266; color:#023824; }
.elgg-button-submit { background: #359973; color:white; border:0; border-radius:0; border-bottom: 3px solid #2a7e5e; }
.elgg-button-submit:hover, .elgg-button-submit:active, .elgg-button-submit:focus { background: #3eb386; color:#023824; }
.elgg-button-delete { background: #75ab97; color:white; border:0; border-radius:0; border-bottom: 3px solid #598575; }
.elgg-button-delete:hover, .elgg-button-delete:active, .elgg-button-delete:focus { background: #8bc8b1; color:#023824; }
.elgg-button-admin { border: 1px solid #666; color: #666; padding: 0px 8px; border-radius: 10px; margin: 3px 6px 3px 0; background: white; }
/*
color: #023824;
color: #297256;
*/

/* System messages */
.elgg-state-success { background-color: #32A951; }
.elgg-state-error { background-color: #BF4E4E; }
.elgg-state-notice { background-color: #ABD660; color: #023824; }


/* Main layout */
body { background:#EBE7DF; font-family:Lato; }
.elgg-page-navbar { padding: 0 0px; }
.elgg-page-body { padding: 40px 0; }
.elgg-page-default .elgg-page-navbar > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-footer > .elgg-inner, 
.elgg-page-footer-transitions2 > .elgg-inner { /* max-width:96%; */ max-width:990px; margin:0 auto; }
.elgg-page-body > .elgg-inner { max-width:990px; margin:0 auto; }

.elgg-page-body-search { background:#E2D8C3; padding: 40px 0; text-align:center; }
#transitions-search-home input { font-size:20px; color: #666; border: 0; border-radius: 0; margin:0; }
#transitions-search-home .elgg-button-submit { background-color: #89BF4E; color:white; padding: 0.5em 0.8em; }
#transitions-search-home .elgg-button-submit:hover { background-color: #9bd759; color:#023824; }
.transitions-search-menu .elgg-button { margin: 0 10px 10px 0; font-size: 14px; border-radius:0; }


/* Header */
/*
.elgg-page-header { background: url(<?php echo $imgurl; ?>flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; height:200px; }
.elgg-page-header h1 img { max-width:100%; }
*/
.elgg-page-header { padding: 20px 0px; position: relative; background: white; }
.elgg-page-default .elgg-page-header > .elgg-inner { min-height:0; }
.elgg-page-header h1 { line-height:1.8em; }
.elgg-page-header h1 a, .elgg-page-header h1 a:hover { text-transform: uppercase; font-size: 14px; color: #4B8F74; font-family:Lato, sans-serif; text-shadow:none; /* font-weight:normal; */ }
.elgg-page-header h1 a .transitions-eco { color:#89BF4E; }
.elgg-page-header h1 a .transitions-num { color:#003923; }
.elgg-page-header h1 img { max-height:40px; float: left; margin-right: 20px; }

/* Slider */
.transitions-home-slider { width:75%; height:260px; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls { text-align: center; bottom: 40px; height: auto; width: 100%; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls ul.thumbNav { width: auto; padding:0; text-align: center; display: inline-block; }
.slider-homepage-slider .anythingSlider .anythingControls ul a { background:#EBE7DF; height:15px; width:15px; border:3px solid #EBE7DF; margin: 0 5px; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls a.cur, .slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls a:hover { background:#89BF4E; height:15px; width:15px; border:3px solid #EBE7DF; margin: 0 5px; }
.transitions-home-contribute { width:25%; float:right; height:260px; background:#297256; }


/* Footer */
.elgg-page-footer { background:#E2D8C3; padding: 40px 0; }
.elgg-page-footer .cmspages-output { width: 100%; }
.elgg-footer-partners-text { width:460px; max-width:100%; float:left; }
.elgg-footer-partners-logo { width:460px; max-width:100%; float:right; text-align: right; }
.elgg-footer-partners-logo img { height: 40px; margin: 0 10px 10px 0; }
.elgg-page-footer-transitions2 { padding: 40px 0; background:white; text-align:center; }
.elgg-page-footer-transitions2, .elgg-page-footer-transitions2 a { font-size:12px; color:#909AAD; }
.elgg-page-footer-transitions2 .elgg-footer-logo img { max-height:40px; float: left; margin-right: 20px; }
.elgg-page-footer-transitions2 .elgg-menu-footer { width: 600px; max-width: 100%; margin: 0 auto; float: none; }
.elgg-page-footer-transitions2 .transitions-socialshare a { font-size:20px; margin:0 0 0 1em; }
.elgg-menu-footer > li:after { content: ''; }


/* Menu */
/*
.elgg-page-navbar { background: #223300; }
.elgg-menu-site > .elgg-state-selected > a, .elgg-menu-site > li:hover > a { background-color: #669900; }
.elgg-button-dropdown:hover, .elgg-button-dropdown:focus, .elgg-button-dropdown.elgg-state-active { background: #669900; }
.elgg-button-nav:hover { background-color: #669900; }
*/
.elgg-page-navbar { background: #89BF4E; border-bottom: 3px solid #4B8F74; }
.elgg-menu-site { width:100%; }
.elgg-menu-site > li.float-alt { float: right; }
.elgg-menu-site > a, .elgg-menu-site > li > a, .elgg-button-dropdown { color: white; background-color:#89BF4E; }
.elgg-menu-site > .elgg-state-selected > a, .elgg-menu-site > li:hover > a { color: white; background-color:#4B8F74; border-bottom: 3px solid #297256; margin-bottom: -3px; }
.elgg-button-dropdown:hover, .elgg-button-dropdown:focus, .elgg-button-dropdown.elgg-state-active { background: #4B8F74; transition-duration:0.5s; border-bottom: 3px solid #297256; margin-bottom: -3px; }
.elgg-button-nav:hover { background-color: #4B8F74; }


/* Sidebar */
.elgg-menu-extras { font-size: 1.5em; }
.elgg-menu-extras li { margin-right: 0.4em; }

/* Homepage */
.elgg-menu-item-logohome a { padding: 0 !important; }
.elgg-button-transitions { font-size:3em; padding:1em; background-color:#9C9; margin:0 auto; }
.elgg-form-theme-transitions2-select-article select { max-width: 10em; }

/* Profile */
.profile-static-block { padding: 0 0.5em 0.5em 0.5em; }

/* Feedback */
/*
#feedbackWrapper { bottom: 46px; right: 46px; left:initial; top:initial; }
#feedBackContentWrapper { left:0; }
#feedBackTogglerLink { background: #7DF537; box-shadow: none; border: 3px solid black; border-right: 0; border-bottom: 0; border-radius: 10px 0 0 0; }
#feedBackTogglerLink img { margin: 0 10px 5px 0; }
*/
#feedBackToggler { opacity: 0.7; }
#feedBackTogglerLink { opacity: 0.7; background: #D4C8AF; }
#feedBackToggler:hover, #feedBackToggler:active, #feedBackToggler:focus { opacity: 1; }





@media (max-width: 1030px) {
}

@media (max-width: 820px) {
}

@media (min-width: 767px) {
}

@media (max-width: 766px) {
}

@media (max-width: 600px) {
	.flexible-block { float:none !important; margin:0 auto; width:auto !important; }
}


