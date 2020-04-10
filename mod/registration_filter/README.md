Registration Filter / Filtre d'inscription
=======================================

EN : Filters account registration based on email domains. 
Enable this plugin if you wish to allow a custom list of allowed email domains to register, or define a list of emails domains that should be denied registration (antispam mode).

FR : Filtrage des adresses autorisées à créer un compte. 
Activez ce plugin si vous souhaitez restreindre l'inscription exclusivement à certains noms de domaines.


## Installation
- Add the plugin to "mod/" folder, and enable it in admin panel
- Define plugin settings: 
  - choose white or blacklist mode: 
   * white list: only email matching the domain list are allowed to register.
   * blacklist / antispam: emails matching this domain list will be refused without any message. 
  - add your custom domains list


- Installer le plugin (dossier "mod/") puis l'activer via le panneau d'administration.
- Définir les paramètres du plugin : 
  - activer l'un des deux modes de fonctionnement : 
   * liste blanche : seuls les emails d'une liste de noms de domaines sont autorisés à créer un compte.
   * blacklist / antispam : les noms de domaines de cette liste sont rejetés sans aucun message. 
  - ajouter la liste des noms de domaines correspondante


## ROADMAP
 * suggestions welcomed


## HISTORY
3.3.0 : 20200410
	- upgrade to Elgg 3.3
	- setting : enable/disable registration form extend

0.4.1 : 20150719
	- admin bypass to allow direct account creation by admin

0.4 : 20150610 - Updated to Elgg 1.11
	- renamed to registration_filter

0.3 : 20150525 - +blacklist mode

0.2.2 : activé à l'installation

0.2.1 : ajustement du filtrage du username : remplacement des '@' par des '_' mais on garde les '.' (le tiret n'étant pas un caractère valide)

0.2 : suppression du username (généré à partir de l'adresse mail d'inscription)

0.1 : première version opérationnelle


