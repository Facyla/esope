<?php
	/**
		Test de restitution
	*/
	include_once "../../php/inc/survey/pro/report.inc.php";
	
	$cid = 'dolto';
	$gid = 'dolto';
	
	$restitution = getRestitutionDatas($cid, $gid, "synth");
	if(!$restitution){
		die(mysql_error());
	}

	$TBS = createDocument("odp", $restitution);
	$TBS->Show(OPENTBS_DOWNLOAD, "resultats_synth.odp");
	exit();

//	$restitution['graph_7_chart']->Stroke();

	//var_dump($restitution);
?>
