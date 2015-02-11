<?php

$fr = array(

	/**
	 * Menu items and titles
	 */
	'poll' => "Sondages",
	'poll:add' => "Nouveau sondage",
	'poll:group_poll' => "Sondages",
	'poll:group_poll:listing:title' => "Sondages de %s",
	'poll:your' => "Vos sondages",
	'poll:not_me' => "Sondages de %s",
	'poll:friends' => "Sondages des contacts",
	'poll:addpost' => "Créer un sondage",
	'poll:editpost' => "Modifier un sondage : %s",
	'poll:edit' => "Modifier un sondage",
	'item:object:poll' => 'Sondages',
	'item:object:poll_choice' => "Options du sondage",
	'poll:question' => "Question du sondage",
	'poll:description' => "Description (facultatif)",
	'poll:responses' => "Options du vote",
	'poll:show_results' => "Montrer les résultats",
	'poll:show_poll' => "Afficher le sondage",
	'poll:add_choice' => "Ajouter une option",
	'poll:delete_choice' => "Supprimer cette option",
	'poll:close_date' => "Date de clôture du sondage (facultatif)",
	'poll:voting_ended' => "Les votes pour ce sondage se terminent le %s.",
	'poll:poll_closing_date' => "(Date de clôture du sondage : %s)",

	'poll:convert:description' => 'ATTENTION: there were %s existing polls found that still have the old vote choices data structure. These polls won\'t work correctly on this version of the poll plugin.',
	'poll:convert' => 'Mettre à jour les sondages maintenant',
	'poll:convert:confirm' => 'The update is irreversible. Are you sure you want to convert the poll vote choices data structure?',

	'poll:settings:group:title' => "Activer les sondages du groupe ?",
	'poll:settings:group_poll_default' => "oui, activé par défaut",
	'poll:settings:group_poll_not_default' => "oui, désactivé par défaut",
	'poll:settings:no' => "non",
	'poll:settings:group_access:title' => "If group polls are activated, who gets to create polls?",
	'poll:settings:group_access:admins' => "responsables du groupe et administrayeurs seulement",
	'poll:settings:group_access:members' => "tout membre du groupe",
	'poll:settings:front_page:title' => "Admins can make a single poll at a time the site's \"Poll of the day\"? (Widget Manager plugin required for adding the corresponding widget to the index page)",
	'poll:settings:allow_close_date:title' => "Allow setting a closing date for polls? (afterwards the results can still be viewed but voting is no longer permitted)",
	'poll:settings:allow_open_poll:title' => "Allow open polls? (open polls show which user voted for which poll choice; if this option is enabled, admins can see who voted what on any polls)",
	'poll:none' => "Aucun sondage.",
	'poll:permission_error' => "You do not have permission to edit this poll.",
	'poll:vote' => "Voter",
	'poll:login' => "Please login if you would like to vote in this poll.",
	'group:poll:empty' => "Aucun sondage",
	'poll:settings:site_access:title' => "Qui peut créer des sondages pour l'ensemble du site ?",
	'poll:settings:site_access:admins' => "administrateurs seulement",
	'poll:settings:site_access:all' => "tout membre du site",
	'poll:can_not_create' => "You do not have permission to create polls.",
	'poll:front_page_label' => "Make this poll the site's new \"Poll of the day\"",
	'poll:open_poll_label' => "Show in results which members voted for which choice (open poll)",
	'poll:show_voters' => "Montrer les votes",

	/**
	 * Poll widget
	 **/
	'poll:latest_widget_title' => "Latest community polls",
	'poll:latest_widget_description' => "Displays the most recent polls.",
	'poll:latestgroup_widget_title' => "Derniers sondages du groupe",
	'poll:latestgroup_widget_description' => "Affiche les derniers sondages du groupe.",
	'poll:my_widget_title' => "Mes sondages",
	'poll:my_widget_description' => "This widget will display your polls.",
	'poll:widget:label:displaynum' => "How many polls do you want to display?",
	'poll:individual' => "Sondage du jour",
	'poll_individual:widget:description' => "Display the site's current \"Poll of the day\".",
	'poll:widget:no_poll' => "There are no polls of %s yet.",
	'poll:widget:nonefound' => "Aucun sondage.",
	'poll:widget:think' => "Let %s know what you think!",
	'poll:enable_poll' => "Activer les sondages",
	'poll:noun_response' => "vote",
	'poll:noun_responses' => "votes",
	'poll:settings:yes' => "oui",
	'poll:settings:no' => "non",

	'poll:month:01' => 'Janvier',
	'poll:month:02' => 'Février',
	'poll:month:03' => 'Mars',
	'poll:month:04' => 'Avril',
	'poll:month:05' => 'Mai',
	'poll:month:06' => 'Juin',
	'poll:month:07' => 'Juillet',
	'poll:month:08' => 'Août',
	'poll:month:09' => 'Septembre',
	'poll:month:10' => 'Octobre',
	'poll:month:11' => 'Novembre',
	'poll:month:12' => 'Décembre',

	/**
	 * Notifications
	 **/
	'poll:new' => 'Un nouveau sondage',
	'poll:notify:summary' => 'New poll called %s',
	'poll:notify:subject' => 'Nouveau sondage : %s',
	'poll:notify:body' =>'
%s a créé un nouveau sondage :

%s

Afficher le sondage et voter :
%s
',

	/**
	 * Poll river
	 **/
	'poll:settings:create_in_river:title' => "Show poll creation in activity river?",
	'poll:settings:vote_in_river:title' => "Show poll voting in activity river?",
	'poll:settings:send_notification:title' => "Send notification when a poll is created? (Members will only receive notifications if their are friend with the creator of the poll or a member of the group the poll was added to. Additionally, notifications will only be sent to members who configured Elgg's notification settings accordingly)",
	'river:create:object:poll' => '%s created a poll %s',
	'river:vote:object:poll' => '%s voted on the poll %s',
	'river:comment:object:poll' => '%s commented on the poll %s',

	/**
	 * Status messages
	 */
	'poll:added' => "Your poll was created.",
	'poll:edited' => "Your poll was saved.",
	'poll:responded' => "Thank you for responding, your vote was recorded.",
	'poll:deleted' => "Your poll was successfully deleted.",
	'poll:totalvotes' => "Total number of votes: ",
	'poll:voted' => "Your vote has been cast for this poll. Thank you for voting on this poll.",

	/**
	 * Error messages
	 */
	'poll:blank' => "Désolé : you need to fill in both the question and add at least one vote choice before you can create the poll.",
	'poll:novote' => "Désolé : you need to choose an option to vote in this poll.",
	'poll:notfound' => "Désolé : we could not find the specified poll.",
	'poll:notdeleted' => "Désolé : we could not delete this poll."
);

add_translation("fr",$fr);

