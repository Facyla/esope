<?php
/**
 * Upload users language strings
 * French
 *
 * @package upload_users
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Jaakko Naakka / Mediamaisteri Group
 * @author Ismayil Khayredinov / Arck Interactive
 * @translation Florian DANIEL aka Facyla 2015-2016
 * @copyright Mediamaisteri Group 2009
 * @copyright ArckInteractive 2013
 * @link http://www.mediamaisteri.com/
 * @link http://arckinteractive.com/
 */
return array(
	/**
	 * Admin Interface
	 */
	'admin:users:upload' => 'Import membres CSV',

	'upload_users:error:cannot_open_file' => "Le fichier que vous avez envoyé ne semble pas être un fichier CSV valide, ou les paramètres que vous avez définis ne sont pas corrects",
	
	'upload_users:incomplete' => 'Imports incomplets',
	'upload_users:upload' => 'Charger un nouveau fichier',
	'upload_users:instructions' => "Mode d'emploi",
	'upload_users:mapping' => 'Correspondance des entêtes  CSV avec les champs de profil',
	'upload_users:attributes' => 'Générer automatiquement les attributs obligatoires',
	'upload_users:report' => 'Import terminé',

	'upload_users:continue' => 'Suivant',
	'upload_users:back' => 'Retour',
	'upload_users:delete' => 'Supprimer le fichier',

	'upload_users:choose_file' => 'Choisir un fichier',

	'upload_users:encoding' => 'Encodage du fichier CSV',

	'upload_users:delimiter' => 'Délimiteur de champs',
	'upload_users:delimiter:comma' => 'virgule (&#44;)',
	'upload_users:delimiter:semicolon' => 'point-virguke (&#59;)',
	'upload_users:delimiter:colon' => 'barre verticale (&#58;)',

	'upload_users:enclosure' => "Délimiteur de texte",
	'upload_users:enclosure:doublequote' => 'guillemet double (&#34;)',
	'upload_users:enclosure:singlequote' => 'guillemet simple (&#39;)',

	'upload_users:mapping_template' => "Sélectionner un modèle de correspondance existant",
	'upload_users:new_template' => 'Nouveau modèle',

	'upload_users:save_as_template' => "Entrer un nom pour sauvegarder le modèle de correspondance de l'entête",
	'upload_users:yes' => 'Oui',
	'upload_users:no' => 'Non',

	'upload_users:setting:notification' => 'Envoyer un email aux nouveaux membres lorsque leur compte est créé',
	'upload_users:setting:update_existing_users' => 'Mettre à jour les informations du profil si le compte existe déjà',
	'upload_users:setting:fix_usernames' => "Corriger les identifiants si la valeur ne correspond pas aux standards d'Elgg (par ex. s'il contient des caractères spéciaux), et ajouter un numéro en suffixe si cet identifiant est déjà pris",
	'upload_users:setting:fix_passwords' => "Générer de nouveaux mots de passe si la valeur ne correspond pas aux standards d'Elgg (par ex. s'il est trop court)",
	'upload_users:notification:custom' => "Message à insérer dans les emails de notification",
	'upload_users:notification:preview' => "Prévisualisation des messages envoyés",

	'upload_users:create_users' => 'Créer les comptes des membres',
	'upload_users:success' => 'Compte créé',
	'upload_users:statusok' => 'Le compte peut être créé',
	'upload_users:creation_report' => 'Comptes créés',
	'upload_users:process_report' => 'Prévisualisation des comptes créés',
	'upload_users:no_created_users' => 'Aucun compte créé.',
	'upload_users:number_of_accounts' => 'Nombre total de comptes',
	'upload_users:number_of_errors' => "Nombre d'erreurs",
	'upload_users:submit' => 'Envoyer',
	'upload_users:upload_help' => "
		<p>Il est préféable d'inclure les colonnes suivantes dans votre fichier CSV :
		<dl>
			<dt><b>email</b></dt>
			<dd>- ce champ est <b>obligatoire</b></dd>
			<dt><b>username</b></dt>
			<dd>identifiant - ce champ est optionnel, mais vivement conseillé</dd>
			<dd>- s'il n'est pas présent, il vous sera demandé de sélectionner une série de champs dans votre fichier afin de pouvoir le générer automatiquement (par ex. à partir de l'email)</dd>
			<dt><b>name</b></dt>
			<dd>nom sur le site - ce champ est optionnel, mais fortement conseillé</dd>
			<dd>- s'il n'est pas présent, il vous sera demandé de sélectionner une série de champs dans votre fichier afin de pouvoir le générer automatiquement (par ex. en ajoutant le nom et le prénom)</dd>
			<dt><b>password</b></dt>
			<dd>mot de passe - ce champ est optionnel</dd>
			<dd>- s'il n'est pas présent, un mot de passe sera généré automatiquement</dd>
		</dl>
		</p>

		<p>Pour de meilleurs résultats lors de l'import (ce n'est pas nécessaire, mais suggéré) utilisez la configuraiton suivante lors de la création de votre fichier CSV :
		<dl>
			<dt>Délimiteur</dt>
			<dd>- virgule (&#44;)</dd>
			<dt>Séparateur de texte</dt>
			<dd>- guillemet double (&#34;)</dd>
			<dt>Encodage des caractères</dt>
			<dd>- UTF-8</dd>
			<dt>Entêtes</dt>
			<dd>- la première ligne de votre fichier CSV devrait correspondre aux entêtes (que vous pouvez faire correspondre à des champs de profil ou à des métadonnées personnalisées à l'étape suivante)</dd>
			<dd>- utilisez des lettres en minuscule</dd>
			<dd>- pas d'espace ni de caractère spécial</dd>
		</dl>
		</p>
		

		<p>Voici quelques exemples de fichiers CSV :</p>",
	/**
	 * Error Messages
	 */
	'upload_users:error:file_open_error' => "Erreur lors de l'ouverture du fichier",
	'upload_users:error:wrong_csv_format' => "Mauvais format du fichier CSV",
	/**
	 * Email Notifications
	 */
	'upload_users:email:message' => "Bonjour %s !

	Un compte utilisateur a été créé pour vous sur %s. Utilisez votre identifiant de connexion (ou votre email) et votre mot de passe pour vous identifier sur le site.

	Identifiant de connexion : %s
	Mot de passe : %s

	Veuillez vous rendre sur %s pour vous identifier.

		%s
	",
	'upload_users:email:subject' => "Votre compte sur %s",
	/**
	 * Miscellaneous
	 */
	'upload_users:random_cleartext_passowrd' => 'Mot de passe aléatoire',
	'upload_users:mapping:instructions' => "Précisez la correspondance entre chaque entête du fichier CSV et les métadonnées et/ou les champs du profil du compte ; les listes déroulantes contiennent une liste des attributs et métadonnée du compte, ainsi que les champs de profils. Vous pouvez également sélectionner un nom de métadonnée personnalisé.",
	'upload_users:mapping:instructions_required' => "Les attributs listés ci-dessous sont nécessaires pour créer des comptes et aucune correspondance avec un entête du fichier CSV n'a été définie. Veuillez préciser quels entêtes du fichier CSV doivent être utilisés pour ces champs (par ex. l'email) ou les éléments qui seront utilisés pour générer automatiquement ces champs (par ex. identifiant et nom)",
	'upload_users:mapping:csv_header' => 'Entête CSV',
	'upload_users:mapping:elgg_header' => 'Champ de profil ou nom de métadonnée correspondant',
	'upload_users:mapping:access_id' => "Niveau d'accès",
	'upload_users:mapping:value_type' => 'Type de valeur',
	'upload_users:mapping:value_type:text' => 'Conserver comme texte',
	'upload_users:mapping:value_type:tags' => 'Convertir en tags',
	'upload_users:mapping:value_type:timestamp' => 'Convertir en timestamp',

	'upload_users:mapping:attribute' => 'Attribut',
	'upload_users:mapping:components' => 'Eléments',
	'upload_users:mapping:select' => 'sélection ...',
	'upload_users:mapping:custom' => 'personnalisé ...',
	'upload_users:mapping:guid' => 'GUID (seulement pour les mises à jour)',
	'upload_users:mapping:username' => 'identifiant',
	'upload_users:mapping:name' => 'nom',
	'upload_users:mapping:email' => 'email',
	'upload_users:mapping:password' => 'mot de passe',
	'upload_users:mapping:user_upload_role' => 'nom du rôle',

	'upload_users:download_sample_help' => "Télécharger un exemple de fichier CSV avec les entêtes correspondant à l'ensemble des métadonnées actuellement présentes sur le site",
	'upload_users:download_sample' => 'Télécharger',

	'upload_users:status:mapping_pending' => '[Correspondance des champs en attente]',
	'upload_users:status:ready_for_import' => '[Prêt à importer]',
	'upload_users:status:imported' => '[Importé]',

	'upload_users:continue:map' => 'Définir la correspondance des entêtes',
	'upload_users:continue:import' => 'Importer',
	'upload_users:continue:import:warning' => "Les fichiers CSV de grande taille peuvent prendre plus de temps à importer. Veuillez ne pas rafraîchir après avoir validé l'import.",
	'upload_users:continue:view_report' => 'Afficher le rapport',
	'upload_users:continue:download_report' => 'Télécharger le rapport',

	'upload_users:error:userexists' => 'Un compte existe déjà avec cet identifiant ou cet email',
	'upload_users:error:empty_name' => "Le nom ne peut pas être vide",
	'upload_users:error:invalid_guid' => "Aucun compte n'est associé à ce GUID",
	'upload_users:error:update_email_username_mismatch' => "Impossible de mettre à jour le compte à cause d'une non-correspondance entre identifiant et email",
	
);
