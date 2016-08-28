<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtquestion']) && isset($_POST['txtiduser']) && isset($_POST['txtanswer']) && isset($_POST['txttime']))
{
		$m = new Question($_POST['txtquestion']);
		$us = new User(($_POST['txtiduser']));
		if($us->addscore($m->get_id(), $_POST['txtanswer'], $_POST['txttime']))
		{
			echo '{ 
					"status" : 0, "message" : "Answer added successfully",
					"questionId" : '.$m->get_id().',
					"question":"'.$m->get_question().'",
					"userId":'.$us->get_id().',
					"user" : "'.$us->get_first_name().' '.$us->get_last_name().'"
					}';
		}
		else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 2, "errorMessage" : "Parameter not found" }';
}


?>