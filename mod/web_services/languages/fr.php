<?php
/**
 * Elgg Web Services language pack.
 * 
 * @package Webservice
 * @author Florian Daniel - Facyla
 */

$french = array(
	'web_services:user' => "Utilisateur", 
	'web_services:blog' => "Blog", 
	'web_services:wire' => "Le Fil", 
	'web_services:core' => "Core", 
	'web_services:group' => "Groupes",
	'web_services:file' => "Fichiers",
	'web_services:messages' => "Messages",
	'web_services:settings_description' => "Sélectionnez ci-dessous les web services que vous souhaitez activer :",
	'web_services:selectfeatures' => "Sélectionnez les fonctionnalités à activer",
	'friends:alreadyadded' => "%s a déjà été ajouté comme contact",
	'friends:remove:notfriend' => "%s n'est pas en contact avec vous",
	'blog:message:notauthorized' => "Non autorisé à accomplir cette requête",
	'blog:message:noposts' => "Aucun article de blog par utilisateur",

	'admin:utilities:web_services' => 'Tests des Web Services',
	'web_services:tests:instructions' => 'Lancer les tests unitaires pour le plugin des web services',
	'web_services:tests:run' => 'Lancer les tests',
	'web_services:likes' => 'Likes',
	'likes:notallowed' => 'Non autorisé à "liker"',
	
	// A resolution to json convertion error (for river)
	'river:update:user:default' => ' a mis à jour son profil ',
	
	// Core webservice
	'web_services:core:site_test' => "Webservice de test",
	'web_services:core:site_test:response' => "Bonjour",
	'web_services:core:getinfo' => "Récupérer les informations du site",
	'web_services:core:oauthok' => "en fonctionnement",
	'web_services:core:nooauth' => "non",
	'web_services:core:river_feed' => "Récupérer la rivière d'activité",
	'web_services:core:search' => "Effectuer une recherche",
	'web_services:core:auth_renewtoken' => "Renouvellement du jeton d'API utilisateur",
	'SecurityException:tokenrenewalfailed' => "Echec du renouvellement du jeton d'API : connexion perdue. Si vous aviez des modifications en cours, vous devriez les copier-coller avant de vous reconnecter.",
	
	// Blog webservice
	'web_services:blog:get_posts' => "Récupérer la liste des articles de blog",
	'web_services:blog:save_post' => "Publier un article de blog",
	'web_services:blog:delete_post' => "Supprimer un article de blog",
	'web_services:blog:get_post' => "Lire un article de blog",
	'web_services:blog:get_comments' => "Get comments for a blog post",
	'web_services:blog:post_comment' => "Post a comment on a blog post",
	
	// File webservice
	'web_services:file:get_files' => "Get file uploaded by all users",
	
	// Group webservice
	'web_services:group:get_groups' => "Get groups user is a member of",
	'web_services:group:get' => "Récupérer un groupe",
	'web_services:group:join' => "Rejoindre un groupe",
	'web_services:group:leave' => "Quitter un groupe",
	'web_services:group:save' => "Enregistrer un groupe",
	'web_services:group:save_post' => "Post a topic to a group forum",
	'web_services:group:delete_post' => "Delete topic post from a group forum",
	'web_services:group:get_posts' => "Get posts from a group",
	'web_services:group:get_post' => "Get a single post from a group forum",
	'web_services:group:get_replies' => "Get replies from a group forum topic",
	'web_services:group:save_reply' => "Post a reply to a group forum topic",
	'web_services:group:delete_reply' => "Delete a reply from a group forum topic",
	'web_services:group:activity' => "Get the activity feed for a group",
	
	// The Wire webservice
	'web_services:wire:save_post' => "Post a wire post",
	'web_services:wire:get_posts' => "Read latest wire posts",
	'web_services:wire:delete_posts' => "Delete a wire post",
	
	// User webservice
	'web_services:user:get_profile_fields' => "Get user profile labels",
	'web_services:user:get_profile' => "Get user profile information",
	'web_services:user:save_profile' => "Get user profile information with username",
	'web_services:user:get_user_by_email' => "Get username(s) by email",
	'web_services:user:check_username_availability' => "Check username availability",
	'web_services:user:register' => "Créer un compte utilisateur",
	'web_services:user:friend:add' => "Ajouter un contact",
	'web_services:user:friend:remove' => "Supprimer un contact",
	'web_services:user:get_friends' => "Récupérer les contacts",
	'web_services:user:friend:get_friends_of' => "Récupérer les membres dont le membre est un contact",
	'web_services:user:get_messageboard' => "Get a users messageboard",
	'web_services:user:post_messageboard' => "Post a messageboard post",
	'web_services:user:activity' => "Get the activity feed for a user",
	'web_services:user:get_guid' => "Get the user GUID for a given username",
	'web_services:user:get_username' => "Get the user username for a given GUID",
	
	// Message webservice
	'web_services:message:read' => "Lire un message",
	'web_services:message:count' => "Get a count of the users unread messages",
	'web_services:message:inbox' => "Récupérer les messages reçus",
	'web_services:message:sent' => "Récupérer les messages envoyés",
	'web_services:message:send' => "Envoyer un message",
	
	
);

add_translation("fr", $french);

