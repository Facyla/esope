Account Lifecycle / Cycle de vie des comptes utilisateurs
=========================================================

Activez ce plugin si vous souhaitez effectuer une vérification périodique des comptes. 

Cette extension propose un mode "direct" et un mode "complet". Le mode "direct" est opérationnel, tantdis que l'autre vise à dessiner la future roadmap du plugin. 

# Mode direct
Vérification des comptes tous les X jours, avec envoi d'un email de re-vérification du compte à la date d'échéance. Lors de la re-vérification, les comptes sont désactivés - et le restent jusqu'à leur vérification. 
Options : 
 - inclure ou non les comptes admin
 - intervale entre 2 vérifications en jours
 - action à effectuer (pour le moment, seulement demander une validaiton du compte par email)


# Mode complet - EN COURS - ROADMAP
Le mode complet permet de créer des règles de gestion du cycle de vie des comptes utilisateurs. Chaque règle de gestion comporte : 
 - des critères de sélection des comptes (admin/tous, jeux de comparaison de métadonnées/valeurs, en l'absence de connexion depuis X jours, etc.)
 - une date de début et un intervale de vérification en jours
 - des dates de rappel avant d'appliquer le règle (en jours avant l'échéance)

Rappels : selon le type d'action, par ex. pour une re-validation annuelle des comptes via le site : rappels 1 mois, puis 1 semaine, 3 jours et 1 jour avant, puis désactivation du compte si aucune action effectuée. 

Et actions ponctuelles : 
- régénération nouveau mot de passe (envoi par email)


## Installation
- Installer le plugin (dossier "mod/") puis l'activer via le panneau d'administration.
- Définir les paramètres du plugin


## ROADMAP
 * introduction de plusieurs types de délais et types d'actions liées à un cycle de vie : 
   * J+X : désactivation et revalidation
   * J+X+Y : anonymisation des comptes (suppression email et données personnelles)
 * poursuite du développement du mode "complet"
 * des suggestions ?


## HISTORY
3.3.0 : 20210421
 - version initiale

3.3.0-dev : 20210329
 - création du plugin


