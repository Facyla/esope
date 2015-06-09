<?php

$schedule_action = get_input("schedule-action");

$enable_schedule = get_input("enable-schedule");
$schedule_period = get_input("schedule-period");
$schedule_delete = get_input("schedule-delete");
$backup_options = get_input("backup_options");

$ftp_enable = get_input("ftp-enable", false);
$ftp = get_input("ftp", false);

if (!$backup_options) {
    register_error(elgg_echo('backup-tool:settings:error:backup_options'));
} else {
    elgg_set_plugin_setting('backup_options', serialize($backup_options), 'backup-tool');



    if ($schedule_action == elgg_echo("backuptool:schedule:button:enable")) {
        $enable_schedule = true;
        elgg_set_plugin_setting('enable_schedule', $enable_schedule, 'backup-tool');
        system_messages(elgg_echo("backup-tool:settings:success:enable"));
    } elseif ($schedule_action == elgg_echo("backuptool:schedule:button:disable")) {
        $enable_schedule = false;
        elgg_set_plugin_setting('enable_schedule', $enable_schedule, 'backup-tool');
        system_messages(elgg_echo("backup-tool:settings:success:disable"));
    } else {
        system_messages(elgg_echo("backup-tool:settings:success"));
    }


    elgg_set_plugin_setting('schedule_period', $schedule_period, 'backup-tool');
    elgg_set_plugin_setting('schedule_delete', $schedule_delete, 'backup-tool');
    
    //save ftp settings
    elgg_set_plugin_setting('ftp_enable', $ftp_enable[0], 'backup-tool');
    elgg_set_plugin_setting('ftp', serialize($ftp), 'backup-tool');
    
}

