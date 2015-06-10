<?php
/**
 * Fonctions d'&eacute;criture de code XML
*/
function openXML($charset='UTF-8'){
	return '<?xml version="1.0" encoding="'.$charset.'"?>';
}

function openTag($name, $attributes=null, $content=null){
	global $charset;
	$xml = '<'.$name.' ';
	if($attributes != null && is_array($attributes)){
		if(count($attributes) > 0){
			foreach($attributes as $key => $value){
				$xml .= $key.'="'.$value.'" ';
			}
		}
	}
	$xml .='>';

	if($content != null){
		$xml .= '<![CDATA['.htmlentities($content, ENT_COMPAT, $charset).']]>';
	}
	return $xml;
}

function closeTag($name){
	return '</'.$name.'>';
}

function addTag($name, $attributes=null, $content=null){
	$xml = openTag($name, $attributes, $content);
	$xml .= closeTag($name);
	return $xml;
}

function errorXML($error_code, $sql=''){

	$xml = openXML();
	$xml .= openTag('server');
	$xml .= addTag('error', null, $error_code);
	$xml .= closeTag('server');
	return $xml;
}

function successXML($action='OK'){
	$xml = openXML();
	$xml .= openTag('server');
	$xml .= addTag('action', null, $action);
	$xml .= closeTag('server');
	return $xml;
}
?>
