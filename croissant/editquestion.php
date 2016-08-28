<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtquestion'])  && isset($_POST['idquestion']))
{
		$m = new Question($_POST['idquestion']);
		$m->set_question($_POST['txtquestion']);
		if($m->Update())
		echo '{ "status" : 0, "message" : "Question edited successfully",
				"id": '.$m->get_id().',
				"question":"'.$m->get_question().'",
				"date":"'.$m->get_dateOfQuestion().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no edited" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>