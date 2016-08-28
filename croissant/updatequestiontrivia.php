<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['trueanswer']) && isset($_POST['id']))
{
		$q = new Question($_POST['id']);
		$q->set_correctAns($_POST['trueanswer']);
		if($q->UpdateTrivia())
		echo '{ 
				"status" : 0, "message" : "Question updated successfully",
				"id": '.$q->get_id().',
				"question":"'.$q->get_question().'",
				"date":"'.$q->get_dateOfQuestion().'",
				"correctAnswer":"'.$q->get_correctAns().'",
				"statusQuestion":"'.$q->get_status().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
