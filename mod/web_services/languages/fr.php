<?php
/**
 * Elgg Web Services language pack.
 * 
 * @package Webservice
 * @author Florian Daniel - Facyla
 */

$french = array(
	'web_services:user' => "Utilisateur", 
	'web_services:object' => "Publications", 
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
	'web_services:likes' => 'Appréciations',
	'likes:notallowed' => "Non autorisé à ajouter une appréciation",
	'web_services:likes:add' => "Ajouter une appréciation",
	'web_services:likes:delete' => "Retirer une appréciation",
	'web_services:likes:count' => "Compter le nombre d'appréciations",
	'web_services:likes:getusers' => "Récupérer les membres qui ont apprécié une publication",
	'web_services:annotation_likes:add' => "Ajouter une appréciation sur une réponse ou un commentaire",
	'web_services:annotation_likes:delete' => "Retirer une appréciation sur une réponse ou un commentaire",
	'web_services:annotation_likes:count' => "Compter le nombre d'appréciations sur une réponse ou un commentaire",
	'web_services:annotation_likes:getusers' => "Récupérer les membres qui ont apprécié une réponse ou un commentaire",
	
	'web_services:settings:api_information' => "Tout web service activé peut être appelé via l'URL :<br />
		<pre>&lt;URL du site&gt;/services/api/rest/&lt;format&gt;/?method=&lt;nom méthode&gt;</pre><br />
		Avec <ul>
			<li>&lt;URL du site&gt; : la racine du site Elgg</li>
			<li>&lt;format&gt; : json ou xml</li>
			<li>&lt;nom méthode&gt; : le nom de la méthode que vous souhaitez appeler</li>
		</ul>
		<p>Les paramètres optionels sont <strong>api_key=APIKEY</strong> et <strong>auth_token=USER_TOKEN</strong></p>
		<p>Les autres paramètres dépendent du webservice utilisé</p>",
	
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
	'web_services:blog:get_comments' => "Récupérer les commentaires d'un article",
	'web_services:blog:post_comment' => "Publier un commentaire sur un article",
	
	// File webservice
	'web_services:file:get_files' => "Récupérer les fichiers envoyés par les utilisateurs",
	'web_services:file:get_info' => "Récupérer les informations du fichier",
	'web_services:file:get_content' => "Récupérer le contenu du fichier",
	'web_services:file:not_found' => "Fichier non trouvé",
	
	// Group webservice
	'web_services:group:get_groups' => "Récupérer les groupes dont l'utilisateur est membre",
	'web_services:group:get' => "Récupérer un groupe",
	'web_services:group:join' => "Rejoindre un groupe",
	'web_services:group:leave' => "Quitter un groupe",
	'web_services:group:save' => "Enregistrer un groupe",
	'web_services:group:save_post' => "Publier un sujet dans un forum de groupe",
	'web_services:group:delete_post' => "Supprimer un sujet d'un forum de groupe",
	'web_services:group:get_posts' => "Récupérer les articles d'un groupe",
	'web_services:group:get_post' => "Récupérer un sujet d'un forum de groupe",
	'web_services:group:get_replies' => "Récupérer les réponses à un sujet de forum",
	'web_services:group:save_reply' => "Publier une réponse à un sujet de forum",
	'web_services:group:delete_reply' => "Supprimer une réponse à un sujet de forum",
	'web_services:group:activity' => "Récupérer le fil d'activité d'un groupe",
	'web_services:group:notfound' => "Groupe non trouvé ou inaccessible",
	'web_services:group:get_icon' => "Récupérer l'icone de profil d'un groupe",
	
	// The Wire webservice
	'web_services:wire:save_post' => "Publier un message sur le Fil",
	'web_services:wire:get_posts' => "Lire les derniers messages du Fil",
	'web_services:wire:delete_posts' => "Supprimer un message du Fil",
	
	// User webservice
	'web_services:user:get_profile_fields' => "Récupérer les champs du profil d'un utilisateur",
	'web_services:user:get_profile' => "Récupérer les informations du profil d'un utilisateur",
	'web_services:user:save_profile' => "Enregistrer les informations du profil d'un utilisateur",
	'web_services:user:get_user_by_email' => "Récupérer un (ou des) nom(s) d'utilisateur à partir d'un email",
	'web_services:user:check_username_availability' => "Vérifier la disponibilité d'un nom d'utilisateur",
	'web_services:user:register' => "Créer un compte utilisateur",
	'web_services:user:friend:add' => "Ajouter un contact",
	'web_services:user:friend:remove' => "Supprimer un contact",
	'web_services:user:get_friends' => "Récupérer les contacts",
	'web_services:user:friend:get_friends_of' => "Récupérer les membres dont le membre est un contact",
	'web_services:user:get_messageboard' => "Récupérer le Mur d'un utilisateur",
	'web_services:user:post_messageboard' => "Publier un message sur le Mur",
	'web_services:user:activity' => "Récupérer le fil d'activité d'un membre",
	'web_services:user:get_guid' => "Récupérer le GUID à partir d'un nom d'utilisateur",
	'web_services:user:get_username' => "Récupérer le nom d'utilisateur à partir d'un GUID",
	'web_services:user:group_join_request:remove' => "Supprimer une invitation à un groupe",
	'web_services:user:group_join_request:accept' => "Accepter une invitation à un groupe",
	'web_services:user:friend_request:remove' => "Supprimer une demande de contact",
	'web_services:user:friend_request:accept' => "Accepter une demande de contact",
	'web_services:user:requests:list' => "Récupérer les demandes de contacts et invitations dans des groupes",
	'web_services:user:get_icon' => "Récupérer l'image de profil d'un membre",
	
	
	// Message webservice
	'web_services:message:read' => "Lire un message",
	'web_services:message:count' => "Récupérer le nombre de messages non lus",
	'web_services:message:inbox' => "Récupérer les messages reçus",
	'web_services:message:sent' => "Récupérer les messages envoyés",
	'web_services:message:send' => "Envoyer un message",
	
	// Object
	'web_services:object:get_post' => "Lire une publication",
	'object:error:post_not_found' => "Publication non trouvée",
	
	
);

add_translation("fr", $french);

