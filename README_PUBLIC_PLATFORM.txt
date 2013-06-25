Départements en réseaux.fr est une plateforme collaborative construite à partir d'Elgg 1.8, proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.

Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.

Suite à ses évolutions, elle permet également de proposer des réseaux publics ou à usage mixte intranet / extranet / réseau social / site web collaboratif / plateforme de formation.


#============================================================#
=== Crédits ===
- la distribution Départements en réseaux a été souhaitée et conçue en partenariat par l'Assemblée des Départements de France, le Conseil Général de l'Essonne et ITEMS International.
- Sa version initiale (développements initiaux + conception graphique et accessibilité) a été financée par le Conseil Général de l'Essonne, et réalisée par ITEMS International, en partenariat avec Urbilog sur l'accessibilité et la conception graphique.
- Elle est publié sous licence opensource (GPL2), et peut être librement réutilisée pour tous types d'usages, sous les conditions de cette licence.

- Conception, réalisation et maintenance : Florian DANIEL ~ Facyla, facyla@gmail.com / Items International, http://items.fr/


=== Cette plateforme est composée des éléments suivants ===
- Elgg core, et plugins associés

- Le coeur de la distribution :
  * Acc'Essonne : LA base commune. Il s'agit d'une base de thème accessible et configurable, qui sert de base à toute la distribution
    - réorganisation des menus
    - modifications fonctionnelles : groupes, notifications, outils, etc.
    - accessibilité : plateforme accessible aux utilisateurs handicapés (navigation au clavier et lecture d'écran)
    - liste de pages publiques explicitement définies (en mode walled_garden)
    - ...
  
- Plusieurs plugins communautaires : plugins intégrés dans la distribution, au fur et à mesure de l'évolution des besoins de sites qui s'appuient sur cette distribution
	* Plugins recommandés pour la distribution : friend_requests, group_operators, guidtool, html_email_handler, login_as, profile_manager
	* Plugins optionnels, selon les usages : elgg-brainstorm, event_calendar, related-items, simplepie, tidypics, threads, videos...
	* plugins optionnels ajoutés par des contributeurs de la distribution : 
    - Inscript-Essonne : inscriptions limitées en fonction de noms de domaines autorisés (accès réservé aux membres d'une ou plusieurs organisations)
		- ldap_auth : authentification auprès d'un serveur LDAP et mise à jour des infos (Inria)
		- export_embed : widgets exportables pour afficher des informations entre plusieurs sites Elgg, ou à utiliser comme un "embed" (RésoPolen)
	* plugins optionnels ajoutés par le concepteur/mainteneur de la distribution (Facyla ~ Florian DANIEL) : 
		- pdf_export : export de contenus sous forme de PDF
		- cmspages : gesiton de pages statiques

  
- Différents thèmes ou adaptations spécifiques à des usages particuliers : ces "thèmes" viennent en surcharge après Acc'Essonne, et sont adaptés à certains types d'usages
  * theme_inria : Thème du réseau Inria
  * theme_compnum + dossierdepreuve : thème spécifique pour la plateforme "Compétences Numériques" + l'outil de suivi des dossiers de preuve (adapté pour l'évaluation au B2i Adultes - ou d'autres référentiels)
  	- ...

- En projet
    accès externes limités à certaines ressources, pour permettre des accès limités à des collaborateurs externes
    ...
#============================================================#

#============================================================#
PRE-REQUIS : http://docs.elgg.org/wiki/Installation/Requirements
- Serveur Web (Apache...)
- URL rewriting
- PHP 5.2+, avec les extensions GD, Multibyte String support, et la possibilité d'envoyer des mails
- MySQL 5+


#============================================================#
INSTALLATION & CONFIGURATION : 

1. installez la plateforme Elgg :
  - créez une base de données (MySQL)
  - copiez les fichiers sur votre serveur dans l'espace approprié (le mieux est de le faire directement via GIT ; si vous ne savez pas de quoi il s'agit, copiez les fichiers comme vous en avez l'habitude)
  - créez un dossier pour les données, de préférence hors de la racine web (si les scripts sont dans .../www/, l'emplacement de ce dossier pourrait être .../data/). Si ce n'est pas possible, ajoutez un fichier .htaccess dans le dossier avec pour seul contenu : deny from all
  - rendez-vous sur l'adresse de votre site et suivez la procédure d'installation

2. La procédure d'installation se termine par la création du compte administrateur principal : je vous recommande de faire en sorte que ce compte ne soit pas "personnel". Pour cela, utilisez une adresse générique (redirection ou mailing-list), et n'utilisez ce compte que pour des tâches purement administratives.

3. Dès le compte administrateur créé, connectez-vous et créez votre compte administrateur personnel, puis déconnectez-vous et n'utilisez plus que votre compte personnel.

5. Configurez les paramètres de base de votre site
  - dans Administration > Paramètres > Réglages de base (basic settings) : modifiez la langue par défaut du site
  - dans Administration > Paramètres > Paramètres avancés (advanced settings) :
    * pour un site en cours de mise en place : désactivez les caches et affichez les erreurs
    * pour un site "intranet" : cochez "Restreindre les pages aux seuls utilisateurs enregistrés"
    * connexion HTTPS et autres réglages selon votre configuration

5. Activez les plugins pour votre site :
  - réordonnez certains plugins :
    * Acc'Esssonne en dernier, 
    * (facultatif) si vous utilisez un thème spécifique, placez-le après Acc'Essonne
    * Elgg developper tools en premier (pour un site en cours de mise en place)
    * "Embed" après "File", 
    * "Profile_manager" après "Profile",
    * "Group_operators" après "Groups".
  - le plugin "Acc'Essonne" liste les plugins nécessaires pour l'activer (via les dépendances) : commencez par activer ces plugins, puis activez Acc'Essonne une fois toutes les dépendances satisfaites.
  - (facultatif) faites de même pour votre thème spécifique (dépendance puis activation du thème)
  - le plugin "Inscript-Essonne" peut être activé ou non selon vos besoins : il permet de restreindre les inscriptions sur la base de leur adresse mail d'inscription (liste précise de noms de domaines autorisés à s'inscrire). A placer vers la fin (juste avant "Acc'Essonne").
  - vous pouvez activer ou désactiver les autres plugins selon vos besoins :
    * plugins de contenus : blog, bookmarks, pages, brainstorm, file (+embed), announcements, thewire, event_calendar
    * divers : zaudio, likes, message board, tag cloud, twitter widget
    * etc. (la liste évolue régulièrement)
  - plugins non testés avec ce thème (nécessitent éventuellement une intégration supplémentaire pour s'intégrer correctement) : Twitter API, OAuth API, TheWire

6. Configurez les divers plugins selon vos besoins, et notamment :
  - Inscript-Essonne : liste des domaines autorisés pour l'inscritpion de nouveaux membres (si activé)
  - Acc'Essonne : réglages du thème, des couleurs, des bandeaux, images et autres textes configurables
  - profile manager : profils membres et groupes
  - event_calendar : réglages à tester soigneusement
  - Site-wide categories : liste de thématiques du site (si activé)
  - groups, log rotate, garbage collector
  - etc. selon les plugins optionnels activés




