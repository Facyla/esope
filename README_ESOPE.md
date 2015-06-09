# Environnement Social Opensource Public Elgg (ESOPE)
> Elgg Social Opensource Public Environment)
ESOPE est une distribution francisée d'Elgg, conçue pour faciliter et accélérer la mise en place de plateformes collaboratives "clefs en main".

Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.

Suite à ses évolutions, elle permet également de proposer des réseaux publics ou à usage mixte intranet / extranet / réseau social / site web collaboratif / plateforme de formation.


## Quelle version choisir ?
* esope_1.8 : RECOMMANDEE POUR LA PRODUCTION
* esope_1.9 : branche intermédiaire - partiellement fonctionnelle
* esope_1.10 : branche intermédiaire - non fonctionnelle
* esope_1.11 : DEVELOPPEMENT - prochaine version majeure d'ESOPE


## A propos d'Elgg
Lire [README.txt](README.txt)
* Copyright :  [COPYRIGHT.txt](COPYRIGHT.txt)
* Contributeurs : [CONTRIBUTORS.txt](CONTRIBUTORS.txt)
* Licence : [LICENSE.txt](LICENSE.txt)
* Installation : [INSTALL.txt](INSTALL.txt)
* Mise à jour : [UPGRADE.txt](UPGRADE.txt)


## A propos d'ESOPE
A l'origine, ESOPE est issue du projet partenarial "Departements en réseaux" initié par l'Assemblée des Départements de France, le Conseil Général de l'Essonne, et ITEMS International, qui visait à construire une plateforme collaborative opensource, francisée et accessible.
Un travail spécifique d'accessibilité a été mené avec l'appui de la société Urbilog.
Ce projet a donné lieu au site Departements-en-reseaux.fr, plateforme collaborative opensource proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.



ESOPE est constituée :
* d'une base d'Elgg générique (core),
* d'un plugin générique en surcouche, qui permet de modifier l'apparence et le comportement du site,
* et d'une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages d'organisations souhaitant disposer d'une plateforme collaborative interne, publique ou mixte.

La distribution ESOPE offre de très nombreux réglages et possibilités de personnalisation qui permettent d'ajuster l'apparence et le comportement d'Elgg à une large gamme d'usages collaboratifs ou sociaux. Ces réglages sont directelent accessibles aux administrateurs, sans nécessiter de développement ni d'intervention plus technique.

ESOPE est également adaptée pour fournir une base sur laquelle construire des thèmes légers.


### Version
ESOPE suit de près les évolutions du "core" d'Elgg ; la version de production actuelle s'appuie sur Elgg 1.8.20
Cette version est en cours de développement et s'appuie sur Elgg 1.9.7.


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



# ESOPE 1.11 Upgrade status : IN PROGRESS

## Elgg core version : 1.11.2

## ESOPE plugins update
- core : core 1.11.2 plugin
- 1.11 : plugin version ready for 1.11
- wait : not available yet
- todo : to be done...


| State | Plugin name | Source / URL | Comments |
|:-----:|:------------|:-------------|:---------|
|     	| aalborg_theme | (core) ||
| todo	| access_icons |
| todo	| adf_registration_filter | ESOPE ||
| todo	| advanced_notifications | https://github.com/Coldtrick/advanced_notifications |
| 1.9		| advanced_statistics | https://github.com/Coldtrick/advanced_statistics |
| todo	| announcements | https://github.com/ewinslow/elgg-announcements | deprecated : convert to blog posts |
| todo	| apiadmin | https://github.com/fmestrone/apiadmin | existing forks for 1.9 |
| wait	| au_subgroups | https://github.com/AU-Landing-Project/au_subgroups |
| wait	| auto_sitemap | https://github.com/theyke/Elgg-AutoSitemap-Plugin | Not available 20150108 |
| todo	| backup-tool | https://code.google.com/p/backup-tool/ | Not maintained |
|     	| blog | (core) ||
| 1.9 	| blog_tools | https://github.com/ColdTrick/blog_tools |
|     	| bookmarks | (core) ||
|     	| categories | (core) ||
|     	| ckeditor | (core) ||
| todo	| cmspages | ESOPE | Missing search functions upgrade |
| 1.9		| code_review | https://github.com/Srokap/code_review |
| 1.9		| comment_tracker | https://github.com/AU-Landing-Project/Comment-Tracker-1.8.x |
| todo	| croncheck |
|     	| custom_index | (core) ||
|     	| dashboard | (core) ||
| todo	| deleted_user_content |
|     	| developers | (core) ||
|     	| diagnostics | (core) ||
| 1.9		| digest | https://github.com/ColdTrick/digest |
| todo	| dossierdepreuve | ESOPE ||
| todo	| elgg-brainstorm |
| todo	| elgg_cas | ESOPE ||
| todo	| elgg_cmis | ESOPE ||
| todo	| elgg_dataviz | ESOPE ||
| todo	| elgg_etherpad | ESOPE ||
| todo	| elgg_file_viewer |
|     	| embed | (core) ||
| todo	| esope : former adf_public_platform, much work to do |
| todo	| event_calendar | https://github.com/kevinjardine/Elgg-Event-Calendar/tree/full ||
| todo	| export_embed | ESOPE ||
| todo	| externalmembers |
|     	| externalpages | (core) ||
| todo	| feedback | ESOPE ||
|     	| file | (core) ||
| 1.9		| file_tools | https://github.com/Coldtrick/file_tools |
| todo	| friend_request |
|     	| garbagecollector | (core) ||
| todo	| gdocs_file_previewer | https://github.com/thomasyung/GDocs-File-Previewer | Not maintained |
| todo	| group_chat | ESOPE ||
| wait	| group_operators | https://github.com/lorea/group_operators/ | Not maintained ? |
|     	| groups | (core) ||
| todo	| guidtool | ESOPE ||
|     	| htmlawed | (core) ||
| 1.9		| html_email_handler | https://github.com/ColdTrick/html_email_handler |
| todo	| hybridauth | ESOPE ||
| todo	| impress_js | ESOPE ||
|     	| invitefriends | (core) ||
| todo	| knowledge_database | ESOPE ||
| todo	| ldap_auth | ESOPE ||
| todo	| leaflet | ESOPE ||
|     	| legacy_urls | (core) ||
|     	| likes | (core) ||
|     	| logbrowser | (core) ||
| todo	| login_as | https://github.com/brettp/Login-As ||
|     	| logrotate |
| todo	| mailing |
|     	| members | (core) ||
|     	| messageboard | (core) ||
|     	| messages | (core) ||
| todo	| metatags |
| 1.9		| newsletter | https://github.com/ColdTrick/newsletter |
| todo	| no_friends |
| todo	| notification_messages |
|     	| notifications | (core) ||
| todo	| oauth_api |
| todo	| pdf_export | ESOPE ||
| todo	| pin | ESOPE ||
| todo	| plugin_template | ESOPE ||
| todo	| postbymail | ESOPE ||
| todo	| prevent_notifications | ESOPE ||
|     	| profile | (core) ||
| todo	| profileiconaccess |
| 1.9		| profile_manager | https://github.com/ColdTrick/profile_manager |
| todo	| related-items |
|     	| reportedcontent | (core) ||
| todo	| rssimport |
|     	| search | (core) ||
| todo	| security_tools |
| todo	| shortcodes |
| todo	| simplepie |
|     	| site_notifications | (core) ||
| todo	| slider | ESOPE ||
| todo	| socialshare | ESOPE ||
|     	| tagcloud | (core) ||
| todo	| theme_cocon | ESOPE ||
| todo	| theme_compnum | ESOPE ||
| todo	| theme_fing | ESOPE ||
| todo	| theme_inria | ESOPE ||
| todo	| theme_template | ESOPE ||
|     	| thewire | (core) ||
| todo	| threads |
| 1.9 	| tidypics | https://github.com/iionly/Elgg_1.9_tidypics ||
| todo	| tinymce |
| todo	| togetherjs | ESOPE ||
| 1.9		| translation_editor | https://github.com/ColdTrick/translation_editor |
| todo	| twitter |
|     	| twitter_api | (core) ||
| todo	| upload_users | https://github.com/arckinteractive/upload_users | Replaced by Elgg plugin  |
| todo	| uservalidationbyadmin | https://github.com/ColdTrick/uservalidationbyadmin | Previous version based on TeamWebgalli + changes |
|     	| uservalidationbyemail | (core) ||
| todo	| vazco_text_captcha |||
| todo	| videos |
| todo	| views_counter |
|     	| web_services | (core) ||
|     	| zaudio | (core) ||



## Other plugins to be checked / updated (not in ESOPE)
| todo	| addthis |
| wait	| au_analytics |
| todo	| au_sets |
| todo	| bookmark_tools |
| todo	| cas_auth |
| todo	| cocon_sgmap |
| todo	| containers |
| todo	| csv_import |
| todo	| csv_process |
| todo	| czd_data |
| todo	| disable_friends |
| todo	| draw |
| todo	| elgg_d3js |
| todo	| elgg_dropzone |
| todo	| elgg-ggouv_pad |
| todo	| elgg_social_login |
| todo	| embedvideo |
| todo	| entitymenu_dropdown |
| todo	| entity_view_counter |
| todo	| etherpad |
| todo	| event_calendar_ical |
| todo	| event_manager |
| todo	| externalblogs |
| todo	| facebook_connect |
| todo	| galliShortcodes |
| todo	| google_login |
| todo	| group_alias |
| todo	| group_tools |
| todo	| homepage_cms |
| todo	| ical_viewer |
| todo	| iframe_widget |
| todo	| image_proxy |
| todo	| infinite_scroll |
| todo	| lazy_load |
| todo	| ldap_auth_old |
| todo	| liked_content |
| todo	| linkedin |
| todo	| livesearch18 |
| todo	| location_autocomplete |
| todo	| maghrenov_kdb |
| todo	| menu_builder |
| todo	| mission |
| todo	| mobile_apps |
| todo	| new_event_calendar |
| todo	| notification_subjects | https://github.com/AU-Landing-Project/Notification-Subjects |
| todo	| openbadges |
| todo	| original_ldap_auth |
| todo	| osm_maps |
|     	| pages |
| todo	| persona |
| todo	| project_manager |
| todo	| project_workflow |
| todo	| protovis |
| todo	| qrcode |
| todo	| relatedgroups |
| todo	| rendezvous |
| todo	| search_advanced |
| todo	| siteoffline |
| todo	| social_connect |
| todo	| speak_freely |
| todo	| tabbed_profile |
| todo	| theme_cwia |
| todo	| theme_items |
| todo	| theme_maghrenov |
| todo	| version_check |
| todo	| vroom |
| todo	| webinar |
| todo	| webodf |
| todo	| websockets |
| todo	| widget_manager |




