<?php
$url = elgg_get_site_url();

/* THEME ADF - DEPARTEMENTS EN RESEAUX */
/*

Teintes de bleu : 
	Bleu sombre intense : #0b2d51
	Bleu sombre 2 : #1b3b5d

	Bleu clair intense : #0092ef  (aplats)
	Bleu ciel : #36b9ff
	Bleu pastel : #5ba2d9
	Bleu pastel clair : #6bb6f0

Orange : e57b5f (aplats)

Dégradés du noir au blanc : 
	Gris (teinte marron) : #141516
	Gris sombre : #333333
	Gris sombre 2 (teinte bleue): #40464d
	Gris sombre 3 : #555555
	Gris moyen : #777777
	Gris teinte bleue : #7e8a96
	Gris moyen 2 : #949494
	Gris teinte vert : #a1aba8
	Gris clair : #cccccc
	Gris clair 2 : #dfdfdf
	Gris pâle teinte bleue : #e6eaed
	Gris pâle : #eeeeee

*/
?>

/* Layouts */


/* Eléments et styles génériques */
a, a:visited { color: #0b2d51; }
a:hover, a:focus { color: #02080e; text-decoration: underline; }


.elgg-button-action, .elgg-button-action:visited { background: #5ba2d9; color: #fff; }
.elgg-button-submit { background: #1b3b5d; color: #fff; }



/* Topbar et menus */
.elgg-page-topbar { background: #0b2d51; box-shadow: 0 -.25rem 1rem 0 #fff; /* position: fixed; left: 0; right: 0; top: 0; z-index: 5; */ }
.elgg-page-topbar a, .elgg-page-topbar a:visited { color: #FFFFFF; }
.elgg-page-topbar a:hover, .elgg-page-topbar a:focus { color: #FFFFFF; text-decoration: none; }

.elgg-page-topbar .elgg-menu li:hover > .elgg-child-menu::before { color: #0b2d51; }
.elgg-page-topbar .elgg-menu li .elgg-child-menu { background: #0b2d51; }
.elgg-page-body { padding-top: 3rem; }

.elgg-page-topbar .elgg-menu li > a { border-bottom: 3px solid transparent; /* margin-bottom: -3px; */ }
.elgg-page-topbar .elgg-menu li.elgg-state-selected > a { background-color: initial; border-bottom: 3px solid #e57b5f; }
.elgg-page-topbar .elgg-menu li:hover > a { /* background: #5ba2d9; */ background: #0b2d51; }

.elgg-nav-collapse { flex-wrap: wrap; }

.elgg-nav-collapsed .elgg-nav-collapse { margin-top: 2rem; }

.elgg-nav-logo { flex: 0 0 auto; align-self: start; display: flex; background: #0b2d51; padding: 0 .5rem; /* width: 11rem; border-radius: 0 0 3rem 0; padding: 1rem; */ }
.elgg-nav-logo h1 { flex: 1; display: flex; /* position: absolute; */ top: 0; left: 0; padding: 0rem 1rem; background: #0b2d51; border-radius: 0 0 2rem 0; }
.elgg-nav-logo h1 a { flex: 1; width: 10rem; background: transparent url('<?php echo $url; ?>mod/theme_adf/graphics/titre-departements-en-reseaux-France-ADF.png') 0% 50%/contain no-repeat; }
.elgg-heading-site .elgg-anchor-label { text-indent: -9999px; display: inline-block; }
.elgg-heading-site a { flex: 1; }

.elgg-nav-search { display: none; max-width: 24rem; }
.elgg-nav-search .elgg-form-search { /* border: 1px solid #fff; */ background: rgba(255,255,255,0.1); }
.elgg-page-topbar .elgg-form-search [type="text"] { background: #1b3b5d; }
.elgg-page-topbar .elgg-form-search fieldset { width: 100%; display: inline-block; }
.elgg-page-topbar .elgg-form-search fieldset > .elgg-field { max-width: calc(100% - 10rem); }

.elgg-menu-item-entity-menu-toggle .elgg-menu-content { min-width: 1.5em; text-align: center; }
.elgg-page-topbar .elgg-menu li.elgg-menu-item-groups .elgg-child-menu { width: 20rem; max-width: 100vw; }
.elgg-page-topbar .elgg-menu li.elgg-menu-item-members .elgg-child-menu { width: 20rem; max-width: 100vw; }

.elgg-menu-item-help { /* background: #e57b5f; */ }

.group-header { max-width: 100vw; /* width: 100vw; margin: -2rem calc(-10vw - 1rem) 0; padding: .5rem 10vw; */ background: #fff; border-bottom: 1px solid #0b2d51; min-height: 3.5rem; display: flex; }
.group-header .group-image { width: 2.5rem; height: 2.5rem; margin: 0 1rem; }
.group-header .group-search { align-self: center; flex: 1 1 auto; }

#feedBackTogglerLink { background: #e57b5f; }


/* LAYOUTS & SIDEBARS */
.elgg-layout-columns > .elgg-sidebar { order: -1; margin-left: 0; margin-right: 2rem; }


/* FOOTER */
.elgg-page-footer { background: #0b2d51; border-top: 1px solid #e6e6ea; color: #969696; font-size: .9rem; }
.elgg-page-footer a { color: #DFDFDF; }
.elgg-page-footer a:hover { color: #FFFFFF; }
.elgg-page-footer .elgg-inner { display: flex; align-items: center; }


/* Accueil */
.elgg-layout-header .elgg-form-thewire-add { flex: 1; }

.elgg-module-home-mygroups { border: 5px solid #5ba2d9; padding: 1rem; border-radius: 2rem; }
.elgg-module-home-mygroups ul { display: grid; grid-template-columns: repeat(auto-fit,minmax(6rem,1fr)); grid-gap: .5rem 0.25rem; }
.elgg-module-home-mygroups li { list-style: none; }

.elgg-module-home-recommandations { background: #e57b5f; padding: 1rem; border-radius:2rem; }
.elgg-module-discussions-global { flex: 1 0 12rem; }
.elgg-module-discussions-my-groups { flex: 1 0 12rem; }


.groups-mine { width: 100%; }
.groups-mine ul { display: grid; grid-template-columns: repeat(auto-fit,minmax(6rem,1fr)); grid-gap: .5rem 0.25rem; }


/* ANNUAIRE */
.elgg-context-members .elgg-layout-content .elgg-list-entity { display: grid; grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr)); grid-gap: 1rem 1rem; }
.elgg-context-members .elgg-layout-content .elgg-list-entity > li { /* flex: 0 0 24rem; */ border-bottom: 0; box-shadow: 0 0 2px -1px #0b2d51; margin: .5rem; border-radius: .25rem; display: flex; flex-direction: column; }

.elgg-item-user .elgg-image-block { flex: 1; }
/*
.elgg-item-user .elgg-image-block { display: flex; flex-direction: column; }
.elgg-item-user .elgg-image-block .elgg-image { margin: 0 0 .5rem 0; }
*/
.elgg-item-user .elgg-image-block .elgg-image .elgg-avatar img { border-radius: 50%; }
.elgg-item-user .elgg-image-block .elgg-body {  }
.elgg-item-user .elgg-image-block .elgg-body .elgg-listing-summary-metadata { order: 2; }
.elgg-item-user .elgg-image-block .elgg-body .elgg-listing-summary-title {  flex: 1; }
.elgg-item-user .contacts { background: #e6eaed; margin: .5rem -1rem -1rem -1rem; padding: 0.5rem 1rem; }


/* PROFIL */
.elgg-context-profile .elgg-layout-header { background: #e6eaed; }
.elgg-context-profile .elgg-layout-header .elgg-avatar { order: -1; margin-right: 1rem; }
.elgg-context-profile .elgg-layout-header .profile-actions-menu-wrapper { order: 0; }
.elgg-context-profile .elgg-layout-header .profile-admin-menu-wrapper { order: 1; }
.elgg-context-profile .elgg-layout-header h2 { order: 3; }


/* DEBUT TEST PLEINE LARGEUR */
.elgg-page-default .elgg-page-section > .elgg-inner { max-width: 100vw; padding: 0; }
.elgg-page-body { padding-top: 0rem; }
/*
.elgg-layout-columns > .elgg-body { padding-left: 24rem; }
.elgg-layout-sidebar { z-index: 1; width: 24rem; background: #244263; position: fixed; top: 0rem; bottom: 0; overflow: auto; padding: 4rem 1rem 1rem 2.5rem; }
.elgg-page-topbar { background: #0b2d51; z-index: 2; position: fixed; left: 0; right: 0; }
*/

.elgg-layout-breadcrumbs { display: none; }
.elgg-layout-header { background: #dee3e8; border: 0; /* background: #244263; border-bottom: 1px solid #0b2d51; color: white; */ margin-bottom: 0; padding: 0.25rem 2rem 0.25rem 2rem; }
.elgg-page-footer { border-top: 1px solid #0b2d51; }
.elgg-layout-columns > .elgg-sidebar { background: #fafafa; background: white; background: #0b2d5122; padding: 1rem 0 1rem 0rem; /* border-right: 1px solid #244263; */ margin-right: 0rem; }
.elgg-sidebar .elgg-module > .elgg-head, .elgg-sidebar .elgg-module > .elgg-body { padding-left: 2rem; }
.elgg-layout-header > h2, .elgg-layout-header > h3 { font-size: 1.5rem; }
.elgg-layout-columns > .elgg-body { margin: 1rem 2rem; }
.elgg-layout-one-column .elgg-layout-columns > .elgg-body { margin-left: 2rem; margin-right: 2rem; }

.elgg-sidebar .elgg-menu, .elgg-sidebar .elgg-menu li { border: 0; }
.facets-video iframe { margin: 1rem 0 -1rem 0; }
@media (min-width: 80rem) {
	.elgg-layout-columns > .elgg-sidebar { width: 20rem; }
}
@media (max-width: 80rem) {
	.elgg-layout-columns > .elgg-sidebar { border-right: 0; /* border-bottom: 1px solid #244263; box-shadow: 0px 0px 3px #244263; */ }
}

.elgg-layout-columns > .elgg-sidebar-alt { order: 1; padding: 1rem .5rem; /* background: #e57b5f33; */ }
.elgg-layout-columns > .elgg-sidebar-alt .elgg-module { background: white; }
@media (min-width: 50rem) {
	.elgg-layout-sidebar-alt { width: 20rem; margin-right: 0; }
}

.elgg-layout-header > .elgg-heading-main { padding: .25rem 1rem;; }
.elgg-layout-header > .elgg-menu-container { padding: .25rem 1rem;; }
.elgg-nav-collapsed .elgg-nav-collapse { display: flex; flex-direction: row; flex-wrap: wrap; }
.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container > ul { display: grid; grid-template-columns: repeat(auto-fit,minmax(12rem,1fr)); grid-gap: 1rem 1rem; border-top: 1px solid rgba(255,255,255,.3); }

.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-topbar-container { flex: 0 1 auto; flex: 1 0 100%; }
.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-topbar-container ul .elgg-child-menu { display: grid; grid-template-columns: repeat(auto-fit,minmax(12rem,1fr)); grid-gap: 1rem 1rem; }

.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-site-container { flex: 1 1 auto; }
.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-site-container ul { display: block; }
.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-site-container ul .elgg-child-menu { display: grid; grid-template-columns: repeat(auto-fit,minmax(14rem,1fr)); grid-gap: 0rem 0rem; padding-left: 1rem; width: auto; }
.elgg-nav-collapsed .elgg-nav-collapse .elgg-menu-container.elgg-menu-site-container ul .elgg-child-menu li a {  }

.elgg-menu-page, .elgg-menu-owner-block { background: transparent; }
.elgg-menu-page li.elgg-state-selected > a, .elgg-menu-owner-block li.elgg-state-selected > a { background-color: #fff; }


/* sous-menu (fixe) en pleine largeur */
.elgg-page-topbar { position: fixed; top: 0; width: 100vw; z-index: 1; }
.elgg-page-body { margin-top: 4rem; }
.elgg-page-topbar .elgg-menu li .elgg-child-menu { position: fixed; left: 0; right: 0; padding: 2rem 3rem; width: auto; z-index: 2; background: #5ba2d9; }

.elgg-page-topbar .elgg-menu li:hover .elgg-menu-parent .fa-caret-down::before { font-size: 1rem; vertical-align: middle; }
.elgg-page-topbar .elgg-menu li:hover .elgg-menu-parent .fa-caret-down::before { content: "\f0d8"; }
.elgg-page-topbar .elgg-menu li .elgg-menu-parent .fa-angle-down::before { font-size: 1rem; content: "\f0d7"; }
.elgg-page-topbar .elgg-menu li:hover .elgg-menu-parent .fa-angle-down::before { content: "\f0d8"; }


.elgg-page-topbar .elgg-menu.elgg-child-menu > li { width: auto; }
.elgg-page-topbar .elgg-menu li:hover > .elgg-child-menu::before { color: #5ba2d9; right: 50%; /* content: "\25bc"; padding: 0; top: 0; color: #0b2d51; */ display: none; }
.elgg-page-topbar .elgg-menu li:hover > a.elgg-menu-parent::after { content: " "; display: block; width: 0; height: 0; border-top: .75rem solid #0b2d51; border-bottom: 0; border-right: 1rem solid transparent; border-left: 1rem solid transparent; position: absolute; bottom: calc(3px - 0.75rem); left: calc(50% - 1rem); z-index: 3; }
.elgg-page-topbar .elgg-menu li:hover > .elgg-child-menu { display: grid; grid-template-columns: repeat(auto-fit,minmax(12rem,1fr)); grid-gap: 0rem 0rem; }
.elgg-page-topbar .elgg-menu li.elgg-menu-item-members .elgg-child-menu, 
.elgg-page-topbar .elgg-menu li.elgg-menu-item-groups .elgg-child-menu { width: auto; }
.elgg-page-topbar .elgg-menu.elgg-child-menu > li > a { border: 0; }


/* FIN TEST PLEINE LARGEUR */


/*
@media (min-width: 105rem) {
	.elgg-page-default .elgg-page-section > .elgg-inner { max-width: 80vw; }
	
	.elgg-page-body { padding-top: 1rem; }
	
	.elgg-page-topbar > .elgg-inner { position: relative; }
	.elgg-nav-logo { position: absolute; top: 0; left: -10vw; width: calc(9vw + 1rem); height: 7.5rem; border-radius: 0 0 3rem 0; margin-left: 0; padding: 1rem 1rem 1rem 0rem; }
	.elgg-nav-logo { position: fixed; top: 0; left: 0; z-index: 1; }
	.elgg-nav-logo h1 { position: initial; padding: initial; background: initial; border-radius: initial; }
	.elgg-nav-logo h1 a { background-image: url('<?php echo $url; ?>mod/theme_adf/graphics/titre-departements-en-reseaux-France-ADF.png'); background-position: center; }
}
@media (max-width: 105rem) {
	.elgg-nav-collapse { max-width: calc(100% - 12rem); margin-left: auto; }
}
*/

@media (min-width: 80rem) {
	.elgg-layout-sidebar { width: 24rem; }
}

@media (max-width: 80rem) {
	.elgg-nav-logo { left: 0; margin-left: 0; }
	.elgg-nav-logo h1 { padding: 0.5rem 1rem; line-height: 2.5rem; }
	.elgg-heading-site a { flex: 1; width: 8rem; }
}


@media (min-width: 50rem) {
	
}

