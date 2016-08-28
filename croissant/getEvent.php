<?php
	//alow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/events.php');
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
			$c = new Event($_GET['id']);			
			$json = '{ "status" : 0,
						"id" : '.$c->get_id().',
						"name" : "'.$c->get_name_of_event().'",
						"description" : "'.$c->get_description().'",
						"logo" : "'.$c->get_logo_of_event().'",';
			try
			{
				
				$json .='"theme": {
						"id" : '.$c->get_theme()->get_id().',
						"primary" : "'.$c->get_theme()->get_primary_color().'",
						"primary_dark" : "'.$c->get_theme()->get_primary_dark_color().'",
						"primary_light" : "'.$c->get_theme()->get_primary_light_color().'",
						"ascent" : "'.$c->get_theme()->get_accent_color().'",
						"icons" : "'.$c->get_theme()->get_icons_color().'"
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