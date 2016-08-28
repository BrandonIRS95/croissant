<?php
/*Creado por Dalia Pinto 21/03 */

//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/answer.php');
require_once('classes/user.php');
require_once('classes/catalogs.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

	if(isset($_POST['id']))
	{
			$m = new Question($_POST['id']);
			try
			{
				$json = '{ "status" : 0, "message" : "Question found",
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
				
				echo $json;
			}
			catch(RecordNotFoundException $ex)
			{
			  echo '{ "status" : 1, "error" : "'.$ex->get_message().'"}';
			}
	}		
	else
	{
		echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
	}


?>
