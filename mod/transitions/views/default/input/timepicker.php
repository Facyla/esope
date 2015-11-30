<?php
// Time should be formatted as HHmm => values are in minutes

$value = $vars['value'];
if (is_numeric($value)) {
	$hour = floor($value/60);
	$minute = ($value -60*$hour);
	$time = $hour*60+$minute;
} else {
	$time = '0';
}

$dates = array();

for($h=0;$h<24;$h++) {
	$ht = sprintf("%02d",$h);
	for($m=0;$m<60;$m=$m+15) {
		$mt = sprintf("%02d",$m);
		$t = $h*60+$m;
		$dates[$t] = "$ht:$mt";
	}
}

echo elgg_view('input/dropdown',array('name'=>$vars['name'],'value'=>$time,'options_values'=>$dates));
