




select Que_Id from questions where Que_CorrectAns != 0 and Con_Id = 1 and Que_Id NOT IN (SELECT a.Que_Id FROM score s, answers a, questions q WHERE s.Ans_Id = a.Ans_Id AND s.Use_Id =15 AND a.Que_Id = q.Que_Id AND q.Con_Id =1)

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
    require_once('classes/question.php');
    require_once('classes/answer.php');
	// get headers
	$headers = getallheaders();
	//validate parameter and headers
	
	if(isset($_POST['txtidconference']) && isset($_POST['iduser']))
	{
		// mode 1 is for the question with the status = W *wait*
		// mode 2 is for the question with the status = A *acepted*
		// mode 3 is for the question with the status = D *declined*
        // mode 4 is for the question with the status = T *TRIVIA*
		// mode 5 is for the question with the status = P *PLAY*
		
		
		$json = '{ "status" : 0, "questions" : [';
		$first = true;
        
		
        
		foreach(Catalogs::get_questions($_POST['txtidconference'], ($_POST['mode'])) as $c)
		{
			$esto = "";
			$esto = trim($c->get_question());
		
			
			if($first) $first=false; else $json .= ',';
				$json .= ' { 
						
						"id" : '.$c->get_id().',
						"question" : "'.$esto.'",
                        "correctanswer" : "'.$c->get_correctAns().'",
						"date":"'.$c->get_dateOfQuestion().'",
						"user":"'.$c->get_user()->get_first_name().' '.$c->get_user()->get_last_name().'",
						"answeroptions": [';
                
                $questions = new Question($c->get_id());
                $answers= $questions->getAnswers();    
                $first2 = true;
                foreach($answers as $a)
                {
                    if($first2) $first2=false; else $json .= ',';
                    $json .='{ "idanswer" : '.$a->get_id().',
						      "answer" : "'.$a->get_answer().'",
                              "dateanswer" : "'.$a->get_date().'" }';
                    
                } 
                $json .= ']}';
		}		
		$json .= '] }';		
		echo $json;
	}
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}
	

?>