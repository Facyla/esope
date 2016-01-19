<?php
/* Cette version du fichier de langue s'appuie sur Elgg 1.11.4
 * Elle doit remplacer le fichier fr.php fournit en standard à chaque mise à jour du core
 * Cette version se justifie par de nombreuses traductions qui ne sont pas homogènes dans la version originale
 */

return array(
/**
 * Sites
 */

	'item:site' => 'Sites',

/**
 * Sessions
 */

	'login' => "Connexion",
	'loginok' => "Vous êtes connecté(e).",
	'loginerror' => "Nous n'avons pas pu vous identifier. Assurez-vous que les informations que vous avez entrées sont correctes et réessayez.",
	'login:empty' => "Nom d'utilisateur et mot de passe sont requis.",
	'login:baduser' => "Impossible de charger votre compte d'utilisateur.",
	'auth:nopams' => "Erreur interne. Aucune méthode d'authentification des utilisateurs n'est installée.",

	'logout' => "Déconnexion",
	'logoutok' => "Vous avez été déconnecté(e).",
	'logouterror' => "Nous n'avons pas pu vous déconnecter. Essayez à nouveau.",
	'session_expired' => "Suite à un temps d'inactivité prolongé, votre session de travail a expiré. Veuillez SVP recharger la page afin de vous identifier à nouveau.",

	'loggedinrequired' => "Vous devez être connecté(e) pour voir cette page.",
	'adminrequired' => "Vous devez être administrateur pour voir cette page.",
	'membershiprequired' => "Vous devez être membre de ce groupe pour voir cette page.",
	'limited_access' => "Vous n'avez pas la permission de consulter la page demandée.",


/**
 * Errors
 */

	'exception:title' => "Erreur Fatale.",
	'exception:contact_admin' => "Une erreur irrécupérable a été rencontrée et a été enregistrée. Veuillez SVP contacter l'administrateur du site avec l'information suivante :",

	'actionundefined' => "L'action demandée (%s) n'est pas définie par le système.",
	'actionnotfound' => "Le fichier d'action pour %s n'a pas été trouvé.",
	'actionloggedout' => "Désolé, vous ne pouvez pas effectuer cette action sans être connecté(e).",
	'actionunauthorized' => 'Vous n êtes pas autorisé(e) à effectuer cette action.',
	'ajax:error' => 'Une erreur est survenue lors d\'un appel Ajax. Peut-être que la connexion avec le serveur est perdue.',
	'ajax:not_is_xhr' => 'You cannot access AJAX views directly',

	'PluginException:MisconfiguredPlugin' => "Le plugin %s (guid: %s) est mal configuré. Il a été désactivé. Veuillez rechercher dans le wiki d'aide les causes possibles (http://learn.elgg.org/).",
	'PluginException:CannotStart' => '%s (guid : %s) ne peut pas démarrer. Raison: %s',
	'PluginException:InvalidID' => "%s est un ID de plugin invalide.",
	'PluginException:InvalidPath' => "%s est un chemin invalide pour le plugin.",
	'PluginException:InvalidManifest' => 'Fichier manifest.xml invalide pour le plugin %s',
	'PluginException:InvalidPlugin' => '%s n\'est pas un plugin valide.',
	'PluginException:InvalidPlugin:Details' => '%s n\'est pas un plugin valide: %s',
	'PluginException:NullInstantiated' => 'ElggPlugin ne peut pas être laissé vide. Vous devez passer un GUID, un ID de plugin, ou un chemin complet.',
	'ElggPlugin:MissingID' => 'L\'ID du plugin manque (guid %s)',
	'ElggPlugin:NoPluginPackagePackage' => 'Le paquet d\'Elgg \'ElggPluginPackage\' du plugin ID %s manque (guid %s)',
	'ElggPluginPackage:InvalidPlugin:MissingFile' => 'Le fichier obligatoire %s manque dans le paquet.',
	'ElggPluginPackage:InvalidPlugin:InvalidId' => 'Le dossier du plugin doit être renommé en "%s" pour correspondre à l\'identifiant spécifié dans le manifeste. ',
	'ElggPluginPackage:InvalidPlugin:InvalidDependency' => 'Le manifeste contient un type de dépendance "%s" invalide.',
	'ElggPluginPackage:InvalidPlugin:InvalidProvides' => 'Le manifeste contient un type de fourniture "%s" invalide.',
	'ElggPluginPackage:InvalidPlugin:CircularDep' => '%s invalide dans dépendance \'%s\' dans le plugin %s. Les plugins ne peuvent pas être en conflit avec, ou avoir besoin de quelque chose, qu\'ils fournissent!',
	'ElggPlugin:Exception:CannotIncludeFile' => 'Impossible d\'inclure %s pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !',
	'ElggPlugin:Exception:CannotRegisterViews' => 'Impossible d\'ouvrir la vue dir pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !',
	'ElggPlugin:Exception:CannotRegisterLanguages' => 'Impossible d\'enregistrer les langues pour le plugin %s (guid : %s) sur %s. Vérifiez les autorisations !',
	'ElggPlugin:Exception:NoID' => 'Aucun ID pour le plugin guid %s !',
	'PluginException:NoPluginName' => "Le nom du plugin n'a pas pu être trouvé",
	'PluginException:ParserError' => 'Erreur de syntaxe du fichier manifest.xml avec la version %s de l\'API du plugin %s.',
	'PluginException:NoAvailableParser' => 'Analyseur syntaxique du fichier manifest.xml introuvable pour l\'API version %s du plugin %s.',
	'PluginException:ParserErrorMissingRequiredAttribute' => "L'attribut nécessaire '%s' manque dans le fichier manifest.xml pour le plugin %s.",
	'ElggPlugin:InvalidAndDeactivated' => '%s est un plugin invalide et a été désactivé.',

	'ElggPlugin:Dependencies:Requires' => 'Requis',
	'ElggPlugin:Dependencies:Suggests' => 'Suggestion',
	'ElggPlugin:Dependencies:Conflicts' => 'Conflits',
	'ElggPlugin:Dependencies:Conflicted' => 'En conflit',
	'ElggPlugin:Dependencies:Provides' => 'Fournit',
	'ElggPlugin:Dependencies:Priority' => 'Priorité',

	'ElggPlugin:Dependencies:Elgg' => 'Version d\'Elgg',
	'ElggPlugin:Dependencies:PhpVersion' => 'Version de PHP',
	'ElggPlugin:Dependencies:PhpExtension' => 'extension PHP : %s',
	'ElggPlugin:Dependencies:PhpIni' => 'Paramètre PHP ini : %s',
	'ElggPlugin:Dependencies:Plugin' => 'Plugin: %s',
	'ElggPlugin:Dependencies:Priority:After' => 'Après %s',
	'ElggPlugin:Dependencies:Priority:Before' => 'Avant %s',
	'ElggPlugin:Dependencies:Priority:Uninstalled' => '%s n\'est pas installé',
	'ElggPlugin:Dependencies:Suggests:Unsatisfied' => 'Manquant',
	
	'ElggPlugin:Dependencies:ActiveDependent' => 'Il existe d\'autres plugins répertoriant %s en tant que dépendance. Vous devez désactiver les plugins suivants avant de désactiver celui-ci: %s',

	'ElggMenuBuilder:Trees:NoParents' => 'Une entrée de menu a été trouvée sans lien avec un parent',
	'ElggMenuBuilder:Trees:OrphanedChild' => 'L\'entrée de menu [%s] a été trouvée avec un parent manquant [%s]',
	'ElggMenuBuilder:Trees:DuplicateChild' => 'L\'entrée de menu [%s] est enregistrée plusieurs fois',

	'RegistrationException:EmptyPassword' => 'Les champs du mot de passe ne peut pas être vide',
	'RegistrationException:PasswordMismatch' => 'Les mots de passe doivent correspondre',
	'LoginException:BannedUser' => 'Vous avez été banni de ce site et ne pouvez plus vous connecter',
	'LoginException:UsernameFailure' => 'Nous n\'avons pas pu vous connecter ! Vérifiez votre nom d\'utilisateur et mot de passe.',
	'LoginException:PasswordFailure' => 'Nous n\'avons pas pu vous connecter ! Vérifiez votre nom d\'utilisateur et mot de passe.',
	'LoginException:AccountLocked' => 'Votre compte a été verrouillé suite à un trop grand nombre d\'échecs de connexion.',
	'LoginException:ChangePasswordFailure' => 'Echec vérification mot de passe courant.',
	'LoginException:Unknown' => 'Nous ne pouvons pas vous connecter à cause d\'une erreur inconnue.',

	'deprecatedfunction' => "Attention : ce code source utilise une fonction obsolète \"%s\". Il n'est pas compatible avec cette version de Elgg.",

	'pageownerunavailable' => "Attention : la page de l'utilisateur %d n'est pas accessible.",
	'viewfailure' => 'Erreur interne dans la vue %s',
	'view:missing_param' => "Le paramètre obligatoire '%s' manque dans la vue %s",
	'changebookmark' => 'Veuillez mettre à jour votre favori pour cette page.',
	'noaccess' => "Vous devez vous connecter pour accéder à cette page, ou celle-ci a été supprimée, ou vous n'avez pas la permission d'y accéder",
	'error:missing_data' => 'Il manque des données dans votre requête',
	'save:fail' => "Une erreur s'est produite lors de la sauvegarde de vos données. ",
	'save:success' => 'Vos données ont été sauvegardéées',

	'error:default:title' => 'Oups...',
	'error:default:content' => 'Oups... quelque chose est allé de travers.',
	'error:400:title' => 'Mauvaise requête',
	'error:400:content' => 'Désolé. La requête est invalide ou incomplète.',
	'error:403:title' => 'Interdit',
	'error:403:content' => "Désolé. Vous n'avez pas l'autorisation d'accdéder à cette page.",
	'error:404:title' => 'Page non trouvée',
	'error:404:content' => 'Désolé. Nous n\'arrivons pas à trouver la page que vous demandez.',

	'upload:error:ini_size' => 'Le fichier que vous avez essayé de télécharger est trop grand.',
	'upload:error:form_size' => 'Le fichier que vous avez essayé de télécharger est trop grand.',
	'upload:error:partial' => "Le téléchargement du fichier ne s'est pas terminé correctement.",
	'upload:error:no_file' => "Aucun fichier n'a été sélectionné.",
	'upload:error:no_tmp_dir' => "Impossible d'enregistrer le fichier téléchargé (répertoire temporaire).",
	'upload:error:cant_write' => "Impossible d'enregistrer le fichier téléchargé (écriture impossible).",
	'upload:error:extension' => "Impossible d'enregistrer le fichier téléchargé (extension)",
	'upload:error:unknown' => 'Le téléchargement a échoué.',


/**
 * User details
 */

	'name' => "Prénom et Nom",
	'email' => "Adresse e-mail",
	'username' => "Identifiant",
	'loginusername' => "Identifiant ou e-mail",
	'password' => "Mot de passe",
	'passwordagain' => "Confirmation du mot de passe",
	'admin_option' => "Définir comme administrateur ?",

/**
 * Access
 */

	'PRIVATE' => "Privé",
	'LOGGED_IN' => "Membres connectés",
	'PUBLIC' => "Public",
	'LOGGED_OUT' => "Visiteurs non connectés",
	'access:friends:label' => "Contacts",
	'access' => "Accès (visibilité)",
	'access:overridenotice' => "Note : selon la politique de confidentialité, ce contenu ne sera accessible qu'aux membres du groupe.",
	'access:limited:label' => "Limité",
	'access:help' => "Le niveau d'accès",
	'access:read' => "Accès en lecture",
	'access:write' => "Accès en écriture",
	'access:admin_only' => "Seulement pour les administrateurs",
	'access:missing_name' => "Le nom du niveau d'accès est manquant",
	'access:comments:change' => "Cette discussion a actuellement des droits d'accès limités. Faites attention lorsque vous la partagez.",

/**
 * Dashboard and widgets
 */

	'dashboard' => "Tableau de bord",
	'dashboard:nowidgets' => "Votre tableau de bord vous permet de suivre l'activité et les contenus qui vous intéressent.",

	'widgets:add' => 'Personnaliser cette page',
	'widgets:add:description' => "Cliquez sur un widget ci-dessous pour l'ajouter à votre page. Vous pouvez ensuite le déplacer et le configurer selon vos souhaits.<br />Note : certains widgets peuvent être ajoutés plusieurs fois.",
	'widgets:panel:close' => "Fermer le panneau des widgets",
	'widgets:position:fixed' => '(la position de ce widget est fixe et ne peut pas être modifiée)',
	'widget:unavailable' => 'Vous avez déjà ajouté ce widget',
	'widget:numbertodisplay' => "Nombre d'éléments à afficher",

	'widget:delete' => 'Supprimer %s',
	'widget:edit' => 'Personnaliser ce widget',

	'widgets' => "Widgets",
	'widget' => "Widget",
	'item:object:widget' => "Widgets",
	'widgets:save:success' => "Le widget a été sauvegardé avec succès.",
	'widgets:save:failure' => "Un problème est survenu lors de l'enregistrement de votre widget. Veuillez recommencer.",
	'widgets:add:success' => "Le widget a bien été ajouté.",
	'widgets:add:failure' => "Nous n'avons pas pu ajouter votre widget.",
	'widgets:move:failure' => "Nous n'avons pas pu enregistrer la position du nouveau widget.",
	'widgets:remove:failure' => "Impossible de supprimer ce widget",

/**
 * Groups
 */

	'group' => "Groupe",
	'item:group' => "Groupes",

/**
 * Users
 */

	'user' => "Membre",
	'item:user' => "Membres",

/**
 * Friends
 */

	'friends' => "Contacts",
	'friends:yours' => "Vos contacts",
	'friends:owned' => "Les contacts de %s",
	'friend:add' => "Ajouter un contact",
	'friend:remove' => "Supprimer un contact",

	'friends:add:successful' => "Vous avez ajouté %s à vos contacts.",
	'friends:add:failure' => "%s n'a pas pu être ajouté(e) à vos contacts. Merci de réessayer ultérieurement.",

	'friends:remove:successful' => "Vous avez retiré %s de vos contacts.",
	'friends:remove:failure' => "%s n'a pas pu être retiré(e) de vos contacts. Merci de réessayer ultérieurement.",

	'friends:none' => "Ce membre n'a pas encore ajouté de contact.",
	'friends:none:you' => "Vous n'avez pas encore de contact !",

	'friends:none:found' => "Aucun contact n'a été trouvé.",

	'friends:of:none' => "Personne n'a encore ajouté cet utilisateur comme contact.",
	'friends:of:none:you' => "Personne ne vous a encore ajouté comme contact. Commencez par remplir votre page de profil et publiez du contenu pour que les gens vous trouvent !",

	'friends:of:owned' => "Les personnes qui ont %s dans leurs contacts",

	'friends:of' => "Contacts de",
	'friends:collections' => "Groupement de contacts",
	'collections:add' => "Nouveau groupement",
	'friends:collections:add' => "Nouveau groupement de contacts",
	'friends:addfriends' => "Sélectionner des contacts",
	'friends:collectionname' => "Nom du groupement",
	'friends:collectionfriends' => "Contacts dans le groupement",
	'friends:collectionedit' => "Modifier ce groupement",
	'friends:nocollections' => "Vous n'avez pas encore de groupement de contacts.",
	'friends:collectiondeleted' => "Votre groupement de contacts a été supprimé.",
	'friends:collectiondeletefailed' => "Le groupement de contacts n'a pas été supprimé. Vous n'avez pas de droits suffisants, ou un autre problème peut être en cause.",
	'friends:collectionadded' => "Votre groupement de contacts a été créé avec succès",
	'friends:nocollectionname' => "Vous devez donner un nom à votre groupement de contact.",
	'friends:collections:members' => "Membres du groupement",
	'friends:collections:edit' => "Modifier le groupement de contacts",
	'friends:collections:edited' => "Groupement sauvegardé",
	'friends:collection:edit_failed' => "Impossible d'enregistrer le groupement.",

	'friendspicker:chararray' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',

	'avatar' => "Photo du profil",
	'avatar:noaccess' => "Vous n'êtes pas autorisé à modifier la photo de ce membre",
	'avatar:create' => 'Créer ma photo du profil',
	'avatar:edit' => 'Modifier ma photo',
	'avatar:preview' => 'Prévisualisation',
	'avatar:upload' => 'Envoyer une nouvelle photo du profil',
	'avatar:current' => 'Photo actuelle',
	'avatar:remove' => 'Supprime votre photo du profil et restaure l\'icône par défaut',
	'avatar:crop:title' => 'Recadrage de la photo',
	'avatar:upload:instructions' => "Votre photo est affichée sur tout le site. Vous pouvez la changer quand vous le souhaitez. (Formats de fichiers acceptés: GIF, JPG ou PNG)",
	'avatar:create:instructions' => 'Cliquez et faites glisser le carré ci-dessous selon la façon dont vous voulez que votre photo soit recadrée. Un aperçu s\'affiche sur la droite. Lorsque le résultat vous convient, cliquez sur «&nbsp;Créer ma photo de profil&nbsp;». Cette version recadrée sera utilisée sur le site.',
	'avatar:upload:success' => 'Image téléchargée avec succès',
	'avatar:upload:fail' => 'Échec de l\'envoi de l\'image',
	'avatar:resize:fail' => 'Le redimensionnement de la photo a échoué',
	'avatar:crop:success' => 'Le redimensionnement de la photo a réussi',
	'avatar:crop:fail' => 'Le recadrage de la photo a échoué',
	'avatar:remove:success' => 'Suppression de la photo terminée',
	'avatar:remove:fail' => 'Échec de la suppression de l\'image',

	'profile:edit' => 'Modifier mon profil',
	'profile:aboutme' => "A mon propos",
	'profile:description' => "A mon propos",
	'profile:briefdescription' => "Brève description",
	'profile:location' => "Adresse",
	'profile:skills' => "Compétences",
	'profile:interests' => "Centres d'intérêt",
	'profile:contactemail' => "Contact e-mail",
	'profile:phone' => "Téléphone",
	'profile:mobile' => "Téléphone portable",
	'profile:website' => "Site web",
	'profile:twitter' => "Nom d'utilisateur Twitter",
	'profile:saved' => "Votre profil a bien été enregistré.",

	'profile:field:text' => 'Texte court',
	'profile:field:longtext' => 'Texte long',
	'profile:field:tags' => 'Tags',
	'profile:field:url' => 'Adresse web ',
	'profile:field:email' => 'Adresse e-mail',
	'profile:field:location' => 'Adresse',
	'profile:field:date' => 'Date',

	'admin:appearance:profile_fields' => 'Modifier les champs du profil',
	'profile:edit:default' => 'Modifier les champs du profil',
	'profile:label' => "Etiquette du profil",
	'profile:type' => "Type de profil",
	'profile:editdefault:delete:fail' => 'Echec de la suppression du champ de profil',
	'profile:editdefault:delete:success' => 'Le champ de profil par défaut est supprimé !',
	'profile:defaultprofile:reset' => 'Réinitialisation du profil système par défaut',
	'profile:resetdefault' => 'Réinitialisation du profil par défaut',
	'profile:resetdefault:confirm' => 'Etes-vous sûr(e) de vouloir effacer les champs de profil personnalisés ?',
	'profile:explainchangefields' => "Vous pouvez remplacer les champs de profil existants avec les vôtres en utilisant le formulaire ci-dessous.\n\nDonner une étiquette pour le nouveau champ du profil, par exemple, 'équipe préférée', puis sélectionnez le type de champ (par exemple, texte, url, balises), et cliquez sur le bouton 'Ajouter'. Pour réordonner les champs faites glisser la poignée de l'étiquette du champ. Pour modifier un champ d'étiquette - cliquez sur le texte de l'étiquette pour le rendre modifiable. A tout moment vous pouvez revenir au profil par défaut, mais vous perdrez toutes les informations déjà entrées dans des champs personnalisés des pages de profil.",
	'profile:editdefault:success' => 'Champ ajouté au profil par défaut',
	'profile:editdefault:fail' => "Le profil par défaut n'a pas pu être sauvegardé",
	'profile:field_too_long' => "Impossible de sauvegarder vos informations du profil car la section %s est trop longue.",
	'profile:noaccess' => "Vous n'avez pas la permission d'éditer ce profil.",
	'profile:invalid_email' => '%s doit être une adresse e-mail valide.',


/**
 * Feeds
 */
	'feed:rss' => 'S\'abonner au fil RSS de cette page',
/**
 * Links
 */
	'link:view' => 'voir le lien',
	'link:view:all' => 'Voir tout',


/**
 * River
 */
	'river' => "Flux",
	'river:friend:user:default' => "%s est maintenant en contact avec %s",
	'river:update:user:avatar' => '%s a une nouvelle photo du profil',
	'river:update:user:profile' => '%s ont mis à jour leur profils',
	'river:noaccess' => 'Vous n\'avez pas la permission de voir cet élément.',
	'river:posted:generic' => '%s envoyé',
	'riveritem:single:user' => 'un membre',
	'riveritem:plural:user' => 'des membres',
	'river:ingroup' => 'au groupe %s',
	'river:none' => 'Aucune activité',
	'river:update' => 'Mise à jour pour %s',
	'river:delete' => 'Retirer l\'item de cette activité',
	'river:delete:success' => 'L\'article du flux a été supprimé',
	'river:delete:fail' => 'L\'article du flux ne peut pas être supprimé',
	'river:subject:invalid_subject' => 'Utilisateur invalide',
	'activity:owner' => 'Consulter l\'activité',

	'river:widget:title' => "Activité",
	'river:widget:description' => "Afficher l'activité la plus récente",
	'river:widget:type' => "Type d'activité",
	'river:widgets:friends' => 'Activité des contacts',
	'river:widgets:all' => 'Toutes les activités sur le site',

/**
 * Notifications
 */
	'notifications:usersettings' => "Configuration des messages du site",
	'notification:method:email' => 'E-mail',

	'notifications:usersettings:save:ok' => "La configuration des messages du site a bien été sauvegardée.",
	'notifications:usersettings:save:fail' => "Il y a eu un problème lors de la sauvegarde des paramètres de configuration des messages du site.",

	'notification:subject' => 'Notification à propos de %s',
	'notification:body' => 'Consulter les nouvelles activités à %s',

/**
 * Search
 */

	'search' => "Chercher",
	'searchtitle' => "Rechercher : %s",
	'users:searchtitle' => "Recherche des membres : %s",
	'groups:searchtitle' => "Rechercher des groupes : %s",
	'advancedsearchtitle' => "%s résultat(s) trouvé(s) pour %s",
	'notfound' => "Aucun résultat trouvé.",
	'next' => "Suivant",
	'previous' => "Précédent",

	'viewtype:change' => "Changer le type de liste",
	'viewtype:list' => "Lister les vues",
	'viewtype:gallery' => "Galerie",

	'tag:search:startblurb' => "Eléments avec le(s) mot(s)-clé '%s' :",

	'user:search:startblurb' => "Utilisateurs avec le(s) mot(s)-clé '%s' :",
	'user:search:finishblurb' => "Pour en savoir plus, cliquez ici.",

	'group:search:startblurb' => "Groupes qui vérifient le critère : %s",
	'group:search:finishblurb' => "Pour en savoir plus, cliquez ici.",
	'search:go' => 'Rechercher',
	'userpicker:only_friends' => 'Seulement les contacts',

/**
 * Account
 */

	'account' => "Compte",
	'settings' => "Configuration",
	'tools' => "Outils",
	'settings:edit' => 'Editer les paramètres',

	'register' => "Créer un compte",
	'registerok' => "Vous vous êtes enregistré avec succès sur %s.",
	'registerbad' => "Votre création de compte n'a pas fonctionné pour une raison inconnue.",
	'registerdisabled' => "La création de compte a été désactivée par l'administrateur du site.",
	'register:fields' => 'Tous les champs sont requis',

	'registration:notemail' => 'L\'adresse e-mail que vous avez indiquée ne semble pas valide.',
	'registration:userexists' => 'Cet identifiant existe déjà',
	'registration:usernametooshort' => "L'identifiant doit comporter au minimum %u caractères.",
	'registration:usernametoolong' => 'Votre identifiant est trop long. Il doit comporter au maximum %u caractères.',
	'registration:passwordtooshort' => 'Le mot de passe doit comporter un minimum de %u caractères.',
	'registration:dupeemail' => 'Cette adresse e-mail est déjà utilisée.',
	'registration:invalidchars' => 'Désolé, votre nom d\'utilisateur contient le caractère %s qui ne peut pas être utilisé. Les caractères suivants sont invalides : %s',
	'registration:emailnotvalid' => 'Désolé, l\'adresse e-mail que vous avez indiquée est invalide sur ce site.',
	'registration:passwordnotvalid' => 'Désolé, le mot de passe que vous avez indiqué est invalide sur ce site.',
	'registration:usernamenotvalid' => "Désolé, l'identifiant que vous avez indiqué est invalide sur ce site.",

	'adduser' => "Ajouter un utilisateur",
	'adduser:ok' => "Vous avez ajouté un nouvel utilisateur avec succès.",
	'adduser:bad' => "Le nouvel utilisateur ne peut pas être créé.",

	'user:set:name' => "Nom",
	'user:name:label' => "Nom",
	'user:name:success' => "Votre nom a été changé avec succès.",
	'user:name:fail' => "Impossible de changer votre nom. Assurez-vous que votre nom n'est pas trop long et essayez à nouveau.",

	'user:set:password' => "Mot de passe",
	'user:current_password:label' => 'Mot de passe actuel',
	'user:password:label' => "Votre nouveau mot de passe",
	'user:password2:label' => "Veuillez saisir à nouveau votre nouveau mot de passe",
	'user:password:success' => "Votre mot de passe a bien été modifié",
	'user:password:fail' => "Impossible de modifier votre mot de passe.",
	'user:password:fail:notsame' => "Les deux mots de passe ne correspondent pas !",
	'user:password:fail:tooshort' => "Le mot de passe est trop court !",
	'user:password:fail:incorrect_current_password' => 'Le mot de passe actuel indiqué est incorrect.',
	'user:changepassword:unknown_user' => 'Utilisateur inconnu.',
	'user:changepassword:change_password_confirm' => 'Cela modifiera votre mot de passe.',

	'user:set:language' => "Langue",
	'user:language:label' => "Votre langue",
	'user:language:success' => "Votre paramètre de langue a été mis à jour.",
	'user:language:fail' => "Votre paramètre de langue n'a pas pu être sauvegardé.",

	'user:username:notfound' => 'Identifiant %s non trouvé.',

	'user:password:lost' => 'Mot de passe perdu',
	'user:password:changereq:success' => 'Vous avez demandé un nouveau mot de passe, un e-mail vous a été envoyé',
	'user:password:changereq:fail' => 'Impossible de demander un nouveau mot de passe.',

	'user:password:text' => 'Pour générer un nouveau mot de passe, entrez votre identifiant ou votre e-mail ci-dessous, puis cliquez sur le bouton de demande.',

	'user:persistent' => 'Se souvenir de moi',

	'walled_garden:welcome' => 'Bienvenue',

/**
 * Administration
 */
	'menu:page:header:administer' => 'Administration',
	'menu:page:header:configure' => 'Configuration',
	'menu:page:header:develop' => 'Développement',
	'menu:page:header:default' => 'Autre',

	'admin:view_site' => 'Voir le site',
	'admin:loggedin' => 'Connecté en tant que %s',
	'admin:menu' => 'Menu',

	'admin:configuration:success' => "Vos paramètres ont été enregistrés.",
	'admin:configuration:fail' => "Vos paramètres n'ont pas pu être enregistrés.",
	'admin:configuration:dataroot:relative_path' => 'Impossible de définir %s comme racine de \'dataroot\' car ce n\'est pas un chemin absolu.',
	'admin:configuration:default_limit' => 'Le nombre d\'éléments par page doit être d\'au moins 1.',

	'admin:unknown_section' => 'Partie Admin invalide.',

	'admin' => "Administration",
	'admin:description' => "Le panneau d'administration vous permet de contrôler tous les aspects du système d'Elgg, de la gestion des utilisateurs à la gestion des outils installés. Choisissez une rubrique dans le menu ci-contre pour commencer.",

	'admin:statistics' => "Statistiques",
	'admin:statistics:overview' => 'Vue d\'ensemble',
	'admin:statistics:server' => 'Informations sur le serveur',
	'admin:statistics:cron' => 'Table de planification (cron)',
	'admin:cron:record' => 'Dernière table de planification',
	'admin:cron:period' => 'Période de la table de planification',
	'admin:cron:friendly' => 'Dernière exécution',
	'admin:cron:date' => 'Date et heure',

	'admin:appearance' => 'Apparence',
	'admin:administer_utilities' => 'Utilitaires',
	'admin:develop_utilities' => 'Utilitaires',
	'admin:configure_utilities' => 'Utilitaires',
	'admin:configure_utilities:robots' => 'Robots.txt',

	'admin:users' => "Utilisateurs",
	'admin:users:online' => 'Actuellement en ligne',
	'admin:users:newest' => 'Nouveaux',
	'admin:users:admins' => 'Administrateurs',
	'admin:users:add' => 'Ajouter un nouvel utilisateur',
	'admin:users:description' => "Ce panneau d'administration vous permet de contrôler les paramètres des utilisateurs de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:users:adduser:label' => "Cliquez ici pour ajouter un nouvel utilisateur ...",
	'admin:users:opt:linktext' => "Configurer des utilisateurs ...",
	'admin:users:opt:description' => "Configurer les utilisateurs et les informations des comptes.",
	'admin:users:find' => 'Trouver',

	'admin:administer_utilities:maintenance' => 'Mode maintenance',
	'admin:upgrades' => 'Mise à niveau',

	'admin:settings' => 'Configuration',
	'admin:settings:basic' => 'Réglages de base',
	'admin:settings:advanced' => 'Paramètres avancés',
	'admin:site:description' => "Ce menu vous permet de définir les paramètres principaux de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:site:opt:linktext' => "Configurer le site...",
	'admin:settings:in_settings_file' => 'Ce paramètre est configuré dans settings.php',

	'admin:legend:security' => 'Sécurité',
	'admin:site:secret:intro' => 'Elgg utilise une clé pour sécuriser les tokens dans un certain nombre de cas.',
	'admin:site:secret_regenerated' => "La clé secrète du site a été régénérée.",
	'admin:site:secret:regenerate' => "Régénérer la clé secrète du site",
	'admin:site:secret:regenerate:help' => "Note : régénérer votre clé peut poser problème à certains utilisateurs en invalidant les tokens utilisés dans les cookies de session, dans les e-mails de validation de compte, les codes d’invitation, etc.",
	'site_secret:current_strength' => 'Complexité de la clé',
	'site_secret:strength:weak' => "Faible",
	'site_secret:strength_msg:weak' => "Nous vous conseillons fortement de régénérer la clé secrète de votre site.",
	'site_secret:strength:moderate' => "Moyenne",
	'site_secret:strength_msg:moderate' => "Nous vous conseillons de régénérer la clé secrète de votre site pour une meilleure sécurité.",
	'site_secret:strength:strong' => "Forte",
	'site_secret:strength_msg:strong' => "La clé secrète de votre site est suffisamment complexe. Il est inutile de la régénérer.",

	'admin:dashboard' => 'Tableau de bord',
	'admin:widget:online_users' => 'Membres connectés',
	'admin:widget:online_users:help' => 'Affiche la liste des membres actuellement connectés sur le site',
	'admin:widget:new_users' => 'Nouveaux membres',
	'admin:widget:new_users:help' => 'Affiche la liste des nouveaux membres',
	'admin:widget:banned_users' => 'Utilisateurs bannis',
	'admin:widget:banned_users:help' => 'Liste des utilisateurs bannis',
	'admin:widget:content_stats' => 'Statistiques',
	'admin:widget:content_stats:help' => 'Gardez une trace du contenu créé par vos utilisateurs',
	'admin:widget:cron_status' => 'Statut du cron',
	'admin:widget:cron_status:help' => 'Afficher les statuts du dernier cron terminé',
	'widget:content_stats:type' => 'Type de contenu',
	'widget:content_stats:number' => 'Nombre',

	'admin:widget:admin_welcome' => 'Bienvenue',
	'admin:widget:admin_welcome:help' => "Une courte introduction à la zone d'administration de Elgg",
	'admin:widget:admin_welcome:intro' => 'Bienvenue sur Elgg ! Vous êts actuellement sur le tableau de bord de l\'administration. Il vous permet de suivre ce qui se passe sur le site.',

	'admin:widget:admin_welcome:admin_overview' => "La navigation dans l'administration se fait à l'aide du menu de droite. Il est organisé en 3 rubriques :
	<dl>
		<dt>Administration</dt><dd>Les tâches quotidiennes comme le suivi du contenu signalé, l'aperçu des utilisateurs en ligne, l'affichage des statistiques...</dd>
		<dt>Configuration</dt><dd>Les tâches occasionnelles comme le paramétrage du nom du site ou l'activation d'un plugin.</dd>
		<dt>Développement</dt><dd>Pour les développeurs qui créent des plugins ou conçoient des thèmes. (Nécessite des connaissances en programmation.)</dd>
	</dl>
	",

	// argh, this is ugly
	'admin:widget:admin_welcome:outro' => '<br /> Soyez sûr de vérifier les ressources disponibles via les liens de bas de page et merci d\'utiliser Elgg !',

	'admin:widget:control_panel' => 'Panneau de Contrôle',
	'admin:widget:control_panel:help' => "Fourni un accès facile aux contrôles communs",

	'admin:cache:flush' => 'Nettoyer le cache',
	'admin:cache:flushed' => "Le cache du site a été nettoyé",

	'admin:footer:faq' => 'FAQ Administration',
	'admin:footer:manual' => 'Guide sur l\'administration',
	'admin:footer:community_forums' => 'Forums de la communauté Elgg',
	'admin:footer:blog' => 'Blog d\'Elgg',

	'admin:plugins:category:all' => 'Tous les plugins',
	'admin:plugins:category:active' => 'Plugins Actifs',
	'admin:plugins:category:inactive' => 'Plugins Inactifs',
	'admin:plugins:category:admin' => 'Admin',
	'admin:plugins:category:bundled' => 'Empaqueté',
	'admin:plugins:category:nonbundled' => 'Non-Empaqueté',
	'admin:plugins:category:content' => 'Contenu',
	'admin:plugins:category:development' => 'Développement',
	'admin:plugins:category:enhancement' => 'Améliorations',
	'admin:plugins:category:api' => 'Service/API',
	'admin:plugins:category:communication' => 'Communication',
	'admin:plugins:category:security' => 'Sécurité et spam',
	'admin:plugins:category:social' => 'Social',
	'admin:plugins:category:multimedia' => 'Multimédia',
	'admin:plugins:category:theme' => 'Thèmes',
	'admin:plugins:category:widget' => 'Widget',
	'admin:plugins:category:utility' => 'Utilitaires',

	'admin:plugins:markdown:unknown_plugin' => 'Plugin inconnu.',
	'admin:plugins:markdown:unknown_file' => 'fichier inconnu.',

	'admin:notices:could_not_delete' => 'Impossible de supprimer la remarque.',
	'item:object:admin_notice' => 'Remarques Administrateur',

	'admin:options' => 'Options Administrateur',

/**
 * Plugins
 */

	'plugins:disabled' => 'Les Plugins ne seront pas lus car un fichier nommé \'disabled\' (désactivé) est présent dans le répertoire mod.',
	'plugins:settings:save:ok' => "Le paramétrage du plugin %s a été enregistré.",
	'plugins:settings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres du plugin %s.",
	'plugins:usersettings:save:ok' => "Le paramétrage du plugin a été enregistré avec succès.",
	'plugins:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement du paramétrage du plugin %s.",
	'item:object:plugin' => 'Administrer les plugins',

	'admin:plugins' => "Administrer les plugins",
	'admin:plugins:activate_all' => 'Tout Activer',
	'admin:plugins:deactivate_all' => 'Tout Désactiver',
	'admin:plugins:activate' => 'Activer',
	'admin:plugins:deactivate' => 'Désactiver',
	'admin:plugins:description' => "Ce menu vous permet de contrôler et de configurer les outils installés sur votre site.",
	'admin:plugins:opt:linktext' => "Configurer les outils...",
	'admin:plugins:opt:description' => "Configurer les outils installés sur le site.",
	'admin:plugins:label:author' => "Auteur",
	'admin:plugins:label:copyright' => "Copyright",
	'admin:plugins:label:categories' => 'Catégories',
	'admin:plugins:label:licence' => "Licence",
	'admin:plugins:label:website' => "URL",
	'admin:plugins:label:repository' => "Code",
	'admin:plugins:label:bugtracker' => "Signaler un problème",
	'admin:plugins:label:donate' => "Don",
	'admin:plugins:label:moreinfo' => 'Plus d\'informations',
	'admin:plugins:label:version' => 'Version',
	'admin:plugins:label:location' => 'Adresse',
	'admin:plugins:label:contributors' => 'Contributeurs',
	'admin:plugins:label:contributors:name' => 'Nom',
	'admin:plugins:label:contributors:email' => 'E-mail',
	'admin:plugins:label:contributors:website' => 'Site web',
	'admin:plugins:label:contributors:username' => 'Identifiant',
	'admin:plugins:label:contributors:description' => 'Description',
	'admin:plugins:label:dependencies' => 'Dépendances',

	'admin:plugins:warning:elgg_version_unknown' => 'Ce plugin utilise un ancien fichier manifest.xml et ne précise pas si cette version est compatible avec l\'Elgg actuel. Il ne fonctionnera probablement pas !',
	'admin:plugins:warning:unmet_dependencies' => 'Ce plugin ne retrouve pas certaines dépendances et ne peut être activé. Vérifiez les dépendances pour plus d\'infos.',
	'admin:plugins:warning:invalid' => '%s n\'est pas un plugin valide d\'Elgg. Vérifiez <a href="http://docs.elgg.org/Invalid_Plugin">la documentation d\'Elgg</a> les conseils de dépannage.',
	'admin:plugins:warning:invalid:check_docs' => 'Vérifiez <a href="http://learn.elgg.org/fr/stable/appendix/faqs.html">la documentation d\'Elgg</a> - ou la version <a href="http://learn.elgg.org/en/stable/appendix/faqs.html">anglophone</a>, souvent plus complète - pour des astuces de débogage.',
	'admin:plugins:cannot_activate' => 'Activation impossible',

	'admin:plugins:set_priority:yes' => "%s réordonné",
	'admin:plugins:set_priority:no' => "Impossible de réordonner %s.",
	'admin:plugins:set_priority:no_with_msg' => "Impossible de réordonner %s. Erreur : %s",
	'admin:plugins:deactivate:yes' => "Désactiver %s.",
	'admin:plugins:deactivate:no' => "Impossible de désactiver %s.",
	'admin:plugins:deactivate:no_with_msg' => "Impossible de désactiver %s. Erreur : %s",
	'admin:plugins:activate:yes' => "%s activé.",
	'admin:plugins:activate:no' => "Impossible d'activer %s.",
	'admin:plugins:activate:no_with_msg' => "Impossible d'activer %s. Erreur : %s",
	'admin:plugins:categories:all' => 'Toutes les catégories',
	'admin:plugins:plugin_website' => 'Site du plugin',
	'admin:plugins:author' => '%s',
	'admin:plugins:version' => 'Version %s',
	'admin:plugin_settings' => 'Paramètres du plugin',
	'admin:plugins:warning:unmet_dependencies_active' => 'Ce plugin est actif, mais a des dépendances non satisfaites. Cela peut poser des problèmes. Voir \'plus d\'info\' ci-dessous pour plus de détails.',

	'admin:plugins:dependencies:type' => 'Type',
	'admin:plugins:dependencies:name' => 'Nom',
	'admin:plugins:dependencies:expected_value' => 'Valeur testée',
	'admin:plugins:dependencies:local_value' => 'Valeur réelle',
	'admin:plugins:dependencies:comment' => 'Commentaire',

	'admin:statistics:description' => "Cette page est un résumé des statistiques de votre site. Si vous avez besoin de statistiques plus détaillées, une version professionnelle d'administration est disponible.",
	'admin:statistics:opt:description' => "Visualiser les statistiques des utilisateurs et des objets de votre site.",
	'admin:statistics:opt:linktext' => "Voir statistiques...",
	'admin:statistics:label:basic' => "Statistiques basiques du site",
	'admin:statistics:label:numentities' => "Entités sur le site",
	'admin:statistics:label:numusers' => "Nombre d'utilisateurs",
	'admin:statistics:label:numonline' => "Nombre d'utilisateurs en ligne",
	'admin:statistics:label:onlineusers' => "Utilisateurs en ligne actuellement",
	'admin:statistics:label:admins'=>"Administrateurs",
	'admin:statistics:label:version' => "Version d'Elgg",
	'admin:statistics:label:version:release' => "Révision",
	'admin:statistics:label:version:version' => "Version",

	'admin:server:label:php' => 'PHP',
	'admin:server:label:web_server' => 'Serveur Web',
	'admin:server:label:server' => 'Serveur',
	'admin:server:label:log_location' => 'Emplacement du journal',
	'admin:server:label:php_version' => 'Version de PHP',
	'admin:server:label:php_ini' => 'Emplacement fichier PHP .ini',
	'admin:server:label:php_log' => 'Log PHP',
	'admin:server:label:mem_avail' => 'Mémoire disponible',
	'admin:server:label:mem_used' => 'Mémoire utilisée',
	'admin:server:error_log' => "Journal des erreurs web",
	'admin:server:label:post_max_size' => 'Taille maximum d\'un envoi',
	'admin:server:label:upload_max_filesize' => 'Taille maximum d\'un envoi de fichier',
	'admin:server:warning:post_max_too_small' => '(Remarque : la valeur de post_max_size doit supérieure à cette valeur pour supporter des envois de fichier de cette taille)',

	'admin:user:label:search' => "Trouver des membres :",
	'admin:user:label:searchbutton' => "Chercher",

	'admin:user:ban:no' => "Cet utilisateur ne peut pas être banni",
	'admin:user:ban:yes' => "Utilisateur banni.",
	'admin:user:self:ban:no' => "Vous ne pouvez pas vous bannir vous-même",
	'admin:user:unban:no' => "Cet utilisateur ne peut pas être réintégré",
	'admin:user:unban:yes' => "Utilisateur réintégré.",
	'admin:user:delete:no' => "Cet utilisateur ne peut pas être supprimé",
	'admin:user:delete:yes' => "Utilisateur supprimé",
	'admin:user:self:delete:no' => "Vous ne pouvez pas supprimer votre propre compte",

	'admin:user:resetpassword:yes' => "Mot de passe réinitialisé, l'utilisateur a été notifié par e-mail.",
	'admin:user:resetpassword:no' => "Le mot de passe n'a pas pu être réinitialisé.",

	'admin:user:makeadmin:yes' => "L'utilisateur est maintenant un administrateur.",
	'admin:user:makeadmin:no' => "Impossible de faire de cet utilisateur un administrateur.",

	'admin:user:removeadmin:yes' => "L'utilisateur n'est plus administrateur.",
	'admin:user:removeadmin:no' => "Impossible de supprimer les privilèges d'administrateur de cet utilisateur.",
	'admin:user:self:removeadmin:no' => "Vous ne pouvez pas supprimer vos propres privilèges d'administrateur.",

	'admin:appearance:menu_items' => 'Les éléments de menu',
	'admin:menu_items:configure' => 'Configurer les éléments du menu principal',
	'admin:menu_items:description' => 'Sélectionnez les éléments de menu que vous voulez afficher en liens directs. Les éléments de menu inutilisés seront ajoutées dans la liste «Plus».',
	'admin:menu_items:hide_toolbar_entries' => 'Supprimer les liens dans le menu barre d\'outils ?',
	'admin:menu_items:saved' => 'Les éléments de menu sauvés.',
	'admin:add_menu_item' => 'Ajouter un élément de menu personnalisé',
	'admin:add_menu_item:description' => 'Indiquez le nom à afficher et l\'URL correspondante afin d\'ajouter des éléments personnalisés à votre menu de navigation.',

	'admin:appearance:default_widgets' => 'Widgets par défaut',
	'admin:default_widgets:unknown_type' => 'Type de widget inconnu',
	'admin:default_widgets:instructions' => 'Ajoutez, supprimez, positionnez et configurez les widgets par défaut pour la page de profil.',

	'admin:robots.txt:instructions' => "Editez le fichier robots.txt du site",
	'admin:robots.txt:plugins' => "Les plugins ajoutent les lignes suivantes au fichier robots.txt ",
	'admin:robots.txt:subdir' => "L'outil pour robots.txt ne fonctionnera peut-être pas car Elgg est installé dans un sous-répertoire",
	'admin:robots.txt:physical' => "Le fichier robots.txt ne fonctionnera pas car un fichier robots.txt est physiquement présent",

	'admin:maintenance_mode:default_message' => 'Le site est indisponible pour cause de maintenance. Veuillez réessayer plus tard.',
	'admin:maintenance_mode:instructions' => "Le mode maintenance devrait être utilisé pour les mises à jour et les autres changements importants sur le site. <br />Quand ce mode est activé, seuls les administrateurs peuvent s'identifier sur le site et l'utiliser.",
	'admin:maintenance_mode:mode_label' => 'Mode maintenance',
	'admin:maintenance_mode:message_label' => 'Message affiché aux utilisateurs lorsque le mode maintenance est activé',
	'admin:maintenance_mode:saved' => 'Les paramètres du mode maintenance ont été sauvegardés.',
	'admin:maintenance_mode:indicator_menu_item' => 'Le site est en maintenance. ',
	'admin:login' => 'Identification Admin',

/**
 * User settings
 */
		
	'usersettings:description' => "Le panneau de configuration vous permet de contrôler tous vos outils et vos paramètres personnels. Choisissez une rubrique pour continuer.",

	'usersettings:statistics' => "Vos statistiques",
	'usersettings:statistics:opt:description' => "Afficher les statistiques des utilisateurs et des objets sur le site.",
	'usersettings:statistics:opt:linktext' => "Statistiques de votre compte.",

	'usersettings:user' => "Vos paramètres",
	'usersettings:user:opt:description' => "Ceci vous permet de contrôler vos paramètres.",
	'usersettings:user:opt:linktext' => "Changer vos paramètres",

	'usersettings:plugins' => "Outils",
	'usersettings:plugins:opt:description' => "Configurer vos paramètres (s'il y en a) pour activer vos outils.",
	'usersettings:plugins:opt:linktext' => "Configurer vos outils",

	'usersettings:plugins:description' => "Ce panneau de configuration vous permet de mettre à jour les options de vos outils installés par l'administrateur.",
	'usersettings:statistics:label:numentities' => "Vos entités",

	'usersettings:statistics:yourdetails' => "Vos informations",
	'usersettings:statistics:label:name' => "Votre nom",
	'usersettings:statistics:label:email' => "E-mail",
	'usersettings:statistics:label:membersince' => "Membre depuis",
	'usersettings:statistics:label:lastlogin' => "Dernière connexion",

/**
 * Activity river
 */
		
	'river:all' => 'Toute l\'activité du site',
	'river:mine' => 'Mon activité',
	'river:owner' => 'Activité de %s',
	'river:friends' => 'Activités des contacts',
	'river:select' => 'Afficher %s',
	'river:comments:more' => '+%u plus',
	'river:comments:all' => 'Voir tous les %u commentaires',
	'river:generic_comment' => 'commenté sur %s',

	'friends:widget:description' => "Affiche une partie de vos contacts.",
	'friends:num_display' => "Nombre de contacts à afficher",
	'friends:icon_size' => "Taille des icônes",
	'friends:tiny' => "minuscule",
	'friends:small' => "petit",

/**
 * Icons
 */

	'icon:size' => "Taille des icônes",
	'icon:size:topbar' => "Topbar",
	'icon:size:tiny' => "Mini",
	'icon:size:small' => "Petit",
	'icon:size:medium' => "Moyen",
	'icon:size:large' => "Large",
	'icon:size:master' => "Très large",
		
/**
 * Generic action words
 */

	'save' => "Enregistrer",
	'reset' => 'Réinitialiser',
	'publish' => "Publier",
	'cancel' => "Annuler",
	'saving' => "Enregistrement en cours",
	'update' => "Mettre à jour",
	'preview' => "Prévisualiser",
	'edit' => "Modifier",
	'delete' => "Supprimer",
	'accept' => "Accepter",
	'reject' => "Rejeter",
	'decline' => "Refuser",
	'approve' => "Accepter",
	'activate' => "Activer",
	'deactivate' => "Désactiver",
	'disapprove' => "Désapprouver",
	'revoke' => "Révoquer",
	'load' => "Charger",
	'upload' => "Charger",
	'download' => "Télécharger",
	'ban' => "Bannir",
	'unban' => "Réintégrer",
	'banned' => "Banni",
	'enable' => "Activer",
	'disable' => "Désactiver",
	'request' => "Requête",
	'complete' => "Complété",
	'open' => 'Ouvert',
	'close' => 'Fermer',
	'hide' => 'Masquer',
	'show' => 'Montrer',
	'reply' => "Répondre",
	'more' => 'Plus',
	'more_info' => 'Plus d\'information',
	'comments' => 'Commentaires',
	'import' => 'Importer',
	'export' => 'Exporter',
	'untitled' => 'Sans titre',
	'help' => 'Aide',
	'send' => 'Envoyer',
	'post' => 'Publier',
	'submit' => 'Soumettre',
	'comment' => 'Commentaire',
	'upgrade' => 'Mise à jour',
	'sort' => 'Trier',
	'filter' => 'Filtrer',
	'new' => 'Nouveau',
	'add' => 'Ajouter',
	'create' => 'Créer',
	'remove' => 'Enlever',
	'revert' => 'Rétablir',

	'site' => 'Site',
	'activity' => 'Activité',
	'members' => 'Membres',
	'menu' => 'Menu',

	'up' => 'Monter',
	'down' => 'Descendre',
	'top' => 'Au-dessus',
	'bottom' => 'Au-dessous',
	'right' => 'Droite',
	'left' => 'Gauche',
	'back' => 'Derrière',

	'invite' => "Inviter",

	'resetpassword' => "Réinitialiser le mot de passe",
	'changepassword' => "Changer le mot de passe",
	'makeadmin' => "Rendre administrateur",
	'removeadmin' => "Retirer administrateur",

	'option:yes' => "Oui",
	'option:no' => "Non",

	'unknown' => 'Inconnu',
	'never' => 'Jamais',

	'active' => 'Activé',
	'total' => 'Total',
	
	'ok' => 'OK',
	'any' => 'N\'importe',
	'error' => 'Erreur',
	
	'other' => 'Autre',
	'options' => 'Options',
	'advanced' => 'Avancées',

	'learnmore' => "Cliquer ici pour en savoir plus.",
	'unknown_error' => 'Erreur inconnue',

	'content' => "contenu",
	'content:latest' => 'Dernière activité',
	'content:latest:blurb' => 'Vous pouvez également cliquer ici pour voir les dernières modifications effectuées sur le site.',

	'link:text' => 'voir le lien',
	
/**
 * Generic questions
 */

	'question:areyousure' => 'Etes-vous sûr(e) ?',

/**
 * Status
 */

	'status' => 'Statut',
	'status:unsaved_draft' => 'Brouillon non enregistré',
	'status:draft' => 'Brouillon',
	'status:unpublished' => 'Dépublié',
	'status:published' => 'Publié',
	'status:featured' => 'En vedette',
	'status:open' => 'Ouvert',
	'status:closed' => 'Fermé',

/**
 * Generic sorts
 */

	'sort:newest' => 'Nouveaux',
	'sort:popular' => 'Populaires',
	'sort:alpha' => 'Alphabétique',
	'sort:priority' => 'Priorité',
		
/**
 * Generic data words
 */

	'title' => "Titre",
	'description' => "Description",
	'tags' => "Tags",
	'all' => "Tous",
	'mine' => "Moi",

	'by' => 'par',
	'none' => 'aucun',

	'annotations' => "Annotations",
	'relationships' => "Relations",
	'metadata' => "Métadonnées",
	'tagcloud' => "Nuage de tags",

	'on' => 'Actif',
	'off' => 'Inactif',

/**
 * Entity actions
 */
		
	'edit:this' => 'Modifier',
	'delete:this' => 'Supprimer',
	'comment:this' => 'Commenter',

/**
 * Input / output strings
 */

	'deleteconfirm' => "Etes-vous sûr(e) de vouloir supprimer cet élément ?",
	'deleteconfirm:plural' => "Etes-vous sûr(e) de vouloir supprimer ces éléments ?",
	'fileexists' => "Un fichier a déjà été chargé. Pour le remplacer sélectionner un nouveau fichier ci-dessous :",

/**
 * User add
 */

	'useradd:subject' => 'Compte de membre créé',
	'useradd:body' => '
%s,

Un compte de membre vous a été créé sur %s. Pour vous connecter, rendez-vous sur :
%s

Et connectez-vous avec les identifiants suivants :
 - Identifiant : %s
 - Mot de passe : %s
Vous pouvez également vous connecter avec votre e-mail au lieu de votre identifiant.

Une fois que vous vous êtes connecté(e), nous vous conseillons de changer votre mot de passe.
',

/**
 * System messages
 */

	'systemmessages:dismiss' => "Cliquer pour fermer",


/**
 * Import / export
 */
		
	'importsuccess' => "L'import des données a bien été effectué",
	'importfail' => "L'import des données OpenDD a échoué.",

/**
 * Time
 */

	'friendlytime:justnow' => "à l'instant",
	'friendlytime:minutes' => "il y a %s minutes",
	'friendlytime:minutes:singular' => "il y a une minute",
	'friendlytime:hours' => "il y a %s heures",
	'friendlytime:hours:singular' => "il y a une heure",
	'friendlytime:days' => "Il y a %s jours",
	'friendlytime:days:singular' => "hier",
	'friendlytime:date_format' => 'j F Y @ g:ia',
	
	'friendlytime:future:minutes' => "dans %s minutes",
	'friendlytime:future:minutes:singular' => "dans une minute",
	'friendlytime:future:hours' => "dans %s heures",
	'friendlytime:future:hours:singular' => "dans une heure",
	'friendlytime:future:days' => "dans %s jours",
	'friendlytime:future:days:singular' => "demain",

	'date:month:01' => 'Janvier %s',
	'date:month:02' => 'Février %s',
	'date:month:03' => 'Mars %s',
	'date:month:04' => 'Avril %s',
	'date:month:05' => 'Mai %s',
	'date:month:06' => 'Juin %s',
	'date:month:07' => 'Juillet %s',
	'date:month:08' => 'Août %s',
	'date:month:09' => 'Septembre %s',
	'date:month:10' => 'Octobre %s',
	'date:month:11' => 'Novembre %s',
	'date:month:12' => 'Décembre %s',

	'date:weekday:0' => 'dimanche',
	'date:weekday:1' => 'lundi',
	'date:weekday:2' => 'mardi',
	'date:weekday:3' => 'mercredi',
	'date:weekday:4' => 'jeudi',
	'date:weekday:5' => 'vendredi',
	'date:weekday:6' => 'samedi',
	
	'interval:minute' => 'chaque minute',
	'interval:fiveminute' => 'chaque cinq minutes',
	'interval:fifteenmin' => 'toutes les 15 minutes',
	'interval:halfhour' => 'toutes les demi-heures',
	'interval:hourly' => 'toutes les heures',
	'interval:daily' => 'tous les jours',
	'interval:weekly' => 'chaque semaine',
	'interval:monthly' => 'tous les mois',
	'interval:yearly' => 'chaque année',
	'interval:reboot' => 'Au redémarrage',

/**
 * System settings
 */

	'installation:sitename' => "Le nom de votre site :",
	'installation:sitedescription' => "Brève description du site (facultatif) : ",
	'installation:wwwroot' => "L'URL du site, suivie de ' / ' : ",
	'installation:path' => "Chemin physique des fichiers sur le serveur, suivi de ' / ' : ",
	'installation:dataroot' => "Chemin complet où seront hébergés les fichiers uploadés par les utilisateurs, suivi de ' / ' :",
	'installation:dataroot:warning' => "Vous devez créer ce répertoire manuellement. Il doit se situer dans un répertoire différent de votre installation de Elgg.",
	'installation:sitepermissions' => "Les permissions d'accés par défaut : ",
	'installation:language' => "La langue par défaut de votre site : ",
	'installation:debug' => "Le mode de débogage permet de mettre en évidence certaines erreurs de fonctionnement, cependant il ralentit l'accès au site, et devrait être utilisé uniquement en cas de problème :",
	'installation:debug:label' => "Niveau de journalisation :",
	'installation:debug:none' => 'Désactivé (recommandé)',
	'installation:debug:error' => 'Seulement les erreurs critiques',
	'installation:debug:warning' => 'Erreurs et avertissements',
	'installation:debug:notice' => 'Toutes les erreurs, avertissements et avis',
	'installation:debug:info' => 'Enregistrer tout :',

	// Walled Garden support
	'installation:registration:description' => "L'enregistrement d'un nouveau membre est activé par défaut. Désactivez cette option si vous ne voulez pas que de nouvelles personnes soient en mesure de s'inscrire par elles-mêmes.",
	'installation:registration:label' => 'Permettre à de nouveaux membres de s\'inscrire eux-mêmes',
	'installation:walled_garden:description' => 'Faire du site un réseau privé. Cela empêchera les visiteurs non connectés d\'afficher les pages du site autres que celles expressément spécifiées comme publiques.',
	'installation:walled_garden:label' => "Réserver l'accès aux pages aux membres connectés",

	'installation:httpslogin' => "Activer ceci afin que les utilisateurs puissent se connecter via le protocole HTTPS. Vous devez avoir HTTPS activé sur votre serveur afin que cela fonctionne.",
	'installation:httpslogin:label' => "Activer les connexions HTTPS",
	'installation:view' => "Entrer le nom de la vue qui sera utilisée automatiquement pour l'affichage du site (par exemple : 'mobile'), laissez par défaut en cas de doute :",

	'installation:siteemail' => "L'adresse e-mail du site (utilisée lors de l'envoi d'e-mails par le système)",
	'installation:default_limit' => "Nombre d'éléments par page par défaut",

	'admin:site:access:warning' => "Changer les paramètres d'accès n'affectera que les permissions des  contenus créées dans le futur.",
	'installation:allow_user_default_access:description' => "Si coché, les membres pourront définir leur propre niveau d'accés par défaut, qui s'appliquera à la place de celui défini par défaut dans le système.",
	'installation:allow_user_default_access:label' => "Autoriser un niveau d'accés par défaut pour les membres",

	'installation:simplecache:description' => "Le cache simple augmente les performances en mettant en cache du contenu statique comme des CSS et des fichiers Javascripts. Normalement vous ne devriez pas avoir besoin de l'activer.",
	'installation:simplecache:label' => "Utiliser un cache simple (recommandé)",

	'installation:minify:description' => "Le cache peut être amélioré en compressant les fichiers JavaScript et  CSS. (Il est nécessaire que le cache simple soit activé). ",
	'installation:minify_js:label' => "Compresser le JavaScript (recommandé)",
	'installation:minify_css:label' => "Compresser les CSS (recommandé)",

	'installation:htaccess:needs_upgrade' => "Vous devez mettre à jour votre fichier .htaccess afin que le chemin soit ajouté au paramètre GET __elgg_uri (vous pouvez vous aider de htaccess_dist)",
	'installation:htaccess:localhost:connectionfailed' => "Elgg ne peut pas se connecter à lui-même pour tester les règles de réécriture. Veuillez vérifier si l'extension curl fonctionne, et qu'il n'y a pas de restriction au niveau des IP interdisant de se connecter depuis localhost.",
	
	'installation:systemcache:description' => "Le cache système diminue le temps de chargement du moteur Elgg en mettant en cache les données dans des fichiers.",
	'installation:systemcache:label' => "Utiliser le cache système (recommandé)",

	'admin:legend:system' => 'Système',
	'admin:legend:caching' => 'Mise en cache',
	'admin:legend:content_access' => "Niveau d'accès par défaut (nouveaux contenus)",
	'admin:legend:site_access' => 'Accès au site',
	'admin:legend:debug' => 'Débugger',

	'upgrading' => 'Mise à jour en cours',
	'upgrade:db' => 'Votre base de données a été mise à jour.',
	'upgrade:core' => 'Votre installation d\'Elgg a été mise à jour.',
	'upgrade:unlock' => 'Déverrouiller la mise à jour',
	'upgrade:unlock:confirm' => "La base de données est verrouillée par une autre mise à jour. Exécuter des mises à jours concurrentes est dangereux. Vous devriez continuer seulement si vous savez qu'il n'y a pas d'autre mise à jour en cours d'exécution. Déverrouiller ?",
	'upgrade:locked' => "Impossible de mettre à jour. Une autre mise à jour est en cours. Pour effacer le verrouillage de la mise à jour, visiter la partie administrateur.",
	'upgrade:unlock:success' => "Mise à niveau débloquée.",
	'upgrade:unable_to_upgrade' => 'Impossible de mettre à jour.',
	'upgrade:unable_to_upgrade_info' => 'Cette installation ne peut pas être mise à jour, car des fichiers de l\'ancienne version ont été détectées dans le noyau d\'Elgg. Ces fichiers sont obsolètes et doivent être supprimés pour qu\'Elgg fonctionne correctement. Si vous n\'avez pas modifié les fichiers du noyau d\'Elgg, vous pouvez simplement supprimer le répertoire noyau et le remplacer par celui de la dernière version d\'Elgg téléchargée  depuis <a href="http://elgg.org> elgg.org" </ a>. <br /> <br />

Si vous avez besoin d\'instructions détaillées, veuillez visiter la <a href="http://learn.elgg.org/en/stable/admin/upgrading.html">Documentation sur la mise à niveau d\'Elgg</ a>. Si vous avez besoin d\'aide, veuillez poser votre question dans les <a href="http://community.elgg.org/pg/groups/discussion/"> Forums d\'aide technique communautaire</ a>.',

	'update:twitter_api:deactivated' => 'Twitter API (précédemment Twitter Service) a été désactivé lors de la mise à niveau. Veuillez l\'activer manuellement si nécessaire.',
	'update:oauth_api:deactivated' => 'OAuth API (précédemment OAuth Lib) a été désactivé lors de la mise à niveau. Veuillez l\'activer manuellement si nécessaire.',
	'upgrade:site_secret_warning:moderate' => "Vous êtes invité à régénérer la clé de votre site afin d'améliorer sa sécurité. Voir dans Configuration / Paramètres avancés",
	'upgrade:site_secret_warning:weak' => "Vous êtes fortement encouragé à régénérer la clé de votre site afin d'améliorer la sécurité de votre système. Voir dans Configuration / Paramètres avancés",

	'deprecated:function' => '%s() est obsolète et a été remplacé par %s()',

	'admin:pending_upgrades' => 'Le site a des mises à niveau en attente qui nécessitent votre attention immédiate.',
	'admin:view_upgrades' => 'Afficher les mises à jour en attente.',
 	'admin:upgrades' => 'Mise à niveau',
	'item:object:elgg_upgrade' => 'Site mis à jour',
	'admin:upgrades:none' => 'Votre traduction est à jour !',

	'upgrade:item_count' => 'Il y a <b>%s</b> éléments qui doivent être mis à niveau.',
	'upgrade:warning' => '<b>Attention :</b> sur un site volumineux cette mise à jour peut prendre un temps significatif (voire très long) !',
	'upgrade:success_count' => 'Mise à jour :',
	'upgrade:error_count' => 'Erreurs :',
	'upgrade:river_update_failed' => 'Impossible de mettre à jour l\'entrée du flux de l\'élément d\'identifiant id %s',
	'upgrade:timestamp_update_failed' => 'Impossible de mettre à jour l\'horodatage de l\'élément d\'identifiant id %s',
	'upgrade:finished' => 'Mise à jour terminée',
	'upgrade:finished_with_errors' => '<p>Mise à jour terminée sans erreur. Rafraîchissez la page et tentez de relancer la mise à jour.</p></p><br />Si vous avez encore cette erreur, vérifiez le contenu du log d\'erreurs du serveur. Vous pouvez chercher de l\'aide sur cette erreur dans le <a href="http://community.elgg.org/groups/profile/179063/elgg-technical-support">groupe de support technique</a> de la communauté Elgg.</p>',

	// Strings specific for the comments upgrade
	'admin:upgrades:comments' => 'Mise à jour des commentaires',
	'upgrade:comment:create_failed' => 'Impossible de convertir le commentaire id %s en une entité.',
	'admin:upgrades:commentaccess' => 'Mise à jour des commentaires',

	// Strings specific for the datadir upgrade
	'admin:upgrades:datadirs' => 'Répertoire de données mis à jour',

	// Strings specific for the discussion reply upgrade
	'admin:upgrades:discussion_replies' => 'Réponses aux discussions mises à jour',
	'discussion:upgrade:replies:create_failed' => 'Impossible de convertir la discussion id %s en une entité.',

/**
 * Welcome
 */

	'welcome' => "Bienvenue",
	'welcome:user' => 'Bienvenue %s',

/**
 * Emails
 */
		
	'email:from' => 'De',
	'email:to' => 'Pour',
	'email:subject' => 'Sujet',
	'email:body' => 'Corps de l\'article',
	
	'email:settings' => "Paramètres e-mail",
	'email:address:label' => "Votre adresse e-mail",

	'email:save:success' => "Nouvelle adresse e-mail enregistrée. Une vérification a été envoyée.",
	'email:save:fail' => "Votre nouvelle adresse e-mail n'a pas pu être enregistrée.",

	'friend:newfriend:subject' => "%s vous a ajouté comme contact !",
	'friend:newfriend:body' => "%s vous a ajouté comme contact !

Pour voir son profil cliquer sur le lien ci-dessous

	%s

Vous ne pouvez pas répondre à cet e-mail.",

	'email:changepassword:subject' => "Mot de passe modifié !",
	'email:changepassword:body' => "Bonjour %s,

Votre mot de passe a été modifié.",

	'email:resetpassword:subject' => "Réinitialisation du mot de passe !",
	'email:resetpassword:body' => "Bonjour %s,

Votre nouveau mot de passe est : %s",

	'email:changereq:subject' => "Demander un nouveau mot de passe.",
	'email:changereq:body' => "Bonjour %s,

Quelqu'un (à partir de l'adresse IP %s) a demandé un changement de mot de passe pour votre compte.

Si vous êtes à l'origine de cette demande, cliquez sur le lien ci-dessous pour confirmer votre demande.
%s

Sinon ignorez cet e-mail.
",

/**
 * user default access
 */

	'default_access:settings' => "Votre niveau d'accès par défaut",
	'default_access:label' => "Accès par défaut",
	'user:default_access:success' => "Votre nouveau niveau d'accès par défaut a été enregistré.",
	'user:default_access:failure' => "Votre nouveau niveau d'accès par défaut n'a pas pu être enregistré.",

/**
 * Comments
 */

	'comments:count' => "%s commentaire(s)",
	'item:object:comment' => 'Commentaires',

	'river:comment:object:default' => '%s a commenté %s',

	'generic_comments:add' => "Laisser un commentaire",
	'generic_comments:edit' => "Modifier le commentaire",
	'generic_comments:post' => "Publier un commentaire",
	'generic_comments:text' => "Commentaire",
	'generic_comments:latest' => "Derniers commentaires",
	'generic_comment:posted' => "Votre commentaire a bien été publié.",
	'generic_comment:updated' => "Le commentaire a été mis à jour.",
	'generic_comment:deleted' => "Votre commentaire a bien été supprimé.",
	'generic_comment:blank' => "Désolé ; vous devez écrire un commentaire avant de pouvoir l'enregistrer.",
	'generic_comment:notfound' => "Désolé ; l'élément recherché n'a pas été trouvé.",
	'generic_comment:notfound_fallback' => "Désolé, le commentaire demandé n'a pas été trouvé. Vous avez été redirigé sur la page précédente.",
	'generic_comment:notdeleted' => "Désolé; le commentaire n'a pu être supprimé.",
	'generic_comment:failure' => "Une erreur inattendue a eu lieu pendant la sauvegarde du commentaire.",
	'generic_comment:none' => 'Pas de commentaire',
	'generic_comment:title' => 'Commentaire de %s',
	'generic_comment:on' => '%s sur %s',
	'generic_comments:latest:posted' => 'publié un',

	'generic_comment:email:subject' => 'Vous avez un nouveau commentaire !',
	'generic_comment:email:body' => "Vous avez un nouveau commentaire sur l'élément '%s' de %s :


%s


Pour répondre ou voir le contenu de référence, suivez le lien :
%s

Pour voir le profil de %s, suivez ce lien :
%s

Merci de ne pas répondre à cet e-mail.
",

/**
 * Entities
 */
	
	'byline' => 'Par %s',
	'entity:default:strapline' => 'Créé le %s par %s',
	'entity:default:missingsupport:popup' => 'Cette entité ne peut pas être affichée correctement. C\'est peut-être dû à un plugin qui a été supprimé.',

	'entity:delete:success' => "L'entité %s a été supprimée",
	'entity:delete:fail' => "L'entité %s n'a pas pu être supprimée",
	
	'entity:can_delete:invaliduser' => "Impossible de vérifier ->canDelete pour user_guid [%s] car l'utilisateur n'existe pas.",

/**
 * Action gatekeeper
 */

	'actiongatekeeper:missingfields' => "Votre session de connexion n'est plus valide (session ou jetons de sécurité __token ou __ts manquants). En cas d'erreur, veuillez recharger la page et ré-essayer.",
	'actiongatekeeper:tokeninvalid' => "Votre session de connexion n'est plus valide (session ou jetons de sécurité __token ou __ts invalides). Veuillez recharger la page et ré-essayer.",
	'actiongatekeeper:timeerror' => 'La page a expiré, rafraichissez et recommencez à nouveau.',
	'actiongatekeeper:pluginprevents' => 'Une extension a empêché ce formulaire d\'être envoyé',
	'actiongatekeeper:uploadexceeded' => 'La taille du fichier dépasse la limite définie par l\'administrateur du site',
	'actiongatekeeper:crosssitelogin' => "Désolé, il n'est pas permis de se connecter depuis un autre nom de domaine. Veuillez réessayer.",

/**
 * Word blacklists
 */

	// Note : these are stop words
	'word:blacklist' => 'alors, au, aucuns, aussi, autre, avant, avec, avoir, bon, ça, car, ce, cela, ces, ceux, chaque, ci, comme, comment, dans, début, dedans, dehors, depuis, des, devrait, doit, donc, dos, du, elle, elles, en, encore, essai, est, et, étaient, état, été, étions, être, eu, fait, faites, fois, font, hors, ici, il, ils, je, juste, la, là, le, les, leur, ma, maintenant, mais, même, mes, mine, moins, mon, mot, ni, nommés, notre, nous, ou, où, par, parce, pas, peu, peut, plupart, pour, pourquoi, quand, que, quel, quelle, quelles, quels, qui, sa, sans, ses, seulement, si, sien, son, sont, sous, soyez, sujet, sur, ta, tandis, tellement, tels, tes, ton, tous, tout, très, trop, tu, voient, vont, votre, vous, vu',

/**
 * Tag labels
 */

	'tag_names:tags' => 'Tags',

/**
 * Javascript
 */

	'js:security:token_refresh_failed' => 'Impossible de contacter %s. Vous risquez de ne pas pouvoir enregistrer le contenu. Veuillez rafraîchir cette page.',
	'js:security:token_refreshed' => 'La connexion à %s est rétablie !',
	'js:lightbox:current' => "image %s de %s",

/**
 * Miscellaneous
 */
	'elgg:powered' => "Propulsé par Elgg / ESOPE",

/**
 * Languages according to ISO 639-1 (with a couple of exceptions)
 */

	"aa" => "Afar",
	"ab" => "Abkhaze",
	"af" => "Afrikaans",
	"am" => "Amharique",
	"ar" => "Arabe",
	"as" => "Assamais",
	"ay" => "Aymara",
	"az" => "Azéri",
	"ba" => "Bachkir",
	"be" => "Biélorusse",
	"bg" => "Bulgare",
	"bh" => "Bihari",
	"bi" => "Bichelamar",
	"bn" => "Bengalî",
	"bo" => "Tibétain",
	"br" => "Breton",
	"ca" => "Catalan",
	"cmn" => "Chinois Mandarin", // ISO 639-3
	"co" => "Corse",
	"cs" => "Tchèque",
	"cy" => "Gallois",
	"da" => "Danois",
	"de" => "Allemand",
	"dz" => "Dzongkha",
	"el" => "Grec",
	"en" => "Anglais",
	"eo" => "Espéranto",
	"es" => "Espagnol",
	"et" => "Estonien",
	"eu" => "Basque",
	"eu_es" => "Basque (Espagne)",
	"fa" => "Persan",
	"fi" => "Finnois",
	"fj" => "Fidjien",
	"fo" => "Féringien",
	"fr" => "Français",
	"fy" => "Frison",
	"ga" => "Irlandais",
	"gd" => "Écossais",
	"gl" => "Galicien",
	"gn" => "Guarani",
	"gu" => "Gujarâtî",
	"he" => "Hébreu",
	"ha" => "Haoussa",
	"hi" => "Hindî",
	"hr" => "Croate",
	"hu" => "Hongrois",
	"hy" => "Arménien",
	"ia" => "Interlingua",
	"id" => "Indonésien",
	"ie" => "Occidental",
	"ik" => "Inupiaq",
	//"in" => "Indonésien",
	"is" => "Islandais",
	"it" => "Italien",
	"iu" => "Inuktitut",
	"iw" => "Hébreu (obsolète)",
	"ja" => "Japonais",
	"ji" => "Yiddish (obsolète)",
	"jw" => "Javanais",
	"ka" => "Géorgien",
	"kk" => "Kazakh",
	"kl" => "Kalaallisut",
	"km" => "Khmer",
	"kn" => "Kannara",
	"ko" => "Coréen",
	"ks" => "Kashmiri",
	"ku" => "Kurde",
	"ky" => "Kirghiz",
	"la" => "Latin",
	"ln" => "Lingala",
	"lo" => "Lao",
	"lt" => "Lituanien",
	"lv" => "Letton",
	"mg" => "Malgache",
	"mi" => "Maori",
	"mk" => "Macédonien",
	"ml" => "Malayalam",
	"mn" => "Mongol",
	"mo" => "Moldave",
	"mr" => "Marâthî",
	"ms" => "Malais",
	"mt" => "Maltais",
	"my" => "Birman",
	"na" => "Nauruan",
	"ne" => "Népalais",
	"nl" => "Néerlandais",
	"no" => "Norvégien",
	"oc" => "Occitan",
	"om" => "Oromo",
	"or" => "Oriya",
	"pa" => "Panjâbî",
	"pl" => "Polonais",
	"ps" => "Pachto",
	"pt" => "Portugais",
	"pt_br" => 'Portugais (Brésil)',
	"qu" => "Quechua",
	"rm" => "Romanche",
	"rn" => "Kirundi",
	"ro" => "Roumain",
	"ro_ro" => "Roumain (Roumanie)",
	"ru" => "Russe",
	"rw" => "Kinyarwanda",
	"sa" => "Sanskrit",
	"sd" => "Sindhi",
	"sg" => "Sango",
	"sh" => "Serbo-Croate",
	"si" => "Cingalais",
	"sk" => "Slovaque",
	"sl" => "Slovène",
	"sm" => "Samoan",
	"sn" => "Shona",
	"so" => "Somalien",
	"sq" => "Albanais",
	"sr" => "Serbe",
	"sr_latin" => "Serbe (Latin)",
	"ss" => "Siswati",
	"st" => "Sotho",
	"su" => "Soundanais",
	"sv" => "Suédois",
	"sw" => "Swahili",
	"ta" => "Tamoul",
	"te" => "Télougou",
	"tg" => "Tadjik",
	"th" => "Thaï",
	"ti" => "Tigrinya",
	"tk" => "Turkmène",
	"tl" => "Tagalog",
	"tn" => "Tswana",
	"to" => "Tongien",
	"tr" => "Turc",
	"ts" => "Tsonga",
	"tt" => "Tatar",
	"tw" => "Twi",
	"ug" => "Ouïghour",
	"uk" => "Ukrainien",
	"ur" => "Ourdou",
	"uz" => "Ouzbek",
	"vi" => "Vietnamien",
	"vo" => "Volapük",
	"wo" => "Wolof",
	"xh" => "Xhosa",
	//"y" => "Yiddish",
	"yi" => "Yiddish",
	"yo" => "Yoruba",
	"za" => "Zhuang",
	"zh" => "Chinois",
	"zh_hans" => "Chinois simplifié",
	"zu" => "Zoulou",
);
