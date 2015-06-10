<?php

/*
 *  Download backup file
 */
global $CONFIG;

$filename = get_input('file');

//get path to default backup dir specified in plugin settings
$backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');
$file_path = $backup_dir . $filename;

if (file_exists($file_path)) {

    //start downlading file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    ob_clean();
    flush();
    readfile($file_path);
    exit;
} else {
    register_error(elgg_echo("backup-tool:message:notexists",array($filename)));
    forward("admin/backup/list");
}