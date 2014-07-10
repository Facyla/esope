> ESOPE pour Environnement Social Opensource Public Elgg, est une distribution francisée d'Elgg, conçue pour faciliter et accélérer la mise en place de plateformes collaboratives "clefs en main".
> In english: Elgg Social Opensource Public Environment)


# A propos d'Elgg
Lire [README.txt](README.txt)
* Copyright :  [COPYRIGHT.txt](COPYRIGHT.txt)
* Contributeurs : [CONTRIBUTORS.txt](CONTRIBUTORS.txt)
* Licence : [LICENSE.txt](LICENSE.txt)
* Installation : [INSTALL.txt](INSTALL.txt)
* Mise à jour : [UPGRADE.txt](UPGRADE.txt)


# Installation d'ESOPE
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



# Présentation d'ESOPE
ESOPE est le nouveau nom du projet initié sous le nom de "Departements en réseaux" en partenariat par l'Assemeblée des Départements de France, le Conseil Général de l'Essonne, et ITEMS International.
Departements-en-reseaux.fr est une plateforme collaborative proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.
Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.
Crédits
* la version originelle de Départements en réseaux a été réalisée grâce au soutien du Conseil Général de l'Essonne, en partenariat avec l'Assemblée des Départements de France (ADF)
* Conception, réalisation et maintenance : Facyla ~ Florian DANIEL / ITEMS International
* Conception graphique et accessibilité : Urbilog


# Contenu de la plateforme
* Elgg core, et plugins associés
* Traduction intégrale FR (et bien sûr EN)
* Plusieurs plugins communautaires (testés pour leur intégration, et parfois améliorés)
* Un plugin qui sert de pivot à cette distribution : adf_public_platform ("Acc'Essonne")
* Plusieurs thèmes et développements pour des usages spécifiques

## Plugins communautaires
* brainstorm (Manutopik)
* profile_manager (ColdTrick)
* event_calendar (Kevin Jardine)
* friend_requests
* group_operators
* guidtool
* login_as
* profile_manager
* threads
* & much more

## Développements spécifiques à cette distribution
* Acc'Essonne : thème accessible et configurable - le coeur de cette distribution
	* réorganisation des menus
	* modifications fonctionnelles : groupes, notifications, outils, etc.
	* accessibilité : plateforme accessible aux utilisateurs handicapés (navigation au clavier et lecture d'écran)
	* liste de pages publiques explicitement définies
* Inscript-Essonne : inscriptions limitées en fonction de noms de domaines autorisés (accès réservé aux membres d'une ou plusieurs organisations)
* En projet
	* accès externes limités à certaines ressources, pour permettre des accès limités à des collaborateurs externes


# Conception et maintenance
* Florian DANIEL - Facyla


# Principaux contributeurs
* Conseil Général de l'Essonne
* Assemblée des Départements de France (ADF)
* ITEMS International
* Agence Nationale de Lutte Contre l'Illetrisme (ANLCI)
* Région Rhône-Alpes (via le projet FormaVia)
* Inria
* Cartier International



