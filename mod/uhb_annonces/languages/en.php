<?php
// @TODO : translate into English if you wish to use it for real !
// Note : you may want to use translation tools on dev server to facilitate translation

return array(
	'uhb_annonces' => "Job and Training",
	'item:object:uhb_offer' => "Job and Training Offers",

	/* @TODO : translate into English !
	'uhb_annonces:home' => "Accueil",
	'uhb_annonces:title' => "Offres de stage et d'emploi",
	'uhb_annonces:admin:title' => "Administration des offres",
	'uhb_annonces:admin:warning' => "Attention ! ces actions d'administration sont à utiliser avec précaution !",
	'uhb_annonces:search' => "Rechercher une offre",
	'uhb_annonces:login' => 'Connectez-vous ou créez votre profil',
	'uhb_annonces:results:actions' => "Actions",
	'uhb_annonces:results:view' => "Afficher",
	'uhb_annonces:results:edit' => "Modifier",
	'uhb_annonces:list' => "Liste",
	'uhb_annonces:add' => "Déposer une offre",
	'uhb_annonces:edit' => "Modification de l'offre",
	'uhb_annonces:view' => "Offre n°%s %s : %s",
	'uhb_annonces:view:emploi' => "Offre d'emploi n° %s (%s) : %s",
	'uhb_annonces:view:emploi:notype' => "Offre d'emploi n°%s : %s",
	'uhb_annonces:view:stage' => "Offre de stage n°%s : %s",
	'uhb_annonces:apply' => "Candidature - %s",
	'uhb_annonces:save:success' => "Votre offre a bien été enregistrée.",
	'uhb_annonces:error:missingrequired' => "Attention, des champs requis n'ont pas été renseignés ou contiennent des données incorrectes.<br />Veuillez vérifier et compléter les champs suivants avant de valider votre annonce :",
	'uhb_annonces:error:invalidemail' => "L'adresse email indiquée n'est pas une adresse email valide.",
	'uhb_annonces:error:emailmatch' => "Les adresses emails fournies ne correspondent pas, veuillez vérifier que vous avez bien saisi les mêmes adresses email.",
	'uhb_annonces:mustrevalidate' => "L'adresse email de contact a été modifiée, vous devez confirmer de nouveau votre adresse email.",
	'uhb_annonces:updated:mustconfirm' => "L'annonce a été modifiée, elle doit être de nouveau examinée avant d'être publiée.",
	'uhb_annonces:error:cannotsave' => "Une erreur s'est produite lors de l'enregistrement de votre offre, veuillez réessayer.",
	'uhb_annonces:error:unauthorised' => "Vous n'avez pas accès à cette page.",
	'uhb_annonces:error:unauthorisedip' => "L'accès aux offres est réservé aux étudiants de l'université. Veuillez vous connecter ou utiliser un poste connecté au réseau de l'université.",
	'uhb_annonces:error:unauthorisedview' => "L'accès aux offres est réservé aux étudiants de l'université. Veuillez vous connecter avec votre compte utilisateur, ou utiliser un poste connecté au réseau de l'université.",
	'uhb_annonces:error:unauthorisedsearch' => "La recherche d'offres est réservée aux étudiants de l'université. Veuillez vous connecter avec votre compte utilisateur, ou utiliser un poste connecté au réseau de l'université.",
	'uhb_annonces:error:unauthorisededit' => "L'édition des offres est réservée aux personnes ayant déposé cette offre. Pour modifier votre annonce, vous devez en être l'auteur, ou utiliser le lien d'édition qui vous a été envoyé par email.",
	'uhb_annonces:error:unauthorisedadmin' => "L'administration des offres est réservée aux personnels autorisés.",
	'uhb_annonces:error:invalidkey' => "Clef d'édition inconnue, veuillez vérifier que vous utilisez le bon lien d'édition. Si vous disposez d'un compte, veuillez vous connecter pour modifier vos offres.",
	'uhb_annonces:error:noentity' => "Offre inexistante ou archivée.",
	'uhb_annonces:error:unpublished' => "Cette offre n'existe pas ou n'a pas encore été validée. Si vous avez créé cette offre, veuillez utiliser le lien qui vous a été transmis par email.",
	'uhb_annonces:error:filled' => "Cette offre a déjà été pourvue et n'est plus accessible.",
	'uhb_annonces:error:archive' => "Cette offre a été archivée et n'est plus accessible.",
	'uhb_annonces:error:noaccess' => "Cette offre n'est pas ou plus disponible.",
	'uhb_annonces:error:missingattachment' => "Pièce jointe manquante.",
	
	
	// Accueil
	'uhb_annonces:basicstat' => "Actuellement : %s offre(s) d'emploi ou de stage en cours de recrutement et %s annonce(s) pourvue(s) ou archivée(s).",
	'uhb_annonces:admin:title' => "Administration des annonces",
	'uhb_annonces:role:admin:details' => "Vous êtes un administrateur du système d'annonce.",
	'uhb_annonces:role:title' => "Votre rôle : %s",
	'uhb_annonces:role:admin' => "Administrateur des annonces",
	'uhb_annonces:role:staff' => "Personnels de l'université",
	'uhb_annonces:role:student' => "Etudiant(e)",
	'uhb_annonces:role:doctorat' => "Doctorant(e) à Rennes 2",
	'uhb_annonces:role:pro' => "Professionnel(le)",
	'uhb_annonces:role:member' => "Membre du site",
	'uhb_annonces:role:public' => "Visiteur non connecté",
	'uhb_annonces:role:user' => "Membre non qualifié",
	'uhb_annonces:role:other' => "Autre",
	'uhb_annonces:offre:create' => "Employeur : %s",
	'uhb_annonces:offre:create:link' => "déposez une annonce",
	'uhb_annonces:offre:searchorreply' => "Candidats : %s aux annonces",
	'uhb_annonces:offre:searchorreply:link' => "cherchez et postulez",
	'uhb_annonces:disclaimer' => "L'accès au catalogue des offres est réservé aux étudiants et anciens étudiants de l'université Rennes 2, avec un compte dans le réseau social RESONANCES.",
	'uhb_annonces:unpublished:link' => "%s annonce(s) à valider pour publication",
	'uhb_annonces:unpublished' => "Vous avez %s.",
	'uhb_annonces:unpublished:warning:link' => "%s annonce(s)",
	'uhb_annonces:unpublished:warning' => "%s sont restée(s) sans relecture et devrai(en)t être revue(s) en priorité.",
	'uhb_annonces:stats:title' => "Pour information il y a %s offres au total, dont :",
	'uhb_annonces:stats:initial' => "%s annonce(s) dans l'état \"initial\".",
	'uhb_annonces:stats:obsolete' => "%s annonce(s) obsolète(s) en cours de relance.",
	'uhb_annonces:stats:reportfilled' => "%s annonce(s) signalée(s) comme étant pourvue(s) par les membres du réseau.",
	'uhb_annonces:stats:filled' => "%s annonce(s) pourvue(s).",
	'uhb_annonces:stats:archive' => "%s annonce(s) archivée(s).",
	
	
	// Sidebar / widgets
	// Widget étudiant
	'uhb_annonces:sidebar:title' => "Emploi & Stage",
	'uhb_annonces:sidebar:add' => "Déposer une annonce",
	'uhb_annonces:sidebar:duplicate' => "Créer une nouvelle annonce à partir de celle-ci",
	'uhb_annonces:preload:message' => "Vos informations de contact ainsi que celles concernant votre structure ont été pré-chargées dans votre nouvelle annonce. Veuillez vérifier l'exactitude de ces informations, et renseigner la partie \"Offre et Profil\".",
	'uhb_annonces:sidebar:mypublished' => "Mes annonces déposées",
	'uhb_annonces:sidebar:search' => "Rechercher dans le catalogue des offres",
	'uhb_annonces:sidebar:edit' => "Modifier cette offre",
	'uhb_annonces:sidebar:edit:your' => "Modifier votre offre",
	'uhb_annonces:sidebar:memorised' => "Mes %s annonces retenues",
	'uhb_annonces:sidebar:candidated' => "Mes %s candidatures",
	// Widget annonce
	'uhb_annonces:sidebar:offer:title' => "A propos",
	'uhb_annonces:sidebar:offer:published' => "Publiée le %s",
	'uhb_annonces:sidebar:offer:notyetpublished' => "Pas encore publiée",
	'uhb_annonces:sidebar:offer:alreadypublished' => "Annonce actuellement non publiée, mais qui avait déjà été publiée le %s",
	'uhb_annonces:sidebar:offer:published:unknown' => "Date de publication inconnue",
	'uhb_annonces:sidebar:offer:remember' => "RETENIR CETTE ANNONCE",
	'uhb_annonces:sidebar:offer:dontremember' => "Ne plus retenir cette annonce",
	'uhb_annonces:sidebar:offer:apply' => "POSTULER",
	'uhb_annonces:sidebar:offer:hasapplied' => "J'ai déjà postulé",
	'uhb_annonces:sidebar:offer:candidate' => "Candidature",
	'uhb_annonces:sidebar:offer:report' => "Signaler comme étant pourvue",
	'uhb_annonces:sidebar:offer:unreport' => "Ne plus signaler comme étant pourvue",
	'uhb_annonces:report:error:account' => "Pour signaler une offre comme pourvue, vous devez disposer d'un compte.",
	'uhb_annonces:sidebar:offer:memorised' => "%s membre(s) ont retenu cette annonce",
	'uhb_annonces:sidebar:offer:candidated' => "%s membre(s) ont postulé",
	// Widget statistiques (admin)
	'uhb_annonces:sidebar:stats:title' => "Statistiques globales",
	'uhb_annonces:sidebar:stats:memorised' => "%s annonce(s) retenue(s)",
	'uhb_annonces:sidebar:stats:candidated' => "%s candidature(s) envoyée(s)",
	'uhb_annonces:sidebar:stats:reported' => "%s annonce(s) signalée(s) comme pourvue(s).",
	// Widget admin
	'uhb_annonces:sidebar:admin:title' => "Administration",
	'uhb_annonces:sidebar:resendconfirm' => "Renvoyer la confirmation d'email",
	'uhb_annonces:sidebar:validate' => "Forcer la validation d'email",
	'uhb_annonces:sidebar:publish' => "PUBLIER cette annonce",
	'uhb_annonces:sidebar:removereport' => "Effacer tous les signalements \"pourvue\"",
	'uhb_annonces:sidebar:archive' => "Déclarer l'annonce OBSOLETE",
	'uhb_annonces:sidebar:archive:details' => "Cette action retire une annonce obsolète ou devenue sans objet du catalogue. Attention, cette action est irréversible.",
	'uhb_annonces:sidebar:markfilled' => "Déclarer l'annonce POURVUE",
	'uhb_annonces:sidebar:markfilled:details' => "Cette action retire une annonce qui a été pourvue du catalogue. Attention, cette action est irréversible.",
	
	
	// Paramètres
	'uhb_annonces:settings:maxcount' => "Nombre maximum de résultats de recherche",
	'uhb_annonces:settings:maxcount:help' => "Les résultats au-delà de ce nombre ne seront pas affichés, avec une invitation à affiner les critères de recherche. Un nombre de 100 ou supérieur est recommandé.<br />Attention : en dessous de 50, il devient très probable que même avec des critères fins tous les résultats ne puissent pas être affichés.<br />Indiquer 0 pour aucune limite",
	'uhb_annonces:settings:maxcountadmin' => "Nombre maximum de résultats de recherche pour les administrateurs",
	'uhb_annonces:settings:maxcountadmin:help' => "Idem, mais ne concerne que les administrateurs : un nombre sensiblement plus élevé est recommandé, par exemple 500. Attention toutefois aux ressources utilisées dans le cas d'un très grand nombre de résultats.<br />Indiquer 0 pour aucune limite<br />Note : aucune limitation n'est appliquée pour l'export des données.",
	'uhb_annonces:settings:ipallowed' => "Plages d'IP autorisées pour la consultation publique des annonces",
	'uhb_annonces:settings:ipallowed:help' => "Ce réglage ne concerne que les accès à la consultation des annonces sans identification sur le site.<br />Indiquer les adresses IP autorisées sous la forme aaa.bbb.ccc.ddd. Il est possible de définir des plages d'adresses autorisées en utilisant les syntaxes suivantes (avec ou sans \".*\"): 127.*, 123.62.*, 123.6, etc. (mais pas : 123.6* ni 82.*.63 ).<br />Par soucis de performance, merci de lister en priorité les masques les plus génériques (127 avant 127.1.2.3)<br />Note : des masques d'adresses ipv6 peuvent également être spécifiés de la même manière.",
	'uhb_annonces:settings:adminlist' => "Gestion des membres autorisés à gérer les annonces",
	'uhb_annonces:settings:adminlist:help' => "Indiquez ci-dessous les GUID ou les identifiants des membres qui disposeront des droits d'administration des annonces.",
	'uhb_annonces:settings:whitelist' => "Liste blanche des types de membres autorisés à consulter les annonces",
	'uhb_annonces:settings:whitelist:help' => "Tous les types de membres peuvent déposer des annonces. L'accès à la recherche et à la consultation des annonces est réservée à certains types de profils. Lister ici les types de profils correspondant, par ex.: student, staff, doctorat<br />Note : les administrateurs des annonces sont toujours autorisés.",
	'uhb_annonces:settings:candidate_whitelist' => "Liste blanche des types de membres autorisés à postuler",
	'uhb_annonces:settings:candidate_whitelist:help' => "Lister ici les types de membres qui peuvent mémoriser une annonce, et postuler aux annonces. Il s'agit a priori d'une liste plus restreinte que pour la consultation, correspondant aux divers types de profils étudiants, par. ex.: student, doctorat<br />Note : les administrateurs des annonces sont toujours autorisés.",
	'uhb_annonces:settings:fieldsvalues' => "Champs disponibles dans les sélecteurs (édition des annonces)",
	'uhb_annonces:settings:searchfieldsvalues' => "Champs disponibles pour la recherche des annonces",
	'uhb_annonces:settings:fieldsvalues:help' => "Indiquer les clefs de traduction séparées par des virgules, par ex.: clef1, clef2, clef3, etc.<br />Ces clefs peuvent ensuite être traduites via les fichiers de traduction, en utilisant par ex.: <pre>'uhb_annonces:NOM_DU_CHAMP:clef1' =>  \"Traduction en français de la valeur Clef 1\",</pre>",
	'uhb_annonces:settings:searchfieldsvalues:help' => "Ces champs peuvent être les mêmes que pour l'édition, mais ils permettent aussi d'être différenciés et d'utiliser comme critère de recherche des valeurs qui ne sont plus disponibles pour la création de nouvelles annonces.",
	'uhb_annonces:settings:contact_email' => "Adresse email de contact",
	'uhb_annonces:settings:contact_email:help' => "Cette adresse est utilisée dans certaines notifications adressées aux annonceurs, et leur permet de contacter l'équipe d'administration des annonces par email.",
	'uhb_annonces:settings:debugmode' => "Mode debug",
	'uhb_annonces:settings:debugmode:details' => "Affiche diverses informations à l'écran (et quelques unes dans les logs) sur les temps d'exécution des éléments de la recherche, aux requêtes SQL utilisées ainsi qu'à la mémoire consommée.<br />NE PAS ACTIVER EN PRODUCTION !",
	'uhb_annonces:settings:memorylimit' => "Définition manuelle de memory_limit",
	'uhb_annonces:settings:memorylimit:details' => "Permet de définir le paramètre memory_limit du serveur. Laisser vide pour utiliser les paramètres par défaut, ou indiquer une valeur acceptable par ini_get, par ex. 256M, ou 2G. Value recommandée : vide, ou 256M si la mémoire n'est pas suffisante pour certaines recherches.<br />A n'utiliser que si ce paramètre ne peut pas être défini défini globalement via .htaccess.",
	
	
	// Recherche
	'uhb_annonces:search:emptytitle' => "(choisir) ",
	'uhb_annonces:search:count' => "La recherche a trouvé %s résultat(s).",
	'uhb_annonces:search:morethanmax' => "ATTENTION : D'autres annonces correspondent à votre recherche. L'affichage est limité à %s annonces : précisez d'autres critères pour votre recherche.",
	'uhb_annonces:search:structureprofile' => "Structure et profil",
	'uhb_annonces:search:timefilters' => "Filtrer par dates",
	'uhb_annonces:search:stats' => "Statistiques",
	'uhb_annonces:search:typeoffer' => "Type d'offre",
	'uhb_annonces:owner:anonymous' => "N'afficher que les annonces créées sans compte de membre",
	'uhb_annonces:search:offerposition' => "Intitulé",
	'uhb_annonces:search:profileformation' => "Formation",
	'uhb_annonces:search:profilelevel' => "Niveau requis",
	'uhb_annonces:search:structurename' => "Raison sociale",
	'uhb_annonces:search:structurecity' => "Ville",
	'uhb_annonces:search:worklength' => "Durée",
	'uhb_annonces:search:managervalidated' => "Mail validé",
	'uhb_annonces:search:followcreation' => "Création",
	'uhb_annonces:search:followvalidation' => "Publication",
	'uhb_annonces:search:followend' => "Obsolète le",
	//'uhb_annonces:search:followend' => "Date de fin de publication",
	'uhb_annonces:search:followstate' => "Etat",
	'uhb_annonces:search:followinterested' => "Membres intéressés",
	'uhb_annonces:search:followcandidates' => "Candidatures",
	'uhb_annonces:search:followreport' => "Signalements",
	'uhb_annonces:search:state:new' => "Initial",
	'uhb_annonces:search:state:confirmed' => "A publier",
	'uhb_annonces:search:state:published' => "Publiée",
	'uhb_annonces:search:state:filled' => "Archivée (pourvue)",
	'uhb_annonces:search:state:archive' => "Archivée",
	'uhb_annonces:search:profilelevel:all' => "Tous niveaux",
	'uhb_annonces:search:profilelevel:1' => "Licence (Bac +1 +2 et +3)",
	'uhb_annonces:search:profilelevel:4' => "Master (Bac +4 et +5)",
	'uhb_annonces:search:profilelevel:6' => "Doctorat (Bac +6 et plus)",
	'uhb_annonces:search:worklength:all' => "Toutes les durées",
	'uhb_annonces:search:worklength:0to3' => "Moins de 3 mois",
	'uhb_annonces:search:worklength:3to6' => "De 3 à 6 mois",
	'uhb_annonces:search:worklength:6more' => "Plus de 6 mois",
	'uhb_annonces:search:workstart' => "Début",
	'uhb_annonces:search:worklength' => "Durée",
	'uhb_annonces:search:worklength:unit' => "mois",
	'uhb_annonces:search:worklength:result' => "%s mois",
	
	
	
	// Entité
	'uhb_annonces:object:readkey' => "Clef pour accès en lecture",
	'uhb_annonces:object:editkey' => "Clef pour modification",
	'uhb_annonces:object:group:types' => "Types d'offres",
	'uhb_annonces:object:typeoffer' => "Type de l'offre",
	'uhb_annonces:object:typework' => "Type d'emploi",

	'uhb_annonces:object:group:structure' => "Information sur la structure d'accueil",
	'uhb_annonces:object:structurename' => "Raison sociale",
	'uhb_annonces:object:structureaddress' => "Adresse",
	'uhb_annonces:object:structurepostalcode' => "Code postal",
	'uhb_annonces:object:structurecity' => "Ville",
	'uhb_annonces:object:structurewebsite' => "Site internet",
	'uhb_annonces:object:structuresiret' => "SIRET",
	'uhb_annonces:object:structurenaf2008' => "NAF 2008",
	'uhb_annonces:object:structurelegalstatus' => "Statut juridique",
	'uhb_annonces:object:structureworkforce' => "Effectifs",
	'uhb_annonces:object:structuredetails' => "Description de la structure",

	'uhb_annonces:object:group:offer' => "Description de l'offre",
	'uhb_annonces:object:offerposition' => "Intitulé du poste",
	'uhb_annonces:object:offerreference' => "Référence interne",
	'uhb_annonces:object:offertask' => "Descriptif de la mission et tâches",
	'uhb_annonces:object:offerpay' => "Rémunération / gratification",

	'uhb_annonces:object:group:offer' => "Description de l'offre",
	'uhb_annonces:object:group:work' => "Période, lieu, durée",
	'uhb_annonces:object:workstart' => "Début de mission",
	'uhb_annonces:object:worklength' => "Durée en mois",
	'uhb_annonces:object:worktime' => "Temps de travail",
	'uhb_annonces:object:worktrip' => "Déplacements",
	'uhb_annonces:object:workcomment' => "Commentaires",

	'uhb_annonces:object:group:profile' => "Profil recherché",
	'uhb_annonces:object:profileformation' => "Formation du candidat",
	'uhb_annonces:object:profilelevel' => "Niveau d'études",
	'uhb_annonces:object:profilelevel:details' => "Si vous acceptez plusieurs niveaux, indiquez le niveau minimum et ajoutez l’information dans les observations.",
	'uhb_annonces:object:profilecomment' => "Observations sur le profil recherché (intitulé précis de la formation, compétences particulières, etc.)",

	'uhb_annonces:object:group:manager' => "Responsable de l'offre (personne à contacter)",
	'uhb_annonces:object:managergender' => "Genre",
	'uhb_annonces:object:managername' => "Prénom et Nom",
	'uhb_annonces:object:manageremail' => "Email",
	'uhb_annonces:object:manageremail:confirm' => "Email (confirmation)",
	'uhb_annonces:object:managerphone' => "Téléphone",
	'uhb_annonces:object:managervalidated' => "Email confirmé",
	'uhb_annonces:object:search:managervalidated' => "Email confirmé",

	'uhb_annonces:object:group:follow' => "Suivi de l'offre",
	'uhb_annonces:object:followcreation' => "Date de création",
	'uhb_annonces:object:followupdated' => "Date de dernière modification",
	'uhb_annonces:object:followvalidation' => "Date de publication",
	'uhb_annonces:object:followend' => "Fin de publication",
	'uhb_annonces:object:followstate' => "Etat",
	'uhb_annonces:object:followinterested' => "Membres intéressés",
	'uhb_annonces:object:followcandidates' => "Candidatures",
	'uhb_annonces:object:followreport' => "Signalements \"pourvue\"",
	'uhb_annonces:object:followcomments' => "Remarques",
	
	// Fields dropdown values
	'uhb_annonces:option:' => "",
	'uhb_annonces:option:yes' => "Yes",
	'uhb_annonces:option:no' => "No",
	'uhb_annonces:undefined' => "(undefined)",
	
	'uhb_annonces:typeoffer:values' => "stage, emploi, apprentissage, professionalisation",
	'uhb_annonces:typeoffer:stage' => "Training",
	'uhb_annonces:typeoffer:emploi' => "Job",
	'uhb_annonces:typeoffer:apprentissage' => "Contrat d'apprentissage", // non utilisé
	'uhb_annonces:typeoffer:professionalisation' => "Contrat de professionnalisation", // non utilisé
	'uhb_annonces:typeoffer:contrat_en_alternance' => 'Contrat en alternance',
	'uhb_annonces:typeoffer:service_civique' => 'Service civique',
	'uhb_annonces:typeoffer:job_etudiant' => 'Job étudiant',
	
	'uhb_annonces:typework:values' => "cdd, cdi, other",
	'uhb_annonces:typework:' => "",
	'uhb_annonces:typework:cdd' => "CDD",
	'uhb_annonces:typework:cdi' => "CDI",
	'uhb_annonces:typework:other' => "Other",
	
	'uhb_annonces:structurelegalstatus:values' => "privateenterprise, publicenterprise, publicadmin, territadmin, hospadmin, association, other",
	'uhb_annonces:structurelegalstatus:privateenterprise' => "Private Enterprise",
	'uhb_annonces:structurelegalstatus:publicenterprise' => "Public Enterprise",
	'uhb_annonces:structurelegalstatus:publicadmin' => "Administration publique d’État",
	'uhb_annonces:structurelegalstatus:territadmin' => "Administration territoriale",
	'uhb_annonces:structurelegalstatus:hospadmin' => "Administration hospitalière",
	'uhb_annonces:structurelegalstatus:association' => "Association",
	'uhb_annonces:structurelegalstatus:other' => "Autre (profession libérale, ONG...)",
	
	'uhb_annonces:structureworkforce:values' => "1to9, 10to49, 50to199, 200to499, 500more",
	'uhb_annonces:structureworkforce:1to9' => "1 to 9",
	'uhb_annonces:structureworkforce:10to49' => "10 to 49",
	'uhb_annonces:structureworkforce:50to199' => "50-199",
	'uhb_annonces:structureworkforce:200to499' => "200 à 499",
	'uhb_annonces:structureworkforce:500more' => "500 and more",
	
	'uhb_annonces:worklength:values' => "0to3, 3to6, 6more",
	'uhb_annonces:worklength:0to3' => "less than 3 months",
	'uhb_annonces:worklength:3to6' => "from 3 to 6 months",
	'uhb_annonces:worklength:6more' => "more than 6 months",
	
	'uhb_annonces:worktime:values' => "fulltime, partial",
	'uhb_annonces:worktime:fulltime' => "Full time",
	'uhb_annonces:worktime:partial' => "Partial time (use comments for details)",
	
	'uhb_annonces:worktrip:values' => "no, yes",
	'uhb_annonces:worktrip:no' => "No",
	'uhb_annonces:worktrip:yes' => "Yes",
	
	'uhb_annonces:managergender:values' => "mr, mrs",
	'uhb_annonces:managergender:mr' => "Monsieur",
	'uhb_annonces:managergender:mrs' => "Madame",
	
	'uhb_annonces:managervalidated:yes' => "Yes",
	'uhb_annonces:managervalidated:no' => "No",
	
	'uhb_annonces:profileformation:values' => "urbanism, artculture, documentation, communication, learning, research, enterprise, languages, healthcare, sport",
	'uhb_annonces:profileformation:urbanism' => "Aménagement / Environnement / Urbanisme",
	'uhb_annonces:profileformation:artculture' => "Art / Culture / Patrimoine",
	'uhb_annonces:profileformation:documentation' => "Bibliothèques / Documentation / Edition",
	'uhb_annonces:profileformation:communication' => "Communication / Multimédia",
	'uhb_annonces:profileformation:learning' => "Education / Formation",
	'uhb_annonces:profileformation:research' => "Etudes / Recherche / Innovation",
	'uhb_annonces:profileformation:enterprise' => "Gestion / Marketing / Ressources Humaines",
	'uhb_annonces:profileformation:languages' => "Linguistique / Traduction",
	'uhb_annonces:profileformation:healthcare' => "Santé / Social",
	'uhb_annonces:profileformation:sport' => "Sport / Tourisme / Loisirs",
	// OUT - old keys should stay for compatibility. These were not in production
	//'uhb_annonces:profileformation:administration' => "Administration publique",
	//'uhb_annonces:profileformation:trade' => "Commerce / Marketing / International",
	//'uhb_annonces:profileformation:economy' => "Economie / Gestion / Statistiques",
	//'uhb_annonces:profileformation:communication' => "Information / Communication / TIC",
	//'uhb_annonces:profileformation:journalism' => "Journalisme / Lettres",
	//'uhb_annonces:profileformation:socialinclusion' => "Prévention / Insertion / Intervention",
	//'uhb_annonces:profileformation:humanressources' => "Ressources Humaines / Management",
	
	//'uhb_annonces:profilelevel:values' => "all, licence, master1, master2, doctorat",
	// Note : it is essential to have numerical values because of search greater than X
	'uhb_annonces:profilelevel:values' => "0, 1, 4, 5, 6",
	'uhb_annonces:profilelevel:all' => "Tous niveaux",
	'uhb_annonces:profilelevel:' => "Tous niveaux",
	'uhb_annonces:profilelevel:0' => "Tous niveaux",
	'uhb_annonces:profilelevel:licence' => "Licence (Bac +1, +2, +3)",
	'uhb_annonces:profilelevel:1' => "Licence (Bac +1, +2, +3)",
	'uhb_annonces:profilelevel:2' => "Licence 2 (Bac +2, +3)",
	'uhb_annonces:profilelevel:3' => "Licence 3 (Bac +3)",
	'uhb_annonces:profilelevel:master1' => "Master 1 (Bac +4)",
	'uhb_annonces:profilelevel:4' => "Master 1 (Bac +4)",
	'uhb_annonces:profilelevel:master2' => "Master 2 (Bac +5)",
	'uhb_annonces:profilelevel:5' => "Master 2 (Bac +5)",
	'uhb_annonces:profilelevel:doctorat' => "Doctorat (Bac >= +6)",
	'uhb_annonces:profilelevel:6' => "Doctorat (Bac >= +6)",
	
	'uhb_annonces:followstate:values' => "new, confirmed, published, filled, archive",
	'uhb_annonces:followstate:new' => "Nouvelle (à confirmer)",
	'uhb_annonces:followstate:confirmed' => "Confirmée (à publier)",
	'uhb_annonces:followstate:published' => "Publiée",
	'uhb_annonces:followstate:filled' => "Pourvue",
	'uhb_annonces:followstate:archive' => "Archivée",
	
	'uhb_annonces:followreport:values' => "no, yes",
	'uhb_annonces:followreport:no' => "No",
	'uhb_annonces:followreport:yes' => "Yes (report as filled)",
	
	'uhb_annonces:addcomment' => "Add a comment",
	
	
	// Formulaire
	// Création / édition d'une offre
	'uhb_annonces:form:add' => "Déposer une offre",
	'uhb_annonces:form:edit' => "Modification de l'offre",
	'uhb_annonces:form:edit:your' => "Modification de votre offre",
	// Titres
	'uhb_annonces:form:group:structure' => "Structure d'accueil",
	'uhb_annonces:form:group:offerprofile' => "Offre et profil recherché",
	'uhb_annonces:form:group:manager' => "Responsable de l'offre",
	// Navigation
	'uhb_annonces:form:step0' => "Suivi",
	'uhb_annonces:form:step1' => "Structure d'accueil",
	'uhb_annonces:form:step2' => "Offre et profil",
	'uhb_annonces:form:step3' => "Contact",
	'uhb_annonces:form:action:next' => "Etape suivante",
	'uhb_annonces:form:action:previous' => "Etape précédente",
	// Actions
	'uhb_annonces:form:action:create' => "Valider mon offre",
	'uhb_annonces:form:action:save' => "Enregistrer les modifications",
	'uhb_annonces:form:action:cancel' => "Annuler",
	'uhb_annonces:form:action:cancel:confirm' => "Attention, vos modification seront perdues !",
	'uhb_annonces:form:action:search' => "Rechercher",
	'uhb_annonces:form:action:removefilters' => "Supprimer les filtres",
	'uhb_annonces:form:action:exportcsv' => "Exporter les résultats sous forme de tableau CSV",
	'uhb_annonces:form:action:exportcsv:details' => "Note : lors d'un export au format CSV, le fichier exporté comprend l'ensemble des offres correspondant à vos critères de recherche, et toutes les informations associées aux offres.<br />Attention : l'export CSV intégrant l'ensemble des informations associées à chacune des offres, l'export d'un nombre important d'offre peut prendre un temps significatif, de l'ordre de plusieurs minutes par millier d'offres. Veuillez également noter que le fichier exporté peut être lourd (environ 1 Mo par millier d'offres).",
	'uhb_annonces:form:action:candidate' => "Envoyer ma candidature",
	'uhb_annonces:form:candidate:attachment' => "CV et lettre de motivation",
	'uhb_annonces:form:candidate:profilelink' => "Profil professionnel",
	// Explications
	'uhb_annonces:form:manager:details' => "<p>Vos coordonnées de contact ne sont pas affichées dans RESONANCES. Le site vous transmettra automatiquement par email les demandes de candidature d'étudiants ou de diplômés pour cette offre.</p>
	<p>Vous pouvez vérifier votre saisie en revenant sur les étapes précédentes avec la navigation en haut de page. Une fois votre offre validée, vous recevrez un email de vérification avec un lien à activer.</p>
	<p>Votre offre sera relue par un chargé de mission qui sera votre correspondant éventuel avant la publication dans RESONANCES.</p>",
	
	
	// Candidatures
	'uhb_annonces:apply:attachfiles' => "Je joins mon CV et ma lettre de candidature",
	'uhb_annonces:apply:file1' => "Fichier joint n°1 (obligatoire)",
	'uhb_annonces:apply:file2' => "Fichier joint n°2 (optionnel)",
	'uhb_annonces:apply:profile:attach' => "J'ajoute un lien vers mon profil RESONANCES à mon dossier de candidature.",
	'uhb_annonces:apply:profile:cantattach' => "Votre profil ne peut pas être joint à votre candidature car il n'est pas public ou pas suffisamment complet.",
	'uhb_annonces:apply:profile:details' => "Pour joindre votre profil Résonances, vous devez avoir renseigné les rubriques Formation, Expérience et Compétences, et avoir défini leur visibilité sur \"Public\".",
	'uhb_annonces:error:downloadattachment' => "Erreur : impossible de joindre le fichier joint.",
	'uhb_annonces:error:missingattachment' => "Fichier joint manquant",
	'uhb_annonces:error:attachmentsupport' => "L'envoi de pièces jointes par email n'est pas pris en charge, veuillez contacter un administrateur du site.",
	
	
	// Listing
	'uhb_annonces:count' => "%s offres",
	
	'uhb_annonces:list:new' => "New offers",
	'uhb_annonces:list:confirmed' => "Confirmed offers",
	'uhb_annonces:list:published' => "Published offers",
	'uhb_annonces:list:filled' => "Filled offers",
	'uhb_annonces:list:archive' => "Archived offers",
	'uhb_annonces:list:all' => "All offers",
	'uhb_annonces:list:anonymous' => "Offres sans compte de membre",
	'uhb_annonces:list:reported' => "Offres signalées comme pourvues",
	'uhb_annonces:list:reportedby' => "Membres auteurs des signalements",
	'uhb_annonces:list:memorised' => "Offres mémorisées",
	'uhb_annonces:list:candidated' => "Offres ayant reçu une candidature",
	'uhb_annonces:list:mine' => "My offers",
	'uhb_annonces:list:mine:memorised' => "My saved offers",
	'uhb_annonces:list:mine:candidated' => "Offres auxquelles j'ai candidaté",
	'uhb_annonces:list:mine:mine' => "My offers",
	
	'uhb_annonces:tab:new' => "New",
	'uhb_annonces:tab:confirmed' => "Confirmed",
	'uhb_annonces:tab:published' => "Published",
	'uhb_annonces:tab:filled' => "Filled",
	'uhb_annonces:tab:archive' => "Archived",
	'uhb_annonces:tab:reported' => "Reported",
	'uhb_annonces:tab:memorised' => "Saved",
	'uhb_annonces:tab:candidated' => "Candidatées",
	'uhb_annonces:tab:all' => "All",
	'uhb_annonces:tab:anonymous' => "Non-members",
	'uhb_annonces:tab:mine' => "My offers",
	
	'uhb_annonces:view:menu:structure' => "Structure",
	'uhb_annonces:view:title' => "Offer from %s",
	'uhb_annonces:view:structure' => "Structure : ",
	'uhb_annonces:view:structurelegalstatus' => "Statut juridique : ",
	'uhb_annonces:view:structureaddress' => "Address: ",
	'uhb_annonces:view:structurewebsite' => "Web site: ",
	'uhb_annonces:view:structuresiret' => "SIRET : ",
	'uhb_annonces:view:structurenaf2008' => "NAF 2008 : ",
	'uhb_annonces:view:structureworkforce' => "Effectifs : %s personnes",
	'uhb_annonces:view:structuredetails' => "Description de la structure",
	
	'uhb_annonces:view:menu:offer' => "Offre et profil",
	'uhb_annonces:view:offertask' => "Descriptif de la mission et tâches",
	'uhb_annonces:view:offerpay' => "Rémunération / gratification : ",
	'uhb_annonces:view:offerreference' => "Référence de l'offre : ",
	'uhb_annonces:view:workstart' => "Date de démarrage : ",
	'uhb_annonces:view:worklength' => "durée : %s mois",
	'uhb_annonces:view:worktime' => "Temps de travail : ",
	'uhb_annonces:view:worktime:fulltime' => "Temps plein",
	'uhb_annonces:view:worktime:partial' => "Temps partiel",
	'uhb_annonces:view:worktrip' => "Déplacements : ",
	'uhb_annonces:view:workcomment' => "Commentaires",
	'uhb_annonces:view:profileformation' => "Formation souhaitée : ",
	'uhb_annonces:view:profilelevel' => "Niveau d'études : ",
	'uhb_annonces:view:profilecomment' => "Observations sur le profil recherché : ",
	
	'uhb_annonces:view:menu:candidate' => "Je candidate",
	// Note : attention, c'est un entête de menu !
	'uhb_annonces:view:menu:candidate:done' => "Candidature déjà envoyée",
	'uhb_annonces:candidate:done:details' => "Vous avez déjà postulé à cette offre. Le contact de cet annonce vous répondra personnellement.<br /><br />Les fichiers que vous avez joints vous ont également été envoyés par email au moment de votre candidature.",
	
	'uhb_annonces:view:menu:contact' => "Contact",
	'uhb_annonces:view:manageremail' => "Email du responsable : %s",
	'uhb_annonces:view:managerphone' => "Téléphone : %s",
	'uhb_annonces:view:managervalidated:yes' => "Email du responsable validé",
	'uhb_annonces:view:managervalidated:no' => "Email du responsable non validé",
	
	'uhb_annonces:view:menu:admin' => "Admin",
	'uhb_annonces:view:followstate' => "Etat : %s",
	'uhb_annonces:view:followcreation' => "Created on %s",
	'uhb_annonces:view:createdby' => "by %s",
	'uhb_annonces:view:createdby:nomember' => "(non-member)",
	'uhb_annonces:view:followcreation:no' => "No creation date",
	'uhb_annonces:view:followvalidation' => "Published on %s",
	'uhb_annonces:view:followvalidation:no' => "Not published",
	'uhb_annonces:view:followend' => "Fin de publication le %s",
	'uhb_annonces:view:followend:no' => "Pas de date de fin de publication ",
	'uhb_annonces:view:interested' => "%s membre(s) intéressé(s)",
	'uhb_annonces:view:candidated' => "%s candidature(s)",
	'uhb_annonces:view:reported' => "%s signalement(s) comme pourvue",
	'uhb_annonces:view:followcomments' => "Comments",
	
	
	// Messages
	'uhb_annonces:message:reactivate' => "Votre annonce a été réactivée pour un nouveau cycle de publication. Merci de votre confiance.",
	'uhb_annonces:message:archive' => "Votre annonce a été archivée. Un email de confirmation vient de vous être envoyé. Merci de votre confiance.",
*/
	
	
	/* NOTIFICATIONS */
/* @TODO : translate !
	// Public actions
	'uhb_annonces:action:confirm:success' => "L'adresse email est confirmée. Les instructions pour la suite vous ont été envoyées.",
	'uhb_annonces:action:confirm:success:message' => "Votre adresse email a bien été confirmée. ",
	'uhb_annonces:action:confirmed:success' => "L'adresse email était déjà confirmée.",
	'uhb_annonces:action:confirmed:success:message' => "Votre adresse email était déjà confirmée.",
	'uhb_annonces:action:reactivate:success' => "L'annonce est ré-activée",
	'uhb_annonces:action:reactivate:success:message' => "Votre annonce a bien été ré-activée.",
	'uhb_annonces:action:archive:success' => "L'annonce est désactivée",
	'uhb_annonces:action:archive:success:title' => "Annonce désactivée",
	'uhb_annonces:action:archive:success:message' => "Votre annonce a été désactivée.",
	'uhb_annonces:action:archive:alreadydone' => "Votre annonce a déjà été archivée",
	'uhb_annonces:action:filled:success' => "L'annonce est désactivée car pourvue",
	'uhb_annonces:action:filled:success:title' => "Annonce pourvue",
	'uhb_annonces:action:filled:success:message' => "Votre annonce a été désactivée car pourvue.",
	'uhb_annonces:image_captcha:verify:fail' => "Votre annonce n'a pas pu être enregistrée, veuillez vérifier le captcha",
	
	// Member actions
	'uhb_annonces:action:memorise:success' => "L'annonce est mémorisée : vous la retrouverez dans votre suivi d'annonces.",
	'uhb_annonces:action:removememorise:success' => "Cette offre n'est plus mémorisée dans votre suivi d'annonces.",
	'uhb_annonces:action:candidate:waitwhilesending' => "Candidature en cours. L'envoi des pièces jointes peut prendre un peu de temps, veuillez patienter sans fermer cette page.",
	'uhb_annonces:action:candidate:success' => "Votre candidature a été envoyée. Vous la retrouverez dans votre suivi d'annonces.",
	'uhb_annonces:action:candidate:error' => "Il y a eu une erreur lors de l'envoi de votre candidature, veuillez réessayer.",
	'uhb_annonces:action:report:success' => "Signalement effectué : nous vérifierons cette annonce.",
	'uhb_annonces:action:unreport:success' => "Votre signalement a été supprimé.",
	// Admin actions
	'uhb_annonces:action:publish:success' => "L'annonce est publiée",
	'uhb_annonces:action:resendconfirm:success' => "Un nouvel email de confirmation a été renvoyé.",
	'uhb_annonces:action:validate:success' => "L'adresse email est validée",
	'uhb_annonces:action:removereport:success' => "Signalements \"annonce pourvue\" supprimés",
	
	
	'uhb_annonces:notification:mail:success' => "Un email de confirmation a été envoyé.",
	'uhb_annonces:notification:mail:error' => "Une erreur s'est produite lors de l'envoi du mail.",
	
	// Emails de notification vers l'annonceur
	// Email de confirmation n°1
	'uhb_annonces:notification:confirm1:subject' => "Votre annonce dans RESONANCES",
	'uhb_annonces:notification:confirm1:body' => "%1\$s %2\$s,

Nous vous remercions d'avoir utilisé RESONANCES pour déposer votre offre %3\$s. Ce message est la première étape : pour confirmer la validité de votre email, cliquez sur le lien ci-dessous.

%4\$s

Après cette vérification, votre annonce sera prise en charge par un chargé de mission pour sa diffusion auprès des étudiants et diplômés. Vous recevrez un lien à conserver qui vous permettra de la modifier ou de la supprimer, de suivre les candidatures.",
	
	// Email de confirmation n°2
	'uhb_annonces:notification:confirm2:subject' => "Vos informations pour gérer votre annonce dans RESONANCES",
	'uhb_annonces:notification:confirm2:validate' => "Votre adresse email est confirmée.",
	'uhb_annonces:notification:confirm2:edit' => "Votre annonce a été modifiée.",
	'uhb_annonces:notification:confirm2:body' => "%1\$s %2\$s,

%3\$s
Votre annonce va maintenant être validée par un chargé de mission de l'université avant sa publication. Celui-ci reviendra vers vous si votre annonce nécessite des précisions ou modifications. Cette étape est généralement très rapide, de l'ordre d'un jour ouvré.

Nous vous remercions de votre confiance et de votre intérêt pour les étudiants et diplômés de notre université.

L'équipe RESONANCES",
	
	// Email de publication de l'annonce
	'uhb_annonces:notification:publication:subject' => "Publication de votre annonce dans RESONANCES",
	'uhb_annonces:notification:publication:body' => "%1\$s %2\$s,

Votre annonce pour un %3\$s intitulé \"%4\$s\" vient d'être validée et publiée par un chargé de mission de l'université. Elle est désormais accessible pour que des étudiants et diplômés de l'université puissent envoyer leur candidature.

Vos coordonnées n'étant pas publiques, ces candidatures vous seront transmises via le site RESONANCES, ce qui permet de suivre les candidatures et l'actualité de votre recrutement.

Avec le lien de gestion suivant, vous accédez à la page de votre annonce dans laquelle figure le nombre de personnes qui ont été intéressées par votre annonce, et la liste des candidatures à jour.

%5\$s

Vous serez relancé au bout de 1 mois pour confirmer la validité de cette annonce et la renouveler. Si vous avez des questions à nous adresser, utilisez l'adresse %6\$s

Nous vous remercions de la confiance que vous avez témoignée envers les étudiants et diplômés de l'université Rennes 2. Nous espérons que vous utiliserez à nouveau nos services pour vos futurs recrutements.

Recevez, %1\$s %2\$s, nos sincères salutations.

L'équipe RESONANCES",
	
	// Email de fin de publication
	'uhb_annonces:notification:endofpublication:subject' => "Désactivation de votre annonce dans RESONANCES",
	'uhb_annonces:notification:endofpublication:body' => "%1\$s %2\$s,

Votre annonce pour un %3\$s intitulé \"%4\$s\" publiée le %5\$s arrive bientôt à échéance. Sans action de votre part, elle ne sera plus affichée dans les résultats des recherches pour que des candidats puissent postuler.

Si cette annonce est toujours d'actualité et non pourvue pour vous, nous vous invitons à la réactiver via ce lien : 
%6\$s

Si elle est obsolète ou si vous ne souhaitez pas la remettre en affichage, cliquez sur ce lien pour la désactiver : 
%7\$s

Sans action de votre part, l'annonce sera automatiquement archivée d'ici 7 jours.

Nous vous remercions de la confiance que vous avez témoignée envers les étudiants et diplômés de l'université Rennes 2. Nous espérons que vous utiliserez à nouveau nos services pour vos futurs recrutements.

Recevez, %1\$s %2\$s, nos sincères salutations.

L'équipe RESONANCES",
	
	// Email d'archivage de l'annonce (fin de publication + 7 jours)
	'uhb_annonces:notification:archive:subject' => "Désactivation de votre annonce dans RESONANCES",
	'uhb_annonces:notification:archive:body' => "%1\$s %2\$s,

Votre annonce pour un %3\$s intitulé %4\$s vient d'être désactivée. Elle n'est plus visible pour les membres du réseau social RESONANCES de l'université Rennes 2.

Nous vous remercions de la confiance que vous avez témoignée envers les étudiants et diplômés de l'université Rennes 2. Nous espérons que vous utiliserez à nouveau nos services pour vos futurs recrutements.

Recevez, %1\$s %2\$s, nos sincères salutations.
L'équipe RESONANCES",
	
	// Email d'un candidat
	'uhb_annonces:notification:candidate:subject' => "Candidature pour votre offre %s",
	'uhb_annonces:notification:candidate:body' => "%1\$s %2\$s,

Un membre du réseau social RESONANCES de l'université Rennes 2 vous envoie sa candidature pour l'annonce que vous avez publiée pour un %3\$s intitulé \"%4\$s\".

Ce candidat est %5\$s, vous trouverez sa candidature en %6\$s à ce message.
%7\$s
C'est désormais à vous d'entrer directement en contact avec le candidat pour donner suite à son projet.

Si cette offre est obsolète de votre côté, nous vous invitons à actualiser son statut à partir de cette URL de gestion, afin de ne plus recevoir de candidatures.
%8\$s

En vous souhaitant bonne réception de ces informations, recevez, %1\$s %2\$s, nos sincères salutations.

L'équipe RESONANCES",
	'uhb_annonces:notification:attached:single' => "un fichier joint",
	'uhb_annonces:notification:attached:multiple' => "%s fichiers joints",
	'uhb_annonces:notification:candidate:body:profile' => "
De plus %1\$s vous invite à consulter son profil numérique professionnel dans RESONANCES à cette adresse : %2\$s
",
	
	// Email de notification vers le candidat
	// Email à destination du membre candidat
	'uhb_annonces:notification:application:subject' => "Votre candidature à une annonce dans RESONANCES",
	'uhb_annonces:notification:application:body' => "Bonjour %1\$s,

Vous avez envoyé votre candidature pour postuler à une offre %2\$s publiée dans RESONANCES. Pour mémoire, cette annonce est disponible après authentification à cette URL :
%3\$s.

Vous retrouverez un lien vers les annonces pour lesquelles vous avez souhaité postuler dans la navigation présente dans votre fiche profil %4\$s.

Nous vous souhaitons la réussite dans vos projets,

L'équipe RESONANCES",
*/
	
);

