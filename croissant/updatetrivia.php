<?php
//*Creado por Dalia Pinto 20/03*//
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['id']) && isset($_POST['question']) && isset($_POST['date']))
{
		$q = new Question($_POST['id']);
		$q->set_question($_POST['question']);
		$q->set_dateOfQuestion($_POST['date']);
		if($q->updateQuestion())
		echo '{ 
				"status" : 0, "message" : "Question updated successfully",
				"id": '.$q->get_id().',
				"question":"'.$q->get_question().'",
				"date":"'.$q->get_dateOfQuestion().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
