<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;
$urlimg = $CONFIG->url;
$urlimg = $url . 'mod/theme_cocon/graphics/';
$urlpictos = $urlimg . 'pictos/';

$site = elgg_get_site_entity();
$title = $site->name;
$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'adf_public_platform');

$content = '';

// Contenu de la page => $vars['body']
// @TODO : mieux gérer l'affichage si $vars['body'] est renseigné

// Display reset password form if asked to
$user_guid = get_input('u', false);
$code = get_input('c', false);
if ($user_guid && $code) {
	$user = get_entity($user_guid);
	if (!$user instanceof ElggUser) {
		register_error(elgg_echo('user:passwordreset:unknown_user'));
		forward();
	}
	$params = array('guid' => $user_guid, 'code' => $code);
	
	$content .= '<header><div class="interne">';
	$content .= '<h1><img src="' . $urlimg . 'header_ministere.jpg" /><a href="' . $url . '" title="' . elgg_echo('adf_platform:gotohomepage') . '"><img src="' . $urlimg . 'header_cocon.png" style="margin-left:14px;" /></a></h1>';
	$content .= '</div></header>';
	$content .= '<div class="elgg-page-messages">';
	$content .= elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div>';

	$content .= '<div id="adf-homepage" class="interne">';
	$content .= '<div id="adf-loginbox">';
	$content .= elgg_view_form('user/passwordreset', array('class' => 'elgg-form-account'), $params);
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	$content .= '</div>';

	$content .= elgg_view('page/elements/footer');

}




// Display default page only if no specific content has been set before
if (empty($content)) {
	
	// Formulaire de renvoi du mot de passe
	$lostpassword_form = '<div id="adf-lostpassword" style="display:none;">';
	//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
	$lostpassword_form .= elgg_view_form('user/requestnewpassword');
	$lostpassword_form .= '</div>';

	// Formulaire d'inscription
	if (elgg_get_config('allow_registration')) {
		$register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
	}

	// Statistiques du site
	$stats = '';
	$displaystats = elgg_get_plugin_setting('displaystats', 'adf_public_platform');
	if ($displaystats == "yes") {
		$stats .= '<div style="background:transparent;">';
		$stats .= '<h2>Quelques chiffres</h2>';
		//$subtypes = get_registered_entity_types();
		//access_show_hidden_entities(true); // Accès aux entités désactivés
		elgg_set_ignore_access(true); // Pas de vérification des droits d'accès
		$stats .= '<strong>' . get_number_users() . '</strong> membres inscrits<br />';
		$stats .= '<strong>' . find_active_users(600, 10, 0, true) . '</strong> membres connectés en ce moment<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'group', 'count' => true)) . '</strong> groupes de travail<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'groupforumtopic', 'count' => true)) . '</strong> sujets de discussion dans les forums<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'announcement', 'count' => true)) . '</strong> annonces dans les groupe<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'idea', 'count' => true)) . '</strong> idées / remue-méninges dans les groupe<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => array('page','page_top'), 'count' => true)) . '</strong> pages wikis : ';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'page_top', 'count' => true)) . '</strong> wikis et ';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'page', 'count' => true)) . '</strong> sous-pages<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'blog', 'count' => true)) . '</strong> articles de blog<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'bookmarks', 'count' => true)) . '</strong> liens partagés<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'file', 'count' => true)) . '</strong> fichiers<br />';
		$stats .= '<strong>' . elgg_get_entities(array('types' => 'object', 'subtypes' => 'event_calendar', 'count' => true)) . '</strong> événements<br />';
		//access_show_hidden_entities(false);
		elgg_set_ignore_access(false);
		$stats .= '</div>';
	}


	if ($replace_public_home == 'cmspages') {
		if (!elgg_is_active_plugin('cmspages')) { register_error(elgg_echo('adf_platform:cmspages:notactivated')); }
		define('cmspage', true);
		$pagetype = 'homepage-public';
		// Ajout des feuilles de style personnalisées
		//if (!empty($cmspage->css)) $content .= "\n<style>" . $cmspage->css . "</style>\n";
		// Ajout des JS personnalisés
		//if (!empty($cmspage->js)) $content .= "\n<script type=\"text/javascript\">" . $cmspage->js . "</script>\n";
	
		$content .= '<div id="' . $pagetype . '">' . elgg_view('cmspages/view', array('pagetype' => $pagetype)) . '</div>';
		
	} else {
		$content .= '<header><div class="interne">';
		$content .= '<h1><img src="' . $urlimg . 'header_ministere.jpg" /><a href="' . $url . '" title="' . elgg_echo('adf_platform:gotohomepage') . '"><img src="' . $urlimg . 'header_cocon.png" style="margin-left:14px;" /></a></h1>';
		$content .= '</div></header>';

		$content .= '<div class="elgg-page-messages">';
		$content .= elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
		$content .= '</div>';

		$content .= '<div class="clearfloat"></div>';

		$content .= '<div id="adf-homepage" class="interne">';
		
		// Slider
		$slider_params = array(
		//'sliderparams' => "theme:'cs-portfolio', buildStartStop:false, resizeContents:false, ", 
		//'slidercss_main' => "width:100%; height:400px;", 
		'width' => '100%',
		'height' => '300px', 
		);
		$slider = elgg_view('slider/slider', $slider_params);
		$content .= '<div class="elgg-context-dashboard cocon-public-slider">' . $slider . '</div>';
	
		$content .= '<div id="adf-public-col1">';
		$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
		if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
		$content .= '<div id="adf-loginbox">';
		$content .= '<h2>Connexion</h2>';
		// Connexion + mot de passe perdu
		$content .= elgg_view_form('login');
		$content .= $lostpassword_form;
		$content .= '<div class="clearfloat"></div>';
		$content .= '</div>';
		$content .= '</div>';

		$content .= '<div id="adf-public-col2">';
		// Création nouveau compte
		if (elgg_get_config('allow_registration')) { $content .= $register_form; }
		$content .= '</div>';
	
		$content .= '<div class="clearfloat"></div><br />';
		$content .= $stats;

		$content .= '</div>';

		$content .= elgg_view('page/elements/footer');
	}

}


$lang = $CONFIG->language;

// Construction de la page proprement dite
header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
	<?php echo elgg_view('page/elements/head', $vars); ?>
	<?php echo '<script type="text/javascript">' . elgg_view('js/walled_garden') . '</script>'; ?>
</head>

<body>
	
	<?php echo $content; ?>
	
	<?php //echo elgg_view('page/elements/foot', $vars); ?>
	
</body>
</html>

