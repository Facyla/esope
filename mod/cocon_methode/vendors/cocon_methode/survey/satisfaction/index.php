<?php
// Note : Load Elgg engine for each page where we need to access logged user, etc.
require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");
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
require_once(dirname(dirname(dirname(__FILE__))) . "/php/inc/config.inc.php");


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
	<meta http-equiv="pragma" content="no-cache" />
    <meta name="expires" content="tue, 01 Jun 2010 19:45:00 GMT" />
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
	<script type="text/javascript" src="js/utils/querystring.js"></script>
	<script type="text/javascript" src="js/utils/ajax_delegate.js"></script>
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
				<table class="app_table" style="background-color:#ffffff;width:100%">
					<tr>
						<td colspan="3" class="app_content" id="app_content"></td>
					</tr>
					<tr>
						<td colspan="3">
							<table width="100%">
								<tr>
									<td class="app_menu" width="33%" id="btnPrev" onclick="javascript:prevPage();">Précédent</td>
									<td class="app_menu" width="33%" id="btnSave" onclick="javascript:saveQuest();">Enregistrer</td>
									<td class="app_menu" width="33%" id="btnNext" onclick="javascript:nextPage();">Suivant</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div id="app_loader">
					<div></div>
				</div>
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
