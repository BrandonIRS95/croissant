<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/answer.php');
require_once('classes/question.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['answer']) )
{
		$a = new Answer();
		$a->set_answer($_POST['answer']);
		$a->set_date($_POST['date']);
		$q = new Question($_POST['idquestion']);
		$a->set_question($q);
		
		if($a->add())
		echo '{ 
				"status" : 0, "message" : "Answer added successfully",
				"id": '.$a->get_id().',
				"answer":"'.$a->get_answer().'",
				"date":"'.$a->get_date().'",
				"questionid":"'.$q->get_id().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "answer no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
