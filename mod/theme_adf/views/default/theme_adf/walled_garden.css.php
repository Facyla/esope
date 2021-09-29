<?php
$url = elgg_get_site_url();
?>

/* Accueil public (walled garden) */
.elgg-page-walled-garden { flex-direction: column; }

.elgg-page-header { width: 100%; display: flex; flex-wrap: wrap; justify-content: space-between; }
.elgg-page-header .elgg-nav-logo { background: #0b2d51; }

.elgg-nav-logo { flex: 0 0 auto; align-self: start; display: flex; background: #0b2d51; /* width: 11rem; border-radius: 0 0 3rem 0; */ padding: 4rem 1rem 1rem; }
.elgg-nav-logo h1 { flex: 1; display: flex; /* position: absolute; */ top: 0; left: 0; padding: 0rem 1rem; background: #0b2d51; border-radius: 0 0 2rem 0; }
.elgg-nav-logo h1 a { flex: 1; width: 10rem; background: transparent url('<?php echo $url; ?>mod/theme_adf/graphics/titre-departements-en-reseaux-France-ADF.png') 0% 50%/contain no-repeat; }
.elgg-heading-site .elgg-anchor-label { text-indent: -9999px; display: inline-block; }

.elgg-nav-login { flex: 0 0 auto; display: flex; align-items: baseline; padding: 1rem 2rem; }
#login-dropdown { order: initial; }
#login-link { padding: .25rem 1rem; border: 1px solid #0078ac; border-radius: 1.5rem; }
#register-link { padding: .5rem 1rem; }
#register-link a { color: #2d3047; }

.elgg-page-walled-garden > .elgg-inner { width: 40vw; min-width: 30rem; max-width: calc(100% - 4rem); }
.elgg-page-body { margin: 2rem 3rem; }

.elgg-page-footer { width: 100%; background: #0b2d51; color: #ffffff; padding: 1.5rem 3rem; }
.elgg-page-footer .elgg-inner { display: flex; }
.elgg-page-footer .footer-logo { flex: 0 0 auto; margin-right: 3rem; }
.elgg-page-footer {  }

