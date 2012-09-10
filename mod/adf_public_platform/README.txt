ADF_public_platform

Le plugin adf_registration_filter permet de filtrer les noms de domaines autorisés à s'inscrire. Il a été développé comme plugin indépendant car il s'agit d'une fonctionnalité très générique.


Attention : un changement du nom du dossier du plugin risquerait de l'empêcher de fonctionner : changer plutôt le titre dans le fichier manifest.xml


Les adaptations sont faites autant que possible sans modifier ni même surcharger les plugins existants.

Cela reste cependant parfois nécessaire :
- lors du passage 1.8.0.1 => 1.8.1, les page_handler nécessitent que l'on renvoie une valeur true pour ne pas rediriger sur l'accueil (activity précisément). Les auteurs des plugins ont été prévenus.
- certaines surcharges via le plugin sont nécessaires pour la gestion des inscriptions, et des menus
- les principales surcharges sont liées à la base de thème utilisée : faire très attention lors d'une mise à niveau du core car les fichiers images ne vont pas forcément correspondre (il est conseillé de garder les fichiers originaux de la version - cela concerne surtout le fichier elgg_sprites qui regroupe tous les éléments d'interface..)

