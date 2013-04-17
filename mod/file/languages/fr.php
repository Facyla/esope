<?php
/**
 * Elgg file plugin language pack
 *
 * @package ElggFile
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'file' => "Fichiers",
	'files' => "Fichiers",
	'file:yours' => "Vos fichiers",
	'file:yours:friends' => "Les fichiers de vos contacts",
	'file:user' => "Fichiers de %s",
	'file:friends' => "Fichiers des contacts",
	'file:all' => "Tous les fichiers du site",
	'file:edit' => "Editer le fichier",
	'file:more' => "Plus de fichiers",
	'file:list' => "vue liste",
	'file:group' => "Fichiers",
	'file:gallery' => "vue galerie",
	'file:gallery_list' => "Vue 'liste' ou 'galerie'",
	'file:num_files' => "Nombre de fichiers à afficher",
	'file:user:gallery'=> "Voir la galerie de %s",
	'file:via' => "via les fichiers",
	'file:upload' => "Envoyer un fichier",
	'file:replace' => "Remplacer le contenu du fichier (laisser vide pour ne rien changer)",
	'file:list:title' => "%s %s de %s",
	'file:title:friends' => "des contacts",

	'file:add' => "Envoyer un fichier",

	'file:file' => "Fichier",
	'file:title' => "Titre",
	'file:desc' => "Description",
	'file:tags' => "Mots-clefs",

	'file:types' => "Types de fichiers téléchargés",

	'file:type:' => "Fichiers",
	'file:type:all' => "Tous les fichiers",
	'file:type:video' => "Vidéos",
	'file:type:document' => "Documents",
	'file:type:audio' => "Audio",
	'file:type:image' => "Images",
	'file:type:general' => "Autres types de fichiers",

	'file:user:type:video' => "Les documents de %s",
	'file:user:type:document' => "Les documents de %s",
	'file:user:type:audio' => "Les fichiers audio de %s",
	'file:user:type:image' => "Les images de %s",
	'file:user:type:general' => "Les autres types de fichiers de %s",

	'file:friends:type:video' => "Les vidéos de vos contacts",
	'file:friends:type:document' => "Les documents de vos contacts",
	'file:friends:type:audio' => "Les enregistrements audio de vos contacts",
	'file:friends:type:image' => "Les images de vos contacts",
	'file:friends:type:general' => "Les autres types de fichiers de vos contacts",

	'file:widget' => "Module fichiers",
	'file:widget:description' => "Liste vos fichiers personnels les plus récents",

	'groups:enablefiles' => "Activer les fichiers de groupes",

	'file:download' => "Télécharger ce fichier",

	'file:delete:confirm' => "Etes-vous sûr(e) de vouloir supprimer ce fichier ?",

	'file:tagcloud' => "Nuage de tags",

	'file:display:number' => "Nombre de fichiers à afficher",

	'file:river:create' => "fichier téléchargé",
	'river:commented:object:file' => "le fichier",
	'river:create:object:file' => '%s a publié  le fichier %s',
	'river:comment:object:file' => '%s a commenté le fichier %s',

	'item:object:file' => "Fichiers",

	/**
	 * Embed media
	 **/

		'file:embed' => "Importer un fichier media",
		'file:embedall' => "Tout",

	/**
	 * Status messages
	 */

		'file:saved' => "Votre fichier a bien été enregistré.",
		'file:deleted' => "Votre fichier a bien été supprimé.",

	/**
	 * Error messages
	 */

		'file:none' => "Aucun fichier pour le moment.",
		'file:uploadfailed' => "Désolé, votre fichier n'a pu être enregistré.",
		'file:downloadfailed' => "Désolé, ce fichier n'est pas disponible en ce moment.",
		'file:deletefailed' => "Votre fichier n'a pas pu être effacé en ce moment.",
		'file:noaccess' => "Vous n'avez pas la permission de modifier ce fichier",
		'file:cannotload' => "Erreur de chargement du fichier",
		'file:nofile' => "Vous devez choisir un fichier",
		
		'file:list:list' => "Afficher sous forme de liste",
		'file:list:gallery' => "Afficher sous forme de galerie",
		'file:notification' => "%s a chargé un nouveau fichier :

%s
%s

Afficher et commenter le nouveau fichier :
%s",

);

add_translation("fr", $french);
