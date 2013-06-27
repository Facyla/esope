<?php
/**
 * Core French Language
 *
 * @package Elgg.Core
 * @subpackage Languages.French
 */

$french = array(
/**
 * Sites
 */

	'item:site' => "Sites",

/**
 * Sessions
 */

	'login' => "Connexion",
	'loginok' => "Vous êtes désormais connecté(e).",
	'loginerror' => "Nous n'avons pas pu vous identifier. Assurez-vous que les informations que vous avez saisies sont correctes et réessayez.",
	'login:empty' => "Un nom d'utilisateur et un mot de passe sont requis.",
	'login:baduser' => "Impossible de charger votre compte d'utilisateur.",
	'auth:nopams' => "Erreur interne. Aucune méthode d'authentification des utilisateurs installés.",

	'logout' => "Déconnexion",
	'logoutok' => "Vous avez été déconnecté(e).",
	'logouterror' => "Nous n'avons pas pu vous déconnecter. Essayez de nouveau.",

	'loggedinrequired' => "Vous devez être connecté pour voir cette page.",
	'adminrequired' => "Vous devez être administrateur pour voir cette page.",
	'membershiprequired' => "Vous devez être membre de ce groupe pour voir cette page.",


/**
 * Errors
 */
	'exception:title' => "Bienvenue sur Elgg.",

	'actionundefined' => "L'action demandée (%s) n'est pas définie par le système.",
	'actionnotfound' => "Le fichier d'action pour %s n'a pas été trouvé.",
	'actionloggedout' => "Désolé, vous ne pouvez pas effectuer cette action sans être connecté.",
	'actionunauthorized' => "Vous n'êtes pas autorisé à effectuer cette action",

	'InstallationException:SiteNotInstalled' => "Impossible de traiter cette requête. Ce site n'est pas configuré ou la base de données est en panne.",

	'InstallationException:MissingLibrary' => "Impossible de charger %s",
	'InstallationException:CannotLoadSettings' => "Elgg n'a pas pu charger le fichier de paramètres. Il n'existe pas ou il y a un problème de d'autorisations.",

	'SecurityException:Codeblock' => "Accès non autorisé pour la création de bloc de code.",
	'DatabaseException:WrongCredentials' => "Elgg n'a pas pu se connecter à la base de données avec les informations données. Vérifiez les paramètres.",
	'DatabaseException:NoConnect' => "Elgg n'a pas pu sélectionner la base de données '%s', merci de vérifier que la base de données est bien créée et que vous y avez accès.",
	'SecurityException:FunctionDenied' => "L'accès à la fonction privilégiée '%s' n'est pas autorisé.",
	'DatabaseException:DBSetupIssues' => "Il y a eu plusieurs problèmes :",
	'DatabaseException:ScriptNotFound' => "Elgg n'a pas pu trouver le script de la base de données a %s.",
	'DatabaseException:InvalidQuery' => "Requête non valide",

	'IOException:FailedToLoadGUID' => "Echec du chargement du nouveau %s avec le GUID:%d",
	'InvalidParameterException:NonElggObject' => "Passage d'un objet de type non-Elgg vers un constructeur d'objet Elgg !",
	'InvalidParameterException:UnrecognisedValue' => "Valeur non reconnue passés au constructeur.",

	'InvalidClassException:NotValidElggStar' => "guid : %d n'est pas valide %s",

	'PluginException:MisconfiguredPlugin' => "%s (guid : %s) est un plugin non configuré. Il a été désactivé. Veuillez chercher dans le wiki d'Elgg pour connaître les cause possibles (http://docs.elgg.org/wiki/).",
	'PluginException:CannotStart' => "%s (guid : %s) ne peut pas démarrer. Raison : %s",
	'PluginException:InvalidID' => "%s est un ID de plugin invalide.",
	'PluginException:InvalidPath' => "%s est un chemin invalide pour le plugin.",
	'PluginException:InvalidManifest' => "Fichier manifest.xml invalide pour le plugin %s",
	'PluginException:InvalidPlugin' => "%s n'est pas un plugin valide.",
	'PluginException:InvalidPlugin:Details' => "%s n'est pas valide. plugin : %s",

	'ElggPlugin:MissingID' => "Manque l'ID du plugin (guid %s)",
	'ElggPlugin:NoPluginPackagePackage' => "Manque le paquet d'Elgg 'ElggPluginPackage' du plugin ID %s (guid %s)",

	'ElggPluginPackage:InvalidPlugin:MissingFile' => "Manque le fichier %s dans le paquet",
	'ElggPluginPackage:InvalidPlugin:InvalidDependency' => "Type '%s' des dépendances invalide",
	'ElggPluginPackage:InvalidPlugin:InvalidProvides' => "Type '%s' invalide",
	'ElggPluginPackage:InvalidPlugin:CircularDep' =>"%s invalide dans dépendance '%s', dans le plugin %s. Les plugins ne peuvent pas être en conflit avec, ou avoir besoin de quelque chose, qu'ils contiennent !",

	'ElggPlugin:Exception:CannotIncludeFile' => "Impossible d'inclure %s pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterViews' => "Impossible d'ouvrir la vue dir pour le plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterLanguages' => "Impossible d'enregistrer les langues pour le plugin %s (guid : %s) sur %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:CannotRegisterClasses' => "Impossible d'enregistrer les classes pour plugin %s (guid : %s) ici %s. Vérifiez les autorisations !",
	'ElggPlugin:Exception:NoID' => "Aucun ID pour le plugin guid %s !",

	'PluginException:ParserError' => "Erreur de syntaxe du fichier manifest.xml avec la version %s de l'API du plugin %s.",
	'PluginException:NoAvailableParser' => "Analyseur syntaxique du fichier manifest.xml introuvable pour l'API version %s du plugin %s.",
	'PluginException:ParserErrorMissingRequiredAttribute' => "L'attribut nécessaire '%s' manque dans le fichier manifest.xml pour le plugin %s.",

	'ElggPlugin:Dependencies:Requires' => "Requis",
	'ElggPlugin:Dependencies:Suggests' => "Suggestion",
	'ElggPlugin:Dependencies:Conflicts' => "Conflits",
	'ElggPlugin:Dependencies:Conflicted' => "En conflit",
	'ElggPlugin:Dependencies:Provides' => "Fournit",
	'ElggPlugin:Dependencies:Priority' => "Priorité",

	'ElggPlugin:Dependencies:Elgg' => "version d'Elgg",
	'ElggPlugin:Dependencies:PhpExtension' => "extension PHP : %s",
	'ElggPlugin:Dependencies:PhpIni' => "Paramètre PHP ini : %s",
	'ElggPlugin:Dependencies:Plugin' => "Plugin: %s",
	'ElggPlugin:Dependencies:Priority:After' => "Après %s",
	'ElggPlugin:Dependencies:Priority:Before' => "Avant %s",
	'ElggPlugin:Dependencies:Priority:Uninstalled' => "%s n'est pas installé",
	'ElggPlugin:Dependencies:Suggests:Unsatisfied' => "Manquant",


	'InvalidParameterException:NonElggUser' => "Passage d'un utilisateur de type non-Elgg vers un constructeur d'utilisateur Elgg !",

	'InvalidParameterException:NonElggSite' => "Passage d'un site non-Elgg vers un constructeur de site Elgg !",

	'InvalidParameterException:NonElggGroup' => "Passage d'un groupe non-Elgg vers un constructeur de groupe Elgg !",

	'IOException:UnableToSaveNew' => "Impossible de sauvegarder le nouveau %s",

	'InvalidParameterException:GUIDNotForExport' => "GUID non spécifié durant l'export, ceci ne devrait pas se produire.",
	'InvalidParameterException:NonArrayReturnValue' => "La fonction de sérialisation de l'entité a retourné une valeur dont le type n'est pas un tableau",

	'ConfigurationException:NoCachePath' => "Le chemin du cache est vide !",
	'IOException:NotDirectory' => "%s n'est pas un répertoire.",

	'IOException:BaseEntitySaveFailed' => "Impossibilité de sauver les informations de base du nouvel objet !",
	'InvalidParameterException:UnexpectedODDClass' => "import() a passé un argument qui n'est pas du type ODD class",
	'InvalidParameterException:EntityTypeNotSet' => "Le type d'entité doit être renseigné.",

	'ClassException:ClassnameNotClass' => "%s n'est pas %s.",
	'ClassNotFoundException:MissingClass' => "La classe '%s' n'a pas été trouvée, le plugin serait-il manquant ?",
	'InstallationException:TypeNotSupported' => "Le type %s n'est pas supporté. Il y a une erreur dans votre installation, le plus souvent causé par une mise à jour non-complète.",

	'ImportException:ImportFailed' => "Impossible d'importer l'élément %d",
	'ImportException:ProblemSaving' => "Une erreur est survenue en sauvant %s",
	'ImportException:NoGUID' => "La nouvelle entité a été créée mais n'a pas de GUID, ceci ne devrait pas se produire.",

	'ImportException:GUIDNotFound' => "L'entité '%d' n'a pas été trouvée.",
	'ImportException:ProblemUpdatingMeta' => "Il y a eu un problème lors de la mise à jour de '%s' pour l'entité '%d'",

	'ExportException:NoSuchEntity' => "Il n'y a pas d'entité telle que GUID:%d",

	'ImportException:NoODDElements' => "Aucun élément OpenDD n'a été trouvé dans les données importées, l'importation a échoué.",
	'ImportException:NotAllImported' => "Tous les éléments n'ont pas été importés.",

	'InvalidParameterException:UnrecognisedFileMode' => "Mode de fichier non-reconnu : '%s'",
	'InvalidParameterException:MissingOwner' => "Tous les fichiers doivent avoir un propriétaire",
	'IOException:CouldNotMake' => "Impossible de faire %s",
	'IOException:MissingFileName' => "Vous devez spécifier un nom avant d'ouvrir un fichier.",
	'ClassNotFoundException:NotFoundNotSavedWithFile' => "Fichiers stockés non trouvés ou classes non sauvegardées avec le fichier !",
	'NotificationException:NoNotificationMethod' => "Aucune méthode de notification spécifiée.",
	'NotificationException:NoHandlerFound' => "Aucune fonction trouvée pour '%s' ou elle ne peut être appelée.",
	'NotificationException:ErrorNotifyingGuid' => "Une erreur s'est produite lors de la notification %d",
	'NotificationException:NoEmailAddress' => "Impossible de trouver une adresse e-mail pour GUID:%d",
	'NotificationException:MissingParameter' => "Un argument obligatoire a été omis, '%s'",

	'DatabaseException:WhereSetNonQuery' => "La requête where ne contient pas de WhereQueryComponent",
	'DatabaseException:SelectFieldsMissing' => "Des champs sont manquants sur la requête de sélection.",
	'DatabaseException:UnspecifiedQueryType' => "Type de requête non-reconnue ou non-spécifiée.",
	'DatabaseException:NoTablesSpecified' => "Aucune table spécifiée pour la requête.",
	'DatabaseException:NoACL' => "Pas de liste d'accès fourni pour la requête",

	'InvalidParameterException:NoEntityFound' => "Aucune entité trouvée, soit elle est inexistante, soit vous n'y avez pas accès.",

	'InvalidParameterException:GUIDNotFound' => "GUID : %s n'a pas été trouvé ou vous n'y avez pas accès.",
	'InvalidParameterException:IdNotExistForGUID' => "Désolé, '%s' n'existe pas pour GUID : %d",
	'InvalidParameterException:CanNotExportType' => "Désolé, je ne sais pas comment exporter '%s'",
	'InvalidParameterException:NoDataFound' => "Aucune donnée trouvée.",
	'InvalidParameterException:DoesNotBelong' => "N'appartient pas à l'entité.",
	'InvalidParameterException:DoesNotBelongOrRefer' => "N'appartient pas ou aucune référence à l'entité.",
	'InvalidParameterException:MissingParameter' => "Paramètre manquant, il faut fournir un GUID.",
	'InvalidParameterException:LibraryNotRegistered' => "%s n'est pas une bibliothèque enregistré",

	'APIException:ApiResultUnknown' => "Les résultats de API sont de types inconnus, ceci ne devrait pas se produire.",
	'ConfigurationException:NoSiteID' => "L'identifiant du site n'a pas été spécifié.",
	'SecurityException:APIAccessDenied' => "Désolé, l'accès API a été désactivé par l'administrateur.",
	'SecurityException:NoAuthMethods' => "Aucune méthode d'authentification n'a été trouvée pour cette requête API.",
	'InvalidParameterException:APIMethodOrFunctionNotSet' => "Methode ou fonction non définie dans expose_method()",
	'InvalidParameterException:APIParametersArrayStructure' => "Le paramètre de structure 'array' est incorrect pour appeller to expose method '%s'",
	'InvalidParameterException:UnrecognisedHttpMethod' => "Methode HTTP %s pour la methode API '%s' non reconnue",
	'APIException:MissingParameterInMethod' => "Argument %s manquant pour la méthode %s",
	'APIException:ParameterNotArray' => "%s n'est semble t-il pas un tableau.",
	'APIException:UnrecognisedTypeCast' => "Type %s non reconnu pour la variable '%s' pour la fonction '%s'",
	'APIException:InvalidParameter' => "Paramètre invalide pour '%s' pour la fonction '%s'.",
	'APIException:FunctionParseError' => "%s(%s) a une erreur d'analyse.",
	'APIException:FunctionNoReturn' => "%s(%s) ne retourne aucune valeur.",
	'APIException:APIAuthenticationFailed' => "Echec d'authentification d'API par l'appel de méthode",
	'APIException:UserAuthenticationFailed' => "Echec d'authentification d'utilisateur par l'appel de méthode",
	'SecurityException:AuthTokenExpired' => "Le jeton d'authentification est manquant, invalide ou expiré.",
	'CallException:InvalidCallMethod' => "%s doit être appelé en utilisant '%s'",
	'APIException:MethodCallNotImplemented' => "L'appel à la méthode '%s' n'a pas été implémenté.",
	'APIException:FunctionDoesNotExist' => "La fonction pour la methode '%s' n'est pas appellable",
	'APIException:AlgorithmNotSupported' => "L'algorithme '%s' n'est pas supporté ou a été désactivé.",
	'ConfigurationException:CacheDirNotSet' => "Le répertoire de cache 'cache_path' n'a pas été renseigné.",
	'APIException:NotGetOrPost' => "La méthode de requête doit être GET ou POST",
	'APIException:MissingAPIKey' => "Clé API manquante",
	'APIException:BadAPIKey' => "Mauvaise clé API",
	'APIException:MissingHmac' => "X-Elgg-hmac manquant dans l'entête",
	'APIException:MissingHmacAlgo' => "X-Elgg-hmac-algo manquant dans l'entête",
	'APIException:MissingTime' => "X-Elgg-time manquant dans l'entête",
	'APIException:MissingNonce' => "X-Elgg-nonce manquant dans l'entête",
	'APIException:TemporalDrift' => "X-Elgg-time est trop éloigné dans le temps. Epoch a échoué.",
	'APIException:NoQueryString' => "Aucune valeur dans la requête",
	'APIException:MissingPOSTHash' => "X-Elgg-posthash manquant dans l'entête",
	'APIException:MissingPOSTAlgo' => "X-Elgg-posthash_algo manquant dans l'entête",
	'APIException:MissingContentType' => "Le content-type est manquant pour les données postées",
	'SecurityException:InvalidPostHash' => "La signature des données POST est invalide.%s attendu mais %s reçu.",
	'SecurityException:DupePacket' => "La signature du paquet a déjà été envoyée.",
	'SecurityException:InvalidAPIKey' => "Clé API invalide ou non-reconnue.",
	'NotImplementedException:CallMethodNotImplemented' => "La méthode '%s' n'est pas supportée actuellement.",

	'NotImplementedException:XMLRPCMethodNotImplemented' => "L'appel à la méthode XML-RPC '%s' n'a pas été implémentée.",
	'InvalidParameterException:UnexpectedReturnFormat' => "L'appel à la méthode '%s' a retourné un résultat inattendu.",
	'CallException:NotRPCCall' => "L'appel ne semble pas être un appel XML-RPC valide",

	'PluginException:NoPluginName' => "Le nom du plugin n'a pas pu être trouvé",

	'SecurityException:authenticationfailed' => "Impossible d'authentifier l'utilisateur",

	'CronException:unknownperiod' => "%s n'est pas une période valide.",

	'SecurityException:deletedisablecurrentsite' => "Impossible de supprimer ou désactiver le site en cours !",

	'RegistrationException:EmptyPassword' => "Les champs du mot de passe ne peut pas être vide",
	'RegistrationException:PasswordMismatch' => "Les mots de passe doivent correspondre",
	'LoginException:BannedUser' => "Vous avez été banni de ce site et ne pouvez plus vous connecter",
	'LoginException:UsernameFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:PasswordFailure' => "Nous n'avons pas pu vous connecter ! Vérifiez votre nom d'utilisateur et mot de passe.",
	'LoginException:AccountLocked' => "Votre compte a été verrouillé suite à un trop grand nombre d'échecs de connexion.",

	'memcache:notinstalled' => "Le module PHP memcache n'est pas installé. Vous devez installer php5-memcache",
	'memcache:noservers' => "Pas de serveur memcache défini, veuillez renseigner la variable",
	'memcache:versiontoolow' => "Memcache nécessite au minimum la version %s pour fonctionner, vous avez la version %s",
	'memcache:noaddserver' => "Le support de serveurs multiples est désactivé, vous avez peut-être besoin de mettre à jour votre bibliothèque memcache PECL",

	'deprecatedfunction' => "Attention : Ce code source utilise une fonction périmée '%s'. Il n'est pas compatible avec cette version de Elgg.",

	'pageownerunavailable' => "Attention : La page de l'utilisateur %d n'est pas accessible.",
	'viewfailure' => "Il ya eu une erreur interne dans la vue %s",
	'changebookmark' => "Veuillez changer votre favori pour cette page.",
/**
 * API
 */
	'system.api.list' => "Liste tous les appels API au système.",
	'auth.gettoken' => "Cet appel API permet à un utilisateur de se connecter, il retourne une clef d'authentification qui permet de rendre la tentative de connexion unique.",

/**
 * User details
 */

	'name' => "Prénom + Nom",
	'email' => "Adresse e-mail",
	'username' => "Identifiant de connexion",
//	'loginusername' => "Identifiant de connexion ou e-mail",
	'loginusername' => "Identifiant ou Email",
	'password' => "Mot de passe",
	'passwordagain' => "Confirmation du mot de passe",
	'admin_option' => "Définir cet utilisateur comme administrateur ?",

/**
 * Access
 */

	'PRIVATE' => "Privé / brouillon",
	'LOGGED_IN' => "Membres du site",
	'PUBLIC' => "Public",
	'access:friends:label' => "Contacts seulement",
	'access' => "Accès",

/**
 * Dashboard and modules
 */

	'dashboard' => "Tableau de bord",
	'dashboard:nowidgets' => "Votre tableau de bord personnalisable vous permet de suivre l'activité et les contenus qui vous intéressent.",

	'widgets:add' => "Personnaliser cette page",
	'widgets:add:description' => "Cliquez sur l'un des modules ci-dessous pour l'ajouter à votre page d'accueil. Attention : les modules grisés ne sont plus disponibles.<br />Les modules ajoutés apparaissent ci-dessous à droite. Agencez-les dans la page en cliquant dessus et en les déplaçant à l'emplacement souhaité, dans l'une des 3 colonnes.'",
	'widgets:position:fixed' => "(Position modifiée sur la page)",
	'widget:unavailable' => "Vous avez déjà ajouté ce module",
	'widget:numbertodisplay' => "Nombre d'éléments à afficher ",

	'widget:delete' => "Supprimer le module %s",
	'widget:edit' => "Paramétrer ce module",

	'widgets' => "Modules",
	'widget' => "Module",
	'item:object:widget' => "Modules",
	'widgets:save:success' => "Le module a été enregistré avec succès.",
	'widgets:save:failure' => "Un problème est survenu lors de l'enregistrement de votre module. Veuillez recommencer.",
	'widgets:add:success' => "Le module a bien été ajouté.",
	'widgets:add:failure' => "Nous n'avons pas pu ajouter votre module.",
	'widgets:move:failure' => "Nous n'avons pas pu enregistrer la position du nouveau module.",
	'widgets:remove:failure' => "Impossible de supprimer ce module",

/**
 * Groups
 */

	'group' => "Groupe",
	'item:group' => "Groupes",

/**
 * Users
 */

	'user' => "Utilisateur",
	'item:user' => "Utilisateurs",

/**
 * Friends
 */

	'friends' => "Mes Contacts",
	'friends:yours' => "Mes contacts",
	'friends:owned' => "Les contacts de %s",
	'friend:add' => "Ajouter comme contact",
	'friend:remove' => "Supprimer un contact",

	'friends:add:successful' => "Vous avez ajouté %s à vos contacts.",
	'friends:add:failure' => "%s n'a pas pu être ajouté(e) à vos contacts. Merci de réessayer ultérieurement.",

	'friends:remove:successful' => "Vous avez retiré %s de vos contacts.",
	'friends:remove:failure' => "%s n'a pas pu être retiré(e) de vos contacts. Merci de réessayer ultérieurement.",

	'friends:none' => "Cet utilisateur n'a pas encore choisi de contact.",
	'friends:none:you' => "Vous n'avez pas encore de contact !",

	'friends:none:found' => "Aucun contact n'a été trouvé.",

	'friends:of:none' => "Personne n'a encore choisi cet utilisateur comme contact.",
	'friends:of:none:you' => "Personne ne vous a encore choisi comme contact. Vous pouvez commencer par remplir votre page de profil et rejoindre le groupe de votre département pour que les gens vous retrouvent.",

	'friends:of:owned' => "Les personnes qui ont %s dans leurs contacts",

	'friends:of' => "Contacts de",
	'friends:collections' => "Liste de contacts",
	'collections:add' => "Créer une liste",
	'friends:collections:add' => "Nouvelle liste de contacts",
	'friends:addfriends' => "Sélectionner des contacts",
	'friends:collectionname' => "Nom de la liste",
	'friends:collectionfriends' => "Contacts dans la liste",
	'friends:collectionedit' => "Modifier cette liste",
	'friends:nocollections' => "Vous n'avez pas encore créé de liste de contacts.",
	'friends:collectiondeleted' => "Votre liste de contacts a été supprimée.",
	'friends:collectiondeletefailed' => "La liste de contacts n'a pas été supprimée. Vous n'avez pas de droits suffisants, ou un autre problème peut être en cause.",
	'friends:collectionadded' => "Votre liste de contacts a été créé avec succès",
	'friends:nocollectionname' => "Vous devez nommer votre liste de contacts avant qu'elle puisse être créée.",
	'friends:collections:members' => "Membres de la liste",
	'friends:collections:edit' => "Modifier la liste de contacts",

	'friends:river:add' => "est maintenant dans les contacts de %s",

	'friendspicker:chararray' => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",

	'avatar' => "Photo",
	'avatar:create' => "Recadrer ma photo",
	'avatar:edit' => "Modifier ma photo",
	'avatar:preview' => "Prévisualisation",
	'avatar:upload' => "Sélectionner une nouvelle photo",
	'avatar:current' => "Photo actuelle",
	'avatar:crop:title' => "Outil pour recadrer votre photo",
	'avatar:upload:instructions' => "Votre photo est affichée sur tout le site. Vous pouvez la changer quand vous le souhaitez. (Formats de fichiers acceptés: GIF, JPG ou PNG, l'image sera retaillée en plusieurs vignettes dont la plus grande sera de dimension maximum : 200x200)",
	'avatar:create:instructions' => "Agrandissez et déplacez le carré qui apparaît afin de recadrer votre photo. Un aperçu est disponible à droite de l'image. Lorsque vous êtes content de votre choix, cliquer sur 'Recadrer ma photo'. Cette version recadrée sera utilisée sur le site.",
	'avatar:upload:success' => "Photo téléchargée avec succès",
	'avatar:upload:fail' => "Échec de l'envoi de l'image",
	'avatar:resize:fail' => "Le redimensionnement de la photo a échoué",
	'avatar:crop:success' => "Le recadrage de la photo a réussi",
	'avatar:crop:fail' => "Le recadrage de la photo a échoué",

	'profile:edit' => "Modifier mon profil",
	'profile:aboutme' => "A propos de moi",
	'profile:description' => "A propos de moi",
	'profile:briefdescription' => "Brève description",
	'profile:location' => "Lieu",
	'profile:skills' => "Compétences",
	'profile:interests' => "Mots-clefs",
	'profile:contactemail' => "Contact email",
	'profile:phone' => "Téléphone",
	'profile:mobile' => "Téléphone portable",
	'profile:website' => "Site Web",
	'profile:twitter' => "Nom d'utilisateur Twitter",
	'profile:saved' => "Votre profil a été correctement enregistré.",

	'admin:appearance:profile_fields' => "Modifier les champs du profil",
	'profile:edit:default' => "Modifier les champs du profil",
	'profile:label' => "Etiquette du profil",
	'profile:type' => "Type de profil",
	'profile:editdefault:delete:fail' => "Echec de l'enlevement du champ profil par défaut",
	'profile:editdefault:delete:success' => "Le champ profil par défaut est supprimé!",
	'profile:defaultprofile:reset' => "Réinitialisation du profil système par défaut",
	'profile:resetdefault' => "Réinitialisation du profil par défaut",
	'profile:explainchangefields' =>"Vous pouvez remplacer les champs de profil existant avec les vôtres en utilisant le formulaire ci-dessous.\n\nDonner une étiquette pour le nouveau champ du profil, par exemple, 'équipe préférée', puis sélectionnez le type de champ (par exemple, texte, url, balises), et cliquez sur le bouton 'Ajouter'. Pour réordonner les champs faites glisser la poignée de l'étiquette du champ. Pour modifier un champ d'étiquette - cliquez sur le texte de l'étiquette pour le rendre modifiable. A tout moment vous pouvez revenir au profil par défaut, mais vous perdrez toutes les informations déjà entrées dans des champs personnalisés des pages de profil.",
	'profile:editdefault:success' => "Champ ajouté au profil par défaut avec succès",
	'profile:editdefault:fail' => "Le profil par défaut n'a pas pu être sauvé",


/**
 * Feeds
 */
	'feed:rss' => "S'abonner au fil RSS de cette page",
/**
 * Links
 */
	'link:view' => "voir le lien",
	'link:view:all' => "Voir tout",


/**
 * River
 */
	'river' => "River",
	'river:friend:user:default' => "%s est maintenant en contact avec %s",
	'river:update:user:avatar' => "%s a changé d'image de profil",
	'river:update:user:profile' => '%s a mis à jour son profil',
	'river:relationship:friend' => "est maintenant dans les contacts de",
	'river:noaccess' => "Vous n'avez pas la permission de voir cet élément.",
	'river:posted:generic' => "%s a publié",
	'riveritem:single:user' => "un utilisateur",
	'riveritem:plural:user' => "des utilisateurs",
	'river:ingroup' => "dans le groupe %s",
	'river:none' => "Aucune activité",
	'river:update' => 'Mise à jour pour %s',
	'river:create:object:default' => "%s a publié %s",
	'river:comment:object:default' => "%s a commenté %s",
	'river:commented:object:default' => "la publication",

	'river:widget:title' => "Actualités du site",
	'river:widget:description' => "Afficher l'activité la plus récente",
	'river:widget:type' => "Type d'activité",
	'river:widgets:friends' => "Activité des contacts",
	'river:widgets:all' => "Toutes les activités sur le site",

/**
 * Notifications
 */
	'notifications:usersettings' => "Configuration des messages du site",
	'notifications:methods' => "Choisissez votre mode de réception des messages du site.",

	'notifications:usersettings:save:ok' => "La configuration des messages du site a été enregistrée avec succès.",
	'notifications:usersettings:save:fail' => "Il y a eu un problème lors de la sauvegarde des paramètres de configuration des messages du site.",

	'user.notification.get' => "Renvoie les paramètres de messages du site pour un utilisateur donné.",
	'user.notification.set' => "Définir les paramètres de messages du site pour un utilisateur donné.",
/**
 * Search
 */

	'search' => "Chercher",
	'search:label' => "Termes à chercher",
	'searchtitle' => "Chercher : %s",
	'users:searchtitle' => "Recherche des utilisateurs : %s",
	'groups:searchtitle' => "Rechercher des groupes : %s",
	'advancedsearchtitle' => "%s résultat(s) trouvé(s) pour %s",
	'notfound' => "Aucun résultat trouvé.",
	'next' => "&#x25B6;",
	'previous' => "&#x25C0;",

	'viewtype:change' => "Changer le type de liste",
	'viewtype:list' => "Lister les vues",
	'viewtype:gallery' => "Galerie",

	'tag:search:startblurb' => "Eléments avec le(s) mot(s)-clé '%s' :",

	'user:search:startblurb' => "Utilisateurs avec le(s) mot(s)-clé '%s' :",
	'user:search:finishblurb' => "Cliquez ici pour plus de résultats...",

	'group:search:startblurb' => "Groupes qui vérifient le critère : %s",
	'group:search:finishblurb' => "Pour en savoir plus, cliquez ici.",
	'search:go' => "Rechercher",
	'userpicker:only_friends' => "Seulement les contacts",

/**
 * Account
 */

	'account' => "Compte",
	'settings' => "Paramètres",
	'tools' => "Outils",

	'register' => "Créer un compte",
	'registerok' => "Vous vous êtes enregistré avec succès sur %s.",
	'registerbad' => "La création de votre compte n'a pas fonctionné pour une raison inconnue.",
	'registerdisabled' => "Votre compte a été désactivé par l'administrateur du site.",

	'registration:notemail' => "L'adresse email que vous avez renseignée n'apparaît pas comme valide.",
	'registration:userexists' => "Ce nom d'utilisateur existe déjà, merci d'en choisir un autre",
	'registration:usernametooshort' => "L'identifiant de connexion doit faire %u caractères au minimum.",
	'registration:passwordtooshort' => "Le mot de passe doit faire %u caractères au minimum.",
	'registration:dupeemail' => "Cette adresse email est déjà utilisée.",
	'registration:invalidchars' => "Désolé, votre identifiant contient les caractères invalides suivants: %s. Tous ces caractères sont invalides: %s",
	'registration:emailnotvalid' => "Désolé, l'adresse email que vous avez saisie est invalide sur ce site.",
	'registration:passwordnotvalid' => "Désolé, le mot de passe que vous avez saisi est invalide sur ce site.",
	'registration:usernamenotvalid' => "Désolé, l'identifiant de connexion que vous avez saisi est invalide sur ce site.",

	'adduser' => "Créer un nouveau compte utilisateur",
	'adduser:ok' => "Vous avez ajouté un nouvel utilisateur avec succès.",
	'adduser:bad' => "Le nouveau compte utilisateur ne peut pas être créé.",

	'user:set:name' => "Identifiant de connexion",
	'user:name:label' => "Prénom et Nom",
	'user:name:success' => "Votre identité a été modifiée avec succès.",
	'user:name:fail' => "Impossible de modifier votre identité. Assurez-vous que votre nom n'est pas trop long et essayez à nouveau.",

	'user:set:password' => "Mot de passe",
	'user:current_password:label' => "Mot de passe actuel",
	'user:password:label' => "Votre nouveau mot de passe",
	'user:password2:label' => "Veuillez re saisir votre nouveau mot de passe",
	'user:password:success' => "Mot de passe modifié avec succès",
	'user:password:fail' => "Impossible de modifier votre mot de passe.",
	'user:password:fail:notsame' => "Les deux mots de passe ne correspondent pas !",
	'user:password:fail:tooshort' => "Le mot de passe est trop court !",
	'user:password:fail:incorrect_current_password' => "Le mot de passe actuel entré est incorrect.",
	'user:resetpassword:unknown_user' => "Utilisateur inconnu.",
	'user:resetpassword:reset_password_confirm' => "Après réinitialisation de votre mot de passe, celui-ci vous sera envoyé à votre adresse email.",

	'user:set:language' => "Langue",
	'user:language:label' => "Votre langue",
	'user:language:success' => "Votre paramètre de langage a été mis à jour.",
	'user:language:fail' => "Votre paramètre de langage n'a pas pu être sauvegardé.",

	'user:username:notfound' => "Nom d'utilisateur %s non trouvé.",

	'user:password:lost' => "Mot de passe perdu ?",
	'user:password:resetreq:success' => "Vous avez demandé un nouveau mot de passe, un email vous a été envoyé",
	'user:password:resetreq:fail' => "Impossible de demander un nouveau mot de passe.",

	'user:password:text' => "Pour générer un nouveau mot de passe, entrez votre adresse de courrier électronique ci-dessous (celle utilisée lors de l'inscription). Vous recevrez un message avec un lien sur lequel vous devez cliquer pour confirmer votre demande, et recevrez dans les minutes qui suivent un second message avec votre nouveau mot de passe.",

//	'user:persistent' => "Se souvenir de moi",
//	'user:persistent' => "Rester connecté (jusqu'à la fermeture de mon navigateur)",
	'user:persistent' => "Rester connecté",

	'walled_garden:welcome' => "Bienvenue à ",

/**
 * Administration
 */
	'menu:page:header:administer' => "Administrer",
	'menu:page:header:configure' => "Configurer",
	'menu:page:header:develop' => "Développer",

	'admin:view_site' => "Accéder au site",
	'admin:loggedin' => "Connecté en tant que %s",
	'admin:menu' => "Menu",

	'admin:configuration:success' => "Vos paramètres ont été sauvegardés.",
	'admin:configuration:fail' => "Vos paramètres n'ont pas pu être sauvegardés.",

	'admin:unknown_section' => "Partie Admin invalide.",

	'admin' => "Administration",
	'admin:description' => "Le panneau d'administration vous permet de contrôler tous les aspects du système d'Elgg, de la gestion des utilisateurs à la gestion des outils installés. Choisissez une option dans le menu ci-contre pour commencer.",

	'admin:statistics' => "Statistiques",
	'admin:statistics:overview' => "Vue d'ensemble",

	'admin:appearance' => "Apparence",
	'admin:utilities' => "Utilitaires",

	'admin:users' => "Utilisateurs",
	'admin:users:online' => "Actuellement en ligne",
	'admin:users:newest' => "Le plus récent",
	'admin:users:add' => "Créer un nouveau compte utilisateur",
	'admin:users:description' => "Ce panneau d'administration vous permet de contrôler les paramètres des utilisateurs de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:users:adduser:label' => "Cliquez ici pour ajouter un nouvel utilisateur ...",
	'admin:users:opt:linktext' => "Configurer des utilisateurs ...",
	'admin:users:opt:description' => "Configurer les utilisateurs et les informations des comptes.",
	'admin:users:find' => "Trouver",

	'admin:settings' => "Paramètres",
	'admin:settings:basic' => "Réglages de base",
	'admin:settings:advanced' => "Paramètres avancés",
	'admin:site:description' => "Ce menu vous permet de définir les paramètres principaux de votre site. Choisissez une option ci-dessous pour commencer.",
	'admin:site:opt:linktext' => "Configurer le site...",
	'admin:site:access:warning' => "Changer les paramètres d'accès n'affectera que les permissions de contenu créées dans le futur.",

	'admin:dashboard' => "Tableau de bord",
	'admin:widget:online_users' => "Utilisateurs en ligne",
	'admin:widget:online_users:help' => "Affiche la liste des utilisateurs actuellement inscrits sur le site",
	'admin:widget:new_users' => "Nouveaux utilisateurs",
	'admin:widget:new_users:help' => "Affiche la liste des nouveaux utilisateurs",
	'admin:widget:content_stats' => "Statistiques",
	'admin:widget:content_stats:help' => "Gardez une trace du contenu créé par vos utilisateurs",
	'widget:content_stats:type' => "Type de contenu",
	'widget:content_stats:number' => "Nombre",

	'admin:widget:admin_welcome' => "Bienvenue",
	'admin:widget:admin_welcome:help' => "Une courte introduction à la zone d'administration de Elgg",
	'admin:widget:admin_welcome:intro' =>
"Bienvenue sur Elgg ! Vous êtes actuellement sur le tableau de bord de l'administration. Il vous permet de suivre de ce qui se passe sur le site.",

	'admin:widget:admin_welcome:admin_overview' =>
"La navigation dans l'administration se fait à l'aide du menu de droite. Il est organisé en"
. " 3 sections :
	<dl>
		<dt>Administrer</dt><dd>Les tâches quotidiennes comme le suivi du contenu signalé, l'aperçu des utilisateurs en ligne, l'affichage des statistiques...</dd>
		<dt>Configurer</dt><dd>Les tâches occasionnelles comme le paramétrage du nom du site ou l'activation d'un plugin.</dd>
		<dt>Développer</dt><dd>Pour les développeurs qui créent des plugins ou conçoivent des thèmes (Connaissances en programmation nécessaires).</dd>
	</dl>
	",

	// argh, this is ugly
	'admin:widget:admin_welcome:outro' => "<br /> (Des liens d'aide technique sur le logiciel Elgg support de ce réseau, sont éventuellement à la disposition des développeurs en bas de page. Ces ressources sont hébergées sur un site tiers en Anglais)",
	'admin:footer:faq' => "FAQ Administration",
	'admin:footer:manual' => "Guide sur l'administration",
	'admin:footer:community_forums' => "Forums de la communauté Elgg",
	'admin:footer:blog' => "Blog d'Elgg",

	'admin:plugins:category:all' => "Tous les plugins",
	'admin:plugins:category:admin' => "Admin",
	'admin:plugins:category:bundled' => "Empaqueté",
	'admin:plugins:category:content' => "Contenu",
	'admin:plugins:category:development' => "Développement",
	'admin:plugins:category:extension' => "Extensions",
	'admin:plugins:category:service' => "Service / API",

	'admin:plugins:markdown:unknown_plugin' => "Plugin inconnu.",
	'admin:plugins:markdown:unknown_file' => "fichier inconnu.",


	'admin:notices:could_not_delete' => "Impossible de supprimer la remarque.",

	'admin:options' => "Options Admin",


/**
 * Plugins
 */
	'plugins:settings:save:ok' => "Le paramétrage du plugin %s a été enregistré.",
	'plugins:settings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres du plugin %s.",
	'plugins:usersettings:save:ok' => "Le paramétrage du plugin a été enregistré avec succès.",
	'plugins:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement du paramétrage du plugin %s.",
	'item:object:plugin' => "Plugins",

	'admin:plugins' => "Administrer les plugins",
	'admin:plugins:activate_all' => "Tout activer",
	'admin:plugins:deactivate_all' => "Tout désactiver",
	'admin:plugins:description' => "Ce menu vous permet de contrôler et de configurer les outils installés sur votre site.",
	'admin:plugins:opt:linktext' => "Configurer les outils...",
	'admin:plugins:opt:description' => "Configurer les outils installés sur le site.",
	'admin:plugins:label:author' => "Auteur",
	'admin:plugins:label:copyright' => "Copyright",
	'admin:plugins:label:categories' => "Catégories",
	'admin:plugins:label:licence' => "Licence",
	'admin:plugins:label:website' => "URL",
	'admin:plugins:label:moreinfo' => "Plus d'informations",
	'admin:plugins:label:version' => "Version",
	'admin:plugins:label:location' => "Adresse",
	'admin:plugins:label:dependencies' => "Dépendances",

	'admin:plugins:warning:elgg_version_unknown' => "Ce plugin utilise un ancien fichier manifest.xml et ne précise pas si cette version est compatible avec l'Elgg actuel. Il ne fonctionnera probablement pas !",
	'admin:plugins:warning:unmet_dependencies' => "Ce plugin ne retrouve pas certaines dépendances et ne peut être activé. Vérifiez les dépendances pour plus d'infos.",
	'admin:plugins:warning:invalid' => "%s n'est pas un plugin d'Elgg valide. Vérifiez les conseils de dépannage dans <a href=\"http://docs.elgg.org/Invalid_Plugin\">documentation d'Elgg</a>.",
	'admin:plugins:cannot_activate' => "Activation impossible",

	'admin:plugins:set_priority:yes' => "%s Réordonné",
	'admin:plugins:set_priority:no' => "Impossible de réordonné %s.",
	'admin:plugins:deactivate:yes' => "Désactivé %s.",
	'admin:plugins:deactivate:no' => "Impossible de désactiver %s.",
	'admin:plugins:activate:yes' => "%s Activé.",
	'admin:plugins:activate:no' => "Impossible d'activer %s.",
	'admin:plugins:categories:all' => "Toutes les catégories",
	'admin:plugins:plugin_website' => "Site du plugin",
	'admin:plugins:author' => "%s",
	'admin:plugins:version' => "Version %s",
	'admin:plugins:simple' => "Simple",
	'admin:plugins:advanced' => "Avancé",
	'admin:plugin_settings' => "Paramètres du plugin",
	'admin:plugins:simple_simple_fail' => "Impossible d'enregistrer les paramètres.",
	'admin:plugins:simple_simple_success' => "Paramètres sauvegardés.",
	'admin:plugins:simple:cannot_activate' => "Impossible d'activer ce plugin. Vérifiez les options avancées de plugin dans la zone d'administration pour plus d'informations.",

	'admin:plugins:dependencies:type' => "Type",
	'admin:plugins:dependencies:name' => "Nom",
	'admin:plugins:dependencies:expected_value' => "Valeur testée",
	'admin:plugins:dependencies:local_value' => "Valeur réelle",
	'admin:plugins:dependencies:comment' => "Commentaire",

	'admin:statistics:description' => "Cette page est un résumé des statistiques de votre site. Si vous avez besoin de statistiques plus détaillées, une version professionnelle d'administration est disponible.",
	'admin:statistics:opt:description' => "Voir des informations statistiques sur les utilisateurs et les objets de votre site.",
	'admin:statistics:opt:linktext' => "Voir statistiques...",
	'admin:statistics:label:basic' => "Statistiques basiques du site",
	'admin:statistics:label:numentities' => "Entités sur le site",
	'admin:statistics:label:numusers' => "Nombre d'utilisateurs",
	'admin:statistics:label:numonline' => "Nombre d'utilisateurs en ligne",
	'admin:statistics:label:onlineusers' => "Utilisateurs en ligne actuellement",
	'admin:statistics:label:version' => "Version d'Elgg",
	'admin:statistics:label:version:release' => "Release",
	'admin:statistics:label:version:version' => "Version",

	'admin:user:label:search' => "Trouver des utilisateurs :",
	'admin:user:label:searchbutton' => "Chercher",

	'admin:user:ban:no' => "Cet utilisateur ne peut pas être banni",
	'admin:user:ban:yes' => "Utilisateur banni.",
	'admin:user:self:ban:no' => "Vous ne pouvez pas vous bannir vous même",
	'admin:user:unban:no' => "Cet utilisateur ne peut pas être réintégré",
	'admin:user:unban:yes' => "Utilisateur réintégré.",
	'admin:user:delete:no' => "Cet utilisateur ne peut pas être supprimé",
	'admin:user:delete:yes' => "Utilisateur supprimé",
	'admin:user:self:delete:no' => "Vous ne pouvez pas vous supprimer",

	'admin:user:resetpassword:yes' => "Mot de passe réinitialisé, utilisateur notifié.",
	'admin:user:resetpassword:no' => "Le mot de passe n'a pas pu être réinitialisé.",

	'admin:user:makeadmin:yes' => "L'utilisateur est maintenant un administrateur.",
	'admin:user:makeadmin:no' => "Nous ne pouvons pas faire de cet utilisateur un administrateur.",

	'admin:user:removeadmin:yes' => "L'utilisateur n'est plus administrateur.",
	'admin:user:removeadmin:no' => "Nous ne pouvons pas supprimer les privilèges d'administrateur à cet utilisateur.",
	'admin:user:self:removeadmin:no' => "Vous ne pouvez pas supprimer vos propres privilèges d'administrateur.",

	'admin:appearance:menu_items' => "Les éléments de menu",
	'admin:menu_items:configure' => "Configurer les éléments du menu principal",
	'admin:menu_items:description' => "Sélectionnez les éléments de menu que vous voulez afficher en liens directs. Les éléments de menu inutilisés seront ajoutées dans la liste «Plus».",
	'admin:menu_items:hide_toolbar_entries' => "Supprimer les liens dans le menu barre d'outils ?",
	'admin:menu_items:saved' => "Les éléments de menu sauvés.",
	'admin:add_menu_item' => "Ajouter un élément de menu personnalisé",
	'admin:add_menu_item:description' => "Remplissez le nom et l'URL d'affichage pour ajouter des éléments personnalisés à votre menu de navigation.",

	'admin:appearance:default_widgets' => "Modules par défaut",
	'admin:default_widgets:unknown_type' => "Type de module inconnu",
	'admin:default_widgets:instructions' => "Ajoutez, supprimez, positionnez et configurez les modules par défaut pour la page des profils. Ces changements s'appliqueront uniquement aux nouveaux utilisateurs sur le site.",


/**
 * User settings
 */
	'usersettings:description' => "Le panneau de configuration vous permet de contrôler tous vos paramètres et vos plugins. Choisissez une option ci-dessous pour continuer.",

	'usersettings:statistics' => "Vos statistiques",
	'usersettings:statistics:opt:description' => "Visualiser les statistiques des utilisateurs et des objets sur votre espace.",
	'usersettings:statistics:opt:linktext' => "Statistiques de mon compte",

	'usersettings:user' => "Modifier mes paramètres",
	'usersettings:user:opt:description' => "Ceci vous permet de contrôler vos paramètres.",
	'usersettings:user:opt:linktext' => "Modifier mes paramètres",

	'usersettings:plugins' => "Outils",
	'usersettings:plugins:opt:description' => "Configurer vos paramètres (s'il y en a) pour activer vos outils.",
	'usersettings:plugins:opt:linktext' => "Configurer mes outils",

	'usersettings:plugins:description' => "Ce panneau de configuration vous permet de mettre à jour les options des outils installés par l'administrateur.",
	'usersettings:statistics:label:numentities' => "Vos entités",

	'usersettings:statistics:yourdetails' => "Vos informations",
	'usersettings:statistics:label:name' => "Votre nom",
	'usersettings:statistics:label:email' => "Email",
	'usersettings:statistics:label:membersince' => "Membre depuis",
	'usersettings:statistics:label:lastlogin' => "Dernière connexion",

/**
 * Activity river
 */
	'river:all' => "Toute l'activité du site",
	'river:mine' => "Mon activité",
	'river:friends' => "Activités des contacts",
	'river:select' => "Filtrer l'activité : %s",
	'river:comments:more' => "+%u plus",
	'river:generic_comment' => "commenté sur %s",

	'friends:widget:description' => "Affiche certains de vos contacts.",
	'friends:num_display' => "Nombre de contacts à afficher",
	'friends:icon_size' => "Taille des icônes",
	'friends:tiny' => "minuscule",
	'friends:small' => "petit",

/**
 * Generic action words
 */

	'save' => "Enregistrer",
	'reset' => "Réinitialiser",
	'publish' => "Publier",
	'cancel' => "Annuler",
	'saving' => "Enregistrement en cours",
	'update' => "Mettre à jour",
	'edit' => "Modifier",
	'delete' => "Supprimer",
	'accept' => "Accepter",
	'load' => "Charger",
	'upload' => "Charger",
	'ban' => "Bannir",
	'unban' => "Réintégrer",
	'banned' => "Banni",
	'enable' => "Activer",
	'disable' => "Désactiver",
	'request' => "Requête",
	'complete' => "Complété",
	'open' => "Ouvrir",
	'close' => "Fermer",
	'reply' => "Commenter",
	'more' => "Plus",
	'comments' => "Commentaires",
	'import' => "Importer",
	'export' => "Exporter",
	'untitled' => "Sans titre",
	'help' => "Aide",
	'send' => "Envoyer",
	'post' => "Poster",
	'submit' => "Soumettre",
	'comment' => "Commentaire",
	'upgrade' => "Mise à jour",

	'site' => "Site",
	'activity' => "Activité récente",
	'members' => "Membres",

	'up' => "Monter",
	'down' => "Descendre",
	'top' => "Tout en haut",
	'bottom' => "Tout en bas",

	'invite' => "Inviter",

	'resetpassword' => "Réinitialiser le mot de passe",
	'makeadmin' => "Rendre l'utilisateur administrateur",
	'removeadmin' => "Supprimer les droits administrateur de l'utilisateur",

	'option:yes' => "Oui",
	'option:no' => "Non",

	'unknown' => "Inconnu",

	'active' => "Activé",
	'total' => "Total",

	'learnmore' => "Cliquer ici pour en apprendre plus.",

	'content' => "contenu",
	'content:latest' => "Dernière activité",
	'content:latest:blurb' => "Vous pouvez également cliquer ici pour voir les dernières modifications effectuées sur le site.",

	'link:text' => "voir le lien",
/**
 * Generic questions
 */

	'question:areyousure' => "Etes-vous sûr ?",

/**
 * Generic data words
 */

	'title' => "Titre",
	'description' => "Description",
	'tags' => "Mots-clefs",
	'spotlight' => "Projecteur sur",
	'all' => "Tout",
	'mine' => "Moi",

	'by' => "par",

	'annotations' => "Annotations",
	'relationships' => "Relations",
	'metadata' => "Metadonnées",
	'tagcloud' => "Nuage de mots-clefs",
	'tagcloud:allsitetags' => "Tous les mots-clefs du site",

/**
 * Entity actions
 */
	'edit:this' => "Modifier",
	'delete:this' => "Supprimer",
	'comment:this' => "Commenter",

/**
 * Input / output strings
 */

	'deleteconfirm' => "Etes-vous sur de vouloir supprimer cet élément ?",
	'fileexists' => "Un fichier a déjà été chargé. Pour le remplacer sélectionner le ci-dessous :",

/**
 * User add
 */

	'useradd:subject' => "Compte de l'utilisateur créé",
	'useradd:body' => "
%s,

Un compte utilisateur vous a été créé sur %s. Pour vous connecter, rendez-vous :

%s

Et authentifiez-vous avec les éléments suivant :

Identifiant de connexion : %s
Mot de passe : %s

Une fois que vous vous êtes connecté(e), nous vous conseillons fortement de changer votre mot de passe.
",

/**
 * System messages
 **/

	'systemmessages:dismiss' => "Cliquer pour fermer",


/**
 * Import / export
 */
	'importsuccess' => "L'import des données a été réalisé avec succès",
	'importfail' => "L'import OpenDD des données a échoué.",

/**
 * Time
 */

	'friendlytime:justnow' => "à l'instant",
	'friendlytime:minutes' => "il y a %s minutes",
	'friendlytime:minutes:singular' => "il y a une minute",
	'friendlytime:hours' => "il y a %s heures",
	'friendlytime:hours:singular' => "il y a une heure",
	'friendlytime:days' => "il y a %s jours",
	'friendlytime:days:singular' => "hier",
	'friendlytime:date_format' => "j F Y @ g:ia",

	'date:month:01' => "Janvier %s",
	'date:month:02' => "Février %s",
	'date:month:03' => "Mars %s",
	'date:month:04' => "Avril %s",
	'date:month:05' => "Mai %s",
	'date:month:06' => "Juin %s",
	'date:month:07' => "Juillet %s",
	'date:month:08' => "Août %s",
	'date:month:09' => "Septembre %s",
	'date:month:10' => "Octobre %s",
	'date:month:11' => "Novembre %s",
	'date:month:12' => "Décembre %s",


/**
 * System settings
 */

	'installation:sitename' => "Le nom de votre site (par exemple 'Mon site de réseau social') :",
	'installation:sitedescription' => "Brève description du site (facultatif) :",
	'installation:wwwroot' => "L'URL du site, suivi de ' / ' :",
	'installation:path' => "Chemin physique des fichiers sur le serveur, suivi par ' / ' :",
	'installation:dataroot' => "Chemin complet où seront hébergés les fichiers uploadés par les utilisateurs, suivi de ' / ' :",
	'installation:dataroot:warning' => "Vous devez créer ce répertoire manuellement. Il doit se situer dans un répertoire différent de votre installation de Elgg.",
	'installation:sitepermissions' => "Les permissions d'accés par défaut :",
	'installation:language' => "La langue par défaut de votre site :",
	'installation:debug' => "Le mode de débogage permet de mettre en évidence certaines erreurs de fonctionnement, cependant il ralenti l'accès au site, il est à utiliser uniquement en cas de problème :",
	'installation:debug:none' => "Désactive le mode debug (recommandé)",
	'installation:debug:error' => "Afficher seulement les erreurs critiques",
	'installation:debug:warning' => "Afficher les erreurs et les avertissements",
	'installation:debug:notice' => "Log toutes les erreurs, les avertissements et les avis",

	// Walled Garden support
	'installation:registration:description' => "L'enregistrement d'un utilisateur est activé par défaut. Désactivez cette option si vous ne voulez pas que de nouveaux utilisateurs soient en mesure de s'inscrire eux-mêmes.",
	'installation:registration:label' => "Permettre à de nouveaux utilisateurs de s'enregistrer eux-mêmes",
	'installation:walled_garden:description' => "Autoriser le site à fonctionner comme un réseau privé. Cela empêchera les utilisateurs non connectés d'afficher les pages du site autres que celles expressément spécifiées publiques.",
	'installation:walled_garden:label' => "Restreindre les pages aux utilisateurs enregistrés",

	'installation:httpslogin' => "Activer ceci afin que les utilisateurs puissent se connecter via le protocole https. Vous devez avoir https activé sur votre serveur afin que cela fonctionne.",
	'installation:httpslogin:label' => "Activer les connexions HTTPS",
	'installation:view' => "Entrer le nom de la vue qui sera utilisée automatiquement pour l'affichage du site (par exemple : 'mobile'), laissez par défaut en cas de doute :",

	'installation:siteemail' => "L'adresse e-mail du site (utilisée lors d'envoi d'e-mail par le système)",

	'installation:disableapi' => "Elgg fournit une API pour l'élaboration de services web qui permettent à des application distantes d'interagir avec votre site.",
	'installation:disableapi:label' => "Activer les services web d'Elgg",

	'installation:allow_user_default_access:description' => "Si coché, les utilisateurs pourront modifier leur niveau d'accés par défaut et pourront surpasser le niveau d'accés mis en place par défaut dans le système.",
	'installation:allow_user_default_access:label' => "Autoriser un niveau d'accés par défaut pour l'utilisateur",

	'installation:simplecache:description' => "Le cache simple augmente les performances en mettant en cache du contenu statique comme des CSS et des fichiers Javascripts. Normalement vous ne devriez pas avoir besoin de l'activer.",
	'installation:simplecache:label' => "Utiliser un cache simple (recommandé)",

	'installation:viewpathcache:description' => "Le cache utilisé pour stocker les chemins vers les vues des greffons réduit le temps de chargement de ces derniers.",
	'installation:viewpathcache:label' => "Utiliser le cache de stockage des chemins vers les vues des greffons (recommandé)",

	'upgrading' => "Mise à jour en cours",
	'upgrade:db' => "Votre base de données a été mise à jour.",
	'upgrade:core' => "Votre installation de Elgg a été mise à jour",
	'upgrade:unable_to_upgrade' => "Impossible de mettre à jour.",
	'upgrade:unable_to_upgrade_info' => "Cette installation ne peut pas être mise à jour car des vues personnalisées ont été détectées dans le dossier des vues du core d'Elgg. Ces vues ont été dépréciées et doivent être retirées pour qu'Elgg fonctionne correctement. Si vous n'avez fait aucune modification du core d'Elgg, vous pouvez simplement supprimer le dossier  des vues du core et le remplacer par celui de la dernière version d'Elgg téélchargeable à partir de <a href=\"http://elgg.org\">elgg.org</a>.<br /><br />

		Pour des instructions détaillées, veuillez vous reporter à la <a href=\"http://docs.elgg.org/wiki/Upgrading_Elgg\">documentation sur la mise à jour d'Elgg</a>.  Si vous avez besoin d'aide, veuillez écrire dans les <a href=\"http://community.elgg.org/pg/groups/discussion/\">Forums d'aide de la communauté Elgg</a>.",

	'update:twitter_api:deactivated' => "Twitter API (précédemment Twitter Service) a été désactivée lors de la mise à niveau. Veuillez l'activer manuellement si nécessaire.",
	'update:oauth_api:deactivated' => "OAuth API (précédemment OAuth Lib) a été désactivée lors de la mise à niveau. Veuillez l'activer manuellement si nécessaire.",

	'deprecated:function' => "%s() a été déclaré obsolète par %s()",

/**
 * Welcome
 */

	'welcome' => "Bienvenue",
	'welcome:user' => "Bienvenue %s",

/**
 * Emails
 */
	'email:settings' => "Paramètres email",
	'email:address:label' => "Votre adresse email",

	'email:save:success' => "Votre nouvelle adresse email a été enregistrée, vous allez recevoir un email de confirmation.",
	'email:save:fail' => "Votre nouvelle adresse email n'a pas pu être enregistrée.",

	'friend:newfriend:subject' => "%s vous a ajouté comme contact !",
	'friend:newfriend:body' => "%s vous a ajouté comme contact!

Pour voir son profil, cliquez sur le lien ci-dessous

	%s

Vous ne pouvez pas répondre à cet email.",



	'email:resetpassword:subject' => "Réinitialisation du mot de passe !",
	'email:resetpassword:body' => "Bonjour %s,

Votre nouveau mot de passe est : %s",


	'email:resetreq:subject' => "Demander un nouveau mot de passe.",
	'email:resetreq:body' => "Bonjour %s,

Quelqu'un (avec l'adresse IP %s) a demandé un nouveau mot de passe pour votre compte.

Si c'est bien vous qui avez demandé ce changement, veuillez cliquer sur le lien ci-dessous, sinon ignorez cet email.

%s
",

/**
 * user default access
 */

'default_access:settings' => "Votre niveau d'accès par défaut",
'default_access:label' => "Accès par défaut",
'user:default_access:success' => "Votre nouveau niveau d'accès par défaut a été enregistré.",
'user:default_access:failure' => "Votre nouveau niveau d'accès par défaut n'a pu être enregistré.",

/**
 * XML-RPC
 */
	'xmlrpc:noinputdata'	=>	"Données d'entrée manquantes",

/**
 * Comments
 */

	'comments:count' => "%s commentaire(s)",

	'riveraction:annotation:generic_comment' => "%s a écrit un commentaire sur %s",

	'generic_comments:add' => "Laisser un commentaire",
	'generic_comments:post' => "Poster un commentaire",
	'generic_comments:text' => "Commentaire",
	'generic_comments:latest' => "Derniers commentaires",
	'generic_comment:posted' => "Votre commentaire a bien été publié.",
	'generic_comment:deleted' => "Votre commentaire a bien été supprimé.",
	'generic_comment:blank' => "Désolé, vous devez remplir votre commentaire avant de pouvoir l'enregistrer.",
	'generic_comment:notfound' => "Désolé, l'élément recherché n'a pas été trouvé.",
	'generic_comment:notdeleted' => "Désolé, le commentaire n'a pas pu être supprimé.",
	'generic_comment:failure' => "Une erreur est survenue lors de l'ajout de votre commentaire. Veillez réessayer.",
	'generic_comment:none' => "Pas de commentaire",

	'generic_comment:email:subject' => "Vous avez un nouveau commentaire !",
	'generic_comment:email:body' => "Vous avez un nouveau commentaire sur l'élément '%s' de %s. Voici son contenu :


%s


Pour répondre ou voir le contenu de référence, suivez le lien :
%s

Pour voir le profil de %s, suivez ce lien :
%s

Ne répondez pas à cet email.",

/**
 * Entities
 */
	'byline' => "Par %s",
	'entity:default:strapline' => "Créé le %s par %s",
	'entity:default:missingsupport:popup' => "Cette entité ne peut pas être affichée correctement. C'est peut-être dû à un plugin qui a été supprimé.",

	'entity:delete:success' => "L'entité %s a été effacée",
	'entity:delete:fail' => "L'entité %s n'a pas pu être effacée",


/**
 * Action gatekeeper
 */
	'actiongatekeeper:missingfields' => "Il manque les champs __token ou __ts dans le formulaire.",
	'actiongatekeeper:tokeninvalid' => "Une erreur est survenue. Cela veut probablement dire que la page que vous utilisiez a expirée. Merci de réessayer",
	'actiongatekeeper:timeerror' => "La page a expiré, rafraichissez et recommencez à nouveau.",
	'actiongatekeeper:pluginprevents' => "Une extension a empêché ce formulaire d'être envoyé",


/**
 * Word blacklists
 */
	'word:blacklist' => "alors, au, aucuns, aussi, autre, avant, avec, avoir, bon, car, ce, cela, ces, ceux, chaque, ci, comme, comment, dans, des, du, dedans, dehors, depuis, deux, devrait, doit, donc, dos, droite, début, elle, elles, en, encore, essai, est, et, eu, fait, faites, fois, font, force, haut, hors, ici, il, ils, je, juste, la, le, les, leur, là, ma, maintenant, mais, mes, mine, moins, mon, mot, même, ni, nommés, notre, nous, nouveaux, ou, où, par, parce, parole, pas, personnes, peut, peu, pièce, plupart, pour, pourquoi, quand, que, quel, quelle, quelles, quels, qui, sa, sans, ses, seulement, si, sien, son, sont, sous, soyez, sujet, sur, ta, tandis, tellement, tels, tes, ton, tous, tout, trop, très, tu, valeur, voie, voient, vont, votre, vous, vu, ça, étaient, état, étions, été, être",

/**
 * Tag labels
 */

	'tag_names:tags' => "Mots-clefs",
	'tags:site_cloud' => "Nuage de mots-clefs du site",

/**
 * Javascript
 */

	'js:security:token_refresh_failed' => "Impossible de contacter %s. Vous aurez sans doute des difficultés à enregistrer le contenu.",
	'js:security:token_refreshed' => "La connexion à %s est restaurée !",

/**
 * Languages according to ISO 639-1
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
	//"in" => "Indonesian",
	"is" => "Islandais",
	"it" => "Italien",
	"iu" => "Inuktitut",
	"iw" => "Hebrew (obsolete)",
	"ja" => "Japonais",
	"ji" => "Yiddish (obsolete)",
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
	"mi" => "Māori",
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
	"qu" => "Quechua",
	"rm" => "Romanche",
	"rn" => "Kirundi",
	"ro" => "Roumain",
	"ru" => "Russe",
	"rw" => "Kinyarwanda",
	"sa" => "Sanskrit",
	"sd" => "Sindhi",
	"sg" => "Sango",
	"sh" => "Serbo-Croatian",
	"si" => "Cingalais",
	"sk" => "Slovaque",
	"sl" => "Slovène",
	"sm" => "Samoan",
	"sn" => "Shona",
	"so" => "Somali",
	"sq" => "Albanais",
	"sr" => "Serbe",
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
	"zu" => "Zoulou",
	
	
	// Additions between 1.8.8 (or 1.8.01 ?) and 1.8.14 - Facyla
  'access:help' => "Niveau d'accès",
  'access:limited:label' => "Limité",
  'actiongatekeeper:uploadexceeded' => "La taille du (ou des) fichier(s) envoyé(s) dépasse la limite fixée par l'administrateur du site.",
  'add' => "Ajouter",
  'admin:administer_utilities' => "Utilitaires",
  'admin:cache:flushed' => "Les caches du site ont été vidés",
  'admin:cache:flush' => "Vider les caches",
  'admin:configuration:dataroot:relative_path' => "Impossible de définir &quot;%s&quot; comme dossier de données (dataroot) car ce n'est pas un chemin absolu.",
  'admin:develop_utilities' => "Utilitaires",
  'admin:plugins:activate' => "Activer",
  'admin:plugins:activate:no_with_msg' => "Impossible d'activer %s. Erreur : %s",
  'admin:plugins:category:active' => "Plugins actifs",
  'admin:plugins:category:api' => "Service/API",
  'admin:plugins:category:communication' => "Communication",
  'admin:plugins:category:enhancement' => "Améliorations",
  'admin:plugins:category:inactive' => "Plugins désactivés",
  'admin:plugins:category:multimedia' => "Multimédia",
  'admin:plugins:category:nonbundled' => "Non-empaquetés (non-bundled)",
  'admin:plugins:category:security' => "Sécurité et spam",
  'admin:plugins:category:social' => "Social",
  'admin:plugins:category:theme' => "Thèmes",
  'admin:plugins:category:utility' => "Utilitaires",
  'admin:plugins:category:widget' => "Widgets",
  'admin:plugins:deactivate' => "Désactiver",
  'admin:plugins:deactivate:no_with_msg' => "Impossible de désactiver %s. Erreur : %s",
  'admin:plugins:label:bugtracker' => "Signaler un problème",
  'admin:plugins:label:donate' => "Soutenir (donation)",
  'admin:plugins:label:repository' => "Code",
  'admin:plugins:set_priority:no_with_msg' => "Impossible de réordonner %s. Erreur : %s",
  'admin:plugins:sort:alpha' => "Alphabétique",
  'admin:plugins:sort:date' => "Les plus récents",
  'admin:plugins:sort:priority' => "Priorité",
  'admin:plugins:warning:invalid:check_docs' => "Vérifiez &lt;a href=&quot;http://docs.elgg.org/Invalid_Plugin&quot;&gt;la documentation Elgg&lt;/a&gt; pour des astuces de résolution de problèmes.",
  'admin:plugins:warning:unmet_dependencies_active' => "Ce plugin est activé mais a des dépendances non satisfaites. Vous pouvez rencontrer des problèmes. Consultez &quot;plus d'informations&quot; ci-dessous pour des informations détaillées.",
  'admin:server:error_log' => "Journal d'erreurs du serveur web",
  'admin:server:label:log_location' => "Emplacement du journal",
  'admin:server:label:mem_avail' => "Mémoire disponible",
  'admin:server:label:mem_used' => "Mémoire utilisée",
  'admin:server:label:php_ini' => "Emplacement du fichier PHP.ini",
  'admin:server:label:php_log' => "Journal PHP",
  'admin:server:label:php' => "PHP",
  'admin:server:label:php_version' => "Version de PHP",
  'admin:server:label:post_max_size' => "Taille maximale des requêtes POST",
  'admin:server:label:server' => "Serveur",
  'admin:server:label:upload_max_filesize' => "Taille maximale des fichiers envoyés",
  'admin:server:label:web_server' => "Serveur web",
  'admin:server:warning:post_max_too_small' => "(Note: post_max_size doit être supérieur à cette valeur pour permettre des envois de cette taille - pensez aux entêtes des requêtes)",
  'admin:statistics:label:admins' => "Administrateurs",
  'admin:statistics:server' => "Informations du serveur",
  'admin:users:admins' => "Administrateurs",
  'admin:widget:control_panel' => "Tableau de bord d'administration",
  'admin:widget:control_panel:help' => "Fournit un accès rapide aux fonctionnalités de contrôle les plus communes",
  'avatar:remove:fail' => "Echec de la suppression de l'image de profil",
  'avatar:remove' => "Supprimer votre image de profil et rétablir l'icône de profil par défaut",
  'avatar:remove:success' => "Suppression de l'image de profil réussie",
  'back' => "Retour",
  'create' => "Créer",
  'filter' => "Filtrer",
  'DatabaseException:InvalidDBLink' => "La connexion à la base de données a été perdue.",
  'deleteconfirm:plural' => "Etes-vous sûr(e) de vouloir supprimer ces éléments ?",
  'ElggPlugin:InvalidAndDeactivated' => "%s est un polugin invalide et a été désactivé.",
  'error:404' => "Désolé, la page demandée n'a pas été trouvée.",
  'error:default' => "Aïe... quelque chose n'a pas fonctionné.",
  'error:missing_data' => "Données manquantes dans votre requête",
  'exception:contact_admin' => "Une erreur irrécupérable s'est produite et a été enregistrée dans le journal. Contactez l'administrateur du site avec les informations suivantes : ",
  'friends:collection:edit_failed' => "Impossible d'enregistrer la collection.",
  'friends:collections:edited' => "Collection enregistrée",
  'generic_comment:title' => "Commentaire de %s",
  'generic_comment:on' => "%s sur %s",
  'installation:systemcache:description' => "Le cache système diminue le temps de chargement d'Elgg en mettant en cache des données dans des fichiers.",
  'installation:systemcache:label' => "Utiliser le cache système (recommandé)",
  'InvalidParameterException:LibraryNotFound' => "Impossible de charger la bibliohtèque %s à partir de %s",
  'item:object:admin_notice' => "Information pour l'administrateur",
  'LoginException:ChangePasswordFailure' => "Echec de la vérification du mot de passe actuel.",
  'LoginException:Unknown' => "Impossible de vous identifier sur le site suite à une erreur inconnue.",
  'menu:page:header:default' => "Autre",
  'new' => "Nouveau",
  'none' => "aucun",
  'noaccess' => "Vous devez vous connecter pour accéder à cette publication, ou celle-ci a été supprimée, ou vous n'avez pas le droit d'y accéder.",
  'profile:noaccess' => "Vous n'avez pas la permission de modifier ce profil.",
  'off' => "Désactivé",
  'on' => "Activé",
  'PluginException:NullInstantiated' => "La classe ElggPlugin n'a pas pu être instanciée. Vous devez passer un GUID, un ID de plugin, ou un chemin complet.",
  'plugins:disabled' => "Les plugins n'ont pas été chargés car un fichier nommé &quot;disabled&quot; est présent dans le répertoire mod/ du serveur.",
  'preview' => "Prévisualiser",
  'profile:field:date' => "Date",
  'profile:field:email' => "Adresse de courriel",
  'profile:field:location' => "Adresse ou localisation",
  'profile:field:longtext' => "Zone de texte étendue",
  'profile:field:tags' => "Mots-clefs",
  'profile:field:text' => "Texte court",
  'profile:field_too_long' => "Impossible d'enregistrer vos informations de profil car la section &quot;%s&quot; est trop longue.",
  'profile:field:url' => "Adresse web (URL)",
  'profile:resetdefault:confirm' => "Etes-vous sûr(e) de vouloir supprimer vos champs de profil personnalisés ?",
  'register:fields' => "Tous les champs sont requis",
  'registration:usernametoolong' => "Votre nom d'utilisateur est trop long. Il doit être d'une longuaeur maximale de %u caractères.",
  'remove' => "Retirer",
  'revert' => "Rétablir",
  'river:comment:object:default' => "%s a commenté %s",
  'river:delete:fail' => "L'élément de la rivière n'a pas pu être supprimé",
  'river:delete:success' => "L'élément de la rivière a été supprimé",
  'SecurityException:ForwardFailedToRedirect' => "La redirection n'a pas pu être effectuée car les headers ont déjà été envoyés. Suspension de l'exécution pour des raisons de sécurité. Consultez la documentation d'Elgg sur <a href=\"http://docs.elgg.org/\">http://docs.elgg.org/</a> pour plus d'informations.",
  'settings:edit' => "Modifier les paramètres",
  'sort' => "Trier",
  'upgrade:locked' => "Impossible de mettre à jour. Une autre mise à jour est en cours. Pour supprimer le verrou d'installation, veuillez vous rendre dans la section Administration du site.",
  'upgrade:unlock:confirm' => "La base de données est verrouillé pour une autre mise à jour. Lancer des mises à jour concurrentes est dangereux. Vous ne devriez poursuivre que si vous savez qu'il n'y a pas d'autre mise à jour en cours d'exécution. Déverrouiller ?",
  'upgrade:unlock' => "Débloquer le verrou de mise à jour",
  'upgrade:unlock:success' => "Verrou de mise à jour débloqué. Vous pouvez procéder à la mise à jour.",
	
);

add_translation("fr",$french);

