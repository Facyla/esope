<?php
/**
 * Backup Tool French language file.
 *
 */
return array(
	'admin:backups' => 'Backups',
	'admin:backups:list' => 'Derniers backups',
	'admin:backups:schedule' => 'Planifier un backup',
	'backup-tool:create' => 'Créer un nouveau backup',
	'backup-tool:settings:backup_dir' => 'Le chemin complet du dossier de backup. Par exemple "/var/backups/elgg/".',
	'backup-tool:bad_backup_dir' => '!!! Le dossier de backup n\'est pas spécifié ou n\'existe pas. Veuillez renseigner un chemin valide dans <a href="' . elgg_get_site_url() . 'admin/plugin_settings/backup-tool"><u>les paramètres du plugin</u></a>',
	'backup-tool:create:success' => '%s a bien été créé',
	'backup-tool:create:fail' => 'Le fichier n\'a pas pu être créé suite à certaines erreurs. Veuillez vérifier le dossier et les permissions du dossier des backups',
	'backup-tool:message:removed' => 'Les %s fichiers sélectionnés ont bien été supprimés',
	'backup-tool:message:notexists' => 'Le fichier %s n\'existe pas',
	'backup-tool:message:nofiles' => 'Aucune sélection',
	'backup-tool:schedule:enable' => 'Activer la planification du backup',
	'backup-tool:schedule:period' => 'A quelle fréquence effectuer des backups ?',
	'backup-tool:schedule:hourly'  => 'Une fois par heure',
	'backup-tool:schedule:daily' => 'Une fois par jour',
	'backup-tool:schedule:weekly' => 'Une fois par semaine',
	'backup-tool:schedule:monthly' => 'Une fois par mois',
	'backup-tool:schedule:yearly' => 'Une fois par an',
	
	'backup-tool:schedule:delete' => 'Supprimer les backups qui ont plus de ',
	'backup-tool:schedule:week' => 'une semaine',
	'backup-tool:schedule:month' => 'un mois',
	'backup-tool:schedule:year' => 'un an',
	'backup-tool:schedule:never' => 'jamais',
	
	'backup-tool:settings:success' => 'Les paramètres de la planification ont été enregistrés',
	'backup-tool:settings:success:enable' => 'La planification des backups a bien été activée',
	'backup-tool:settings:success:disable' => 'La planification des backups a bien été désactivée',
	
	'backuptool:schedule:button:enable' => 'Activer la planification',
	'backuptool:schedule:button:disable' => 'Désactiver la planification',
	
	'backup-tool:schedule:settings' => 'Paramètres de planification',
	'backup-tool:schedule:backup-options' => 'Options de backup',
	'admin:backups:settings' => 'Paramètres du plugin',
	'backuptool:schedule:button:apply'=>'Appliquer les changements',
	'backup-tool:schedule:ftp-settings' => 'Paramètres FTP',
	'backup-tool:schedule:ftp-settings:text' => 'Envoyer une copie du backup dans un dossier FTP distant',
	'backup-tool:schedule:ftp-host'=> 'Hôte FTP',
	'backup-tool:schedule:ftp-user'=> 'Utilisateur FTP',
	'backup-tool:schedule:ftp-password'=> 'Mot de passe FTP',
	'backup-tool:schedule:ftp-dir'=> 'Dossier distant',
	'backuptool:schedule:ftp:testbutton' => 'Tester la connexion',
	'backup-tool:schedule:ftp:enable' => 'Activer l\'envoi sur le FTP',
	'backup-tool:ftp:established' => 'Connexion établie',
	'backup-tool:ftp:notestablished' => 'Connexion non établie',
	'backup-tool:ftp:failchdir' => ' mais le dossier distant n\est pas valide',
	
	'backup-tool:settings:error:backup_options' => 'Une option de backup au moins doit être choisie',
	'backup-tool:create:inprogress' => 'Création du backup...</br>Veuillez patienter, la procédure peut durer quelques minutes',
	'backup-tool:create:text' => 'Veuillez spécifier quelle données devraient être incluses dans le fichier de backup',
	
	'backup-tool:options:site' => 'dossier du site (%s)',
	'backup-tool:options:data' => 'dossier de données - data (%s)',
	'backup-tool:options:db' => 'dump de la base de données',
	
);

