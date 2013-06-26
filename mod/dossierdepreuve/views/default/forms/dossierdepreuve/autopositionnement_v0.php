<?php
/**
 * Elgg dossierdepreuve browser edit
 * 
 * @package Elggdossierdepreuve
 * @author Facyla
 * @copyright Items International 2010-2012
 * @link http://items.fr/
 */

global $CONFIG;

/* Fonctionnement du test d'auto-positionnement :
 * Ce test peut être passé publiquement (sans compte) 
 * ou en tant que membre pour s'auto-évaluer, et mettre à jour l'avancement de son auto-évaluation dans son dossier de preuve.
 * Il n'utilise PAS les données d'un dossier de preuve existant, 
 * mais permet de l'initialiser, et *éventuellement* de le mettre à jour.
 * Choix de mettre à jour le "vrai" dossier arrive après obtention des résultats (et comparaison éventuelle).
 */

if (!elgg_is_logged_in()) {
	$public_mode = true;
	elgg_set_page_owner_guid(0);
} else {
	$page_owner = elgg_get_page_owner_entity(); // Get the page owner
	if ($page_owner === false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		elgg_set_page_owner_guid($_SESSION['guid']);
	}
	// Selon les types de profil
	if (elgg_is_admin_logged_in()) {
		$profile_type = 'admin';
	} else {
		$profile_type = dossierdepreuve_get_rights('edit', elgg_get_logged_in_user_entity());
	}
}
$content = '';


// Initialisation data : vars
$pagetitle = elgg_echo("dossierdepreuve:auto:new");
$action = "dossierdepreuve/autopositionnement_new";
$owner_guid = elgg_get_logged_in_user_guid();
$container_guid = $owner_guid;
$typedossier = 'b2iadultes';

$owner = get_entity($owner_guid);

// Liste de valeur des sélecteurs

$competence_values =  array(
	  "" => elgg_echo ('dossierdepreuve:choose'),
	  "A" => elgg_echo ('dossierdepreuve:acquis'),
	  "NA" => elgg_echo ('dossierdepreuve:nonacquis'),
	  "EC" => elgg_echo ('dossierdepreuve:encoursacquisition'),
  );
$typedossier_values = array(
	  "" => elgg_echo ('dossierdepreuve:choose'),
		'b2iadultes' => "B2i Adultes",
		/*
		'b2i' => "B2i",
		'passnumrra' => "Pass'Numérique",
		*/
	);
?>


<div class="contentWrapper">
	<?php
	// Le formulaire proprement dit
	echo '<form action="' . $vars['url'] . 'action/' . $action . '" enctype="multipart/form-data" method="post">';

	echo elgg_view('input/securitytoken');
	?>

	<p>Principe de fonctionnement :<br />
	On répond aux questions au fur et à mesure.<br />
	Interface à définir : les questions suivantes apparaissent dès qu'on a répondu à une question ?<br />
	Organisation en arborescence des questions (questions générales puis on affine le "diagnostic") ?'<br />
	Selon les réponses, des conseils, activités, liens associés s'affichent => tout de suite ou à la fin ?<br />
	</p>

	<div class="clearfloat"></div>
	
	<h3>Quelques questions pour la démo...</h3>
	
	<?php
	// Quelques types de questions

	// Question fulltext
	//echo '<p><label for="dossierdepreuve_description">' . elgg_echo('dossierdepreuve:description') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:description:help') . elgg_view('input/longtext', array('name' => 'description', 'id' => 'dossierdepreuve_description', 'value' => $description)) . '</p>';

	// Question multi-sélecteur

	// Question sélecteur

	// Question radio
	$auto1_opt = array(
		"Aucune réponse" => '0', 
		"Une réponse : par ex. Je ne sais pas / je ne comprends pas la question." => '1', 
		"Une autre réponse, par ex. Oui je vois de quoi il s'agit mais je ne maîtrise pas vraiment / j'ai encore des choses à apprendre." => '2', 
		"Encore une réponse, par ex. Oui je sais faire cela correctement." => '3',
		"Une dernière réponse, par ex. Je sais parfaitement faire cela, et je pourrais expliquer à d'autres comment faire !" => '4',
		);
	echo '<p><label for="dossierdepreuve_auto1">' . elgg_echo('dossierdepreuve:auto:q1') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:auto:q1:help') . elgg_view('input/radio', array('name' => 'auto1', 'id' => 'dossierdepreuve_auto1', 'options' => $auto1_opt, 'class')) . '</p>';
	?>
	<div class="clearfloat"></div>

	<?php
	/*
	echo '<div class="clearfloat"></div>';
	echo '<div style="float:left; width:20%; margin-left:2%;">Eléments de preuve (liens)</div><div style="float:right; width:76%;">' . elgg_view('input/plaintext', array('name' =>  $meta_basename . 'proof', 'value' =>  $vars['entity']->{$meta_basename . 'proof'}, 'js' => ' style="height:6ex;"')) . '</div>';
	echo '<div class="clearfloat"></div>';
	*/
	
	// Hidden fields & submit
	echo '<div class="clearfloat"></div><br /><br />';
	echo '<hr />';
	echo '<input type="hidden" name="owner_guid" value="' . $owner_guid . '" />';
	echo '<input type="hidden" name="container_guid" value="' . $container_guid . '" />';
	echo '<p>';
		echo '<p><label for="dossierdepreuve_contact_email">' . elgg_echo('dossierdepreuve:auto:contact_email') . '</label> &nbsp; ' . elgg_echo('dossierdepreuve:auto:contact_email:help') . elgg_view('input/text', array('name' => 'contact_email', 'id' => 'dossierdepreuve_contact_email', 'value' => $contact_email)) . '</p>';
		echo elgg_view('input/submit', array('value' => elgg_echo("dossierdepreuve:save"))) . '<br /><br />';
	echo '</p>';
	?>
	</form>
</div>

