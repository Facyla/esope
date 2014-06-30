Départements en réseaux.fr est une plateforme collaborative construite à partir d'Elgg 1.8, proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.

Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.


#============================================================#
=== Crédits ===
- Départements en réseaux a été réalisé, et est publié sous licence opensource (GPL2), par le Conseil Général de l'Essonne
- Conception et réalisation : Florian DANIEL (Facyla, facyla@gmail.com) / Items International (http://items.fr/)
- Conception graphique et accessibilité : Urbilog


=== Cette plateforme est composée des éléments suivants ===
- Elgg core, et plugins associés
- Plugins communautaires : brainstorm, event_calendar, friend_requests, group_operators, guidtool, login_as, profile_manager, threads
- Développements spécifiques
  * Inscript-Essonne : inscriptions limitées en fonction de noms de domaines autorisés (accès réservé aux membres d'une ou plusieurs organisations)
  * Acc'Essonne : thème accessible et configurable
      réorganisation des menus
      modifications fonctionnelles : groupes, notifications, outils, etc.
      accessibilité : plateforme accessible aux utilisateurs handicapés (navigation au clavier et lecture d'écran)
      liste de pages publiques explicitement définies
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
  - copiez les fichiers sur votre serveur dans l'espace approprié
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
    * Elgg developper tools en premier (pour un site en cours de mise en place)
    * "Embed" après "File", 
    * "Profile_manager" après "Profile",
    * "Group_operators" après "Groups".
  - le plugin "Inscript-Essonne" peut être activé ou non selon vos besoins : il permet de restreindre les inscriptions sur la base de leur adresse mail d'inscription (liste précise de noms de domaines autorisés à s'inscrire). A placer vers la fin (juste avant "Acc'Essonne").
  - le plugin "Acc'Essonne" liste les plugins à activer (via les dépendances) : commencez par activer ces plugins, puis activez-le une fois toutes les dépendances satisfaites.
  - vous pouvez activer ou désactiver certains plugins selon vos besoins :
    * plugins de contenus : blog, bookmarks, pages, brainstorm, file (+embed), announcements, thewire, event_calendar
    * divers : zaudio, likes, message board, tag cloud, twitter widget
  - plugins non testés avec ce thème (nécessitent éventuellement une intégration supplémentaire pour s'intégrer correctement) : Twitter API, OAuth API, TheWire

6. Configurez les divers plugins selon vos besoins, et notamment :
  - Inscript-Essonne : liste des domaines autorisés pour l'inscritpion de nouveaux membres (si activé)
  - Acc'Essonne : réglages du thème, des couleurs, des bandeaux, images et autres textes configurables
  - profile manager : profils membres et groupes
  - event_calendar : réglages à tester soigneusement
  - Site-wide categories : liste de thématiques du site (si activé)
  - groups, log rotate, garbage collector




#============================================================#
SECURITE : 
De nombreuses mesures peuvent être prises du côté du serveur, notamment 
via la mise en place d'une connexion HTTPS (nécesite un certificat valide) 
et diverses options de configuration d'Apache.
Quelques ajouts complémentaires à intégrer aux fichiers .htaccess :

# Secure cookies
<IfModule php5_module>
	# Set cookie to use HTTPOnly (can't be used in any script - such as JS)
	php_flag session.cookie_httponly on
	# Allow cookie session over secure channel only
	php_value session.cookie_secure 1
</IfModule>

# No Multiviews
Options -Multiviews

# XSS protection and various other security settings
<IfModule mod_headers.c>
	#Header add TimeGenerated "It took %D microseconds to serve this request."
	Header add Strict-Transport-Security "max-age=157680000"
	Header unset ETag
	Header set X-Frame-Options: sameorigin
	Header set X-XSS-Protection: "1; mode=block"
	Header set X-Content-Type-Options: nosniff
	Header set X-Content-Security-Policy: "allow 'self'"
	Header set X-WebKit-CSP: "allow 'self'"
	Header set X-Permitted-Cross-Domain-Policies: "master-only"
	Header unset X-Powered-By
</IfModule>
ServerSignature Off



