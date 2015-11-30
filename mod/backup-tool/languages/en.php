<?php

/**
 * Bakup Tool English language file.
 *
 */
return array(
    'admin:backups' => 'Backups',
    'admin:backups:list' => 'Latest backups',
    'admin:backups:schedule' => 'Schedule a backup',
    'backup-tool:create' => 'Create a new backup',
    'backup-tool:settings:backup_dir' => 'The full path to the backup directory. For ex. "/var/backups/elgg/".',
    'backup-tool:bad_backup_dir' => '!!! Backup directory is not specified or not exists. Please fill a correct path into <a href="' . elgg_get_site_url() . 'admin/plugin_settings/backup-tool"><u>plugin settings</u></a>',
    'backup-tool:create:success' => '%s was created successfully',
    'backup-tool:create:fail' => 'File was not created because of some errors. Please check path and permissions to the backups directory',
    'backup-tool:message:removed' => '%s file(s) was removed',
    'backup-tool:message:notexists' => 'File %s not exists',
    'backup-tool:message:nofiles' => 'Nothing was selected',
    'backup-tool:schedule:enable' => 'Enable backup scheduling',
    'backup-tool:schedule:period' => 'How often should the backup be created?',
    'backup-tool:schedule:hourly'  => 'Once a hour',
    'backup-tool:schedule:daily' => 'Once a day',
    'backup-tool:schedule:weekly' => 'Once a week',
    'backup-tool:schedule:monthly' => 'Once a month',
    'backup-tool:schedule:yearly' => 'Once a year',
    
    'backup-tool:schedule:delete' => 'Delete backups older than a',
    'backup-tool:schedule:week' => 'week',
    'backup-tool:schedule:month' => 'month',
    'backup-tool:schedule:year' => 'year',
    'backup-tool:schedule:never' => 'never',
    
    'backup-tool:settings:success' => 'Settings of schedule was saved',
    'backup-tool:settings:success:enable' => 'Backup scheduling was enabled',
    'backup-tool:settings:success:disable' => 'Backup scheduling was disabled',
    
    'backuptool:schedule:button:enable' => 'Turn On scheduling',
    'backuptool:schedule:button:disable' => 'Turn Off scheduling',
    
    'backup-tool:schedule:settings' => 'Schedule settings',
    'backup-tool:schedule:backup-options' => 'Backup options',
    'admin:backups:settings' => 'Plugin settings',
    'backuptool:schedule:button:apply'=>'Apply changes',
    'backup-tool:schedule:ftp-settings' => 'FTP settings',
    'backup-tool:schedule:ftp-settings:text' => 'Upload copy of a backup to remote FTP-folder',
    'backup-tool:schedule:ftp-host'=> 'FTP host',
    'backup-tool:schedule:ftp-user'=> 'FTP user',
    'backup-tool:schedule:ftp-password'=> 'FTP password',
    'backup-tool:schedule:ftp-dir'=> 'Remote directory',
    'backuptool:schedule:ftp:testbutton' => 'Test connection',
    'backup-tool:schedule:ftp:enable' => 'Enable FTP uploading',
    'backup-tool:ftp:established' => 'Connection established',
    'backup-tool:ftp:notestablished' => 'Connection not established',
    'backup-tool:ftp:failchdir' => ' but remote directory is wrong',
    
    'backup-tool:settings:error:backup_options' => 'At least one backup option should be choosen',
    'backup-tool:create:inprogress' => 'Creating backup...</br>Please be patient it could take a few minutes',
    'backup-tool:create:text' => 'Please specify which data should be included in backup file',
    
    'backup-tool:options:site' => 'site folder (%s)',
    'backup-tool:options:data' => 'data folder (%s)',
    'backup-tool:options:db' => 'database dump',
    
    'backup-tool:settings:backup_name' => 'Name of the backup file',
    'backup-tool:restore:success' => 'Backup was restored successfully',
    'backup-tool:restore' => 'Restore',
    
);

