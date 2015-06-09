<?php
/**
 *        Fonctions utilitaires
 */

 /**
 * Retourne une chaine de type String contenant X carat&egrave;res.<br>$_size est une valeur int correspondant au nombre de caract&egrave;res souhait&eacute; (20 par d&eacute;faut)
 * @param int $size
 * @return String
 */
function getUniqueID($size = 20, $timer = true){
	$c = array(
			'a','b','c','d','e','f','g','h','i','j','k',
			'l','m','n','o','p','q','r','s','t','u','v',
			'w','x','y','z','0','1','2','3','4','5','6',
			'7','8','9'
	);
	
	$id = "";
	if($timer){
		$size = $size - 5;
	}
	for ($i = 0; $i < $size; $i++){
		$id .= strtoupper($c[rand(0,35)]);
	}

	if($timer){
		$_tm = "".microtime(true);
		$_tm = substr($_tm,-5);
		$id = $id.$_tm;
	}
	return $id;
}
	
function addZeroToStringNumber($chaine, $size){
	if(strlen($chaine) == $size){
		return $chaine;
	}
	$ch = "";
	for($i = strlen($chaine); $i < ($size + 1); $i++){
		$ch = $ch ."0";
	}
	
	return $ch.$chaine;
}
	
/**
 * Retourne true si l'adresse email pass&eacute;e par le param&egrave;tre $email est de format correct.
 * @param String $email : adresse email &agrave; tester
 * @return boolean
 */
function validateEmailFormat($email){
	if(!is_String($email) || $email == ''){
		return false;
	}
	
	$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	if(preg_match($Syntaxe,$email)){
		return true;
	}else{
		return false;
	}	
}

/**
 * Ecrit un message dans le fichier trace.log.<br>$message est une chaine String contenant le message &agrave; &eacute;crire.<br>$type est une valeur pouvant etre l'une des valeurs suivantes:<br>- 0 : normal<br>- 1 : Erreur PHP<br>- 2 : Erreur SQL
 * @param String $message
 * @param int $type
 */
function trace($message, $type=0, $file='trace.log'){
	if(TRACER != 'on'){
		return;
	}
	$f = fopen(TRACE_DIR.'/'.$file, 'a+');
	if($type == 0){
		$message = "[SCRIPT : ".date("d-m-Y H:i:s")."]".$message;
	}
	
	if($type == 1){
		$message = "[PHP : ".date("d-m-Y H:i:s")."]".$message;
	}
	
	if($type == 2){
		$message = "[SQL : ".date("d-m-Y H:i:s")."]".$message;
	}
	$message .= "\r\n";
	fwrite($f, $message);
	fclose($f);
}

/**
 * Retourne true si la chaine $value est null ou vide.
 * @param String $value
 * @return boolean
 */
function isEmpty($value){
	return (is_String($value) && ($value == null || strlen($value) == 0));
}

function getHH_MM_SS($_time){
	return gmdate('H:i:s',($_time));
}

/**
	Javascript Obfuscator function
*/
function jsObfuscator($_source){
	global $constantes;
	$js = file_get_contents($_source);
	foreach($constantes as $a => $b){
		$js = str_replace("%".$a."%", call_user_func($b), $js);
	}	
	
	if(OBFUSCATOR == 'on'){
		$packer = new JavaScriptPacker($js, 'Normal', false, false);
		$packed = $packer->pack();
		return $packed;
	}else{
		return $js;
	}
}
?>