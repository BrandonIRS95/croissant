<?php

/*Create by Dalia 01/04*/

	//alow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/score.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	require_once('classes/user.php');
	require_once('classes/answer.php');
	require_once('classes/catalogs.php');
	//get headers
	$headers = getallheaders();
	
	
	if(isset($_POST['idquestion']) )
	{
		$q = new Question($_POST['idquestion']);
		$json = '{ "status":0,
					"id":'.$q->get_id().',
					"question":"'.$q->get_question().'",
					"scores":[';
		$first = true;
		
		foreach(Catalogs::get_scores_by_question($_POST['idquestion']) as $s)
		{
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						"user":{
								"id":'.$s->get_user()->get_id().',
								"name":"'.$s->get_user()->get_first_name().' '.$s->get_user()->get_last_name().'"
							},
						"answers":{
									"id":'.$s->get_answer()->get_id().',
									"answer":"'.$s->get_answer()->get_answer().'"
						
						},
						
						"date":"'.$s->get_time().'"
						}';
		}		
		$json .= '] }';		
		echo $json;
	}
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}

	
?>
