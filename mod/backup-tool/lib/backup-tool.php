<?php

/**
 * 
 * @global type $CONFIG
 * @return string filename of a new backup or false
 */
function backup_tool_create_backup($options = array()) {

    /*
     *  Create a new backup file
     */
    global $CONFIG;


    $dbuser = $CONFIG->dbuser; //get database user
    $dbpass = $CONFIG->dbpass; //get database password
    $dbname = $CONFIG->dbname; //get database name
    $dbhost = $CONFIG->dbhost;

    $datafolder = in_array('data', $options) ? elgg_get_data_path() : ''; //get path to sndata folder
    $rootfolder = in_array('site', $options) ? elgg_get_root_path() : ''; //get path to Elgg folder
//get path to default backup dir specified in plugin settings
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

    $dump_path = '';

//prepeare database dump
    if (in_array('db', $options)) {
        $dump_name = $dbname . '-' . date("Ymd") . '.sql';
        $dump_command = "mysqldump --user={$dbuser} --password={$dbpass} --host={$dbhost} --databases {$dbname} > {$backup_dir}{$dump_name}";
        $dump_path = $backup_dir . $dump_name;
        $result = shell_exec($dump_command);
    }
//prepare tar file
    $tar_name = $dbname . '-' . date('Ymd') . '.tar';
    $tar_command = "tar -cf {$backup_dir}{$tar_name} {$dump_path} {$datafolder} {$rootfolder}";

    shell_exec($tar_command);

//if dump with such name already exists then remove it first
    if (file_exists($backup_dir . $tar_name . ".gz")) {
        $remove_command = "rm " . $backup_dir . $tar_name . ".gz";
        shell_exec($remove_command);
    }


//compress
    $gzip_command = "gzip {$backup_dir}{$tar_name}";

    shell_exec($gzip_command);


//remove dump
    if (in_array('db', $options)) {
        $remove_dump_command = "rm {$backup_dir}{$dump_name}";
        shell_exec($remove_dump_command);
    }




    if (file_exists($backup_dir . $tar_name . ".gz")) {
        //create info file
        $inifile = fopen($backup_dir . $tar_name . ".gz.ini", "w+");
        $options_string = serialize($options);
        fputs($inifile, $options_string, strlen($options_string));
        fclose($inifile);

        //return name of the new created backup file
        return $tar_name . ".gz";
    }

    return false;
}

function backup_tool_cleanup($offset) {

    elgg_load_library("backup_tool");
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');


    $dir = opendir($backup_dir);

    //get size of each backup and comare it with offset
    while ($file = readdir($dir)) {
        if ($file != '.' && $file != '..') {
            $filename = $backup_dir . $file;
            if (is_file($filename)) {
                //if differences between current time and creation time is greater than offset then remove file
                $current_time = time();
                $creation_time = filemtime($filename);
                if ($current_time - $creation_time >= $offset) {
                    unlink($filename);
                    if (file_exists($filename . ".ini")) {
                        unlink($filename . ".ini");
                    }
                }
            }
        }
    }
}

/**
 * 
 * @param type $filename - file for uploading
 * @param type $ftpfortest - ftp settings for test
 */
function backup_tool_upload_to_ftp($filename = NULL, $ftpfortest = false) {


    if (!$ftpfortest) {
        //get ftp settings
        $ftp = unserialize(elgg_get_plugin_setting('ftp', 'backup-tool'));
    } else {
        $ftp = $ftpfortest;
    }

//Set up a connection
    $conn = ftp_connect($ftp['host']) or die("Can not connect to " . $ftp['host']);

// Login 
    if (ftp_login($conn, $ftp['user'], $ftp['password'])) {
        echo elgg_echo('backup-tool:ftp:established');

        if (ftp_chdir($conn, $ftp['dir'])) {

            if (!$ftpfortest) {
                //try to upload file
                //get path to default backup dir specified in plugin settings
                $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');
                $file_path = $backup_dir . $filename;

                if (ftp_put($conn, $filename, $file_path, FTP_BINARY)) {
                    echo "successfully uploaded $filename\n";
                } else {
                    echo "There was a problem while uploading $filename\n";
                }
            }
        } else {
            echo elgg_echo('backup-tool:ftp:failchdir');
        }
    } else {
        echo elgg_echo('backup-tool:ftp:notestablished');
    }

// close the connection
    ftp_close($conn);
}