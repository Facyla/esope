<?php
/**
 * French strings
 */
global $CONFIG;

$fr = array(
	'accessibility:sidebar:title' => "Outils",
	//'breadcrumb' => "Fil d'Ariane",
	'breadcrumb' => "Revenir à ",
	// Demandes en attente
	'decline' => "Décliner",
	'refuse' => "Refuser",
	/* Pagination */
	'previouspage' => "Page précédente",
	'nextpage' => "Page suivante",
	/* Recherche de membres */
	'searchbytag' => "Recherche par mot-clef",
	'searchbyname' => "Recherche par nom",
	// Actions génériques à "typer"
	'delete:message' => "Supprimer le(s) message(s)",
	'markread:message' => "Marquer le(s) message(s)  comme lu(s)",
	'toggle:messages' => "inverser la sélection des messages",
	'messages:send' => "Envoyer le message",
	'save:newgroup' => "Créer le groupe !",
	'save:group' => "Enregistrer les modifications du groupe",
	'upload:avatar' => "Charger la photo",
	'save:settings' => "Enregistrer la configuration",
	'save:usersettings' => "Enregistrer mes paramètres",
	'save:usernotifications' => "Enregistrer mes paramètres de notification pour les membres",
	'save:groupnotifications' => "Enregistrer mes paramètres de notification pour les groupes",
	'save:widgetsettings' => "Enregistrer les réglages du module",
	// Notifications
	'link:userprofile' => "Page de profil de %s",
	
	// Params widgets
	'onlineusers:numbertodisplay' => "Nombre maximum de membres connectés à afficher",
	'newusers:numbertodisplay' => "Nombre maximum de nouveaux membres à afficher",
	'brainstorm:numbertodisplay' => "Nombre maximum d'idées à afficher",
	'river:numbertodisplay' => "Nombre maximum d'activités à afficher",
	'group:widget:num_display' => "Nombre maximum de groupes à afficher",
	
	'more:friends' => "Plus de contacts", 
	
	// New group
	'groups:newgroup:disclaimer' => "<blockquote><strong>Extrait de la Charte :</strong> <em>toute personne ou groupe de personnes souhaitant créer un groupe - à la condition de <a href=\"mailto:secretariat@departementsenreseaux.fr&subject=Demande%20de%20validation%20de%20groupe&body=Contact%20%depuis%20la%20page%20http%3A%2F%2Fdepartements-en-reseaux.fr%2Fgroups%2Fadd%2F129\" title=\"Ecrire au secrétariat de la plateforme\">se déclarer comme animateur de ce groupe auprès du secrétariat de la plateforme</a>, dispose de droits d’administrateur sur les accès à ce groupe et s’engage à y faire respecter les <a href=\"' . $CONFIG->url . 'pages/view/3792/charte-de-dpartements-en-rseaux\">règles d’utilisation et de création de contenus de « Départements-en-réseaux »</a></em></blockquote>",
	
	// 
	'accessibility:allfieldsmandatory' => "<sup class=\"required\">*</sup> Tous les champs sont obligatoires",
	'accessibility:requestnewpassword' => "Demander la réinitialisation du mot de passe",
	'accessibility:revert' => "Supprimer",
//	'' => "",
	
);

add_translation('fr', $fr);

