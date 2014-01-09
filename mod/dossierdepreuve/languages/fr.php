<?php
/** Elgg dossierdepreuve plugin language
 * @author Facyla
 * @copyright Facyla 2010-2013
 * @link http://id.facyla.net/
 */

$url = elgg_get_site_url();

$french = array(

	'dossierdepreuve' => "Dossier de preuve",
	'item:object:dossierdepreuve' => "Dossier de preuve",
	'dossierdepreuve:gestion' => "Gestion des groupes de formation",
	'dossierdepreuve:picto:description' => "<a href=\"javascript:void(0);\" onclick=\"$('#dossierdepreuve-picto-toggle').toggle();\" style=\"float:left; margin-left:20px;\">Que signifie cette image ?</a><div id=\"dossierdepreuve-picto-toggle\" style=\"display:none; clear:both;\">Cette image représente l'avancement du dossier de suivi :<ul><li>la première ligne correspond à l'auto-évaluation faite par le candidat, au fur et à mesure de son avancement</li><li>la 2e ligne représente l'évaluation par le formateur ; elle peut être faite ponctuellement, ou au fur et à mesure de l'avancement. Cette ligne peut ne pas être renseignée lorsque le formateur est habilité : dans ce cas il ne renseigne que la 3e ligne.</li><li>la 3e ligne représente l'évaluation faite par le formateur habilité ; elle intervient normalement en fin de parcours, lorsque le formateur a jugé que le dossier peut être présenté pour la certification</li><li>Une case rouge indique l'absence d'évaluation, ou une évaluation \"non acquis\"</li><li>Une case verte indique une compétence acquise.</li><li>Une case de couleur intermédiaire indique une compétence en cours d'acquisition.</li></ul></div>",
	
	// Settings
	'dossierdepreuve:settings' => "Paramétrages du dossier de preuve",
	'dossierdepreuve:settings:referentiels' => "Choix du référentiel",
	'dossierdepreuve:settings:referentiel:b2iadultes' => "Référentiel B2i adultes",
	'dossierdepreuve:settings:referentiel:b2iadultes:help' => "Définition de la structure du référentiel, sous la forme de la liste des numéros des compétences, pour chaque domaine, sous la forme suivante, par ex. pour le B2i adultes : 1,2,3,4;1,2,3,4;1,2,3;1,2,3,4;1,2,3",
	'dossierdepreuve:settings:referentiels:help' => "Choisissez le référentiel à configurer. Si vous changez de référentiel, les valeurs précédemment enregistrées seront conservées, mais ne seront plus affichées.",
	'dossierdepreuve:settings:referentiel:domaines' => "Liste des domaines",
	'dossierdepreuve:settings:referentiel:competences' => "Liste des compétences",
	// Infos sur le référentiel
	'dossierdepreuve:referentiel:info' => "Le référentiel comporte %s compétences réparties en %s domaines.<br /><br />",
	'dossierdepreuve:referentiel:infotype' => "Si vous souhaitez un positionnement complet, vous devez répondre à toutes les questions de tous les domaines.<br />Vous pouvez répondre dans l'ordre de votre choix, et modifier vos réponses autant que vous le souhaitez. Pour changer de domaine, utilisez les flèches ou cliquez sur l'onglet correspondant au domaine de votre choix.<br />Quand vous avez terminé, cliquez sur le bouton \"Enregistrer mes réponses et afficher les résultats\" tout en bas du questionnaire.<br /><br />Vous pouvez faire une auto-évaluation partielle, en ne répondant qu'aux questions correspondant aux compétences et aux domaines de votre choix.",
	// Vous avez choisi le questionnaire &laquo;&nbsp;%s&nbsp;&raquo;.<br />
	'dossierdepreuve:domaineselection' => "Choix des domaines.",
	'dossierdepreuve:domaineselection:help' => "Le test de positionnement peut être passé en entier, en répondant à l'ensemble des questions.<br />Pour ne passer qu'une partie du test, rien de plus simple : renseignez seulement les domaines ou les compétences sur lesquelles vous souhaitez vous positionner !<br />Pour commencer, cliquez sur \"Commencer le test\" ci-dessous.",
	'dossierdepreuve:referentiel:infoselection' => "Ce questionnaire porte sur %s domaines&nbsp;: ",
	// Seuils
	'dossierdepreuve:settings:thresholds' => "Seuils",
	'dossierdepreuve:settings:thresholds:help' => "Les résultats du test d'autopositionnement ne produisent pas de résultat discrétisé (0, ou 50, ou 100) mais des valeurs intermédiaires. Les seuils suivants permettent de déterminer comment interpréter un résultat intermédiaire entre Non acquis / En cours d'acquisition / Acquis. Le niveau intermédiaire est bien évidemment situé entre les seuils haut et bas.",
	'dossierdepreuve:settings:threshold_low' => "Seuil bas",
	'dossierdepreuve:settings:threshold_low:help' => "Seuil en dessous duquel une compétence ou un domaine sont considérés comme \"Non acquis\" (strictement inférieur à...).",
	'dossierdepreuve:settings:threshold_high' => "Seuil haut",
	'dossierdepreuve:settings:threshold_high:help' => "Seuil en dessus duquel une compétence ou un domaine sont considérés comme \"Acquis\" (supérieur ou égal à...)",
	'dossierdepreuve:settings:threshold_validation' => "Seuil de validation",
	'dossierdepreuve:settings:threshold_validation:help' => "Ce seuil permet de déterminer à partir de quel note ou score on considère qu'une compétence est validé.",
	// Report strings
	'dossierdepreuve:results' => 'Résultats',
	'dossierdepreuve:results:title' => "Résultats du test du positionnement",
	'dossierdepreuve:results:sendbymail' => 'Recevoir mes résultats par email',
	'dossierdepreuve:results:sendbymail:help' => "Vous pouvez choisir de recevoir vos résultats par email&nbsp;: pour cela merci d'indiquer votre adresse email ci-dessous, puis de cliquer sur le lien \"Terminer (et recevoir mes résultats par email)\".",
	'dossierdepreuve:results:updatedata' => "Mise à jour de mon dossier de suivi",
	'dossierdepreuve:results:updatedatatitle' => "Pour mettre à jour votre dossier de suivi, cliquez sur le lien ci-dessous. Seules les résultats indiqués ci-dessus seront mis à jour.",
	'dossierdepreuve:results:updatedatalink' => "Mettre à jour mon dossier de suivi avec ces informations",
	'dossierdepreuve:results:updatedata:confirm' => "Attention : êtes-vous sûr de vouloir mettre à jour votre dossier de suivi avec les informations ci-dessus ? Vous ne pourrez pas annuler ette action.",
	'dossierdepreuve:results:updatedata:help' => "Si vous souhaitez aussi recevoir les résultations par mail, veuillez commerncer par mettre à jour votre dossier de preuve !",
	'dossierdepreuve:results:updatedatalink:newwindow' => "Mettre à jour mon dossier de suivi avec ces informations (nouvelle fenêtre)",
	'dossierdepreuve:results:sendbymail:description' => "Vous pouvez choisir de recevoir ces résultats par email&nbsp;: pour cela merci d'indiquer votre adresse email ci-dessous.",
	'dossierdepreuve:results:done' => "Ce questionnaire d'autopositionnement est maintenant terminé.",
	'dossierdepreuve:report:email' => "Email utilisé pour l'envoi des résultats du questionnaire : %s<br />",
	'dossierdepreuve:report:confirmsend' => "Etes-vous sûr de vouloir terminer le questionnaire et afficher vos résultats ? Vous ne pourrez plus revenir en arrière : si vous voulez continuer à répondre pour d'autres domaines, veuillez Annuler puis utiliser les flèches ou les onglets. Si vous avez terminé, vosu pouvez confirmer.",
	'dossierdepreuve:auto:datacleared' => "Données du questionnaire effacées.",
	'dossierdepreuve:auto:previousdomain' => "Domaine précédent",
	'dossierdepreuve:auto:previousdomainnum' => "Domaine précédent : domaine %s",
	'dossierdepreuve:auto:previousdomaintitle' => "Domaine de compétences précédent",
	'dossierdepreuve:auto:nextdomain' => "Domaine suivant",
	'dossierdepreuve:auto:nextdomainnum' => "Domaine suivant : domaine %s",
	'dossierdepreuve:auto:nextdomaintitle' => "Domaine de compétences suivant",
	'dossierdepreuve:report:comp:nonacquis' => '<span style="color:darkred;">Non acquis</span>',
	'dossierdepreuve:report:comp:acquis' => '<span style="font-weight:bold; color:darkgreen;">Acquis</span>',
	'dossierdepreuve:report:comp:encours' => '<span style="color:darkorange;">En cours d\'acquisition</span>',
	'dossierdepreuve:report:answered' => "Vous avez répondu à %s questions pour ce domaine",
	'dossierdepreuve:report:domainaverage' => ", soit un score moyen sur le domaine de %s%.",
	'dossierdepreuve:report:domaincompvalidation' => "<strong>Vous pouvez actuellement valider %s des %s compétences de ce domaine.</strong>",
	'dossierdepreuve:report:domainpos' => "Positionnement pour le domaine %s&nbsp;: ",
	'dossierdepreuve:report:totalanswered' => "Vous avez répondu à %s des %s questions de ce test d'autopositionnement.<br />",
	'dossierdepreuve:report:totalaverage' => "Votre positionnement moyen sur %s des %s domaines est de %s%<br />",
	'dossierdepreuve:report:totalvalidation' => "<strong>D'après vos réponses, vous pouvez actuellement valider %s des %s domaines du référentiel (%s des %s compétences).</strong><br />",
	'dossierdepreuve:report:totalvalidation:partial' => "<strong>D'après vos réponses, vous pouvez actuellement valider %s des %s domaines du référentiel (%s des %s compétences). Ce résultat est toutefois incomplet et n'utilise que vos réponses.</strong><br />",
	'dossierdepreuve:report:totalvalidation:toopartial' => "<strong>Vous pouvez actuellement valider %s compétences (sur %s), mais avez répondu à trop peu de questions pour un résultat fiable sur l'ensemble du référentiel.</strong><br />",
	// Mails & messages
	'dossierdepreuve:msg:subject' => "Test d'autopositionnement B2i adultes",
	'dossierdepreuve:msg:message' => "Vous venez de terminer votre questionnaire d'autopositionnement de la plateforme des Compétences Numériques.<br />Comme vous l'avez demandé, voici les résultats de votre test. Ceux-ci ne sont pas conservés sur la plateforme et restent anonymes.<br />Si vous le souhaitez, vous pouvez utiliser ou transmettre à votre formateur le code présent en fin de mail pour reprendre votre questionnaire dans l'état où vous l'aviez laissé.",
	'dossierdepreuve:msg:restoredata' => "Données à utiliser pour restaurer votre autopositionnement sur le site, ou mettre à jour votre dossier de preuve avec ces informations :",
	'dossierdepreuve:msg:thanks' => "Merci d'avoir utilisé l'outil de positionnement de Compétence Numériques !<br />Vous pouvez le recommander en envoyant ce lien aux personnes que cela pourrait intéresser :",
	'dossierdepreuve:msg:success' => "Un mail de synthèse a bien été envoyé à %s",
	'dossierdepreuve:msg:error' => "Une erreur est survenue : le rapport n'a pas pu être envoyé à %s !",
	'dossierdepreuve:msg:invalidmail' => "Adresse email invalide : %s",
	'dossierdepreuve:dossierfound' => "Le bon dossier de preuve a pu être retrouvé automatiquement.",
	'dossierdepreuve:invalid' => "Le dossier spécifié est invalide.",
	'dossierdepreuve:nowriteaccess' => "Vous n'avez pas accès en écriture à ce dossier de preuve. Pour avoir accès en écriture, vous devez être soit le candidat qui a créé le dossier, soit un formateur de son groupe de formation.",
	
	
	
	// Pages
	'dossierdepreuve:all' => "Toutes les dossiers de preuve",
	'dossierdepreuve:inscription' => "Inscription des candidats",
	'dossierdepreuve:export' => "Exporter le dossier de preuve et de suivi",
	
	// Widgets
	'dossierdepreuve:widget:title' => "Dossiers de preuve",
	'dossierdepreuve:widget:description' => "Affiche les dossiers de preuve de vos groupes.",
	'dossierdepreuve:widget:mydossier:title' => "Mon Dossier de preuve",
	'dossierdepreuve:widget:mydossier:description' => "Affiche votre dossier de preuve.",
	'dossierdepreuve:widget:friends:title' => "Contacts",
	'dossierdepreuve:widget:friends:description' => "Affiche vos contacts de formation, au choix et selon votre profil : tous, candidats, formateurs, et centres de rattachement.",
	'dossierdepreuve:friends:scope' => "Types de contacts à afficher",
	'dossierdepreuve:widget:scope:all' => "Tous mes contacts",
	'dossierdepreuve:widget:scope:learners' => "Candidats",
	'dossierdepreuve:widget:scope:tutors' => "Formateurs et Habilitateurs",
	//'dossierdepreuve:widget:scope:organisations' => "Centres agrées",
	'dossierdepreuve:widget:scope:organisations' => "Centre(s) de rattachement",
	'dossierdepreuve:widget:group_select' => "Choix du groupe",
	
	// Group tool
	'dossierdepreuve:groupenable' => "Afficher les Dossiers de preuve des apprenants ?",
	'dossierdepreuve:none' => "Aucun dossier de preuve.",
	'dossierdepreuve:nodossier' => "Pas de dossier de suivi.",
	'dossierdepreuve:group' => "Dossiers de suivi",
	'dossierdepreuve:add' => "Créer mon dossier",
	
	// Actions
	'dossierdepreuve:new' => "Créer un nouveau dossier pour %s",
	'dossierdepreuve:edit' => "Mise à jour du dossier de %s",
	'dossierdepreuve:update' => "Mettre à jour le dossier",
	'dossierdepreuve:save' => "Enregistrer",
	'dossierdepreuve:start' => "Commencer le test",
	'dossierdepreuve:next' => "Enregistrer mes réponses et afficher les résultats",
	'dossierdepreuve:next:details' => "Pour passer d'un domaine à l'autre, utilisez les flèches ou les onglets en haut de page. Lorsque vous avez terminé, vous pouvez cliquer sur le bouton ci-dessous pour afficher vos résultats. Vous pourrez alors choisir de les recevoir par email.",
	'dossierdepreuve:sendupdate' => "Terminer (et recevoir mes résultats par email)",
	'dossierdepreuve:sendonly' => "Terminer (et recevoir mes résultats par email)",
	'dossierdepreuve:finish' => "Envoyer les résultats par email",
	'dossierdepreuve:restore' => "Restaurer le positionnement",
	'dossierdepreuve:saved' => "Mise à jour du dossier enregistrée",
	'dossierdepreuve:savefailed' => "L'enregistrement du dossier a échoué ; vous pouvez essayer de renvoyer le formulaire, ou de ré-éditer le dossier.",
	'dossierdepreuve:delete:confirm' => "Confirmez-vous la suppression de ce dossier ?",
	'dossierdepreuve:deleted' => "le dossier a bien été supprimé",
	
	
	// Edit form & field names
	// Dossier de preuve
	'dossierdepreuve:title' => "Titre (nom du dossier)", 
	'dossierdepreuve:title:help' => "", 
	'dossierdepreuve:status' => "Statut du dossier", 
	'dossierdepreuve:status:help' => "Statut du dossier de preuve : en cours de formation, clôturé, etc. à définir plus en détail (validé, refusé, etc.).", 
	'dossierdepreuve:status:open' => "Ouvert (en cours de formation)", 
	'dossierdepreuve:status:closed' => "Fermé (pas en formation)", 
	'dossierdepreuve:typedossier' => "Type de dossier de preuve", 
	'dossierdepreuve:typedossier:help' => "Certification, brevet, diplôme ou dispositif concerné par ce dossier de preuve. Un seul dossier de suivi peut être créé pour chacun.", 
	'dossierdepreuve:description' => "Description", 
	'dossierdepreuve:description:help' => "Une description du dossier", 
	'dossierdepreuve:readaccess' => "Accès en lecture",
	'dossierdepreuve:writeaccess' => "Accès en écriture",
	'dossierdepreuve:referentiel:selecthelp' => "Sélectionnez les compétences mises en oeuvre dans votre publication. Elles apparaîtront dans votre dossier de suivi.",
	
	
	// Test d'auto-positionnement : éléments du formulaire
	'dossierdepreuve:auto:title' => "Test d'auto-positionnement B2i adultes",
	'dossierdepreuve:auto:public:disclaimer' => "Ce test de positionnement s'améliore grâce à vos retours ! N'hésitez pas à faire part de vos remarques, suggestions, corrections à <a href=\"mailto:contact@formavia.fr\">contact@formavia.fr</a> !",
	'dossierdepreuve:auto:warning' => "Si votre centre vous a fourni un compte sur la plateforme, pensez à <a href=\"" . $url . "login\">vous connecter maintenant</a>.",
	'dossierdepreuve:auto:new' => "Test d'auto-positionnement",
	'dossierdepreuve:auto:description' => "Ce test permet de savoir où vous en êtes par rapport au référentiel national de compétences B2i adultes. En répondant à quelques questions, auto-évaluez vos compétences numériques et identifiez ainsi vos axes d'amélioration.<br /><br />Utilisez ce test librement, renseignez-le en totalité ou pas, et recevez vos résultats par mail si vous le souhaitez.",
	'dossierdepreuve:auto:contact_email' => "Votre adresse email",
	'dossierdepreuve:auto:contact_email:help' => "Facultatif, uniquement si vous souhaitez recevoir vos résultats par mail.<br /><em>Note&nbsp;: vous pouvez envoyer les résultats à plusieurs adresses email, en les séparant par des ';')</em>",
	'dossierdepreuve:auto_type' => "Choix du test d'autopositionnement",
	'dossierdepreuve:auto_type:help' => "", 
	// "Vous voulez savoir où vous en êtes en quelques clics, ou vous positionner précisément ? Choisissez le test le plus utile dans votre cas !",
	'dossierdepreuve:auto_type:full' => "Autopositionnement complet (fiable, 15 à 30 minutes)",
	'dossierdepreuve:auto_type:random' => "Autopositionnement rapide (approximatif, 1 question au hasard par compétence)",
	'dossierdepreuve:auto_type:limited' => "Autopositionnement limité (choix des domaines à autoévaluer)",
	'dossierdepreuve:auto_type:googleform' => "Questionnaire Google (positionnement sans rapport d'évaluation)",
	'dossierdepreuve:auto_type:googleform:clickopen' => "Cliquez ici pour ouvrir le questionnaire Google dans une nouvelle fenêtre",
	'dossierdepreuve:auto_type:googleform:help' => "Ce questionnaire ne vous permet pas de sauvegarder vos résultats ni de mettre à jour votre dossier de suivi, mais peut être utilisé indépendament pour vous donner quelques pistes en fonction de vos réponses.",
	'dossierdepreuve:auto:myowneval' => '<strong>=> Mon positionnement </strong>',
	//'dossierdepreuve:auto:questionlabel' => "<strong>Question n°%s&nbsp;: </strong> %s<br />",
	'dossierdepreuve:auto:questionlabel' => '%2$s',
	'dossierdepreuve:report:questionlabel' => "<strong> - Question n°%s&nbsp;:</strong> %s<br />",
	'dossierdepreuve:report:noeval' => "<strong>Question n°%s&nbsp;:</strong> (pas de positionnement)<br />",
	'dossierdepreuve:report:compeval' => "Positionnement sur cette compétence&nbsp;: %s ",
	
	'dossierdepreuve:auto_type:restore_history' => "Restauration d'un questionnaire d'autopositionnement précédent",
	'dossierdepreuve:auto:restore:instructions' => "Coller ici le code que vous avez conservé ou reçu par mail. Votre questionnaire de positionnement sera restauré dans l'état où vous l'avez laissé.",
	'dossierdepreuve:auto:update_dossier' => "Mettre à jour mon positionnement dans le dossier de suivi ?",
	'dossierdepreuve:update_dossier:yes' => "Oui, mettre à jour mon dossier de suivi avec ces résultats",
	'dossierdepreuve:update_dossier:no' => "Non, je ne veux pas utiliser ces données pour modifier mon autopositionnment",
	'dossierdepreuve:auto:send_email' => "Envoyer un email avec ces résultats ?",
	'dossierdepreuve:send_email:yes' => "Oui, envoyer ces résultats par email",
	'dossierdepreuve:send_email:no' => "Non, aucun mail, merci (attention&nbsp;: ces résultats seront effacés)",
	'dossierdepreuve:auto:clearandrestart' => "Supprimer toutes les données et recommencer au début",
	'dossierdepreuve:auto:clear:confirm' => "Etes-vous sûr de vouloir recommencer ? Toutes vos réponses seront perdues.",
	'dossierdepreuve:auto:restorecode' => "Code de sauvegarde",
	'dossierdepreuve:auto:restorecode:help' => "<strong>Utilisation&nbsp;:</strong> copiez-collez ce code et conservez-le si vous souhaitez pouvoir revenir à cette page précise du test de positionnement (attention&nbsp;: les modifications que vous venez de faire sur cette page ne sont pas conservées).<br />Pour restaurer un questionnaire sauvegardé, choisissez \"Restauration d'un questionnaire précédent\" lors du choix du questionnaire, puis collez ce code.",
	

	// Types des profils
	'dossierdepreuve:profile_type:others' => "Autres types de profils",
	'dossierdepreuve:profile_type:' => "Non défini / Aucun type de profil spécifique",
	'dossierdepreuve:profile_type:none' => "Aucun type de profil spécifique",
	'dossierdepreuve:profile_type:learner' => "Candidat",
	'dossierdepreuve:profile_type:tutor' => "Formateur",
	'dossierdepreuve:profile_type:evaluator' => "Habilitateur",
	'dossierdepreuve:profile_type:other_administrative' => "Autres et administration",
	'dossierdepreuve:profile_type:organisation' => "Centre agréé",
	// Internationalisation pour profile_manager
	'profile:types:admin' => "Administrateur",
	'profile:types:admin:description' => "Les administrateurs de la plateforme.",
	'profile:types:learner' => "Candidat",
	'profile:types:learner:description' => "Un Candidat est en cours d'acquisition des compétences du B2i adultes. Il est pour cela membre d'un groupe de formation et sous la responsabilité d'un formateur.",
	'profile:types:tutor' => "Formateur",
	'profile:types:tutor:description' => "Un Formateur est en charge de candidats, regroupés au sein d'un ou de plusieurs groupes de formation.<br />Il est rattaché à une organisation (centre agréé).",
	'profile:types:evaluator' => "Habilitateur",
	'profile:types:evaluator:description' => "Formateur habilité à valider les compétences du B2i adultes.",
	'profile:types:other_administrative' => "Autres et administration",
	'profile:types:other_administrative:description' => "Autres membres hors-formation : gestion administrative, animation globale et tous les profils particuliers qui ne sont pas liés directement à la formation et à la certification au B2i.",
	'profile:types:organisation' => "Centre agréé",
	'profile:types:organisation:description' => "Un centre agréé est une structure agréée pour la délivrance des formations et la constitution de dossiers de preuves qui pourront être soumis à la certification par la DAFCO.<br />Elle a le droit de créer des groupes de formation, et d'y nommer des responsables (formateurs et habilitateurs).",

	// Types de groupes
	'dossierdepreuve:learner_group:invalid' => "Ce groupe de formation n'existe pas ou plus. Merci de choisir un autre groupe de formation.",
	'dossierdepreuve:learner_group:none' => "Aucun groupe de formation",
	'dossierdepreuve:learner_group:none:help' => "Si vous êtes inscrit pour une formation, vous devriez rejoindre votre groupe. Pour cela cliquez sur le bouton ci-dessous, et cherchez votre groupe. Si vous ne le connaissez pas, demandez à votre formateur.",
	'dossierdepreuve:groups:join' => "Affichez les groupes de formation.",
	
	
	// Edition des membres (types de profils, groupes pour les apprenants)
	'dossierdepreuve:gestion:help' => "Cette page permet de modifier les profils des membres, et d'affecter les apprenants dans leur groupe de formation.<br />Seuls les admins peuvent modifier le profil des membres.",
	'dossierdepreuve:noaccess' => "Désolé, vous n'avez pas accès à cette page.",
	'dossierdepreuve:error:invaliduser' => "Membre inexistant ou invalide",
	'dossierdepreuve:error:onlyforlearners' => "Les dossiers de suivi ne peuvent être créés que pour des candidats.",
	'dossierdepreuve:error:ownonly' => "Vous ne pouvez modifier que vos propres informations",
	'dossierdepreuve:error:cantedit' => "Désolé, vous n'avez pas les droits pour modifier ce dossier de suivi.",
	'dossierdepreuve:error:adminonly' => "Seul un administrateur peut supprimer un dossier de suivi.",
	'dossierdepreuve:ajax:error:reload' => "Erreur d'enregistrement, veuillez recharger la page et réessayer.",
	'dossierdepreuve:inscription' => "Inscription de nouveaux comptes",
	'dossierdepreuve:inscription:help' => "Selon votre profil, vous pouvez créer différents types de comptes utilisateur :<ul><li>Les formateurs et habilitateurs peuvent créer les comptes des candidats.</li><li>Les organisations peuvent créer les comptes des habilitateurs, formateurs et candidats</li><li>Seul un administrateur peut créer les comptes des organisations.</li></ul>Vous pouvez choisir d'inscrire automatiquement les nouveaux comptes dans un groupe dont vous êtes membre ou propriétaire.<br />Enfin vous pouvez choisir d'être automatiquement mis en contact avec les nouveaux membres.",
	'dossierdepreuve:profiletype' => "Type de profil",
	'dossierdepreuve:profiletype:help' => "Choisissez le type de profil des personnes que vous inscrivez.",
	'dossierdepreuve:registergroup' => "Inscription automatique dans un groupe",
	'dossierdepreuve:registergroup:help' => "Choisissez le groupe auquel inscrire les nouveaux comptes.",
	'dossierdepreuve:register_emails' => "Liste des emails à inscrire",
	'dossierdepreuve:register_emails:help' => "Ajoutez un email par ligne.",
	'dossierdepreuve:add_contact' => "Mise en contact automatique",
	'dossierdepreuve:add_contact:help' => "Vous pouvez choisir que les nouveaux comptes soient automatiquement déclarés comme vos contacts.",
	'dossierdepreuve:doregister' => "Créer les comptes",
	
	
	// Référentiel
	'dossierdepreuve:referentiel' => "Référentiel B2i adultes",
	'dossierdepreuve:referentiel:domaine' => "Domaine",
	'dossierdepreuve:referentiel:competence' => "Compétence",
	'dossierdepreuve:referentiel:b2i:title' => "Référentiel B2i : positionnement et évaluation",
	'dossierdepreuve:referentiel:legende' => "Légende",
	'dossierdepreuve:referentiel:legende:description' => "Compétences : compétences du référentiel (70% des compétences de chaque domaine doivent être validées).<br />Eléments de compétence : Aptitudes correspondant aux compétences du référentiel.<br />A/NA/EC : Acquis, Non-Acquis, En Cours d'acquisition.<br />URL : lien vers l'élément de preuve justifiant de cet élément de compétence.",
	// Domaine 1
	'dossierdepreuve:referentiel:1' => "Domaine 1",
	'dossierdepreuve:referentiel:1:description' => "ENVIRONNEMENT INFORMATIQUE",
	'dossierdepreuve:referentiel:1:aide' => "Aide",
	'dossierdepreuve:referentiel:1:1' => "Compétence 1.1",
	'dossierdepreuve:referentiel:1:1:description' => "Utiliser le vocabulaire spécifique et maîtriser les éléments matériels et logiciels de base.",
	'dossierdepreuve:referentiel:1:1:aide' => "Reconnaître, nommer et décrire la fonction des éléments de base d'un poste informatique (unité centrale), les périphériques courants, les différents lecteurs, supports de stockage amovibles ou non.<br />Reconnaître les types de connexion (USB, Ethernet, Vidéo, Audio, WIFI, etc).<br />Différencier les différents types de logiciels et leurs fonctions (systèmes d'exploitation, logiciels d'applications).<br />Identifier les familles de logiciels bureautiques, les navigateurs Internet, les logiciels de messagerie, et leurs fonctions.<br />Nommer et utiliser les dispositifs de pointage et de saisie.",
	'dossierdepreuve:referentiel:1:2' => "Compétence 1.2",
	'dossierdepreuve:referentiel:1:2:description' => "Gérer et organiser les fichiers, identifier leurs propriétés et caractéristiques.",
	'dossierdepreuve:referentiel:1:2:aide' => "Distinguer fichiers / dossiers : reconnaître le type de fichier par son icone ou son extension (extensions courantes).<br />Retrouver un logiciel ou un dossier/fichier dans une arborescence.<br />Créer, supprimer, renommer, déplacer, organiser des dossiers/fichiers dans une arborescence cohérente.<br />Enregistrer un fichier.<br />Afficher les propriétés d'un fichier.",
	'dossierdepreuve:referentiel:1:3' => "Compétence 1.3",
	'dossierdepreuve:referentiel:1:3:description' => "Organiser, personnaliser et gérer un environnement informatique.",
	'dossierdepreuve:referentiel:1:3:aide' => "Identifier les éléments graphiques de l'environnement de travail, se repérer dans cet interface, gérer les fenêtres, les icônes.<br />Personnaliser un environnement de travail.<br />Gérer un poste de travail informatique.",
	'dossierdepreuve:referentiel:1:4' => "Compétence 1.4",
	'dossierdepreuve:referentiel:1:4:description' => "Se connecter et s'identifier sur différents types de réseaux.",
	'dossierdepreuve:referentiel:1:4:aide' => "Identifier et différencier les principaux types de réseaux.<br />Maîtriser les paramètres de connexion.<br />Utiliser des périphériques réseaux (imprimante, stockage, scanner).",
	// Domaine 2
	'dossierdepreuve:referentiel:2' => "Domaine 2",
	'dossierdepreuve:referentiel:2:description' => "ATTITUDE CITOYENNE",
	'dossierdepreuve:referentiel:2:aide' => "Aide",
	'dossierdepreuve:referentiel:2:1' => "Compétence 2.1",
	'dossierdepreuve:referentiel:2:1:description' => "Respecter les règles d'usage, connaître les dangers liés aux réseaux et aux échanges de données.",
	'dossierdepreuve:referentiel:2:1:aide' => "Citer les règles propres à l'usage des réseaux et de l'Internet.<br />Lister les dangers liés aux réseaux et aux échanges de données : pistage, violation des droits, confidentialité...<br />Enumérer les protections à employer pour contrer les risques liés aux échanges de données.",
	'dossierdepreuve:referentiel:2:2' => "Compétence 2.2",
	'dossierdepreuve:referentiel:2:2:description' => "Respecter les droits et obligations relatifs à l'utilisation de l'informatique et d'Internet, respecter les droits d'auteur et de propriété.",
	'dossierdepreuve:referentiel:2:2:aide' => "Citer les éléments représentatifs généraux des textes fondamentaux qui régissent l'utilisation de l'informatique et d'internet.<br />Respecter les droits d'auteurs dans l'utilisation des ressources multimédia (texte, image, son) et des logiciels (notion de licence).<br />Connaître les droits et obligations liés à la publication et à l'échange de données.",
	'dossierdepreuve:referentiel:2:3' => "Compétence 2.3",
	'dossierdepreuve:referentiel:2:3:description' => "Protéger les informations concernant sa personne et ses données, construire son identité numérique.",
	'dossierdepreuve:referentiel:2:3:aide' => "Identifier les notions importantes pour sa protection et celle de ses données.<br />Protéger ses créations.",
	'dossierdepreuve:referentiel:2:4' => "Compétence 2.4",
	'dossierdepreuve:referentiel:2:4:description' => "Prendre part à la société de l'information dans ses dimensions administratives et citoyennes.",
	'dossierdepreuve:referentiel:2:4:aide' => "Utiliser les centres de ressources en ligne pour accéder/participer à la culture (musées, bibliothèques, médiathèques, cinémathèques).",
	// Domaine 3
	'dossierdepreuve:referentiel:3' => "Domaine 3",
	'dossierdepreuve:referentiel:3:description' => "TRAITEMENT ET PRODUCTION",
	'dossierdepreuve:referentiel:3:aide' => "Aide",
	'dossierdepreuve:referentiel:3:1' => "Compétence 3.1",
	'dossierdepreuve:referentiel:3:1:description' => "Concevoir un document",
	'dossierdepreuve:referentiel:3:1:aide' => "Préciser les objectifs visés pour la production d'un document numérique.<br />Identifier les différents types de documents numériques, leurs caractéristiques et les logiciels associés.<br />Etablir la meilleure relation entre l'objectif visé, les outils et les ressources (humaines, matérielles, documentaires...) disponibles (faire des choix).",
	'dossierdepreuve:referentiel:3:2' => "Compétence 3.2",
	'dossierdepreuve:referentiel:3:2:description' => "Mettre en œuvre les fonctionnalités de base d'outils permettant le traitement de texte, de nombres, d'images et de sons.",
	'dossierdepreuve:referentiel:3:2:aide' => "Créer, modifier, enregistrer, imprimer, mettre en forme un document.",
	'dossierdepreuve:referentiel:3:3' => "Compétence 3.3",
	'dossierdepreuve:referentiel:3:3:description' => "Réaliser un document composite.",
	'dossierdepreuve:referentiel:3:3:aide' => "Intégrer dans un même document des types de contenus différents.<br />Intégrer des liens hypertextes.<br />Rendre disponible et exploitable un document composite.",
	// Domaine 4
	'dossierdepreuve:referentiel:4' => "Domaine 4",
	'dossierdepreuve:referentiel:4:description' => "RECHERCHE DE L'INFORMATION",
	'dossierdepreuve:referentiel:4:aide' => "Aide",
	'dossierdepreuve:referentiel:4:1' => "Compétence 4.1",
	'dossierdepreuve:referentiel:4:1:description' => "Concevoir une démarche de recherche d'informations et la mettre en œuvre.",
	'dossierdepreuve:referentiel:4:1:aide' => "Identifier les ressources possibles.<br />Catégoriser et choisir les outils de recherche.<br />Choisir les mots‐clés adaptés.<br />Utiliser des fonctionnalités avancées.",
	'dossierdepreuve:referentiel:4:2' => "Compétence 4.2",
	'dossierdepreuve:referentiel:4:2:description' => "Identifier et organiser les informations.",
	'dossierdepreuve:referentiel:4:2:aide' => "Effectuer une première analyse des résultats.<br />Récupérer, organiser, et retrouver l'information.",
	'dossierdepreuve:referentiel:4:3' => "Compétence 4.3",
	'dossierdepreuve:referentiel:4:3:description' => "Évaluer la qualité et la pertinence de l'information.",
	'dossierdepreuve:referentiel:4:3:aide' => "Identifier la source du document.<br />Evaluer la qualité du site et sa navigation.<br />Evaluer l'information trouvée et son adéquation.",
	'dossierdepreuve:referentiel:4:4' => "Compétence 4.4",
	'dossierdepreuve:referentiel:4:4:description' => "Réaliser une veille informationnelle.",
	'dossierdepreuve:referentiel:4:4:aide' => "Réaliser un profil de recherche personnalisé.<br />Créer des alertes informationnelles.",
	// Domaine 5
	'dossierdepreuve:referentiel:5' => "Domaine 5",
	'dossierdepreuve:referentiel:5:description' => "COMMUNICATION",
	'dossierdepreuve:referentiel:5:aide' => "Aide",
	'dossierdepreuve:referentiel:5:1' => "Compétence 5.1",
	'dossierdepreuve:referentiel:5:1:description' => "Utiliser l'outil de communication adapté au besoin.",
	'dossierdepreuve:referentiel:5:1:aide' => "Choisir et utiliser le mode et l'outil adaptés à différentes situations de communication.<br />Communiquer avec le son et l'image.",
	'dossierdepreuve:referentiel:5:2' => "Compétence 5.2",
	'dossierdepreuve:referentiel:5:2:description' => "Échanger et diffuser des documents numériques.",
	'dossierdepreuve:referentiel:5:2:aide' => "Choisir et utiliser un outil de transfert de fichiers.<br />Choisir le format du fichier et adapter sa taille.<br />Configurer et utiliser une messagerie électronique.",
	'dossierdepreuve:referentiel:5:3' => "Compétence 5.2",
	'dossierdepreuve:referentiel:5:3:description' => "Collaborer en réseau",
	'dossierdepreuve:referentiel:5:3:aide' => "Choisir et utiliser un outil collaboratif.<br />Enrichir une base de connaissances.<br />Elaborer un document de manière collective.",
	
	
	// Niveaux de compétence
	'dossierdepreuve:choose' => "(choisir)",
	'dossierdepreuve:nodata' => "(non renseigné)",
	'dossierdepreuve:autopositionnement:' => "(choisir une réponse)",
	'dossierdepreuve:autopositionnement:nodata' => "(non renseigné)",
	'dossierdepreuve:autopositionnement:100' => "Oui",
	'dossierdepreuve:autopositionnement:50' => "Oui un peu",
	'dossierdepreuve:autopositionnement:0' => "Non",
	'dossierdepreuve:currentautopositionnement' => "Votre autopositionnement actuel&nbsp;: ",
	'dossierdepreuve:competence:' => "(choisir)",
	'dossierdepreuve:competence:100' => "Maîtrisé",
	'dossierdepreuve:competence:50' => "En cours",
	'dossierdepreuve:competence:0' => "Non-Maîtrisé",
	
	// Questions du formulaire d'auto-positionnement
	'dossierdepreuve:auto:q1' => "Une première question de positionnement : Savez-vous faire telle ou telle chose, produire tel ou tel document ? &nbsp; (A DEFINIR !!)",
	'dossierdepreuve:auto:q1:help' => "Une aide sur la question : par ex. Réponsez en fonction de ce que vous savez faire...",
	
	
	// Pool de questions B2i adultes : ce serait bien d'automatiser tout ça... 
	// sous forme d'objets ou de quelque chose d'un petit peu configurable au moins (settings..)
	// Donc la liste ci-dessous doit être seulement une liste par défaut, réserve de contenus.
	/*
	Les questions doivent pouvoir être récupérées par domaine seulement, et par compétence, avec une ou plusieurs questions pour chaque.
	Pour chaque compétence, on a les élements de compétence, les savoirs, et les critères qualitatifs et/ou quantitatifs de mesure, soit : elements, savoirs, criteres
	*/
	// ELEMENTS
	'b2iadultes:1:1:elements' => "D111: Reconnaître, nommer et décrire la fonction des éléments de base d’un poste informatique (unité centrale), les périphériques courants, les différents lecteurs, supports de stockage amovibles ou non<br />Reconnaître les types de connexion (USB, Ethernet, Vidéo, Audio,WIFI, etc)
		D112: Différencier les différents types de logiciels et leurs fonctions (systèmes d’exploitation, logiciels d’applications)
		D113: Identifier les familles de logiciels bureautiques, les navigateurs Internet, les logiciels de messagerie, et leurs fonctions
		D114: Nommer et utiliser les dispositifs de pointage et de saisie", 
	'b2iadultes:1:2:elements' => "D122: Retrouver un logiciel ou un dossier/fichier dans une arborescence
		D123: Créer, supprimer, renommer, déplacer, organiser des dossiers/fichiers dans une arborescence cohérente
		D124: Enregistrer un fichier
		D125: Afficher les propriétés d’un fichier", 
	'b2iadultes:1:3:elements' => "D131: Identifier les éléments graphiques de l’environnement de travail, se repérer dans cet interface, gérer les fenêtres, les icônes
		D132: Personnaliser un environnement de travail
		D133: Gérer un poste de travail informatique", 
	'b2iadultes:1:4:elements' => "D141: Identifier et différencier les principaux types de réseaux
		D142: Maîtriser les paramètres de connexion
		D143: Utiliser des périphériques réseaux (imprimante, stockage, scanner)", 
	'b2iadultes:2:1:elements' => "D211: Citer les règles propres à l’usage des réseaux et de l’Internet
		D212: Lister les dangers liés aux réseaux et aux échanges de données : pistage, violation des droits, confidentialité…
		D213: Enumérer les protections à employer pour contrer les risques liés aux échanges de données", 
	'b2iadultes:2:2:elements' => "D221: Citer les éléments représentatifs généraux des textes fondamentaux qui régissent l’utilisation de l’informatique et d’internet.
		D222: Respecter les droits d’auteurs dans l’utilisation des ressources multimédia (texte, image, son) et des logiciels (notion de licence)
		D223: Connaître les droits et obligations liés à la publication et à l’échange de données", 
	'b2iadultes:2:3:elements' => "D231: Identifier les notions importantes pour sa protection et celle de ses données
		D232: Protéger ses créations", 
	'b2iadultes:2:4:elements' => "D241: Utiliser les centres de ressources en ligne pour accéder/participer à la culture (musées, bibliothèques, médiathèques, cinémathèques)", 
	'b2iadultes:3:1:elements' => "D311: Préciser les objectifs visés pour la production d’un document numérique
		D312: Identifier les différents types de documents numériques, leurs caractéristiques et les logiciels associés
		D313: Etablir la meilleure relation entre l’objectif visé, les outils et les ressources (humaines, matérielles, documentaires …) disponibles (faire des choix)", 
	'b2iadultes:3:2:elements' => "D321: Créer, modifier, enregistrer, imprimer, mettre en forme un document", 
	'b2iadultes:3:3:elements' => "D331: Intégrer dans un même document des types de contenus différents
		D332: Intégrer des liens hypertextes
		D333: Rendre disponible et exploitable un document composite", 
	'b2iadultes:4:1:elements' => "D411: Identifier les ressources possibles
		D412: Catégoriser et choisir les outils de recherche
		D413: Choisir les mots‐clés adaptés
		D414: Utiliser des fonctionnalités avancées", 
	'b2iadultes:4:2:elements' => "D421: Effectuer une première analyse des résultats
		D422: Récupérer, organiser, et retrouver l’information", 
	'b2iadultes:4:3:elements' => "D431: Identifier la source du document
		D432: Evaluer la qualité du site et sa navigation
		D433: Evaluer l’information trouvée et son adéquation", 
	'b2iadultes:4:4:elements' => "D441: Réaliser un profil de recherche personnalisé
		D442: Créer des alertes informationnelles", 
	'b2iadultes:5:1:elements' => "D511: Choisir et utiliser le mode et l’outil adaptés à différentes situations de communication
		D512: Communiquer avec le son et l’image
		D513: Configurer et utiliser une messagerie électronique", 
	'b2iadultes:5:2:elements' => "D521: Choisir et utiliser un outil de transfert de fichiers
		D522: Choisir le format du fichier et adapter sa taille", 
	'b2iadultes:5:3:elements' => "D531: Choisir et utiliser un outil collaboratif
		D532: Enrichir une base de connaissances : forum, Plateforme, site collaboratif
		D533: Elaborer un document de manière collective", 
	
	// SAVOIRS
	'b2iadultes:1:1:savoirs' => "D111 ... différencier les différents équipements (smartphone, tablette, ordinateur, netbook...)<br />... reconnaître : Disque dur, Clé USB, carte/ microSD<br />.... à quoi sert l'imprimante / le scanner...<br />... brancher sur mon ordinateur : une imprimante, une souris, une clé, un casque audio, <br />... raccorder mon ordinateur à une télé /écran / vidéoprojecteur <br />... je connais plusieurs modes de connexion (ethernet, wifi, bluetooth, CPL, 3G...)
		D112 ... je connais la différence entre un système d'exploitation et un programme/logiciel/application <br />... installer un programme, une application
		D113 je sais chercher un logiciel bureautique lorsque j'ai besoin de créer un document<br />je sais ouvrir un navigateur lorsque j'ai besoin d'aller sur internet<br />je sais ouvrir un logiciel de messagerie (webmail) pour consulter mes mails
		D114 ... connaître les différentes formes que prend le pointeur<br />... utiliser les fonctions principales du clavier (minuscules/majuscules, Supprimer, je connais quelques raccourcis clavier)<br />... sélectionner, déplacer un objet à l'écran, lancer une application/logiciel", 
	'b2iadultes:1:2:savoirs' => "D122 savoir reconnaître un fichier et un dossier
		D123 organiser mon arborescence
		D124 je connais une démarche pour enregistrer (fichier >enregistrer ou ctrl S ou...etc)
		D125 je connais une démarche pour afficher les propriétés", 
	'b2iadultes:1:3:savoirs' => "D131 ...repérer les fenêtres et les icones fermer, niveau inférieur, réduire
		D132 ...ranger son bureau<br />... créer des raccourcis (dossiers / logiciels)<br />... paramétrer sa barre des tâches (lancement rapide)<br />... changer son fond d'écran<br />... modifier le menu démarrer selon ses besoins
		D133 ...installer / désinstaller une application<br />...savoir sauvegarder", 
	'b2iadultes:1:4:savoirs' => "D141 citer différents moyens de connexion à internet
		D142 ... créer un identifiant (pseudo) et un mot de passe sécurisé / je sais m'identifier avec un compte, me déconnecter, modifier les paramètres de mon compte utilisateur
		D143 ...choisir l'imprimante, le scanner dont j'ai besoin // choisir l'espace (C, CD, USB) où j'enregistre mon fichier/dossier <br />... reconnaître : Disque dur, Clé USB, carte/ microSD", 
	'b2iadultes:2:1:savoirs' => "D211  ... me soucier du poids des fichiers attachés, quand j'envoie des pièces jointes dans un email, <br />... masquer leurs adresses quand j'écris à plusieurs destinataires, <br />... consulter les règles d'utilisation quand je communique dans un espace de groupe comme un forum
		D212  ... que je laisse des traces même sans rien écrire<br />... ce que sont une adresse IP et des cookies<br />... comment un virus peut se propager<br />...ce qu'est une \"chaine\" et comment éviter de contribuer au spam<br />... les possibilités d'escroqueries possibles et sais être prudent
		D213 ... si le site est sécurisé ou non lors d'un achat sur Internet,<br />... à quoi sert un pare feu (firewall)<br />... je connais la différence entre virus, spyware et spam et comment me protéger", 
	'b2iadultes:2:2:savoirs' => "D221 je connais les principes d'Hadopi... <br />...je sais à qui m'adressse en cas de problème (données perssonnelles avec la CNIL), (xxx pour une réclamation e-commerce)
		D222 ...Je sais installer et utiliser des ressoures libres <br />...je sais faire la différence avec des ressources propriétaires (texte, image, sons). <br />... Je connais la différence entre Creative Commons et Copyright. <br />.... Je connais les avantages de l'un par rapport à l'autre
		D223 je sais ce que j'ai le droit de diffuser sur internet dans le respect de la loi....<br />...je connais le droit du travail et surveillance éléctronique<br />.... je comprend les chartes informatiques<br />.... Je connais les risques à télécharger une oeuvre protéger (ex : P2P)", 
	'b2iadultes:2:3:savoirs' => "D231 ... Je sais reconnaitre un site sécurisé<br />... j'utilise des mots de passe sécurisé<br />... Je sais repérer les arnaques (spams, phishing, etc.) et se protéger
		D232 ...Je sais mettre ma crétaion sous licence Creative Commons<br />... Je sais enregistrer un document au format PDF<br />... Je sais changer des droits d'accès à un document ou à un espace (ex : google doc, formavia)", 
	'b2iadultes:2:4:savoirs' => "D241 ... Je sais créer un profil sur Pole emploi, mettre mon CV en ligne, remplir un formulaire<br />... je connais le site de ma ville (ou département, région) et les services proposés (e-administration, débat citoyen) <br />... Je sais suivre le travail de mon enfant sur le cahier de texte de l'ENT<br />... Je sais valoriser mon dossier de preuves B2I / ePortfolio <br />... Je participe à une visite de musées en ligne", 
	'b2iadultes:3:1:savoirs' => "D311 ... choisir le logiciel le plus adapté pour faire mon document
		D312 Je sais utiliser un logiciel de traitement de texte<br />... utiliser un tableur<br />... utiliser un logiciel de traitement d'images (recadrer, redimensionner, modifier son poids...)<br />... modifier un son, une vidéo (montage, partage...)
		D313  je dois faire une candidature pour un cv : quels outils (word, paint, libre office), comment je le sauvegarde, comment je l'envoi. Définir le but de ma production", 
	'b2iadultes:3:2:savoirs' => "D321 ... créer un document numérique<br />... ouvrir un document existant<br />... modifier et enregistrer un document<br />... imprimer un document", 
	'b2iadultes:3:3:savoirs' => "D331 ...dans un document texte, je sais intégrer au moins 3 des éléments suivants : images, tableaux, liens hypertextes, graphiques
		D332 ... dans un diaporama  je sais intégrer au moins 3 des éléments suivants : des images, des tableaux, des liens hypertextes, des vidéos ou du son
		D333 ... je sais exporter un document en pdf // convertir un document d'une version recente en version ancienne // convertir un document open office en microsoft office", 
	'b2iadultes:4:1:savoirs' => "D411 .... sur support : je sais faire des recherches sur un CD-DVD, utiliser le menu, revenir en arrière...<br />... je fais la différence entre navigateurs et moteur de recherches, je suis capable d'en citer<br />...je sais comment faire pour aller sur un site sans passer par un moteur de recherche<br />...j'utilise souvent les onglets<br />... je sais naviguer sur les pages<br />... je sais reconnaitre les éléments cliquables sur ma page
		D412 choisir un moteur de recherche en fonction de mes thématiques de recherche (générique ou spécifique)
		D413 je sais utiliser des mots-clés
		D414 ....utiliser dans ma recherche des guillemets, symbole *, des operateurs logique + - pour affiner ma recherche", 
	'b2iadultes:4:2:savoirs' => "D421 dès la liste de résultat je sais quels sites seront pertinents
		D422 ... créer un favori / marque-page pour le site qui m'interresse // copier, enregistrer une image issue du web ///selectionner une partie du texte de la page web // je sais imprimer une page web ou une partie // télécharger un fichier issu d'une page web // j'utilise l'historique de navigation pour retrouver le site où j'étais la veille ", 
	'b2iadultes:4:3:savoirs' => "D431 quand je suis sur un site j'identifie l'auteur du site, la date de mise à jour, le pays du site
		D432 distinguer un site web institutionnel, commercial ou personnel // je sais distinguer un site d'un blog ou d'un forum // utiliser les moteurs de recherche propre au site web (sur le site de la Fnac, ou catalogue bibliothèque...)
		D433 je sais que toutes les informations sur le web ne sont pas toutes vraies et actuelles, je sais garder un esprit critique face à l'information recueillie", 
	'b2iadultes:4:4:savoirs' => "D441 créer un profil de recherche sur les site d'emploi, de logement ou marchand (ebay, cdiscount...)
		D442 m'abonner à une newsletter // créer une alerte mail", 
	'b2iadultes:5:1:savoirs' => "D511 ....qu'il existe différents moyens pour communiquer comme : <br />                - le chat pour discuter en instanté (ex : msn)<br />                - la messagerie mail pour envoyer un message en différé (ex : un mail)<br />                - l'appel vidéo ou téléphonique pour joindre un personne ou un groupe (ex : skype, googlecam)<br />                - les réseaux sociaux pour publier, partager des événements et commenter ceux de mes amis (ex : facebook, copain d'abord)<br />.... utiliser :  <br />                - le chat,     <br />                - des forums,<br />                - une boite mail<br />                - les réseaux sociaux,<br />                - la  vidéoconférence (appel à distance)
		D512 ... utiliser une webcam ou la vidéoconférence, réaliser une vidéo avec son téléphone, la publier en ligne : youtube ou autre, utiliser Skype, utiliser Google Hangout, enregistrer un message oral, le publier ou l'envoyer
		D513 - j'ai créé moi même ma messagerie sur le web et je peux y accéder de n'importe quel ordinateur<br />- j'ai réussi intégrer une signature automatique / une image (ex : logo) dans le paramètre de mon compte<br />- je gère mes mails avec des libéllés ou des dossiers : lus, non lu, indesirable, important etc...<br />- je sais créer un nouveau contact<br />- je sais créer un groupe de contact (une liste de diffusion)<br />- je sais répondre à un message à un destinataire unique<br />je sais envoyer un message à plusieurs destinataire<br />- je sais envoyer et réceptionner un message avec une pièce jointe et l'enregistrer<br />- je sais transférer un message<br />- je sais rechercher et retrouver un mail<br />- je sais configurer un logiciel de messagerie : outlook ou thunderbird<br />- je sais paramétrer plusieurs comptes de messagerie", 
	'b2iadultes:5:2:savoirs' => "D521 - Mettre sur un site ou un blog un fichier // je sais comment transférer des gros fichiers sans passer par ma boite mail : wetransfer, dropbox, FTP, espace réservé de mon fournisseur d'accès<br />Echanger, partager des photos sur Picasa ou Flickr en public ou réservé<br />- Televerser une vidéo sur Youtube, définir les options de partage<br />- Televerser son CV en ligne sur un site de recherche d'emploi
		D522 Différencier les formats de fichiers les plus courants<br />enregistrer un fichier dans le format (pdf, jpeg, rtf,,) demandé sur le site // si le fichier est trop gros, je sais réduire son poids<br />Utiliser un outil de compression<br />Choisir le format dans le logiciel dans lequel je travaille<br />Exporter ou importer un fichier", 
	'b2iadultes:5:3:savoirs' => "D531 - utiliser un calendrier partagé avec un autre groupe d'amis, d'utilisateurs<br />- utiliser un espace numérique pour mes études ou ma formation : EPN, plateforme FOAD,  <br />- faire un travail collaboratif en ligne avec des outils adaptés : framapad, wiki, carte mentale, doodle, Google Drive, Sky Drive <br />- utiliser un forum, un blog
		D532 Mettre un message sur un forum, ecrire un commentaire sur un blog, déposer des ressources, pointer vers des ressources appropriées<br />(Liens hypertextes, Pinterest...)
		D533 écouter les autres, respecter leur point de vue, leurs modifications<br />respecter une charte de fonctionnement<br />utiliser l'outil de révision des traitements de texte", 
	
	// CRITERES
	'b2iadultes:1:1:criteres' => "D111: Il sait mettre en route l'ordinateur, y brancher une souris, une clé USB, un câble éthernet...
		D112: savoir nommer son système d'exploitation, et savoir dire quel logiciel de traitement de texte il utilise
		D113: => relié à la rubrique D31 et D4 (internet)<br />il parvient à envoyer un document texte par mail au formateur sans qu'on lui ait donné de consignes sur les logiciels à utiliser.
		D114: utilité de savoir nommer curseur / pointeur ??", 
	'b2iadultes:1:2:criteres' => "D122: aller rechercher des dossiers, fichiers proposés par le formateur
		D123: créer sa mini arborescence pour la formation par exemple
		D124: l'enregistre à l'endroit voulu
		D125: Dire le poids d'un fichier, sa date de création, le logiciel utilisé pour le produire", 
	'b2iadultes:1:3:criteres' => "D131: savoir ouvrir 2 fenêtres côte à côte et passer de l'une à l'autre
		D132: - faire un raccourci sur le bureau vers l'arborescence de la formation<br />- changer son fond d'écran en utilisant les thèmes<br />- modifier l'affichage<br />- épingler les logiciels les plus utilisés dans la barre des tâches / ou dans le menu démarrer
		D133: - installer et désinstaller un logiciel (en faisant attention aux toolbars, pub...)<br />- faire une sauvegarde sur un support", 
	'b2iadultes:1:4:criteres' => "D141: - expliquer comment il se relie à sa box à la maison (cable / wifi....)<br />- si l'apprenant a un smartphone, lui faire expliquer les différents modes de connexion disponibles<br />- se connecter à internet selon les possibilités de connexions disponibles (wifi, ethernet......)
		D142: via plateforme formavia création de son compte et le faire vivre tout au long de la formation / créer un compte google
		D143: faire imprimer au format PDF comme moyen de sauvegarder une page<br />imprimer sous forme papier<br />faire faire transférer des fichiers (textes / photos...) sur l'ordinateur à partir d'une clé USB ou carte micro SD...", 
	'b2iadultes:2:1:criteres' => "D211: travailler sur l'espace commun de la plate forme et comprendre les différents niveaux de publication et informer le groupe via mail
		D212: QCM
		D213: installer un logiciel gratuit sur sa machine anti spam", 
	'b2iadultes:2:2:criteres' => "D221: 
		D222: j'enrichis mes articles d'images et de video creative commons et je cite l'auteur<br />j'installe des logiciels libres sur ma machine et autre framakey
		D223: J'utilise le droit de citation dans mon blog<br />+ QCM", 
	'b2iadultes:2:3:criteres' => "D231: QCM ou mise à situation avec pasword card (http://www.passwordcard.org/fr) et tester son mot de passe
		D232: Publication d'articles sur le blog de l'apprenant avec des PDF, des ressources Creative Commons", 
	'b2iadultes:2:4:criteres' => "D241: observations ", 
	'b2iadultes:3:1:criteres' => "D311: utiliser les bonnes fonctionnalités  de mise en page pour créer un traitement de texte et prendre et intégrer une photo
		D312: reconnaitre les icônes sur un bureau ou exploreur
		D313: Pour l'apprenant = une fiche ou un article de blog qu'il devra remplir pour organiser ses outils.", 
	'b2iadultes:3:2:criteres' => "D321: maitrise de la mise en page - créer un index de sommaire - maitrise des champs spécifiques - pieds de page/en-tête", 
	'b2iadultes:3:3:criteres' => "D331: insérer<br />- copier/coller<br />- manipuler l'image<br />- l'intégrer en relation avec le texte (ancrage)<br />- insertion d'objet (tableaux - vidéos)
		D332: insérer<br />- copier/coller<br />- manipuler l'image<br />- l'intégrer en relation avec le texte (ancrage)<br />- insertion d'objet (tableaux - vidéos)
		D333: gestion des formats de fichiers (.pdf avec gestion de droits)<br />- enregistrer et enregistrer sous<br />- enregistrer sur 2 formats différents- autonomie dans l'exécution<br />- gérer les droits d'auteurs", 
	'b2iadultes:4:1:criteres' => "D411: 
		D412: Trouver le bon moteur de recherche (vidéo ou réseaux sociaux ou recherche web)
		D413: savoir orthographier - utiliser des combinaisons de mots
		D414: savoir affiner la recherche en fonction des résultats obtenus", 
	'b2iadultes:4:2:criteres' => "D421: choisir le bon résultat en comparaison de ma recherche
		D422: organiser les favoris", 
	'b2iadultes:4:3:criteres' => "D431: 
		D432: 
		D433: ", 
	'b2iadultes:4:4:criteres' => "D441: 
		D442: ", 
	'b2iadultes:5:1:criteres' => "D511: 
		D512: 
		D513: ", 
	'b2iadultes:5:2:criteres' => "D521: 
		D522: ", 
	'b2iadultes:5:3:criteres' => "D531: 
		D532: 
		D533: ", 
	
	
	
	// MediaPicker
	'dossierdepreuve:choose:multi' => "(choisir un ou plusieurs)",
	//'dossierdepreuve:file:clicktoadd' => " (cliquer pour ajouter)",
	'dossierdepreuve:file:clicktoadd' => " <strong><big><big>+</big></big></strong>",
	//'dossierdepreuve:file:clicktoselect' => " (afficher/masquer le sélecteur)",
	'dossierdepreuve:file:clicktoselect' => " +",

	'dossierdepreuve:searchtag' => "Recherche",

	// River
	'river:create:object:default' => "%s a publié %s",
	'river:comment:object:default' => "%s a commenté %s",
	'river:commented:object:default' => "la publication",

);

add_translation("fr",$french);

