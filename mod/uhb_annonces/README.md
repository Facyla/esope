# UHB Annonces

Ce plugin répond au besoin d'une fonctionalité d'un service de publication, recherche et candidature pour l'emploi et l'intégration professionnelle.

Il permet :
* le dépôt d'offres par des professionnels, sans obligation de création de compte, et le suivi
de cette offre
* la recherche parmi les offres pour les étudiants, le suivi des candidatures envisagées et
effectives
* Pour le PFE (pôle formation emploi) : la gestion du cycle de vie des annonces (durée de publication, validation), les indicateurs de candidatures et d'offres.


# Installation
1. Vérifier les dépendances
2. Activer le plugin
3. Configurer le plugin
4. Ajouter une entrée dans le menu du site qui pointe vers "annonces"



# Notes sur tests de charges :
## Données de test :
	3798 offres au total, dont :
		2384 annonces dans l'état "initial".
		79 annonces à valider pour publication.
		92 annonces obsolètes en cours de relance.
		772 annonces signalées comme étant pourvues par les membres du réseau.
		230 annonces pourvues.
		19 annonces archivées.

''Note :''
L'algo Elgg standard n'entre pas dans la comparaison : au-delà du seuil de 5 à 8 critères simultanées, pour moins de 50 annonces totales, les requêtes commencent à dépasser les 1 à 5 secondes, avec croissance exponentielle.
Une fois ce seuil passé, la requête plante à 1 ou 2 critères de plus

3 algo comparés : tous avec pré-filtrage des résultats à partir des types d'entités valides
	A : ajout de filtres multiples à une seule requête
	B : filtres en cascade, via une seule requête "imbriquée", les résultats d'une filtres sont chargés dans une clause du suivant
	C : série de filtres successifs, sous la forme de plusieurs requêtes SQL successives, qui réduisent à chaque fois la liste des résultats possibles

## Résultats

### En secondes, avec 20 filtres simultanés (soit tous en mode admin) :

Notes : 
	dans tous les cas, 355 résultats
	le temps de récupération des entités peut varier

A - filtres multiples : 1.3004
B - filtres en cascade : 3.3525
C - filtres successifs : 0.5705


### 2e recherche avec 1 critère de moins (test des caches)

A - filtres multiples : 1.4455
B - filtres en cascade : 3.3526
C - filtres successifs : 0.1851


### Recherche complexe (14 critère) mais ne produisant aucun résultat :
A - filtres multiples : 0.8508
B - filtres en cascade : 1.1996
C - filtres successifs : 0.0084

=> Méthode C mise en place suite aux tests de charge, avec 2 effets :
	- rapidité de la requête sur de nombreux critères
	- meilleures capacités d'utilisation des caches SQL
	- optimisation pour requêtes ne renvoyant pas de résultats



# Procédure de test en charge
Cette méthode duplique les annonces existantes, afin de générer un nombre important d'annonces pour effectuer des tests.
Elle effectue cette duplication en clonant les dernières annonces trouvées, avec une limite configurable (40 par défaut).

1. créer au moins une annonce dans chaque état, si possible créées par plusieurs types d'auteur (anonyme, admin, membre)
2. à partir de la page de recherche, ajouter le paramètre ?test_clone=clone soit par exemple URL_SITE/annonces/search?test_clone=clone
3. Pour modifier le nombre d'annonces dupliquées à chaque affichage de la page, ajouter un paramètre &clone_limit=XX
4. Noter que cette procédure peut générer des Internal server error selon les réglages d'Apache, sans incidence sur la création des annonces ni sur le fonctionnement du site.



