<?php

$ftp = get_input('ftp');

elgg_load_library('backup_tool');

backup_tool_upload_to_ftp(NULL,$ftp);

//echo "success";
exit;
