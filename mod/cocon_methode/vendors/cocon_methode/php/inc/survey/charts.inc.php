<?php
	include("../../inc/pchart/pData.class");  
	include("../../inc/pchart/pChart.class");

	/**
		Création d'un graphique en forme de camembert
		$values est un tableau de valeurs
		$legends est un tableau de chaines contenant les étiquettes
		$colors est une chaine contenant le fichiers de couleurs à utiliser (facultatif)
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			- "chart_left" : position gauche du camembert sur le graphique
			- "chart_top" : position haute du camembert sur le graphique
			- "chart_size" : taille du camembert sur le graphique
			- "legend_left" : position gauche des légendes sur le graphique
			- "legend_top" : position gauche des légendes sur le graphique
			- "font_size" : taille de la police du texte
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createPieChart($values, $legends, $colors = "",$layout = "", $title=""){
	
		if($layout == ""){
			$layout = array(
				"width" => 320,
				"height" => 200,
				"chart_left" => 115,
				"chart_top" => 100,
				"chart_size" => 60,
				"legend_left" => 200,
				"legend_top" =>15,
				"font_size" => 8
			);
		}else{
			if(!isset($layout["width"])){
				$layout["width"] = 320;
			}
			if(!isset($layout["height"])){
				$layout["height"] = 200;
			}
			if(!isset($layout["chart_left"])){
				$layout["chart_left"] = 115;
			}
			if(!isset($layout["chart_top"])){
				$layout["chart_top"] = 100;
			}
			if(!isset($layout["chart_size"])){
				$layout["chart_size"] = 60;
			}
			if(!isset($layout["legend_left"])){
				$layout["legend_left"] = 200;
			}
			if(!isset($layout["legend_top"])){
				$layout["legend_top"] = 15;
			}
			if(!isset($layout["font_size"])){
				$layout['font_size'] = 8;
			}
		}

		$pc = 0;
		$vmax = 0;
		$vmin = 0;
		$max = 0;
		for ($i = 0; $i < count($values); $i++){

			if($values[$i] > $values[$vmax]){
				$vmax = $i;
			}
			
			$pc += $values[$i];
		}

		if(isset($values[$vmax])){
			if($pc > 100){
				$values[$vmax] = $values[$vmax] - ($pc - 100);
			}

			if($pc < 100){
				$values[$vmax] = $values[$vmax] + (100 - $pc);
			}
		}
		
		// Dataset definition   
		$dataSet = new pData;  
		$dataSet->AddPoint($values,"Serie1");  
		$dataSet->AddPoint($legends,"Serie2");  
		$dataSet->AddAllSeries();  
		$dataSet->SetAbsciseLabelSerie("Serie2");  

		// Initialise the graph  
		$chart = new pChart($layout["width"],$layout["height"]);  
		if($colors != ""){
			$chart->loadColorPalette("colors/".$colors.".txt");  
		}

		$chart->drawFilledRoundedRectangle(7, 7,$layout["width"] - 7,$layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5,$layout["height"] - 5, 5, 128, 128, 128);  

		// This will draw a shadow under the pie chart  
		$chart->drawFilledCircle($layout["chart_left"] + 4,$layout["chart_top"] + 4, $layout["chart_size"],200,200,200);  

		// Draw the pie chart  
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf",$layout["font_size"]);  
		$chart->drawTitle(7,24,$title,0,0,0, $layout['width'],$layout['font_size']);
		$chart->drawBasicPieGraph($dataSet->GetData(), $dataSet->GetDataDescription(), $layout["chart_left"], $layout["chart_top"], $layout["chart_size"], PIE_PERCENTAGE, 255, 255, 255);  
		$chart->drawPieLegend($layout["legend_left"], $layout["legend_top"], $dataSet->GetData(), $dataSet->GetDataDescription(), 250, 250, 250);  

		return $chart;
	}

	/**
		Création d'un graphique en forme de barres horizontales
		$values est un tableau de valeurs
		$legends est un tableau de chaines contenant les étiquettes
		$colors est une chaine contenant le fichiers de couleurs à utiliser (facultatif)
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			- "chart_left" : position gauche du camembert sur le graphique
			- "chart_top" : position haute du camembert sur le graphique
			- "chart_size" : taille du camembert sur le graphique
			- "legend_left" : position gauche des légendes sur le graphique
			- "legend_top" : position gauche des légendes sur le graphique
			- "font_size" : taille de la police texte
		$symbol est le caractères qui accompagne les valeurs
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createHorizontalBarChart($values, $legends, $colors = "", $layout = "", $symbol = "", $title = ""){
	
		if($layout == ""){
			$layout = array(
				"width" => 320,
				"height" => 200,
				"chart_left" => 150,
				"chart_top" => 100,
				"chart_size" => 60,
				"legend_left" => 200,
				"legend_top" =>15,
				"font_size" => 8
			);
		}else{
			if(!isset($layout["width"])){
				$layout["width"] = 320;
			}
			if(!isset($layout["height"])){
				$layout["height"] = 200;
			}
			if(!isset($layout["chart_left"])){
				$layout["chart_left"] = round($layout["width"] / 2);
			}
			if(!isset($layout["chart_top"])){
				$layout["chart_top"] = 100;
			}
			if(!isset($layout["chart_size"])){
				$layout["chart_size"] = 60;
			}
			if(!isset($layout["legend_left"])){
				$layout["legend_left"] = 200;
			}
			if(!isset($layout["legend_top"])){
				$layout["legend_top"] = 15;
			}
			if(!isset($layout["font_size"])){
				$layout['font_size'] = 8;
			}
		}
	
		if($colors == ''){
			$colors = array("0"=>array("R"=>188,"G"=>224,"B"=>46),
							"1"=>array("R"=>224,"G"=>100,"B"=>46),
							"2"=>array("R"=>224,"G"=>214,"B"=>46),
							"3"=>array("R"=>46,"G"=>151,"B"=>224),
							"4"=>array("R"=>176,"G"=>46,"B"=>224),
							"5"=>array("R"=>224,"G"=>46,"B"=>117),
							"6"=>array("R"=>92,"G"=>224,"B"=>46),
							"7"=>array("R"=>224,"G"=>176,"B"=>46));			
		}
	
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", $layout['font_size']);
		$chart->drawTitle(7,24,$title,0,0,0, $layout['width'],$layout['font_size']);
		$height = round($layout["height"] / count($legends)) - 14;
		$width = $layout["width"] - 14;
		
		$pas = round(($width - $layout["chart_left"]) / 10);
		// Trace le fond
		$pc = 0;
		for($i = 0; $i < 11; $i++){
			$chart->drawLine($layout['chart_left'] + ($i * $pas), 24, $layout['chart_left'] + ($i * $pas), $layout['height'] - 24,200,200,200);
			if($symbol == "%"){
				if($i == 0){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 4, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'], "0%" ,0,0,0,0, ALIGN_LEFT,false);
				}
				if($i == 10){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 14, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'],"100%",0,0,0,0, ALIGN_LEFT,false);
				}
			}
			$pc += 10;
		}
		
		
		$y = 7;
		$c = 0;
		for($i = 0; $i < count($legends); $i++){
			$chart->drawTextBox(10, $y, $layout["chart_left"] - 4, $y + $height, $legends[$i], 0, 0, 0, 0, ALIGN_LEFT, false);
			$pc = $values[$i];
			$wpc = (($width - $layout["chart_left"]) / 100) * $pc;
			$chart->drawFilledRectangle($layout["chart_left"] + 2, ($y + ($height / 4)) + 2, $layout["chart_left"] + $wpc + 2, ($y + ($height /4)) + ($height / 2) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], ($y + ($height / 4)), $layout["chart_left"] + $wpc, ($y + ($height /4)) + ($height / 2) , $colors[$c]["R"], $colors[$c]["G"], $colors[$c]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y + ($height / 2), $layout["width"], $y + ($height / 2), $values[$i].$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);
			$c++;
			if($c == count($colors)){
				$c = 0;
			}
			$y += $height;
		}
		return $chart;
	}
	
	/**
		Création d'un graphique en forme de double-barres horizontales
		$values1 est un tableau de valeurs de la source 1
		$values2 est un tableau de valeurs de la source 2
		$legends est un tableau de chaines contenant les étiquettes
		$colors est une chaine contenant le fichiers de couleurs à utiliser (facultatif)
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			- "chart_left" : position gauche du camembert sur le graphique
			- "chart_top" : position haute du camembert sur le graphique
			- "chart_size" : taille du camembert sur le graphique
			- "legend_left" : position gauche des légendes sur le graphique
			- "legend_top" : position gauche des légendes sur le graphique
			- "font_size" : taille de la police texte
		$symbol est le caractères qui accompagne les valeurs
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createDoubleHorizontalBarChart($values1, $values2, $legends, $colors = "", $layout = "", $symbol = "", $title = ""){
	
		if($layout == ""){
			$layout = array(
				"width" => 320,
				"height" => 200,
				"chart_left" => 150,
				"chart_top" => 100,
				"chart_size" => 60,
				"legend_left" => 200,
				"legend_top" =>15,
				"font_size" => 8
			);
		}else{
			if(!isset($layout["width"])){
				$layout["width"] = 320;
			}
			if(!isset($layout["height"])){
				$layout["height"] = 200;
			}
			if(!isset($layout["chart_left"])){
				$layout["chart_left"] = round($layout["width"] / 2);
			}
			if(!isset($layout["chart_top"])){
				$layout["chart_top"] = 100;
			}
			if(!isset($layout["chart_size"])){
				$layout["chart_size"] = 60;
			}
			if(!isset($layout["legend_left"])){
				$layout["legend_left"] = 200;
			}
			if(!isset($layout["legend_top"])){
				$layout["legend_top"] = 15;
			}
			if(!isset($layout["font_size"])){
				$layout['font_size'] = 8;
			}
		}
	
		if($colors == ''){
			$colors = array(
				"0"=>array("R"=>157,"G"=>195,"B"=>230),
				"1"=>array("R"=>255,"G"=>192,"B"=>0)
			);
		}
	
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", $layout['font_size']);
		$chart->drawTitle(7,24,$title,0,0,0, $layout['width'],$layout['font_size']);
		$height = round($layout["height"] / count($legends)) - 14;
		$width = $layout["width"] - 14;
		
		$pas = round(($width - $layout["chart_left"]) / 10);
		// Trace le fond
		$pc = 0;
		for($i = 0; $i < 11; $i++){
			$chart->drawLine($layout['chart_left'] + ($i * $pas), 24, $layout['chart_left'] + ($i * $pas), $layout['height'] - 24,200,200,200);
			if($symbol == "%"){
				if($i == 0){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 4, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'], "0%" ,0,0,0,0, ALIGN_LEFT,false);
				}
				if($i == 10){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 14, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'],"100%",0,0,0,0, ALIGN_LEFT,false);
				}
			}
			$pc += 10;
		}
		
		
		$y = 7;
		for($i = 0; $i < count($legends); $i++){
			$chart->drawTextBox(10, $y, $layout["chart_left"] - 4, $y + $height, $legends[$i], 0, 0, 0, 0, ALIGN_LEFT, false);
			//$pc = round((100 / $max)) * ($values[$i]);
			$pc1 = $values1[$i];
			$pc2 = $values2[$i];
			$wpc1 = (($width - $layout["chart_left"]) / 100) * $pc1;
			$wpc2 = (($width - $layout["chart_left"]) / 100) * $pc2;
			
			// Dessin barre 1
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + 2, $layout["chart_left"] + $wpc1 + 2, $y + ($height / 2) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y, $layout["chart_left"] + $wpc1, $y + ($height / 2) , $colors[0]["R"], $colors[0]["G"], $colors[0]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y, $layout["width"], $y + ($height / 2), $values1[$i].$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);

			// Dessin barre 2
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + ($height / 2) + 2, $layout["chart_left"] + $wpc2 + 2, $y + ($height) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y + ($height / 2), $layout["chart_left"] + $wpc2, $y + $height , $colors[1]["R"], $colors[1]["G"], $colors[1]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y + ($height / 2), $layout["width"], $y + $height, $values2[$i].$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);
			
			$y += $height + 8;
		}
		return $chart;
	}
	/**
		Création d'un graphique en forme de multi barres horizontales
		$values est un tableau de valeurs
		$legends est un tableau de chaines contenant les étiquettes
		$colors est une chaine contenant le fichiers de couleurs à utiliser (facultatif)
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			- "chart_left" : position gauche du camembert sur le graphique
			- "chart_top" : position haute du camembert sur le graphique
			- "chart_size" : taille du camembert sur le graphique
			- "legend_left" : position gauche des légendes sur le graphique
			- "legend_top" : position gauche des légendes sur le graphique
			- "font_size" : taille de la police texte
		$symbol est le caractères qui accompagne les valeurs
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createMultiHorizontalBarChart($values, $legends, $colors = "", $layout = "", $symbol = "", $title = ""){
	
		if($layout == ""){
			$layout = array(
				"width" => 320,
				"height" => 200,
				"chart_left" => 150,
				"chart_top" => 100,
				"chart_size" => 60,
				"legend_left" => 200,
				"legend_top" =>15,
				"font_size" => 8
			);
		}else{
			if(!isset($layout["width"])){
				$layout["width"] = 320;
			}
			if(!isset($layout["height"])){
				$layout["height"] = 200;
			}
			if(!isset($layout["chart_left"])){
				$layout["chart_left"] = round($layout["width"] / 2);
			}
			if(!isset($layout["chart_top"])){
				$layout["chart_top"] = 100;
			}
			if(!isset($layout["chart_size"])){
				$layout["chart_size"] = 60;
			}
			if(!isset($layout["legend_left"])){
				$layout["legend_left"] = 200;
			}
			if(!isset($layout["legend_top"])){
				$layout["legend_top"] = 15;
			}
			if(!isset($layout["font_size"])){
				$layout['font_size'] = 8;
			}
		}
	
		if($colors == ''){
			$colors = array("0"=>array("R"=>188,"G"=>224,"B"=>46),
							"1"=>array("R"=>224,"G"=>100,"B"=>46),
							"2"=>array("R"=>224,"G"=>214,"B"=>46),
							"3"=>array("R"=>46,"G"=>151,"B"=>224),
							"4"=>array("R"=>176,"G"=>46,"B"=>224),
							"5"=>array("R"=>224,"G"=>46,"B"=>117),
							"6"=>array("R"=>92,"G"=>224,"B"=>46),
							"7"=>array("R"=>224,"G"=>176,"B"=>46));			
		}
	
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", $layout['font_size']);
		$chart->drawTitle(7,24,$title,0,0,0, $layout['width'],$layout['font_size']);
		$height = round($layout["height"] / count($legends)) - 14;
		$width = $layout["width"] - 14;
		
		$pas = round(($width - $layout["chart_left"]) / 10);
		
		// Trace le fond
		$pc = 0;
		for($i = 0; $i < 11; $i++){
			$chart->drawLine($layout['chart_left'] + ($i * $pas), 24, $layout['chart_left'] + ($i * $pas), $layout['height'] - 24,200,200,200);
			if($symbol == "%"){
				if($i == 0){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 4, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'], "0%" ,0,0,0,0, ALIGN_LEFT,false);
				}
				if($i == 10){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 14, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'],"100%",0,0,0,0, ALIGN_LEFT,false);
				}
			}
			$pc += 10;
		}
		
		
		$y = 7;
		for($i = 0; $i < count($legends); $i++){
			$c = 0;
			$pc = 0;
			$vmax = 0;
			$vmin = 0;
			$max = 0;
			for ($i2 = 0; $i2 < count($values[$i]); $i2++){

				if($values[$i][$i2] > $values[$i][$vmax]){
					$vmax = $i2;
				}
				
				$pc += $values[$i][$i2];
			}
			
			if($pc > 100){
				$values[$i][$vmax] = $values[$i][$vmax] - ($pc - 100);
			}

			if($pc < 100){
				$values[$i][$vmax] = $values[$i][$vmax] + (100 - $pc);
			}

			$v = $values[$i];
			
			$chart->drawTextBox(10, $y, $layout["chart_left"] - 4, $y + $height, $legends[$i], 0, 0, 0, 0, ALIGN_LEFT, false);
			$x = $layout['chart_left'];
			for($ii = 0; $ii < count($v); $ii++){
				$pc = $v[$ii];
				$wpc = (($width - $layout["chart_left"]) / 100) * $pc;
				$chart->drawFilledRectangle(2 + $x, ($y + ($height / 4)) + 2, $wpc + 2 + $x, ($y + ($height /4)) + ($height / 2) + 2 , 128, 128, 128, true);
				$chart->drawFilledRectangle($x, ($y + ($height / 4)), $wpc + $x, ($y + ($height /4)) + ($height / 2) , $colors[$c]["R"], $colors[$c]["G"], $colors[$c]["B"], true);
				if($pc > 0){
					$chart->drawTextBox(4 + $x, $y + ($height / 2), $layout["width"], $y + ($height / 2), $pc.$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);
				}
				$c++;
				if($c == count($colors)){
					$c = 0;
				}
				$x = $x + $wpc;
			}
			$y += $height;
		}
		return $chart;
	}
	
	/**
		Création d'un graphique en forme de 4 barres horizontales superposées
		$values est un tableau de tableaux de valeurs pour chaque barre
		$legends est un tableau de chaines contenant les étiquettes
		$colors est une chaine contenant le fichiers de couleurs à utiliser (facultatif)
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			- "chart_left" : position gauche du camembert sur le graphique
			- "chart_top" : position haute du camembert sur le graphique
			- "chart_size" : taille du camembert sur le graphique
			- "legend_left" : position gauche des légendes sur le graphique
			- "legend_top" : position gauche des légendes sur le graphique
			- "font_size" : taille de la police texte
		$symbol est le caractères qui accompagne les valeurs
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function create4HorizontalBarChart($values, $legends, $colors = "", $layout = "", $symbol = "", $title = ""){
	
		if($layout == ""){
			$layout = array(
				"width" => 320,
				"height" => 200,
				"chart_left" => 150,
				"chart_top" => 100,
				"chart_size" => 60,
				"legend_left" => 200,
				"legend_top" =>15,
				"font_size" => 8
			);
		}else{
			if(!isset($layout["width"])){
				$layout["width"] = 320;
			}
			if(!isset($layout["height"])){
				$layout["height"] = 200;
			}
			if(!isset($layout["chart_left"])){
				$layout["chart_left"] = round($layout["width"] / 2);
			}
			if(!isset($layout["chart_top"])){
				$layout["chart_top"] = 100;
			}
			if(!isset($layout["chart_size"])){
				$layout["chart_size"] = 60;
			}
			if(!isset($layout["legend_left"])){
				$layout["legend_left"] = 200;
			}
			if(!isset($layout["legend_top"])){
				$layout["legend_top"] = 15;
			}
			if(!isset($layout["font_size"])){
				$layout['font_size'] = 8;
			}
		}
	
		if($colors == ''){
			$colors = array(
				"0"=>array("R"=>188,"G"=>224,"B"=>46),
				"1"=>array("R"=>224,"G"=>100,"B"=>46),
				"2"=>array("R"=>224,"G"=>214,"B"=>46),
				"3"=>array("R"=>46,"G"=>151,"B"=>224)
			);
		}
	
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", $layout['font_size']);
		$chart->drawTitle(7,24,$title,0,0,0, $layout['width'],$layout['font_size']);
		$height = round($layout["height"] / count($legends)) - 14;
		$width = $layout["width"] - 14;
		
		$pas = round(($width - $layout["chart_left"]) / 10);
		// Trace le fond
		$pc = 0;
		for($i = 0; $i < 11; $i++){
			$chart->drawLine($layout['chart_left'] + ($i * $pas), 24, $layout['chart_left'] + ($i * $pas), $layout['height'] - 24,200,200,200);
			if($symbol == "%"){
				if($i == 0){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 4, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'], "0%" ,0,0,0,0, ALIGN_LEFT,false);
				}
				if($i == 10){
					$chart->drawTextBox($layout['chart_left'] + ($i * $pas) - 14, $layout['height'] - 24, $layout['chart_left'] + ($i * $pas) + $pas, $layout['height'],"100%",0,0,0,0, ALIGN_LEFT,false);
				}
			}
			$pc += 10;
		}
		
		
		$y = 7;
		for($i = 0; $i < count($legends); $i++){
			$v = $values[$i];
			$chart->drawTextBox(10, $y, $layout["chart_left"] - 4, $y + $height, $legends[$i], 0, 0, 0, 0, ALIGN_LEFT, false);
			$pc1 = $v[0];
			$pc2 = $v[1];
			$pc3 = $v[3];
			$pc4 = $v[4];
			
			$wpc1 = (($width - $layout["chart_left"]) / 100) * $pc1;
			$wpc2 = (($width - $layout["chart_left"]) / 100) * $pc2;
			$wpc3 = (($width - $layout["chart_left"]) / 100) * $pc3;
			$wpc4 = (($width - $layout["chart_left"]) / 100) * $pc4;
			
			// Dessin barre 1
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + 2, $layout["chart_left"] + $wpc1 + 2, $y + ($height / 4) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y, $layout["chart_left"] + $wpc1, $y + ($height / 4) , $colors[0]["R"], $colors[0]["G"], $colors[0]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y, $layout["width"], $y + ($height / 4), $pc1.$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);

			// Dessin barre 2
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + ($height / 4) + 2, $layout["chart_left"] + $wpc2 + 2, $y + (($height / 4) * 2) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y + ($height / 4), $layout["chart_left"] + $wpc2, $y + (($height / 4) * 2) , $colors[1]["R"], $colors[1]["G"], $colors[1]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y + ($height / 4), $layout["width"], $y + (($height / 4) * 2), $pc2.$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);
			
			// Dessin barre 3
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + (($height / 4) * 2) + 2, $layout["chart_left"] + $wpc3 + 2, $y + (($height / 4) * 3) + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y + (($height / 4) * 2), $layout["chart_left"] + $wpc3, $y + (($height / 4) * 3) , $colors[2]["R"], $colors[2]["G"], $colors[2]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y + (($height / 4) * 2), $layout["width"], $y + (($height / 4) * 3), $pc3.$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);

			// Dessin barre 4
			$chart->drawFilledRectangle($layout["chart_left"] + 2, $y + (($height / 4) * 3) + 2, $layout["chart_left"] + $wpc4 + 2, $y + $height + 2 , 128, 128, 128, true);
			$chart->drawFilledRectangle($layout["chart_left"], $y + (($height / 4) * 3), $layout["chart_left"] + $wpc4, $y + $height , $colors[2]["R"], $colors[2]["G"], $colors[2]["B"], true);
			$chart->drawTextBox($layout["chart_left"] + 4, $y + (($height / 4) * 3), $layout["width"], $y + $height, $pc4.$symbol, 0, 0, 0, 0, ALIGN_LEFT,false);

			$y += $height + 8;
		}
		return $chart;
	}
	/**
		Création d'un graphique en forme de matrice de positionnement
		$matrice est un tableau de tableaux de valeurs
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createMatriceChart($matrice, $layout = ""){
	
		if($layout == ""){
			$layout = array(
				'width' => 800,
				'height' => 600
			);
		}
		
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", 8);
		$hstep = round(($layout['width']) / 9);
		$vstep = round(($layout['height'] - 40) / 9);
		
		$x = 50; $y = $layout['height'] - 60;
		$chart->drawFilledRectangle(35, $y - (4 * $vstep), $x + $layout['width'] - 80, $y - (4 * $vstep) + 1, 184,184,184);
		$chart->drawFilledRectangle($x + (4 * $hstep), $y + 10, ($x + (4 * $hstep)) + 1, 20, 184,184,184);
		for ($i = 0; $i < 9; $i++){
			$chart->drawLine(40, $y - ($i * $vstep), $x + $layout['width'] - 80, $y - ($i * $vstep) + 1, 200,200,200);
			$chart->drawLine($x + ($i * $hstep), $y + 10, ($x + ($i * $hstep)) + 1, 20, 200,200,200);
			$chart->drawTextBox(35, $y - ($i * $vstep), 34, ($y - ($i * $vstep)), $i, 0, 0, 0, 0, ALIGN_LEFT,false);
			$chart->drawTextBox($x + ($i * $hstep) - 4, $y + 10, $x + ($i * $hstep) + 34, $y + 24, $i, 0, 0, 0, 0, ALIGN_LEFT,false);
		}

		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", 10);
		$chart->drawTextBox(25,660,0,0, "Ouverture ecosystème", 90, 64, 64, 64, ALIGN_LEFT,false);
		$chart->drawTextBox(390,$layout['height'] + 460,0,0, "Utilisation du numérique", 0, 64, 64, 64, ALIGN_LEFT,false);

		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", 14);
		$chart->drawTextBox(170,910,0,0, "Utilisateurs modérés", 0, 200, 0, 0, ALIGN_LEFT,false);
		$chart->drawTextBox(590,910,0,0, "Utilisateurs solitaires", 0, 0, 64, 128, ALIGN_LEFT,false);
		$chart->drawTextBox(690,250,0,0, "Utilisateurs catalyseurs ", 0, 0, 128, 64, ALIGN_LEFT,false);
		$chart->drawTextBox(360,60,0,0, "Utilisateurs attentistes ", 0, 0, 128, 128, ALIGN_LEFT,false);
		
		for($i = 0; $i < count($matrice['cercles']); $i++){
			$v = $matrice['cercles'][$i];
			$x = 50 + (($v['usag']) * $hstep);
			$y = (($v['eco']) * $vstep);
			
			$size = 10;
			$red = 255;
			$green = 192;
			$blue = 0;
			
			if($v['size'] == 1){
				$size = 30;
				$red = 123;
				$green = 161;
				$blue = 206;
			}
			
			if($v['size'] == 2){
				$size = 50;
				$red = 190;
				$green = 227;
				$blue = 150;
			}
			
			if($v['type'] == 1){
				$chart->drawFilledCircle($x, (($layout['height'] - 60) - $y) , $size +  2 , $red - 64, $green - 64, $blue - 64);
			}else{
				$chart->drawFilledCircle($x, (($layout['height'] - 60) - $y) , $size +  2 , 255, 0, 0);
			}
			$chart->drawFilledCircle($x, ($layout['height'] - 60) - $y, $size , $red, $green, $blue);
		}
		
		return $chart;
	}
	
	/**
		Création d'un tableau des résulats de la matrice de positionnement
		$matrice est un tableau de tableaux de valeurs
		$layout est un tableau associatif contenant les clefs suivantes :
			- "width" : largeur du graphique
			- "height" : hauteur du graphique
			
		Retourne l'objet pChart ou false si il y a une erreur
	*/
	function createTableauMatriceChart($matrice, $layout = ""){
	
		if($layout == ""){
			$layout = array(
				'width' => 800,
				'height' => 600
			);
		}
		
		$chart = new pChart($layout["width"],$layout["height"]);  
		$chart->drawFilledRoundedRectangle(7, 7, $layout["width"] - 7, $layout["height"] - 7, 5, 240, 240, 240);  
		$chart->drawRoundedRectangle(5, 5,$layout["width"] - 5, $layout["height"] - 5, 5, 128,128,128);  
		
		$chart->setFontProperties("../../inc/pchart/Fonts/tahoma.ttf", 8);
		
		$chart = drawHeaderCell($chart,"Enseignant", 10, 10, 415, 24);
		$chart = drawHeaderCell($chart,"Ouverture ecosystème", 425, 10, 200, 24);		
		$chart = drawHeaderCell($chart,"Utilisation du numérique", 625, 10, 200, 24);		
		$chart = drawHeaderCell($chart,"Titulaire", 825, 10, 50, 24);
		$chart = drawHeaderCell($chart,"Profil", 875, 10, 50, 24);

		for($i = 0; $i < count($matrice['cercles']); $i++){
			$v = $matrice['cercles'][$i];
			$chart = drawCircleCell($chart,$v['legend'], 10, 34 + ($i * 24), 415, 24, $v['size']);
			$chart = drawCell($chart,$v['eco'], 425, 34 + ($i * 24), 200, 24, ALIGN_CENTER);
			$chart = drawCell($chart,$v['usag'], 625, 34 + ($i * 24), 200, 24, ALIGN_CENTER);
			if($v['type'] == 1){
				$chart = drawCell($chart, "OUI", 825, 34 + ($i * 24), 50, 24, ALIGN_CENTER);
			}else{
				$chart = drawCell($chart, "NON", 825, 34 + ($i * 24), 50, 24, ALIGN_CENTER);
			}
			$chart = drawCell($chart,$v['profil'], 875, 34 + ($i * 24), 50, 24, ALIGN_CENTER);
		}
		return $chart;
	}	
	
	function drawHeaderCell($chart, $text, $x, $y, $width, $height){
		$chart->drawFilledRectangle($x, $y, $x + $width, $y + $height, 128, 128, 128);
		$chart->drawFilledRectangle($x + 1, $y + 1, $x + ($width - 2), $y + ($height - 2),200,200,200);
		$chart->drawTextBox($x, $y, $x + $width, $y + $height, $text,0, 0, 0, 0, ALIGN_CENTER,false);
		return $chart;
	}

	function drawCircleCell($chart, $text, $x, $y, $width, $height,$size, $align=ALIGN_LEFT){
		$red = 255;
		$green = 192;
		$blue = 0;
			
		if($size == 1){
			$red = 123;
			$green = 161;
			$blue = 206;
		}
			
		if($size == 2){
			$size = 50;
			$red = 190;
			$green = 227;
			$blue = 150;
		}
		
		$chart->drawFilledRectangle($x, $y, $x + $width, $y + $height, 128, 128, 128);
		$chart->drawFilledRectangle($x + 1, $y + 1, $x + ($width - 2), $y + ($height - 2),255,255,255);
		$chart->drawFilledCircle($x + 16, $y + 12 , 8 , $red, $green, $blue);
		$chart->drawTextBox($x + 32, $y, $x + $width, $y + $height, $text, 0, 0, 0, 0, $align, false);
		return $chart;
	}
	
	function drawCell($chart, $text, $x, $y, $width, $height, $align=ALIGN_LEFT){
		$chart->drawFilledRectangle($x, $y, $x + $width, $y + $height, 128, 128, 128);
		$chart->drawFilledRectangle($x + 1, $y + 1, $x + ($width - 2), $y + ($height - 2),255,255,255);
		$chart->drawTextBox($x, $y, $x + $width, $y + $height, $text, 0, 0, 0, 0, $align, false);
		return $chart;
	}
	
	/**
		Adapte l'image d'un graphique pour l'insertion dans un doc PDF
	*/
	function pdfImageAdapter($image, $percent = 0.75){
		//$percent = 0.75;

		// Calcul des nouvelles dimensions
		list($width, $height) = getimagesize($image);
		$newwidth = $width * $percent;
		$newheight = $height * $percent;

		// Chargement
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefrompng($image);

		// Redimensionnement
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imageantialias($thumb, true);
		
		// Affichage
		imagepng($thumb, $image, 0, PNG_ALL_FILTERS);		
	}	
?>
