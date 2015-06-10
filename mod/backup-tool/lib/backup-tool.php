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
    
    $backip_file_name = elgg_get_plugin_setting("backup_name", 'backup-tool', 'backup') . '-' . date("Ymd");   
    $backup_data_dir = $backup_dir.$backip_file_name."/";
    
    
    mkdir($backup_data_dir);
    
    $dump_path = '';

//prepeare database dump
    if (in_array('db', $options)) {
        $backup_dump_dir = $backup_data_dir."dump/";
        mkdir($backup_dump_dir);
        $dump_name = $dbname . '.sql';
        $dump_path = $backup_dump_dir . $dump_name;
        $dump_command = "mysqldump --user={$dbuser} --password={$dbpass} --host={$dbhost} --databases {$dbname} > {$dump_path}";
        
        shell_exec($dump_command);
        sleep(1);
        
        //make a tar file for a dump
        //$cmd = "cd {$backup_dump_dir} && tar -cf {$backip_file_name}.tar {$dump_name}";
        //$result = shell_exec($cmd);
        //unlink($dump_path);
    }
    
   
    //prepare dataroot
    if (in_array('data',$options)){
        $backup_dataroot_dir = $backup_data_dir."dataroot/";
        mkdir($backup_dataroot_dir);
        $cmd = "cd {$datafolder} && cp . {$backup_dataroot_dir} -R";
        shell_exec($cmd);
    }

    //prepare siteroot
    if (in_array('site',$options)){
        $backup_siteroot_dir = $backup_data_dir."siteroot/";
        mkdir($backup_dataroot_dir);
        $cmd = "cd {$rootfolder} && cp . {$backup_siteroot_dir} -R";
        shell_exec($cmd);
    }

    
//prepare tar file
    //$tar_name = $backip_file_name . '.tar';
//    $cmd = "tar -cf {$backup_data_dir}{$tar_name} {$datafolder} {$rootfolder}";

    $cmd = "cd {$backup_dir} && tar -cf {$backip_file_name}.tar -C {$backip_file_name} .";
    $result = shell_exec($cmd);
    
    //remove temp folder
    $remove_command = "rm " . $backup_data_dir ." -R";
    shell_exec($remove_command);
    

//if dump with such name already exists then remove it first
    if (file_exists($backup_dir . $backip_file_name.".tar.gz")) {
        $remove_command = "rm " . $backup_dir . $backip_file_name . ".tar.gz";
        shell_exec($remove_command);
    }


//compress
    $gzip_command = "gzip {$backup_dir}{$backip_file_name}.tar";

    shell_exec($gzip_command);


    if (file_exists($backup_dir . $backip_file_name . ".tar.gz")) {
        //create info file
        $inifile = fopen($backup_dir . $backip_file_name . ".tar.gz.ini", "w+");
        $options_string = serialize($options);
        fputs($inifile, $options_string, strlen($options_string));
        fclose($inifile);

        //return name of the new created backup file
        return $backip_file_name . "tar.gz";
    }

    return false;
}



function backup_tool_restore_backup ($options = array()){
    
    global $CONFIG;


    $dbuser = $CONFIG->dbuser; //get database user
    $dbpass = $CONFIG->dbpass; //get database password
    $dbname = $CONFIG->dbname; //get database name
    $dbhost = $CONFIG->dbhost;

//get path to default backup dir specified in plugin settings
    $backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');
    
    $backip_file_name = $options['file_name'];   
    
    $backup_data_dir = $backup_dir.str_replace(".tar.gz","",$backip_file_name)."/";       
    $backup_file_path = $backup_dir.$backip_file_name;
    mkdir($backup_data_dir);
    
    
    //extract files from backup file into the new backup's dir
    $cmd = "cd $backup_data_dir && tar xfz $backup_file_path";
    exec($cmd); 
    
    //restore dump
    $dump_dir = $backup_data_dir."dump/";
    $dump_file_path = $dump_dir.$dbname.".sql";
    
    $cmd = "mysql --user={$dbuser} --password={$dbpass} --host={$dbhost} {$dbname} < {$dump_file_path}";
    exec($cmd);
    
    //restore data folder
    
    $data_dir = $backup_data_dir."dataroot/";
    
    if (is_dir($data_dir)){
        $datafolder = elgg_get_data_path();
        
        $cmd = "cd $data_dir && cp -R . $datafolder";
        exec($cmd);
    }
    
    //restore site folder
    
        $site_dir = $backup_data_dir."siteroot/";
    
    if (is_dir($site_dir)){
        $sitefolder = elgg_get_root_path();
        
        $cmd = "cd $site_dir && cp -R . $sitefolder";
        exec($cmd);
    }
    
    
    //remove backup's dir
    $cmd = "rm $backup_data_dir -R";
    exec($cmd);
    
    return true;

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