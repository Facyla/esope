<?php
	include "../inc/config.inc.php";
	include "../inc/database.inc.php";
	
	$format= "odp";
	
	/**
		R�cup�re le format du fichier demand�
	*/
	if(isset($_GET['format'])){
		$format = $_GET['format'];
	}

	// R�cup�re l'ID du cycle associ� au goupe CoCon(coll�ge)
	$cid = "";
	if(isset($_GET['cid'])){
		$cid = $_GET['cid'];
	}
	
	// Erreur si l'ID du cycle n'a pas �t� indiqu�
	if ($cid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	// R�cup�re l'ID de goupe CoCon(coll�ge)
	$gid = "";
	if(isset($_GET['gid'])){
		$gid = $_GET['gid'];
	}
	
	// Erreur si l'ID groupe CoCon(Coll�ge) n'a pas �t� indiqu�
	if ($gid == ''){
		header("HTTP/1.0 403 Permission refused");
		die();
	}

	// V�rifie si il s'agit d'une extraction globale ou un simple t�l�chargement
	$forZIP = 0;
	if(isset($_GET['zip'])){
		$forZIP = $_GET['zip'];
		if($forZIP == 1){
			if(!file_exists("../../_tmp/".$gid) || !is_dir("../../_tmp/".$gid)){
				mkdir("../../_tmp/".$gid);
			}
		}		
	}	
	
	$data = array();
	
	// Connexion � la base de donn�es
	$conn = connectDB();
	
	// Requ�te SELECT pour r�cup�rer la derni�re feuille de route
	$sql = "select * from FEUILLE_ROUTE where CYCLE_ID=\"".securiseSQLString($conn, $cid)."\" and GROUP_ID=\"".securiseSQLString($conn,$gid)."\" and ACTIVE=1";
	$result = executeQuery($conn, $sql);
	
	// Erreur lors d ela requ�te
	if(!$result){
		header("HTTP/1.0 403 Permission refused");
		die();
	}
	
	$instances = array(
		"",
		utf8_encode("Conseil p�dagogique"),
		utf8_encode("Conseil d'administration"),
		utf8_encode("Commission permanente"),
		utf8_encode("Conseil �cole-coll�ge"),
		utf8_encode("Commission num�rique"),
		utf8_encode("Conseil d'enseignement"),
		utf8_encode("Autre")
	);
	
	while($row = mysql_fetch_assoc($result)){
		$data[] = array(
			'group_id' => 'abdc',
			'group_name' => utf8_encode('Coll�ge Henri Sellier'),
			'date' => date('d/m/Y', $row['DT_CREATE']),
			'objectifs' => $row['OBJECTIF_1']."\n".$row['OBJECTIF_2']."\n".$row['OBJECTIF_3']."\n".$row['OBJECTIF_4']."\n".$row['OBJECTIF_5']."\n".$row['OBJECTIF_6']."\n".$row['OBJECTIF_7']."\n".$row['OBJECTIF_8'],
			'equipe_projet' => $row['EQUIPE_PROJET'],
			'ressources' => $row['RESSOURCES'],
			'instances' => $instances[$row['INSTANCE_1']]."\n".$row['COMMENT_1']."\n".$instances[$row['INSTANCE_2']]."\n".$row['COMMENT_2']."\n".$instances[$row['INSTANCE_3']]."\n".$row['COMMENT_3']."\n".$instances[$row['INSTANCE_4']]."\n".$row['COMMENT_4']."\n".$instances[$row['INSTANCE_5']]."\n".$row['COMMENT_5']."\n".$instances[$row['INSTANCE_6']]."\n".$row['COMMENT_6']."\n".$instances[$row['INSTANCE_7']]."\n".$row['COMMENT_7']."\n".$instances[$row['INSTANCE_8']]."\n".$row['COMMENT_8'],
			'calendrier' => $row['CALENDRIER']
		);
	}

	/**
		Type de retour en fonction du type de format demand�
	*/
	if($forZIP == "0"){
		if($format == "odp"){
			header("content-type: application/vnd.oasis.opendocument.presentation");
		}
		
		if($format == "pdf"){
			header("content-type: application/pdf");
		}
	}else{
		header("content-type: json/application; charset=utf-8");
	}
	
	/**
		Construstion du document selon le format
	*/
	if($format == 'odp'){
	
		include_once('../inc/tbs/tbs_class.php');
		include_once('../inc/tbs/opentbs/tbs_plugin_opentbs.php');
	
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
		$template = '../../_files/restitution/feuille_de_route.odp';
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
		$TBS->MergeBlock('b', $data);
		if($forZIP == 0){
			$TBS->Show(OPENTBS_DOWNLOAD, "feuille_de_route.odp");
		}else{
			$TBS->Show(OPENTBS_FILE, "../../_tmp/".$gid."/feuille_de_route.odp");
			die(json_encode(array("error" => false)));
		}
	}
	
	if($format == 'pdf'){
		include_once('../pdf/fpdf.php');
		include_once('../pdf/fpdi/fpdi.php');
		
		$template = '../../_files/restitution/feuille_de_route.pdf';
		
		$pdf = new FPDI();
		$pages = $pdf->setSourceFile($template);
		
		$pdf->SetFont("Helvetica");
		$pdf->SetFontSize(9);
		$pdf->SetTextColor(128, 128, 128);
		for($i = 1; $i < ($pages + 1); $i++){
			$pgId = $pdf->importPage($i); 
			$size = $pdf->getTemplateSize($pgId);

			if ($size['w'] > $size['h']) {
				$pdf->AddPage('L', array($size['w'], $size['h']));
			} else {
				$pdf->AddPage('P', array($size['w'], $size['h']));
			}			

			$pdf->useTemplate($pgId,0,0,210,297);
			
			if($i == 1){
				$pdf->SetXY(12, 51);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['objectifs']));
				$pdf->SetXY(12, 190);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['equipe_projet']));
				$pdf->SetXY(120, 165);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['ressources']));
			}

			if($i == 2){
				$pdf->SetXY(20, 66);
				$pdf->MultiCell(200, 5, utf8_decode($data[0]['instances']));

				$pdf->Image("gfx_".$data[0]['calendrier'].".jpg",  20 , 200, 180, 35);				
			}
		}
		
		if($forZIP == 0){
			$pdf->OutPut("feuille_de_route.pdf", "D");
		}else{
			$pdf->OutPut("../../_tmp/".$gid."/feuille_de_route.pdf", "F");
			die(json_encode(array("error" => false)));
		}
	}
	exit();	
?>