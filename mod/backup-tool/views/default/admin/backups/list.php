<?php

/*
 * Display List of backups
 *  
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

//get path to default backup dir specified in plugin settings
$backup_dir = elgg_get_plugin_setting('backup_dir', 'backup-tool');

if (!$backup_dir || !file_exists($backup_dir)) {

    echo '<p><b>' . elgg_echo('backup-tool:bad_backup_dir') . '</b></p>';
} else {
    echo '<div class="elgg-head">';

    //display button for create a new backup
    echo elgg_view('output/url', array(
        'text' => elgg_echo('backup-tool:create'),
        'href' => elgg_get_site_url() . "ajax/view/backup-tool/create-backup", //elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/backup-tool/create'),
        'class' => 'elgg-lightbox elgg-button elgg-button-submit'
    ));

    //button for Shadule a backup
    echo elgg_view('output/url', array(
        'text' => elgg_echo('admin:backups:schedule'),
        'href' => elgg_get_site_url() . 'admin/backups/schedule',
        'class' => 'elgg-button elgg-button-submit'
    ));


    //button for backup settings
    echo elgg_view('output/url', array(
        'text' => elgg_echo('admin:backups:settings'),
        'href' => elgg_get_site_url() . 'admin/plugin_settings/backup-tool',
        'class' => 'elgg-button elgg-button-submit float-alt'
    ));


    echo '</div>';
}



$dir = opendir($backup_dir);

//prepeare array with files name
$backups_files = array();
while ($file = readdir($dir)) {
    if ($file != '.' && $file != '..') {
        if (strpos($file, '.tar.gz.ini') == false) { //do not include inifiles in backups list
            $time = filemtime($backup_dir . $file);
            $backups_files[$time] = $file;
        }
    }
}

if ($backups_files) {

    //sorting by name
    ksort($backups_files);
    $backups_files = array_reverse($backups_files, true);

    $body = '<div class="elgg-module elgg-module-inline">';
    $body .= '<div class="elgg-head">';
    $body .= '<label><input type="checkbox" id="backups-checkall"> List of existing backups</label>';
    $body .= elgg_view("input/submit", array("value" => elgg_echo("remove"), 'class' => 'float-alt'));
    $body .= '</div>';
    $body .= '<div class="elgg-body">';

    $body .= '<ul class="elgg-list elgg-list-distinct">';

    foreach ($backups_files as $time => $backup) {
        //get backup options from ini file
        $inifile_path = $backup_dir . $backup . ".ini";
        if (file_exists($inifile_path)) {
            $inifile = fopen($inifile_path, "r");
            $options_string = unserialize(fgets($inifile));
            fclose($inifile);
        }else{
            $options_string = array('site', 'data', 'db'); //for old backups and backups without ini files
        }

        //prepeare link for downloading
        $restore_link = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/restore?file=" . $backup);
        $download_link = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/download?file=" . $backup);
        $remove_link = elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/remove?file=" . $backup);
        //buttons

        $buttons = '<span class="elgg-subtext">' . number_format(filesize($backup_dir . $backup) / 1048576, 2) . 'M </span>&nbsp;&nbsp;/&nbsp;&nbsp;';
        $buttons .= '<span class="elgg-subtext">' . date("d.m.Y", $time) . '</span>&nbsp;&nbsp;';
        $buttons .= elgg_view("output/url", array("text" => elgg_echo("backup-tool:restore"), "href" => $restore_link, "class" => "elgg-button-submit elgg-button"));
        $buttons .= elgg_view("output/url", array("text" => elgg_echo("download"), "href" => $download_link, "class" => "elgg-button-submit elgg-button"));       
        $buttons .= elgg_view("output/confirmlink", array("text" => elgg_echo("remove"), "href" => $remove_link, "class" => "elgg-button-submit elgg-button"));
        //checkbox
        $checkbox = elgg_view("input/checkbox", array('name' => 'file[]', 'value' => $backup));


        $backup_link = elgg_view("output/url", array("text" => $backup, "title" => $backup_dir . $backup, "href" => $download_link));
        $backup_options = '<span class="elgg-subtext">(' . implode(", ", $options_string) . ') </span>';

        $body .= '<li class="elgg-item">
            <div class="elgg-image-block clearfix">
                <div class="elgg-image">
                    ' . $checkbox . '
                </div>
                <div class="elgg-image-alt">
                ' . $buttons . ' 
                </div>
                <div class="elgg-body">
                    ' . $backup_link . ' ' . $backup_options . '
                </div>
            </div>
        </li>';
    }
    $body .= '</ul>';

    $body .= '</div>';

    echo elgg_view("input/form", array("id" => "backups-form", "action" => "action/backup-tool/remove", "body" => $body));
}


closedir($dir);

