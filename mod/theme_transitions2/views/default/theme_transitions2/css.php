<?php
$url = elgg_get_site_url();
$imgurl = $url . 'mod/theme_transitions2/graphics/';
?>


/* Generic styles */
a { color: #223300; }
img { max-width: 100%; }
select { max-width: 98%; }
input, textarea { max-width: 100%; }


.flexible-block { float:left; }


/* Main layout */
.elgg-page-navbar { padding: 0 0px; }
.elgg-page-default .elgg-page-navbar > .elgg-inner, 
.elgg-page-default .elgg-page-body > .elgg-inner, 
.elgg-page-default .elgg-page-footer > .elgg-inner { /* max-width:96%; */ max-width:990px; margin:0 auto; }
.elgg-page-body > .elgg-inner { max-width:990px; margin:0 auto; }


/* Header */
.elgg-page-header { background: url(<?php echo $imgurl; ?>flickr/miuenski_miuenski_2311617707_33a63b3928_o.jpg) #223300 50% 50% no-repeat; background-size:cover; height:200px; }
.elgg-page-header h1 img { max-width:100%; }

/* Menu */
/*
.elgg-page-navbar { background: #223300; }
.elgg-menu-site > .elgg-state-selected > a, .elgg-menu-site > li:hover > a { background-color: #669900; }
.elgg-button-dropdown:hover, .elgg-button-dropdown:focus, .elgg-button-dropdown.elgg-state-active { background: #669900; }
.elgg-button-nav:hover { background-color: #669900; }
*/
.elgg-page-navbar { background: white; }
.elgg-menu-site > a, .elgg-menu-site > li > a, .elgg-button-dropdown { color: #669900; background-color:white; }
.elgg-menu-site > .elgg-state-selected > a { color: #223300; background-color:white; }
.elgg-menu-site > li:hover > a { color: white; background-color:#669900; }
.elgg-button-dropdown:hover, .elgg-button-dropdown:focus, .elgg-button-dropdown.elgg-state-active { background: #669900; transition-duration:0.5s; }
.elgg-button-nav:hover { background-color: #669900; }


/* Sidebar */
.elgg-menu-extras { font-size: 1.5em; }
.elgg-menu-extras li { margin-right: 0.4em; }

/* Homepage */
.elgg-menu-item-logohome a { padding: 0 !important; }
.elgg-button-transitions { font-size:3em; padding:1em; background-color:#9C9; margin:0 auto; }


/* Profile */
.profile-static-block { padding: 0 0.5em 0.5em 0.5em; }

/* Feedback */
#feedbackWrapper { bottom: 46px; right: 46px; left:initial; top:initial; }
#feedBackContentWrapper { left:0; }
#feedBackTogglerLink { background: #7DF537; box-shadow: none; border: 3px solid black; border-right: 0; border-bottom: 0; border-radius: 10px 0 0 0; }
#feedBackTogglerLink img { margin: 0 10px 5px 0; }



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


