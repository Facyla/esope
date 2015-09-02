<?php
$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_transitions2/graphics/';
?>


/* Generic styles */
a { color: #4b8f74; }
a:hover, a:active, a:focus { color: #297256; text-decoration:none; }
.elgg-heading-basic { color: #003923; }
.elgg-loud { color: #003923; }


h1, h2, h3, h4, h5, h6 { font-family:Lato, sans-serif; color:#003923; }
h2 { text-transform: uppercase; font-size: 30px; font-weight: normal; color: #003923; margin-bottom:20px; }
h2 span { color: #4B8F74; }
h3 a { color:#003923; }
img { max-width: 100%; }
select { max-width: 98%; }
input, textarea { max-width: 100%; font-family: FontAwesome, Lato; min-width:20px; }
.elgg-button-submit { min-width:3em; }
textarea { min-height:30px; }
blockquote { background: #e2d8c3; color:#666; border:none; }

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

/* Modules */
.elgg-module-aside .elgg-head { border-bottom: 1px solid #e2d8c3; }
.elgg-module-info > .elgg-head { background-color: #ebe7df; }
.elgg-module-featured { border: 1px solid #e2d8c3; }
.elgg-module-featured > .elgg-head { background-color: #ebe7df; border-bottom: 1px solid #e2d8c3; }


/* Main layout */
body { background:#EBE7DF; font-family:Lato; }
.elgg-main { padding:0; }
.elgg-page-navbar { padding: 0 0px; }
.elgg-page-body { padding: 30px 0; }
.elgg-page-default .elgg-page-topbar > .elgg-inner, 
.elgg-page-default .elgg-page-header > .elgg-inner, 
.elgg-page-default .elgg-page-navbar > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner, 
.elgg-page-footer-transitions2 > .elgg-inner { /* max-width:96%; max-width:1170px; */ max-width:990px; margin:0 auto; padding:0; border:0; }
.elgg-page-body > .elgg-inner { /* max-width:1170px; */ max-width:990px; margin:0 auto; }

/* Breadcrumb */
.elgg-breadcrumbs { font-size: 80%; }
.elgg-breadcrumbs > li > a:hover { text-decoration: none; color: #4b8f74; }

/* Listes et pagination */
.elgg-menu-entity { max-width: 50%; min-width:100px; }
.elgg-tabs, .elgg-menu-filter { margin-bottom: 0; }
.elgg-list { margin-top: 0; background: white; padding: 20px 40px 40px 40px; }
.elgg-pagination { margin: 20px 0 10px 0; }
.elgg-pagination li a, .elgg-pagination li span { background: #E2D8C3; border: 0; margin: 0 5px; }
.elgg-pagination .elgg-state-disabled span { color: #999; }
.elgg-pagination li.elgg-state-selected a, .elgg-pagination li.elgg-state-selected span { background: #89BF4E; color:white; }



/* Contributions - Recherche homepage */
.elgg-page-body-search { background:#E2D8C3; padding: 30px 0; text-align:center; }
#transitions-search-home input { font-size:20px; color: #666; border: 0; border-radius: 0; margin:0; }
#transitions-search-home .elgg-button-submit { background-color: #89BF4E; color:white; padding: 0.5em 0.8em; }
#transitions-search-home .elgg-button-submit:hover { background-color: #9bd759; color:#023824; }
.transitions-search-menu .elgg-button { margin: 10px 10px 0 0; font-size: 12px; border-radius:0; }
.transitions-search-menu a.elgg-button:hover, .transitions-search-menu a.elgg-button:focus, .transitions-search-menu a.elgg-button:active { color:white; }

#transitions-search {  }
.transitions-index-search { padding-top: 20px; }
.transitions-index-search .transitions-search-menu { margin: 20px; }
#transitions-search input { font-size:20px; color: #666; border: 0; border-radius: 0; margin:0; }
#transitions-search .elgg-button-submit { background-color: #89BF4E; color:white; padding: 0.5em 0.8em; }
#transitions-search .elgg-button-submit:hover { background-color: #9bd759; color:#023824; }


.elgg-comments .elgg-list { padding: 30px 30px 20px 30px; }
.elgg-comments .elgg-list > li { border:0; border-bottom: 1px solid #e2d8c3; margin-bottom: 20px; padding: 0; }




/* Collections */


/* Topbar */
.elgg-page-topbar { background: white; border: 0; color: #666; font-size: 14px; }
.elgg-menu-topbar > li > a { color: #666; font-size: 14px; padding-top:0; margin:0 10px; }
.elgg-menu-topbar > li > a:hover, .elgg-menu-topbar > li > a:active, .elgg-menu-topbar > li > a:focus { color: #333; }
.elgg-menu-topbar > li > a.elgg-topbar-avatar { padding-top: 2px; }
.messages-new { background-color: #ABD660; position:initial; line-height:16px; box-shadow: none; min-width: 14px; height: 14px; display: inline-block; margin-left: 2px; }


/* Header */
/*
.elgg-page-header { background: url(<?php echo $imgurl; ?>flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; height:200px; }
.elgg-page-header h1 img { max-width:100%; }
*/
.elgg-page-header { padding: 0 0 20px 0; position: relative; background: white; }
.elgg-page-default .elgg-page-header > .elgg-inner { min-height:0; }
.elgg-page-header a, .elgg-page-header a:hover, .eminlgg-page-header a:active, .elgg-page-header a:focus { line-height:40px; }
.elgg-page-header h1, .elgg-page-header a h1, .elgg-page-header a:hover h1, .elgg-page-header a:active h1, .elgg-page-header a:focus h1 { text-transform: uppercase; color: #4B8F74; font-size: 14px; font-family:Lato, sans-serif; text-shadow:none; display:inline-block; width: 100%; }
.elgg-page-header a h1 .transitions-eco { color:#89BF4E; }
.elgg-page-header a h1 .transitions-num { color:#003923; }
.elgg-page-header h1 img { max-height:40px; float:left; margin-right: 20px; }

/* Slider */
.transitions-home-slider { width:75%; height:260px; }
.slider-homepage-slider { font-size: 18px; color: #555; }
.slider-homepage-slider #slider-uid-1 { background: transparent; }
#slider-uid-1 .transitions2-slide-image { max-width: 50% !important; }
.slider-homepage-slider .anythingSlider .panel { overflow:auto; background:white; }
.transitions2-slide-image { float:left; margin-right:32px; max-width:50%; }
.transitions2-slide-text { padding:32px 32px 20px 0px; }
.transitions2-slide-text-inner { overflow: auto; max-height:200px; }
.slider-homepage-slider h3 { font-size: 24px; color: #555; margin-bottom: 20px; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls { text-align: center; bottom: 40px; height: auto; width: 100%; background:transparent; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls ul.thumbNav { width: auto; padding:0; text-align: center; display: inline-block; }
.slider-homepage-slider .anythingSlider .anythingControls ul a { background:#EBE7DF; height:15px; width:15px; border:3px solid #EBE7DF; margin: 0 5px; border-radius:10px; }
.slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls a.cur, .slider-homepage-slider .anythingSlider-cs-portfolio .anythingControls a:hover { background:#89BF4E; height:15px; width:15px; border:3px solid #EBE7DF; margin: 0 5px; }
.transitions-home-contribute { width:25%; float:right; height:260px; background:#297256; }


/* Footer */
.elgg-page-footer { background:#E2D8C3; padding: 30px 0 0 0; }
.elgg-page-footer .cmspages-output { width: 100%; }
/*
.elgg-footer-partners-text { width:460px; max-width:100%; float:left; }
.elgg-footer-partners-logo { width:460px; max-width:100%; float:right; text-align: right; }
*/
.elgg-footer-partners-logo { margin-bottom:30px; }
.elgg-footer-partners-logo img { height: 40px; margin: 0 10px 10px 0; }
.elgg-page-footer-transitions2 { padding: 30px 0; background:white; text-align:center; }
.elgg-page-footer-transitions2, .elgg-page-footer-transitions2 a { font-size:12px; color:#909AAD; }
.elgg-page-footer-transitions2 .elgg-footer-logo img { max-height:40px; float: left; margin-right: 20px; }
.elgg-page-footer-transitions2 .elgg-menu-footer { width: 600px; max-width: 100%; margin: 0 auto; float: none; }
.elgg-page-footer-transitions2 .transitions-socialshare a { font-size:20px; margin:0 0 0 1em; }
.elgg-menu-footer > li:after { content: ''; }


/* Menu */
#login-dropdown-box { z-index:9001; top: 34px !important; }
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
.elgg-sidebar { border-left: 1px solid #c6beac; }

/* Homepage */
.elgg-menu-item-logohome a { padding: 0 !important; }
.elgg-button-transitions { font-size:3em; padding:1em; background-color:#9C9; margin:0 auto; }
.elgg-form-theme-transitions2-select-article select { max-width: 10em; }

/* Profile */
.profile-static-block { padding-bottom: 40px; }
.profile { background: white; margin-bottom:40px; }
.profile-static-block h2 { /* background: #F0F0F0; padding: 10px; */ text-transform: initial; }
.profile-transitions { padding: 0 0 40px 40px; }
.profile-transitions .transitions-gallery-item { margin-right: 0; }
.profile-comments .elgg-list { background: #e2d8c3; }
/*
.elgg-module > .elgg-body { background: white; padding: 10px 20px 20px 20px; }
*/


/* Feedback */
/*
#feedbackWrapper { bottom: 46px; right: 46px; left:initial; top:initial; }
#feedBackContentWrapper { left:0; }
#feedBackTogglerLink { background: #7DF537; box-shadow: none; border: 3px solid black; border-right: 0; border-bottom: 0; border-radius: 10px 0 0 0; }
#feedBackTogglerLink img { margin: 0 10px 5px 0; }
*/
#feedbackWrapper { top: initial; bottom: 60%; }
#feedBackToggler { opacity: 0.7; }
#feedBackTogglerLink { border: 0; border-radius: 0; box-shadow: none; background: transparent; }
#feedBackToggler:hover, #feedBackToggler:active, #feedBackToggler:focus { opacity: 1; }
#feedBackContent { color: #333; border-radius: 0; box-shadow: none; }
#feedBackForm { padding: 0 10px; }
#feedBackIntro, #feedBackFormStatus { padding: 0 10px 10px 10px; }
#feedBackClose { padding: 10px 10px 0px 10px; }
#feedBackContent .elgg-head { background: #4c8a71; padding:10px; }
#feedBackContent h3 { color: white; text-transform: uppercase; }
#feedbackSuccess { /* color: white; */ background-color: #ABD660; }


/* Members */
.esope-alpha-char { background: white; padding: 5px 10px; font-size: 1.2em; letter-spacing: 4px; }




@media (max-width: 1030px) {
}

@media (max-width: 820px) {
}

@media (min-width: 767px) {
}

@media (max-width: 766px) {
	.elgg-page-topbar { padding: 0; }
	.elgg-topbar-nav-collapse { display:none; }
	.elgg-menu-topbar { width:100%; }
	.elgg-menu-topbar ul { display:block; position:initial; width:100%; margin:0; border:0; box-shadow:none; }
	.elgg-menu-topbar > li { float:none; width: 100%; margin: 0; padding: 0; }
	.elgg-menu-topbar li, .elgg-menu-topbar li { display: inline-block; width: 100%; }
	.elgg-menu-site > li.float-alt { width: 100%; }
	.elgg-menu-topbar > li > a.elgg-topbar-dropdown { display:none; }
	.elgg-menu-topbar > li > a, .elgg-menu-topbar li li > a, .elgg-menu-topbar > li > a.elgg-topbar-avatar { padding-top: 0; margin: 0 10px; }
	
}

@media (max-width: 600px) {
	.flexible-block { float:none !important; margin:0 auto; width:auto !important; }
}


