<?php
/**
 * Elgg LDAP authentication
 * 
 * @package ElggLDAPAuth
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Misja Hoebe <misja@elgg.com>
 * @copyright Curverider Ltd 2008
 * @link http://elgg.com
 */

return array(
	'ldap_auth' => "Authentification LDAP",
	
	'ldap_auth:missingsettings' => "Veuillez configurer le plugin ldap_auth plugin en créant un fichier settings.php à la racine du plugin. Voyez le fichier settings_dist.php pour un exemple de fichier de configuration.",
	
	// Settings
	'ldap_auth:title' => "Authentification LDAP",
	'ldap_auth:settings:main' => "Fonctionnalités",
	'ldap_auth:settings:fields' => "Champs",
	'ldap_auth:settings:allow_registration' => "Permettre de créer un compte à partir d'un compte LDAP (l'identifiant doit exister dans LDAP) ?",
	'elgg_ldap:mail_field_name' => "Nom du champ donnant l'email du compte dans LDAP",
	'elgg_ldap:username_field_name' => "Nom du champ donnant l'username du compte dans LDAP (et Elgg)",
	'elgg_ldap:status_field_name' => "Nom du champ donnant le statut du compte LDAP actif/inactif. Si vide, tout comptes est considéré comme actif.",
	'elgg_ldap:generic_register_email' => "Adresse email générique pour la création des comptes (avant MAJ via LDAP)",
	'ldap_auth:settings:label:host' => "Paramètres de l'hôte",
	'ldap_auth:settings:label:connection_search' => "Paramètres LDAP",
	'ldap_auth:settings:label:hostname' => "Nom de l'hôte'",
	'ldap_auth:settings:help:hostname' => "Saisissez le nom cannonique de l'hôte, par exemple <i>ldap.yourcompany.com</i>",
	'ldap_auth:settings:label:port' => "Port du serveur LDAP",
	'ldap_auth:settings:help:port' => "Le port du serveur LDAP. La valeur par défaut est 389, utilisée par les plupart des hôtes.",
	'ldap_auth:settings:label:version' => "Version du protocole LDAP",
	'ldap_auth:settings:help:version' => "Version du protocole LDAP. Par défaut 3, ce qui correspond à celui qu'utilisent la majorité des hôtes LDAP.",
	'ldap_auth:settings:label:ldap_bind_dn' => "LDAP bind DN",
	'ldap_auth:settings:help:ldap_bind_dn' => "Quel DN utiliser pour un bind non-anonyme bind, par exemple <i>cn=admin,dc=yourcompany,dc=com</i>",
	'ldap_auth:settings:label:ldap_bind_pwd' => "Mot de passe LDAP bind",
	'ldap_auth:settings:help:ldap_bind_pwd' => "Quel mot de passe utiliser pour effectuer un bind non-anonyme.",
	'ldap_auth:settings:label:basedn' => "Based DN",
	'ldap_auth:settings:help:basedn' => "Le DN de base. Séparez avec deux points (:) pour saisir plusieurs DNs, par exemple <i>dc=yourcompany,dc=com : dc=othercompany,dc=com</i>",
	'ldap_auth:settings:label:filter_attr' => "Username filter attribute",
	'ldap_auth:settings:help:filter_attr' => "Le filtre est utilisé pour le nom d'utilisateur, les valeurs fréquentes sont <i>cn</i>, <i>uid</i> ou <i>sAMAccountName</i>.",
	'ldap_auth:settings:label:search_attr' => "Attributs de recherche",
	'ldap_auth:settings:help:search_attr' => "Saisissez es attributs de recherche sous la forme de paires de clef, valeur, la clef étant la description de l'attribut, et la valeur l'attribut LDAP.
	 <i>firstname</i>, <i>lastname</i> et <i>mail</i> sont utilisés pour créer le profil Elgg. L'exemple suivant fonctionne pour ActiveDirectory :<br/>
	 <blockquote><i>firstname:givenname, lastname:sn, mail:mail</i></blockquote>",
	'ldap_auth:settings:label:user_create' => "Créer des comptes utilisateur",
	'ldap_auth:settings:help:user_create' => "Vous pouvez choisir de créer automatiquement un compte lorsqu'un authentification LDAP est réussie.",
	'ldap_auth:settings:label:start_tls' => "Start TLS",
	'ldap_auth:settings:help:start_tls' => "Utiliser Start TLS pour sécuriser l'authentificaiton LDAP (le serveur doit supporter LDAPS).",
	
	'ldap_auth:settings:updatename' => "Forcer la mise à jour des noms affichés à partir des informations du LDAP ?",
	'ldap_auth:settings:updateprofile' => "Forcer la mise à jour des informations du profil à partir des informations du LDAP ?",
	
	// Messages
	'ldap_auth:no_account' => "Vos accès LDAP sont valides, mais aucun compte n'a été trouvé sur le site - veuillez contacter l'administrateur.",
	'ldap_auth:no_register' => "Votre compte n'a pas pu être créé - veuillez contacter l'administrateur.",
	'ldap_auth:invalid:password' => 'LDAP : votre mot de passe est incorrect',
	'ldap_auth:invalid:username' => 'LDAP : votre login est inconnu (attention à la casse)',
	'ldap_auth:error:alreadyexists' => "Un compte est déjà associé à votre adresse email %s : veuillez contacter l'administrateur du site à l'adresse %s pour que votre identifiant de connexion corresponde à votre identifiant LDAP.",
	'ldap_auth:error:cannotupdate' => "LDAP : impossible de mettre à jour le profil %s lors de l'inscription.",
	
	
);


