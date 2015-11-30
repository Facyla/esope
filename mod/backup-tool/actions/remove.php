<?php

/*
 *  Download backup file
 */


global $CONFIG;

$files = get_input('file', false);
$counter = 0;
if ($files) {
    if (!is_array($files)) {
        $files = array($files);
    }
//get path to default backup dir specified in plugin settings
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

    foreach ($files as $filename) {
        if ($filename) {
            $file_path = $backup_dir . $filename;

            if (file_exists($file_path)) {
                unlink($file_path);
                if (file_exists($file_path . ".ini")) {
                    unlink($file_path . ".ini");
                }
                $counter++;
            }
        }
    }
}
if (!$counter) {
    register_error(elgg_echo("backup-tool:message:nofiles"));
} else {
    system_message(elgg_echo("backup-tool:message:removed", array($counter)));
}

forward("admin/backups/list");

