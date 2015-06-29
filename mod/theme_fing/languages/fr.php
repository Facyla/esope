<?php
/**
* Elgg theme_fing plugin language pack
* 
* @package theme_fing
**/
$url = elgg_get_site_url();

$french = array(
	'theme_fing' => "Thème Réseau Fing",
	'theme_fing:title' => "Thème Réseau Fing",
	
	// Home pins
	'theme_fing:settings:homehighlight' => "Page d'accueil du site : contenus en Une",
	'theme_fing:settings:homehighlight:help' => "Active ou non un bloc contenant une sélection (antéchronologique) de contenus mis en avant par les admins ou modérateurs du site en page d'accueil.<br />Le bloc est prévu pour 4 articles, le premier entier avec 3 vignettes sur son côté. Selon les mises en page, vous avez la possibilité de configurer des articles supplémentaires.",
	'theme_fing:settings:homehighlight1' => "Article en Une (affiché en entier)",
	'theme_fing:settings:homehighlight2' => "2e article (vignette)",
	'theme_fing:settings:homehighlight3' => "3e article (vignette)",
	'theme_fing:settings:homehighlight4' => "4e article (vignette)",
	'theme_fing:settings:homehighlightN' => "autre article (vignette)",
	'theme_fing:settings:disabled' => "Désactivé",
	'theme_fing:settings:enabled' => "Activé",
	
	'theme_fing:comments:publicnotice' => "Vous devez vous identifier pour ajouter un commentaire.",
	'theme_fing:groups' => "Groupes",
	'theme_fing:groups:mine' => "Mes Groupes",
	'theme_fing:allgroups' => "Tous les groupes",
	'theme_fing:groups:featured' => "Nos travaux",
	'theme_fing:homegroups:featured' => "Nos travaux en cours",
	'groups:theme' => "Thématique",
	'theme_fing:projet' => "Projets",
	'theme_fing:prospective' => "Prospective",
	'theme_fing:archive' => "Archives",
	
	'profile:types:fing' => "Equipe Fing",
	'profile:types:adherents' => "Adhérents",
	
	'theme_fing:digest:pin' => "Contenus sélectionnés",
	'theme_fing:digest:likes' => "Quelques contenus les plus appréciés",
	'theme_fing:userlikedthis' => "%s membre a particulièrement apprécié",
	'theme_fing:userslikedthis' => "%s membres ont particulièrement apprécié",
	'theme_fing:digest:message:title:site' => "Votre revue %s du %s",
	'theme_fing:digest:message:title:group' => "Votre revue %s de % - %s",
	
	'theme_fing:ressources' => "Ressources",
	'theme_fing:ressources:group' => "Ressources du groupe %s",
	
	'theme_fing:qntransitions' => "Questions Numériques - Transitions",
	
	'theme_fing:register:create' => "Créez votre compte", 
	'theme_fing:register:participate' => "et participez aux projets et recherche de la Fing", 
	'theme_fing:register:3minutes'=> "1 minute pour ouvrir un compte",
	'theme_fing:register:prefill' => "Pré-remplissez votre inscription avec :",
	'theme_fing:register:createwithmail' => "Ou inscrivez-vous avec votre email :",
	'theme_fing:register:discoverwork' => "Découvrez nos travaux en cours",
	'theme_fing:register:usernameurl' => "Username pour personnaliser l'url de votre profil<br /><small>reseau.fing.org/profile/<em>username</em></small>",
	'theme_fing:register:choosegroups' => "Cochez les cases des travaux que vous souhaitez rejoindre dès l'inscription",
	'theme_fing:register:email' => "Email",
	'theme_fing:register:terms' => "En vous inscrivant sur le réseau Fing vous acceptez <a href=\"" . $url . "p/charte-sociale\" target=\"_blank\">la Charte d'utilisation</a> et <a href=\"" . $url . "/p/mentions-legales\" target=\"_blank\">les mentions légales</a>",
	'esope:register:joingroups:help' => "",
	'theme_fing:register:antispam' => "[&nbsp;Question anti-spam&nbsp;]",
	
	
);

add_translation("fr",$french);


