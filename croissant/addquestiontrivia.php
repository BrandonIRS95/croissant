<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/question.php');
require_once('classes/conference.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['txtquestion'])  && isset($_POST['txtidconf']))
{
		$q = new Question();
		$q->set_question($_POST['txtquestion']);
		$conf = new Conference($_POST['txtidconf']);
		$q->set_conference($conf);
		//$q->set_dateOfQuestion($_POST['txtdate']);
		$q->set_status($_POST['txtstatus']);
        $us = new User(($_POST['txtiduser']));
        $q->set_user($us);
		if($q->AddQuestionTrivia())
		echo '{ 
				"status" : 0, "message" : "Question added successfully",
				"id": '.$q->get_id().',
				"question":"'.$q->get_question().'",
				"date":"'.$q->get_dateOfQuestion().'",
				"correctAnswer":"'.$q->get_correctAns().'",
                "userId":'.$us->get_id().',
				"conferenceId":'.$conf->get_id().',
				"statusQuestion":"'.$q->get_status().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
