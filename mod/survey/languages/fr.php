<?php

$fr = array(

	/**
	 * Menu items and titles
	 */
	'survey' => "Sondages",
	'survey:add' => "Nouveau sondage",
	'survey:group_survey' => "Sondages",
	'survey:group_survey:listing:title' => "Sondages de %s",
	'survey:your' => "Vos sondages",
	'survey:not_me' => "Sondages de %s",
	'survey:friends' => "Sondages des contacts",
	'survey:addpost' => "Créer un sondage",
	'survey:editpost' => "Modifier un sondage : %s",
	'survey:edit' => "Modifier un sondage",
	'item:object:survey' => 'Sondages',
	'item:object:survey_choice' => "Options du sondage",
	'survey:question' => "Question du sondage",
	'survey:description' => "Description (facultatif)",
	'survey:responses' => "Options de la réponse",
	'survey:show_results' => "Montrer les résultats",
	'survey:show_survey' => "Afficher le sondage",
	'survey:add_choice' => "Ajouter une option",
	'survey:delete_choice' => "Supprimer cette option",
	'survey:close_date' => "Date de clôture du sondage (facultatif)",
	'survey:voting_ended' => "Les réponses pour ce sondage se terminent le %s.",
	'survey:survey_closing_date' => "(Date de clôture du sondage : %s)",

	'survey:convert:description' => "ATTENTION : %s sondages utilisent encore l'ancienne structure de données. Ces sondages ne vont pas fonctionner correctement avec cette version du plugin.",
	'survey:convert' => "Mettre à jour les sondages maintenant",
	'survey:convert:confirm' => "La mise à jour est irréversible. Confirmez-vous vouloir convertir la structure de données du des choix du sondage ?",

	'survey:settings:group:title' => "Activer les sondages du groupe ?",
	'survey:settings:group_survey_default' => "oui, activé par défaut",
	'survey:settings:group_survey_not_default' => "oui, désactivé par défaut",
	'survey:settings:no' => "non",
	'survey:settings:group_access:title' => "Si les sondages de groupe sont activés, qui peut créer les sondages ?",
	'survey:settings:group_access:admins' => "responsables du groupe et administrateurs seulement",
	'survey:settings:group_access:members' => "tout membre du groupe",
	'survey:settings:front_page:title' => "Les administrateurs peuvent-ils faire d'un sondage le \"Sondage du jour\" du site ? (le plugin Widget Manager requis pour ajouter le widget correspondant sur la page d'accueil)",
	'survey:settings:allow_close_date:title' => "Permettre de définir une date de clôture pour les sondages ? (après cette date les résultats pourront toujours être consultés, mais il ne sera plus possible de répondre)",
	'survey:settings:allow_open_survey:title' => "Permettre de créer des sondages ouverts ? (les sondages ouverts montrent les réponses de chacun des membres ; si cette option est activée, les administrateurs peuvent voir qui a voté quoi sur tous les sondages)",
	'survey:none' => "Aucun sondage.",
	'survey:permission_error' => "Vous n'avez pas la permission de modifier ce sondage.",
	'survey:respond' => "Répondre",
	'survey:login' => "Veuillez vous connecter pour répondre à ce sondage.",
	'group:survey:empty' => "Aucun sondage",
	'survey:settings:site_access:title' => "Qui peut créer des sondages pour l'ensemble du site ?",
	'survey:settings:site_access:admins' => "administrateurs seulement",
	'survey:settings:site_access:all' => "tout membre du site",
	'survey:can_not_create' => "Vous n'avez pas la permission de créer de sondage.",
	'survey:front_page_label' => "Faire de ce sondage le nouveau \"Sondage du jour\" du site",
	'survey:open_survey_label' => "Afficher dans les résultats les réponses des membres (sondage ouvert)",
	'survey:show_responders' => "Montrer les répondants",

	/**
	 * Poll widget
	 **/
	'survey:latest_widget_title' => "Sondages récents",
	'survey:latest_widget_description' => "Affiche les derniers sondages créés.",
	'survey:latestgroup_widget_title' => "Derniers sondages du groupe",
	'survey:latestgroup_widget_description' => "Affiche les derniers sondages du groupe.",
	'survey:my_widget_title' => "Mes sondages",
	'survey:my_widget_description' => "Ce widget affiche vos sondages.",
	'survey:widget:label:displaynum' => "Nombre de sondages à afficher ?",
	'survey:individual' => "Sondage du jour",
	'survey_individual:widget:description' => "Afficher le \"Sondage du jour\" du site.",
	'survey:widget:no_survey' => "Aucun sondage de %s pour le moment.",
	'survey:widget:nonefound' => "Aucun sondage.",
	'survey:widget:think' => "Dites à %s ce que vous pensez !",
	'survey:enable_survey' => "Activer les sondages",
	'survey:noun_response' => "réponse",
	'survey:noun_responses' => "réponses",
	'survey:settings:yes' => "oui",
	'survey:settings:no' => "non",

	'survey:month:01' => 'Janvier',
	'survey:month:02' => 'Février',
	'survey:month:03' => 'Mars',
	'survey:month:04' => 'Avril',
	'survey:month:05' => 'Mai',
	'survey:month:06' => 'Juin',
	'survey:month:07' => 'Juillet',
	'survey:month:08' => 'Août',
	'survey:month:09' => 'Septembre',
	'survey:month:10' => 'Octobre',
	'survey:month:11' => 'Novembre',
	'survey:month:12' => 'Décembre',

	/**
	 * Notifications
	 **/
	'survey:new' => "Un nouveau sondage",
	'survey:notify:summary' => "Nouveau sondage intitulé %s",
	'survey:notify:subject' => "Nouveau sondage : %s",
	'survey:notify:body' =>'
%s a créé un nouveau sondage :

%s

Afficher le sondage et y répondre :
%s
',

	/**
	 * Poll river
	 **/
	'survey:settings:create_in_river:title' => "Montrer la création de sondages dans la fil d'activité ?",
	'survey:settings:response_in_river:title' => "Montrer les réponses aux sondages dans le fil d'activité ?",
	'survey:settings:send_notification:title' => "Envoyer des notifications lorsqu'un sondage est créé ? (Les membres ne recevront des notifications que s'ils sont en contact avec l'auteur, ou membre du groupe dans lequel le sondage a été créé. De plus, les notifications ne seront envoyées qu'aux membres qui ont activé leurs notifications)",
	'river:create:object:survey' => '%s a créé un sondage %s',
	'river:response:object:survey' => '%s a répondu au sondage %s',
	'river:comment:object:survey' => '%s a commenté le sondage %s',

	/**
	 * Status messages
	 */
	'survey:added' => "Votre sondage a été créé.",
	'survey:edited' => "Votre sondage a été enregistré.",
	'survey:responded' => "Merci d'avoir répondu, vos réponses ont été enregistrées.",
	'survey:deleted' => "Votre sondage a été supprimé.",
	'survey:totalresponses' => "Nombre total de réponses : ",
	'survey:responded' => "Votre réponse a été enregistrée. Merci d'avoir répondu à ce sondage.",

	/**
	 * Error messages
	 */
	'survey:blank' => "Désolé : vous devez compléter la question et ajouter au moins un choix avant de pouvoir enregistrer le sondage.",
	'survey:noresponse' => "Désolé : vous devez choisir une réponse pour participer à ce sondage.",
	'survey:notfound' => "Désolé : impossible de trouver le sondage demandé.",
	'survey:notdeleted' => "Désolé : impossible de supprimer ce sondage.",
	
	
	// New survey strings
	'survey:questions' => "Questions",
	'survey:add_question' => "Ajouter une question",
	'survey:title' => "Titre du sondage",
	'survey:option:yes' => "oui",
	'survey:option:no' => "non",
	// Question fields
	'survey:question:title' => "Intitulé de la question",
	'survey:question:description' => "(facultatif) Aide ou précisions sur la question",
	'survey:question:input_type' => "Type de question",
	'survey:question:options' => "(facultatif) Options",
	'survey:question:empty_value' => "(si options) Option vide",
	'survey:question:required' => "Réponse obligatoire",
	// Input types
	'survey:type:text' => "Texte court",
	'survey:type:longtext' => "Texte de paragraphe (avec éditeur)",
	'survey:type:plaintext' => "Texte de paragraphe (sans éditeur)",
	'survey:type:dropdown' => "Choix dans une liste",
	'survey:type:checkboxes' => "Cases à cocher",
	'survey:type:multiselect' => "Sélection multiple",
	'survey:type:rating' => "Echelle d'évaluation",
	'survey:type:date' => "Date",
	// Responses
	'survey:result:label' => "\"%s\" (%s réponses)",
	
	
);

add_translation("fr",$fr);

