<?php
/* ############################### CORE ############################ */
/**
	 * Basée sur la traduction de RONNEL Jérémy | Laurent Grangeau - jeremy.ronnel@elbee.fr | laurent.grangeau@gmail.com
	 * Traduction core version 1.5 par Fabien Eychenne | fabien.eychenne@gmail.com et Maxime Granier | maxime.granier@gmail.com
	 * Traductions plugins multisite, anfh_specific, notificationsplus et multipublisher par Mélèze conseil
	 * Compilation, traductions autres plugins, adaptations et compléments par Facyla http://id.facyla.net
	 **/
$french = array(
  /**
   * Sites
   */
    'item:site' => 'Sites',
  /**
   * Sessions
   */
    'login' => "Connexion",
    'loginok' => "Vous êtes désormais connecté(e).",
    'loginerror' => "Nous n'avons pas pu vous identifier. Cette erreur peut être due, soit, au fait que vous n'avez pas encore validé votre compte, que les informations entrées sont incorrectes ou que vous avez fait trop de tentatives de connexion. Assurez-vous que les informations que vous avez entrées sont correctes et réessayez.",
    'logout' => "Déconnexion",
    'logoutok' => "Vous avez été déconnecté(e).",
    'logouterror' => "Nous n'avons pas pu vous connecter. Essayez de nouveau.",
  /**
   * Errors
   */
    'exception:title' => "Bienvenue sur Elgg.",
    'InstallationException:CantCreateSite' => "Impossibilité de créer le site Elgg %s à l'URL %s",
    'actionundefined' => "L'action demandée (%s) n'est pas définie par le système.",
    'actionloggedout' => "Désolé, vous devez être connecté(e) pour exécuter cette action.",
    'notfound' => "La ressource demandée n'a pas été trouvée, ou peut être vous n'avez pas les autorisations nécessaire pour y accéder.",
    'SecurityException:Codeblock' => "Accès non autorisé pour la création de block.",
    'DatabaseException:WrongCredentials' => "Elgg n'a pas pu se connecter à la base de données avec les informations données.",
    'DatabaseException:NoConnect' => "Elgg n'a pas pu sélectionner la base de données '%s', merci de vérifier que la base de données est bien créée et que vous y avez accès.",
    'SecurityException:FunctionDenied' => "L'accès à la fonction privilégiée '%s' n'est pas accordé.",
    'DatabaseException:DBSetupIssues' => "Il y a eu plusieurs problèmes : ",
    'DatabaseException:ScriptNotFound' => "Elgg n'a pas pu trouver le script de la base de données a %s.",
    'IOException:FailedToLoadGUID' => "Echec du chargement du nouveau %s avec le GUID:%d",
    'InvalidParameterException:NonElggObject' => "Types incompatibles, objet de type non-Elgg vers un constructeur d'objet Elgg !",
    'InvalidParameterException:UnrecognisedValue' => "Valeur de type non reconnu passée en argument.",
    'InvalidClassException:NotValidElggStar' => "GUID:%d n'est pas valide %s",
    'PluginException:MisconfiguredPlugin' => "%s est un plugin non configuré.",
    'InvalidParameterException:NonElggUser' => "Types incompatibles, utilisateur de type non-Elgg vers un constructeur d'utilisateur Elgg !",
    'InvalidParameterException:NonElggSite' => "Types incompatibles, site de type non-Elgg vers un constructeur de site Elgg !",
    'InvalidParameterException:NonElggGroup' => "Types incompatibles, groupe de type non-Elgg vers un constructeur de groupe Elgg !",
    'IOException:UnableToSaveNew' => "Impossible de sauvegarder le nouveau %s",
    'InvalidParameterException:GUIDNotForExport' => "GUID non spécifié durant l'export, ceci ne devrait pas se produire.",
    'InvalidParameterException:NonArrayReturnValue' => "La fonction de sérialisation de l'entité a retourné une valeur dont le type n'est pas un tableau.",
    'ConfigurationException:NoCachePath' => "Le chemin du cache est vide!",
    'IOException:NotDirectory' => "%s n'est pas un répertoire.",
    'IOException:BaseEntitySaveFailed' => "Impossibilité de sauver les informations de bases du nouvel objet!",
    'InvalidParameterException:UnexpectedODDClass' => "import() a passé un argument qui n'est pas du type ODD class",
    'InvalidParameterException:EntityTypeNotSet' => "Le type d'entité doit être renseigné.",
    'ClassException:ClassnameNotClass' => "%s n'est pas %s.",
    'ClassNotFoundException:MissingClass' => "La classe '%s' n'a pas été trouvée, le plugin serait-il manquant?",
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
    'ClassNotFoundException:NotFoundNotSavedWithFile' => "Fichiers stockés non trouvés ou classes non sauvegardées avec le fichier!",
    'NotificationException:NoNotificationMethod' => "Aucune méthode de notification spécifiée.",
    'NotificationException:NoHandlerFound' => "Aucune fonction trouvée pour '%s' ou elle ne peut être appelée.",
    'NotificationException:ErrorNotifyingGuid' => "Une erreur s'est produite lors de la notification %d",
    'NotificationException:NoEmailAddress' => "Impossible de trouver une adresse email pour GUID:%d",
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
    'InvalidParameterException:MissingParameter' => "Argument manquant, il faut fournir un GUID.",
    'SecurityException:APIAccessDenied' => "Désolé, l'accès API a été désactivé par l'administrateur.",
    'SecurityException:NoAuthMethods' => "Aucune méthode d'authentification n'a été trouvée pour cette requête API.",
    'APIException:ApiResultUnknown' => "Les résultats de API sont de types inconnus, ceci ne devrait pas se produire.",
    'ConfigurationException:NoSiteID' => "L'identifiant du site n'a pas été spécifié.",
    'InvalidParameterException:UnrecognisedMethod' => "Appel à la méthode '%s' non-reconnu",
    'APIException:MissingParameterInMethod' => "Argument %s manquant pour la méthode %s",
    'APIException:ParameterNotArray' => "%s n'est semble t-il pas un tableau.",
    'APIException:UnrecognisedTypeCast' => "Type %s non reconnu pour la variable '%s' pour la fonction '%s'",
    'APIException:InvalidParameter' => "Paramètre invalide pour '%s' pour la fonction '%s'.",
    'APIException:FunctionParseError' => "%s(%s) a une erreur d'analyse.",
    'APIException:FunctionNoReturn' => "%s(%s) ne retourne aucune valeur.",
    'SecurityException:AuthTokenExpired' => "Le jeton d'authentification est manquant, invalide ou expiré.",
    'CallException:InvalidCallMethod' => "%s doit être appelé en utilisant '%s'",
    'APIException:MethodCallNotImplemented' => "L'appel à la méthode '%s' n'a pas été implémenté.",
    'APIException:AlgorithmNotSupported' => "L'algorithme '%s' n'est pas supporté ou a été désactivé.",
    'ConfigurationException:CacheDirNotSet' => "Le répertoire de cache 'cache_path' n'a pas été renseigné.",
    'APIException:NotGetOrPost' => "La méthode de requête doit être GET ou POST",
    'APIException:MissingAPIKey' => "X-Elgg-apikey manquant dans l'entête HTTP",
    'APIException:MissingHmac' => "X-Elgg-hmac manquant dans l'entête",
    'APIException:MissingHmacAlgo' => "X-Elgg-hmac-algo manquant dans l'entête",
    'APIException:MissingTime' => "X-Elgg-time manquant dans l'entête",
    'APIException:TemporalDrift' => "X-Elgg-time est trop éloigné dans le temps. Epoch a échoué.",
    'APIException:NoQueryString' => "Aucune valeur dans la requête",
    'APIException:MissingPOSTHash' => "X-Elgg-posthash manquant dans l'entête",
    'APIException:MissingPOSTAlgo' => "X-Elgg-posthash_algo manquant dans l'entête",
    'APIException:MissingContentType' => "Le content-type est manquant pour les données postées",
    'SecurityException:InvalidPostHash' => "La signature des données POST est invalide.%s attendu mais %s reçu.",
    'SecurityException:DupePacket' => "La signature du paquet a déjà été envoyée.",
    'SecurityException:InvalidAPIKey' => "API Key invalide ou non-reconnue.",
    'NotImplementedException:CallMethodNotImplemented' => "La méthode '%s' n'est pas supportée actuellement.",
    'NotImplementedException:XMLRPCMethodNotImplemented' => "L'appel à la méthode XML-RPC '%s' n'a pas été implémentée.",
    'InvalidParameterException:UnexpectedReturnFormat' => "L'appel à la méthode '%s' a retourné un résultat inattendu.",
    'CallException:NotRPCCall' => "L'appel ne semble pas être un appel XML-RPC valide",
    'PluginException:NoPluginName' => "Le nom du plugin n'a pas pu être trouvé",
    'ConfigurationException:BadDatabaseVersion' => "La version de la base de données ne correspondant pas au minimum requis par Elgg. Veuillez vous référer à la documentation de Elgg.",
    'ConfigurationException:BadPHPVersion' => "Elgg requiert au minimum PHP 5.2.",
    'configurationwarning:phpversion' => "Elgg requiert au minimum PHP 5.2, une installation est possible sur 5.1.6 au risque de perdre quelques fonctionnalités. A utiliser à vos risques et périls.",
    'InstallationException:DatarootNotWritable' => "Le répertoire des données %s n'est pas accessible en écriture.",
    'InstallationException:DatarootUnderPath' => "Le répertoire des données %s doit être en dehors de votre dossier d'installation de Elgg.",
    'InstallationException:DatarootBlank' => "Vous n'avez pas spécifié de dossier pour le stockage des fichiers.",
    'SecurityException:authenticationfailed' => "Impossible d'authentifier l'utilisateur",
    'CronException:unknownperiod' => "%s n'est pas une période valide.",
    'SecurityException:deletedisablecurrentsite' => "Impossible de supprimer ou désactiver le site en cours !",
    'memcache:notinstalled' => "Le module PHP memcache n'est pas installé. Vous devez installer php5-memcache",
    'memcache:noservers' => "Pas de serveur memcache défini, veuillez renseigner la variable $CONFIG->memcache_servers",
    'memcache:versiontoolow' => "Memcache nécessite au minimum la version %s pour fonctionner, vous avez la version %s",
    'memcache:noaddserver' => "Le support de serveurs multiples est désactivé, vous avez peut-être besoin de mettre à jour votre bibliothèque memcache PECL",
  /**
   * API
   */
    'system.api.list' => "Liste tous les appels API au système.",
    'auth.gettoken' => "Cet appel API permet à un utilisateur de se connecter, il retourne une clef d'authentification qui permet de rendre la tentative de connexion unique.",
  /**
   * User details
   */
    'name' => "Prénom et nom",
    'email' => "Adresse mail",
    'username' => "Identifiant de connexion",
    'password' => "Mot de passe",
    'passwordagain' => "Confirmation du mot de passe",
    'admin_option' => "Définir cet utilisateur comme administrateur ?",
  /**
   * Access
   */
    'PRIVATE' => "Privé / brouillon",
    'LOGGED_IN' => "Membres du site",
    'PUBLIC' => "Public",
    'access:friends:label' => "Contacts",
    'access' => "Accès",
  /**
   * Dashboard and widgets
   */
    'dashboard' => "Tableau de bord",
    'dashboard:configure' => "Choisir et organiser les modules de ma page",
    'dashboard:nowidgets' => "Votre tableau de bord est votre page d'accueil sur le site. Cliquez sur 'Modifier cette page' pour ajouter des widgets pour garder un oeil sur le contenu et votre activité sur le site.",
    'widgets:add' => 'Ajouter des widgets à votre page',
    'widgets:add:description' => "Choisissez les fonctionnalités à faire apparaître en glissant un élément de <b>la liste de Widgets</b> (modules) sur la droite, vers l'une des trois zones ci-dessous. Positionnez-les selon vos envies. Vous pouvez utiliser plusieurs fois le même widget en enregistrant vos modifications, puis en recommençant.
Pour retirer un widget, glissez-le vers <b>la liste de Widgets</b> et engreistrez.",
    'widgets:position:fixed' => '(Position modifiée sur la page)',
    'widgets' => "Widgets",
    'widget' => "Widget",
    'item:object:widget' => "Widgets",
    'layout:customise' => "Personnaliser la mise en page",
    'widgets:gallery' => "Liste des widgets",
    'widgets:leftcolumn' => "Widgets de gauche",
    'widgets:fixed' => "Position modifiée",
    'widgets:middlecolumn' => "Widgets du milieu",
    'widgets:rightcolumn' => "Widgets de droite",
    'widgets:profilebox' => "Boîte de profil",
    'widgets:panel:save:success' => "Vos widgets ont été sauvegardés avec succès.",
    'widgets:panel:save:failure' => "Un problème est survenu lors de l'enregistrement de vos widgets. Veuillez recommencer.",
    'widgets:save:success' => "Le widget a été sauvegardé avec succès.",
    'widgets:save:failure' => "Un problème est survenu lors de l'enregistrement de votre widget. Veuillez recommencer.",
    'widgets:handlernotfound' => "Ce widget est ou bien cassé, ou alors a été désactivé par l'administrateur du site.",
  /**
   * Groups
   */
    'group' => "Groupe",
    'item:group' => "Groupes",
  /**
   * Profile
   */
    'profile' => "Profil",
    'profile:edit:default' => 'Remplacer les champs du profil',
    'user' => "Utilisateur",
    'item:user' => "Utilisateurs",
    'riveritem:single:user' => 'un utilisateur',
    'riveritem:plural:user' => 'des utilisateurs',
  /**
   * Profile menu items and titles
   */
    'profile:yours' => "Votre profil",
    'profile:user' => "Le profil de %s",
    'profile:edit' => "Modifier le profil",
    'profile:profilepictureinstructions' => "L'image de votre profil est l'image qui s'affichera sur la page de votre profil. <br /> Vous pouvez la changer autant de fois que vous le désirez. (Les types de fichiers images acceptés sont : GIF, JPG or PNG)",
    'profile:icon' => "Image de votre profil",
    'profile:createicon' => "Créer votre photo de profil",
    'profile:currentavatar' => "photo de profil actuelle",
    'profile:createicon:header' => "Photo de votre profil",
    'profile:profilepicturecroppingtool' => "Outil de retaillage de la photo",
    'profile:createicon:instructions' => "Cliquer et déplacer le carré ci-dessous afin de définir le retouchage de votre photo.  Un aperçu sera disponible sur la droite de l'image.  Lorsque vous êtes content de votre choix, cliquer sur 'Créer ma photo de profil'. Cette image recadrée sera utilisée sur le site comme votre photo de profil. ",
    'profile:editdetails' => "Modifier le profil",
    'profile:editicon' => "Changer la photo",
    'profile:aboutme' => "A propos de moi",
    'profile:description' => "A propos de moi",
    'profile:briefdescription' => "Description brève",
    'profile:location' => "Localisation géographique (lieux séparés par des virgules)",
    'profile:skills' => "Expériences",
    'profile:interests' => "Centres d'intérêt (tags séparés par des virgules)",
    'profile:contactemail' => "Adresse email de contact",
    'profile:phone' => "Téléphone",
    'profile:mobile' => "Téléphone mobile",
    'profile:website' => "Site internet",
    'profile:banned' => 'Ce compte a été désactivé.',
    'profile:river:update' => "%s a mis à jour son profil",
    'profile:river:iconupdate' => "%s a mis à jour sa photo",
    'profile:label' => "Etiquette de profil",
    'profile:type' => "Type de profil",
    'profile:editdefault:fail' => 'Une erreur est survenue lors de la sauvegarde du profil par défaut.',
    'profile:editdefault:success' => "L'élément a été ajouté avec succès au profil par défaut.",
    'profile:editdefault:delete:fail' => "La suppression de l'élément lié au profil par défaut a échouée",
    'profile:editdefault:delete:success' => "L'élément du profil par défaut a été supprimé !",
    'profile:defaultprofile:reset' => 'Profil par défaut réinitialisé.',
    'profile:resetdefault' => 'Profil par défaut réinitialisé.',
  /**
   * Profile status messages
   */
    'profile:saved' => "Votre profil a bien été sauvegardé.",
    'profile:icon:uploaded' => "La photo de votre profil a bien été chargée.",
  /**
   * Profile error messages
   */
    'profile:noaccess' => "Vous n'avez pas accès à ce profil.",
    'profile:notfound' => "Le profil recherché n'existe pas ou plus.",
    'profile:cantedit' => "Vous n'avez pas la permission de modifier ce profil.",
    'profile:icon:notfound' => "Desolé, il y a eu un problème lors du chargement de l'image de votre profil.",
  /**
   * Friends
   */
    'friends' => "Contacts",
    'friends:yours' => "Vos contacts",
    'friends:owned' => "Les contacts de %s",
    'friend:add' => "Devenir son contact",
    'friend:remove' => "Retirer ce contact",
    'friends:add:successful' => "Vous êtes maintenant en contact avec %s.",
    'friends:add:failure' => "%s n'a pas pu être ajouté(e) comme contact. Merci de réessayer.",
    'friends:remove:successful' => "Vous avez supprimé %s de vos contacts.",
    'friends:remove:failure' => "%s n'a pas pu être supprimé(e) de vos contacts. Merci de réessayer.",
    'friends:none' => "Cet utilisateur n'a pas encore ajouté de contact.",
    'friends:none:you' => "Vous n'avez pas de contact ! Pensez à vos centres d'intérêts pour trouver des personnes que vous pourriez suivre.",
    'friends:none:found' => "Aucun contacts n'ont été trouvés.",
    'friends:of:none' => "Personne n'a encore ajouté cet utilisteur comme contact.",
    'friends:of:none:you' => "Personne ne vous a encore ajouté comme contact. Commencez par remplir votre page profil et publiez du contenu pour que les gens vous trouvent !",
    'friends:of:owned' => "Les personnes qui ont %s comme contact",
    'friends:num_display' => "Nombre de contacts à afficher",
    'friends:icon_size' => "Taille de l'icône",
    'friends:tiny' => "Toute petite",
    'friends:small' => "Petite",
    'friends:of' => "Suivi par..",
    'friends:collections' => "Listes de contacts",
    'friends:collections:add' => "Nouvelle liste de contacts",
    'friends:addfriends' => "Ajouter des contacts",
    'friends:collectionname' => "Nom de la liste",
    'friends:collectionfriends' => "Contacts dans la liste",
    'friends:collectionedit' => "Modifier cette liste",
    'friends:nocollections' => "Vous n'avez pas encore de liste de contacts.",
    'friends:collectiondeleted' => "Votre liste de contacts a été supprimé.",
    'friends:collectiondeletefailed' => "La liste de contacts n'a pas été supprimée. Vous n'avez probablement pas les droits qui permettent cela, ou un autre problème peut être en cause.",
    'friends:collectionadded' => "Votre liste de contact a bien été créée",
    'friends:nocollectionname' => "Vous devez nommer votre liste de contact pour qu'elle puisse en enregistrée.",
    'friends:collections:members' => "Liste de contacts",
    'friends:collections:edit' => "Modifier la liste de contacts",
    'friends:river:created' => "%s a ajouté le widget Contacts.",
    'friends:river:updated' => "%s a mis à jour son widget Contacts.",
    'friends:river:delete' => "%s a supprimé son widget Contacts.",
    'friends:river:add' => "%s est maintenant le contact de",
    'friendspicker:chararray' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
  /**
   * Feeds
   */
    'feed:rss' => "RSS",
    'feed:odd' => 'OpenDD',
  /**
   * links
   **/
    'link:view' => 'voir le lien',
  /**
   * River
   */
    'river' => "River",
    'river:relationship:friend' => 'est maintenant en contact avec',
    'river:noaccess' => "Vous n'avez pas la permission de voir cet élément.",
    'river:posted:generic' => '%s a publié',
  /**
   * Plugins
   */
    'plugins:settings:save:ok' => "Le paramétrage du plugin %s a été enregistré.",
    'plugins:settings:save:fail' => "Il y a eu un problème lors de l'enregistrement des paramètres du plugin %s.",
    'plugins:usersettings:save:ok' => "Le paramétrage du plugin a été enregistré avec succès.",
    'plugins:usersettings:save:fail' => "Il y a eu un problème lors de l'enregistrement du paramétrage du plugin %s.",
    'admin:plugins:label:version' => "Version",
    'item:object:plugin' => 'Paramètres de configuration du plugin',
  /**
   * Notifications
   */
    'notifications:usersettings' => "paramétrages du système de notification",
    'notifications:methods' => "Merci de spécifier les méthodes que vous souhaitez permettre.",
    'notifications:usersettings:save:ok' => "La configuration des paramétrages du sytème de notification a été enregistrée avec succès.",
    'notifications:usersettings:save:fail' => "Il y a eu un problème lors de la sauvegarde des paramètres du système de notification.",
    'user.notification.get' => 'Redonner les paramèters du sytème de notification pour un utilisateur donné.',
    'user.notification.set' => 'Déterminer les paramètres du système de notification pour un utilisateur donné.',
  /**
   * Search
   */
    'search' => "Rechercher",
    'searchtitle' => "Rechercher: %s",
    'users:searchtitle' => "Recherche des utilisateurs: %s",
    'advancedsearchtitle' => "%s résultat(s) trouvé(s) pour %s",
    'notfound' => "Aucun résultat trouvé. La ressource que vous recherchez a peut-être été supprimée, ou vous devriez vous identifier sur la plateforme pour y avoir accès.",
    'next' => "Suivant",
    'previous' => "Précédent",
    'viewtype:change' => "Changer le type de liste",
    'viewtype:list' => "Liste",
    'viewtype:gallery' => "Galerie",
    'tag:search:startblurb' => "Résultats pour le tag '%s':",
    'user:search:startblurb' => "Utilisateurs associés '%s':",
    'user:search:finishblurb' => "Plus de résultats...",
  /**
   * Account
   */
    'account' => "Compte",
    'settings' => "Mes réglages",
    'tools' => "Outils",
    'tools:yours' => "Vos outils",
    'register' => "Créer mon compte",
    'registerok' => "Vous vous êtes enregistré avec succès sur %s.",
    'registerbad' => "La création de votre compte n'a pas fonctionné. Le nom utilisateur existe peut-être déjà, vos mots de passe ne correspondent pas, ou votre nom d'utilisateur ou votre mot de passe est peut-être trop court (6 caractères min.)",
    'registerdisabled' => "La création de compte a été désactivé par l'administrateur du site.",
    'firstadminlogininstructions' => "Votre nouveau site Elgg a été installé avec succès et votre compte administrateur a été créé. Vous pouvez maintenant configurer votre site en activant les différents plugins disponibles dans le panneau d'administration.",
    'registration:notemail' => "L'adresse e-mail que vous avez renseigné n'apparaît pas comme valide.",
    'registration:userexists' => "Ce nom d'utilisateur existe déjà",
    'registration:usernametooshort' => "Le nom d'utilisateur doit faire 4 caractères au minimum.",
    'registration:passwordtooshort' => 'Le mot de passe doit faire 6 caractères au minimum.',
    'registration:dupeemail' => 'Cette adresse e-mail est déjà utilisée.',
    'registration:invalidchars' => "Désolé, votre nom d'utilisateur contient des caractères invalides.",
    'registration:emailnotvalid' => "Désolé, l'adresse e-mail que vous avez entré est invalide sur ce site.",
    'registration:passwordnotvalid' => 'Désolé, le mot de passe que vous avez entré est invalide sur ce site.',
    'registration:usernamenotvalid' => "Désolé, le nom d'utilisateur que vous avez entré est invalide sur ce site.",
    'adduser' => "Ajouter un utilistateur",
    'adduser:ok' => "Vous avez ajouté un nouvel utilisateur avec succès.",
    'adduser:bad' => "Le nouvel utilisateur ne peut pas être créé.",
    'item:object:reported_content' => "Contenu signalé",
    'user:set:name' => "Nom de membre sur le site",
    'user:name:label' => "Votre nom sur le site",
    'user:name:success' => "Votre nom de membre a été changé avec succès.",
    'user:name:fail' => "Impossible de changer votre nom de membre.",
    'user:set:password' => "Mot de passe du compte",
    'user:password:label' => "Votre nouveau mot de passe",
    'user:password2:label' => "Veuillez re-saisir votre nouveau mot de passe",
    'user:password:success' => "Mot de passe modifié avec succès",
    'user:password:fail' => "Impossible de modifier votre mot de passe.",
    'user:password:fail:notsame' => "Les deux mots de passe ne correspondent pas!",
    'user:password:fail:tooshort' => "Le mot de passe est trop court !",
    'user:set:language' => "Langue du site",
    'user:language:label' => "Votre langue",
    'user:language:success' => "La langue du site a été modifiée.",
    'user:language:fail' => "Votre paramètre de langue n'a pas pu être sauvegardé.",
    'user:username:notfound' => "Nom d'utilisateur %s non trouvé.",
    'user:password:lost' => 'Mot de passe perdu ?',
    'user:password:resetreq:success' => 'Vous avez demandé un nouveau mot de passe, un e-mail vous a été envoyé',
    'user:password:resetreq:fail' => 'Impossible de demander un nouveau mot de passe.',
    'user:password:text' => "Pour générer un nouveau mot de passe, entrez votre nom d'utilisateur (votre identifiant de connexion au site) ou votre adresse email ci-dessous. Vous recevrez par mail un lien sur lequel vous devez cliquer pour valider votre demande, et recevrez dans les minutes qui suivent un second message avec votre nouveau mot de passe.",
    'user:persistent' => 'Rester connecté',
  /**
   * Administration
   */
    'admin:configuration:success' => "Vos paramètres ont bien été sauvegardés.",
    'admin:configuration:fail' => "Vos paramètres n'ont pas pu être sauvegardés.",
    'admin' => "Administration",
    'admin:description' => "Le panneau d'administration vous permet de contrôler tous les aspects du système d'Elgg, de la gestion des utilisateurs à la gestion des outils installés. Choisissez une option dans le menu ci-contre pour commencer.",
    'admin:user' => "Gestion des membres",
    'admin:user:description' => "Ce menu vous permet de contrôler les paramètres des utilisateurs sur votre site. Choisissez une option ci-dessous pour commencer.",
    'admin:user:adduser:label' => "Cliquer ici pour ajouter un nouvel utilisateur...",
    'admin:user:opt:linktext' => "Configurer les utilisateurs...",
    'admin:user:opt:description' => "Configurer les utilisateurs et les informations de compte. ",
    'admin:site' => "Gestion du site",
    'admin:site:description' => "Ce menu vous permet de définir les paramètres principaux de votre site. Choisissez une option ci-dessous pour commencer.",
    'admin:site:opt:linktext' => "Configurer le site...",
    'admin:site:opt:description' => "Configurer les paramètres techniques et non techniques du site. ",
    'admin:site:access:warning' => "Changer les paramètres d'accès n'affectera que les permissions de contenu créées dans le futur.",
    'admin:plugins' => "Gestion des outils",
    'admin:plugins:description' => "Ce menu vous permet de contrôler et de configurer les outils installés sur votre site.",
    'admin:plugins:opt:linktext' => "Configurer les outils...",
    'admin:plugins:opt:description' => "Configurer les outils installés sur le site. ",
    'admin:plugins:label:author' => "Auteur",
    'admin:plugins:label:copyright' => "Copyright",
    'admin:plugins:label:licence' => "Licence",
    'admin:plugins:label:website' => "URL",
    'admin:plugins:label:moreinfo' => "Plus d'informations",
    'admin:plugins:label:version' => 'Version',
    'admin:plugins:warning:elggversionunknown' => 'Attention : Ce plugin ne spécifie pas une compatibilité pour cette version de Elgg.',
    'admin:plugins:warning:elggtoolow' => 'Attention : Ce plugin requiert une version antérieure de Elgg!',
    'admin:plugins:reorder:yes' => "Le plugin %s a été réordonné avec succès.",
    'admin:plugins:reorder:no' => "Le plugin %s n'a pas pu être réordonné.",
    'admin:plugins:disable:yes' => "Le plugin %s a été désactivé avec succès.",
    'admin:plugins:disable:no' => "Le plugin %s n'a pas pu être désactivé.",
    'admin:plugins:enable:yes' => "Le plugin %s a été activé avec succès.",
    'admin:plugins:enable:no' => "Le plugin %s n'a pas pu être activé.",
    'admin:statistics' => "Statistiques",
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
    'admin:user:label:search' => "Trouver des utilisateurs:",
    'admin:user:label:seachbutton' => "Rechercher",
    'admin:user:ban:no' => "Ce compte ne peut pas être banni/désactivé",
    'admin:user:ban:yes' => "Compte désactivé.",
    'admin:user:unban:no' => "Cet utilisateur ne peut pas être réintégré",
    'admin:user:unban:yes' => "Utilisateur réintégré.",
    'admin:user:delete:no' => "Cet utilisateur ne peut pas être supprimé",
    'admin:user:delete:yes' => "Utilisateur supprimé",
    'admin:user:resetpassword:yes' => "Mot de passe réinitialisé, utilisateur notifié.",
    'admin:user:resetpassword:no' => "Le mot de passe n'a pas pu être réinitialisé.",
    'admin:user:makeadmin:yes' => "L'utilisateur est maintenant un administrateur.",
    'admin:user:makeadmin:no' => "Nous ne pouvons pas faire de cet utilisateur un administrateur.",
    'admin:user:removeadmin:yes' => "L'utilisateur n'est plus administrateur.",
    'admin:user:removeadmin:no' => "Nous ne pouvons pas supprimer les privilèges d'administrateur à cet utilisateur.",
  /**
   * User settings
   */
    'usersettings:description' => "Le panneau de configuration vous permet de contrôler tous vos paramètres et vos plugins. Choisissez une option ci-dessous pour continuer.",
    'usersettings:statistics' => "Vos statistiques",
    'usersettings:statistics:opt:description' => "Visualiser les statistiques des utilisateurs et des objets sur votre espace.",
    'usersettings:statistics:opt:linktext' => "Statistiques de votre compte.",
    'usersettings:user' => "Vos paramètres",
    'usersettings:user:opt:description' => "Ceci vous permet de contrôler vos paramètres.",
    'usersettings:user:opt:linktext' => "Changer vos paramètres",
    'usersettings:plugins' => "Outils",
    'usersettings:plugins:opt:description' => "Configurer vos paramètres (s'il y a lieu) pour activer vos outils.",
    'usersettings:plugins:opt:linktext' => "Configurer vos outils",
    'usersettings:plugins:description' => "Ce panneau de configuration vous permez de mettre à jour les options de vos outils installés par l'administrateur.",
    'usersettings:statistics:label:numentities' => "Vos entités",
    'usersettings:statistics:yourdetails' => "Vos informations",
    'usersettings:statistics:label:name' => "Votre nom",
    'usersettings:statistics:label:email' => "Email",
    'usersettings:statistics:label:membersince' => "Membre depuis",
    'usersettings:statistics:label:lastlogin' => "Dernière connexion",
  /**
   * Generic action words
   */
    'save' => "Enregistrer",
    'publish' => "Publier",
    'cancel' => "Annuler",
    'saving' => "Enregistrement en cours",
    'update' => "Mettre à jour",
    'edit' => "Modifier",
    'delete' => "Supprimer",
    'accept' => "Accepter",
    'load' => "Charger",
    'upload' => "Charger",
    'ban' => "Désactiver/Bannir",
    'unban' => "Réintégrer",
    'enable' => "Activer",
    'disable' => "Désactiver",
    'request' => "Demander la réinitialisation du mot de passe",
    'complete' => "Compléter",
    'open' => 'Ouvrir',
    'close' => 'Fermer',
    'reply' => "Répondre",
    'more' => 'Plus',
    'comments' => 'Commentaires',
    'import' => 'Importer',
    'export' => 'Exporter',
    'up' => 'Monter',
    'down' => 'Descendre',
    'top' => 'Au-dessus',
    'bottom' => 'Au-dessous',
    'invite' => "Inviter",
    'resetpassword' => "Réinitialiser le mot de passe",
    'makeadmin' => "Donner à cet utilisateur le statut d'administrateur",
    'removeadmin' => "Supprimer les droits administrateur de l'utilisateur",
    'option:yes' => "Oui",
    'option:no' => "Non",
    'unknown' => 'Inconnu',
    'active' => 'Activé',
    'total' => 'Total',
    'learnmore' => "Cliquer ici pour en apprendre plus.",
    'content' => "contenu",
    'content:latest' => 'Dernière activité',
    'content:latest:blurb' => 'Vous pouvez également cliquer ici pour voir les dernières modifications effectuées sur le site.',
    'link:text' => 'voir le lien',
    'enableall' => 'Tout activer',
    'disableall' => 'Tout désactiver',
  /**
   * Generic questions
   */
    'question:areyousure' => 'Etes-vous sûr ?',
  /**
   * Generic data words
   */
    'title' => "Titre",
    'description' => "Description",
    'tags' => "Tags (séparés par des virgules)",
    'spotlight' => "Plateforme sociale &nbsp; ~ &nbsp; Besoin d'aide ?", // Anciennement "Projecteur sur" ou "Focus" ou "En ce moment"...
    'all' => "Tous",
    'by' => 'par',
    'annotations' => "Annotations",
    'relationships' => "Relations",
    'metadata' => "Métadonnées",
  /**
   * Input / output strings
   */
    'deleteconfirm' => "Etes-vous sur de vouloir supprimer cet élément ?",
    'fileexists' => "Un fichier a déjà été chargé. Pour le remplacer sélectionnez-le ci-dessous.:",
  /**
   * User add
   */
    'useradd:subject' => "Compte de l'utilisateur créé",
    'useradd:body' => "
%s,
Un compte utilisateur vous a été créé à %s. Pour vous connecter, rendez-vous sur la page %s

Et connectez-vous avec les identifiants suivant
Nom d'utilisateur: %s
Mot de passe: %s

Une fois que vous vous êtes connecté(e), nous vous conseillons fortement de changer votre mot de passe.
",
    /**
       * System messages
       **/
    'systemmessages:dismiss' => "Cliquer pour fermer",
  /**
   * Import / export
   */
    'importsuccess' => "L'import des données a été réalisée avec succès",
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
  /**
   * Installation and system settings
   */
    'installation:error:htaccess' => "Elgg requiert un fichier .htaccess à la racine de l'installation. L'écriture automatique du fichier par l'installeur a échoué.
La création de ce fichier est facile. Copiez-collez le texte ci-dessous dans un fichier texte que vous nommerez .htaccess
",
    'installation:error:settings' => "Elgg requiert un fichier de configuration. Pour continuer :
1. Renommez 'engine/settings.example.php' en 'settings.php' dans le répertoire d'installation de Elgg.
2. Editer le fichier avec le bloc-notes et entrez les informations relatives à votre base de données MySQL. Si vous ne les connaissez pas contacter votre administrateur ou le support technique.
Elgg peut créer ce fichier pour vous, entrez les informations ci-dessous...",
    'installation:error:configuration' => "Une fois les corrections de configuration apportées, pressez 'Réessayer'.",
    'installation' => "Installation",
    'installation:success' => "La base de données a été créée avec succès.",
    'installation:configuration:success' => "Votre configuration initiale a été sauvegardée. Désormais enregistrer un premier utilisateur; il sera administrateur du système.",
    'installation:settings' => "Configuration du système",
    'installation:settings:description' => "Désormais la base de données de Elgg est installée, entrez quelques informations supplémentaires relatives à votre site. Certaines de ces informations sont automatiquement renseignées, <b>veuillez vérifier ces détails.</b>",
    'installation:settings:dbwizard:prompt' => "Entrez la configuration de votre base de données ci-dessous:",
    'installation:settings:dbwizard:label:user' => "Utilisateur",
    'installation:settings:dbwizard:label:pass' => "Mot de passe",
    'installation:settings:dbwizard:label:dbname' => "Nom de la base",
    'installation:settings:dbwizard:label:host' => "Serveur hôte (le plus souvent 'localhost')",
    'installation:settings:dbwizard:label:prefix' => "Préfixe des tables de données (le plus souvent 'elgg')",
    'installation:settings:dbwizard:savefail' => "La création du fichier 'settings.php' a échoué. Copiez-collez le texte ci-dessous dans un fichier texte 'engine/settings.php'.",
    'installation:sitename' => "Nom du site (par exemple \"Ma communauté\")::",
    'installation:sitedescription' => "Brève description du site (optionnel)",
    'installation:wwwroot' => "Adresse du site internet suivi de '\' :",
    'installation:path' => "Chemin physique des fichiers sur le serveur suivi de '\' :",
    'installation:dataroot' => "Chemin complet où héberger les fichiers uploadés par les utilisateurs suivi de '\' :",
    'installation:dataroot:warning' => "Vous devez créer ce répertoire manuellement. Il doit se situer dans un répertoire différent de votre installation de Elgg.",
    'installation:sitepermissions' => "Les permissions d'accès par défaut:",
    'installation:language' => "La langue par défaut de votre site:",
    'installation:debug' => "Le mode de débogage permet de mettre en évidence certaines erreurs de fonctionnement, cependant il ralenti l'accès au site, il est à utiliser uniquement en cas de problème:",
    'installation:debug:label' => "Activer le mode debug",
    'installation:httpslogin' => "Activer ceci afin que les utilisateurs puissent se connecter via le protocole https. Vous devez avoir https activé sur votre serveur afin que cela fonctionne.",
    'installation:httpslogin:label' => "Activer la connexion HTTPS",
    'installation:usage' => "Cette option permet l'envoie de statistiques anonyme vers Curverider.",
    'installation:usage:label' => "Envoyer des statistiques anonymement",
    'installation:view' => "Entrer le nom de la vue qui sera utilisée automatiquement pour l'affichage du site (par exemple : 'mobile'), laissez défault en cas de doute :",
    'installation:siteemail' => "L'adresse email du site (Elle sera utilisée lors d'envoi d'email par le système)",
    'installation:disableapi' => "L'API RESTful API est une interface qui permet à des applications d'utiliser certaines caractéristiques de Elgg à distance.",
    'installation:disableapi:label' => "Activer l'API RESTful",
    'installation:allow_user_default_access:description' => "Si cliqué, les utilisateurs pourront modifier leur niveau d'accès par défaut et pourront surpasser le niveau d'accès mis en place par défaut dans le système.",
    'installation:allow_user_default_access:label' => "Autoriser un niveau d'accès par défaut pour l'utilisateur",
    'installation:simplecache:description' => "Le cache simple augmente les performances en mettant en cache du contenu statique comme des CSS et des fichiers Javascripts. Normalement vous ne devriez pas avoir besoin de l'activer.",
    'installation:simplecache:label' => "Utiliser un cache simple",
    'upgrading' => 'Mise à jour en cours',
    'upgrade:db' => 'Votre base de données a été mise à jour.',
    'upgrade:core' => 'Votre installation de Elgg a été mise à jour',
  /**
   * Welcome
   */
    'welcome' => "Bienvenue",
    'welcome_message' => "Bienvenue sur ce site Elgg.",
  /**
   * Emails
   */
    'email:settings' => "Paramètres de mail",
    'email:address:label' => "Votre adresse email",
    'email:save:success' => "Votre nouvelle adresse email a été enregistrée, vous allez recevoir un email de confirmation.",
    'email:save:fail' => "Votre nouvelle adresse email n'a pas pu être enregistrée.",
    'friend:newfriend:subject' => "%s vous a ajouté comme contact !",
    'friend:newfriend:body' => "%s vous a ajouté comme contact !
Pour voir son profil cliquer sur le lien ci-dessous
%s
Vous ne pouvez pas répondre à cet email.",
    'email:resetpassword:subject' => "Mot de passe réinitialisé !",
    'email:resetpassword:body' => "Bonjour %s,
Votre nouveau mot de passe est : %s

Vous pouvez l'utiliser dès maintenant, et, si vous le souhaitez, pouvez le modifier après vous être connecté(e) sur le site.",
    'email:resetreq:subject' => "Demander un nouveau mot de passe.",
    'email:resetreq:body' => "Bonjour %s,
Quelqu'un, probablement vous (avec l'adresse IP %s), a demandé un nouveau mot de passe pour son compte.

Si vous avez effectivement demandé ce changement ou l'avez demandé au webmestre du site, veuillez cliquer sur le lien %s pour recevoir votre nouveau mot de passe par mail.


Si vous n'avez pas fait cette demande, veuillez ignorer cet email, ou le signaler à l'équipe du site.",
  /**
   * user default access
   */
  'default_access:settings' => "Votre niveau d'accès par défaut",
  'default_access:label' => "accès par défaut",
  'user:default_access:success' => "Votre nouveau niveau d'accès par défaut a été enregistré.",
  'user:default_access:failure' => "Votre nouveau niveau d'accès par défaut n'a pu être enregistré.",
  /**
   * XML-RPC
   */
    'xmlrpc:noinputdata'	=>	"Données d'entrées manquantes",
  /**
   * Comments
   */
    'comments:count' => "%s commentaire(s)",
    'riveraction:annotation:generic_comment' => '%s a commenté %s',
    'generic_comments:add' => "Ajouter un commentaire",
    'generic_comments:text' => "Commentaire",
    'generic_comment:posted' => "Votre commentaire a été publié avec succés.",
    'generic_comment:deleted' => "Votre commentaire a été supprimé avec succés.",
    'generic_comment:blank' => "Désolé, vous devez remplir votre commentaire avant de pouvoir l'enregistrer.",
    'generic_comment:notfound' => "Désolé, l'élément recherché n'a pas été trouvé.",
    'generic_comment:notdeleted' => "Désolé, le commentaire n'a pu être supprimé.",
    'generic_comment:failure' => "Une erreur est survenue lors de l'ajout de votre commentaire.",
    'generic_comment:email:subject' => 'Vous avez un nouveau commentaire !',
    'generic_comment:email:body' => "%2\$s a commenté \"%1\$s\" :
%s
Pour accéder à ce commentaire sur le site, suivez le lien %s
(note : si la page n'est pas accessible, vous devez d'abord vous connecter au site, puis cliquer à nouveau sur ce lien)
Pour voir le profil de %s, suivez le lien %s
Message envoyé automatiquement - merci de ne pas répondre à ce mail.",
  /**
   * Entities
   */
    'entity:default:strapline' => 'Créé le %s par %s',
    'entity:default:missingsupport:popup' => "Cette entité ne peut pas être affichée correctement. C'est peut-être dû à un plugin qui a été supprimé.",
    'entity:delete:success' => "L'entité %s a été effacée",
    'entity:delete:fail' => "L'entité %s n'a pas pu être effacée",
  /**
   * Action gatekeeper
   */
    'actiongatekeeper:missingfields' => 'Il manque les champs __token ou __ts dans le formulaire.',
    'actiongatekeeper:tokeninvalid' => "Une erreur est survenue. Cela veut probablement dire que la page que vous utilisiez a expirée. Merci de réessayer",
    'actiongatekeeper:timeerror' => 'La page a expiré, rafraichissez et recommencez à nouveau.',
    'actiongatekeeper:pluginprevents' => "Une extension a empêché ce formulaire d'être envoyé",
  /**
   * Word blacklists
   */
    'word:blacklist' => 'et, le, la les, un, une, des, alors, mais, je, tu, il, elle, on, nous, vous, ils, elles, son, sa, ses, nos, vos, lui, ne, pas, à propos, maintenant, depuis, quoique, encore, comme, plutôt, en conséquence, à la place, pendant, après, ce, cette, ces, ceci, cela, semble, quoi, qui, quand, où, comment, quel, lequel, lesquels',
  /**
   * Languages according to ISO 639-1
   */
    "aa" => "Afar",
    "ab" => "Abkhazien",
    "af" => "Afrikaans",
    "am" => "Amharic",
    "ar" => "Arabe",
    "as" => "Assamese",
    "ay" => "Aymara",
    "az" => "Azerbaijani",
    "ba" => "Bashkir",
    "be" => "Biélorusse",
    "bg" => "Bulgarian",
    "bh" => "Bihari",
    "bi" => "Bislama",
    "bn" => "Bengali; Bangla",
    "bo" => "Tibetain",
    "br" => "Breton",
    "ca" => "Catalan",
    "co" => "Corse",
    "cs" => "Tchèque",
    "cy" => "Gallois",
    "da" => "Danois",
    "de" => "Allemand",
    "dz" => "Bhutani",
    "el" => "Grec",
    "en" => "Anglais",
    "eo" => "Espéranto",
    "es" => "Espagnol",
    "et" => "Estonien",
    "eu" => "Basque",
    "fa" => "Persan",
    "fi" => "Finnois",
    "fj" => "Fiji",
    "fo" => "Faeroese",
    "fr" => "Français",
    "fy" => "Frisien",
    "ga" => "Irlandais",
    "gd" => "Scots / Gaélic",
    "gl" => "Galicien",
    "gn" => "Guarani",
    "gu" => "Gujarati",
    "he" => "Hébreu",
    "ha" => "Hausa",
    "hi" => "Hindi",
    "hr" => "Croate",
    "hu" => "Hongrois",
    "hy" => "Arménien",
    "ia" => "Interlingua",
    "id" => "Indonésien",
    "ie" => "Interlingue",
    "ik" => "Inupiak",
    //"in" => "Indonesian",
    "is" => "Icelandic",
    "it" => "Italian",
    "iu" => "Inuktitut",
    "iw" => "Hebrew (obsolète)",
    "ja" => "Japanese",
    "ji" => "Yiddish (obsolète)",
    "jw" => "Javanais",
    "ka" => "Géorgien",
    "kk" => "Kazakh",
    "kl" => "Greenlandic",
    "km" => "Cambodian",
    "kn" => "Kannada",
    "ko" => "Korean",
    "ks" => "Kashmiri",
    "ku" => "Kurdish",
    "ky" => "Kirghiz",
    "la" => "Latin",
    "ln" => "Lingala",
    "lo" => "Laothian",
    "lt" => "Lithuanian",
    "lv" => "Latvian/Letton",
    "mg" => "Malagasy",
    "mi" => "Maori",
    "mk" => "Macédonien",
    "ml" => "Malayalam",
    "mn" => "Mongolien",
    "mo" => "Moldave",
    "mr" => "Marathi",
    "ms" => "Malay",
    "mt" => "Maltese",
    "my" => "Burmese",
    "na" => "Nauru",
    "ne" => "Nepali",
    "nl" => "Dutch",
    "no" => "Norvégien",
    "oc" => "Occitan",
    "om" => "(Afan) Oromo",
    "or" => "Oriya",
    "pa" => "Punjabi",
    "pl" => "Polish",
    "ps" => "Pashto / Pushto",
    "pt" => "Portugais",
    "qu" => "Quechua",
    "rm" => "Rhaeto-Romance",
    "rn" => "Kirundi",
    "ro" => "Romanian",
    "ru" => "Russe",
    "rw" => "Kinyarwanda",
    "sa" => "Sanskrit",
    "sd" => "Sindhi",
    "sg" => "Sangro",
    "sh" => "Serbo-Croate",
    "si" => "Singhalese",
    "sk" => "Slovaque",
    "sl" => "Slovénien",
    "sm" => "Samoan",
    "sn" => "Shona",
    "so" => "Somalien",
    "sq" => "Albanais",
    "sr" => "Serbe",
    "ss" => "Siswati",
    "st" => "Sesotho",
    "su" => "Sundanese",
    "sv" => "Suédois",
    "sw" => "Swahili",
    "ta" => "Tamil",
    "te" => "Tegulu",
    "tg" => "Tajik",
    "th" => "Thai",
    "ti" => "Tigrinya",
    "tk" => "Turkmen",
    "tl" => "Tagalog",
    "tn" => "Setswana",
    "to" => "Tonga",
    "tr" => "Turc",
    "ts" => "Tsonga",
    "tt" => "Tatar",
    "tw" => "Twi",
    "ug" => "Ouïgur",
    "uk" => "Ukrainien",
    "ur" => "Urdu",
    "uz" => "Ouzbek",
    "vi" => "Vietnamien",
    "vo" => "Volapuk",
    "wo" => "Wolof",
    "xh" => "Xhosa",
    //"y" => "Yiddish",
    "yi" => "Yiddish",
    "yo" => "Yoruba",
    "za" => "Zuang",
    "zh" => "Chinois",
    "zu" => "Zoulou",
    /* AJOUTS POUR LA VERSION 1.6.1 */
    'deprecatedfunction' => "Attention: Ce code source utilise une fonction périmée '%s'. Il n'est pas compatible avec cette version de Elgg.",
    'pageownerunavailable' => "Attention: La page de %d n'est pas accessible.",
    'profile:preview' => 'Aperçu',
    'profile:deleteduser' => 'Membre effacé.',
    'profile:explainchangefields' => "Vous pouvez remplacer les champs du profil par les vôtres, en utilisant le formulaire ci-dessous. Ensuite, sélectionnez le type du champ (par exemple : tags, url, text et ainsi de suite). À tout moment vous pouvez réinitialiser le profil à sa configuration d'origine.",
    'river:posted:generic' => "%s a ajouté",
    'groups:searchtitle' => "Rechercher des groupes : %s",
    'group:search:startblurb' => "Groupes qui vérifient le critère : %s",
    'group:search:finishblurb' => "Pour en savoir plus, cliquez ici.",
    'search:go' => "Rechercher",
    'installation:viewpathcache:description' => "Le cache utilisé pour stocker les chemins vers les vues des greffons réduit le temps de chargement de ces derniers.",
    'installation:viewpathcache:label' => "Utiliser le cache de stockage des chemins vers les vues des greffons (recommandé).",
    'welcome:user' => "Bienvenue %s",
    'groups:manycreated' => 'groupes au total',
//
//
/* #########################################################################
MOD : anfh_specific */
    'anfh_specific:accueil' => "ACCUEIL",
    'anfh_specific:discussions' => "DISCUSSIONS",
    'anfh_specific:mood' => "MOOD",
    'anfh_specific:newest_member' => 'Derniers inscrits',
    'anfh_specific:expressyourself' => 'Exprimez vous',
    'anfh_specific:latest' => 'Derniers posts',
    'anfh_specific:latest_discussions' => 'Derni&egrave;res discussions',
    'anfh_specific:photos' => 'Derni&egrave;res photos',
    'anfh_specific:videos' => 'Derni&egrave;res vid&eacute;os',
    'anfh_specific:latest_comments' => 'Derniers commentaires',
    'anfh_specific:add:mood' => 'A quoi pensez-vous ?',
    'anfh_specific:add:article' => 'Ajoutez un article',
    'anfh_specific:add:photo' => 'Ajoutez une photo',
    'anfh_specific:add:video' => 'Ajoutez une vid&eacute;o',
    'anfh_specific:topics' => 'Discussions',
    'anfh_specific:topics:yours' => 'Vos discussions',
    'anfh_specific:topics:all' => 'Toutes les discussions',
    'anfh_specific:video:list' => 'Toutes les vid&eacute;os',
    'anfh_specific:photo:list' => 'Toutes les photos',
    'anfh_specific:add:publish' => 'Publiez',
    'anfh_specific:sitemessages:posted' => 'Posté le ',
    'anfh_specific:sitemessages:add' => 'Modifier le message du site',
    'anfh_specific:sitemessages:announcements' => 'Message du site',
    'anfh_specific:nogroupactivity' => "Aucune activité dans vos groupes ou bien vous n'êtes membre d'aucun groupe",
    'anfh_specific:comments:title' => 'Tous les commentaires',
    'anfh_specific:contents:title' => 'Toutes les contributions',
    //
    'anfh:add:question' => 'Publiez un nouveau contenu',
    'anfh:add:note' => 'Ajoutez un billet dans votre carnet de bord',
    'anfh:news:title' => 'Sur le site',
    'anfh:network:title' => "Au fil du réseau",
    'anfh:recentgroups' => 'Derniers groupes',
    'anfh:members:title' => 'Les membres',
    'anfh:group:activity' => 'Dans mes groupes',
    'anfh:group:members' => 'Les membres de mes groupes',
    'anfh:network:all' => "Toute l'activité",
    'anfh:network:friend' => 'Mes contacts',
    'anfh:notebook:title' => "Rêves d'experts",
    'anfh:telex:title' => 'Telex',
    'anfh:question:all' => 'Voir tous contenus',
    'anfh:question:allanswers' => 'Voir tous les commentaires',
    'anfh:notebook:all' => 'Voir tous les carnets de bord',
    'anfh:telex:all' => 'Voir toutes les brèves',
    'anfh:add:telex' => 'Publiez une brève',
    'anfh:images:all' => 'Voir toutes les photos',
    'anfh:add:images' => 'Publiez une photo',
    'anfh:river:all' => "Voir le fil d'activité",
    'anfh:video:all' => 'Voir toutes les vidéos',
    'anfh:add:video' => 'Publiez une vidéo',
    'anfh:video:title' => 'Vidéos',
    'anfh:search' => 'Rechercher sur le site (par mots clés)',
    'anfh:home' => "Revenir à l'accueil",
    'anfh:user:welcome' => 'Bienvenue',
    'anfh:explorer' => 'Explorer',
    'anfh:publier' => 'Publier',
    'anfh:groupes' => 'Mes groupes',
    'anfh:compte' => 'Mon compte',
    'anfh:bonus' => 'Bonus',
    'anfh:contacts' => 'Mes contacts',
    'anfh:recentmembers' => 'Nouveaux membres',
    'anfh:membersonline' => 'En ligne',
    'anfh:images:title' => 'Dans les albums photos',
    'anfh:groups:all' => 'Voir la liste des groupes',
    'anfh:events' => 'Événements du réseau',
    'anfh:ads' => 'Annonces',
    'anfh:featuredgroups' => 'Groupes à la Une',
    'anfh:recommandations' => 'Dernières recommandations',
    'anfh_specific:site:rfc:title' => 'Plateforme collaborative',
//
//
/* #########################################################################
MOD : autocomplete */
//
//
/* #########################################################################
MOD : autosubscribegroup
Menu items and titles */
    'autosubscribe' => 'Inscription automatique à un groupe',
    'autosubscribe:list' => "Liste des identifiants des groupes séparés par des virgules",
//
//
/* #########################################################################
MOD : avatar wall
*/
  // main titles
  'avatar_wall' => "Mur d'avatars",
  'avatar_wall:title' => "Mur d'avatars",
  'avatar_wall:shorttitle' => "Mur d'avatars",
  'avatar_wall:description' => "Le mur d'avatars affiche toutes les photos de profil des utilisateurs sur une seule page",
  'avatar_wall:settings:onlywithavatar' => "Ne montrer que les membres avec un avatar personnalisé",
  'avatar_wall:settings:tiny' => "Très petit",
  'avatar_wall:settings:small' => "Petit",
  'avatar_wall:settings:iconsize' => "Choisir la taille des icônes",
  'avatar_wall:settings:maxicons' => "Choisir le nombre maximal d'icônes sur le mur",
//
//
/* #########################################################################
MOD : blog
Menu items and titles */
    'blog' => "Blog",
    'blogs' => "Blogs",
    'blog:user' => "Le blog de %s",
    'blog:user:friends' => "Le blog des contacts de %s",
    'blog:your' => "Votre blog",
    'blog:posttitle' => "Le blog de %s: %s",
    'blog:friends' => "Blogs des contacts",
    'blog:yourfriends' => "Les blogs les plus récents de vos contacts",
    'blog:everyone' => "Tous les articles du site",
    'blog:newpost' => "Nouvel article de blog",
    'blog:via' => "via le blog",
    'blog:read' => "Lire le blog",
    'blog:addpost' => "Ecrire un article de blog",
    'blog:editpost' => "Editer un article de blog",
    'blog:text' => "Contenu de l'article",
    'blog:strapline' => "%s",
    'item:object:blog' => 'Articles de blog',
    'blog:never' => 'jamais',
    'blog:preview' => 'Aperçu',
    'blog:draft:save' => 'Enregistrer le brouillon',
    'blog:draft:saved' => 'Votre dernier brouillon',
    'blog:comments:allow' => 'Autoriser les commentaires',
    'blog:preview:description' => 'Cette page est un <b>aperçu non enregistré</b> de votre article de blog.',
    'blog:preview:description:link' => "Cliquez ici pour continuer l'édition et enregistrer votre article.",
  /* Blog river */
    //generic terms to use
    'blog:river:created' => "%s a écrit :",
    'blog:river:create' => "un article :",
    'blog:river:updated' => "%s a mis à jour",
    'blog:river:update' => "l'article",
    'blog:river:posted' => "%s a ajouté",
    'blog:river:annotate' => "un commentaire sur",
    //these get inserted into the river links to take the user to the entity
  /* Status messages */
    'blog:posted' => "Votre article de blog a bien été ajouté.",
    'blog:deleted' => "Votre article de blog a bien été supprimé.",
  /* Error messages */
    'blog:error' => "Une erreur s'est produite. Veuillez réessayer.",
    'blog:save:failure' => "Votre article n'a pas pu être enregistré, merci de réessayer.",
    'blog:blank' => "Vous devez compléter le titre et le corps de l'article avant de pouvoir publier.",
    'blog:notfound:title' => "L'article que vous recherchez n'a pas été trouvé",
    'blog:notfound' => "<br /><p>L'article que vous recherchez n'est pas disponible ; il peut y avoir plusieurs raisons à cela :<ul><li>soit cet article n'est accessible qu'aux membres du site (dans ce cas veuillez vous connecter pour y avoir accès)</li><li>soit il a été supprimé, ou vous n'avez pas les droits d'accès suffisant pour y accéder (veuillez contacter l'auteur si vous pensez que vous devriez y avoir accès, ou vérifiez que vous faites partie du groupe dans lequel il a été publié le cas échéant)</li><li>soit il y a eu une erreur dans l'adresse de cette page (typiquement une virgule en trop, ou une adresse coupée)</li></ul></p>",
    'blog:notdeleted' => "Cet article de blog n'a pu être supprimé.",
//
//
/* ###########################################################
MOD : blogextended
Blog types translations */
'blog:type'=>"Type de contenu",
'blog:type:other'=>"Autre",
'blog:type:news'=>"Actualités",
'blog:type:goodpractice'=>"Bonnes pratiques",
'blog:type:event'=>"Evénement",
/* Blog widget */
'blog:widget:title'=>"Blogs",
'blog:widget:description'=>"Ce widget affiche le nombre d'articles de blog spécifié",
'blog:widget:default_view'=>"Vue par défaut du widget",
'blog:widget:default'=>"Normal",
'blog:widget:compact'=>"Compact",
'contents:empty'=>"Aucun contenu enregistré pour le moment",
'blog:extratypes:enable'=> "Activer le support du type Blog ?",
'blog:group:contents'=> "Activer la publication d'articles dans les groupes ?",
'blog:group:iconoverwrite'=>"Activer le remplacement de l'icône par celle du groupe lorsque le blog est associé à un groupe ?",
// Group related translations
'group:contents'=>"Contenu",
'group:contents:empty'=>"Aucun article de blog",
//
'content:owner'=>"Assigner à",
'my:profile'=>"Mon profil",
'publish:for'=>"publié dans %s",
'blog:groupblog' => "Derniers articles du blog",
//
//
/* #########################################################################
MOD : bloglistsummary */
    'bloglistsummary:more' => "(lire la suite)",
//
//
/* #########################################################################
MOD : bookmarks */
    'bookmarks' => "Marque-pages",
    'bookmarks:add' => "Ajouter une page web en marque-page",
    'bookmarks:read' => "Marque-pages",
    'bookmarks:friends' => "Marque-pages des contacts",
    'bookmarks:everyone' => "Tous les marque-pages du site",
    'bookmarks:this' => "Mettre en marque-page",
    'bookmarks:bookmarklet' => "Récupérer le 'bookmarklet'",
    'bookmarks:inbox' => "Boîte de réception des marque-pages",
    'bookmarks:more' => "En savoir plus",
    'bookmarks:shareditem' => "Elément mis en marque-page",
    'bookmarks:with' => "Partager avec",
    'bookmarks:new' => "Un nouvel élément mis en marque-page",
    'bookmarks:via' => "via les marque-pages",
    'bookmarks:address' => "Adresse (URL) de la page à ajouter à vos marque-pages",
    'bookmarks:delete:confirm' => "Etes-vous sûr(e) de vouloir supprimer ce marque-page ?",
    'bookmarks:numbertodisplay' => 'Nombre de marque-pages à afficher',
    'bookmarks:shared' => "Mis en marque-page",
    'bookmarks:visit' => "Accéder à la ressource",
    'bookmarks:recent' => "Marque-pages récents",
    'bookmarks:river:created' => '%s a mis en marque-page',
    'bookmarks:river:annotate' => 'un commentaire sur le marque-page',
    'bookmarks:river:item' => 'un élément',
    'item:object:bookmarks' => 'Marque-pages',
  /* More text */
      'bookmarks:widget:description' =>
              "Ce widget est conçu pour votre tableau de bord, et vous présentera les éléments les plus récents de votre boîte de réception des marque-pages.",
    'bookmarks:bookmarklet:description' =>
        "Le 'bookmarklet' des marque-pages vous permet de partager toute ressource que vous trouvez sur le web avec vos contacts, ou à la conserver pour vous-même. Pour l'utiliser, faites glisser cet icône dans la barre de liens de votre navigateur:",
        'bookmarks:bookmarklet:descriptionie' =>
        "Si vous utilisez Internet Explorer, faites un clic droit sur l'icône du bookmarklet, sélectionnez 'ajouter aux favoris', puis choisissez la barre de liens.",
    'bookmarks:bookmarklet:description:conclusion' =>
        "Vous pouvez enregistrer toute page que vous visitez en cliquant dessus à tout moment.",
  /* Status messages */
    'bookmarks:save:success' => "Votre élément a bien été mis en marque-page.",
    'bookmarks:delete:success' => "Votre marque-page a bien été supprimé.",
  /* Error messages */
    'bookmarks:save:failed' => "Votre élément n'a pu être correctement mis en marque-page. Merci de réessayer.",
    'bookmarks:delete:failed' => "Votre marque-page n'a pu être supprimé. Merci de réessayer.",
    
    /* Plateforme collaborative */
    'bookmarks:container' => "Publier dans ",
//
//
/* #########################################################################
MOD : canvas_menu */
    'canvasmenu:members' => "Membres",
    'canvasmenu:photos' => "Photos",
    'canvasmenu:groups' => "Groupes",
    'canvasmenu:videos' => "Vidéos",
    'canvasmenu:current' => "c'est pour le moment :",
    'canvasmenu:andmore' => "et plus encore...",
//
//
/* #########################################################################
MOD : categories */
  'categories' => 'Catégories',
  'categories:settings' => 'Catégories du site',
  'categories:explanation' => "Pour définir quelques catégories pré-déterminées qui seront utilisées à travers l'ensemble du site, veuillez les saisir ci-dessous, en les séparant par des virgules. Les outils compatibles pourront alors les afficher quand les utilisateurs créent ou éditent des contenus.",
  'categories:save:success' => 'Les catégories du site ont été correctement enregistrées.',
//
//
/* #########################################################################
MOD : crontrigger */
//
//
/* #########################################################################
MOD : customindex */
    'custom:bookmarks' => "Marque-pages les plus récents",
    'custom:groups' => "Groupes les plus récents",
    'custom:files' => "Fichiers les plus récents",
    'custom:blogs' => "Articles de blog les plus récents",
    'custom:members' => "Nouveaux membres",
    'custom:nofiles' => "Il n'y a pas encore de fichier",
    'custom:nogroups' => "Il n'y a pas encore de groupe",
    'custom:latestcontent' => "Dernières publications",	
//
//
/* #########################################################################
MOD : defaultwidgets */
/* Nice name for the entity (shown in admin panel) */
'item:object:moddefaultwidgets' => 'Paramètres des widgets par défaut',
/* Menu items */
'defaultwidgets:menu:profile' => 'Widgets du profil',
'defaultwidgets:menu:dashboard' => 'Widgets du tableau de bord',
'defaultwidgets:admin:error' => "Erreur: vous n'êtes pas identifié comme administrateur",
'defaultwidgets:admin:notfound' => 'Erreur: page non trouvée',
'defaultwidgets:admin:loginfailure' => "Attention: vous n'êtes pas identifié comme administrateur",
'defaultwidgets:update:success' => 'Vos paramètres des widgets ont bien été enregistrés',
'defaultwidgets:update:failed' => "Erreur: les paramètres n'ont pu être enregistrés",
'defaultwidgets:update:noparams' => 'Erreur: paramètres du formulaire incorrects',
'defaultwidgets:profile:title' => 'Définir les widgets par défaut pour les profils des nouveaux utilisateurs',
'defaultwidgets:dashboard:title' => 'Définir les widgets par défaut pour les tableaux de bord des nouveaux utilisateurs',
//
//
/* #########################################################################
MOD : diagnostics */
    'diagnostics' => 'Diagnostics du système',
    'diagnostics:description' => "Le rapport de diagnostic suivant est utile pour diagnostiquer tout problème avec Elgg, et devrait être inclus dans tout rapport d'erreur que vous rapportez.",
    'diagnostics:download' => 'Télécharger .txt',
    'diagnostics:header' => "========================================================================
Rapport de diagnostic d'Elgg
Généré %s par %s
========================================================================
    
",
    'diagnostics:report:basic' => "
Elgg release %s, version %s

------------------------------------------------------------------------",
    'diagnostics:report:php' => "
Informations PHP :
%s
------------------------------------------------------------------------",
    'diagnostics:report:plugins' => "
Plugins installés et détails :

%s
------------------------------------------------------------------------",
    'diagnostics:report:md5' => "
Fichiers installés et signatures (checksums) :

%s
------------------------------------------------------------------------",
    'diagnostics:report:globals' => "
Varaibles globales :

%s
------------------------------------------------------------------------",
//
//
/* #########################################################################
MOD : draggable_widgets */
    'draggable_widgets:add' => "Ajouter un nouveau widget",
    'draggable_widgets:delete' => "Etes-vous sûr de vouloir supprimer ce widget ?",
//
//
/* #########################################################################
MOD : embed */
  'media:insert' => 'Embarquer / télécharger un média',
  'embed:instructions' => "Cliquez sur le fichier de votre choix pour l'embarquer dans votre contenu.",
  'embed:media' => 'Fichier embarqué',
  'upload:media' => 'Télécharger un fichier',
  'embed:file:required' => "Aucun service de téléchargement de fichier n'a été trouvé. L'administrateur du site pourrait avoir besoin d'installer le plugin de gestion des fichiers.",
//
//
/* #########################################################################
MOD : embedvideo */
  'embedvideo:widget' => 'Vidéo',
  'embedvideo:url' => 'URL de la vidéo',
  'embedvideo:title' => 'Titre',
  'embedvideo:comment' => 'Commentaire',
  'embedvideo:description' => 'Ajouter une vidéo depuis des sites comme Youtube sur votre profil',
  'embedvideo:width' => 'Largeur de la vidéo',
  'embedvideo:sites' => 'youtube, google, vimeo, metacafe, veoh, dailymotion, blip.tv',
  'embedvideo:tags_instruct' => ' (les tags html sont autorisés)',
  'embedvideo:novideo' => 'Aucune vidéo définie',
  'embedvideo:unrecognized' => 'Site de vidéo non reconnu',
  'embedvideo:parseerror' => "Impossible de traiter l'URL %s",
  'embedvideo:river:updated' => "%s a publié une vidéo sur son profil",
//
//
/* #########################################################################
MOD : eventcalendar */
'item:object:event_calendar' => "Agenda",
'event_calendar:new_event' => "Nouvel événement",
'event_calendar:no_such_event_edit_error' => "Erreur: Cet événement n'existe pas ou vous n'avez pas l'autorisation de le modifier.",
'event_calendar:add_event_title' => "Ajouter un événement",
'event_calendar:manage_event_title' => "Modifier un événement",
'event_calendar:manage_event_description' => "Veuillez saisir les détails de votre événement ci-dessous. "
  ."Le titre, le lieu et la date de départ doivent être précisés. "
  ."Vous pouvez cliquer sur les icônes du calendrier pour définir les dates de début et de fin.",
'event_calendar:title_label' => "Titre",
'event_calendar:title_description' => "Obligatoire. En quelques mots (1 à 4)",
'event_calendar:brief_description_label' => "Brève description",
'event_calendar:brief_description_description' => "Optionnel. Une courte phrase.",
'event_calendar:venue_label' => "Lieu",
'event_calendar:venue_description' => "Obligatoire. Où se tiendra cet événement ?",
'event_calendar:start_date_label' => "Date de début",
'event_calendar:start_date_description'	=> "Obligatoire. Quand débute cet événement ?",
'event_calendar:end_date_label' => "Date de fin",
'event_calendar:end_date_description'	=> "Optionnel. Quand se termine cet événement ? "
  ."La date de début sera utilisée comme date de fin si vous ne précisez rien ici.",
'event_calendar:fees_label' => "Tarif",
'event_calendar:fees_description'	=> "Facultatif. Tarif de l'événement.",
'event_calendar:contact_label' => "Contact",
'event_calendar:contact_description'	=> "Facultatif. La personne à contacter pour plus d'informations, "
    ."de préférence avec un numéro de téléphone ou une adresse mail.",
'event_calendar:organiser_label' => "Organisateur",
'event_calendar:organiser_description'	=> "Facultatif. La personne ou la structure organisatrice de cet événement.",
'event_calendar:event_tags_label' => "Tags",
'event_calendar:event_tags_description'	=> "Facultatif. Une liste de mot-clefs pertinents pour cet événement, séparés par des virgules.",
'event_calendar:long_description_label' => "Description détaillée",
'event_calendar:long_description_description'	=> "Facultatif. Un paragraphe ou plus en fonction des besoins.",
'event_calendar:manage_event_response' => "Votre événement a bien été enregistré.",
'event_calendar:add_event_response' => "Votre événement a bien été ajouté.",
'event_calendar:manage_event_error' => "Erreur: Votre événement n'a pas pu être enregistré. "
    ."Veuillez vérifier que vous avez bien complété les champs obligatoires.",
'event_calendar:show_events_title' => "Agenda",
'event_calendar:day_label' => "Jour",
'event_calendar:week_label' => "Semaine",
'event_calendar:month_label' => "Mois",
'event_calendar:year_label' => "Année",
'event_calendar:ofday_label' => "du jour",
'event_calendar:ofweek_label' => "de la semaine",
'event_calendar:ofmonth_label' => "du mois",
'event_calendar:ofyear_label' => "de l'année",
'event_calendar:group' => "Agenda du groupe",
'event_calendar:new' => "Ajouter un événement",
'event_calendar:submit' => "OK",
'event_calendar:cancel' => "Annuler",
'event_calendar:widget_title' => "Agenda",
'event_calendar:widget:description' => "Afficher vos événements.",
'event_calendar:num_display' => "Nombre d'événements à afficher",
'event_calendar:groupprofile' => "Agenda du groupe",
'event_calendar:view_calendar' => "voir l'agenda",
'event_calendar:when_label' => "Quand",
'event_calendar:site_wide_link' => "Voir tous les événements",
'event_calendar:view_link' => "Voir cet événement",
'event_calendar:edit_link' => "Modifier cet événement",
'event_calendar:delete_link' => "Supprimer cet événement",
'event_calendar:delete_confirm_title' => "Veuillez confirmer la suppression de l'événement",
'event_calendar:delete_confirm_description' => "Etes-vous sûr(e) de vouloir supprimer cet événement (\"%s\") ? Cette action ne peut être révoquée.",
'event_calendar:delete_response' => "L'événement a bien été supprimé.",
'event_calendar:error_delete' => "Cet événement n'existe pas ou vous n'avez pas l'autorisation de le supprimer.",
'event_calendar:delete_cancel_response' => "Suppression de l'événement annulée.",
'event_calendar:add_to_my_calendar' => "M'inscrire à cet événement",
'event_calendar:remove_from_my_calendar' => "Me désinscrire de cet événement",
'event_calendar:add_to_my_calendar_response' => "Vous êtes maintenant inscrit à cet événement, et apparaissez dans la liste des participants.",
'event_calendar:remove_from_my_calendar_response' => "Vous vous êtes désinscrit de cet événement et n'apparaissez plus dans la liste des participants.",
'event_calendar:users_for_event_title' => "Liste des participants à l'événement \"%s\"'",
'event_calendar:personal_event_calendars_link' => "Liste des participants (%s)",
'event_calendar:settings:group_profile_display:title' => "Affichage du calendrier de groupe sur le profil <!--Group calendar profile display//-->(si les agendas des groupes sont activés)",
'event_calendar:settings:group_profile_display_option:left' => "colonne de gauche",
'event_calendar:settings:group_profile_display_option:right' => "colonne de droite",
'event_calendar:settings:group_profile_display_option:none' => "aucun",
'event_calendar:settings:autopersonal:title' => "Inscrire automatiquement l'auteur à l'événement qu'il crée.",
'event_calendar:settings:yes' => "oui",
'event_calendar:settings:no' => "non",
'event_calendar:settings:site_calendar:title' => "Agenda du site",
'event_calendar:settings:site_calendar:admin' => "oui, seuls les administrateurs peuvent ajouter des événements",
'event_calendar:settings:site_calendar:loggedin' => "oui, tout membre peut ajouter un événement",
'event_calendar:settings:group_calendar:title' => "Agendas des groupes",
'event_calendar:settings:group_calendar:admin' => "oui, seuls les administrateurs et les propriétaires de groupes peuvent ajouter des événements",
'event_calendar:settings:group_calendar:members' => "oui, tout membre d'un groupe peut ajouter un événement",
'event_calendar:settings:group_default:title' => "Tout nouveau groupe dispose par défaut d'un agenda de groupe (si les agendas de groupe sont activés)",
'event_calendar:settings:group_default:no' => "non (mais les administrateurs ou les propriétaires de groupes peuvent activer l'agenda s'ils le désirent)",
'event_calendar:settings:group_default:yes' => "oui (mais les administrateurs ou les propriétaires de groupes peuvent désactiver l'agenda s'ils le désirent)",
'event_calendar:enable_event_calendar' => "Activer l'agenda du groupe",
'event_calendar:no_events_found' => "Aucun événement trouvé.",
/* Event calendar river */
//generic terms to use
  'event_calendar:river:created' => "%s a annoncé",
  'event_calendar:river:updated' => "%s a mis à jour",
  'event_calendar:river:annotated1' => "%s a ajouté",
'event_calendar:river:annotated2' => "dans son agenda.",
//these get inserted into the river links to take the user to the entity
  'event_calendar:river:create' => "un événement",
  'event_calendar:river:the_event' => "un événement",
  'event_calendar:agenda:column:time' => "Horaires",
  'event_calendar:agenda:column:session' => "Intitulé",
  'event_calendar:agenda:column:venue' => "Lieu",
  'event_calendar:mine' => "Mon agenda",
  'event_calendar:addnotify:subject' => "Inscription à \"%s\"",
  'event_calendar:addnotify:message' => "Bonjour,\n\n%s (profil : %s ) s'est inscrit à l'événement %s\n\nVous pouvez consulter la liste des participants sur la page %s",
  'event_calendar:removenotify:subject' => "Désinscription de \"%s\"",
  'event_calendar:removenotify:message' => "Bonjour,\n\n%s (profil : %s ) s'est désinscrit de l'événement %s\n\nVous pouvez consulter la liste des participants sur la page %s",

//
//
/* #########################################################################
MOD : externalpages
Menu items and titles
*/
    'expages' => "Pages externes",
    'expages:frontpage' => "Page de garde",
    'expages:about' => "A propos",
    'expages:terms' => "Mentions légales",
    'expages:privacy' => "Informations personnelles",
    'expages:analytics' => "Statistiques",
    'expages:contact' => "Contact",
    'expages:nopreview' => "Aucun aperçu disponible pour le moment",
    'expages:preview' => "Aperçu",
    'expages:notset' => "Cette page n'a pas été définie pour le moment.",
    'expages:lefthand' => "Le panneau d'information latéral gauche",
    'expages:righthand' => "Le panneau d'information latéral droit",
    'expages:addcontent' => "Vous pouvez ajouter du contenu ici via vos outils d'administration. Regardez les pages externes dans la partie administration.",
    'item:object:front' => 'Eléments de la page de garde',
  /* Status messages */
    'expages:posted' => "Votre message de page a bien été posté.",
    'expages:deleted' => "Votre message de page a bien été supprimé.",
  /* Error messages */
    'expages:deleteerror' => "Un problème est survenu lors de la suppression de l'ancienne page",
    'expages:error' => "Une erreur est survenue, merci de réessayer, ou de contacter l'administrateur si le problème persite",
//
//
/* #########################################################################
MOD : file */
    'file' => "Fichiers",
    'files' => "Fichiers",
    'file:yours' => "Vos fichiers",
    'file:yours:friends' => "Les fichiers de vos contacts",
    'file:user' => "Fichiers de %s",
    'file:friends' => "Fichiers des amis de %s",
    'file:all' => "Tous les fichiers du site",
    'file:edit' => "Editer le fichier",
    'file:more' => "Plus de fichiers",
    'file:list' => "vue liste",
    'file:group' => "Fichiers du groupe",
    'file:gallery' => "vue galerie",
    'file:gallery_list' => "Vue 'liste' ou 'galerie'",
    'file:num_files' => "Nombre de fichiers à afficher",
    'file:user:gallery'=>"Voir la galerie",
    'file:via' => 'via les fichiers',
    'file:upload' => "Envoyer un fichier",
    'file:newupload' => 'Envoyer un nouveau fichier',
    'file:file' => "Fichier",
    'file:title' => "Titre",
    'file:desc' => "Description",
    'file:tags' => "Tags",
    'file:types' => "Type de fichiers téléchargés",
    'file:type:all' => "Tous les fichiers",
    'file:type:video' => "Vidéos",
    'file:type:document' => "Documents",
    'file:type:audio' => "Audio",
    'file:type:image' => "Images",
    'file:type:general' => "Autres fichiers",
    'file:user:type:video' => "Les vidéos de %s",
    'file:user:type:document' => "Les documents de %s",
    'file:user:type:audio' => "Les fichiers audio de %s",
    'file:user:type:image' => "Les images de %s",
    'file:user:type:general' => "Les fichiers de %s",
    'file:friends:type:video' => "Les vidéos de vos contacts",
    'file:friends:type:document' => "Les documents de vos contacts",
    'file:friends:type:audio' => "Les enregistrements audio de vos contacts",
    'file:friends:type:image' => "Les images de vos contacts",
    'file:friends:type:general' => "Les fichiers divers de vos contacts",
    'file:widget' => "Fichiers",
    'file:widget:description' => "Galerie de vos derniers fichiers",
    'file:download' => "Télécharger ce fichier",
    'file:delete:confirm' => "Etes-vous sûr(e) de vouloir supprimer ce fichier ?",
    'file:tagcloud' => "Nuage de tags",
    'file:display:number' => "Nombre de fichiers à afficher",
    'file:river:created' => "%s a mis en ligne",
    'file:river:item' => "un fichier",
    'file:river:annotate' => "un commentaire sur ce fichier",
    'item:object:file' => 'Fichiers',
    /* Embed media */
      'file:embed' => "Insérer un fichier media",
      'file:embedall' => "Tout",
  /* Status messages */
    'file:saved' => "Votre fichier a bien été enregistré.",
    'file:deleted' => "Votre fichier a bien été supprimé.",
  /* Error messages */
    'file:none' => "Aucun fichier pour le moment.",
    'file:uploadfailed' => "Désolé, votre fichier n'a pas pu être enregistré.",
    'file:downloadfailed' => "Désolé, ce fichier n'est pas disponible.",
    'file:deletefailed' => "Votre fichier n'a pas pu être effacé.",
//
//
/* #########################################################################
MOD : friendrequest */
'friendrequest' => "Demande de mise en contact",
'friendrequests' => "Demande(s) de mise en contact",
'friendrequests:title' => "Les demandes de mise en contact de %s",
'newfriendrequests' => "Nouvelles(s) demande(s) de mise en contact !",
'friendrequest:add:exists' => "Vous avez déjà demandé à être le contact de %s.",
'friendrequest:add:failure' => "Une erreur est survenue, merci de réessayer.",
'friendrequest:add:successful' => "Vous avez demandé à être le contact de %s. Il/Elle devra valider votre demande avant d'apparaître dans votre liste de contacts.",
'friendrequest:newfriend:subject' => "%s souhaite devenir votre contact&nbsp;!",
'friendrequest:newfriend:body' => "%s souhaite devenir votre contact! Mais il/elle attend que vous approuviez sa demande... Connectez-vous au réseau afin d'approuver sa demande&nbsp;!

Vous pouvez voir la liste des demandes de mise en contact à cette adresse (attention : vous devez d'abord vous connecter au site pour que le lien fonctionne)&nbsp;:

%s

(Vous ne pouvez pas répondre à cet email.)",

'friendrequest:successful' => "Vous êtes maintenant le contact de %s&nbsp;!",
'friendrequest:remove:success' => "Vous avez refusé la demande de mise en contact.",
'friendrequest:remove:fail' => "Impossible de supprimer la demande de mise en contact.",
'friendrequest:approvefail' => "Une erreur est survenue lors de l'ajout de %s comme contact&nbsp;!",
//
//
/* #########################################################################
MOD : friend_request */
  'friend_request' => "Demande de mise en relation",
  'friend_request:menu' => "Demandes de mise en relation",
  'friend_request:title' => "Demandes de mise en relation",
  'friend_request:new' => "Nouvelle demande de mise en relation&nbsp;!",
  'friend_request:newfriend:subject' => "%s souhaite devenir votre contact&nbsp;!",
  'friend_request:newfriend:body' => "%s souhaite devenir votre contact! Mais il/elle attend que vous approuviez sa demande... Connectez-vous au réseau afin d'approuver sa demande&nbsp;!

Vous pouvez voir la liste des demandes de mise en relation à cette adresse (attention : vous devez d'abord vous connecter au site pour que le lien fonctionne)&nbsp;:	%s


Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",
  // Actions
  // Add request
  'friend_request:add:failure' => "Désolé, votre demande n'a pas pu être exécutée. Veuillez réessayer plus tard.",
  'friend_request:add:successful' => "Vous avez demandé à être en relation avec %s. Cette personne devra accepter votre demande avant qu'elle n'apparaisse dans votre liste de contacts.",
  'friend_request:add:exists' => "Vous avez déjà fait une demande de mise en relation à %s.",
  // Approve request
  'friend_request:approve' => "Accepter",
  'friend_request:approve:successful' => "%s est maitenant votre contact",
  'friend_request:approve:fail' => "Erreur lors de la mise en relation avec %s, veuillez réessayer plus tard",
  // Decline request
  'friend_request:decline' => "Décliner",
  'friend_request:decline:subject' => "%s a décliné votre demande de mise en relation",
  'friend_request:decline:message' => "%s,

%s a décliné votre demande de mise en contact.",
  'friend_request:decline:success' => "Demande de mise en relation refusée",
  'friend_request:decline:fail' => "Erreur lors du refus de la demande de mise en relation, veuillez réessayer plus tard",
  // Revoke request
  'friend_request:revoke' => "Annuler",
  'friend_request:revoke:success' => "Demande de mise en relation annulée",
  'friend_request:revoke:fail' => "Erreur lors de l'annulation de la demande de mise en relation, veuillez réessayer plus tard",
  // Views
  // Received
  'friend_request:received:title' => "Demandes reçues",
  'friend_request:received:none' => "Aucune demande en attente",
  // Sent
  'friend_request:sent:title' => "Demandes envoyées",
  'friend_request:sent:none' => "Aucune demande en attente",
//
//
/* #########################################################################
MOD : friends */
    'friends:widget:description' => "Affiche vos contacts sous forme de vignettes. Vous pouvez choisir le nombre de contacts qui apparaissent ainsi que les dimensions des vignettes.",
//
//
/* #########################################################################
MOD : garbagecollector */
    'garbagecollector:period' => 'A quelle fréquence souhaitez-vous faire tourner le ramasse-miettes (garbage collector) ?',
    'garbagecollector:weekly' => 'Une fois par semaine',
    'garbagecollector:monthly' => 'Une fois par mois',
    'garbagecollector:yearly' => 'Une fois par an',
    'garbagecollector' => "GARBAGE COLLECTOR\n",
    'garbagecollector:done' => "TERMINE\n",
    'garbagecollector:optimize' => "Optimisation en cours %s ",
    'garbagecollector:error' => "ERREUR",
    'garbagecollector:ok' => "OK",
    'garbagecollector:gc:metastrings' => 'Nettoyage des chaînes meta (metastrings) non liées: ',
//
//
/* #########################################################################
MOD : group_admin_transfer */
  'group_admin_transfer:transfer' => "Transférer la gestion de ce groupe à&nbsp;",
  'group_admin_transfer:transfer:nofriends' => "Lorsque vous aurez ajouté des contacts, vous aurez la possibilité de leur transférer la gestion de ce groupe.",
  'group_admin_transfer:transfer_submit' => "Transférer le groupe",
  'group_admin_transfer:confirm' => 'ATTENTION : ce processus est irréversible !  Veuillez vérifier que votre contact est au courant de ce transfert !   Confirmez-vous le transfert de ce groupe à',
  'group_admin_transfer:transfer:error' => "L'erreur suivante s'est produite",
  'group_admin_transfer:transfer:error:notowner' => "Le membre actuellement connecté n'est pas gestionnaire de ce groupe",
  'group_admin_transfer:transfer:error:owner' => "Le nouveau propriétaire est identique à l'ancien",
  'group_admin_transfer:transfer:error:input' => "Saisie invalide",
  'group_admin_transfer:transfer:success' => "Le transfert de la gestion du groupe à %s s'est bien déroulé",
  // admin settings
  'group_admin_transfer:admin:settings:transferrights' => "Qui peut transférer la gestion d'un groupe ?",
  'group_admin_transfer:admin:settings:transferrights:option:all' => "Tous les Administrateurs (site et groupes)",
  'group_admin_transfer:admin:settings:transferrights:option:admin_only' => "Seulement les Administrateurs du site",
//
//
/* #########################################################################
MOD : groupextended */
'groups:group_type'=>"Type de groupe",
'groupextended:type:network'=>"Réseau",
'groupextended:type:organization'=>"Organisation",
'groupextended:type:group'=>"Groupe",
'networks:all'=>"Tous les réseaux et les groupes",
'organizations:all'=>"Toutes les Organisations",
'groupextended:members:admin' => "Gestion des membres",
'groupextended:remove' => "Retirer du groupe",
'groupextended:left'=> "%s' a quitté '%s'",
'groupextended:cantleave'=> "'%s' ne peut pas quitter '%s'",
'groupextended:group:cantjoin'=> "Un groupe ne peut pas faire de demande d'adhésion à un autre groupe !",
'groupextended:invitegroups'=>"Permettre aux groupes d'être membres d'un groupe ?",
'groupextended:squareicon'=>"Retailler l'icône du groupe en carré ?",
'groupextended:invite:groups'=>"Inviter des groupes",
'groupextended:invite:subject' => "%s a été invité à rejoindre %s!",
'groupextended:invite:body' => "Bonjour %s,

Votre groupe '%s' a été invité à rejoindre le groupe '%s', veuillez cliquer ci-dessous pour accepter :

%s",
//
//
/* #########################################################################
MOD : groups */
    'groups' => "Groupes",
    'groups:owned' => "Les groupes que vous avez créés",
    'groups:yours' => "Les groupes dont vous faites partie",
    'groups:user' => "Les groupes de %s",
    'groups:all' => "Tous les groupes",
    'groups:new' => "Créer un nouveau groupe",
    'groups:edit' => "Modifier le groupe",
    'groups:delete' => 'Supprimer le groupe',
    'groups:membershiprequests' => "Gérer les demandes d'adhésion",
    'groups:makefeatured' => 'Mettre en Une',
    'groups:makeunfeatured' => 'Retirer de la Une',
    'groups:newest' => 'Tous les groupes',
    'groups:popular' => 'Populaires',
    'group:topic' => "Sujet",
    'groups:icon' => "Icône du groupe (rien = inchangé)",
    'groups:name' => 'Nom du groupe',
    'groups:username' => "Nom court du goupe (s'affichera dans l'URL : en caractères alphanumériques)",
    'groups:description' => 'Description',
    'groups:briefdescription' => 'Brève description',
    'groups:interests' => 'Thématiques (tags)',
    'groups:website' => 'Site web',
    'groups:members' => 'Membres du groupe',
    'groups:groupmembers' => 'Membres du groupe',
    'groups:membership' => "Type d'adhésion au groupe",
    'groups:access' => "Permissions d'accès",
    'groups:owner' => "Responsable",
    'groups:widget:num_display' => 'Nombre de groupes à afficher',
    'groups:widget:membership' => 'Mes groupes',
    'groups:widgets:description' => 'Afficher les groupes dont vous êtes membre dans votre profil',
    'groups:noaccess' => "Vous n'avez pas accès à ce groupe",
    'groups:cantedit' => 'Vous ne pouvez pas modifier ce groupe',
    'groups:saved' => 'Groupe enregistré',
    'groups:featured' => 'A la Une', // Ou : Les groupes à la Une
    'groups:featuredon' => 'Vous avez mis ce groupe à la une.',
    'groups:unfeature' => "Ce groupe n'est plus à la une",
    'groups:joinrequest' => 'Demander une adhésion au groupe',
    'groups:join' => 'Rejoindre le groupe',
    'groups:leave' => 'Quitter le groupe',
    'groups:invite' => 'Inviter des contacts',
    'groups:inviteto' => "Inviter des contacts au groupe '%s'",
    'groups:nofriends' => "Vous n'avez plus de contacts à inviter à ce groupe.",
    'groups:viagroups' => "Via les groupes",
    'groups:group' => "Groupe",
    'groups:notfound' => "Le groupe n'a pas été trouvé",
    'groups:notfound:details' => "Le groupe que vous recherchez n'existe pas, ou alors vous n'avez pas la permission d'y accéder",
    'groups:requests:none' => "Aucune demande en attente pour rejoindre ce groupe.",
    'item:object:groupforumtopic' => "Sujets de discussion",
    'groupforumtopic:new' => "Une nouvelle discussion a été publiée",
    'groups:count' => "groupes créés",
    'groups:open' => "groupe en accès libre",
    'groups:closed' => "groupe en accès restreint",
    'groups:member' => "membres",
    'groups:searchtag' => "Rechercher un groupe",
    /* Access */
    'groups:access:private' => 'Restreint - Les membres doivent être invités ou leur candidature acceptée',
    'groups:access:public' => "Accès libre - Tout membre du site peut rejoindre le groupe librement",
    'groups:closedgroup' => 'Ce groupe est en accès restreint. Pour le rejoindre, cliquez sur le lien "Demander une adhésion au groupe".',
    /* Group tools */
    'groups:enablepages' => 'Activer les Wikis',
    'groups:enableforum' => 'Activer le Forum',
    'groups:enablefiles' => 'Activer les Fichiers',
    'groups:yes' => 'oui',
    'groups:no' => 'non',
    'group:created' => 'créé %s avec %d publications',
    'groups:lastupdated' => 'dernier commentaire %s par %s',
    'groups:pages' => 'Les wikis du groupe',
    'groups:files' => 'Les fichiers du groupe',
    /* Group forum strings */
    'group:replies' => 'Réponses',
    'groups:forum' => 'Forum du groupe',
    'groups:addtopic' => 'Ajouter un sujet',
    'groups:forumlatest' => 'Forums&nbsp;: derniers sujets',
    'groups:latestdiscussion' => 'Sujets des forums',
    'groupspost:success' => 'Votre commentaire a été publié avec succès',
    'groups:alldiscussion' => 'Tous sujets du forum',
    'groups:edittopic' => 'Modifier le sujet',
    'groups:topicmessage' => 'Message du sujet',
    'groups:topicstatus' => 'Statut du sujet',
    'groups:reply' => 'Publier un commentaire',
    'groups:topic' => 'Sujets',
    'groups:posts' => 'Nombre de réponses',
    'groups:lastperson' => 'Dernière personne',
    'groups:when' => 'Quand',
    'grouptopic:notcreated' => "Aucun sujet n'a été créé.",
    'groups:topicopen' => 'Ouvert',
    'groups:topicclosed' => 'Fermé',
    'groups:topicresolved' => 'Résolu',
    'grouptopic:created' => 'Votre sujet a été créé.',
    'groupstopic:deleted' => 'Le sujet a été supprimé.',
    'groups:topicsticky' => 'Persistant',
    'groups:topicisclosed' => 'Ce sujet est fermé.',
    'groups:topiccloseddesc' => "Ce sujet a été fermé et n'accepte plus de nouveaux commentaires.",
    'grouptopic:error' => "Votre sujet n'a pas pu être créé. Merci d'essayer plus tard ou de contacter un administrateur du système.",
    'groups:forumpost:edited' => "Vous avez modifié ce billet avec succès.",
    'groups:forumpost:error' => "Il y a eu un problème lors de la modification du billet.",
    'groups:privategroup' => 'Ce groupe est privé. Il est nécessaire de demander une adhésion.',
    'groups:notitle' => 'Les groupes doivent avoir un titre',
    'groups:cantjoin' => "N'a pas pu rejoindre le groupe",
    'groups:cantleave' => "N'a pas pu quitter le groupe",
    'groups:addedtogroup' => "A ajouté avec succès l'utilisateur au groupe",
    'groups:joinrequestnotmade' => "La demande d'adhésion n'a pas pu être réalisée",
    'groups:joinrequestmade' => "La demande d'adhésion s'est déroulée avec succès",
    'groups:joined' => 'Vous avez rejoint le groupe avec succès !',
    'groups:left' => 'Vous avez quitter le groupe avec succès',
    'groups:notowner' => "Désolé, vous n'êtes pas le propriétaire du groupe.",
    'groups:alreadymember' => "Vous êtes déjà membre de ce groupe !",
    'groups:userinvited' => "L'utilisateur a été invité.",
    'groups:usernotinvited' => "L'utilisateur n'a pas pu être invité",
    'groups:useralreadyinvited' => "L'utilisateur a déjà été invité",
    'groups:updated' => "Dernière mise à jour",
    'groups:invite:subject' => "%s, vous avez été invité(e) à rejoindre %s!",
    'groups:started' => "Démarré par",
    'groups:joinrequest:remove:check' => "Etes-vous sûr de vouloir annuler votre demande d'adhésion ?",
    'groups:invite:body' => "Bonjour %s,

%s vous a invité(e) à rejoindre le groupe '%s' cliquez sur le lien ci-dessous pour confirmer:

%s",
    'groups:welcome:subject' => "Bienvenue dans le groupe %s !",
    'groups:welcome:body' => "Bonjour %s!
  
Vous êtes maintenant membre du groupe '%s' ! Cliquez le lien ci-dessous pour commencer à participer !

%s",
    'groups:request:subject' => "%s a demandé une adhésion à %s",
    'groups:request:body' => "Bonjour %s,

%s a demandé à rejoindre le groupe '%s', cliquez le lien ci-dessous pour voir son profil :
%s


ou cliquez le lien ci-dessous pour confirmer son adhésion :
%s",
    /* Forum river items */
    'groups:river:member' => 'est maintenant membre de ',
    'groupforum:river:updated' => '%s a mis à jour',
    'groupforum:river:update' => 'ce sujet de discussion',
    'groupforum:river:created' => '%s a créé',
    'groupforum:river:create' => 'un sujet de discussion ',
    'groupforum:river:posted' => '%s a publié un nouveau commentaire',
    'groupforum:river:annotate:create' => 'sur ce sujet de discussion',
    'groupforum:river:postedtopic' => '%s a démarré un sujet de discussion ',
    'groups:river:member' => '%s est maintenant membre de',
    'groups:nowidgets' => "Aucun widget n'a été défini pour ce groupe.",
    'groups:widgets:members:title' => 'Membres du groupe',
    'groups:widgets:members:description' => "Voir tous les membres d'un groupe.",
    'groups:widgets:members:label:displaynum' => "Lister les membres d'un groupe.",
    'groups:widgets:members:label:pleaseedit' => 'Merci de configurer ce widget.',
    'groups:widgets:entities:title' => "Objets dans le groupe",
    'groups:widgets:entities:description' => "Lister les objets enregistré dans ce groupe",
    'groups:widgets:entities:label:displaynum' => "Lister les objets d'un groupe.",
    'groups:widgets:entities:label:pleaseedit' => 'Merci de configurer ce widget.',
    'groups:forumtopic:edited' => 'Sujet du forum modifié avec succès.',
    /* Action messages */
    'group:deleted' => 'Contenus du groupe et groupe supprimés',
    'group:notdeleted' => "Le groupe n'a pas pu être supprimé",
    'grouppost:deleted' => "La publication dans le groupe a été effacée",
    'grouppost:notdeleted' => "La publication dans le groupe n'a pas pu être effacée",
    'groupstopic:deleted' => 'Sujet supprimé',
    'groupstopic:notdeleted' => "Le sujet n'a pas pu être supprimé",
    'grouptopic:blank' => 'Pas de sujet',
    'groups:deletewarning' => "Etes-vous sur de vouloir supprimer ce groupe ? Cette action est irréversible !",
    'groups:joinrequestkilled' => "La demande d'adhésion a été supprimée.",
//
//
/* #########################################################################
MOD : guidtool */
    'guidtool' => 'GUID',
    'guidtool:browse' => 'Naviguer dans les GUIDs',
    'guidtool:import' => 'Importer GUID',
    'guidtool:import:desc' => 'Collez les données que vous souhaitez importer dans la fen&ecirc;tre suivante, au format "%s" format.',
    'guidtool:pickformat' => "Veuillez choisir le format d'import/export.",
    'guidbrowser:export' => 'Exporter',
    'guidtool:deleted' => 'GUID %d supprimé',
    'guidtool:notdeleted' => 'GUID %d non supprimé',
//
//
/* #########################################################################
MOD : iframe */
    'iframe:widget' => 'Site web externe (iframe)',
    'iframe:description' => 'Ajoute une page web externe à votre page (iframe)',
    'iframe:notset' => "L'adresse de la page n'est pas définie",
    'iframe:notfind' => 'Impossible de trouver la page. Veuillez vérifier son adresse.',
    'iframe:iframe_url' => 'URL de la page',
    'iframe:iframe_title' => 'Titre de la page (URL si vide)',
    'iframe:iframe_height' => 'Hauteur du cadre',
//
//
/* #########################################################################
MOD : invitefriends */
  'friends:invite' => 'Inviter à rejoindre la Plateforme collaborative',
  'invitefriends:introduction' => 'Pour inviter des personnes à vous rejoindre sur ce réseau, entrez leurs adresses mail ci-dessous. Les adresses mails doivent être "seules", une par ligne, ou séparées par des virgules, ou encore des points-virgules (fichiers CSV) :',
  'invitefriends:message' => "Vous pouvez ajouter un message à votre invitation :",
  'invitefriends:reportedmessage' => "Message de votre invitation :",
  'invitefriends:reportedmessagetitle' => "Envoi de l'invitation réussi pour :",
  'invitefriends:subject' => 'Invitation à rejoindre %s',
  'invitefriends:success' => 'Vos invitations ont bien été envoyées.',
  'invitefriends:failure' => "Vos invitations n'ont pas pu être envoyées. Veuillez contacter l'administrateur du site.",
  'invitefriends:message:default' => "Bonjour,

Je souhaiterais vous inviter à me rejoindre sur le réseau %s.",
  'invitefriends:email' => "Bonjour,

%2\$s vous a invité à rejoindre le réseau %1\$s :
------------------------------------------------------

%3\$s

Pour accepter l'invitation de %2\$s et créer votre compte de membre sur %1\$s, veuillez cliquer sur le lien suivant :
%4\$s

Vous serez automatiquement mis en contact avec %2\$s dès que vous aurez créé votre compte. N'hésitez pas à lui demander des conseils pour bien débuter sur le site !

ATTENTION : si l'inscription ne fonctionne pas du premier coup, merci de revenir sur la page précédente avant de réessayer, ou de cliquer à nouveau sur ce lien.

------

Si vous pensez qu'il s'agit d'une erreur, veuillez ne pas tenir compte de ce mail, ou contacter l'équipe d'animation du site.",
//
//
/* #########################################################################
MOD : izap_videos */
  'izap_videos' => "iZAP Vidéos",
  'videos' => "Vidéos",
  'izap_videos:videos' => "Vidéos",
  'izap_videos:add' => "Ajouter une vidéo",
  'izap_videos:addgroup' => "Ajouter une vidéo au groupe",
  'izap_videos:user' => "Vidéo de %s",
  'izap_videos:addurl'  =>  "Entrez l'URL de votre vidéo (Youtube, Vimeo, Veoh)" , 
  'izap_videos:title'  =>  "Entrez le titre" , 
  'izap_videos:getvideo' => "Récupérer la vidéo",
  'izap_videos:access' => "Accès",
  'izap_videos:tags' => "Tags de la vidéo",
  'izap_videos:blank' => "Veuillez saisir une URL valide",
  'izap_videos:blanktitle' => "Veuillez saisir le titre de la vidéo",
  'izap_videos:saveerror' => "Désolés, la vidéo n'a pas pu être enregistrée",
  'izap_videos:saved' => "Votre vidéo a bien été enregistrée",
  'izap_videos:everyone' => "Toutes les vidéos",
  'izap_videos:time' => "Ajouté %s",
  'izap_videos:remove' => "Voulez-vous supprimer cette vidéo ?",
  'izap_videos:deleted' => "La vidéo a bien été supprimée",
  'izap_videos:notdeleted' => "La vidéo n'a pas été supprimée",
  'izap_videos:wrongid' => "Désolé, la vidéo est déjà supprimée ou porte un mauvais identifiant",
  'izap_videos:frnd' => "Les vidéos de mes contacts",
  'izap_videos:userfrnd' => "Vidéos des contacts de %s",
  'izap_videos:all' => "Toutes les vidéos du site",
  'izap_videos:river:added' => "%s a ajouté un nouveau ",
  'izap_videos:river:video' => "Vidéo",
  'izap_videos:river:annotate' => " un commentaire sur ",
  'izap_videos:widget' => "Liste des dernières vidéos ajoutées par les membres",
  'item:object:izap_videos' => "Vidéos",
  'izap_videos:numbertodisplay' => "Nombre de vidéos à afficher.",
  'izap_videos:play' => "Démarrer la vidéo choisie",
  'izap_videos:play:widget' => "Ce widget lit les vidéos de votre choix. Une à la fois",
  'izap_videos:chosevideo' => "Choisissez une vidéo à afficher",
  'izap_videos:notfound' => "Aucune vidéo pour le moment.",
  'izap_videos:error' => "Erreur en chargeant les données de l'URL distante. Mauvaise URL ou vidéo on trouvée.",
  'izap_videos:addtoyour' => "Ajouter à mes vidéos.",
  'izap_videos:condition' => "* Au dessus des titres, mots clés et description, remplacera les informations originales.<br>* La source de la vidéo est requise (URL ou Téléchargement)",
  'izap_videos:geterror' => "Impossible de charger la vidéo depuis le site distant (pas de réponse).",
  'izap_videos:description' => "Description",
  'izap_videos:edit' => "Modifier",
  'izap_videos:blank:title' => "Vous devez mettre un titre",
  'izap_videos:save' => "Enregistrer",
  'izap_videos:missingfields' => "Desc hamps requis sont manquants.",
  'izap_videos:autoplay' => "Lecture automatique",
  'izap_videos:views' => "Nombre de visionnages",
  'izap_videos:tagcloud' => "Tags les plus consultés (vidéos)",
  'izap_videos:top' => "Vidéos les plus consultées",
  'izap_videos:fopenerror' => "Demandez à l'administrateur du site d'ajouter <b>'allow_url_fopen = On'</b> dans le fichier php.ini.",
  'izap_videos:errorCode' => "Erreur lors du chargement de l'URL distante. Mauvaise URL ou vidéo non trouvée",
  'izap_videos:errorCode101' => "Impossible de récupérer la vidéo depuis le site (le site ne répond pas).",
  'izap_videos:errorCode102' => "Cette vidéo n'appartient pas à Veoh ; veuillez télécharger la vidéo originale.",
  'izap_videos:latest' => "Dernières vidéos",
  'izap_videos:groups' => "Vidéos de %s",
  'izap_videos:group:enablevideo' => "Activer les vidéos du groupe",
  'izap_videos:groupvideos' => "Vidéos du groupe",
  'izap_videos:izapUploadOption' => "Type de vidéo :",
  'izap_videos:upload' => "Envoyer une vidéo (formats 3gp, avi, mp4, flv)",
  'izap_videos:unsupported' => "Type de fichier non supporté.",
  'izap_videos:converterror' => "Erreur de conversion de la vidéo.",
  'izap_videos:izapBorderColor1' => "Couleur de la bordure border color1 pour le lecteur : (code couleur sans le '#')",
  'izap_videos:izapBorderColor2' => "Couleur de la bordure border color1 pour le lecteur : (code couleur sans le '#')",
  'izap_videos:izapBarColor' => "Couleur de la barre du lecteur : (code couleur sans le '#')",
  'izap_videos:river:titled' => '%s a ajouté une vidéo : %s',
  'izap_videos:latestvideos' => "Dernières vidéos",
//
//
/* #########################################################################
MOD : lastlogin */
       'lastlogin:online' => '- en ligne -',
       'lastlogin:lastconnexion' => 'Dernier passage',
       'lastlogin:hours' => 'heures',
       'lastlogin:hour' => "moins d'1 heure",
//
//
/* #########################################################################
MOD : logbrowser */
    'logbrowser' => 'Visualiseur de journal',
    'logbrowser:browse' => 'Visualiser les journaux système',
    'logbrowser:search' => 'Affiner les résultats',
    'logbrowser:user' => "Rechercher par nom d'utilisateur",
    'logbrowser:starttime' => 'Heure de début (par exemple "dernier lundi", "il y a une heure")',
    'logbrowser:endtime' => 'Heure de fin',
    'logbrowser:explore' => 'Explorer le journal',
//
//
/* #########################################################################
MOD : members */
    'members:members' => "Annuaire du réseau",
    'members:online' => "Membres connectés",
    'members:active' => "membres du site",
    'members:searchtag' => "Recherche par tag",
    'members:searchname' => "Recherche par nom de membre",
//
//
/* #########################################################################
MOD : messageboard */
    'messageboard:board' => "Mur",
    'messageboard:messageboard' => "Mur",
    'messageboard:viewall' => "Voir tout",
    'messageboard:postit' => "Envoyer",
    'messageboard:history' => "historique",
    'messageboard:none' => "Il n'y a encore rien sur ce Mur",
    'messageboard:num_display' => "Nombre de messages à afficher",
    'messageboard:desc' => "Le Mur est un espace que vous pouvez ajouter sur votre page de profil, et où les autres utilisateurs peuvent laisser un message.",
    'messageboard:user' => "Mur de %s",
    'messageboard:history' => "Historique",
       /* Message board widget river */
      'messageboard:river:annotate' => "%s a reçu un nouveau commentaire sur son Mur.",
      'messageboard:river:create' => "%s a ajouté le widget Mur.",
      'messageboard:river:update' => "%s a mis à jour son Mur.",
      'messageboard:river:added' => "%s a écrit sur le Mur de",
      'messageboard:river:messageboard' => "",
  /* Status messages */
    'messageboard:posted' => "Votre message a bien été envoyé sur le Mur.",
    'messageboard:deleted' => "Votre message a bien été supprimé.",
  /* Email messages */
    'messageboard:email:subject' => 'Vous avez un nouveau message sur le Mur !',
    'messageboard:email:body' => "Vous avez reçu un nouveau message de %s sur votre Mur :

    
%s


Pour voir vos messages de Mur, cliquez sur : %s

Pour voir le profil de %s, cliquez sur : %s


Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",

  /* Error messages */
    'messageboard:blank' => "Désolé, vous devez écrire quelque chose dans le corps du message avant de pouvoir l'enregistrer.",
    'messageboard:notfound' => "Désolé, l'élément spécifié n'a pu être trouvé.",
    'messageboard:notdeleted' => "Désolé, le message n'a pu être supprimé.",
    'messageboard:somethingwentwrong' => "Quelque chose a tourné court lors de l'enregistrement de votre message, veuillez vérifier que vous avez bien écrit un message.",
    'messageboard:failure' => "Une erreur imprévue s'est produite lors de l'ajout de votre message. Veuillez réeessayer.",
//
//
/* #########################################################################
MOD : messages */
    'messages' => "Messages",
    'messages:back' => "retour aux messages",
    'messages:user' => "Votre boîte de réception",
    'messages:sentMessages' => "Messages envoyés",
    'messages:posttitle' => "Messages de %s : %s",
    'messages:inbox' => "Boîte de réception",
    'messages:send' => "Envoyer un message",
    'messages:sent' => "Messages envoyés",
    'messages:message' => "Contenu du message ",
    'messages:title' => "Sujet du message ",
    'messages:to' => "Destinataire ",
    'messages:from' => "De",
    'messages:fly' => "Envoyer",
    'messages:replying' => "Message en réponse à",
    'messages:inbox' => "Boîte de réception",
    'messages:sendmessage' => "Envoyer un message",
    'messages:compose' => "Ecrire un message",
    'messages:sentmessages' => "Messages envoyés",
    'messages:recent' => "Messages reçus",
    'messages:original' => "Message d'origine",
    'messages:yours' => "Votre message",
    'messages:answer' => "Répondre",
    'messages:toggle' => 'Inverser la sélection',
    'messages:markread' => 'Marquer comme lu',
    'messages:new' => 'Nouveau message',
    'notification:method:site' => 'Site',
    'messages:error' => "Un problème est survenu lors de l'enregistrement de votre message. Veuillez réessayer.",
    'item:object:messages' => 'Messages',
  /* Status messages */
    'messages:posted' => "Votre message a bien été envoyé.",
    'messages:deleted' => "Votre message a bien été effacé.",
    'messages:markedread' => "Vos messages ont bien été marqués comme lus.",
  /* Email messages */
    'messages:email:subject' => 'Vous avez reçu un message de %s',
    'messages:email:body' => "Vous avez reçu un nouveau message de %s :

    
%s


Pour voir vos messages, cliquez sur : %s

Pour envoyer un message à %s, cliquez sur : %s


Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",

  /* Error messages */
    'messages:blank' => "Désolé ; vous devez écrire quelque chose dans votre message avant de pouvoir l'enregistrer.",
    'messages:notfound' => "Désolé ; le message spécifié n'a pu être trouvé.",
    'messages:notdeleted' => "Désolé ; ce message n'a pu être effacé.",
    'messages:nopermission' => "Vous n'avez pas l'autorisation de modifier ce message.",
    'messages:nomessages' => "Il n'y a aucun message à afficher.",
    'messages:user:nonexist' => "Le destinataire n'a pu être trouvé dans la base de données des utilisateurs.",
  /* Ajouts pour Plateforme collaborative (envoi à un groupe ou une liste) */
    'messages:tocollection' => "Groupe ou liste de contacts ",
    'messages:newcollection' => "Créer une liste",
    'messages:attachement' => "Pièce jointe",
//
//
/* #########################################################################
MOD : multipublisher */
  'multipublisher:mymultipublisher' => 'Vos discussions',
  'multipublisher:friendsmultipublisher' => 'Discussions de vos contacts',
  'multipublisher:allmultipublisher' => 'Toutes les discussions',
  'multipublisher:addmultipublisher' => 'Lancer une discussion',
  'multipublisher:add__title' => 'Démarrez une nouvelle discussion',
  'multipublisher:list' => 'Vos discussions',
  'multipublisher:toolbar' => 'discussion',
  'multipublisher:friends' => 'Discussions de vos contacts',
  'multipublisher:user' => 'Discussions de %s',
  'multipublisher:user:friends' => 'Discussions des contacts de %s',
  'multipublisher:view' => 'Voir une discussion',
  'multipublisher:world' => 'Toutes les discussions',
  'multipublisher:title:mandatory' => 'Vous devez obligatoirement mettre un titre à votre message',
  'multipublisher:add:success' => 'Votre discussion a bien été ajoutée',
  'multipublisher:edit:success' => 'Votre discussion a bien été mise à jour',
  'item:object:multipublisher' => 'Discussions',
  'multipublisher:type' => 'type : ',
  'multipublisher:works' => 'Travaux',
  'multipublisher:in' => 'in',
  'multipublisher:avec' => 'en collaboration avec',
  'multipublisher:details' => 'Discuter',
//
  'multipublisher:subtitle' => 'Sous-titre :',
  'multipublisher:revue_num' => 'Numéro / Volume :',
  'multipublisher:revue_name' => 'Nom de la revue :',
  'multipublisher:name' => 'Titre :',
  'multipublisher:revue_mois' => 'Mois / année :',
  'multipublisher:location' => 'Lieu de multipublisher :',
  'multipublisher:editor' => "Nom de l'éditeur",
  'multipublisher:startingpage' => 'Pages (emplacement)',
  'multipublisher:abstract' => 'Résumé',
  'multipublisher:url' => 'Url où la discussion peut être vue (commençant par "http://")',
  'multipublisher:date' => 'Année de discussion',
  'multipublisher:tags' => 'Mots-clés (séparés par une virgule)',
  'multipublisher:pages' => 'Nombre de pages',
  'multipublisher:writers' => 'Prénoms et noms des codirecteurs',
  'multipublisher:coordinators' => 'Prénoms et noms des coordinateurs',
  'multipublisher:maintitle' => 'Titre de la discussion',
  'multipublisher:name:article' => "Titre de l'article",
  'multipublisher:site_name' => 'Nom du site',


  'multipublisher:select_multipublisher_title' => 'Ajoutez une discussion',
  'multipublisher:edit' => 'Modifiez une discussion',
  'multipublisher:add_selected' => 'Ajoutez',
  'multipublisher:select_type' => 'Choisissez le type de discussion',
  'multipublisher:book' => 'Livres',
  'multipublisher:collectif' => 'Ouvrages collectifs en codirection',
  'multipublisher:article' => 'Articles et contributions à des ouvrages collectif',
  'multipublisher:revue' => 'Articles et contributions à des revues',
  'multipublisher:internet' => 'Articles et contributions à des revues internet',
  'multipublisher:delete:success' => 'La discussion a bien été supprimée',
  'multipublisher:remove' => 'Supprimer cette discussion ?',
  'multipublisher:comment:remove' => 'Supprimer cette réaction ?',
  'multipublisher:deletecomment:success' => 'La réaction a bien été supprimée',
  'multipublisher:saved:comment' => 'Votre réaction a bien été enregistrée',
  'multipublisher:titlemandatory' => 'Vous devez donner un titre à votre discussion',
  'multipublisher:updated' => 'La discussion a bien été mise à jour',
  'multipublisher:update' => 'Modifier une discussion',

  'multipublisher:add_book_title' => 'discussion : ajouter un livre',
  'multipublisher:add_collectif_title' => 'discussion : ajouter un ouvrage collectif',
  'multipublisher:add_article_title' => 'discussion : ajouter un article ou une contribution dans un collectif',
  'multipublisher:add_revue_title' => 'discussion : ajouter un article ou une contribution à une revue',
  'multipublisher:add_internet_title' => 'discussion : ajouter un article ou une contribution à une revue internet',
//
  'multipublisher:widget:title' => 'Discussions',
  'multipublisher:widget:description' => 'Affiche les discussions',
  'multipublisher:widget:nocontent' => 'Aucune discussion',
//
  'multipublisher:river:created'  =>  "%s a ajouté" , 
  'multipublisher:river:updated'  =>  "%s a modifié" , 
  'multipublisher:river:posted'  =>  "%s a posté" , 
  'multipublisher:river:create'  =>  "une nouvelle discussion : " , 
  'multipublisher:river:update'  =>  "la discussion " , 
  'multipublisher:river:annotate'  =>  "une réaction sur la discussion" , 
//
  'multiplisher:addcommenttext' => 'Réagissez',
  'multipublisher_comment:title' => 'RÉACTIONS',
  'multipublisher:add' => 'Publiez une discussion',
  'multiplisher:addtext' => "Pour publier une discussion, vous pouvez :<br/>
  - Charger un fichier du format de votre choix : son, image, vidéo <br/>
  - Copier le lien vers une vidéo : youtube, dailymotion, vimeo, ... (seulement si vous n'avez pas chargé de fichier)<br />
  - Ajouter une réaction.",
  'multipublisher:file' => 'Chargez une image ou un fichier son depuis votre ordinateur',
  'multipublisher:addurl' => "Copiez l'URL d'une vidéo (youtube, dailymotion, myspace, vimeo, ...)",
//
  'multipubliher:addwebcamcomment' => 'Enregistrez un message depuis votre webcam ou votre micro',
  'multipublisher:webcam:add' => 'Enregistrez-vous depuis votre webcam',
  'multipublisher:webcam:or' => 'ou',
  'multipublisher:webcam:audioonly' => 'Enregistrez-vous depuis votre micro',
  'multipublisher:webcam:close' => 'Fermer',
  'multipublisher:webcam:see' => 'Voir le message',
  'multipublisher:webcam:listen' => 'Ecouter le message',
  'multipubliher:addcontent' => 'Choisissez le type de contenu à publier',
  'multipublisher:description' => 'Ajoutez une réaction',
  'multipublisher:addtext' => 'Publiez un texte seul',
  'multipublisher:tags' => 'Ajoutez des mots-clés (séparés par une virgule)',
//
  'multipublisher:world:comments' => "Les réactions",
  'multipublisher:allcomments' => "Tous les réactions",
  'multipublisher:page_title' => "Les discussions",
  'multipublisher:launched' => 'lancée',
  'multipublisher:by' => 'par',
  'multipublisher:on' => 'sur',
  'multipublisher:readmoreandreact' => 'lire / réagir',
//
//
/* #########################################################################
MOD : multisite */
  'multisite:title'  =>  "Projets" , 
  'multisite:mysite'  =>  "Mes projets" , 
  'multisite:allsites'  =>  "Tous les projets" , 
  'multisite:createsites'  =>  "Créer un nouveau projet" , 
  'multisite:yours'  =>  "Vos projets" , 
  'multisite:allsite_title'  =>  "Tous les projets" , 
  'multisite:unregister'  =>  "Désinscription" , 
  'multisite:login'  =>  "Connexion" , 
  'multisite:register'  =>  "Inscription" , 
  'multisite:register_ok'  =>  "Votre inscription a bien été prise en compte" , 
  'multisite:register_not_ok'  =>  "Votre inscription n'a pas abouti" , 
  'multisite:unregister_ok'  =>  "Vous demande de désinscription a été prise en compte" , 
  'multisite:create_site_title'  =>  "Créer un nouveau projet" , 
  'multisite:site_name'  =>  "Nom" , 
  'multisite:site_description'  =>  "Description courte" ,
  'multisite:site_longdescription' => "Présentation du projet",
  'multisite:site_type' => 'Type',
  'multisite:site_url'  =>  "Url débutant par http://... finissant par /" , 
  'multisite:site_email'  =>  "Email" , 
  'multisite:submit'  =>  "Sauvegarder" , 
  'multisite:configuration:success'  =>  "Votre nouveau projet a bien été créé" , 
  'multisite:configuration:noinit' => 'Impossible de créer un nouveau projet, vous devez lancer init multisite dans le menu administration',
  'multisite:security_message'  =>  "Vous allez vous connecter à  un autre de vos projets. Par mesure de précaution et pour assurer la sécurité de vos informations, vous devez confirmer votre nom d'utilisateur et votre mot de passe" , 
  'multisite:delete'  =>  "supprimer" , 
  'multisite:disable'  =>  "fermer" , 
  'multisite:enable'  =>  "ouvrir" , 
  'multisite:disable_ok'  =>  "Le projet a bien été fermé (inscription impossible)" , 
  'multisite:enable_ok'  =>  "Le projet a bien été ouvert (inscription possible)" , 
  'multisite:setting'  =>  "configurer" , 
  'multisite:delete:menu'  =>  "Supprimer un projet" , 
  'multisite:delete_ok'  =>  "Le projet a bien été supprimé" , 
  'multisite:delete_not_ok'  =>  "Vous ne pouvez pas supprimer ce projet" , 
  'multisite:option:domain_name'  =>  "Nom de domaine" , 
  'multisite:option:message'  =>  "Non utilisé dans cette version" , 
  'multisite:manage:users'  =>  "Gestion des membres" , 
  'multisite:manage:communities'  =>  "Configurer les projets" , 
  'multisite:plugins'  =>  "Configurer les plugins" , 
  'multisite:update'  =>  "Init multisite",
  'multisite:update_title'  =>  "Initialisation de multisite" , 
  'multisite:update_message'  =>  "Vous devez initialiser le module multisite lorsque vous l'installez pour le première fois" , 
  'multisite:submit_update'  =>  "Initialiser le module multisite" , 
  'multisite:register_close'  =>  "Ce projet est fermé - Vous ne pouvez pas vous enregistrer" , 
  'multisite:manage:plugin'  =>  "Gestion des plugins" , 
  'multisite:plugin:global'  =>  "global" , 
  'multisite:plugin:local'  =>  "local" , 
  'multisite:plugin:theme'  =>  "theme" , 
  'multisite:plugin:hidden'  =>  "caché" , 
  'multisite:plugin:message:header'  =>  "Configurer les plugins installés" , 
  'multisite:plugin:message:global'  =>  "Global : L'outil sera activé pour tous les projets - Seul l'administrateur global y a accès" , 
  'multisite:plugin:message:local'  =>  "Local : L'outil pourra être activé/désactivé par l'administrateur local" , 
  'multisite:plugin:message:theme'  =>  "Theme : Le thème pourra activé/désactivé par l'administrateur local" , 
  'multisite:plugin:message:hidden'  =>  "Caché : Seul l'administrateur global pourra activer / désactiver l'outil" , 
  'multisite:localadmin:themes_title'  =>  "Sélecteur de thème" , 
  'multisite:localadmin:themes_message'  =>  "Sélectionnez l'un ds thèmes ci-dessous et rechargez la page dans votre navigateur" , 
  'multisite:localadmin:disable_plugin'  =>  "désactiver" , 
  'multisite:localadmin:enableplugin'  =>  "activer" , 
  'multisite:localadmin:setting'  =>  "Configuration du projet" , 
  'multisite:localadmin:plugins'  =>  "Sélecteur d'outils" , 
  'multisite:localadmin:themes'  =>  "Sélecteur de thème" , 
  'multisite:localadmin:users'  =>  "Gestion des utilisateurs" , 
  'multisite:localadmin:plugin_title'  =>  "Sélecteur d'outils" , 
  'multisite:localadmin:plugin_message'  =>  "Sélectionnez les outils que vous voulez activer pour votre projet" , 
  'multisite:top:admin'  =>  "AdminSite" , 
  'multisite:localadmin:setting_message'  =>  "Vous devez ouvrir le projet pour que des membres puissent s'y enregistrer" , 
  'multisite:localadmin:title'  =>  "Configuration du projet" , 
  'multisite:localadmin:submit_close'  =>  "fermer le projet" , 
  'multisite:localadmin:submit_open'  =>  "ouvrir le projet" , 
  'multisite:localplugin:enable_ok'  =>  "Le plugin a bien été activé" , 
  'multisite:localplugin:disable_ok'  =>  "Le plugin a bien été désactivé" , 
  'multisite:sitestatus:close'  =>  "Le statut actuel est : Fermé" , 
  'multisite:sitestatus:open'  =>  "Le statut actuel est : Ouvert" , 
  'multisite:sitestatus:changestatus'  =>  "Changer le statut" , 
  'multisite:setting_site_title'  =>  "Configurer" , 
  'multisite:setting:site_url'  =>  "url (finissant par \"/\")" , 
  'multisite:setting:site_domain'  =>  "Domaine (finissant par \"/\")" , 
  'multisite:setting:site_network'  =>  "Réseau" , 
  'multisite:site_oicn'  =>  "in / out Interconnected Communities Network" , 
  'multisite:change_site_oicn'  =>  "Changer" , 
  'multisite:defaultsetting:message'  =>  "Valeurs initiales par défaut" , 
  'multisite:defaultsetting:domain'  =>  "Nom de domaine par défaut (finissant par \"/\")" ,
  'multisite:defaultsetting:folder' => 'Nom du sous-dossier (finissant par "/"). Laissez blanc si votre installation est sous la racine, sinon donner le nom du sous-dossier de votre installation',
  'multisite:defaultsetting:network'  =>  "Nom de réseau par défaut ((\"no\"=no network, \"all\"= all networks)" , 
  'multisite:configuration:wrongurl'  =>  "Ce sous-domaine existe déjà, veuiller utiliser un autre nom de sous-domaine" , 
  'multisite:friends:title'  =>  "Vos contacts sur " , 
  'multisite:friends:select'  =>  "Choisissez un projet ",
//
  'multisite:site_icon' => "Icône",
  'multisite:setting:site_description' => "Description courte",
  'multisite:setting:site_longdescription' => "Description détaillée",
  'multisite:setting:site_type' => "Type de réseau",
//
//
/* #########################################################################
MOD : notifications */
  'friends:all' => 'Tous les contacts',
  'notifications:subscriptions:personal:description' => 'Recevoir des notifications quand des actions concernent vos contenus',
  'notifications:subscriptions:personal:title' => 'Notifications personnelles',
  'notifications:subscriptions:collections:title' => 'Utiliser les listes de contacts',
  'notifications:subscriptions:collections:description' => 'Pour utiliser la notification liée aux listes de contacts, cochez pour chacun des groupes la notification souhaitée. Note : les membres des listes de contacts sélectionnés seront automatiquement cochés dans la fenêtre des "Notification par utilisateur" en bas de page. ',
  'notifications:subscriptions:collections:edit' => 'Pour modifier vos listes de contacts, cliquez ici.',
  'notifications:subscriptions:changesettings' => 'Notifications',
  'notifications:subscriptions:changesettings:groups' => 'Alertes pour les groupes',
  'notification:method:email' => 'Email',	
  'notifications:subscriptions:title' => 'Notifications par utilisateur',
  'notifications:subscriptions:description' => 'Pour recevoir des notifications de vos contacts quand ils créent de nouveaux contenus, sélectionnez-les ci-dessous, et choisissez le mode de notifications que vous souhaitez utiliser.',
  'notifications:subscriptions:groups:description' => 'Pour recevoir des notifications lorsque de nouveaux contenus sont ajoutés à un groupe auquel vous appartenez, sélectionnez-les ci-dessous, et choisissez le mode de notification que vous souhaitez utiliser.',
  'notifications:subscriptions:success' => 'Vos paramètres de notifications ont bien été enregistrés.',
//
//
/* #########################################################################
MOD : notificationsplus */
//
//
/* #########################################################################
MOD : online */
    'online:widget:title' => "Membres connectés.",
    'online:widget:onlineusers' => "Actuellement connectés: ",
//
//
/* #########################################################################
MOD : online_mark */
//
//
/* #########################################################################
MOD : openid_client */
  'openid_client_login_title'                     => "Se connecter avec OpenID",
  'openid_client_login_service'                   => "Service",
  'openid_client_logon'                           => "Connexion",
  'openid_client_go'                              => "Connexion",
  'openid_client_remember_login'                  => "Rester connecté",
  'openid_client:already_loggedin'                => "Vous êtes déjà connecté(e).",
  'openid_client:login_success'                   => "Vous êtes connecté(e).",
  'openid_client:login_failure'                   => "Le nom d'utilisateur n'a pas été spécifié. Le système n'a pas pu vous connecter.",
  'openid_client:disallowed'                      => "Ce site n'autorise pas le gestionnaire d'OpenID que vous utilisez. "
          ."Merci d'essayer un nouvel OpenID, ou contactez l'administrateur du site.",
  'openid_client:redirect_error'                  => "N'a pas pu vous rediriger vers le serveur: %s",
  'openid_client:authentication_failure'          => "L'authentification OpenID a échoué: %s n'est pas une URL OpenID valide.",
  'openid_client:authentication_cancelled'        => "L'authentification OpenID a été annulée.",
  'openid_client:authentication_failed'           => "L'authentification OpenID a échoué (status: %s, message: %s )",
  'openid_client:banned'                          => "Votre compte a été désactivé !",
  'openid_client:email_in_use'                    => "Nous ne pouvons pas changer votre adresse email a %s parce qu'elle est déjà utilisée.",
  'openid_client:email_updated'                   => "Votre adresse email a été mise à jour en %s",
  'openid_client:information_title'               => "OpenID information",
  'openid_client:activate_confirmation'           => "Un message de confirmation a été envoyé à %s ."
          ." Merci de cliquer le lien dans le message afin d'activer votre compte."
          ." Vous pourrez alors vous connecter avec votre compte OpenID.",
      'openid_client:change_confirmation'             => "Votre adresse email a changé. Un message de confirmation vous a été envoyé"
              ." a votre nouvelle adresse %s . Merci de cliquer le lien dans le message afin de confirmer cette nouvelle adresse email. ",
      'openid_client:activate_confirmation_subject'   => "vérification du compte %s",
      'openid_client:activate_confirmation_body'      => "Cher %s,\n\nMerci de vous être isncrit(e) avec %s.\n\n"
          ."Pour finaliser votre inscription, merci de suivre le l'URL:\n\n\t%s\n\ndans les 7 jours.\n\nBien à vous,\n\nL'équipe %s.",
      'openid_client:change_confirmation_subject'     => "%s email change",
      'openid_client:change_confirmation_body'        => "DCher %s,\n\nNous avons reçu une demande de changement de votre adresse email"
          ." inscrit avec %s.\n\nPour changer votre adresse email à {%s}, suivez l'URL suivant:\n\n\t%s\n\ndans les 7 jours."
          ."\n\nBien à vous,\n\nL'équipe %s.",				
    'openid_client:email_label'                     => "Email:",
    'openid_client:name_label'                      => "Nom:",
    'openid_client:submit_label'                    => "Soumettre",
    'openid_client:cancel_label'                    => "Annuler",
    'openid_client:nosync_label'                    => "Ne pas me signaler si les données sur ce système ne sont pas les mêmes"
        ." que les données de mon serveur OpenID.",
    'openid_client:sync_instructions'               => "L'information contenue sur votre serveur OpenID n'est pas la même que celle sur ce système."
        ." Cliquer les boites des informations que vous voulez mettre à jour, et cliquer soumettre.",
    'openid_client:missing_title'					=> "Merci de remplir les informations manquantes",
    'openid_client:sync_title'						=> "Synchroniser vos informations",
    'openid_client:missing_email'                   => "une adresse email valide",
    'openid_client:missing_name'                    => "votre nom complet",
    'openid_client:and'                             => "et",
    'openid_client:missing_info_instructions'       => "Pour créer un compte sur ce site vous devez renseigner %s."
        ." Merci de renseigner les informations ci-dessous.",
    'openid_client:create_email_in_use'             => "Nous n'avons pu créer un compte avec l'adresse email %s car elle est déjà utilisée.",
    'openid_client:missing_name_error'              => "Vous devez stupuler un nom.",
    'openid_client:invalid_email_error'             => "Vous devez stipuler une adresse email valide.",
    'openid_client:invalid_code_error'              => "Votre code semble invalide. Les codes ne durent que 7 jours;"
        ." il est possible que le votre soit obsolète.",
    'openid_client:user_creation_failed'            => "La création du compte OpenID a échoué.",
    'openid_client:created_openid_account'          => "Compte OpenID créé, email transféré %s et nom %s de la part du serveur OpenID.",
    'openid_client:name_updated'                    => "Votre nom a été mis à jour en %s.",
    'openid_client:missing_confirmation_code'       => "Votre code de confirmation semble manquer. Merci de vérifier le lien et réessayer.",
    'openid_client:at_least_13'                     => "Vous devez avoir plus de 13 pour vous enregistrer.",
    'openid_client:account_created'                 => "Votre compte a été créé ! Vous pouvez maintenant vous connecter en utilisant l'OpenID (%s) qui vous a été donné..",
    'openid_client:email_changed'                   => "Votre adresse email a été changée à {%s} . "
      ."Vous pouvez maintenant vous connecter en utilisant votre OpenID si vous n'êtes pas déjà connecté(e).",
  'openid_client:thankyou'                        => "Merci de vous être inscrit(e) avec %s!"
        ." L'inscription est totalement gratuite, mais avant de renseigner votre profil,"
        ." merci de prendre un moment pour lire les documents suivant:",
    'openid_client:terms'                           => "termes et conditions",
    'openid_client:privacy'                         => "Confidentialité",
    'openid_client:acceptance'                      => "Soumettre le document suivant indique que vous acceptez tous les termes et conditions. "
        ."Pensez que vous devez avoir plus de 13 ans pour rejoindre ce site.",
    'openid_client:correct_age'                     => "J'ai plus de 13 ans.",
    'openid_client:join_button_label'               => "Rejoindre",
    'openid_client:confirmation_title'              => "Confirmation",
    'openid_client:admin_title'                     => "Configurer votre client OpenID",
    'openid_client:default_server_title'             => "Serveur par défaut",
    'openid_client:default_server_instructions1'     => "Vous pouvez simplifier la connexion en utilisant OpenID et en spécifiant un serveur OpenID par défaut."
          ." Les utilisateurs qui utilisent un simple nom  (comme. \"Robert\") durant la connexion OpenID peuvent le transformer en un compte OpenID"
        ." si vous stipuler un serveur par défaut ici. Mettez \"%s\" où vous souhaitez que le compte soit ajouté. Par exemple, stipulez"
        ." \"http://openidserver.com/%s/\" si vous voulez que votre OpenID devienne \"http://openidserver.com/robert/\" ou"
        ." \"http://%s.openidserver.com/\" si vous voulez que votre OpenID devienne \"http://robert.openidserver.com/\"",
    'openid_client:default_server_instructions2'    => "La présence de points (\".\") est utilisée pour distinguer les URLs OpenID d'URLs simples"
        ." , donc vous ne pouvez utiliser ce dispositif pour les serveurs qui n'utilisent pas les points par défaut.",
    'openid_client:server_sync_title'               => "Synchronisation du serveur",
    'openid_client:server_sync_instructions'        => "Cliquer cette boite si vous voulez automatiquement mettre à jour le site client si un"
        ." utilisateur se connecte et que son nom ou son adresse email est différente de celles de leur serveur OpenID. Laisser cette boite libre"
        ." si vous voulez que les utilisateurs puissent avoir la possibilité d'avoir un nom ou une adresse email différente de leur serveur d'OpenID.",
    'openid_client:server_sync_label'               => "Mettre à jour automatiquement à partir du serveur OpenID.",
    'openid_client:lists_title'                     => "Listes d'OpenID",
    'openid_client:lists_instruction1'              => "Vous pouvez mettre en place une liste d'OpenIDs verte, jaune ou rouge que le client pourra accepter.",
    'openid_client:lists_instruction2'              => "La liste verte contient les OpenIDs qui seront autorisés pour l'identification"
        ." et qui pourront donner une adresse email valide.",
    'openid_client:lists_instruction3'              => "La liste jaune contient les OpenIds qui seront accepter pour une identification seulement."
        ." Si une adresse email est stipulée, un message de confirmation sera d'abord envoyé.",
    'openid_client:lists_instruction4'              => "La liste rouge contient la liste des OpenIDs qui seront rejetés.",
    'openid_client:lists_instruction5'              => "Si vous ne stipulez pas de liste verte, jaune ou rouge, tous les OpenIDs"
        ." auront un statut vert.",
    'openid_client:lists_instruction6'              => "Mettez un OpenID par ligne. Vous pouvez utiliser \"*\" comme wildcard"
        ." pour faire correspondre plusieurs OpenIDs. Chaque OpenID doit démarrer avec http:// or https://  et être fermé avec un"
        ." slash (\"/\") - ex. http://*.myopenid.com/",
    'openid_client:green_list_title'                => "Liste verte",
    'openid_client:yellow_list_title'               => "Liste jaune",
    'openid_client:red_list_title'                  => "Liste rouge",
    'openid_client:ok_button_label'                 => "OK",
    'openid_client:admin_response'                  => "La configuration du client OpenID a été enregistrée.",
//
//
/* #########################################################################
MOD : openid_server */
  'openid_server:trust_title'                     => "Faire confiance à",	
  'openid_server:trust_question'                  => "Souhaitez-vous confirmer votre OpenID (<code>%s</code>) auprès de <code>%s</code>?",
  'openid_server:remember_trust'                  => "Se souvenir de mon choix",
  'openid_server:confirm_trust'                   => "Oui",
  'openid_server:reject_trust'                    => "Non",
  'openid_server:not_logged_in'                   => "Vous devez être identifié pour accepter cette requête. Veuillez vous identifier maintenant.",
  'openid_server:loggedin_as_wrong_user'          => "Vous devez être identifié en tant que %s pour accepter cette requête."
      ." Vous êtes actuellement identifié en tant que %s.",
  'openid_server:trust_root'                      => "Racine de confiance",
  'openid_server:trust_site'                      => "Site de confiance",
  'openid_server:autologin_url'                   => "URL d'auto-login:",
  'openid_server:autologout_url'                  => "URL d'auto-logout:",
  'openid_server:iframe_width'                    => "Largeur de l'iframe (en pixels)",
  'openid_server:iframe_height'                   => "Hauteur de l'iframe (en pixels)",
  'openid_server:change_button'                   => "Changer",
  'openid_server:add_button'                      => "Ajouter",
  'openid_server:admin_explanation'               => "Vous pouvez utiliser cette page pour définir des racines de confiance par défaut pour votre"
      ." serveur OpenID. Ce sont les applications OpenID clientes qui sont automatiquement acceptées par les personnes utilisant les OpenIDs fournies"
      ." par votre serveur et ne sont utiles que si vous utilisez OpenID pour intégrer une fédération d'applications de confiance. (Vous n'avez pas"
      ." besoin de faire quoi que ce soit ici si vous n'avez pas d'aplplication de confiance.) Vous pouvez aussi définir des URL d'autologin et"
      ." d'autologout pour une partie de vos application de confiance si vous souhaitez que vos utilisateurs soient automatiquement identifiés ou"
      ." déconnectés de ces applications lorsqu'ils se déconnectent de votre serveur OpenID. Normalement l'autologin et l'autologout ont lieu dans des"
      ." iframes invisibles. Si vous souhaitez débugger cette fonctionnalité et souhaitez voir apparaître les iframes, vous pouvez définir leur largeur"
      ." et leur hauteur ci-dessous.",
  'openid_server:trust_root_updated'              => "Racine de confiance mise à jour",
  'openid_server:trust_root_added'                => "Racine de confiance ajoutée",
  'openid_server:trust_root_deleted'              => "Racine de confiance supprimée",
  'openid_server:edit_trust_root_title'           => "Editer les enregistrements de confiance",
  'openid_server:manage_trust_root_title'         => "Gérer les racines de confiance par défaut",
  'openid_server:trust_root_title'                => "Racines de confiance par défaut",
  'openid_server:edit_option'                     => "Editer",
  'openid_server:delete_option'                   => "Supprimer",
  'openid_server:add_trust_root_title'            => "Ajouter une racine de confiance par défaut",
  'openid_server:autologin_title'                 => "Connexion",
  'openid_server:autologin_body'                  => "Connexion ... veuillez patienter",
  'openid_server:autologout_title'                => "Déconnexion",
  'openid_server:autologout_body'                 => "Déconnexion ... veuillez patienter",		
//
//
/* #########################################################################
MOD : pages
Menu items and titles
*/
    'pages' => "Wiki",
    'pages:yours' => "Votre wiki",
    'pages:user' => "Accueil du wiki",
    'pages:group' => "Wikis du groupe",
    'pages:all' => "Toutes les wikis du site",
    'pages:new' => "Créer une nouvelle page wiki",
    'pages:groupprofile' => "Wikis du groupe",
    'pages:edit' => "Modifier cette page (wiki)",
    'pages:delete' => "Effacer cette page du wiki",
    'pages:history' => "Historique des modifications",
    'pages:view' => "Voir la page (wiki)",
    'pages:welcome' => "Modifier la page d'accueil du wiki",
    'pages:welcomeerror' => "Un problème est survenu lors de l'enregistrement de la page d'accueil de votre wiki",
    'pages:welcomeposted' => "La page d'accueil du wiki a bien été publiée",
    'pages:navigation' => "Navigation dans ce wiki",
    'pages:via' => "via les pages",
    'item:object:page_top' => 'Wiki (page principale)',
    'item:object:page' => 'Wiki (sous-page)',
    'item:object:pages_welcome' => "Blocs des pages d'accueil wiki",
    'pages:nogroup' => 'Ce groupe ne comporte encore aucun wiki',
    'pages:more' => 'Afficher plus de wikis',
  /* River */
    'pages:river:annotate' => "un commentaire sur cette page",
    'pages:river:created' => "%s a écrit",
    'pages:river:updated' => "%s a modifié",
    'pages:river:posted' => "%s a posté",
    'pages:river:create' => "sur la page",
    'pages:river:update' => "la page",
    'page:river:annotate' => "un commentaire sur la page wiki",
    'page_top:river:annotate' => "un commentaire sur la page wiki",
  /* Form fields */
    'pages:title' => 'Titre de la page wiki',
    'pages:description' => 'Contenu de cette page wiki (pour copier-coller depuis Word : touches Ctrl+V)',
    'pages:tags' => 'Tags (tag1, tag2...)',	
    'pages:access_id' => 'Accès en lecture',
    'pages:write_access_id' => 'Accès en écriture',
  /* Status and error messages */
    'pages:noaccess' => "Page wiki inaccessible",
    'pages:cantedit' => 'Vous ne pouvez pas modifier cette page wiki',
    'pages:saved' => 'Page wiki enregistrée',
    'pages:notsaved' => "La page wiki n'a pu être enregistrée",
    'pages:notitle' => 'Vous devez spécifier un titre pour cette page wiki.',
    'pages:delete:success' => 'Votre page wiki a bien été effacée.',
    'pages:delete:failure' => "Votre page wiki n'a pu être effacée.",
  /* Page */
    'pages:strapline' => 'Dernière mise à jour %s par %s',
  /* History */
    'pages:revision' => 'Révision du %s par %s',
  /* Widget */
    'pages:num' => 'Nombre de pages à afficher',
    'pages:widget:description' => "Voici la liste des vos pages.",
  /* Submenu items */
    'pages:label:view' => "Voir la page wiki",
    'pages:label:edit' => "Modifier la page (wiki)",
    'pages:label:history' => "Historique des modifications",
  /* Sidebar items */
    'pages:sidebar:this' => "Cette page (wiki)",
    'pages:sidebar:children' => "Pages du wiki",
    'pages:sidebar:parent' => "Parent",
    'pages:newchild' => "Créer une page depuis celle-ci",
    'pages:backtoparent' => "Retour à '%s'",
    
    'pages:sameasparent' => "identique à celui de la page wiki",
    
//
//
/* #########################################################################
MOD : poll
Menu items and titles
*/
    'poll' => "Sondage",
    'polls' => "Sondages",
    'poll:user' => "Sondage de %s",
    'polls:user' => "Sondages",
    'poll:user:friends' => "Sondage des contacts de %s",
    'poll:your' => "Vos Sondages",
    'poll:posttitle' => "Sondage de %s : %s",
    'poll:friends' => "Sondages des contacts",
    'poll:yourfriends' => "Les derniers sondages de vos contacts",
    'poll:everyone' => "Tous les sondages du site",
    'poll:read' => "Accéder au sondage",
    'poll:addpost' => "Créer un sondage",
    'poll:editpost' => "Modifier un sondage",
    'poll:text' => "Texte du sondage",
    'poll:strapline' => "%s",			
    'item:object:poll' => 'Sondages',
    'item:object:poll:responses' => "réponses",
    'poll:question' => "Question du sondage",
    'poll:responses' => "Choix pour la réponse (séparés par des virgules)",
  /* sondage widget */
    'poll:widget:label:displaynum' => "Combien de sondages souhaitez-vous afficher ?",
    'poll:widget:title' => "Mes Sondages",
    'poll:widget:description' => "Ce widget affiche les sondages que vous avez créés",
    'poll:widget:latestpolls:title' => "Derniers sondages du site",
    'poll:widget:latestpolls:description' => "Ce widget affiche les sondages les plus récents du site.",
    'polls:nonefound' => "Aucun sondage n'a été trouvé",
       /* sondage river */
        //generic terms to use
        'poll:river:created' => "%s a écrit",
        'poll:river:updated' => "%s a mis à jour",
        'poll:river:posted' => "%s a posté",
        
        //these get inserted into the river links to take the user to the entity
        'poll:river:create' => "un nouveau sondage intitulé",
        'poll:river:update' => "le sondage intitulé",
        'poll:river:annotate' => "un commentaire sur le sondage",
        'poll:river:voted' => "%s a voté",
        'poll:river:vote' => "sur le sondage",
  /* Status messages */
    'poll:posted' => "Votre sondage a bien été publié.",
    'poll:responded' => "Merci d'avoir répondu, votre vote a bien été enregistré.",
    'poll:deleted' => "Votre sondage a bien été supprimé.",
    'poll:totalvotes' => "Nombre total de votes: ",
    'poll:voted' => "A voté ! Merci d'avoir participé à ce sondage",
  /* Error messages */
    'poll:save:failure' => "Votre sondage n'a pas pu être enregistré. Veuillez réessayer.",
    'poll:blank' => "Désolé, vous devez compléter à la fois la question et les réponses possibles pour créer un sondage.",
    'poll:notfound' => "Désolé, le sondage spécifié n'a pas pu être trouvé.",
    'poll:notdeleted' => "Désolé, ce sondage n'a pas pu être effacé.",
//
//
/* #########################################################################
MOD : poll_extended
poll types translations
*/
'poll:type'=>"Type de contenu",
'poll:type:other'=>"Autre",
'poll:type:news'=>"Actualités",
'poll:type:goodpractice'=>"Bonnes pratiques",
'poll:type:event'=>"Evénement",
/* poll widget */
'poll:widget:title'=>"sondages",
'poll:widget:description'=>"Ce widget affiche le nombre de sondages spécifié",
'poll:widget:default_view'=>"Vue par défaut du widget",
'poll:widget:default'=>"Normal",
'poll:widget:compact'=>"Compacte",
'polls:empty'=>"Aucun sondage en ce moment",
'poll:extratypes:enable'=> "Activer la prise en charge des types de sondages ?",
'poll:group:polls'=> "Activer la publication de sondages pour les groupes ?",
'poll:group:iconoverwrite'=>"Activer le remplacement de l'icone lorsque le contenu est associé à un groupe ?",
// Group related translations
'group:polls'=>"Sondages",
'group:polls:empty'=>"Ce groupe n'a publié aucun sondage.",
//
'content:owner'=>"Assigner à",
'my:profile'=>"Mon profil",
'publish:for'=>"publié dans %s",
//
//
/* #########################################################################
MOD : profile */
//
//
/* #########################################################################
MOD : profile_manager */
  'profile_manager' => "Gestionnaire de profils",
  'custom_profile_fields' => "Champs de profil personnalisés",
  'item:object:custom_profile_field' => 'Champ de profil personnalisé',
  'item:object:custom_profile_field_category' => 'Catégorie de champ de profil personnalisée',
  'item:object:custom_profile_type' => 'Type de profil personnalisé',
  'item:object:custom_group_field' => 'Champ de groupe personnalisé',
  // admin
  'profile_manager:admin:metadata_name' => 'Nom',	
  'profile_manager:admin:metadata_label' => 'Label',
  'profile_manager:admin:metadata_description' => 'Description',
  'profile_manager:admin:metadata_label_translated' => 'Label (Traduit)',
  'profile_manager:admin:metadata_label_untranslated' => 'Label (Non traduit)',
  'profile_manager:admin:metadata_options' => 'Options (séparées par des virgules)',
  'profile_manager:admin:options:datepicker' => 'Sélecteur de date',
  'profile_manager:admin:options:pulldown' => 'Liste déroulante',
  'profile_manager:admin:options:radio' => 'Boutons radio',
  'profile_manager:admin:options:multiselect' => 'Liste à choix multiple',
  'profile_manager:admin:show_on_members' => "Montrer sur la page des 'Membres'",
  //
  'profile_manager:admin:additional_options' => 'Options supplémentaires',
  'profile_manager:admin:show_on_register' => "Montrer sur le formulaire d'enregistrement",	
  'profile_manager:admin:mandatory' => 'Obligatoire',
  'profile_manager:admin:user_editable' => 'Le membre peut modifier ce champ',
  'profile_manager:admin:output_as_tags' => 'Afficher en tant que tags sur le profil',
  'profile_manager:admin:admin_only' => 'Champ admin seulement',	
  'profile_manager:admin:option_unavailable' => 'Option indisponible',
  //
  'profile_manager:admin:profile_icon_on_register' => "Ajouter un champ d'icône de profil obligatoire dans le formulaire d'inscription",
  'profile_manager:admin:simple_access_control' => "Ne montrer qu'un sélecteur de contrôle d'accès dans le formulaire d'édition du profil",
  //
  'profile_manager:admin:hide_non_editables' => "Masquer les champs non modifiables de la page d'édition du profil",
  //
  'profile_manager:admin:edit_profile_mode' => "Comment afficher l'écran 'modifier le profil'",
  'profile_manager:admin:edit_profile_mode:list' => "Liste",
  'profile_manager:admin:edit_profile_mode:tabbed' => "Onglets",
  //
  'profile_manager:admin:show_full_profile_link' => 'Montrer un lien vers la page du profil complet',
  //
  'profile_manager:admin:display_categories' => 'Sélectionner comment les différentes catégories sont affichées sur le profil',
  'profile_manager:admin:display_categories:option:plain' => 'Plan (à la suite)',
  'profile_manager:admin:display_categories:option:accordion' => 'Accordéon',
  //
  'profile_manager:admin:profile_type_selection' => 'Qui peut modifier le type de profil ?',
  'profile_manager:admin:profile_type_selection:option:user' => 'Membre',
  'profile_manager:admin:profile_type_selection:option:admin' => 'Admin seulement',

  'profile_manager:admin:show_admin_stats' => "Montrer les statistiques d'administration",

  'profile_manager:admin:warning:profile' => "ATTENTION: Ce plugin doit être placé après le plugin Profile",

  // non_editable
  'profile_manager:non_editable:info' => 'Ce champ ne peut être modifié',
  // profile user links
  'profile_manager:show_full_profile' => 'Profil complet',
  // datepicker
  'profile_manager:datepicker:output:dateformat' => '%a %d %b %Y', // For available notations see http://nl.php.net/manual/en/function.strftime.php
  'profile_manager:datepicker:input:localisation' => '', // change it to the available localized js files in custom_profile_fields/vendors/jquery.datepick.package-3.5.2 (e.g. jquery.datepick-nl.js), leave blank for default 
  'profile_manager:datepicker:input:dateformat' => '%m/%d/%Y', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
  'profile_manager:datepicker:input:dateformat_js' => 'mm/dd/yy', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
  
  // register profile icon
  'profile_manager:register:profile_icon' => 'Ce site demande impérativement une photo de profil pour valider votre inscription',
  
  // simple access control
  'profile_manager:simple_access_control' => 'Choisissez qui peut visiualiser les informations de votre profil',

  // register pre check
  'profile_manager:register_pre_check:missing' => 'Le champ suivant ne peut pas être vide : %s',
  'profile_manager:register_pre_check:profile_icon:error' => "Erreur lors de l'envoi de votre icône de profil (probablement due à la taille du fichier envoyé)",
  'profile_manager:register_pre_check:profile_icon:nosupportedimage' => "L'image de profil envoyée n'est pas dans l'un des formats reconnus par le site (jpg, gif, png)",

  // actions
  // new
  'profile_manager:actions:new:success' => 'Le nouveau champ de profil a bien été ajouté',	
  'profile_manager:actions:new:error:metadata_name_missing' => 'Aucun nom de métadonnée fourni',	
  'profile_manager:actions:new:error:metadata_name_invalid' => 'Le nom de métadonnée est invalide',	
  'profile_manager:actions:new:error:metadata_options' => 'Vous devez renseigner les options lorsque vous utilisez ce type',	
  'profile_manager:actions:new:error:unknown' => "Une erreur inconnue s'est produite lors de l'enregistrement d'un nouveau champ de profil",
  'profile_manager:action:new:error:type' => 'Mauvais type de champ (groupe ou profil)',
  
  // edit
  'profile_manager:actions:edit:error:unknown' => 'Erreur lors du chargement des données du profil',

  //reset
  'profile_manager:actions:reset' => 'Réinitialiser',
  'profile_manager:actions:reset:description' => 'Supprimer tous les champs de profil personnalisés.',
  'profile_manager:actions:reset:confirm' => 'Êtes-vous sûr de vouloir réinitialiser tous les champs de profil ?',
  'profile_manager:actions:reset:error:unknown' => "Une erreur inconnue s'est produite lors de la réinitialisation des champs du profil",
  'profile_manager:actions:reset:error:wrong_type' => 'Mauvais type de champ (groupe ou profil)',
  'profile_manager:actions:reset:success' => 'Réinitialisation effectuée',

  //delete
  'profile_manager:actions:delete:confirm' => 'Êtes-vous sûr de vouloir supprimer ce champ ?',
  'profile_manager:actions:delete:error:unknown' => "Une erreur inconnue s'est produite lors de la suppression",

  // toggle option
  'profile_manager:actions:toggle_option:error:unknown' => "Une erreur inconnue s'est produite lors du changement de l'option",

  // actions
  'profile_manager:actions:title' => 'Actions',

  // import from custom
  'profile_manager:actions:import:from_custom' => 'Importer les champs personnalisés',
  'profile_manager:actions:import:from_custom:description' => 'Importer les champs de profil prédéfinis (par défaut dans Elgg).',
  'profile_manager:actions:import:from_custom:confirm' => 'Êtes-vous sûr de vouloir importer les champs personnalisés ?',
  'profile_manager:actions:import:from_custom:no_fields' => 'Aucun champ personnalisé disponible pour importation',
  'profile_manager:actions:import:from_custom:new_fields' => 'Importation réussie de <b>%s</b> nouveaux champs',

  // import from default
  'profile_manager:actions:import:from_default' => 'Importer les champs par défaut',
  'profile_manager:actions:import:from_default:description' => "Importer les champs d'Elgg par défaut.",
      
  'profile_manager:actions:import:from_default:confirm' => 'Êtes-vous sûr de vouloir importer les champs par défaut ?',
  'profile_manager:actions:import:from_default:no_fields' => 'Aucun champ par défaut disponible pour importation',
  'profile_manager:actions:import:from_default:new_fields' => 'Importation réussie de <b>%s</b> nouveaux champs',
  'profile_manager:actions:import:from_default:error:wrong_type' => 'Mauvais type de champ (groupe ou profil)',

  // category to field
  'profile_manager:actions:change_category:error:unknown' => "Une erreur inconnue s'est produite lors de la modification de la catégorie",

  // add category
  'profile_manager:action:category:add:error:name' => "Nom de la catégorie manquant",
  'profile_manager:action:category:add:error:object' => "Erreur lors de la création de l'objet 'catégorie'",
  'profile_manager:action:category:add:error:save' => "Erreur lors de l'enregistrement de l'objet 'catégorie'",
  'profile_manager:action:category:add:succes' => "La catégorie a bien été créée",

  // delete category
  'profile_manager:action:category:delete:error:guid' => "Aucun GUID fourni",
  'profile_manager:action:category:delete:error:type' => "Le GUID fourni n'est pas une catégorie de champ de profil",
  'profile_manager:action:category:delete:error:delete' => "Une erreur est survenue lors de la suppression de la catégorie",
  'profile_manager:action:category:delete:succes' => "La catégorie a bien été supprimée",

  // add profile type
  'profile_manager:action:profile_types:add:error:name' => "Nom du type de profil manquant",
  'profile_manager:action:profile_types:add:error:object' => "Erreur lors de la création du type de profil",
  'profile_manager:action:profile_types:add:error:save' => "Erreur lors de l'enregistrement du type de profil",
  'profile_manager:action:profile_types:add:succes' => "Le type de profil personnalisé a bien été créé",
  
  // delete profile type
  'profile_manager:action:profile_types:delete:error:guid' => "Aucun GUID fourni",
  'profile_manager:action:profile_types:delete:error:type' => "Le GUID fourni n'est pas un type de profil",
  'profile_manager:action:profile_types:delete:error:delete' => "Une erreur inconnue est survenue lors de la suppression du type de profil personnalisé",
  'profile_manager:action:profile_types:delete:succes' => "Le type de profil personnalisé a bien été supprimée",
  
  // Custom Group Fields
  'profile_manager:group_fields' => "Modifier les champs de profil des groupes",
  'profile_manager:group_fields:title' => "Modifier les champs de profil des groupes",
  
  'profile_manager:group_fields:add:description' => "Vous pouvez modifier ici les champs qui vont s'afficher sur la page de profil des groupes",
  'profile_manager:group_fields:add:link' => "Ajouter un nouveau champ de profil de groupe",
  
  'profile_manager:profile_fields:add:description' => "Vous pouvez modifier ici les champs qu'un membre va pouvoir modifier sur son profil",
  'profile_manager:profile_fields:add:link' => "Ajouter un nouveau champ de profil",

  // Custom fields categories
  'profile_manager:categories:add:link' => "Ajouter une nouvelle catégorie",
  
  'profile_manager:categories:list:title' => "Catégories",
  'profile_manager:categories:list:default' => "Par défaut",
  'profile_manager:categories:list:view_all' => "Voir tous les champs",
  'profile_manager:categories:list:no_categories' => "Aucune catégorie définie",
  
  'profile_manager:categories:delete:confirm' => "Êtes-vous sûr de vouloir supprimer cette catégorie ?",
  
  // Custom Profile Types
  'profile_manager:profile_types:add:link' => "Ajouter un nouveau type de profil",
  
  'profile_manager:profile_types:list:title' => "Types de profil",
  'profile_manager:profile_types:list:no_types' => "aucun type de profil défini",

  'profile_manager:profile_types:delete:confirm' => "Are you sure you wish to delete this profile type?",
  
  // Export
  'profile_manager:actions:export' => "Exporter les données du profil",
  'profile_manager:actions:export:description' => "Exporter les données du profil dans un fichier CSV",
  'profile_manager:export:title' => "Exporter les données du profil",
  'profile_manager:export:description:custom_profile_field' => "Cette fonctionnalité va exporter toutes les données <b>des utilisateurs</b> sur la base des champs sélectionnés.",
  'profile_manager:export:description:custom_group_field' => "Cette fonctionnalité va exporter toutes les données <b>des groupes</b> sur la base des champs sélectionnés.",
  'profile_manager:export:list:title' => "Sélectionnez les champs à exporter",
  'profile_manager:export:nofields' => "Aucun champ de profil personnalisé disponible pour l'exportation",

  // Configuration Backup and Restore
  'profile_manager:actions:configuration:backup' => "Sauvegarder la configuration des champs",
  'profile_manager:actions:configuration:backup:description' => "Sauvegarder la configuration de ces champs (<b>les catégories et types ne sont pas sauvegardés</b>)",
  //
  'profile_manager:actions:configuration:restore' => "Restaurer la configuration des champs",
  'profile_manager:actions:configuration:restore:description' => "Restaurer un fichier de configuration précédemment enregistré (<b>toutes les relations entre champs et catégories seront perdues</b>)",
  //
  'profile_manager:actions:configuration:restore:upload' => "Restauration",
  //
  'profile_manager:actions:restore:success' => "Restauration effectuée",
  'profile_manager:actions:restore:error:deleting' => "Erreur lors de la restauration : impossible de supprimer les champs actuels",	
  'profile_manager:actions:restore:error:fieldtype' => "Erreur lors de la restauration : les types de champs ne correspondent pas",
  'profile_manager:actions:restore:error:corrupt' => "Erreur lors de la restauration : le fichier de sauvegarde semble corrompu ou les informations sont manquantes",
  'profile_manager:actions:restore:error:json' => "Erreur lors de la restauration : fichier json invalide",
  'profile_manager:actions:restore:error:nofile' => "Erreur lors de la restauration : aucun fichier envoyé",
  // Tooltips
  'profile_manager:tooltips:profile_field' => "<b>Champ de profil</b><br />
    Vous pouvez ajouter ici un nouveau champ de profil.<br /><br />
    Si vous laissez le label vide, vous pouvez internationaliser le label du champ de profil (<i>profile:[name]</i>).<br /><br />
    Les options ne sont obligatoires que pour les types de champ <i>Liste déroulante, Boutons radio et Liste à choix multiples</i>.",
  //
  'profile_manager:tooltips:profile_field_additional' => "<b>Montrer lors de l'inscription</b><br />
    Si vous souhaitez afficher ce champ sur le formulaire d'inscription.<br /><br />
    
    <b>Obligatoire</b><br />
    Si vous souhaitez rendre ce champ obligatoire (ne s'applique qu'à l'inscription).<br /><br />
    
    <b>Modifiable par les membres</b><br />
    Si 'Non', les membres ne peuvent pas modifier ce champ (pratique lorsque les donées sont gérées via un système externe).<br /><br />
    
    <b>Afficher en tant que tags</b><br />
    Les données affichées seront gérées comme des tags (ne s'applique qu'aux champs de profil de membre).<br /><br />
    
    <b>Champs administrateur seulement</b><br />
    Si 'Oui' le champ n'est disponible que pour les administrateurs.",
  //
  'profile_manager:tooltips:category' => "<b>Catégorie</b><br />
    Vous pouvez ajouter de nouvelles catégories de profils.<br /><br />
    Si vous laissez le 'label' vide, vous pouvez internationaliser le label de la catégorie (<i>profile:categories:[name]</i>).<br /><br />
    
    Si les types de profils sont définis vous pouvez choisir sur quels types de profils cette catégorie s'applique. Si aucun type de profil n'est précisé, la catégorie s'applique à tous les types de profils (même non définis).",
  //
  'profile_manager:tooltips:category_list' => "<b>Catégories</b><br />
    Affiche une liste de toutes les catégories configurées.<br /><br />
    
    <i>Par défaut</i> est la catégorie qui s'applique à tous les profils.<br /><br />
    
    Ajouter des champs à ces catégories en les glissant sur les catégories.<br /><br />
    
    Cliquer sur le lable de la catégorie pout filtrer  les champs visibles. Cliquer sur 'voir tous les champs' affiche tous les champs.<br /><br />
    
    Vous pouvez modifier l'ordre des catégories en les faisant glisser (<i>La catégorie par défaut ne peut être déplacée de la sorte</i>. <br /><br />
    
    Clqiuer sur l'icône d'édition pour modifier la catégorie.",
  //
  'profile_manager:tooltips:profile_type' => "<b>Champs de profil</b><br />
    Vous pouvez ajouter un nouveau type de profil.<br /><br />
    Si vous laissez le 'label' vide, vous pouvez internationaliser le label du type de profil (<i>profile:types:[name]</i>).<br /><br />
    Entrez une description que les utilisateurs pourront voir lorsqu'ils sélectionneront ce type de profil, ou laissez-la vide pour l'internationaliser (<i>profile:types:[name]:description</i>).<br /><br />
    Vous pouvez ajouter ce type de profil à la page des membres sous forme d'un onglet additionnel<br /><br />
    
    Si les catégories sont définies vous pouvez choisir quelles catégories s'appliquent à ce type de profil.",
  //
  'profile_manager:tooltips:profile_type_list' => "<b>Types de profil</b><br />
    Affiche une liste des types de profils configurés.<br /><br />
    Cliquez sur l'icône d'édition pour modifier le type de profil.",
  //
  'profile_manager:tooltips:actions' => "<b>Actions</b><br />
    Divers types d'actions liées à ces champs de profil.",
  // Edit profile => profile type selector
  'profile_manager:profile:edit:custom_profile_type:label' => "Sélectionnez votre type de profil",
  'profile_manager:profile:edit:custom_profile_type:description' => "Description du type de profil sélectionné",
  'profile_manager:profile:edit:custom_profile_type:default' => "Par défaut",
  // Admin Stats
  'profile_manager:admin_stats:title'=> "Statistiques du gestionnaire de profil",
  'profile_manager:admin_stats:total'=> "Nombre total de membres",
  'profile_manager:admin_stats:profile_types'=> "Nombre de membres avec le type de profil",
  // Members
  'profile_manager:members:menu' => "Membres",
  'profile_manager:members:submenu' => "Recherche de membres",
  'profile_manager:members:searchform:title' => "Annuaire du réseau",
  'profile_manager:members:searchform:simple:title' => "Recherche simple",
  'profile_manager:members:searchform:advanced:title' => "Recherche avancée",
  'profile_manager:members:searchform:sorting' => "Ordre de tri",
  'profile_manager:members:searchform:date:from' => "de",
  'profile_manager:members:searchform:date:to' => "à",
  'profile_manager:members:searchresults:title' => "Résultats",
  'profile_manager:members:searchresults:query' => "SQL query",
  'profile_manager:members:searchresults:noresults' => "Votre recherche n'a retourné aucun résultat",
  'profile_manager:members:searchform:limit' => "par page",
//
//
/* #########################################################################
MOD : profile_up */
//
//
/* #########################################################################
MOD : recentdiscussions */
   'recentdiscussions:title' => "Discussions (forums)",
   'recentdiscussions:widget:description' => "Affiche les derniers sujets de discussion que vous avez créés dans le forum des groupes",
//
//
/* #########################################################################
MOD : reportedcontent
Menu items and titles
*/
    'item:object:reported_content' => 'Eléments signalés',
    'reportedcontent' => 'Contenu signalé',
    'reportedcontent:this' => 'Signaler un contenu litigieux',
    'reportedcontent:none' => "Il n'y a pas de contenu signalé",
    'reportedcontent:report' => "Signaler à l'administrateur",
    'reportedcontent:title' => 'Titre de la page',
    'reportedcontent:deleted' => 'Le contenu signalé a été effacé',
    'reportedcontent:notdeleted' => "Il a été impossible d'effacer ce signalement",
    'reportedcontent:delete' => "L'effacer",
    'reportedcontent:areyousure' => "Etes-vous sûr de vouloir l'effacer ?",
    'reportedcontent:archive' => "L'archiver",
    'reportedcontent:archived' => 'Le signalement a bien été archivé',
    'reportedcontent:visit' => "Visiter l'élément signalé",
    'reportedcontent:by' => 'Signalé par ',
    'reportedcontent:objecttitle' => "Titre de l'objet",
    'reportedcontent:objecturl' => "URL de l'objet",
    'reportedcontent:reason' => 'Motif du signalement',
    'reportedcontent:description' => 'Pourquoi souhaitez-vous signaler cette page ?',
    'reportedcontent:address' => "Emplacement de l'élément",
    'reportedcontent:success' => "Votre signalement a bien été envoyé à l'adminsitrateur du site",
    'reportedcontent:failing' => "Votre signalement n'a pu être envoyé",
    'reportedcontent:report' => 'Signaler un contenu litigieux', 
    'reportedcontent:moreinfo' => "Plus d'information",
    'reportedcontent:failed' => 'Désolé, la tentative de signaler ce contenu a échoué.',
    'reportedcontent:notarchived' => "Il a été impossible d'archiver ce signalement",
//
//
/* #########################################################################
MOD : riverdashboard */
  'mine' => 'Moi',
  'filter' => 'Filtre',
  'riverdashboard:useasdashboard' => "Remplacer le tableau de bord par défaut avec ce flux (rivière..) d'activité ?",
  'activity' => 'Activité',
    /* Site messages */
  'sitemessages:announcements' => "Annonces du site",
  'sitemessages:posted' => "Posté",
  'sitemessages:river:created' => "L'administrateur du site, %s,",
  'sitemessages:river:create' => "a publié un nouveau message pour l'ensemble du site",
  'sitemessages:add' => "Ajouter un message pour l'ensemble du site sur le flux d'activité",
  'sitemessage:deleted' => "Message du site effacé",
  'river:widget:noactivity' => 'Aucune activité trouvée.',
  'river:widget:title' => "Fil d'Activité",
  'river:widget:description' => "Montrer vos activités les plus récentes.",
  'river:widget:title:friends' => "Activité de vos Contacts",
  'river:widget:description:friends' => "Montrer ce que font vos contacts.",
  'river:widgets:friends' => "Contacts",
  'river:widgets:mine' => "Moi",
  'river:widget:label:displaynum' => "Nombre d'entrées à afficher:",
  'river:widget:type' => "Quel flux d'activité souhaitez-vous afficher ? Celui qui montre votre activité, ou celui qui montre celle de vos contacts ?",
  'item:object:sitemessage' => "Messages du site",
//
//
/* #########################################################################
MOD : riverlinks */
//
//
/* #########################################################################
MOD : searchcloud */
  'searchcloud' => "Nuage des recherches",
  'searchcloud:title' => "Nuage des recherches",
  'searchcloud:reset' => "Réinitialiser les statistiques de recherche",
  'searchcloud:reset:success' => "Réinitialisation des statistiques effectuée",
  'searchcloud:reset:error' => "La réinitialisation des statistiques a échoué",
//
//
/* #########################################################################
MOD : simplepie */
    'simplepie:widget' => 'Syndication',
    'simplepie:description' => 'Ajouter un flux à votre page (syndication)',
    'simplepie:notset' => "L'adresse du flux n'est pas définie",
    'simplepie:notfind' => 'Impossible de trouver le flux. Veuillez vérifier son adresse.',
    'simplepie:feed_url' => 'URL du flux',
    'simplepie:num_items' => "Nombre d'éléments à afficher",
    'simplepie:excerpt' => 'Inclure un extrait',	
    'simplepie:post_date' => 'Inclure la date',
//
//
/* #########################################################################
MOD : siteaccess */
  'siteaccess:usesiteaccesskey' => "Requérir le mot de passe du site pour s'enregistrer ?",
  'siteaccess:usesiteaccessemail' => "Autoriser l'activation du compte par mail ?",
  'siteaccess:usesiteaccesscoppa' => "Requérir un captcha pour s'enregistrer ?",
  'siteaccess:invitecode' => "Requérir une invitation pour s'enregistrer ?",
  'siteaccess:key:enter' => "Veuillez saisir le mot de passe d'accès au site",
  'siteaccess:key:invalid' => "Le mot de passe d'accès au site est invalide !",
  'siteaccess:admin:links' => "Activer",
  'siteaccess:admin:menu' => "Accès au site",
  'siteaccess:admin:validate:success' => "Le compte utilisateur a bien été activé !",
  'siteaccess:admin:validate:error' => "Echec d'activation du compte utilisateur",
  'siteaccess:list:templates' => "Modèles des mail",
  'siteaccess:list:header' => "Sélectionnez quels utilisateurs visualiser :",
  'siteaccess:list:activate' => "Utilisateurs en attente d'activation",
  'siteaccess:list:validate' => "Mails non validés",
  'siteaccess:list:banned' => "Utilisateurs désactivés/bannis",
  'siteaccess:email:default' => "Rétablir aux valeurs par défaut",
  'siteaccess:email:valid:macros' => "Macros de mail possibles",
  'siteaccess:email:delete:success' => "Le mail a bien été supprimé !",
  'siteaccess:email:delete:fail' => "Echec de la suppression du mail !",
  'siteaccess:email:update:success' => "Mail mis à jour !",
  'siteaccess:email:update:fail' => "Echec de la mise à jour du mail !", 
  'siteaccess:email:label:subject' => "Sujet:",
  'siteaccess:email:label:content' => "Contenu :",
  'siteaccess:email:label:adminactivated' => "Mail activé par l'administrateur", 
  'siteaccess:email:label:confirmed' => "Confirmation par mail",
  'siteaccess:email:label:validated' => "Validation par mail",
  'siteaccess:email:label:notifyadmin' => "Admin Notification Email", 

  'siteaccess:email:adminactivated:subject' => "[%site_name%] L'administrateur a activé le compte de %username%!",
  'siteaccess:email:adminactivated:content' => "Bonjour %name%,

Félicitations, votre compte a été activé par l'administrateur du site. Vous pouvez maintenant vous connecter au site %site_url%",
  'siteaccess:email:confirm:subject' => "[%site_name%] %username%, veuillez confirmer votre adresse mail !",
  'siteaccess:email:confirm:content' => "Bonjour %name%,

Veuillez confirmer votre adresse mail en cliquant sur le lien ci-dessous :

%confirm_url%",
  'siteaccess:email:validated:subject' => "[%site_name%] Email de %username% validé !",
  'siteaccess:email:validated:content' => "Bonjour %name%,

Félicitations, vous avez bien validé votre adresse mail. 

%site_url%",
  'siteaccess:confirm:success' => "Vous avez bien confirmé votre adresse mail !",
  'siteaccess:confirm:fail' => "Votre adresse mail n'a pas pu être vérifiée...",
  'siteaccess:authorize' => "Ce site nécessite que l'administrateur valide votre compte !",
  'siteaccess:confirm:email' => "Veuillez confirmer votre adresse mail en cliquant sur le lien qui vient de vous être envoyé.",
  'siteaccess:email:validated' => "Validé",
  'siteaccess:email:notvalidated' => "Non validé",
  'siteaccess:coppa:text' => "J'ai au moins 13 ans",
  'siteaccess:coppa:fail' => "Vous devez avoir au moins 13 ans pour vous enregistrer sur ce site",
  'siteaccess:code:invalid' => "Code de sécurité saisi invalide !",
  'siteaccess:email:notifyadmin:subject' => "[%site_name%] Vous avez des utilisateurs en attente d'activation de compte",
  'siteaccess:email:notifyadmin:content' => "Bonjour %name%,

Des utilisateurs attendent que vous validiez leur inscription, ou ont encore besoin d'une validation par mail

%admin_url%",
  'siteaccess:notify' => "Nom de l'utilisateur à prévenir lorsqu'il y a de nouveaux utilisateurs dans la file d'attente d'activation de compte ? (préciser la fréquence)",
  'siteaccess:hourly' => "horaire",
  'siteaccess:daily' => "quotidien",
  'siteaccess:weekly' => "hebdomadaire",
  'siteaccess:monthly' => "mensuel",
  'siteaccess:invitecode:invalid' => "Enregistrement par invitation seulement",
  'siteaccess:invitecode:info' => "Nécessite le plugin 'invitefriends'",
  'siteaccess:walledgarden' => "Activer le Walledgarden?",
  'siteaccess:walledgarden:allow' => "Vous devez être connecté pour accéder à cette page !",
  'siteaccess:invited' => "Cet utilisateur a été invité par",
  'siteaccess:invitedbyuser' => "Utilisateurs invités par",
  'siteaccess:invitedusers' => "Voir les utilisateurs invités",
  'siteaccess:river:join' => "%s a rejoint le réseau",
  'siteaccess:river:activate' => "%s a activé son compte",
  'siteaccess:river:admin' => "Le compte a été activé %s",
  'siteaccess:useriver' => "Envoyer les invitations vers le flux d'activité ?",
  'siteaccess:walledgarden:debug' => "Activer le mode de débuggage du Walledgarden?",
  'siteaccess:walledgarden:options' => "Options du Walledgarden",
  'siteaccess:notify:options' => "Options de notification",
  'siteaccess:found' => "Utilisateurs trouvés",
  'siteaccess:reg:options' => "Options d'enregistrement",
  'siteaccess:autoactivate' => "Auto-activer le compte ? (ne force pas la validation par mail)",
  'siteaccess:accesslist' => "Liste de contrôle d'accès aux pages pour le walledgarden, une page par ligne",
//
//
/* #########################################################################
MOD : tabbeddashboard */
      "tabbed_dashboard:page:name" => "Page name:",
      "tabbed_dashboard:addtab:title" => "Add page to %s",
      "tabbed_dashboard:removetab:title" => "Delete page '%s'",
      "tabbed_dashboard:defaultnewtabname" => "New page",
      "tabbed_dashboard:maxtabsexceeded" => "Unable to create a new page, the maximum number of pages is %s!",
      "tabbed_dashboard:add:char" => " ",
      "tabbed_dashboard:add:unable" => "Unable to add new page '%s'!",
      "tabbed_dashboard:added" => "Added new page '%s'",
      "tabbed_dashboard:delete:char" => "x",
      "tabbed_dashboard:deleted" => "Deleted page '%s'",
      "tabbed_dashboard:delete:unable" => "Unable to delete page '%s', please try again!",
      "tabbed_dashboard:delete:notallowed" => "You do not have permission to delete the page!",
      "tabbed_dashboard:currenttab:title" => "Selected page, click 'Edit page' to rename",
      "tabbed_dashboard:changed" => "Changed page '%s'",
      "tabbed_dashboard:change:unable" => "Unable to change page, please try again!",
      "tabbed_dashboard:change:notallowed" => "You do not have permission to change the page!",
      "tabbed_dashboard:rename:blank" => "<b>You cannot specify a blank page name, please try again!</b>",
      "tabbed_dashboard:othertab:title" => "%s %s page",
      "tabbed_dashboard:move:left:char" => "<",
      "tabbed_dashboard:move:left" => "Move page '%s' tab left",
      "tabbed_dashboard:moved:left" => "Moved page '%s' tab left",
      "tabbed_dashboard:move:right:unable" => "Unable to move page '%s' tab left!",
      "tabbed_dashboard:move:right:char" => ">",
      "tabbed_dashboard:move:right" => "Move page '%s' tab right",
      "tabbed_dashboard:move:right:unable" => "Unable to move page '%s' tab right!",
      "tabbed_dashboard:moved:right" => "Moved page '%s' tab right",
      "tabbed_dashboard:move:notallowed" => "You do not have permission to move the page tab!",
      "tabbed_dashboard:dashboard:settings:tabs:maximum" => "Maximum number of dashboard pages",
      "tabbed_dashboard:profile:settings:tabs:maximum" => "Maximum number of profile pages",
      "tabbed_dashboard:settings:note" => "<b>Reducing the number of pages will NOT delete existing pages!</b>",
      "item:object:dashboard_widget_tab" => "Dashboard tab settings",
//
//
/* #########################################################################
MOD : tagcloud */
  'tagcloud:widget:title' => 'Tag Cloud',
  'tagcloud:widget:description' => 'Tag cloud',
  'tagcloud:widget:numtags' => 'Number of tags to show',
  'item:object' => 'Items',
  'advancedsearchtitle' => '%s with tags matching %s',
//
//
/* #########################################################################
MOD : thewire
Menu items and titles
*/
    'thewire' => "Micro-Statuts",
    'thewire:user' => "Statuts de %s",
    'thewire:posttitle' => "Notes de %s sur le Fil: %s",
    'thewire:everyone' => "Tous les statuts des membres",
    'thewire:read' => "Statuts",
    'thewire:strapline' => "%s",
    'thewire:add' => "Publier mon statut",
    'thewire:text' => "Statut",
    'thewire:reply' => "Répondre",
    'thewire:update' => "Modifier mon statut",
    'thewire:via' => "via",
    'thewire:wired' => "Statut mis à jour",
    'thewire:charleft' => "caractères restant",
    'item:object:thewire' => "Statuts des membres",
    'thewire:notedeleted' => "Statut effacé",
    'thewire:doing' => "Que faites-vous ? Mettez à jour votre statut !",
    'thewire:newpost' => 'Nouveau statut',
    'thewire:addpost' => 'Modifier mon statut',
      /* The wire river */
        //generic terms to use
        'thewire:river:created' => "%s a écrit",
        //these get inserted into the river links to take the user to the entity
        'thewire:river:create' => "sur son statut.",
    /* Wire widget */
        'thewire:sitedesc' => 'Ce widget affiche les derniers statuts mis à jour',
        'thewire:yourdesc' => 'Ce widget affiche vos derniers statuts',
        'thewire:friendsdesc' => 'Ce widget affiche les derniers statuts de vos contacts',
        'thewire:friends' => 'Les statuts de vos contacts',
        'thewire:num' => "Nombre d'éléments à afficher",
  /* Status messages */
    'thewire:posted' => "Votre statut a bien été mis à jour.",
    'thewire:deleted' => "Votre statut a bien été supprimé.",
  /* Error messages */
    'thewire:blank' => "Désolé, vous devez d'abord écrire un message avant de l'enregistrer.",
    'thewire:notfound' => "Désolé, le message spécifié n'a pas pu être trouvé.",
    'thewire:notdeleted' => "Désolé, ce statut n'a pas pu être effacé.",
  /* Settings */
    'thewire:smsnumber' => "Votre numéro SMS, s'il est différent de celui de votre téléphone portable (le numéro de téléphone doit être 'Public' pour que le Fil puisse l'utiliser). Tous les numéros de téléphone doivent être écrits au format international.",
    'thewire:channelsms' => "Le numéro auquel envoyer des SMS est le <b>%s</b>",
//
//
/* #########################################################################
MOD : tinymce */
    'tinymce:remove' => "Activer/Désactiver l'éditeur visuel (passer en mode HTML)",
//
//
/* #########################################################################
MOD : twitter
twitter widget details
*/
  'twitter:username' => "Votre nom d'utilisateur Twitter.",
  'twitter:num' => 'Nombre de tweets à afficher.',
  'twitter:visit' => 'visitez mon compte',
  'twitter:notset' => "Ce module Twitter n'est pas encore configuré. Pour afficher vos derniers tweets, cliquez sur - éditer - et complétez les informations demandées",
   /* twitter widget river */
        //generic terms to use
        'twitter:river:created' => "%s a ajouté le widget twitter.",
        'twitter:river:updated' => "%s a mis à jour son widget twitter.",
        'twitter:river:delete' => "%s a supprimé son widget twitter.",
//
//
/* #########################################################################
MOD : twitterservice */
  'twitterservice' => 'Service Twitter',
  'twitterservice:postwire' => "Voulez-vous poster vos messages publics de 'The Wire' (le Fil) vers Twitter ?",
  'twitterservice:twittername' => "Nom d'utilisateur Twitter",
  'twitterservice:twitterpass' => "Mot de passe Twitter",
//
//
/* #########################################################################
MOD : uservalidationbyemail */
  'email:validate:subject' => "%s, confirmez votre demande de création de compte sur la Plateforme collaborative",
  'email:validate:body' => "Bonjour %s,

Veuillez confirmer votre demande de création de compte sur la Plateforme collaborative en cliquant sur le lien suivant :

%s",
  'email:validate:success:subject' => "Compte %s créé !",
  'email:validate:success:body' => "Bonjour %s,
    
Félicitations, votre compte a bien été créé.

Il devra toutefois être examiné et validé par un administrateur avant que vous puissiez l'utiliser : vous serez prévenu(e) par mail lorsque cela aura été fait.",
  'email:confirm:success' => "Votre compte a bien été créé. Il devra toutefois être examiné par un administrateur avant que vous puissiez l'utiliser.",
  'email:confirm:fail' => "Votre adresse de courriel n'a pas pu être vérifiée...",
  'uservalidationbyemail:registerok' => "Pour confirmer votre demande de création de compte, veuillez cliquer sur sur le lien qui vient de vous être envoyé par mail (si vous ne recevez rien, veuillez vérifier votre dossier Spam).",
//
//
/* #########################################################################
MOD : welcomer */
 'welcomer:message:edit'  =>  "Edition du message de prochaine connexion" , 
 'welcomer:welcome:edit'  =>  "Edition du message de première connexion" , 
 'welcomer:switcher'  =>  "Page de contrôle" , 
 'welcomer:validate:message'  =>  "Vérifier votre message" , 
 'welcomer:validate:select_check'  =>  "Ajouter une boite de validation obligatoire" , 
 'welcomer:message:editmessage'  =>  "Editer le message de prochaine connexion" , 
 'welcomer:submit'  =>  "Continuer" , 
 'welcomer:welcome:editmessage'  =>  "Editer le message de première connexion" , 
 'welcomer:message:switchmessage'  =>  "Activer / Désactiver les messages de connexion " , 
 'welcomer:message:on'  =>  "Le message de prochaine connexion est ACTIVE " , 
 'welcomer:message:desactivate'  =>  "Désactiver" , 
 'welcomer:message:off'  =>  "Le message de prochaine connexion est DESACTIVE " , 
 'welcomer:message:activate'  =>  "Activer" , 
 'welcomer:welcome:on'  =>  "Le message de première connexion est ACTIVE " , 
 'welcomer:desactivate'  =>  "Désactiver" , 
 'welcomer:welcome:off'  =>  "Le message de première connexion est DESACTIVE " , 
 'welcomer:activate'  =>  "Activer" , 
 'welcomer:message:check_message'  =>  "J'ai lu et je suis d'accord" , 
 'welcomer:validate:message:ok'  =>  "Le message de prochaine connexion a été activé" , 
 'welcomer:validate:welcome:ok'  =>  "Le message de première connexion a été activé" , 
 'welcomer:message:save_ok'  =>  "Le brouillon de message a été sauvegarder. Vous devez l'activer pour le mettre en service" , 
 'welcomer:welcome:save_ok'  =>  "Le brouillon de message a été sauvegarder. Vous devez l'activer pour le mettre en service" , 
 'welcomer:message:desactivate_ok'  =>  "La fonction de message de prochaine connexion a été désactivée" , 
 'welcomer:message:activate_ok'  =>  "La fonction de message de prochaine connexion a été activée" , 
 'welcomer:welcome:desactivate_ok'  =>  "La fonction de message de première connexion a été désactivée" , 
 'welcomer:welcome:activate_ok'  =>  "La fonction de message de première connexion a été activée" , 
 'welcomer:mandatory:message'  =>  "Vous devez obligatoirement valider le message" , 
 'welcomer:menu:welcome:switch'  =>  "Page de contrôle" , 
 'welcomer:menu:welcome:edit'  =>  "Première connexion -> Editer" , 
 'welcomer:menu:welcome:activate'  =>  "Première connexion -> Activer" , 
 'welcomer:menu:welcome:view'  =>  "Première connexion -> Voir" , 
 'welcomer:menu:message:edit'  =>  "Prochaine connexion -> Editer" , 
 'welcomer:menu:message:activate'  =>  "Prochaine connexion -> Activer" , 
 'welcomer:menu:message:view'  =>  "Prochaine connexion -> Voir" , 
 'welcomer:modifier'  =>  "modifier" , 
 'welcomer:valider'  =>  "valider" , 
 'welcomer:admin:menu'  =>  "Gestion du welcomer",
 'welcomer:message:about' => "Vous pouvez activer / désactiver les messages du welcomer
 <ul><li>Le message de prochaine connexion s'affichera lors de la prochaine connexion des membres</li><li>Le message de première connexion s'affichera lors de la première connexion d'un membre</li></ul>",
//
//
/* #########################################################################
MOD : wikilinks
Email messages
*/
    // Messageboard
    'groupemailer:email:messageboard:subject' => 'A new message to group %s',
    'groupemailer:email:messageboard:body' => "%s wrote a new message to group's messageboard. It reads:

    
%s


To view group, click here: %s


Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",
    // Forum
    'groupemailer:email:forum:subject' => 'A new message to group %s',
          'groupemailer:email:forum:body' => "%s wrote a new message to group's discussion forum. It reads:
    
          
%s
    
    
To view or reply to message, click here: %s
    
    
Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",
    // Page
    'groupemailer:email:page:subject' => 'A new page to group %s',
    'groupemailer:email:page:body' => "%s wrote a new page called %s.
    
    
To read the page, click here: %s
    

Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",
    // Comment
    'groupemailer:email:comment:subject' => 'A new comment to group %s',
    'groupemailer:email:comment:body' => "%s wrote a new comment to group %s. It reads:
    
          
%s
    
    
To read the commented item and the comment, click here: %s


Note : en cas de difficulté pour accéder au site, veuillez vérifier que vous êtes bien connecté.

___________________________
Mail envoyé automatiquement, merci de ne pas y répondre.",
  /* Error messages */
    'messageboard:blank' => "Sorry; you need to actually put something in the message area before we can save it.",
    'messageboard:notfound' => "Sorry; we could not find the specified item.",
    'messageboard:notdeleted' => "Sorry; we could not delete this message.",
    'messageboard:failure' => "An unexpected error occurred when adding your message. Please try again.",
//
//
/* #########################################################################
* Divers éléments ajoutés
*/
  'multipublisher:comments' => "Réactions",
  'multipublisher' => "Discussions",
  'multisite:access:collection' => 'Membres de ce site',
  //
  'removelocaladmin' => "Retirer les droits d'administrateur local",
  //
  'feedback:group' => "Feedback sur le site",
  'feedback:river:annotate' => "un commentaire sur le feedback",
  'feedback:enablefeedback' => "Groupe de feeback ? (à désactiver sauf pour le groupe de feedback)",
  //
  'blog:enableblog' => "Activer le blog pour les groupes",
  'blog:group' => "Blog du groupe",
  //
  'file:untitled' => "(fichier sans titre)",
  //
  'bookmarks:this:group' => "Ajouter dans %s",
  'bookmarks:bookmarklet:group' => "Récupérer le bookmarklet",
  'bookmarks:group' => "Marque-pages du groupe",
  'bookmarks:enablebookmarks' => "Activer les marque-pages pour les groupes",
  //
  'members:search' => "Rechercher une personne",
  'members:label:newest' => "Derniers inscrits",
  'members:label:popular' => "Par nombre de contacts",
  'members:label:active' => "Connectés en ce moment",
  'members:friends' => 'Mes contacts',
  'members:searchresult' => "Recherche",
  'members:newest' => "Tous les membres",
  'members:popular' => "Par nombre de contacts",
  //
  'groups:visibility' => 'Visibilité (qui peut voir ce groupe ?)',
  //
  'item:object:multipublisher_comment' => "Réactions",
  'item:user:openid' => "Comptes OpenID",
  'item:object:openid_client::nonce' => "Clients OpenID actuels",
  'item:object:community_plugin' => "Objet 'community_plugin'",
  'item:object:openid_client::association' => "associations OpenID",
  'item:object:invitation' => "Invitations",
  'item:object:siteaccess_email' => "Emails siteaccess",
  'item:object:privacy' => "Page 'Informations personnelles'",
  'item:object:about' => "Page 'A propos'",
  'item:object:form:config' => "Configuration du formulaire",
  'item:object:status' => "Statuts",
  'item:object:form:form' => "Formulaire",
  'item:object:form:field_map' => "Champ 'carte' de formulaire",
  'item:object:form:field' => "Champ de formulaire",
  'item:object:terms' => "Page 'Mentions légales'",
  //
  'event_calendar:upcomingevents' => "Agenda",
  //
  'profile_manager:members:profile_type:no_users' => "Aucun membre",
  'profile:custom_profile_type' => "Type de profil",
  'groups:Email' => "Mail de contact",
//
//
);
//
add_translation("fr",$french);

