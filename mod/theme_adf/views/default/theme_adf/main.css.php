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
.elgg-page-topbar { background: #0b2d51; /* position: fixed; left: 0; right: 0; top: 0; z-index: 5; */ }
.elgg-page-topbar a, .elgg-page-topbar a:visited { color: #FFFFFF; }
.elgg-page-topbar a:hover, .elgg-page-topbar a:focus { color: #FFFFFF; text-decoration: none; }

.elgg-page-topbar .elgg-menu li:hover > .elgg-child-menu::before { color: #0b2d51; }
.elgg-page-topbar .elgg-menu li .elgg-child-menu { background: #0b2d51; }
.elgg-page-body { padding-top: 3rem; }

.elgg-nav-collapsed .elgg-nav-collapse { margin-top: 2rem; }

.elgg-nav-logo { display: flex; width: 11rem; background: #0b2d51; padding: .5rem; /* border-radius: 0 0 3rem 0; padding: 1rem; */ }
.elgg-nav-logo h1 { flex: 1; display: flex; position: absolute; top: 0; left: 0; padding: 1rem 1rem; background: #0b2d51; border-radius: 0 0 2rem 0; }
.elgg-nav-logo h1 a { flex: 1; width: 10rem; background: transparent url('<?php echo $url; ?>mod/theme_adf/graphics/logo-ADF-assemblee-des-departements-de-france_long.png') 0% 50%/contain no-repeat; }
.elgg-heading-site .elgg-anchor-label { text-indent: -9999px; display: inline-block; }
.elgg-heading-site a { flex: 1; }

.elgg-page-topbar .elgg-form-search [type="text"] {  background: #1b3b5d; }

.elgg-menu-item-entity-menu-toggle .elgg-menu-content { min-width: 1.5em; text-align: center; }

.elgg-menu-item-help { background: #e57b5f; }


/* FOOTER */
.elgg-page-footer { background: #0b2d51; border-top: 1px solid #e6e6ea; color: #969696; font-size: .9rem; }
.elgg-page-footer a { color: #DFDFDF; }
.elgg-page-footer a:hover { color: #FFFFFF; }


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
.elgg-context-members .elgg-layout-content .elgg-list-entity { display: flex; flex-wrap: wrap; }
.elgg-context-members .elgg-layout-content .elgg-list-entity > li { flex: 0 0 24rem; border-bottom: 0; box-shadow: 0 0 2px -1px #0b2d51; margin: .5rem; border-radius: .25rem; display: flex; flex-direction: column; }

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



@media (min-width: 105rem) {
	.elgg-page-default .elgg-page-section > .elgg-inner { max-width: 80vw; }
	
	.elgg-page-body { padding-top: 1rem; }
	
	.elgg-page-topbar > .elgg-inner { position: relative; }
	.elgg-nav-logo { position: absolute; top: 0; left: -10vw; width: calc(10vw + 1rem); height: 7.5rem; border-radius: 0 0 3rem 0; margin-left: 0; padding: 1rem 1rem 1rem 1rem; }
	.elgg-nav-logo h1 { position: initial; padding: initial; background: initial; border-radius: initial; }
	.elgg-nav-logo h1 a { background-image: url('<?php echo $url; ?>mod/theme_adf/graphics/logo-ADF-assemblee-des-departements-de-france.png'); background-position: center; }
}

@media (min-width: 80rem) {
	.elgg-layout-sidebar { width: 24rem; }
}

@media (max-width: 80rem) {
	.elgg-nav-logo { left: 0; margin-left: 0; }
	.elgg-nav-logo h1 { padding: 0.5rem 1rem; line-height: 2.5rem; }
	.elgg-heading-site a { flex: 1; width: 8rem; }
}


@media (min-width: 50rem) {
	.elgg-layout-sidebar-alt { /* max-width: 24vw; */ max-width: 30%; }
}

