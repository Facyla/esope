<?php
	$page = "";
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}
	header("Content-type: text/html;charset=utf-8");
	
	if($page == ""){
		die("<b>404 - Not found</b>");
	}
	
	if(!file_exists("../_html/".$page.".html")){
		die("<b>404 - Not found</b>");
	}else{
		die(file_get_contents("../_html/".$page.".html"));
	}
?>