<?php
/**
 * Elgg dossierdepreuve new/edit action
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

global $CONFIG;

gatekeeper();
action_gatekeeper();
if (!elgg_is_logged_in()) forward(REFERRER);

$dossierdepreuve_guid = get_input("dossierdepreuve_guid", false);
if ($dossierdepreuve_guid) {
	// Eject si objet non valide
	if (!($dossierdepreuve = get_entity($dossierdepreuve_guid))) { register_error('Dossier non valide.'); forward(REFERRER); }
	// Si le dossier est valide, eject si on n'a pas les droits suffisants pour éditer
	if (!$dossierdepreuve->canEdit()) { register_error(elgg_echo('dossierdepreuve:error:cantedit')); forward(REFERRER); }
} else {
	$action = "create";
}

// Get variables
// Le propriétaire du dossier est celui connecté, sauf si on a explicitement défini un autre owner (ex. si on le crée pour un autre)
$owner_guid = get_input('owner_guid', elgg_get_logged_in_user_guid());
$container_guid = get_input('container_guid', $owner_guid); // L'apprenant

// Nouveau dossier : si cet user a déjà un dossier => eject !
if ($action == 'create') {
	$existing_dossier = dossierdepreuve_get_user_dossier($owner_guid);
	if ($existing_dossier) {
		register_error("Cette personne a déjà un dossier de suivi : vous ne pouvez pas lui en créer un autre ! Merci de modifier ou de transférer le dossier existant.");
		forward(REFERRER);
	}
	// @TODO : si nouveau dossier mais qu'on n'a pas les droits pour éditer => eject
}


// Useful vars
// Membres du site par défaut (mais on va masquer des infos selon les profils à l'affichage)
$access_id = (int) get_input("access_id", 1);

$title = get_input('title', false);
$description = get_input('description', false);
$typedossier = get_input('typedossier', 'b2iadultes');
$status = get_input('status', 'open');


// Forward if missing data
if (($action != 'create') && !elgg_instanceof($dossierdepreuve, 'object', 'dossierdepreuve')) {
	register_error('Dossier de preuve non valide.');
	forward(REFERRER);
}



// On récupère l'objet courant ou on crée un nouvel objet dossierdepreuve s'il n'existe pas
if ($action == "create") {
	$dossierdepreuve = new ElggObject;
	$dossierdepreuve->subtype = 'dossierdepreuve';
	$dossierdepreuve->owner_guid = $owner_guid;
	$dossierdepreuve->container_guid = $owner_guid;
	$dossierdepreuve->access_id = $access_id;
	$dossierdepreuve->typedossier = $typedossier;
}

// Override access rights
$ia = elgg_set_ignore_access(true);

if ($dossier_owner = get_entity($owner_guid)) {} else {
	register_error("Membre non valide - test : $owner_guid / $container_guid");
	forward(REFERRER);
}

if ($dossier_owner = get_entity($dossierdepreuve->owner_guid)) {} else {
	register_error("Membre non valide.");
	forward(REFERRER);
}
if ($dossier_group = get_entity($dossier_owner->learner_group_b2i)) {} else {
	register_error("Groupe de l'apprenant non valide.");
	//forward(REFERRER); // Génant mais pas bloquant (surtout si on est admin)
	$dossier_group = false;
}


// @TODO : récupérer le type de profil du membre qui édite
$profile_type = dossierdepreuve_get_user_profile_type();
// Selon le profil, on peut modifier ou on est carrément éjecté.
// Pour les nouveaux dossiers, tout le monde peut les créer (ou seulement les apprenants ?)
if ($action != 'create') {
	switch ($profile_type) {
		case 'learner':
			// Seul l'auteur peut modifier son dossier
			if ($dossierdepreuve->owner_guid != elgg_get_logged_in_user_guid()) {
				register_error("Désolé, vous ne pouvez pas modifier le dossier d'un autre apprenant.");
				forward(REFERRER);
			}
			break;
		case 'tutor':
			// Le formateur peut modifier le dossier ssi l'apprenant est dans l'un de ses groupes
			if (!$dossier_group || !$dossier_group->isMember(elgg_get_logged_in_user_entity())) {
				register_error("Désolé, vous ne pouvez pas modifier le dossier d'un apprenant dont vous n'êtes pas le formateur/tuteur. Pour cela, cet apprenant doit être membre de l'un de vos groupes de formation.");
				forward(REFERRER);
			}
			break;
		case 'evaluator':
			// L'évaluateur peut modifier le dossier ssi l'apprenant est dans l'un de ses groupes ?
			if (!$dossier_group->isMember(elgg_get_logged_in_user_entity())) {
				register_error("Désolé, vous ne pouvez pas modifier le dossier d'un apprenant dont vous n'êtes pas le formateur/tuteur. Pour cela, cet apprenant doit être membre de l'un de vos groupes de formation.");
				forward(REFERRER);
			}
			break;
		case 'other_administrative':
		default:
			// Les autres sont rejetés
			if (!elgg_is_admin_logged_in()) {
				register_error("Désolé, vous ne pouvez pas modifier le dossier de cet apprenant.");
				forward(REFERRER);
			}
	}
}

/* Structure des données : on a besoin depouvoir les requêter, les filtrer et y accéder rapidement
	=> nommage structuré : par référentiel, par domaine, par compétence, par type de donnée et (selon les données) par type de profil
	$typedossier_$domaine_$competence_$typededonnee_$profiletype => b2iadultes_tutor_1_1_value
	- $typedossier : b2iadultes (b2i, passnumrra)
	- $domaine : de 1 à 5
	- $competence : de 1 à 3 ou 4
	- $typededonnee : value, comment, proof
	- $profiletype (pour value et comment) : learner, tutor, evaluator
*/

$referentiel_b2iadultes = array(
		'1' => array('1', '2', '3', '4'), 
		'2' => array('1', '2', '3', '4'), 
		'3' => array('1', '2', '3'), 
		'4' => array('1', '2', '3', '4'), 
		'5' => array('1', '2', '3'), 
	);
//$valuetypes = array('value', 'comment', 'proof');
$valuetypes = array('value', 'proof');
$profiletypes = array('learner', 'tutor', 'evaluator');

elgg_make_sticky_form('dossierdepreuve');


if (empty($title)) $title = "Dossier de " . $dossier_owner->name;
$dossierdepreuve->title = $title;
$dossierdepreuve->description = $description;
$dossierdepreuve->status = $status;

// Edition des champs : chaque champ est unique (= requêtage facile)
// Les champs peuvent être différenciés par profil, mais on peut aussi avoir des synthèses par domaine si besoin.. 
// ceci dit, sauf pour des stats, mieux vaut ne stocker que les données brutes, 
// et réserver le traitement pour l'affichage et sur demande
foreach ($referentiel_b2iadultes as $domaine => $competences) {
	foreach ($competences as $competence) {
		$meta_basename = $typedossier . '_' . $domaine . '_' . $competence . '_';
		foreach ($valuetypes as $valuetype) {
			// @TODO : seuls certaines profils peuvent éditer certains champs : à affiner
			$meta_name = $meta_basename . $valuetype;
			if (in_array($valuetype, array('value'))) {
				foreach ($profiletypes as $profiletype) {
					// On ne peut éditer les champs que si on a le bon profil = identique au champ à modifier
					// excepté pour les évaluateurs qui peuvent aussi éditer les informations en tant que tuteur
					// et les admins qui peuvent tout modifier
					if (($profiletype == $profile_type) || (($profile_type == 'evaluator') && ($profiletype == 'tutor')) || elgg_is_admin_logged_in()) {
						$metaname = $meta_name . '_' . $profiletype;
						$value = get_input($metaname, false);
						// On doit faire un test !== false pour faire la différence entre (vide) et 0
						if ($value !== false) $dossierdepreuve->{$metaname} = $value;
					}
				}
			} else {
				// Seul l'apprenant ou un admin peut modifier les élements de preuve
				if (($profile_type == 'learner') || elgg_is_admin_logged_in()) {
					$value = get_input($meta_name, false);
					if ($value) $dossierdepreuve->{$meta_name} = $value;
				}
			}
		}
	}
}

// Save entity
if ($dossierdepreuve->save()) {
	system_message(elgg_echo("dossierdepreuve:saved"));
  if ($action == "create") {
    add_to_river('river/object/dossierdepreuve/create','create',$_SESSION['user']->guid,$dossierdepreuve->guid);
  } else {
    add_to_river('river/object/dossierdepreuve/update','update',$_SESSION['user']->guid,$dossierdepreuve->guid);
  }
} else { register_error(elgg_echo("dossierdepreuve:savefailed")); }

elgg_set_ignore_access($ia);


forward($dossierdepreuve->getURL());

