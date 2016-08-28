<?php
/*Creado por Dalia Pinto 21/03 */

//allow access to API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: user, token');
require_once('classes/answer.php');
require_once('classes/question.php');
require_once('classes/user.php');
require_once('classes/generatetoken.php');
$headers = getallheaders();

if(isset($_POST['id']) && isset($_POST['answer']))
{
		$a = new Answer($_POST['id']);
		$a->set_answer($_POST['answer']);
		if($a->Update())
		echo '{ 
				"status" : 0, "message" : "Question updated successfully",
				"id": '.$a->get_id().',
				"answer":"'.$a->get_answer().'"
				}';
				else echo '{ "status" : 1, "errorMessage" : "question no added" }';
				

}
else
{
	echo '{ "status" : 3, "errorMessage" : "Parameter not found" }';
}


?>
