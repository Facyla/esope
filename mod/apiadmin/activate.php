<?php

$sql_path = elgg_get_plugins_path() . "apiadmin/schema/mysql.sql";
// create the tables for API stats
run_sql_script($sql_path);

if ( !file_exists($browscapdir = elgg_get_data_path() . 'phpbrowscap') ) {
	mkdir($browscapdir);
}

// plugin can be activated
return true;
