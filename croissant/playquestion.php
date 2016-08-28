<?php
//Creado por Dalia Pinto 26/03


//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/answer.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
require_once('classes/conference.php');
$headers = getallheaders();

if(isset($_POST['idquestion']))
{
		$m = new Question($_POST['idquestion']);
		$m->set_status('p');
		if($m->Update())
		{
			$json= '{ "status" : 0, "message" : "Question send to trivia successfully",
					"id": '.$m->get_id().',
					"question":"'.$m->get_question().'",
					"date":"'.$m->get_dateOfQuestion().'",
					"status2":"'.$m->get_status().'",
					"correctAnswer":'.$m->get_correctAns().',
					"idConference" : '.$m->get_conference()->get_id().',
					"nameConference" : "'.$m->get_conference()->get_title().'",
					"answeroptions": [';

					$answers= $m->getAnswers();    
					$first = true;
					foreach($answers as $a)
					{
						if($first) $first=false; else $json .= ',';
						$json .='{ 
								  "idanswer" : '.$a->get_id().',
								  "answer" : "'.$a->get_answer().'",
								  "dateanswer" : "'.$a->get_date().'" 
								  }';

					} 
			$json .= ']}';
			echo $json;
		}
	
		else { echo '{ "status" : 1, "errorMessage" : "question no declined" }';}
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>