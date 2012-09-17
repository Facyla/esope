<?php
/**
 * English strings
 */

$footer_default = '<div class="mts clearfloat right"><a href="http://elgg.org"><img src="' . elgg_get_site_url() . '_graphics/powered_by_elgg_badge_drk_bckgnd.gif" alt="Powered by Elgg" width="106" height="15" /></a></div>';

$en = array(
	
	'adf_platform:settings:layout' => "Pour retrouver la configuration initiale, effacez tout le contenu d'un champ. Pour définir un champ vide, ajoutez un espace dans le champ.",
	// Layout settings
	'adf_platform:header:content' => "Contenu de l'entête (code HTML libre). Effacez ce champ pour récupérer la configuration d'origine avec une image de logo configurable. Pour laisser l'espace vide, laissez seulement un espace ou un saut de ligne.",
	'adf_platform:header:default' => '<div id="easylogo"><a href="/"><img src="' . $vars['url'] . '/mod/adf_public_platform/img/logo.gif" alt="Logo du site"  /></a></div>',
	'adf_platform:header:height' => "Hauteur de l'entête du menu (identique à celle de l'image de fond utilisée)",
	'adf_platform:header:background' => "URL de l'image de fond de l'entête (apparaît également sous le menu)",
	'adf_platform:footer:color' => "Couleur de fond du footer",
	'adf_platform:footer:content' => "Contenu du footer",
	'adf_platform:footer:default' => $footer_default,
	'adf_platform:home:displaystats' => "Afficher les statistiques en page d'accueil",
	'adf_platform:css' => "Ajoutez ici vos styles CSS personnalisés",
	'adf_platform:css:default' => "Les CSS ajoutés ici surchargent la feuille de style principale (sans la remplacer)",
	'adf_platform:dashboardheader' => "Zone configurable en entête du tableau de bord des membres.",
	// Behaviour settings
	'adf_platform:index:url' => "URL du fichier de la page d'accueil (doit pouvoir être inclus)",
	'adf_platform:login:redirect' => "URL de redirection après connexion",
	
	
);

add_translation('en', $en);
