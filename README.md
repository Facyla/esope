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


## Installation d'ESOPE
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



## Présentation d'ESOPE
ESOPE est le nouveau nom du projet initié en partenariat sous le nom de "Departements en réseaux" par l'Assemblée des Départements de France, le Conseil Général de l'Essonne, et ITEMS International.
Departements-en-reseaux.fr est une plateforme collaborative proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.
Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.
Crédits
* la version originelle et les adaptations graphiques initiales de Départements en réseaux ont été réalisés grâce au soutien du Conseil Général de l'Essonne, par ITEMS International (intégration et développement) et Urbilog (graphisme et accessibilité)


## Conception et maintenance d'ESOPE
* Florian DANIEL - Facyla / ITEMS International


## Principaux contributeurs
* Conseil Général de l'Essonne
* Assemblée des Départements de France (ADF)
* ITEMS International
* Agence Nationale de Lutte Contre l'Illetrisme (ANLCI)
* Région Rhône-Alpes (via le projet FormaVia)
* Inria
* Cartier International


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


