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
	
	if(isset($_POST['txtidconference']) && isset($_POST['mode']))
	{
		// mode 1 is for the question with the status = W *wait*
		// mode 2 is for the question with the status = A *acepted*
		// mode 3 is for the question with the status = D *declined*
		
		
		$json = '{ "status" : 0, "asks" : [';
		$first = true;
		
		foreach(Catalogs::get_questions($_POST['txtidconference'], ($_POST['mode'])) as $c)
		{
			$esto = "";
			$esto = trim($c->get_question());
		
			
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						
						"id" : '.$c->get_id().',
						"question" : "'.$esto.'",
						"date":"'.$c->get_dateOfQuestion().'",
						"user":"'.$c->get_user()->get_first_name().' '.$c->get_user()->get_last_name().'"}';
		}		
		$json .= '] }';		
		echo $json;
	}
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}
	

?>




