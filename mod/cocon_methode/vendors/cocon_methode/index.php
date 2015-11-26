<?php
// Note : Load Elgg engine for each page where we need to access logged user, etc.
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php");
global $CONFIG;


/*
$own = elgg_get_logged_in_user_entity();
$user_group = elgg_get_entities(array('type' => 'group', 'limit' => 0));
foreach($user_group as $ent) {
	if ($ent->name == $own->cocon_etablissement) {
		error_log("Group {$ent->guid} {$ent->name} deleted");
		$ent->delete();
	}
}
exit;
*/


// Refuse non logged in users.
gatekeeper();
// Verrouillage des accès à l'application : groupe valide doit exister
$own = elgg_get_logged_in_user_entity();
$user_role = cocon_methode_get_user_role();
// Ensure group exists and user is member, or create it if conditions are valid
$gid = cocon_methode_get_user_group();

// If we do not have a valid group, exit
$group = get_entity($gid);
if (!elgg_instanceof($group, 'group')) {
	//error_log("COCON : $gid INVALIDE");
	$msg = elgg_echo('cocon_methode:error:requiredetab');
	register_error($msg);
	$msg = elgg_echo('cocon_methode:editprofile');
	register_error($msg);
	forward("profile/{$own->username}/edit");
}

//error_log("COCON : {$own->name}, role $user_role, membre du groupe $gid {$group->name}");

// Load Cocon Kit Méthode config
require_once(dirname(__FILE__) . "/php/inc/config.inc.php");


$vars = array();

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$header = elgg_view('adf_platform/adf_header', $vars);
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

// Note : here we add some info from user
if (!elgg_is_logged_in()) {
	register_error("Pour utiliser cette application, vous devez d'abord vous connecter à Cocon");
	forward();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo elgg_view('page/elements/head', $vars); ?>


	<!-- START Add Cocon SGMAP headers here //-->
	<!--
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="IE=Edge" http-equiv="X-UA-Compatible">
	<title>Coll&egrave;ges connect&eacute;s</title>
	<link rel="stylesheet" media="all" href="css/global.css" />
	<link rel="stylesheet" media="all" href="css/font-awesome.min.css" />
	<script type="text/javascript" src="js/jquery/jquery-1.7.2.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />
	<link rel="shortcut icon" type="image/png" href="css/images/favicon.png" />
	//-->
	<meta http-equiv="pragma" content="no-cache" />
	<meta name="expires" content="tue, 01 Jun 2010 19:45:00 GMT" />
	<link rel="stylesheet" media="all" href="css/styles_app.css" />
	<script type="text/javascript" type="text/javascript" src="js/utils/utils.js"></script>
	<script type="text/javascript" src="js/utils/ajax_delegate.js"></script>
	<script type="text/javascript" src="js/config.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<!-- STOP Add Cocon SGMAP headers here //-->
</head>

<body class="<?php echo $loggedin_class; ?>">
<div class="elgg-page elgg-page-default">
	<div class="elgg-page-messages">
		<?php echo $messages; ?>
	</div>
	<!-- Theme Content -->
<?php /*
	<div id="page_container"> 
		<div id="wrapper_header">
*/ ?>
		<?php echo $header; ?>
		<section>
			<div class="interne interne-content">
				<!-- START Add Cocon SGMAP Content here //-->
				<table class="app_table" id="app_table" style="width:100%">
					<!--
						Etats des lieux / Echanges d'idées et usages / Mise en pratique
					-->
					<tr>
						<td class="app_menu" width="10%" style="background:none;vertical-align:top;border-right:1px solid;" rowspan="2">
													<!--
								Panneau de gauche (Présentation // Feuille de route // Bilan)
							-->
							<div id="menus_panel" class="menus_panel">
								<table style="width:100%;text-align:center;">
									<tr>
										<td class="app_menu" style="width:100%;color:white;font-size:13px;height:38px;background-color:#444444">
											Pilotage
										</td>
									</tr>
									<tr>
										<td class="app_menu selected" style="width:90%;font-size:11px;height: 50px;" id="temps_0" onclick="javascript:loadPage('presentation', 'temps_0');">
											<img src="css/images/menu_icon_home.png" width="20" height="20" />&nbsp;<p>Présentation</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px" id="temps_4" onclick="javascript:loadPage('feuille_route', 'temps_4');">
											<img src="css/images/menu_icon_orientation_pilotage.png" width="20" height="20"/>&nbsp;<p>Feuille de route</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px" id="faq" onclick="javascript:loadPage('faq','faq');">
											<img src="css/images/faq.png" width="20" height="20" />&nbsp;<p>Foire aux questions</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px" id="bilan" onclick="javascript:loadPage('bilan', 'bilan');">
											<img src="css/images/menu_icon_bilan.png" width="20" height="20" />&nbsp;<p>Bilan</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:100%;color:white;font-size:13px;height:38px;background-color:#444444">
											Téléchargement
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px; height:50px;" onclick="javascript:loadPage('outils', 'outils');">
											<img src="css/images/save_all.png" width="20" height="20" />&nbsp;<p>Ensemble d'outils</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px" onclick="javascript:loadPage('resultats', 'resultats');">
											<img src="css/images/stats.png" width="20" height="20" />&nbsp;<p>Résultats</p>
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:100%;color:white;font-size:13px;height:38px;background-color:#444444">
											Outils
										</td>
									</tr>
									<tr>
										<td class="app_menu" style="width:90%;font-size:11px;height:50px;" onclick="javascript:loadPage('nouv_cycle', 'nouv_cycle');">
											<img src="css/images/reset.png" width="20" height="20" />&nbsp;<p>Nouveau cycle</p>
										</td>
									</tr>
								</table>
							<div>
						</td>
						<td class="app_menu" width="30%" id="temps_1" onclick="javascript:loadPage('etats_des_lieux', 'temps_1');">
							<img src="css/images/menu_icon_etat_des_lieux.png" />&nbsp;<p>Temps 1 - Etat des lieux</p>
						</td>
						<td class="app_menu" width="30%" id="temps_2" onclick="javascript:loadPage('echanges_usages', 'temps_2');">
							<img src="css/images/menu_icon_echange_usages.png" />&nbsp;<p>Temps 2 - Echanges d'idées et usages</p>
						</td>
						<td class="app_menu" width="30%" id="temps_3" onclick="javascript:loadPage('mise_en_pratique', 'temps_3');">
							<img src="css/images/menu_icon_mise_en_pratique.png" />&nbsp;<p>Temps 3 - Mise en pratique</p>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="app_content" id="app_content"></td>
					</tr>
				</table>
				<div id="black_mask" onclick="javascript:closeFloatWin();"></div>
				<div id="float_win" class="center"></div>
				<!-- STOP Add Cocon SGMAP Content here //-->

				<div class="clearfloat"></div>
			</div>
		</section>
		<?php echo $footer; ?>
		<?php /*
		</div><!-- wrapper_header //-->
	</div><!-- page_container //-->
*/ ?>
	<!-- Theme Content -->
</div>
	<!-- END -->
	<!-- JS deferred scripts -->
	<?php echo elgg_view('page/elements/foot'); ?>
</body>
</html>
