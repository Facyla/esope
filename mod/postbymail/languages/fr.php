<?php
/**
 * Elgg postbymail plugin language pack
 * 
 * @author Florian DANIEL aka Facyla
 * @copyright Facyla 2012-2015
 */

$site_url = elgg_get_site_url();

return array(
	/* Main strings */
	'postbymail' => "Publication par mail",
	'postbymail:title' => "Publication par mail",
	
	// Date format
	'postbymail:dateformat' => "d/m/Y à H:i:s",
	
	/* Settings */
	'postbymail:settings:error:missingrequired' => "Des paramètres de configuration requis sont manquants (serveur et port, nom d'utilisateur du compte de messagerie et/ou mot de passe)",
	'postbymail:settings:loadedfromfile' => "Paramètres chargés depuis le fichier de configuration (settings.php)",
	'postbymail:settings:loadedfromadmin' => "Paramètres définis via l'interface d'administration",
	'postbymail:settings:admin' => "Paramètres généraux",
	'postbymail:settings:replybymail' => "Réponses par email",
	'postbymail:settings:replybymail:details' => "Cette fonctionnalité permet de répondre à des notifications par email.",
	'postbymail:settings:postbymail' => "Publication par email (EXPERIMENTAL)",
	'postbymail:settings:postbymail:details' => "Cette fonctionnalité permet de publier de nouveaux contenus en envoyant un email à l'adresse de publication configurée.<br />Pour cela, une clef de publication unique peut être générée pour chaque groupe et/ou chaqu membre, et sera utilisée pour publier en son nom.<br />Dans un groupe, les publications sont attribuées à l'auteur s'il est connu, ou au groupe lui-même si l'email d'expédition n'est pas reconnu. >Le niveau d'accès est celui du groupe ou par défaut.<br />Les réglages de cette fonctionnalité expérimentale sont incomplets et la prise en charge des contenus autres que blog partiellement implémentée. Si vous le souhaitez, vous pouvez contacter l'auteur pour financer cette fonctionnalité.",
	'postbymail:settings:cron' => "Fréquence du cron",
	'postbymail:settings:cron:help' => "Note : le cron doit être configuré sur le serveur (ou via le plugin crontrigger qui permet de le remplacer en partie), sinon il ne fonctionnera que par intermittence, lors des appels manuels au cron ou à la page de vérification des emails.",
	'postbymail:settings:separator' => "Séparateur du message de réponse",
	'postbymail:settings:separatordetails' => "Texte explicatif situé sous le séparateur, qui limite la publication des signatures et conversations complètes, ainsi que le risque de doublons.",
	'postbymail:settings:scope' => "Types de réponses par mail autorisées", // forumonly, comments, allobjects
	'postbymail:settings:notifylist' => "Comptes à notifier", 
	'postbymail:settings:notifylist:details' => "Liste des GUID ou username des membres à prévenir lors de la réussite ou de l'échec de nouvelles publications (note : l'admin est prévenu de tout nouveau message publié, ou échoué. L'auteur n'est prévenu qu'en cas d'erreur.", 
	'postbymail:settings:debug' => "Activer le mode debug", 
	'postbymail:settings:debug:details' => "Ajoute plus d'informations dans les emails et les journaux d'erreurs", 
	'postbymail:settings:replymode' => "Type de comportement pour la réponse par email",
	'postbymail:settings:replymode:replybutton' => "Bouton de réponse (recommandé)",
	'postbymail:settings:replymode:replyemail' => "Modification de l'email d'envoi",
	'postbymail:settings:replymode:details' => "Le Bouton de réponse ajoute un bouton permettant de répondre par email au message reçu. Le message envoyé est plus propre et limite les risques d'envoi de données personnelles (signature), mais ne permet pas d'utiliser le bouton de réponse de sa messagerie.<br />L'autre méthode consiste à remplacer l'adresse email d'envoi utilisée par les notifications par l'adresse de réponse paramétrée. Elle permet ainsi de répondre directement à l'email pour publier une réponse, mais augmente le risque d'identification comme spam (ou de blocage par les systèmes de validation manuelle d'email). Elle ajoute aussi le risque de publier des réponses automatiques, malgré le mécanisme intégré de filtrage des réponses automatisées. Lorsque ce choix est activé, le texte du séparateur est intégré au tout début du message de notification afin de limiter l'ajout de contenu non désiré au message.",
	'postbymail:settings:addreplybutton' => "Ajoute un bouton de réponse par email",
	'postbymail:settings:addreplybutton:details' => "Ce réglage est généralement inverse du précédent : il ajoute en entête de message un bouton permettant de répondre par email.",
	'postbymail:settings:replybuttonaddtext' => "Ajouter une alternative texte",
	'postbymail:settings:replybuttonaddtext:details' => "Cette option ajoute un message texte sous le bouton de réponse, afin que les personnes utilisant une messagerie qui ne prend pas en charge les messages en HTML puissent tout de même accéder à l'adresse email de réponse.",
	'postbymail:settings:server' => "Serveur et port à utiliser", 
	'postbymail:settings:server:details' => "sous la forme : localhost:143 ou mail.domain.tld:995", 
	'postbymail:settings:protocol' => "Protocole à utiliser", 
	'postbymail:settings:protocol:details' => "si nécessaire (par ex.: /notls ou /imap/ssl, parfois ajouter aussi /novalidate-cert et /norsh)", 
	'postbymail:settings:mailbox' => "Boîte à utiliser (généralement INBOX, nom générique de la boîte de réception)", 
	'postbymail:settings:username' => "Nom d'utilisateur du compte de messagerie", 
	'postbymail:settings:username:details' => "L'identifiant utilisé pour se connecter au serveur de messagerie, par ex.: user@domain.tld", 
	'postbymail:settings:email' => "Adresse email pour la publication", 
	'postbymail:settings:email:details' => "Adresse qui sera indiquée aux membres pour publier, ou répondre par email aux notifications. Facultatif, à renseigner uniquement si différent du compte de messagerie", 
	'postbymail:settings:password' => "Mot de passe du compte de messagerie", 
	'postbymail:settings:inboxfolder' => "Dossier à vérifier", 
	'postbymail:settings:inboxfolder:details' => "Nom du dossier IMAP contenant les nouveaux messages. La valeur par défaut est INBOX, sauf si vous utilisez un filtre spécifique qui déplace les mails à traiter dans un dossier particulier.", 
	'postbymail:settings:markSeen' => "Marquer les messages traités comme lus (qu'ils soient publiés ou non) ; OUI sauf bonne raison", 
	'postbymail:settings:bodyMaxLength' => "Longueur maximale du texte publiable (max fixé par défaut à 65536, qui est la longueur du champ 'description' par défaut dans la base SQL d'Elgg)", 
	'postbymail:settings:mailpost' => "Publication par mail",
	'postbymail:settings:mailpost:help' => "Note : cette fonctionnalité permet de publier dans un groupe par mail, ou au nom d'un membre du réseau. Si l'auteur est connu, son nom est utilisé. Les email d'envoi inconnus permettent de publier, mais l'auteur sera le conteneur lui-même, groupe ou personne. Les accès sont ceux du groupe ou de la personne, sauf si cela est défini autrement.",
	'postbymail:settings:email:title' => "Paramètres du compte de messagerie utilisé",
	'postbymail:settings:email:title:details' => "Important : le fonctionnement du plugin nécessite la création préalable de deux dossiers 'Published' et 'Errors' avant de publier par mail. Ceux-ci sont normalement créés automatiquement lors de la première vérification de la messagerie, cependant il est important de s'assurer de leur existence avant d'utiliser cette fonctionnalité en production.<br />Renseignez les paramètres du compte de messagerie utilisé pour configurer le plugin et lui permettre de récupérer les messages.", 
	'postbymail:settings:cron:url' => "URL utilisée par le CRON",
	'postbymail:settings:cron:test' => "URL de test du plugin (admin seulement)",
	
	
	/* Settings values */
	'postbymail:settings:disabled' => "Désactivé",
	'postbymail:settings:enabled' => "Activé",
	'postbymail:cron:minute' => "Toutes les minutes",
	'postbymail:cron:fiveminute' => "Toutes les 5 minutes",
	'postbymail:cron:fifteenmin' => "Tous les quarts d'heure",
	'postbymail:cron:halfhour' => "Toutes les demi-heures",
	'postbymail:cron:hourly' => "Une fois par heure",
	'postbymail:cron:daily' => "Une fois par jour",
	'postbymail:cron:weekly' => "Une fois par semaine",
	// Scope des publications par mail
	'postbymail:settings:mailpost:none' => "Pas de publication par mail",
	'postbymail:settings:mailpost:grouponly' => "Groupes seulement",
	'postbymail:settings:mailpost:useronly' => "Membres seulement",
	'postbymail:settings:mailpost:groupanduser' => "Groupes et membres",
	// Scope des réponses par mail
	'postbymail:settings:scope:none' => "Pas de publication par mail",
	'postbymail:settings:scope:forumonly' => "Seulement les réponses aux sujets de forums",
	'postbymail:settings:scope:comments' => "Tous les commentaires",
	// Scope des notifications
	'postbymail:settings:notify_scope' => "Notifications pour les admins",
	'postbymail:settings:notify_scope:all' => "Toutes : erreurs et publications réussies (pour modération)",
	'postbymail:settings:notify_scope:erroronly' => "Seulement les erreurs (par défaut)",
	'postbymail:settings:notify_scope:error_and_groupadmin' => "Erreurs seulement pour les admins, et le responsable du groupe est prévenu des nouvelles publications",
	'postbymail:settings:notify_scope:error' => "En cas d'erreur (par défaut)",
	'postbymail:settings:notify_scope:success' => "En cas de réussite",
	'postbymail:settings:notify_scope:groupadmin' => "Notifier également l'admin du groupe",
	// Autres types de publications (non implémentées)
	'postbymail:settings:allowcreation' => "Permettre la création de nouveaux contenus par mail (sans effet - non implémenté)",
	'postbymail:settings:allowusermail' => "Offrir une adresse de publication personnalisée pour chacun des membres (sans effet - non implémenté)",
	'postbymail:settings:allowgroupmail' => "Offrir une adresse de publication personnalisée pour chacun des groupes (sans effet - non implémenté)",
	
	/* Usersettings */
	'postbymail:usersettings:accountemail' => "<strong>Votre adresse email d'inscription&nbsp: %s</strong>",
	'postbymail:usersettings:alternatemail' => "Adresses email liées à votre compte",
	'postbymail:usersettings:alternatemail:list' => "Adresses email enregistrées avec votre compte.",
	'postbymail:usersettings:alternatemail:none' => "Aucune adresse email supplémentaire enregistrée",
	'postbymail:usersettings:alternatemail:add' => "Ajouter une nouvelle adresse email à votre compte",
	'postbymail:usersettings:alternatemail:help' => "Lorsque vous répondez ou publiez par mail, vous pouvez le faire à partir de chacune des adresses listées ici.<br />Vous pouvez renseigner autant d'adresses que vous le souhaitez, à condition qu'elles ne soient pas utilisées par un autre membre.<br />Note : ces adresses ne permettent pas de se connecter au réseau, et ne recevoivent aucune notification du réseau.<br />Si vous souhaitez utiliser une autre adresse principale pour vous connecter et recevoir vos notifications, veuillez changer d'adresse principale via les paramètres de votre compte.",
	'postbymail:usersettings:error:alreadyregistered' => "Vous avez déjà enregistré cette adresse email.",
	'postbymail:usersettings:error:alreadyused' => "L'adresse email %s est déjà associée à un compte sur le site. Impossible de l'ajouter.",
	'postbymail:usersettings:error:invalidemeail' => "Erreur : adresse email non valide !",
	'postbymail:usersettings:success:emailadded' => "Votre adresse email %s a bien été enregistrée.",
	'postbymail:usersettings:success:emailremoved' => "L'adresse email %s a bien été retirée.",
	'postbymail:usersettings:publicationkey' => "Clef pour publication par mail",
	'postbymail:usersettings:publicationkey:change' => "Créer ou changer la clef (une nouvelle clef aléatoire sera générée)",
	'postbymail:usersettings:publicationkey:changed' => "Clef modifiée : seule la nouvelle adresse est désormais valable pour publier en votre nom.",
	'postbymail:usersettings:publicationkey:delete' => "Supprimer la clef",
	'postbymail:usersettings:publicationkey:deleted' => "Clef de publication supprimée.",
	'postbymail:usersettings:publicationkey:email' => "Adresse mail à utiliser pour publier",
	'postbymail:usersettings:publicationkey:nomail' => "Aucune adresse de publication personnelle activée",
	'postbymail:usersettings:publicationkey:tooshort' => "Clef trop courte, merci d'utiliser une clef d'au moins 20 caractères",
	'postbymail:usersettings:publicationkey:help' => "Vous pouvez définir une clef de publication par mail, associée à votre compte personnel. Celle-ci vous permet de publier des publications personnelles à partir de n'importe quele adresse mail. Si vous ne souhaitez plus utiliser cette fonctionnalité, il vous suffit de laisser ce champ vide. Si vous craignez que votre clef ait été compromise, vous pouvez la changer à tout moment.<br />Usage : envoyer un mail à l'adresse indiquée pour publier en votre nom sur le réseau. La nouvelle publication sera en accès restreint jusqu'à votre prochaine connexion web : vous pourrez alors l'éditer et changer son niveau d'accès de votre publication. Le titre de votre publication reprend celui de votre mail.<br />Usage avancé : Vous pouvez choisir le type de publication en ajoutant, après la clef, <strong>&subtype={type de contenu}</strong>, et le niveau d'accès en indiquant <strong>&access={id du niveau d'accès}</strong>.",
	
	/* Group settings */
	'postbymail:groupsettings:publicationkey' => "Clef pour publication par mail",
	'postbymail:groupsettings:publicationkey:change' => "Créer ou changer la clef (une nouvelle clef aléatoire sera générée)",
	'postbymail:groupsettings:publicationkey:changed' => "Clef modifiée : seule la nouvelle adresse est désormais valable pour publier dans ce groupe.",
	'postbymail:groupsettings:publicationkey:delete' => "Supprimer la clef",
	'postbymail:groupsettings:publicationkey:deleted' => "Clef de publication supprimée.",
	'postbymail:groupsettings:publicationkey:email' => "Adresse mail à utiliser pour publier dans ce groupe",
	'postbymail:groupsettings:publicationkey:nomail' => "Aucune adresse de publication activée dans ce groupe",
	'postbymail:groupsettings:publicationkey:tooshort' => "Clef trop courte, merci d'utiliser une clef d'au moins 20 caractères",
	'postbymail:groupsettings:publicationkey:help' => "Vous pouvez définir une clef de publication par mail, associée à ce groupe. Celle-ci vous permet de publier des publications dans ce groupe à partir de n'importe quele adresse mail. Si vous ne souhaitez plus utiliser cette fonctionnalité, il vous suffit de laisser ce champ vide. Si vous craignez que la clef ait été compromise, vous pouvez la changer à tout moment.<br />Usage : envoyer un mail à l'adresse indiquée pour publier dans ce groupe. Si votre adresse email est reconnue, la publication sera faite en votre nom. Si elle n'est pas reconnue, elle sera faite au nom du groupe. La nouvelle publication sera en accès réservé aux membres du groupe jusqu'à votre prochaine connexion web : vous pourrez alors l'éditer et changer le niveau d'accès de la publication. Le titre de la publication reprend celui de votre mail.<br />Usage avancé : Vous pouvez choisir le type de publication en ajoutant, après la clef, <strong>&subtype={type de contenu}</strong>, et le niveau d'accès en indiquant <strong>&access={id du niveau d'accès}</strong>.",
	
	/* Default values */
	'postbymail:default:separator' => "VEUILLEZ REPONDRE AU-DESSUS DE CETTE LIGNE",
	'postbymail:default:separatordetails' => "Afin de protéger vos informations privées et notamment les coordonnées présentes dans votre signature, seule la partie du message situé au-dessus de cette ligne sera publiée. Vous pouvez indiquer vos informations de contact sur votre page de profil.",
	
	/* Interface, report and message content */
	'postbymail:notifiedadminslist' => "Paramètres du plugin : membres notifiés lors du traitement de nouvelles publications par mail (réussies -pour modération-, ou échouées -pour vérification et débuggage-) : %s<br />Soit : ",
	'postbymail:connectionok' => "Connexion à la messagerie réussie<br />",
	'postbymail:newmessagesfound' => "%s messages non lus trouvés<br />",
	'postbymail:processingmsgnumber' => "<hr /><h3>Traitement du message n°%s (ID: %s)</h3><br />",
	'postbymail:validguid' => "<b>GUID valide</b><br /><br />",
	'postbymail:invalidguid' => "<b style=\"color:red;\"GUID non valide</b><br /><br />",
	'postbymail:usecontainer:comment' => "Réponse à un commentaire : utilisation de l'objet parent",
	'postbymail:usecontainer:discussion_reply' => "Réponse à une réponse de forum : utilisation de l'objet parent",
	
	/* Informations issues du mail */
	'postbymail:info:postfullmail' => "<strong>Adresse de publication complète :</strong> %s<br />",
	'postbymail:info:mailtitle' => "<strong>Titre du mail :</strong> %s<br />",
	'postbymail:info:maildate' => "<strong>Date :</strong> %s<br />",
	'postbymail:info:hash' => "<strong>Hash MD5 :</strong> %s<br />",
	'postbymail:info:parameters' => "<strong>Paramètres associés au message : </strong> %s<br />",
	'postbymail:info:paramwrap' => "<ul>%s</ul>",
	'postbymail:info:paramvalue' => "<li><strong>%s :</strong> %s</li>",
	'postbymail:info:objectok' => "<strong>Publication associée au message :</strong> &laquo;&nbsp;<a href=\"%s\">%s</a>&nbsp;&raquo; (%s)<br />",
	'postbymail:info:badguid' => "<strong style=\"color:red;\"Pas de GUID fourni ou la publication associée n'est pas valide ou accessible !</strong><br />",
	'postbymail:info:mailbox' => "<strong>Boîte mail vérifiée :</strong> %s<br />",
	'postbymail:info:usefulcontent' => "Contenu utile : &laquo;&nbsp;%s&nbsp;&raquo;",
	'postbymail:info:memberandmail' => "<strong>Compte de membre associé à l'expéditeur annoncé :</strong> %s (mail annoncé : %s)<br />",
	'postbymail:info:realmemberandmail' => "<strong>Compte de membre associé à l'expéditeur réel :</strong> %s (mail réel : %s)<br />",
	'postbymail:info:emails' => "<strong>Email utilisé :</strong> %s (via %s)<br />",
	'postbymail:info:alternativememberandmail' => "<strong>Compte de membre associé à une adresse alternative :</strong> %s (mail alternatif : %s)<br />",
	'postbymail:info:publicationmember' => "<strong>Membre sélectionné pour publication :</strong> %s<br />",
	
	/* Pièces jointes */
	'postbymail:info:attachment' => "<strong>Pièces jointes :</strong> %s<br />",
	'postbymail:attachment:elements' => "<br /><strong>Eléments du message : %s/%s %s</strong>", 
	'postbymail:attachment:multipart' => "<br />MESSAGE JOINT : %s", 
	'postbymail:attachment:image' => "[image jointe : %s]<br />", 
	'postbymail:attachment:msgcontent' => "<br />Contenu du message : %s<hr />", 
	'postbymail:attachment:other' => "[autre type de contenu joint : %s]<br />", 
	'postbymail:noattachment' => "Le message ne contient pas de pièce jointe.", 
	
	/* Vérification des conditions de publication */
	// Entité : objet concerné
	'postbymail:validobject' => " - La publication indiquée existe et est valide : &laquo;&nbsp;%s&nbsp;&raquo;<br />", 
	'postbymail:error:badguid' => " - <b style=\"color:red;\">Erreur : Aucune publication indiquée, ou la publication n'existe pas : veuillez vérifier que l'adresse de publication est valide, et si la publication est toujours en ligne (elle peut avoir été supprimée).</b><br />", 
	// Membre auteur
	'postbymail:memberok' => " - Membre trouvé à partir de l'adresse mail d'expédition : %s<br />", 
	//'postbymail:error:nomember' => " - <b style=\"color:red;\">Erreur : Compte du membre non trouvé à partir de l'adresse mail d'expédition : veuillez utilisez votre adresse d'inscription au site pour publier ce message (votre adresse d'expédition doit être reconnue par le site pour publier).</b><br />", 
	'postbymail:error:nomember' => " - <b style=\"color:red;\">Erreur : l'adresse mail d'expédition ne correspond à aucun compte connu. Peut-être utilisez-vous une adresse différente de celle que vous avez indiquée sur le site (cas typique si vous utilisez Gmail pour émettre mais une autre adresse pour recevoir). Solution :<br />
-- renvoyez votre mail avec l'adresse que vous avez sur le site<br />
-- ajouter votre présente adresse comme autorisée pour publier par email, à l'adresse " . $site_url . "settings/plugins/</b><br />",


	// Lieu (container) de publication : groupe (à terme : user aussi ?)
	'postbymail:containerok' => " - Le conteneur de cette publication existe et est valide (peut être un groupe ou un membre dans le cas de publications personnelles)<br />", 
	'postbymail:error:nocontainer' => " - <b style=\"color:red;\">Erreur : Aucune conteneur correspondant à la publication &laquo;&nbsp;%s&nbsp;&raquo; (ID du conteneur : %s) : le groupe ou le profil correspondant à cette publication n'a pas été trouvé ; il s'agit d'une erreur technique, veuillez faire suivre ce message à un administrateur du site.</b><br />", 
	'postbymail:error:badcontainer' => " - <b style=\"color:red;\">Erreur : aucun conteneur ne correspond à l'ID %s : le groupe ou le profil correspondant n'a pas été trouvé. Soit ce groupe n'existe pas, soit vous n'y avez pas accès. Si le groupe existe et que vous y avez accès, il s'agit d'une erreur technique, veuillez faire suivre ce message à un administrateur du site.</b><br />", 
	'postbymail:error:unknowncontainer' => " - <b style=\"color:red;\">Erreur : aucun conteneur ne correspond à l'ID %s : le groupe ou le profil correspondant n'a pas été trouvé. Soit ce groupe n'existe pas, soit vous n'y avez pas accès. Si le groupe existe et que vous y avez accès, il s'agit d'une erreur technique, veuillez faire suivre ce message à un administrateur du site.</b><br />", 
	// Conteneur : groupe
	'postbymail:groupok' => " - Le groupe %s existe et est valide<br />", 
	'postbymail:error:notingroup' => " - <b style=\"color:red;\">Erreur : La publication à commenter n'est pas dans un groupe : actuellement seules les publications dans les groupes peuvent être commentées. Il s'agit d'une erreur technique : veuillez faire suivre ce message à un administrateur du site.</b><br />", 
	// Appartenance au groupe ou autorisations de publication
	'postbymail:ismember' => " - %s est bien membre du groupe %s<br />", 
	'postbymail:error:nogroupmember' => " - <b style=\"color:red;\">Erreur : %s n'est pas membre du groupe &laquo;&nbsp;%s&nbsp;&raquo; : votre compte (ou celui correspondant à votre adresse d'expéditeur email) n'appartient pas au groupe dans lequel est publié la publication à laquelle vous souhaitez répondre. Pour pouvoir répondre à cette publication, veuillez rejoindre le groupe en question, ou vérifier que vous utilisez la bonne adresse email d'expédition.</b><br />", 
	// Message vide ou déjà publié
	'postbymail:error:emptymessage' => " - <b style=\"color:red;\">Erreur : Message vide. Les messages sans contenu ne peuvent pas être publiés. Veuillez vérifier que le séparateur utilisé pour séparer votre message de réponse des informations personnelles n'est pas situé au-dessus de votre message.</b><br />", 
	'postbymail:error:alreadypublished' => " - <b style=\"color:red;\">Erreur : Publication déjà effectuée (= a déjà été publié par le même auteur à la même date). Si vous recevez cette erreur, il s'agit probablement d'une erreur survenue suite à des tests. Elle ne se produit que si l'on tente de publier à nouveau un message qui a déjà été publié (celui-ci peut avoir été modéré entretemps s'il n'apparaît pas dans la page de discussion).</b><br />", 
	// Site & user container publishing messages
	'postbymail:error:noaccesstoentity' => " - <b style=\"color:red;\">Le membre n'a pas accès à cette entité</b><br />",
	'postbymail:hasaccesstoentity' => "Le membre a bien accès à l'entité<br />",
	'postbymail:userok' => "Le conteneur est un membre valide<br />",
	'postbymail:siteok' => "Le conteneur est un site valide<br />",
	'postbymail:error:automatic_reply' => " - <b style=\"color:red;\">Le message est certainement un message de réponse automatique (présence du header Auto-submitted)</b><br />",
	'postbymail:error:probable_automatic_reply' => " - <b style=\"color:red;\">Le message est probablement un message de réponse automatique (pas de From ni de Return-Path)</b><br />",
	
	/* Messages communs d'info et de debug pour les expéditeurs et admins */
	'postbymail:error:lastminutedebug' => "<b style=\"color:red;\">Publication impossible alors qu'a priori tout semblait OK : à vérifier pour débuggage</b>\n\n%s", 
	'postbymail:admin:reportmessage:error' => "<br /><b style=\"color:red;\">Publication impossible : soit pour l'une des raisons précédentes (s'il y en a), soit parce que le message est vide...</b>
			<br />Coupure via le séparateur effectuée à %s caractères<br />
			<br /><b>Message non publié :</b><br />%s
			<br /><b>Mail non publié (complet) :</b><br />%s",
	'postbymail:sender:reportmessage:error' => "<b>Votre message non publié :</b><br />%s<br />",
	'postbymail:published' => '<h3>MESSAGE PUBLIÉ</h3>',
	'postbymail:admin:debuginfo' => "<b>%s :</b><br />%s<br /><hr /><b>Informations de débogage :</b><br /><br />%s</hr>",
	'postbymail:sender:debuginfo' => "<b>%s :</b><br />%s<br /><hr />%s<br />",
	'postbymail:report:notificationmessages' => "<br /><br /><b>MAIL EXPEDITEUR :</b><br />%s<br /><br /><b>MAIL ADMIN :</b><br />%s<hr />",
	'postbymail:nonewmail' => "Aucun nouveau message<br />",
	'postbymail:badpluginconfig' => "Plugin mal configuré : paramètres manquants ou non fonctionnels", 
	'postbymail:numpublished' => "<hr />%s commentaires publiés", 
	'postbymail:nonepublished' => "<hr />Aucune publication à publier", 
	
	/* Messages pour les expéditeurs */
	'postbymail:sender:notpublished' => "Votre publication a échoué",
	'postbymail:sendermessage:error' => "Le message n'a pu être publié :<br />\n\n%s",
	'postbymail:sender:error:forumonly' => "<b style=\"color:red;\">Les paramètres du site ne permettent de répondre par mail qu'aux sujets des forums.</b><br />%s", 
	'postbymail:sender:notified' => "<br /><b>EXPEDITEUR NOTIFIÉ (sauf si aucune adresse valide)</b>",
	'postbymail:sender:notnotified' => "<br /><b>EXPEDITEUR NON NOTIFIÉ</b>",
	
	/* Messages pour les admins */
	'postbymail:admin:notpublished' => "Echec d'une publication par mail",
	'postbymail:adminsubject:newpublication' => "Nouvelle publication par mail à vérifier",
	'postbymail:adminmessage:success' => "Publication par mail réussie : nouveau contenu à vérifier\n\n%s",
	'postbymail:adminmessage:newpublication' => "Une nouvelle publication par mail a été faite par &laquo;&nbsp;%s&nbsp;&raquo; 
			(membre identifié via l'adresse email d'expédition &laquo;&nbsp;%s&nbsp;&raquo;), 
			sur <a href=\"%s\">la page &laquo;&nbsp;%s&nbsp;&raquo;</a> (%s)<br /><br />
			Contenu du commentaire publié :<br /><hr />%s<hr /><br />
			Pour modérer cette publication, veuillez vous connecter sur le site puis cliquer sur le titre de la publication ci-dessus<br /><br />",
	'postbymail:admin:notified' => "<br /><b>ADMIN NOTIFIÉ</b>",
	'postbymail:admin:notnotified' => "<br /><b>ADMIN NON NOTIFIÉ</b>",
	'postbymail:admin:error:forumonly' => "<b style=\"color:red;\">Les réglages choisis ne permettent pas de répondre par mail hors des forums.</b><br />", 
	
	/* Publications par mail : message de vérification des pré-requis */
	'postbymail:validcontainer' => "<br />Conteneur valide",
	'postbymail:container:isuser' => "<br />Conteneur : Membre",
	'postbymail:container:isgroup' => "<br />Conteneur : Groupe",
	'postbymail:validkey' => "<br />Clef de publication valide",
	'postbymail:key' => "<br />Clef de publication",
	'postbymail:subtype' => "<br />Type de publication",
	'postbymail:access' => "<br />Niveau d'accès : %s",
	'postbymail:member' => "<br />Membre valide",
	'postbymail:member:usedcontainerinstead' => "<br />Le conteneur a été utilisé comme auteur (expéditeur inconnu)",
	'postbymail:newpost:posted' => "Nouvelle publication réussie !",
	
	/* Messages privés */
	'postbymail:mailreply:success' => "Réponse au message privé effectuée.",
	
	/* Traitement du cron */
	'postbymail:mailprocessed' => "Traitement des mails en attente fait.", // Note : pas d'accent
	
	'postbymail:someone' => "Quelqu'un",
	'postbymail:mail:replyemail' => "ou utilisez cette adresse pour répondre :\n%s",
	
	
	// Reply button
	'postbymail:replybutton:basicsubject' => "Réponse par email",
	'postbymail:replybutton:subject' => "Réponse par email (conversation n°%s)",
	'postbymail:replybutton:title' => "Cliquez ici pour répondre par email",
	'postbymail:replybutton:wrapperstyle' => "background-color:#F0F0F0; color:#000000; padding:0.5ex 1ex; margin-bottom:1ex;",
	'postbymail:replybutton:style' => "background-color:#FFFFFF; padding:2px 1ex; border:1px solid; box-shadow: 0 0 1px 2px; font-weight:bold; text-decoration:none; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;",
	
	'postbymail:replybutton:failsafe' => "Adresse de réponse à copier-coller si le lien ne fonctionne pas : 
	<b>%s</b><br />
	Veuillez vérifier que votre email ne contient que le texte à publier (pas de signature...).",
	
	'postbymail:thewire:charlimitnotice' => "IMPORTANT : lorsque vous répondez à un message du Fil, seuls les 140 premiers caractères seront pris en compte et publiés !
	
	",
);

