# Environnement Social Opensource Public Elgg (ESOPE)
> Elgg Social Opensource Public Environment)
ESOPE est une distribution francisée d'Elgg, conçue pour faciliter et accélérer la mise en place de plateformes collaboratives "clefs en main".

Elle consiste en une collection cohérente de plugins communautaires et spécifiques, adaptés aux usages des collectivités territoriales, ou plus généralement d'organisations souhaitant disposer d'une plateforme collaborative interne, tout en réservant la possibilité de publier des contenus publics.

Suite à ses évolutions, elle permet également de proposer des réseaux publics ou à usage mixte intranet / extranet / réseau social / site web collaboratif / plateforme de formation.


## Quelle version choisir ?
* esope_1.8 : **branche de production - version LTS**
* esope_1.9 : *branche intermédiaire - mises à jour seulement*
* esope_1.10 : *branche intermédiaire - mises à jour seulement*
* esope_1.11 : *branche intermédiaire - mises à jour seulement*
* esope_1.12 : **branche de production - version LTS**
* esope_2.0 : *branche intermédiaire - mises à jour seulement*
* esope_2.1 : *branche intermédiaire - mises à jour seulement*
* esope_2.2 : *branche intermédiaire - mises à jour seulement*
* esope_2.3 : **branche de production - version LTS**
* esope_3.0 : *branche intermédiaire - mises à jour seulement*
* esope_3.1 : *branche intermédiaire - mises à jour seulement*
* esope_3.2 : *branche intermédiaire - mises à jour seulement*
* esope_3.3 : **branche de production - version LTS**



## A propos d'Elgg
* Elgg core : https://github.com/Elgg/Elgg
* Documentation (en français) : http://learn.elgg.org/fr/3.3/
* Documentation de référence du code : http://reference.elgg.org/


## A propos d'ESOPE
A l'origine, ESOPE est issue du projet partenarial "Departements en réseaux" initié par l'Assemblée des Départements de France, le Conseil Général de l'Essonne, et ITEMS International, qui visait à construire une plateforme collaborative opensource, francisée et accessible.
Un travail spécifique d'accessibilité a été mené avec l'appui de la société Urbilog.
Ce projet a donné lieu au site Departements-en-reseaux.fr, plateforme collaborative opensource proposée aux collectivités territoriales et acteurs publics qui souhaitent s'appuyer sur des réalisations et une communauté d'utilisateurs existants pour déployer leur propre projet.
Le projet opensource est porté depuis par Facyla. 


ESOPE est constituée :
* d'une base d'Elgg générique (core),
* et d'une collection cohérente de plugins communautaires, adaptés à divers types d'organisations souhaitant disposer d'une plateforme sociale ou collaborative interne, publique ou mixte.

La distribution ESOPE offre de très nombreux réglages et possibilités de personnalisation qui permettent d'ajuster l'apparence et le comportement d'Elgg à une large gamme d'usages collaboratifs ou sociaux. Ces réglages sont directelent accessibles aux administrateurs, sans nécessiter de développement ni d'intervention plus technique.

ESOPE est également adaptée pour fournir une base sur laquelle construire des thèmes légers.


### Version
Les versions d'ESOPE suivent la politique de versions de Elgg, avec au moins le même niveau de support pour les versions LTS. 


### Conception et maintenance
* Florian DANIEL aka Facyla


### Principaux contributeurs
* Florian DANIEL, aka Facyla
* Assemblée des Départements de France (ADF)
* Conseil Général de l'Essonne
* ITEMS International
* Fondation Internet Nouvelle Génération (FING)
* Agence Nationale de Lutte Contre l'Illetrisme (ANLCI)
* Région Rhône-Alpes (via le projet FormaVia)
* Inria
* Cartier International


## Contenu de la plateforme
* Elgg core + plugins associés
* Traduction FR intégrale
* De nombreux plugins communautaires vérifiés (disponibles séparemment auprès de leurs auteurs respectifs)
* De nombreux plugins spécifiques (disponibles via ESOPE ou dans un repository spécifiques de https://github.com/Facyla )



## Installation d'ESOPE
### PRE-REQUIS : http://docs.elgg.org/wiki/Installation/Requirements
- Serveur Web (Apache ou nginx)
- PHP 7.2 à 7.4
- extensions PHP : GD, PDO, JSON, XML, Multibyte String support, et la possibilité d'envoyer des mails. D'autres extensions peuvent être requises selon les plugins activés.
- MySQL 5.5+
- URL rewriting

### Procédure d'installation
L'installation et les mises à jour ou changements de version d'ESOPE peuvent être gérés via Git : c'est la méthode privilégiée afin faciliter les mises à jour. Il est cependant possible de copier les fichiers source. 
1. Création des dossiers et bases pour accueillir l'application : 
  1. Placez les scripts dans le répertoire de l'hôte choisi, par ex. dans /var/www/esope/www/ : pour cela faites un git clone 
  2. Créer un répertoire pour les données, hors du répertoire web, par ex. dans /var/www/esope/data/
2. Créez une base de données MySQL
3. Installez l'application : visitez la page web, qui vous redirige sur le script d'installation, et suivez les instructions. Vous pourrez avoir besoin d'effectuer des modifications de configuration si nécessaire : les plus fréquentes sont de modifier les droits d'accès sur les dossiers d'installation, et activer le module php mod_rewrite. 
4. Créez le compte administrateur principal. 
5. Configuration initiale : 
  1. Une fois l'installation terminée, connectez-vous et cliquez sur "Settings" pour modifier la langue utilisée et basculer l'interface en français.
  2. Cliquez sur "Administration", puis "Plugins" pour activer les fonctionnalités de votre choix. 
  3. Configurez le site :
    1. Paramètres > Réglages de base
    2. Paramètres > Paramètres avancés
    3. Configuraiton des autres plugins, en fonction de ceux activés
6. Si vous souhaitez modifier l'apparence ou les foncitonnalité au-delà des possibilités proposées par ESOPE, créez un plugin de thème (par ex. theme_montheme) et placez-le en toute fin de liste.

Note : Si vous n'avez accès qu'à la racine web (par ex. sur un hébergement mutualisé), vous pouvez créer le dossier "data" dans ce répertoire et ajouter dans data/ un fichier .htaccess avec pour contenu : deny from all. 




### Sécurisation
Il est recommandé de ne permettre l'accès qu'à travers une connexion HTTPS (nécesite un certificat valide, par ex. avec LetsEncrypt). 
En savoir plus sur les options de sécurité dans Elgg : http://learn.elgg.org/fr/3.3/admin/security.html?highlight=s%C3%A9curit%C3%A9


