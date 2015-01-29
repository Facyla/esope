Installation :

1) Créer une base de données, du même nom que celle d'Elgg, avec la terminaison "_methode", par ex. DB_NAME => DB_NAME_methode
2) Importer le script SQL dans la nouvelle base : script disponible dans cocon_methode/vendors/cocon_methode/sql/base.sql
3) Vérifier que le serveur peut bien lire et écrire dans le dossier mod/cocon_methode/vendors/cocon_methode/_tmp/ (fichiers temporaires)
4) Activer le plugin "Méthode" + Vérifier que le plugin "Thème Cocon" est activé
5) Créer, si ce n'est déjà fait, les champs de profil suivants, avec les paramètres (montrer sur le formulaire d'inscription, obligatoire, modifiable par le membre, afficher comme tag)
	cocon_etablissement (Type : Etablissement)
	cocon_fonction (Type : Fonction)
	cocon_discipline (Type : Discipline)
6) Configurer le plugin "Thème Cocon" avec les valeurs souhaitées pour chacun des 3 champs précédents
7) Accéder aux fonctionnalités via l'adresse SITE_URL/methode

User profile metadata : to be created through profile manager, with settings : 


Note : while it is possible to use this plugin outside from Cocon website, some URL are hardcoded and will not become relative to your instance.

