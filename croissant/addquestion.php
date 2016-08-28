<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtquestion']) && isset($_POST['txtiduser']) && isset($_POST['txtidconf']) && isset($_POST['txtstatus']))
{
		$m = new Question();
		$m->set_question($_POST['txtquestion']);
		$us = new User(($_POST['txtiduser']));
		$conf = new Conference($_POST['txtidconf']);
		$m->set_conference($conf);
		$m->set_user($us);
		$m->set_status($_POST['txtstatus']);
		if($m->add())
		echo '{ 
				"status" : 0, "message" : "Question added successfully",
				"id": '.$m->get_id().',
				"question":"'.$m->get_question().'",
				"date":"'.$m->get_dateOfQuestion().'",
				"userId":'.$us->get_id().',
				"user" : "'.$us->get_first_name().' '.$us->get_last_name().'",
				"conferenceId":'.$conf->get_id().',
				"statusQuestion":"'.$m->get_status().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
