<?php
elgg_load_js('lightbox');
elgg_load_css('lightbox');


$enable_schedule = elgg_get_plugin_setting('enable_schedule', 'backup-tool');
$period = elgg_get_plugin_setting('schedule_period', 'backup-tool');
$delete = elgg_get_plugin_setting('schedule_delete', 'backup-tool');
$ftp_enable = elgg_get_plugin_setting('ftp_enable', 'backup-tool');

$ftp = unserialize(elgg_get_plugin_setting('ftp', 'backup-tool'));
?>

<div>
    <h3><?php echo elgg_echo("backup-tool:schedule:settings"); ?></h3>
</div>
<div>

    <?php
    echo elgg_echo('backup-tool:schedule:period') . ' ';
    echo elgg_view('input/dropdown', array(
        'name' => 'schedule-period',
        'options_values' => array(
            'never' => elgg_echo('backup-tool:schedule:never'),
            //'hourly' => elgg_echo('backup-tool:schedule:hourly'),
            'daily' => elgg_echo('backup-tool:schedule:daily'),
            'weekly' => elgg_echo('backup-tool:schedule:weekly'),
            'monthly' => elgg_echo('backup-tool:schedule:monthly'),
            'yearly' => elgg_echo('backup-tool:schedule:yearly'),
        ),
        'value' => $period,
    ));
    ?>
</div>
<div>
    <?php
    echo elgg_echo('backup-tool:schedule:delete') . ' ';
    echo elgg_view('input/dropdown', array(
        'name' => 'schedule-delete',
        'options_values' => array(
            'never' => elgg_echo('backup-tool:schedule:never'),
            'weekly' => elgg_echo('backup-tool:schedule:week'),
            'monthly' => elgg_echo('backup-tool:schedule:month'),
            'yearly' => elgg_echo('backup-tool:schedule:year')
        ),
        'value' => $delete,
    ));
    ?>
</div>


<?php
echo elgg_view("forms/backup-tool/backup-options");
?>

<div>
    <h3><?php echo elgg_echo("backup-tool:schedule:ftp-settings"); ?></h3>
    <p class='elgg-subtext'><?php echo elgg_echo("backup-tool:schedule:ftp-settings:text"); ?></p>
</div>

<div>

    <fieldset>
        <p>
            <?php
            echo elgg_view("input/checkboxes", array("name" => "ftp-enable", "options" => array(
                    elgg_echo('backup-tool:schedule:ftp:enable') => 'ON'
                ), 'value' => $ftp_enable));
            ?>
        </p>
        
        <p>
            <?php
            echo elgg_echo('backup-tool:schedule:ftp-host');
            echo elgg_view("input/text", array('name' => 'ftp[host]', 'value' => $ftp['host']));
            ?>
        </p>
        <p>
            <?php
            echo elgg_echo('backup-tool:schedule:ftp-user');
            echo elgg_view("input/text", array('name' => 'ftp[user]', 'value' => $ftp['user']));
            ?>
        </p>
        <p>
            <?php
            echo elgg_echo('backup-tool:schedule:ftp-password');
            echo elgg_view("input/password", array('name' => 'ftp[password]', 'value' => $ftp['password']));
            ?>
        </p>
        <p>
            <?php
            echo elgg_echo('backup-tool:schedule:ftp-dir');
            echo elgg_view("input/text", array('name' => 'ftp[dir]', 'value' => $ftp['dir']));
            ?>
        </p>
        <p>
            <?php
            echo elgg_view("output/url", array(
                "text" => elgg_echo("backuptool:schedule:ftp:testbutton"),
                "href" => elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/backup-tool/ftp-test"),
                "class" => "elgg-button elgg-button-cancel",
                "id" => "testFtpConnection"));
            ?>
        </p>
    </fieldset>
</div>

<div>
    <p>
        <?php
        if ($enable_schedule) {
            echo elgg_view("input/submit", array("value" => elgg_echo("backuptool:schedule:button:disable"), 'name' => 'schedule-action'));
            echo elgg_view("input/submit", array("value" => elgg_echo("backuptool:schedule:button:apply")));
        } else {
            echo elgg_view("input/submit", array("value" => elgg_echo("backuptool:schedule:button:enable"), 'name' => 'schedule-action'));
        }
        ?>
    </p>
</div>

<style>
    .elgg-form-backup-tool-schedule-settings input[type=password],
    .elgg-form-backup-tool-schedule-settings input[type=text]{
        width: 20%;
        font-size: 13px;
        margin-right: 60%;
        float:right;
    }

</style>