<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/catalogs.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	require_once('classes/answer.php');
	require_once('classes/conference.php');
	require_once('classes/user.php');
	// get headers
	$headers = getallheaders();
	//validate parameter and headers
	
	// SELECT count(*) FROM questions q join score s on q.Que_id = s.Que_id WHERE q.Que_CorrectAns = s.Ans_id and q.Que_id = 22
	// count of current persons right
	
	// SELECT count(*) FROM questions q join score s on q.Que_id = s.Que_id WHERE q.Que_CorrectAns <> s.Ans_id and q.Que_id = 22
	
	if(isset($_POST['txtidconference']))
	{
		// mode 1 is for the question with the status = W *wait*
		// mode 2 is for the question with the status = A *acepted*
		// mode 3 is for the question with the status = D *declined*
		
		
		$json = '{ "status" : 0, "asks" : [';
		$first = true;
		
		foreach(Catalogs::get_questions($_POST['txtidconference'], 4) as $c)
		{
		    
			$m = new Question($c->get_id());
			if($first) $first=false; else $json .= ',';
			try
			{
				$json.= '{ 
					"id": '.$m->get_id().',
					"question":"'.$m->get_question().'",
					"date":"'.$m->get_dateOfQuestion().'",
					"correctAnswer" : '.$m->get_correctAns().',	
					"totalCorrectPersons" : '.Catalogs::get_count_persons($m->get_id(), 1).',
					"totalWrongPersons" : '.Catalogs::get_count_persons($m->get_id(), 2).',
					"answerOptions": [';
				try
				{
					
		
					$q = new Question($m->get_id());
					$answers= $q->getAnswers();    
					$first2 = true;
					foreach($answers as $a)
					{
						if($first2) $first2=false; else $json .= ',';
						$json .='{ 
								  "idAnswer" : '.$a->get_id().',
								  "answer" : "'.$a->get_answer().'",
								  "dateanswer" : "'.$a->get_date().'" 
								  }';

					} 
					$json .= ']}';
				}
				catch (Exception $e)
				{
					$json .='"answerOptions": [{ }]';
				}
				
			}
			catch(RecordNotFoundException $ex)
			{
			  echo '{ "status" : 1, "error" : "'.$ex->get_message().'"}';
			}
			
			
		}		
		$json .= '] }';		
		echo $json;
	}
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}
	

?>