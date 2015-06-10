<?php

/*
 *  Create a new backup file
 */

elgg_load_library("backup_tool");

$backup_file_name = get_input("file");

if (backup_tool_restore_backup(array("file_name"=>$backup_file_name))){
     system_messages(elgg_echo("backup-tool:restore:success", array($filename)));
}else{
    register_error(elgg_echo("backup-tool:restore:fail"));
}
forward(REFERRER);