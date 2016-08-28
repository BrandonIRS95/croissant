<?php
	//alow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, token');
	//use files
	require_once('classes/scoretoconference.php');
	require_once('classes/exceptions.php');
	require_once('classes/generatetoken.php');
	require_once('classes/user.php');
	require_once('classes/question.php');
	require_once('classes/answer.php');
	require_once('classes/catalogs.php');
	//get headers
	$headers = getallheaders();
	
	
	if(isset($_POST['idconference']) && isset($_POST['idquestion']))//&& isset($_POST['txtpassword'])
	{
		$times = array();
		$c = new Conference($_POST['idconference']);
		$json = '{ "status" : 0,
					"countQuestions" : '.$c->get_count_questions().',
					"ask" : {';
					
					if($_POST['idquestion']!=0){
					
							$m = new Question($_POST['idquestion']);
							
							$json.='"id": '.$m->get_id().',
									"question":"'.$m->get_question().'",
									"date":"'.$m->get_dateOfQuestion().'",
									"correctAnswer" : '.$m->get_correctAns().',
									"totalCorrectPersons" : '.Catalogs::get_count_persons($m->get_id(), 1).',
									"totalWrongPersons" : '.Catalogs::get_count_persons($m->get_id(), 2).',
									"answerOptions": [';
									
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
		
							
							$json .= ']';
					}
					$json .= '}, "scores" : [';
		$first = true;
		
		foreach(Catalogs::get_scores_by_conference($_POST['idconference']) as $s)
		{
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						"user" : {
								"id" : '.$s->get_user()->get_id().',
								"name" : "'.$s->get_user()->get_first_name().' '.$s->get_user()->get_last_name().'"
							},
						"points" : '.(int)$s->get_right_answers().',';
						
						$times = Catalogs::get_time_scores($_POST['idconference'], $s->get_user()->get_id());
						
						$json .= '
									"bestTime" : "'.$times[0].'s'.'",
									"worstTime" : "'.$times[1].'s'.'",
									"averageTime" : "'.$times[2].'s'.'"
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
