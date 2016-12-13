<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

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
	
	$content .= '<div id="adf-homepage" class="interne">';
	$content .= '<div id="adf-loginbox">';
	$content .= elgg_view_form('user/passwordreset', array('class' => 'elgg-form-account'), $params);
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	$content .= '</div>';
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
		$content .= '<div id="adf-homepage" class="interne">';
	
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
	
	<div class="elgg-page elgg-page-default">
	
		<div class="elgg-page-messages">
			<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
		</div>
	
		<?php echo elgg_view('adf_platform/adf_header', $vars); ?>
		<div class="clearfloat"></div>
	
		<?php echo $content; ?>
	
		<?php echo elgg_view('page/elements/footer'); ?>
	
		<?php //echo elgg_view('page/elements/foot', $vars); ?>
	</div>
	
</body>
</html>

