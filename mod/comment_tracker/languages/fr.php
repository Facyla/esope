<?php
/**
 * comment_tracker language extender
 * 
 * @package ElggCommentTracker
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @copyright Copyright (c) 2007-2011 Cubet Technologies. (http://cubettechnologies.com)
 * @version 1.0
 * @author Akhilesh @ Cubet Technologies
 */

$french = array(
	'comments' => "Commentaires",
	'comment:notification:settings' => "Notifications des commentaires",
	'comment:notification:settings:description' => "Envoyer une notification lorsque des commentaires sont ajoutés aux publications auxquelles vous êtes abonné.",
	'comment:notification:settings:how' => "Sélectionner le type de notification",
	'comment:notification:settings:linktext' => "Voir toutes les publications auxquelles vous êtes abonné",
	'comment:subscriptions' => "Abonnements",
	'comment:subscriptions:none' => "Aucun abonnement actuellement",
	'comment:subscribe:tooltip' => "Abonnez-vous pour recevoir des notifications lorsque des commentaires sont faits sur cette publication",
	'allow:comment:notification' => "Voulez-vous activer les notifications ? ",
	'email:content:type' => "Voulez-vous activer les emails en HTML ? ",
	'text:email' => "Non",
	'html:email' => "Oui",
	'comment:subscribe' => "S'abonner",
	'comment:unsubscribe' => "Se désabonner",
			'comment:subscribe:long' => "S'abonner aux notifications des commentaires",
	'comment:unsubscribe:long' => "S'abonner aux notifications des commentaires",
			'comment_tracker:setting:autosubscribe' => "Abonnement automatique aux notifications sur les publications que vous avez commentées ?",
	'show:subscribers' => "Montrer les abonnés",
	'comment:subscribe:success' => "Abonnement réussi à cette publication.",
	'comment:subscribe:failed' => "Désolé, l'abonnement à cette publication a échoué.",
	'comment:subscribe:entity:not:access' => "Désolé, la publication n'a pas pu être trouvée.",
	'comment:unsubscribe:success' => "Désabonnement réussi de cette publication.",
	'comment:unsubscribe:failed' => "Désolé, le désabonnement de cette publication a échoué.",
	'comment:unsubscribe:not:valid:url' => "Désolé, l'adresse de désabonnement pour cette publication n'est pas valable.",
	'comment:unsubscribe:entity:not:access' => "Désolé, la publication n'a pas pu être trouvée.",
	'comment_tracker:setting:show_button' => "Afficher le bouton d'abonnement/désabonnement après les commentaires ? ",
	'comment_tracker:item' => "élément",
'comment_tracker:setting:notify_owner' => "Laisser comment_tracker gérer les notifications du propriétaire ?",
	
	'comment:notify:subject:groupforumtopic' => "%s a commenté %s dans le groupe %s",
	'comment:notify:subject:comment' => "%s a commenté %s \"%s\"",
	'comment:notify:subject:comment:group' => "%s a commenté %s \"%s\" dans le groupe %s",
	
	
	/* Legacy stuff - @TODO - see what's safe to delete */
	'comment:notify:subject' => "Nouveau commentaire sur %s",
	'comment:notify:group:subject' => "Nouveau commentaire sur %s",
	
	'comment:notify:body:web' => "Bonjour %s,
<br/>Un nouveau commentaire a été publié sur %s
<br/>%s a écrit : %s
<br/>%s
<br/>
<font color=\"#888888\" size=\"2\">
Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.<br/>
Pour modifier vos préférences de notification, veuillez cliquer sur :
%s<br/>
</font>
	",
	
	'comment:notify:group:body:web' => "Bonjour %s,
<br/>Une nouvelle réponse a été publiée sur %s
<br/>%s a écrit : %s
<br/>%s
<br/>
<font color=\"#888888\" size=\"2\">
Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.<br/>
Pour modifier vos préférences de notification, veuillez cliquer sur :
%s<br/>
</font>
	",
	
	'comment:notify:body:email:text' => "Bonjour %s,

Un nouveau commentaire a été publié sur %s

%s a écrit :
%s

%s


%s

_________________________________________________________________________________
<font color=\"#888888\" size=\"2\">
Veuillez noter que vous pouvez avoir besoin de vous connecter avant d'accéder à cette discussion.

Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.

Pour modifier vos préférences de notification, veuillez cliquer sur : 
%s

Pour modifier vos préférences de notification pour tous les messages de ce type, veuillez cliquer sur : 
%s
</font>
	",
	
	'comment:notify:group:body:email:text' => "Bonjour %s,

Une nouvelle réponse a été publiée sur %s

%s a écrit :
%s

%s


%s

_________________________________________________________________________________
<font color=\"#888888\" size=\"2\">
Veuillez noter que vous pouvez avoir besoin de vous connecter avant d'accéder à cette discussion.

Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.

Pour modifier vos préférences de notification, veuillez cliquer sur : 
%s

Pour modifier vos préférences de notification pour tous les messages de ce type, veuillez cliquer sur : 
%s
</font>
	",
	
	'comment:notify:body:email:html' => "
		<div>
		<div>Bonjour %s,</div>
		<div>Un nouveau commentaire a été publié sur %s</div>
		<div>%s a écrit : %s</div>
		<div>%s</div>
		<div>&nbsp;</div>
		<div>&nbsp;</div></div>
		<div>%s</div>
		<div>&nbsp;</div>
		<div style=\"border-top:1px solid #CCCCCC;color:#888888;\">
			<div>Veuillez noter que vous pouvez avoir besoin de vous connecter avant d'accéder à cette discussion.</div>
			<div>Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.</div>
			<div>Pour modifier vos préférences de notification pour tous les messages de ce type, veuillez cliquer sur : 
			%s</div>
		</div>
		</div>",
		
	'comment:notify:group:body:email:html' => "
	<div>
	<div>Bonjour %s,</div>
	<div>Une nouvelle réponse a été publiée sur %s</div>
	<div>%s a écrit : %s</div>
	<div>%s</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div>%s</div>
	<div style=\"border-top:1px solid #CCCCCC;color:#888888;\">
		<div>Veuillez noter que vous pouvez avoir besoin de vous connecter avant d'accéder à cette discussion.</div>
		<div>Vous recevez cette notification parce que vous vous êtes abonné à cette discussion, ou y avez participé.</div>
		<div>Pour modifier vos préférences de notification pour tous les messages de ce type, veuillez cliquer sur : 
		%s</div>
	</div>
	</div>",

);

add_translation("fr",$french);

