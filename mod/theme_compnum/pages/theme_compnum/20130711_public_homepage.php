<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

$site = elgg_get_site_entity();
$title = $site->name;

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="adf-lostpassword" style="display:none;">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';

// Formulaire d'inscription
if (elgg_get_config('allow_registration')) {
  $register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
}


$content = '<div id="adf-homepage" class="interne">';

/*
texte d'accueil (idem celui en mode intranet)
liste des groupes publics (icône + titre) - aléatoire parmi les groupes en Une
fil d'activité global

bloc agenda
bloc de connexion
bloc d'inscription
*/

$content .= '<div style="width:600px; float:left;">';
  
  
  // @TODO : remplacer les groupes par un slider, et réduire la largeur du bloc de connexion, et déplacer le bloc texte configurable sous les 2 colonnes
  
  // Slider : 46px de plus que la largeur définie pour la partie utile
  $content .= elgg_view('slider/slider', array());
  
$content .= '</div>';

$content .= '<div style="width:350px; float:right;">';
  $content .= '<div style="border:1px solid #CCCCCC; padding:10px 20px; background:#F6F6F6;">';
  $content .= '<h2>Connexion</h2>';
  // Connexion + mot de passe perdu
  $content .= elgg_view_form('login');
  $content .= $lostpassword_form;
  $content .= '<div class="clearfloat"></div>';
  $content .= '</div>';
  // Création nouveau compte
  if (elgg_get_config('allow_registration')) { $content .= $register_form; }
  $content .= '</div>';
  $content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';


$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
if (!empty($intro)) $content .= '<div id="home_intro">' . $intro . '</div><div class="clearfloat"></div>';



// Pageguide : visite guidée - chargement bibliothèque et activation
/*
if (elgg_is_active_plugin('pageguide')) {
	elgg_load_js('pageguide');
	$content .= '<script type="text/javascript">$(document).ready(function() { tl.pg.init(); })</script>';
	$pageguide = '<ul id="tlyPageGuide" data-tourtitle="Visite guidée de la plateforme Compétences Numériques">
      <li class="tlypageguide_left" data-tourtarget="header h1">
        <div>
          Le bandeau supérieur et le titre du site : toujours présent, le titre vous permet de revenir sur votre page d\'accueil.<br />
          Après identification sur la plateforme, vous trouverez juste au-dessus les liens vers votre profil, vos messages, vos contacts, les paramètres de votre compte, et un lien pour vous déconnecter.
        </div>
      </li>
      <li class="tlypageguide_right" data-tourtarget="#adf-homepage">
        <div>
          Le contenu de la page proprement dit.<br />
          Vous êtes actuellement sur la page d\'accueil du site : celle-ci comporte différentes zones d\'information que nous allons regarder plus en détail.
        </div>
      </li>
      <li class="tlypageguide_left" data-tourtarget=".anythingSlider">
        <div>
          Ce bloc dynamique affiche successivement différentes informations qui présentent la plateforme.<br />
          Vous pouvez utiliser les flèches pour naviguer parmi les diapositives présentées, ou la liste de points pour accéder directement à une diapositive précise.<br />
          Le défilement s\'arrête quand vous placez votre curseur par-dessus.
        </div>
      </li>
      <li class="tlypageguide_left" data-tourtarget=".elgg-form-login">
        <div>
          Le formulaire de connexion vous permet de vous identifier sur le site.<br />
          Si vous avez perdu votre mot de passe, vous pouvez également en demander un nouveau en cliquant sur le lien "Mot de passe perdu ?".
        </div>
      </li>
      <li class="tlypageguide_bottom" data-tourtarget="#home_intro">
        <div>
          Ce bloc affiche d\'autres informations et des liens utiles, qui vous permettent d\'accéder aux principales pages et outils publics du site.<br />
        </div>
      </li>
      <li class="tlypageguide_left" data-tourtarget=".tlypageguide_toggle">
        <div>
        	Merci d\'avoir suivi ce petit tour !<br />
        	Le guide que vous venez de suivre est accessible à tout moment ! Pour recommencer la visite, cliquez sur ce lien.
        </div>
      </li>
    </ul>
    <div id="tlyPageGuideWelcome">
        <p style="color:white;">Bienvenue sur la plateforme des Coméptences Numériques ! Ce guide interactif est là pour vous aider à découvrir la plateforme.</p>
        <p><button class="tlypageguide_start">Commencer la visite !</button></p>
        <button class="tlypageguide_ignore">Pas maintenant</button><br /><br />
        <button class="tlypageguide_dismiss">Je connais, merci</button>
    </div>';
	$content .= $pageguide;
}
*/


//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

