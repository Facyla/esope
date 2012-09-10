<?php
/**
 * Elgg groups plugin language pack
 *
 * @package ElggGroups
 */

$french = array(

	/**
	 * Menu items and titles
	 */
	'groups' => "Groupes",
	'groups:owned' => "Groupes dont je suis responsable",
	'groups:yours' => "Tous mes groupes",
	'groups:user' => "Les groupes de %s",
	'groups:all' => "Tous les groupes",
	'groups:add' => "Créer un nouveau groupe",
	'groups:edit' => "Modifier le groupe",
	'groups:delete' => "Supprimer le groupe",
	'groups:membershiprequests' => "Gérer les demandes de participation au groupe",
	'groups:invitations' => "Invitations du groupe",

	'groups:icon' => "Image du profil du groupe",
	'groups:name' => "Nom du groupe",
	'groups:username' => "Nom court du goupe (qui s'affichera dans l'URL : en caractères alphanumériques)",
	'groups:description' => "Description",
	'groups:briefdescription' => "Résumé",
	'groups:interests' => "Mots-clés",
	'groups:website' => "Site web",
	'groups:members' => "Membres du groupe",
	'groups:members:title' => "Les membres de %s",
	'groups:members:more' => "Voir tous les membres",
	'groups:membership' => "Type d'adhésion au groupe",
	'groups:access' => "Permissions d'accès",
	'groups:owner' => "responsable",
	'groups:widget:num_display' => "Nombre de groupes à afficher",
	'groups:widget:membership' => "Adhésion au groupe",
	'groups:widgets:description' => "Afficher les groupes dont vous êtes membre dans votre profil",
	'groups:noaccess' => "Vous n'avez pas accès au groupe",
	'groups:permissions:error' => "Vous n'avez pas les autorisations pour çà",
	'groups:ingroup' => "dans le groupe",
	'groups:cantedit' => "Vous ne pouvez pas modifier ce groupe",
	'groups:saved' => "Groupe enregistré",
	'groups:featured' => "Les groupes à la une",
	'groups:makeunfeatured' => "Enlever de la une",
	'groups:makefeatured' => "Mettre en une",
	'groups:featuredon' => "%s est maintenant un groupe à la une.",
	'groups:unfeatured' => "s% n'est plus à la une.",
	'groups:featured_error' => "Groupe invalide.",
	'groups:joinrequest' => "Demander une adhésion au groupe",
	'groups:join' => "Rejoindre le groupe",
	'groups:leave' => "Ne plus participer au groupe",
	'groups:invite' => "Inviter des contacts",
	'groups:invite:title' => "Invitez des contacts à participer à ce groupe",
	'groups:inviteto' => "Inviter des contacts au groupe '%s'",
	'groups:nofriends' => "Vous n'avez plus de contacts à inviter à ce groupe.",
	'groups:nofriendsatall' => "Vous n'avez pas de contact à inviter !",
	'groups:viagroups' => "Via les groupes",
	'groups:group' => "Groupe",
	'groups:search:tags' => "Mot-clef",
	'groups:search:title' => "Rechercher des groupes qui contiennent le mot-clef '%s'",
	'groups:search:none' => "Aucun groupe correspondant n'a été trouvé",

	'groups:activity' => "Activité du Groupe",
	'groups:enableactivity' => "Activer les 'Activité du groupe'",
	'groups:activity:none' => "Il n'y a pas encore eu d'activité dans ce groupe",

	'groups:notfound' => "Le groupe n'a pas été trouvé",
	'groups:notfound:details' => "Le groupe que vous recherchez n'existe pas, ou alors vous n'avez pas la permission d'y accéder",

	'groups:requests:none' => "Aucun membre ne demande à rejoindre le groupe en ce moment.",

	'groups:invitations:none' => "Il n'y a pas d'invitations à rejoindre le groupe en attente.",

	'item:object:groupforumtopic' => "Sujets de discussion",

	'groupforumtopic:new' => "Nouvelle réponse dans le forum de discussion",

	'groups:count' => "groupe créé",
	'groups:open' => "groupe ouvert",
	'groups:closed' => "groupe fermé",
	'groups:member' => "membres",
	'groups:searchtag' => "Rechercher de groupes par mot-clef",

	'groups:more' => "Plus de groupes",
	'groups:none' => "Aucun groupe",


	/*
	 * Access
	 */
	'groups:access:private' => "Restreint - Les membres doivent être invités, ou leur candidature acceptée",
	'groups:access:public' => "Libre - N'importe quel membre peut rejoindre le groupe",
	'groups:access:group' => "Membres du groupe seulement",
	'groups:closedgroup' => "La participation à ce groupe est soumise à validation par l'un des responsable du groupe.<br /> ",
	'groups:closedgroup:request' => "Pour demander à participer, cliquez sur le lien \"Demander une adhésion au groupe\".",
	'groups:visibility' => "Visibilité (qui peut avoir connaissance de l'existence de ce groupe ?)",

	/*
	Group tools
	*/
	'groups:enableforum' => "Activer le forum de discussion du groupe",
	'groups:yes' => "oui",
	'groups:no' => "non",
	'groups:lastupdated' => "Dernière mise à jour %s par %s",
	'groups:lastcomment' => "Dernier commentaire %s par %s",

	/*
	Group discussion
	*/
	'discussion' => "Discussion",
	'discussion:add' => "Ajouter un sujet de discussion",
	'discussion:none' => 'Aucun sujet de discussion pour le moment... et si vous en commenciez un ?',
	'discussion:latest' => "Dernières discussions",
	'discussion:group' => "Forum de discussion",

	'discussion:topic:created' => "Le sujet de discussion a été créé.",
	'discussion:topic:updated' => "Le sujet de discussion a été mis à jour.",
	'discussion:topic:deleted' => "Le sujet de discussion a été supprimée.",

	'discussion:topic:notfound' => "Le sujet de discussion est introuvable",
	'discussion:error:notsaved' => "Impossible d'enregistrer ce sujet",
	'discussion:error:missing' => "Les deux champs 'titre' et 'message' sont obligatoires",
	'discussion:error:permissions' => "Vous n'avez pas les autorisations pour effectuer cette action",
	'discussion:error:notdeleted' => "Impossible de supprimer le sujet de discussion",

	'discussion:reply:deleted' => "La réponse de la discussion a été supprimée.",
	'discussion:reply:error:notdeleted' => "Impossible de supprimer la réponse de la discussion",

	'reply:this' => "Répondre à ce message",

	'group:replies' => "Réponses",
	'groups:forum:created' => "Créé %s avec %d commentaire(s)",
	'groups:forum:created:single' => "Créé %s avec %d réponse",
	'groups:forum' => "Discussion",
	'groups:addtopic' => "Ajouter un sujet",
	'groups:forumlatest' => "Dernière discussion",
	'groups:latestdiscussion' => "Dernières discussions",
	'groups:newest' => "Récents",
	'groups:popular' => "Populaires",
	'groupspost:success' => "Votre réponse a bien été publiée",
	'groups:alldiscussion' => "Dernière discussion",
	'groups:edittopic' => "Modifier le sujet",
	'groups:topicmessage' => "Message du sujet",
	'groups:topicstatus' => "Statut du sujet",
	'groups:reply' => "Publier un commentaire",
	'groups:topic' => "Sujets",
	'groups:posts' => "Discussions",
	'groups:lastperson' => "Dernière personne",
	'groups:when' => "Quand",
	'grouptopic:notcreated' => "Aucun sujet n'a encore été créé.",
	'groups:topicopen' => "Ouvert",
	'groups:topicclosed' => "Fermé",
	'groups:topicresolved' => "Résolu",
	'grouptopic:created' => "Votre sujet a été créé.",
	'groupstopic:deleted' => "Sujet supprimé",
	'groups:topicsticky' => "Sujet brûlant",
	'groups:topicisclosed' => "Ce sujet est fermée.",
	'groups:topiccloseddesc' => "Ce sujet a été fermé et n'accepte plus de nouveaux commentaires.",
	'grouptopic:error' => "Votre sujet n'a pas pu être créé. Merci d'essayer plus tard ou de contacter un administrateur du système.",
	'groups:forumpost:edited' => "Vous avez bien modifié cette discussion.",
	'groups:forumpost:error' => "Il y a eu un problème lors de la modification de cette discussion.",


	'groups:privategroup' => "Ce groupe est en accès restreint. Il est nécessaire de demander une adhésion.",
	'groups:notitle' => "Les groupes doivent avoir un titre",
	'groups:cantjoin' => "N'a pas pu rejoindre le groupe",
	'groups:cantleave' => "N'a pas pu quitter le groupe",
	'groups:addedtogroup' => "A ajouté avec succès l'utilisateur au groupe",
	'groups:joinrequestnotmade' => "La demande d'adhésion n'a pas pu être réalisée",
	'groups:joinrequestmade' => "La demande d'adhésion s'est déroulée avec succés",
	'groups:joined' => "Vous avez rejoint le groupe avec succés !",
	'groups:left' => "Vous avez quitter le groupe avec succés",
	'groups:notowner' => "Désolé, vous n'êtes pas le propriétaire du groupe.",
	'groups:notmember' => "Désolé, vous n'êtes pas membre de ce groupe.",
	'groups:alreadymember' => "Vous êtes déjà membre de ce groupe !",
	'groups:userinvited' => "L'utilisateur a été invité.",
	'groups:usernotinvited' => "L'utilisateur n'a pas pu être invité",
	'groups:useralreadyinvited' => "L'utilisateur a déjà été invité",
	'groups:invite:subject' => "%s vous avez été invité(e) à rejoindre %s!",
	'groups:updated' => "Dernière réponse par %s %s",
	'groups:started' => "Démarré par %s",
	'groups:joinrequest:remove:check' => "Etes-vous sûr de vouloir supprimer cette demande d'adhésion ?",
	'groups:invite:remove:check' => "Etes-vous sûr de vouloir supprimer cette invitation?",
	'groups:invite:body' => "Bonjour %s,

%s vous a invité à rejoindre le groupe '%s', cliquez sur le lien ci-dessous pour confirmer votre participation :

%s",

	'groups:welcome:subject' => "Bienvenue dans le groupe %s !",
	'groups:welcome:body' => "Bonjour %s!
		
Vous êtes maintenant membre du groupe '%s' ! Cliquez le lien ci-dessous pour commencer à participer !

%s",

	'groups:request:subject' => "%s a demandé une adhésion à %s",
	'groups:request:body' => "Bonjour %s,

%s a demandé à rejoindre le groupe '%s', cliquez sur le lien ci-dessous pour voir son profil :

%s

ou cliquez directement sur le lien ci-dessous pour confirmer son adhésion :

%s",

	/*
		Forum river items
	*/

	'groups:river:create' => "a créé le groupe",
	'groups:river:join' => "a rejoint le groupe",
	'forumtopic:river:create' => "a ajouté un nouveau sujet de discussion",
	'groups:river:reply' => "a répondu sur le sujet de discussion",
	
	/* Attention : nouvelles entrées liées au widget activité du groupe + river */
  'river:create:group:default' => "%s a créé le groupe %s",
	'river:join:group:default' => "%s a rejoint le groupe %s",
	'river:create:object:groupforumtopic' => "%s a ajouté un nouveau sujet de discussion %s",
	'river:reply:object:groupforumtopic' => "%s a répondu sur le sujet de discussion %s",
	
	'groups:nowidgets' => "Aucun widget n'a été défini pour ce groupe.",


	'groups:widgets:members:title' => "Membres du groupe",
	'groups:widgets:members:description' => "Lister les membres d'un groupe.",
	'groups:widgets:members:label:displaynum' => "Lister les membres d'un groupe.",
	'groups:widgets:members:label:pleaseedit' => "Merci de configurer ce widget.",

	'groups:widgets:entities:title' => "Objets dans le groupe",
	'groups:widgets:entities:description' => "Lister les objets enregistrés dans ce groupe",
	'groups:widgets:entities:label:displaynum' => "Lister les objets d'un groupe.",
	'groups:widgets:entities:label:pleaseedit' => "Merci de configurer ce widget.",

	'groups:forumtopic:edited' => "Sujet du forum modifié avec succés.",

	'groups:allowhiddengroups' => "Voulez-vous permettre les groupes privés (invisibles)?",

	/**
	 * Action messages
	 */
	'group:deleted' => "Contenus du groupe et groupe supprimés",
	'group:notdeleted' => "Le groupe n'a pas pu être supprimé",

	'group:notfound' => "Impossible de trouver le groupe",
	'grouppost:deleted' => "La publication dans le groupe a été effacée",
	'grouppost:notdeleted' => "La publication dans le groupe n'a pas pu être effacée",
	'groupstopic:deleted' => "Sujet supprimé",
	'groupstopic:notdeleted' => "Le sujet n'a pas pu être supprimé",
	'grouptopic:blank' => "Pas de sujet",
	'grouptopic:notfound' => "Le sujet n'a pu être trouvé",
	'grouppost:nopost' => "Pas d'articles",
	'groups:deletewarning' => "Etes-vous sûr de vouloir supprimer ce groupe ? Cette action est irréversible !",

	'groups:invitekilled' => "L'invitation a été supprimée",
	'groups:joinrequestkilled' => "La demande d'adhésion a été supprimée.",

	// ecml
	'groups:ecml:discussion' => "Discussions de groupe",
	'groups:ecml:groupprofile' => "Les profils de groupe",

);

add_translation("fr", $french);
