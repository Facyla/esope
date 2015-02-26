<?php
	$page = "";
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	header("Content-type: text/plain;charset=utf-8");
	
	if($page == ""){
		die("<b>404 - Not found</b>");
	}
	
	if(!file_exists("../_html/email/".$page.".txt")){
		die("<b>404 - Not found</b>");
	}else{
		die(utf8_encode(file_get_contents("../_html/email/".$page.".txt")));
	}
?>