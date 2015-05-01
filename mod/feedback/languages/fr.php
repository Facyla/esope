<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

$french = array(
	'feedback' => 'Feedbacks',
	'admin:administer_utilities:feedback' => 'Feedbacks du site',
	'item:object:feedback' => 'Feedback',
	'feedback:label' => 'Feedback',
	'feedback:title' => 'Feedback',

	'feedback:admin:title' => 'Feedbacks du site',
	'feedback:widget:description' => 'Afficher les feedbacks des membres du site.',
	'feedback:numbertodisplay' => 'Nombre de feedbacks à afficher',

	'feedback:message' => "Vous avez une remarque à faire, de nouvelles idées à proposer ou un bug à signaler ? Nous serions ravis d'avoir votre retour.",
	'feedback:message:adminonly' => "<p><strong>Attention, ceci n'est pas un outil de discussion : pour cela utilisez les commentaires !</strong></p>",

	'feedback:default:id' => 'Nom et/ou Email',
	'feedback:default:txt' => 'Dites-nous ce que vous en pensez !',
	'feedback:default:txt:err' => 'Aucun message de feedback.\nNous apprécions vos suggestions et critiques.\nVeuillez saisir votre message et cliquer sur Envoyer.',

	'feedback:id:blank' => 'Adresse email non renseignée !',
	'feedback:captcha:blank' => 'Captcha non renseigné !',

	'feedback:submit_msg' => 'Envoi en cours...',
	'feedback:submit_err' => "Impossible d'envoyer le feedback !",

	'feedback:submit:error' => "Impossible d'envoyer le feedback !",
	'feedback:submit:success' => "Feedback envoyé. Merci !",

	'feedback:delete:success' => 'Feedback supprimé.',

	'feedback:mood:' => 'Aucun',
	'feedback:mood:angry' => ':-(',
	'feedback:mood:neutral' => 'Neutre',
	'feedback:mood:happy' => ':-)',

	'feedback:about:' => 'Aucun',
	'feedback:about:bug_report' => 'Bug',
	'feedback:about:content' => 'Contenu',
	'feedback:about:suggestions' => 'Suggestions',
	'feedback:about:compliment' => 'Compliment',
	'feedback:about:other' => 'Autre',

	'feedback:list:mood' => 'Humeur',
	'feedback:list:about' => 'A propos de',
	'feedback:list:page' => 'URL du feedback',
	'feedback:list:from' => 'De',
	'feedback:list:nofeedback' => 'Aucun feedback.',
	'feedback:list:noopenfeedback' => 'Aucun feedback ouvert pour le moment.',

	'feedback:user_1' => "Identifiant 1 : ",
	'feedback:user_2' => "Identifiant 2 : ",
	'feedback:user_3' => "Identifiant 3 : ",
	'feedback:user_4' => "Identifiant 4 : ",
	'feedback:user_5' => "Identifiant 5 : ",
	'feedback:settings:public' => "Les visiteurs non connectés peuvent-ils publier des feedbacks ? ",
	'feedback:settings:usernames' => "Vous pouvez définir jusqu'à 5 membres qui recevront des notifications à chaque nouveau feedback. Saisissez leurs identifiants ci-dessous : ",

	'feedback:email:subject' => '[Feedback] %s',
	'feedback:email:body' => "%s a fait un feedback : \"%s\" 
	
	%s
	
	Voir en ligne : %s
	",
	
	
	// Added by Facyla
	
	'feedback:group' => "Feedbacks",
	'feedback:option:grouptool' => "Laisser le choix au responsable de chaque groupe",
	'feedback:enablefeedback' => "Activer le feedback dans ce groupe",
	'feedback:page:unknown' => "URL inconnue",
	'feedback:viewfull' => "Afficher la discusion en pleine page",
	'feedback:commentsreply' => "%s commentaire(s) &nbsp; &raquo;&nbsp;Répondre",
	
	// Settings
	'feedback:settings:memberview' => "Les membres du site peuvent-ils consulter les feedbacks ?",
	'feedback:settings:comment' => "Est-il possible de commenter et de répondre aux feedbacks ?",
	'feedback:settings:feedbackgroup' => "Associer les feedbacks à un ou des groupes ?",
	
	// Feedback status
	'feedback:status' => "Statut des feedbacks",
	'feedback:list:status:open' => "Ouvert",
	'feedback:status:open' => "Feedbacks ouverts",
	'feedback:list:status:closed' => "Résolu",
	'feedback:status:closed' => "Feedbacks résolus",
	'feedback:closeconfirm' => "Marquer comme résolu ? Un feedback résolu est considéré comme traité et alimente la base de connaissances. Confirmer ?",
	'feedback:close:success' => "Feedback marqué comme résolu / déjà traité.",
	'feedback:close:error' => "Impossible de marquer ce feedback comme résolu",
	'feedback:reopenconfirm' => "Ce feedback est considéré comme déjà résolu. Souhaitez-vous le rouvrir ?",
	'feedback:reopen:success' => "Feedback marqué comme en cours / non résolu.",
	'feedback:reopen:error' => "Impossible de rouvrir ce feedback",
	
	// Feedbacks menu
	'feedback:menu:total' => "%s feedbacks",
	'feedback:menu:open' => "%s à traiter",
	'feedback:menu:closed' => "%s résolus",
	'feedback:menu:content' => "%s signalements",
	'feedback:menu:bug' => "%s dysfonctionnements",
	'feedback:menu:suggestion' => "%s suggestions",
	'feedback:menu:question' => "%s questions",
	'feedback:menu:compliment' => "%s compliments",
	'feedback:menu:other' => "%s autres / non classés",
	
	
	// About - feedback types
	'feedback:about' => "de type",
	'feedback:about:question' => "Question",
	'feedback:access:admin' => "Administrateur seulement",
	'feedback:access:sitemembers' => "Membres du site",
	'feedback:access:group' => "Membres du groupe",

	'feedback:email:reply:subject' => "[Feedback] %s",
	'feedback:email:reply:body' => "%s a répondu sur \"%s\" :
	
	%s
	
	Voir en ligne : %s
	",
	
	'feedback:linktofeedbacks' => "&raquo;&nbsp;Afficher les précédents feedbacks",
	
);

add_translation("fr",$french);

