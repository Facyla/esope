<?php

return [
	'item:object:survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Sondages",
	'item:object:survey_question' => "Question d'un sondage",
	
	'survey:index' => "Sondages",
	'survey:group' => "Sondages du groupe",
	'survey:owner' => "Sondages de %s",
	'survey:add' => "Nouveau sondage",
	'survey:edit' => "Modification du sondage",
	'survey:view' => "Sondage %s",
	'survey:results' => "Résultats",
	'survey:export' => "Export",
	
	/**
	 * Menu items and titles
	 */
	'survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Sondages",
	//'survey:site_survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Sondages",
	'survey:group_survey' => "<i class=\"fa fa-bar-chart fa-rotate-90 fa-fw\"></i> Sondages",
	'survey:group_survey:listing:title' => "Sondages de %s",
	'survey:add' => "Nouveau sondage",
	'survey:your' => "Vos sondages",
	'survey:not_me' => "Sondages de %s",
	'survey:friends' => "Sondages des contacts",
	'survey:addpost' => "Créer un sondage",
	'survey:editpost' => "Modifier un sondage : %s",
	'survey:edit' => "Modifier un sondage",
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
	'survey:settings:group_access:title' => "Si les sondages de groupe sont activés, qui peut créer les sondages ?",
	'survey:settings:group_access:admins' => "responsables du groupe et administrateurs seulement",
	'survey:settings:group_access:members' => "tout membre du groupe",
	'survey:settings:front_page:title' => "Activer le \"Sondage du jour\" du site ?",
	'survey:settings:front_page:details' => "Les administrateurs peuvent-ils faire d'un sondage le \"Sondage du jour\" du site ? Le plugin Widget Manager est requis pour ajouter le widget correspondant sur la page d'accueil, ou la vue correspondante doit être intégrée via le plugin de thème.",
	'survey:settings:allow_close_date:title' => "Permettre de définir une date de clôture pour les sondages ?",
	'survey:settings:allow_close_date:details' => "Après cette date les résultats pourront toujours être consultés, mais il ne sera plus possible de répondre.",
	'survey:settings:allow_open_survey:title' => "Permettre de créer des sondages ouverts ?",
	'survey:settings:allow_open_survey:details' => "Les sondages ouverts montrent les réponses de chacun des membres ; si cette option est activée, les administrateurs peuvent voir qui a voté quoi sur tous les sondages.",
	'survey:none' => "Aucun sondage.",
	'survey:not_found' => "Le sondage n'a pas été trouvé.",
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
	'survey:settings:notifications' => "Notifications",
	'survey:settings:access' => "Accès aux sondages",
	'survey:settings:options' => "Options des sondages",
	'survey:settings:show_active_only' => "Masquer le bloc des sondages de groupe si aucun sondage actif",

	/**
	 * Survey widget
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
	 * Survey river
	 **/
	'survey:settings:create_in_river:title' => "Montrer la création de sondages dans la fil d'activité ?",
	'survey:settings:response_in_river:title' => "Montrer les réponses aux sondages dans le fil d'activité ?",
	'survey:settings:send_notification:title' => "Envoyer des notifications lorsqu'un sondage est créé ?",
	'survey:settings:send_notification:details' => "Les membres ne recevront des notifications que s'ils sont en contact avec l'auteur, ou membre du groupe dans lequel le sondage a été créé. De plus, les notifications ne seront envoyées qu'aux membres qui ont activé leurs notifications.",
	// Old river keys < 3.0
	'river:create:object:survey' => '%s a créé un sondage %s',
	'river:response:object:survey' => '%s a répondu au sondage %s',
	'river:comment:object:survey' => '%s a commenté le sondage %s',
	// New river key 3.0+
	'river:object:survey:create' => '%s a créé un sondage %s',
	'river:object:survey:response' => '%s a répondu au sondage %s',
	'river:object:survey:comment' => '%s a commenté le sondage %s',

	/**
	 * Status messages
	 */
	'survey:added' => "Votre sondage a été créé.",
	'survey:edited' => "Votre sondage a été enregistré.",
	'survey:responded' => "Merci d'avoir répondu, vos réponses ont été enregistrées.",
	'survey:deleted' => "Votre sondage a été supprimé.",
	'survey:totalresponses' => "Nombre total de réponses : %s",
	'survey:alreadyresponded' => "Vous avez répondu à ce sondage.",
	'survey:responded' => "Merci d'avoir répondu à ce sondage.",

	/**
	 * Error messages
	 */
	'survey:blank' => "Vous devez compléter la question et ajouter au moins un choix avant de pouvoir enregistrer le sondage.",
	'survey:noresponse' => "Vous devez choisir une réponse pour participer à ce sondage.",
	'survey:notfound' => "Le sondage demandé n'a pas été trouvé.",
	'survey:notdeleted' => "Ce sondage n'a pas pu être supprimé.",
	'survey:filter:invalid' => "Type de filtre invalide.",
	
	// ESOPE : New survey strings
	'survey:questions' => "Questions",
	'survey:add_question' => "Ajouter une question",
	'survey:delete_question' => "Supprimer cette question",
	'survey:title' => "Titre du sondage",
	'survey:option:yes' => "oui",
	'survey:option:no' => "non",
	// Question fields
	'survey:question:title' => "Intitulé de la question",
	'survey:question:title:placeholder' => "Titre de la question",
	'survey:question:description' => "Aide ou précisions sur la question (facultatif)",
	'survey:question:description:placeholder' => "Ce texte permet d'aider à répondre à la question, ou à donner des informations complémentaires.",
	'survey:question:input_type' => "Type de question",
	'survey:question:options' => "Options",
	'survey:question:options:placeholder' => "Une option par ligne \nOption 1 \nOption 2 \nOption 3 \netc.",
	'survey:question:empty_value' => "Ajouter une option vide",
	'survey:question:required' => "Question obligatoire",
	'survey:question:toggle' => "<i class=\"fa fa-toggle-down\"></i> Montrer/masquer",
	'survey:question:toggle:details' => "<i class=\"fa fa-eye-slash\"></i> Montrer/masquer les options des questions",
	// Input types
	'survey:type:text' => "<i class=\"fa fa-font\"></i> Texte court",
	'survey:type:text:details' => "Pour une réponse très courte, sur une seule ligne : de un à quelques mots.",
	'survey:type:longtext' => "<i class=\"fa fa-paragraph\"></i> Texte de paragraphe",
	'survey:type:longtext:details' => "Pour une réponse détaillée, sur plusieurs lignes : de un à quelques paragraphes.",
	'survey:type:plaintext' => "<i class=\"fa fa-paragraph\"></i> Texte de paragraphe",
	'survey:type:plaintext:details' => "Pour une réponse détaillée, sur plusieurs lignes : de un à quelques paragraphes.",
	'survey:type:pulldown' => "<i class=\"fa fa-list\"></i> Choix dans une liste",
	'survey:type:pulldown:details' => "Pour une réponse parmi une liste de choix à définir ci-dessous. Vous pouvez également ajouter une option \"vide\" qui permet de ne pas imposer de choisir une réponse.",
	'survey:type:checkboxes' => "<i class=\"fa fa-check-square-o\"></i> Cases à cocher",
	'survey:type:checkboxes:details' => "Pour plusieurs réponses sous forme de liste, parmi une liste de choix à définir ci-dessous.",
	'survey:type:multiselect' => "<i class=\"fa fa-check-square-o\"></i> Sélection multiple",
	'survey:type:multiselect:details' => "Pour plusieurs réponses sous forme de cases à cocher, parmi une liste de choix à définir ci-dessous.",
	'survey:type:rating' => "<i class=\"fa fa-signal\"></i> Echelle d'évaluation",
	'survey:type:rating:details' => "Pour une seule réponse parmi une liste de choix, présentés sur une seule ligne. Cette option est plus appropriée pour une échelle d'évaluation ou de notation, en indiquant par exemple des options de 0 à 5, ou une liste d'appréciations qualitative (de pas du tout à tout à fait). Vous pouvez également ajouter une option \"vide\" qui permet de ne pas imposer de choisir une réponse.",
	'survey:type:date' => "<i class=\"fa fa-calendar-o\"></i> Date",
	'survey:type:date:details' => "Pour une date à choisir dans un calendrier.",
	// Responses
	'survey:results' => "Résultats du sondage",
	'survey:results:question' => "Question",
	'survey:results:user' => "Répondant",
	'survey:results:export' => "Export des données",
	'survey:result:label' => "\"%s\" (%s réponses)",
	'survey:results:summary' => "Résumé des résultats",
	'survey:results:full' => "Résultats détaillés",
	'survey:results:user_details' => "Voir le détail pour ce répondant",
	'survey:results:user_details:title' => "Détail des réponses de ce répondant",
	'survey:results:question_details' => "Voir le détail pour cette question",
	'survey:results:question_details:title' => "Détail des réponses pour cette question",
	'survey:results:question_details:responses' => "Réponse(s) par répondant",
	'survey:results:question_details:values' => "Nombre de mentions des choix pour chaque valeur de réponse",
	'survey:results:questions' => "Liste des questions",
	'survey:results:users' => "Liste des répondants",
	'survey:results:values' => "Liste des réponses",
	'survey:results:questionscount' => "<strong>%s</strong> questions",
	'survey:results:responderscount' => "<strong>%s</strong> répondants",
	'survey:results:stats' => "Statistiques globales",
	'survey:results:responsesbyquestion' => "Nombre de réponses par question",
	'survey:results:userdetails' => "Détail des réponses de &laquo;&nbsp;%s&nbsp;&raquo;",
	'survey:results:questiondetails' => "Détail des réponses à &laquo;&nbsp;%s&nbsp;&raquo;",
	'survey:results:question:counts' => "%s répondants sur %s ont répondu à cette question (%s%%)",
	'survey:results:responders' => "Répondants",
	'survey:results:inputtype' => "Type de champ",
	'survey:results:nbresponses' => "Nombre de réponses",
	'survey:results:percresponses' => "% réponses",
	'survey:results:moredetails' => "Plus de détails",
	'survey:results:guid' => "GUID",
	'survey:results:name' => "Nom du répondant",
	'survey:results:value' => "Valeur de la réponse",
	'survey:results:count' => "Nombre de mentions",
	
	
	'survey:results:numquestions' => "Nombre de questions",
	'survey:results:numresponders' => "Nombre de répondants",
	'survey:results:created' => "Date de création",
	'survey:results:updated' => "Dernière mise à jour",
	'survey:results:featured' => "Sondage mis en avant",
	'survey:results:open' => "Etat du sondage",
	'survey:results:closing' => "Date de clôture",
	'survey:results:access' => "Visibilité",
	'survey:comments_on' => "Activer les commentaires",
	'survey:question:comment_on' => "Commentaires",
	'survey:question:display_order' => "Ordre d'affichage",
	'survey:question:guid' => "GUID",
	'survey:response:notrequired' => "Question facultative",
	'survey:response:required' => "Question obligatoire",
	'survey:results:yourresponse' => "Votre réponse",
	'survey:questions:reorder' => "<i class=\"fa fa-info-circle\"></i> Vous pouvez modifier l'ordre des questions en les cliquant-déplaçant sur la page.",
	
	'survey:results:export' => "Exporter les résultats du sondage",
	'survey:settings:results_export' => "Permettre d'exporter les résultats en CSV",
	
	'survey:state:open' => "Sondage en cours",
	'survey:state:closed' => "Sondage terminé",
	
];

