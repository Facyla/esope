<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

// Still here for compatibility reasons
error_log("Pin plugin : using mod/pin/index.php instead of /pin URL : please update calling plugin or theme !")

include('pages/pin/index.php');


