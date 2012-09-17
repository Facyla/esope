<?php
/**
 *	Tasks Plugin
 *	@package Tasks
 *	@author Liran Tal <liran@enginx.com>
 *	@license GNU General Public License (GPL) version 2
 *	@copyright (c) Liran Tal of Enginx 2009
 *	@link http://www.enginx.com
 **/

	global $CONFIG;
	require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

	$object_guid = get_input('object_guid');
	$mode = get_input('mode');
	$myObject = get_entity($object_guid);
	
	$size = strtolower(get_input('size'));
	if (!in_array($size,array('large','medium','small','tiny','master','topbar')))
		$size = "medium";
	
	$success = false;
	$filehandler = new ElggFile();
	$filehandler->owner_guid = $myObject->owner_guid;
	$filehandler->setFilename("microthemes/".$mode."_".$myObject->guid.'_'.$size.'.jpg');
	
	$success = false;
	if ($filehandler->open("read")) {
		if ($contents = $filehandler->read($filehandler->size())) {
			$success = true;
		} 
	}
	
	if (!$success) {
		$contents = @file_get_contents($CONFIG->pluginspath . "tasks/graphics/default{$size}.jpg");
	}
	
	header("Content-type: image/jpeg");
	header('Expires: ' . date('r',time() + 864000));
	header("Pragma: public");
	header("Cache-Control: public");
	header("Content-Length: " . strlen($contents));
	echo $contents;
	
?>
