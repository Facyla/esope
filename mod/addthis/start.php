<?php

	function addthis_init(){
		elgg_extend_view("css/elgg", "css/addthis/site");
		
		elgg_register_event_handler("pagesetup", "system", "addthis_pagesetup");
	}
	
	function addthis_pagesetup(){
		
		elgg_register_menu_item("extras", array(
			"name" => "addthis",
			"href" => false,
			"text" => elgg_view("addthis/addthis"),
			"priority" => 10000
		));

	}

	// register default elgg events
	elgg_register_event_handler("init", "system", "addthis_init");
