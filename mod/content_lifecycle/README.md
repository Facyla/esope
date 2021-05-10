Content Lifecycle / Cycle de vie des contenus
=============================================

Activez ce plugin pour définir des règles de gestion du cycle de vie des contenus. 

## Principe de fonctionnement
Ce plugin intercepte la suppression d'un compte utilisateur et offre à un compte administrateur la possibilité de choisir de transférer certains types de contenus vers d'autres comptes avant supression :

Fonctionnalités : 
 - transfert ou suppression de contenus non personnels associés à un compte utilisateur supprimé



## Installation
 - Installer le plugin (dossier "mod/") puis l'activer via le panneau d'administration.
 - Définir les paramètres du plugin : ces réglages seront utilisés par défaut lors de la suppression d'un compte


## Utilisation
 - un administrateur décide de supprimer un compte utilisateur
 - une page intercalaire permet de choisir quelles options appliquer : transfert ou supression définitive, et destinataire du transfert
 - des options avancées permettent de définir plus finement quels types de contenus transférer et à qui : groupes, types de contenus
 - des listes des contenus concernés permettent enfin de choisir l'action à effectuer contenu par contenu

Cette page de configuration définit les choix qui sont présélectionnés par défaut.


## ROADMAP
 * transfert manuel pour les contenus
 * des fonctionnalités spécialisées en lien avec la RGPD ?
 * suppression temporisée du compte et des contenus (par ex. désactivé puis supprimé après une durée de conservation règlementaire)


## HISTORY
3.3.0 : 20210510
 - première version opérationnelle

3.3.0-dev : 20210506
 - création du plugin


