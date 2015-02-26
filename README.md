Cocon - Méthode
===============

## Présentation
"Cocon - Méthode" est un module pour Elgg et destiné à être utilisé dans le cadre du programme "Cocon - Collèges Connectés".

Son développement a été réalisé par PWC pour le Secrétariat Général pour la Modernisation de l'Action publique (SGMAP), et son intégration par ITEMS International pour la Direction du Numérique pour l'Education (DNE).

> Vous trouverez ici un accompagnement méthodologique pour mener une démarche innovante de développement des pratiques numériques pédagogiques au sein de votre collège. Il fournit :
>  - des préconisations pour définir la feuille de route de mise en œuvre la plus une démarche adaptée aux spécificités de votre collège, 
>  - des outils facilitant la mise en œuvre et le suivi de chacun desde cette démarche en 3 temps de la démarche.
> 
> ### En bref, en quoi consiste cette démarche ?
> Cette démarche vise à développer des pratiques numériques en réponse aux préoccupations pédagogiques des enseignants de votre collège. Elle s’appuie sur la mise en place d’une dynamique collective au sein de la communauté enseignante pour faire progressivement évoluer les comportements en tirant parti des ressources et équipements numériques existants.



## Pré-requis :
Ce plugin est conçu pour être intégré dans l'environnement Cocon, qui s'appuie sur :

1. la distribution Elgg / ESOPE
2. le plugin theme_cocon

Il n'est pas prévu pour être utilisé hors de cet environnement.



## Installation

1. Ce plugin nécessite une base de données indépendante de celle d'Elgg : 
	1. Créer une base de données, du même nom que celle d'Elgg, avec la terminaison "_methode", par ex. DB_NAME => DB_NAME_methode
	2. Importer le script SQL dans la nouvelle base : script disponible dans cocon_methode/vendors/cocon_methode/sql/base.sql
2. Vérifier que le serveur peut bien lire et écrire dans le dossier mod/cocon_methode/vendors/cocon_methode/_tmp/ (fichiers temporaires)
3. Activer le plugin "Méthode" + Vérifier que le plugin "Thème Cocon" est activé
4. Créer (via profile_manager) les champs de profil suivants :
	- cocon_etablissement (Type : Etablissement)
	- cocon_fonction (Type : Fonction)
	- cocon_discipline (Type : Discipline)
	- Puis définir pour chacun les paramètres :
		- montrer sur le formulaire d'inscription, 
		- obligatoire, 
		- modifiable par le membre, 
		- afficher comme tag
5. Configurer le plugin "Thème Cocon" avec les valeurs souhaitées pour chacun des 3 champs



## Utilisation
L'accès aux fonctionnalités s'effectue via l'adresse ADRESSE_DU_SITE/**methode**



## Notes techniques
Le dossier @tech_doc liste les fichiers modifiés pour l'intégration en tant que plugin Elgg.


