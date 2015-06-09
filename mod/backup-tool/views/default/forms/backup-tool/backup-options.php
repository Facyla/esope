
<div>
    <h3><?php echo elgg_echo('backup-tool:schedule:backup-options'); ?></h3>
    <p class='elgg-subtext'><?php echo elgg_echo("backup-tool:create:text"); ?></p>
</div>

<div>

    <?php
    $backup_options = unserialize(elgg_get_plugin_setting('backup_options','backup-tool'));
    if (!$backup_options){
        $backup_options = array('site','data','db'); //all selected by default
    }
    $options = array(
        "name" => "backup_options",
        "value" => $backup_options,
        "options" => array(
            elgg_echo("backup-tool:options:site",array(elgg_get_root_path()))=>"site",
            elgg_echo("backup-tool:options:data", array(elgg_get_data_path()))=>"data",
            elgg_echo("backup-tool:options:db")=>"db",
            ));

    echo elgg_view("input/checkboxes", $options);
    ?> 


</div>

