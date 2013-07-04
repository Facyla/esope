<?php
/**
 * Elgg upload_users plugin language file
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @copyright Mediamaisteri Group 2008-2009
 * @link http://www.mediamaisteri.com/
 */

$fr = array(
	
	'admin:users:upload' => "Upload Users",
	'upload_users:upload_users' => "Upload Users",
	'upload_users:choose_file' => "Choisir un fichier",
	'upload_users:encoding' => "Choisir l'encodage",
	'upload_users:delimiter' => "Choisir le délimiteur",
	'upload_users:send_email' => "Envoyer un email aux nouveaux membres",
	'upload_users:yes' => "Oui",
	'upload_users:no' => "Non",

	'upload_users:create_users' => "Créer des comptes utilisateurs",
	'upload_users:success' => "Le compte utilisateur a bien été créé",
	'upload_users:statusok' => "Ce compte peut être créé",
	'upload_users:creation_report' => "Comptes utilisateurs créés",
	'upload_users:process_report' => "Prévisualisation des comptes à créer",
	'upload_users:no_created_users' => "Aucun compte utilisateur créé.",
	'upload_users:number_of_accounts' => "Nommbre total de comptes",
	'upload_users:number_of_errors' => "Nombre total d'erreurs",

	'upload_users:submit' => "Envoyer",

	'upload_users:upload_help' => "<p>Choisissez un fichier CSV et envoyez-le pour créer de nouveaux comptes utilisateurs. </p><p>La première ligne de ce fichier doit correspondre aux informations sur le contenu des colonnes. Les champs obligatoires sont : username, name, email (les intitulés doivent être ceux des noms internes de ces données dans Elgg - en anglais). Si le champ 'password' n'est pas défini, un mot de passe aléatoire sera généré. Si vous le souhaitez, vous pouvez envoyer automatiquement les informations de leur compte à chacun des nouveaux utilisateurs (conseillé). </p><p>Vous pouvez ajouter autant de champs supplémentaires que vous le souhaitez. Tous ces autres champs seront ajoutés aux informations du profil des membres. Si le délimiteur de votre fichier CSV est autre chose qu'une virgule ',' (conseillé), vous pouvez utiliser une virgule pour séparer les éléments d'une liste de tags</p><p>Voici un exemple de fichier CSV (attention, dans cet exemple la création du 1er compte ne fonctionnera pas car le mot de passe demandé est trop court ! minimum 6 caractères habituellement) :</p>",

	/*
	 * Error messages
	 * 
	 */

	'upload_users:error:file_open_error' => "Erreur lors de l'ouverture du fichier",
	'upload_users:error:wrong_csv_format' => "Fichier CSV mal formatté",


	/*
	 * emails
	 * 
	 */

	'upload_users:email:message' => "Bonjour %s!

	Un compte utilisateur a été créé pour vous sur le site %s. Utilisez votre identifiant de connexion (ou votre email) et votre mot de passe pour vous identifier sur le site.

	Identifiant de connexion : %s
	Mot de passe : %s

	Veuillez vous rendre sur %s pour vous identifier.

	",
	'upload_users:email:subject' => "Votre compte utilsiateur pour %s",


	/* MISC */

	'upload_users:mapping:custom' => "personnalisé ...",
	
);

add_translation("fr",$fr);

