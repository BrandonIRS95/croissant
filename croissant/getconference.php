<?php
	//alow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/conference.php');
	require_once('classes/user.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	//get headers
	$headers = getallheaders();

	//validate
	if (isset($_GET['id']))
	{
		//validate token		
		try
		{
			//create object
			$c = new Conference($_GET['id']);			
			$json = '{ "status" : 0,
						"id" : '.$c->get_id().',
						"Place" : "'.$c->get_place().'",
						"Room" : "'.$c->get_room().'",
						"title" : "'.$c->get_title().'",'.'
						"description": " '.$c->get_description().'", 
						"date" : "'.$c->get_date().'", 
						"time" : "'.$c->get_time().'",';
			try
			{
				
				$us = new User($c->get_Speaker());
				$json .='"speaker": {
						"id" : '.$c->get_Speaker().',
						"name" : "'.$us->get_first_name().'",
						"lastname" : "'.$us->get_last_name().'"
						}}';
			}
			catch(Exception $e)
			{
				$json .='"speaker": { }';
			}
			
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
		  echo '{ "status" : 1, "error" : "'.$ex->get_message().'"}';
		}
	}
	else
	{
	  echo '{ "status" : 3, "errorMessage" : "Invalid Parameters" }';
	}
?>
