<?php
//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/answer.php');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['id']))
{
		$q = new Question($_POST['id']);
		//$a = new Answer($_POST['id']);
		if($q->deleteAnswers())
		echo '{ "status" : 0, "message" : "Answers deleted successfully"
				}';
				else echo '{ "status" : 1, "errorMessage" : "Answer no deleted" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>