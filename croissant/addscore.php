<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/score.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['iduser']) && isset($_POST['idanswer']) && isset($_POST['idquestion']))
{
		$s = new Score();
		$u = new User(($_POST['iduser']));
		$a = new Answer($_POST['idanswer']);
		$q = new Question($_POST['idquestion']);
		$s->set_user($u);
		$s->set_question($q);
		$s->set_answer($a);
		if($s->Add())
		echo '{ 
				"status" : 0, "message" : "Score added successfully",
				"id":'.$s->get_id().',
				"date":"'.$s->get_dated().'",
				"question":'.$q->get_id().',
				"answer":'.$a->get_id().',
				"user":'.$u->get_id().'
				
				}';
				
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
