<?php
$site_email = elgg_get_site_entity()->email;

return array(
	
	// Form elements
	'mailing:menu:title' => "Envoyer un mailing HTML",
	'mailing:form:title' => "Préparation du mailing",
	'mailing:form:description' => "<br />Attention, cette fonctionnalité est à utiliser judicieusement et en évitant les abus : il peut y avoir d'autres manières de prévenir les membres plus adéquates au sein d'une réseau, qui tiennent compte de leur préférences en terme de vie privée et de choix de notification. Veuillez également lire avec attention les indications techniques qui suivent avant de l'utiliser !<br />
		<ul>
			<li>Les messages doivent <strong>éviter de contenir des images jointes, ou seulement avec une URL complète et publique</strong> : attention car l'éditeur visuel met les chemins en relatif.. (notez que la majorité des clients mail dédsactivent l'affichage des images dans les mails, aussi pensez à fournir un texte alternatif)</li>
			<li>Les messages sont envoyés directement sans prévisualisation ni autre confirmation. Il est vivement conseillé de procéder à un test préalable sur l'une de vos propres adresses avant de faire l'envoi réel, et de copier-coller le contenu du message pour l'envoi réel, en vérifiant bien une dernière fois l'URL des images insérées...)</li>
			<li>Réglez les adresses d'expédition et de réponse qui apparaîtront</li>
			<li>Les mails peuvent être envoyées à toute adresse email, y compris extérieures au réseau (attention à ne pas spammer)</li>
			<li>Le site d'envoi et l'expéditeur reçoivent un rapport d'envoi par mail, avec les informations complètes sur le mail envoyé</li>
			<li>TODO : sauvegarde de listes de mails</li>
			<li>TODO : chargement depuis des catégories d'utilisateurs du site (par groupe, types de profils, métadonnées, liste d'accès)</li>
		</ul>",
	'mailing:subject' => "Titre du mailing",
	'mailing:sender' => "Expéditeur",
	'mailing:replyto' => "Répondre à",
	'mailing:emailto' => "Destinataires",
	'mailing:emailto:help' => "Les adresses mails doivent être ajoutées seules (sans guillemet ni aucun autre caractère), séparées par des virgules, ou des points-virgules, ou des retours à la ligne.",
	'mailing:message' => "Contenu du mail",
	'mailing:message:help' => "Message HTML seulement (du texte seul apparaîtra 'collé', sans retour à la ligne), pas d'image sans une URL complète et accessible publiquement (sans s'identifier)",
	'mailing:send' => "Envoyer le mailing !",
	
	// Form defaults values : note that these values are used only if plugin settings are not set, and that bad formatted values will break the sending process..
	'mailing:form:default:subject' => "Lettre",
	'mailing:form:default:sender' => "$site_email", // Template : email@site.tld
	'mailing:action:default:replyto' => "$site_email", // Template : email@site.tld
	// Mail HTML template (HTML only ! no plain text)
	'mailing:form:default:message' => "Bonjour,<br /><br />...<br /><p>Au plaisir d'échanger avec vous,</p><p>L'équipe</p>",
	
	
	// Default actions values (leave blank to cancel sending and go back to form, if no value provided in form)
	'mailing:report' => "Rapport d'envoi",
	
	'mailing:send:success' => "Le mail a bien été envoyé",
	'mailing:send:error' => "Le mail n'a pas pu être envoyé",
	'mailing:send:error:subject' => "Pas de sujet",
	'mailing:send:error:recipient' => "Pas de destinataire",
	'mailing:send:error:message' => "Pas de message",
	'mailing:send:error:sender' => "Pas d'expéditeur",
	
);


