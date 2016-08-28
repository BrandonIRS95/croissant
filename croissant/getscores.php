<?php
	//alow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/score.php');
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
			$c = new Score($_GET['id']);			
			$json = '{ 
						"status" : 0,
						"id" : '.$c->get_id().',
						"user" : '.$c->get_user()->get_id().',
						"question" : '.$c->get_question()->get_id().',
						"answer" : '.$c->get_answer()->get_id().',
						"date":"'.$c->get_dated().'"
						}';
						
			
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
