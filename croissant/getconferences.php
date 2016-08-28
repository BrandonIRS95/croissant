<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/catalogs.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	require_once('classes/conference.php');
	require_once('classes/user.php');
	// get headers
	$headers = getallheaders();
	//validate parameter and headers
	
	if(isset($_POST['txtnickname']) && isset($_POST['id_event']) )//&& isset($_POST['txtpassword'])
	{
		
		$json = '{ "status" : 0, "conferences" : [';
		$first = true;
		
		foreach(Catalogs::get_conferences($_POST['id_event']) as $c)
		{
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						"id" : '.$c->get_id().',
						"title" : "'.$c->get_title().'",
						"type" : "'.$c->get_type().'",
						"description" : "'.$c->get_description().'",
						"date" : "'.$c->get_date().'",
						"time" : "'.$c->get_time().'",
						"place" : "'.$c->get_place().'",
						"room" : "'.$c->get_room().'",';
				
				$us = new User($c->get_Speaker());
				$json .='"speaker": {
						"id" : '.$c->get_Speaker().',
						"name" : "'.$us->get_first_name().'",
						"lastname" : "'.$us->get_last_name().'"
						}}';
		}		
		$json .= '] }';		
		echo $json;
	}
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}
	

?>




