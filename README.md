# Environnement Social Opensource Public Elgg
> ESOPE pour Environnement Social Opensource Public Elgg, est une distribution francisée d'Elgg, conçue pour faciliter et accélérer la mise en place de plateformes collaboratives "clefs en main".
> In english: Elgg Social Opensource Public Environment)


## A propos d'Elgg
Lire [README.txt](README.txt)
* Copyright :  [COPYRIGHT.txt](COPYRIGHT.txt)
* Contributeurs : [CONTRIBUTORS.txt](CONTRIBUTORS.txt)
* Licence : [LICENSE.txt](LICENSE.txt)
* Installation : [INSTALL.txt](INSTALL.txt)
* Mise à jour : [UPGRADE.txt](UPGRADE.txt)


## A propos d'ESOPE
A l'origine, ESOPE est issue du projet partenarial "Departements en réseaux" initié par l'Assemblée des Départements de France, le Conseil Général de l'Essonne, et ITEMS International, qui visait à construire une plateforme collaborative opensource, francisée et acsessible.
Un travail spécifique d'accessibilité a également été mené avec l'appui de la société Urbilog.
Ce projet a donné lieu au site Departements-en-reseaux.fr, plateforme collaborative opensource proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.



ESOPE est constituée :
* d'une base d'Elgg générique (core),
* d'un plugin générique en surcouche, qui permet de modifier l'apparence et le comportement du site,
* et d'une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages d'organisations souhaitant disposer d'une plateforme collaborative interne, publique ou mixte.

La distribution ESOPE offre de très nombreux réglages et possibilités de personnalisation qui permettent d'ajuster l'apparence et le comportement d'Elgg à une large gamme d'usages collaboratifs ou sociaux. Ces réglages sont directelent accessibles aux administrateurs, sans nécessiter de développement ni d'intervention plus technique.

ESOPE est également adaptée pour fournir une base sur laquelle construire des thèmes légers.


### Version
ESOPE suit de près les évolutions du "core" d'Elgg, et s'appuie actuellement sur Elgg 1.8.20


### Conception et maintenance
* Florian DANIEL aka Facyla / ITEMS International


### Principaux contributeurs
* ITEMS International
* Conseil Général de l'Essonne
* Assemblée des Départements de France (ADF)
* Fondation Internet Nouvelle Génération (FING)
* Agence Nationale de Lutte Contre l'Illetrisme (ANLCI)
* Région Rhône-Alpes (via le projet FormaVia)
* Inria
* Cartier International



## Installation d'ESOPE
### PRE-REQUIS : http://docs.elgg.org/wiki/Installation/Requirements
- Serveur Web (Apache...)
- URL rewriting
- PHP 5.2+, avec les extensions GD, Multibyte String support, et la possibilité d'envoyer des mails
- MySQL 5+

### Procédure d'installation
1. L'installation d'ESOPE est identique en tous points à celle d'un Elgg standard.
  1. Placez les scripts dans le répertoire de votre choix, par ex. dans /var/www/esope/
  2. Créer un répertoire pour les données, hors du répertoire web, par ex. dans /var/www/esope-data/
  3. Créez une base de données MySQL
  4. Visitez la page web, qui vous redirige sur le script d'installation, et suivez les instructions. Vous pourrez avoir besoin d'effectuer des modifications de configuration si nécessaire : les plus fréquentes sont de modifier les droits d'accès sur les dossiers d'installation, et activer le module php mod_rewrite.
2. Une fois l'installation terminée, connectez-vous et cliquez sur "Settings" pour modifier la langue utilisée et basculer l'interface en français.
3. Cliquez sur "Administration", et activez le plugin "Acc'Essone". Ce plugin rassemble l'ensemble des modifications *spécifiques* de cette distribution, et doit toujours être placé en fin de liste. Il spécifie également une série de dépendances obligatoires ou facultatives : vous devez d'abord activer les dépendances obligatoires (required) pour pouvoir activer ce plugin.
4. Activez les autres plugins de votre choix
5. Configurez le site :
  1. Paramètres > Réglages de base
  2. Paramètres > Paramètres avancés
  3. Apparence > Configuration du thème (propre à ESOPE)
  4. puis en fonction des plugins activés
6. Si vous souhaitez modifier l'apparence ou les foncitonnalité au-delà des possibilités proposées par ESOPE, créez un plugin de thème (par ex. theme_montheme) et placez-le en toute fin de liste, après "Acc'Essonne".

Note : Si vous n'avez accès qu'à la racine web (par ex. sur un hébergement mutualisé), vous pouvez créer le dossier "data" dans ce répertoire et ajouter dans data/ un fichier .htaccess avec pour contenu : deny from all


### Sécurisation
De nombreuses mesures peuvent être prises du côté du serveur, notamment via la mise en place d'une connexion HTTPS (nécesite un certificat valide) et diverses options de configuration d'Apache.

Quelques pistes d'ajouts complémentaires à intégrer aux fichiers .htaccess. Attention : certaines de ces instructions peuvent bloquer l'intégration de contenus tiers -embed- voire bloquer le foncitonnement de certaines scripts ; veuillez les tester soigneusement avant de les utiliser en production :

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



## Contenu de la plateforme
* Elgg core, et plugins associés
* Traduction intégrale FR
* Un plugin qui sert de pivot à cette distribution : adf_public_platform ("Acc'Essonne")
* Plusieurs thèmes et développements pour des usages spécifiques
* De nombreux plugins communautaires vérifiés


### Elgg Core (plugins inclus dans la distribution standard)
* blog
* bookmarks
* categories
* custom_index
* dashboard
* developers
* diagnostics
* embed
* externalpages
* file
* garbagecollector
* groups
* htmlawed
* invitefriends
* likes
* logbrowser
* logrotate
* members
* messageboard
* messages
* notifications
* pages
* oauth_api (supprimé des dernières versions)
* profile
* reportedcontent
* search
* tagcloud
* thewire
* tinymce
* twitter_api
* uservalidationbyemail
* zaudio


### ESOPE core (plugins spécifiques à ESOPE)
* adf_public_platform (Acc'Essonne, ESOPE) : thème accessible et configurable - le coeur de cette distribution
	- configuration du thème : éléments d'interface, couleurs, polices, styles
	- réorganisation des menus et de la page d'accueil
	- nombreux réglages fonctionnels : groupes, notifications, outils, recherche, etc.
	- accessibilité améliorée (notamment navigation au clavier)
	- liste de pages publiques explicitement définies
	- et de nombreux réglages avancés...
* adf_registration_filter (Inscript-Essonne, ESOPE) : inscriptions limitées en fonction de noms de domaines autorisés (accès réservé aux membres d'une ou plusieurs organisations)


### Thèmes (thèmes spécifiques construits à partir d'ESOPE)
* theme_cocon : Thème Collèges connectés (Ministère de l'éducation nationale, DNE)
* theme_compnum : Thème Compétences Numériques B2i Adultes (FormaVia)
* theme_inria : Thème Iris (Inria)

### Plugins communautaires
* access_icons
* advanced_notifications (ColdTrick)
* advanced_statistics (ColdTrick)
* announcements
* apiadmin
* au_subgroups (Matt Beckett, Athabasta University)
* auto_sitemap
* backup-tool
* blog_tools (ColdTrick)
* cmspages (Facyla)
* comment_tracker
* croncheck
* digest (ColdTrick)
* dossierdepreuve (FormaVia)
* elgg-brainstorm (Manutopik)
* elgg_cas (Inria)
* elgg_cmis (Inria)
* elgg_file_viewer
* event_calendar (Kevin Jardine)
* export_embed (Facyla)
* externalmembers (version de développement) : projet de plugin de gestion d'accès externes limités à certaines ressources
* feedback (Facyla)
* file_tools (ColdTrick)
* friend_request
* gdocs_file_previewer
* group_chat (Facyla)
* group_operators
* guidtool (ESOPE)
* html_email_handler (ColdTrick)
* hybridauth (Facyla)
* ldap_auth (Inria)
* ldap_auth_old (ancienne version de ldap_auth)
* login_as
* mailing (Facyla)
* metatags
* new_event_calendar (version de développement de event_calendar)
* newsletter (ColdTrick)
* no_friends
* notification_messages (Facyla)
* pdf_export (Facyla)
* plugin_template (ESOPE, modèle de plugin)
* prevent_notifications (Facyla)
* profileiconaccess
* profile_manager (ColdTrick)
* related-items
* security_tools (ColdTrick)
* shortcodes (Team Webgalli)
* simplepie (Facyla)
* slider (Facyla)
* threads
* tidypics
* translation_editor (ColdTrick)
* twitter
* uservalidationbyadmin
* upload_users
* vazco_text_captcha (Vasco)
* videos
* views_counter
* web_services


